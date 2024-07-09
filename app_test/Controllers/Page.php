<?php
namespace App\Controllers;
class Page extends BaseController
{
    public function paymentFailed()
    {
        echo $this->header();
        $sql = "select * from cms  ";
        $data["cms"] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data["settings"] = $this->userModel->customQuery($sql);
        $data["settings"] = $data["settings"][0];
        $data["flashData"] = $this->session->getFlashdata();
        echo view("PaymentFailed", $data);
        echo $this->footer();
    }

    public function paymentSuccessWallet($oid)
    {
        if ($oid = base64_decode($oid)) {
            $sql = "select * from wallet where order_id='$oid'";
            $payment_txn = $this->userModel->customQuery($sql);
            $transaction = $this->walletModel->wallet_transaction_check($payment_txn[0]->ref);
            // var_dump($transaction , $payment_txn);
            if (!is_null($transaction["status"]) && $transaction["status"] == "Paid") {
                $oup["status"] = "Active";
                $oup["transaction_ref"] = $transaction["ref"];
                $odetail = $this->userModel->do_action(
                    "wallet",
                    $oid,
                    "order_id",
                    "update",
                    $oup,
                    ""
                );

                return redirect()->to( base_url() . "/order-success-wallet?ref=" . base64_encode($oid));
            }
        }
        
    }

    public function newsletter()
    {
        // helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $session = session();
            $pdata = $this->request->getVar();

            $validation = \Config\Services::validation();
            $rules = [
                "email" => [
                    "label" => "email", 
                    "rules" => "required|valid_email"
                ]
            ];
            $validation->setRules($rules);

            if(!$validation->run($pdata)){
                $session->setFlashdata(
                    "ns-sub-failure",
                    $validation->getErrors()["email"]
                );
                return redirect()->to(site_url("#ns_sub_bar"));
            }

            // Save Email Address
            $e = $pdata["email"];
            $exist = $this->newsletterModel->subscriber_exist($e);
            if ($exist) {
                $session->setFlashdata(
                    "ns-sub-failure",
                    "You are already registred."
                );
            } else {
                $this->newsletterModel->_subscribe($pdata);
                $session->setFlashdata(
                    "ns-sub-success",
                    "Thank you You are subscribed!"
                );
            }
            return redirect()->to(site_url("#ns_sub_bar"));
        }
    }

    public function selectAddress($aid)
    {
        if ($aid) {
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $pdata["user_id"] = $user_id;
            $status["status"] = "Inactive";
            $res = $this->userModel->do_action(
                "user_address",
                $user_id,
                "user_id",
                "update",
                $status,
                ""
            );
            $status2["status"] = "Active";
            $res = $this->userModel->do_action(
                "user_address",
                $aid,
                "address_id",
                "update",
                $status2,
                ""
            );
            return redirect()->to(site_url("/checkout"));
        }
    }

    public function saveAddress()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = ["name" => ["label" => "name", "rules" => "required"]];
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $pdata = $this->request->getVar();
            $pdata["user_id"] = $user_id;
            if ($pdata["status"] == "Active") {
                $status["status"] = "Inactive";
                $res = $this->userModel->do_action(
                    "user_address",
                    $user_id,
                    "user_id",
                    "update",
                    $status,
                    ""
                );
            }
            $res = $this->userModel->do_action(
                "user_address",
                "",
                "",
                "insert",
                $pdata,
                ""
            );
            $this->session->setFlashdata(
                "success",
                "Address added successfully!"
            );
            return redirect()->to(site_url("/checkout"));
        }
    }

    public function paymentSuccess($oid , $flag = true){

        $session = session();
        @$user_id = $session->get("userLoggedin");
        $res = $this->userModel->customQuery("select count(order_id) as nb from orders where order_id='".base64_decode($oid)."'");
        $payment_id = (isset($_GET["payment_id"])) ? $_GET["payment_id"] : null;
        $bool = (sizeof($res) > 0 && $res[0]->nb == 0) ? $this->orderModel->online_payment_order_process($oid , $user_id , $payment_id) : false ;
        
        if($bool && $flag)
        return redirect()->to(
            base_url() . "/order-success?ref=" . $oid
        );
        
    }

    public function packages()
    {
        echo $this->header();
        $sql = "select * from cms  ";
        $data["cms"] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data["settings"] = $this->userModel->customQuery($sql);
        $data["settings"] = $data["settings"][0];
        $data["flashData"] = $this->session->getFlashdata();
        echo view("Packages", $data);
        echo $this->footer();
    }

    public function accountVerified()
    {
        $session = session();
        @$user_id = $session->get("userLoggedin");
        if (@$user_id) {
            return redirect()->to(base_url() . "/profile");
        } else {
            echo $this->header();
            echo view("accountVerified");
            echo $this->footer();
        }
    }

    public function resetPassword($id)
    {
        echo $this->header();
        echo view("ResetPassword");
        echo $this->footer();
    }

    public function sendEmailTest()
    {
        $to = "reply2jagat@gmail.com";
        $subject = "subject";
        $message = "mg";
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom("info@zamzamdistribution.com", "Test");
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            echo "Email successfully sent";
        } else {
            $data = $email->printDebugger(["headers"]);
            print_r($data);
        }
    }
    
    public function applyCouponCode() {
        $session = session();
        $orderModel = model("App\Models\OrderModel");
        $brandModel = model("App\Models\BrandModel");
        $productModel = model("App\Models\ProductModel");


        $coupon_cart_condition=false;
        $coupon_brand_condition=false;
        $coupon_cat_condition=false;
        $coupon_total_condition=false;

        // @$user_id = $session->get('userLoggedin');
    
        if($session->get('userLoggedin')){
            @$user_id=$session->get('userLoggedin');
        }

        else{
            $r['msg'] = "Please login to user any coupon";
            $r['action'] = "failed";
            print_r(json_encode($r));
            exit;
        }
        
        // $totaart=$orderModel->total_cart($user_id);
        
        
        
        $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
        $this->userModel->customQueryy($sql);
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            // if (true) {


            $cid = $this->request->getVar('coupon_code');
            $cdate = date("Y-m-d");
            $sql = "select * from coupon where coupon_code='$cid'  AND status='Active'  AND '$cdate' between start_date  AND end_date ";
            $res = $this->userModel->customQuery($sql);

            if ($res) {
                // tests on coupon condition
                $coupon_has_brand=$res[0]->on_brand !==null && $res[0]->on_brand >0;
                $coupon_has_category=$res[0]->on_category !==null;

                $total=$orderModel->total_cart($user_id);

                $cart_categories=$orderModel->_getproductcart_bycategory($user_id);
                $cart_brands = $orderModel->_getproductcart_bybrand($user_id);

                if($coupon_has_brand && !$coupon_has_category)
                $tcart=$orderModel->total_cart($user_id,$res[0]->on_brand);

                else if(!$coupon_has_brand && $coupon_has_category)
                $tcart=$orderModel->total_cart($user_id,null,$res[0]->on_category);

                else if($coupon_has_brand && $coupon_has_category){
                    $tcart=$orderModel->total_cart($user_id,$res[0]->on_brand,$res[0]->on_category);
                }

                else
                $tcart=$orderModel->total_cart($user_id);



                $couppon_discount=$orderModel->coupon_discounted_amount($tcart,$cid);

                // if cart amount is greater than the discounted amount
                $coupon_cart_condition = ($tcart > $couppon_discount);


                $coupon_cat_condition = false;
                foreach(explode(",",$res[0]->on_category) as $value){
                    if(in_array($value,$cart_categories)){
                        $coupon_cat_condition=true;
                    }
                }

                $coupon_brand_condition = in_array($res[0]->on_brand,$cart_brands);
                

                // if coupon code has total cart condition
                if($res[0]->min_cart_amount > 0){
                    $coupon_total_condition = ($tcart >= $res[0]->min_cart_amount);
                    $coupon_cart_condition = ($coupon_cart_condition && $coupon_total_condition);
                }

                // if coupon code has brand & categorycondition _getproductcart_bycategory
                if($coupon_has_brand && !$coupon_has_category){
                    $coupon_cart_condition = ($coupon_cart_condition && $coupon_brand_condition);
                }
                else if(!$coupon_has_brand && $coupon_has_category){
                    $coupon_cart_condition = ($coupon_cart_condition && $coupon_cat_condition);
                }
                else if($coupon_has_brand && $coupon_has_category){
                    $coupon_cart_condition = ($coupon_cart_condition && $coupon_brand_condition && $coupon_cat_condition);
                }

                // Check if the Coupon Has been used by the customer
                $coupon_used = $this->orderModel->is_coupon_used($cid , $user_id);
                if($coupon_used){
                    $r['msg'] = "This promo code has already been used!";
                    $r['action'] = "failed";
                    print_r(json_encode($r));
                    exit;
                }
                // var_dump($coupon_brand_condition);
                // var_dump($coupon_cat_condition);
                // var_dump($coupon_cart_condition);
                // die();


            if($coupon_cart_condition){
                if ($res[0]->coupon_type == "specific") {
                    $cust_id == $session->get('userLoggedin');
                    $sql = "select * from coupon_sent where coupon_code='$cid'  AND customer='$user_id' ";
                    $spec = $this->userModel->customQuery($sql);
                    if ($spec) {
                        $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                        // if (@$user_id) {
                        //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                        // } 
                        // else {
                        //     $sid = session_id();
                        //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                        // }
                        $cart = $this->userModel->customQuery($sql);
                        if ($cart) {
                            foreach ($cart as $k => $v) {

                                // $offer_date= $productModel->get_offer_date($v->product_id);
                                // $discount_cond1=$v->discount_percentage > 0 && !$productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]);
                                // $discount_cond2= $v->discount_percentage > 0 && $productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]) && $productModel->is_date_valide_discount($v->product_id);
                                // if ($v->discount_percentage > 0) {
                                if ($productModel->get_discounted_percentage($this->offerModel->offers_list , $v->product_id)["discount_amount"] > 0) {
                                    $r['msg'] = "Coupon can't be used on this cart";
                                    $r['action'] = "failed";
                                    print_r(json_encode($r));
                                    exit;
                                } else {
                                    $updata['coupon_code'] = $cid;
                                    $updata['coupon_type'] = $res[0]->type;
                                    $updata['coupon_value'] = $res[0]->value;
                                    $rest = $this->userModel->do_action('cart', $v->id, 'id', 'update', $updata, '');
                                }
                            }
                        }
                        $cuses['coupon_code'] = $cid;
                        $cuses['customer'] = $user_id;
                        $cuses['uses_count'] = 1;
                        $rest = $this->userModel->do_action('coupon_uses', '', '', 'insert', $cuses, '');
                        $rest = $this->userModel->do_action('coupon_sent', $spec[0]->id, 'id', 'update', ["used" => "Yes"], '');
                        $r['msg'] = "Coupon code applied successfully.";
                        $r['action'] = "success";
                        print_r(json_encode($r));
                        exit;
                    } 
                    else {
                        $r['msg'] = "This coupon code is not valid for you!";
                        $r['action'] = "failed";
                        print_r(json_encode($r));
                        exit;
                    }
                } 
                else if ($res[0]->coupon_type == "generic") {
                    @$user_id = $session->get('userLoggedin');
                    $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";

                    // if (@$user_id) {
                    //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                    // } 
                    // else {
                    //     $sid = session_id();
                    //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                    // }
                    $cart = $this->userModel->customQuery($sql);
                    if ($cart) {
                        foreach ($cart as $k => $v) {

                            // if ($v->discount_percentage > 0) {
                            if ($productModel->get_discounted_percentage($this->offerModel->offers_list , $v->product_id)["discount_amount"] > 0) {

                                $r['msg'] = "Coupon can't be used on this cart";
                                $r['action'] = "failed";
                                print_r(json_encode($r));
                                exit;

                            } else {
                                $updata['coupon_code'] = $cid;
                                $updata['coupon_type'] = $res[0]->type;
                                $updata['coupon_value'] = $res[0]->value;
                                $rest = $this->userModel->do_action('cart', $v->id, 'id', 'update', $updata, '');
                            }
                        }
                    }
                    $cuses['coupon_code'] = $cid;
                    $cuses['customer'] = $user_id;
                    $cuses['uses_count'] = 1;
                    $rest = $this->userModel->do_action('coupon_uses', '', '', 'insert', $cuses, '');
                    $r['msg'] = "Coupon code applied successfully.";
                    $r['action'] = "success";
                    print_r(json_encode($r));
                    exit;
                } 
                else if ($res[0]->coupon_type == "one_time_coupon") {
                    @$user_id = $session->get('userLoggedin');
                    $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                    
                    // if (@$user_id) {
                    //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                    // } else {
                    //     $sid = session_id();
                    //     $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                    // }
                    $cart = $this->userModel->customQuery($sql);
                    if ($cart) {
                        foreach ($cart as $k => $v) {

                            // if ($v->discount_percentage > 0) {
                            if ($productModel->get_discounted_percentage($this->offerModel->offers_list , $v->product_id)["discount_amount"] > 0) {
                                $r['msg'] = "Coupon can't be used on this cart";
                                $r['action'] = "failed";
                                print_r(json_encode($r));
                                exit;
                            } 
                            else {

                                $coupon_has_brand = $res[0]->on_brand > 0 && $res[0]->on_brand !== null;
                                $coupon_has_category = $res[0]->on_category !== null;

                                $_brand_condition= $v->brand == $res[0]->on_brand;
                                $_category_condition= false;
                                foreach(explode(",",$res[0]->on_category) as $value){
                                  if(in_array($value,explode(",",$v->category))){
                                    $_category_condition=true;
                                  }
                                }

                                $apply=false;

                                switch ($coupon_has_brand && $coupon_has_category) {
                                    case 'true':
                                      # code...
                                        if($_brand_condition && $_category_condition){
                                          $apply=true;
                                        }
                                          
                                    break;
                                    
                                    default:
                                      # code...
                                        if($coupon_has_brand){
                                          if($_brand_condition){
                                              $apply=true;
                                          }
                                         
                                        }
    
                                        else if($coupon_has_category){
                                          if($_category_condition){
                                              $apply=true;
                                          }
                                         
                                        }
    
                                        else{
                                          $apply=true;
                                        }
                                    break;
                                }


                                if($apply){
                                    $updata['coupon_code'] = $cid;
                                    $updata['coupon_type'] = $res[0]->type;
                                    $updata['coupon_value'] = $res[0]->value;
                                    $rest = $this->userModel->do_action('cart', $v->id, 'id', 'update', $updata, '');
                                }
                            }
                            
                        }
                    }

                    $cuses['coupon_code'] = $cid;
                    $cuses['customer'] = $user_id;
                    $cuses['uses_count'] = 1;
                    $rest = $this->userModel->do_action('coupon_uses', '', '', 'insert', $cuses, '');
                    $r['msg'] = "Coupon code applied successfully.";
                    $r['action'] = "success";
                    print_r(json_encode($r));
                    exit;
                }
            }
            else{
                $r['msg'] = "This couppon can't be used for this cart";
                $r['action'] = "failed";
                print_r(json_encode($r));
                exit;
            }
            } 
            
            else {
                $r['msg'] = "Invailid coupon code";
                $r['action'] = "failed";
                print_r(json_encode($r));
                exit;
            }
        }
    }

    public function sendEmail()
    {
        $subject = "subject";
        $message = "message";
        $email = \Config\Services::email();
        $email->setTo("reply2jagat@gmail.com");
        $email->setFrom("reply2jagat@gmail.com", "Contact Us");
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            $msg = "Email successfully sent";
        } else {
            $data = $email->printDebugger(["headers"]);
            print_r($data);
            $msg = "Email send failed";
        }
    }

    public function invoice()
    {
        echo view("Invoice");
    }

    public function orderSuccess() {
        helper(["form", "url"]);
        
        if ($this->request->getMethod() == "get") {
            $oid = base64_decode($this->request->getVar("ref"));
            $spin = new Spintowin();
            $sql = "select * from orders where order_id='$oid'";
            $udetail["order"] = $this->userModel->customQuery($sql);
            if($oid == "16679213805")
            $udetail["spin"] = $spin->spin_wheel("16679213805");
            
            // var_dump($udetail);die();
            if ($udetail["order"]) {
                $udetail["products"] = $this->orderModel->_getproducts_ordered($oid);
               
                echo view('Common/Header' , $udetail);
                echo view("PaymentSuccess", $udetail);
                echo $this->footer();

            }
            else{
                echo("<h2>Sorry! This page can't be displayed</h2>");
            }
        }
    }

    public function orderSuccessWallet()
    {
        helper(["form", "url"]);
        if ($this->request->getMethod() == "get") {
            $oid = base64_decode($this->request->getVar("ref"));
            echo $this->header();
            $sql = "select * from wallet where order_id='$oid'";
            $udetail["data"] = $this->userModel->customQuery($sql);
            if ($udetail) {
                echo view("PaymentSuccessWallet", $udetail);
            }
            echo $this->footer();
        }
    }

    public function orderSubmit(){

        if($this->request->getMethod() == "post"){
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $data = $this->request->getVar();
            if(isset($data["payment_method"])){

                if($user_id){
                    // Submited data
    
                    $payment_method = $data["payment_method"];
                    $cart = $this->orderModel->get_user_cart($user_id);
                    
                    // IF CART IS EMPTY EXIT THE PROCESS
                    if(sizeof($cart) == 0)
                    return $this->checkout();

                    // If the user does not have a phone number saved
                    if(isset($data["order_phone"])){
                        $user_phone = $this->userModel->save_user_phone($user_id , $data["order_phone"]);
                        if(!$user_phone)
                        return $this->checkout("Please enter a valid phone number");
                    }

                    // Repeated later calculation in Prepare order details
                    $cart_coupon_discount = $this->orderModel->cart_total_coupon_discount($user_id);
                    $total_cart = $this->orderModel->total_cart($user_id);
                    // $total = $total_cart - $cart_coupon_discount;
                    // Repeated later calculation

                    // Prepare User Address
                    $user_address = (isset($data["street"])) ? $this->userModel->save_user_address($user_id , $data) : $this->userModel->get_user_address($user_id);

                    // CALCULATE THE CHARGES
                    $cart_charges = $this->orderModel->cart_total_charges($user_id , $total_cart , $user_address->city);

                    // prepare order details
                    $order_details = $this->orderModel->prepare_order_details($user_address , $payment_method);
                    // prepare order products
                    $order_products = $this->orderModel->create_order_products($user_id , $cart , $order_details);
                    // var_dump($order_details["offer"]);
                    // die();
                    // If payment method is Tabby, check Operation faisability status
                    if($payment_method == "Tabby payment"){

                        $tabby_data = $this->tabbyModel->structure_data($cart , $order_details, $user_address , $user_id , false);
                        $scoring = $this->tabbyModel->tabby_prescoring(json_encode($tabby_data));
                        // var_dump($scoring);die();
                        // var_dump($tabby_data['payment']['order']['reference_id']);
                        if($scoring->status == "rejected"){
                            switch ($scoring->configuration->products->installments->rejection_reason) {
                                case 'not_available':
                                    # code...
                                    $reason = lg_get_text("lg_354");
                                    break;

                                case 'order_amount_too_high':
                                    # code...
                                    $reason = lg_get_text("lg_355");
                                    break;

                                case 'order_amount_too_low':
                                    # code...
                                    $reason = lg_get_text("lg_356");
                                    break;
                                
                                default:
                                    # code...
                                    $reason = lg_get_text("lg_357");
                                    break;
                            }
                            return $this->checkout($reason);
                        }
                    }
        
                    if(true):
                    // Make the payment 
                    switch ($payment_method) {
        
                        case 'Cash on devlivery':
                            # code...
                            if ($data["wallet_use"] == "Yes" && false) {
        
                                @$user_id = $session->get("userLoggedin");
                                $sql = "select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at desc";
                                $cbal = $this->userModel->customQuery($sql);
        
                                if ($cbal[0]->total) {
                                    if ($cbal[0]->total >= $order_details["order"]["total"]) {
                                        $oud["payment_status"] = "Paid";
                                        $oud["wallet_used_amount"] = $order_details["order"]["total"];
                                        $odetail = $this->userModel->do_action(
                                            "orders",
                                            $order_details["order"]["order_id"],
                                            "order_id",
                                            "update",
                                            $oud,
                                            ""
                                        );
                                        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
                                        $wallet = $this->userModel->customQuery($sql);
                                        if ($wallet) {
                                            $rest_amount = $order_details["order"]["total"];
                                            foreach ($wallet as $wk => $wv) {
        
                                                if ( $wv->available_balance >= $order_details["order"]["total"]) {
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = $wv->available_balance - $order_details["order"]["total"];
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    break;
                                                } else {
                                                    $rest_amount = $rest_amount - $wupdate["available_balance"];
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = 0;
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    if ($rest_amount == 0) {
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    } 
                                    else {
                                        $oud["wallet_used_amount"] = $cbal[0]->total;
                                        $odetail = $this->userModel->do_action(
                                            "orders",
                                            $order_details["order"]["order_id"],
                                            "order_id",
                                            "update",
                                            $oud,
                                            ""
                                        );
                                        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
                                        $wallet = $this->userModel->customQuery($sql);
                                        if ($wallet) {
                                            $rest_amount = $order_details["order"]["total"];
                                            foreach ($wallet as $wk => $wv) {
                                                if ( $wv->available_balance >= $order_details["order"]["total"] ) {
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = $wv->available_balance - $order_details["order"]["total"];
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    break;
                                                } else {
                                                    $rest_amount = $rest_amount - $wupdate["available_balance"];
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = 0;
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    if ($rest_amount == 0) {
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }       

                            // Create the order
                            $this->orderModel->create_order($order_details);

                            // save order products
                            $oo=$this->orderModel->save_order_products($order_products);

                            // save charges
                            $this->orderModel->save_order_charges($user_id , $order_details["order"]["order_id"] ,$cart_charges);
                            
                            // Clear cart
                            $this->orderModel->clear_cart();

                            // Send order Notification to admin
                            $subject = "ZGames | New order from ".$order_details["order"]["name"];
                            $content = view("emails/Admin_order_notification", ["orderdetails" => $order_details["order"] , "products" => $order_products]);
                            // Send Order notification to Admin
                            $admin_email = $this->systemModel->get_website_settings()->email_2;
                            if(!is_null($admin_email) && trim($admin_email) !== "")
                            $this->orderModel->send_email($admin_email , $subject , $content);
                            
                            // decrease ordered prodcut stock
                            $this->orderModel->decrease_products_stock($order_products);

                            //#############   SEND EMAIL START
                            if ($to = $order_details["order"]["email"]) {

                                $subject ="Your order was successfully submitted. Order Id " . $order_details["order"]["order_id"];
                                $content = view("BookingEmail", ["orders" => $order_details , "order_products" => $order_products , "order_charges" => $cart_charges]);
                                
                                // Send Order summery to customer
                                $this->orderModel->send_email($to , $subject , $content);
                            }                            
                            //############# SEND EMIAL END
                            
                            return redirect()->to( site_url("/order-success?ref=" . base64_encode($order_details["order"]["order_id"])) );
                            break;
        
        
                        
                        case 'Online payment':
                            # code...
                            if($data["wallet_use"] == "Yes" && false){
        
                                @$user_id = $session->get("userLoggedin");
                                $sql = "select sum(available_balance) as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at desc";
                                $cbal = $this->userModel->customQuery($sql);
        
                                if ($cbal[0]->total) {
                                    // Pay Full amount with current balance
                                    if ($cbal[0]->total >= $order_details["order"]["total"]) {
                                        $oud["payment_status"] = "Paid";
                                        $oud["wallet_used_amount"] = $order_details["order"]["total"];
                                        $odetail = $this->userModel->do_action(
                                            "orders",
                                            $order_details["order"]["order_id"],
                                            "order_id",
                                            "update",
                                            $oud,
                                            ""
                                        );
                                        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
                                        $wallet = $this->userModel->customQuery($sql);
                                        if ($wallet) {
                                            $rest_amount = $order_details["order"]["total"];
                                            foreach ($wallet as $wk => $wv) {
                                                if ($wv->available_balance >= $order_details["order"]["total"]) {
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = $wv->available_balance - $order_details["order"]["total"];
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    break;
                                                } 
                                                else {
                                                    $rest_amount = $rest_amount - $wupdate["available_balance"];
                                                    $wupdate["status"] = "Used";
                                                    $wupdate["available_balance"] = 0;
                                                    $odetail = $this->userModel->do_action(
                                                        "wallet",
                                                        $wv->id,
                                                        "id",
                                                        "update",
                                                        $wupdate,
                                                        ""
                                                    );
                                                    if ($rest_amount == 0) {
                                                        break;
                                                    }
                                                }
                                            }

                                            //#############   SEND EMAIL START
                                            if ($to = $order_details["order"]["email"]) {
                                                $subject ="Your order was successfully submitted. Order Id " . $order_details["order"]["order_id"];
                                                $message = view("BookingEmail", ["orders" => $order_details["order"] , "order_products" => $order_products , "order_charges" =>  $cart_charges]);
                                                $email = \Config\Services::email();
                                                $email->setTo($to);
                                                $email->setFrom(
                                                    "info@zamzamdistribution.com",
                                                    "Zamzam Games"
                                                );
                                            
                                                $email->setSubject($subject);
                                                $email->setMessage($message);
                                            
                                                if ($email->send()) {
                                                    echo "Email successfully sent";
                                                } 
                                                else {
                                                    $data = $email->printDebugger(["headers",]);
                                                    print_r($data);
                                                }
                                            }
                                            //############# SEND EMIAL END
                                            return redirect()->to(
                                                site_url(
                                                    "/order-success?ref=" .
                                                        base64_encode($order_details["order"]["order_id"])
                                                )
                                            );
                                        }
                                        
                                    } 
                                    // Pay a part of the amount with current balance
                                    else {
                                        $oud["wallet_used_amount"] = $cbal[0]->total;
                                        $odetail = $this->userModel->do_action(
                                            "orders",
                                            $order_details["order"]["order_id"],
                                            "order_id",
                                            "update",
                                            $oud,
                                            ""
                                        );
        
        
                                        // ######## Telr Payment Start #########
                                        $telr = $this->orderModel->telr_pay($order_details["order"]);
                                        if($telr["status"])
                                        return $this->payment_page($telr["url"]);
                                        else{
                                            echo "Failed to create your Order!";
                                            exit();
                                        }
                                        // ######## Telr Payment End #########
        
        
                                    }
                                }
        
                            }
                            else{
        
                                // ######## Telr Payment Start #########
        
                                $telr = $this->orderModel->telr_pay($order_details["order"]);
                                
                                if($telr["status"]) 
                                return $this->payment_page($telr["url"]);
        
                                // ######## Telr Payment Start #########
        
                                else{
                                    echo "Failed to create your Order!";
                                    exit();
                                }
                            }
                            break;

                        case 'Tabby payment':

                            $tabby_data = ($tabby_data) ?? $this->tabbyModel->structure_data($cart , $order_details , $user_address , $user_id , false);
                            $scoring = $this->tabbyModel->tabby_payment_processing(json_encode($tabby_data));
                            // var_dump($scoring->configuration->available_products->installments[0]->web_url);die();
                            if($scoring->status == "created"){
                                return redirect()->to($scoring->configuration->available_products->installments[0]->web_url);
                                // return $this->payment_page($scoring->configuration->available_products->installments[0]->web_url);
                            }
                            break;
                        default:
                            # code...
                            exit;
                            break;
                    }
                    // Make the payment 
                    endif;
        
                }
                else
                $this->checkout("You need to Login or submit your order as a guest");

            }

            else
            $this->checkout("Please select a Valid Payment Method");
            
        }
                
    }

    public function cart($n = null)
    {
        $data = [];
        helper(["form", "url"]);
        $session = session();
        $user_id = ($session->get("userLoggedin")) ? $session->get("userLoggedin") : session_id();
       
        if ($this->request->getMethod() == "get") {
            // Remove product from cart
            if ($rcid = $this->request->getVar("rcid")) {
                $res = $this->userModel->do_action(
                    "cart",
                    $rcid,
                    "id",
                    "delete",
                    "",
                    ""
                );
                if($this->request->getVar("blank") == true)
                return json_encode(["status"=>true , "totalcart"=> $this->productModel->total_cart()]);
            }
            // Remove package from cart
            if ($pcid = $this->request->getVar("pcid")) {
                $session = session();
                
                $uri = service("uri");
                @$user_id = $session->get("userLoggedin");
                if (@$user_id) {
                    $sql = " DELETE FROM `cart` WHERE package='$pcid' AND user_id='$user_id'";
                    $this->userModel->customQueryy($sql);
                } else {
                    $sid = session_id();
                    $sql = " DELETE FROM `cart` WHERE package='$pcid' AND user_id='$sid'";
                    $this->userModel->customQueryy($sql);
                }
            }
            // Update product cart Quantity
            if ($cid = $this->request->getVar("cid")) {
                $cart = $this->productModel->products_in_cart($this->request->getVar("cid"));
                if($this->productModel->is_in_stock($cart[0]->product_id , $this->request->getVar("quantity"))){
                    $updata["quantity"] = $this->request->getVar("quantity");
                    // Here a custome query can be used to update the cart with user ID and product ID instead of the cart ID
                    $res = $this->userModel->do_action(
                        "cart",
                        $cid,
                        "id",
                        "update",
                        $updata,
                        ""
                    );
                }
                else{
                    echo $this->header();
                    echo view("Cart", ["qty_unavailable" => "Quantity selected is not available!"]);
                    echo $this->footer(array("tabby_js" => view("tabby/Tabby_script" , ["price" => $this->orderModel->total_cart($user_id) , "tabby_promo" => true])));
                    die();
                }
            }
        }
        if ($this->request->getMethod() == "post") {
            if ($freebie = $this->request->getVar("freebie")) {
                $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
                $this->userModel->customQueryy($sql);
                foreach ($freebie as $k => $v) {
                    $p["product_id"] = $v;
                    $p["quantity"] = 1;
                    $p["user_id"] = $user_id;
                    $p["discount_percentage"] = 100;
                    $res = $this->userModel->do_action(
                        "cart",
                        "",
                        "",
                        "insert",
                        $p,
                        ""
                    );
                }
            }
        }

        // Get cart valid applicable offer
        $cart = $this->orderModel->get_user_cart($user_id);
        $offers = $this->offerModel->_get_valid_offers($this->offerModel->_get_offers_list(null , $cart) , null , $cart);
        // var_dump($offers);die();
        if(sizeof($offers) > 0){
            $this->userModel->do_action("cart_product_prizes" , $user_id , "user_id" , "delete" , "" , "");
            array_map(function($offer)use(&$data){
                $offer->application =$this->offerModel->_apply_offer($offer);
                $data["offers"][] = $offer;  
            } , $offers);
        }

        if(is_array($n)){
        
            if(array_key_exists("max_order_qty",$n))
                $data["max_qty_order"]=$n["max_order_qty"];
    
            if(array_key_exists("p_restricted",$n))
                $data["product_order_resctricted"]=$n["p_restricted"];

            if(array_key_exists("dc_availability",$n))
                $data["dc_availability"]=$n["dc_availability"];
        }

        echo $this->header();
        echo view("Cart", $data);
        echo $this->footer(array("tabby_js" => view("tabby/Tabby_script" , ["price" => $this->orderModel->total_cart($user_id) , "tabby_promo" => true])));
    }

    public function checkout($msg_er = null)
    {
        $data = [];
        $counter = 0;
        helper(["form", "url"]);
        $productModel = Model("App\Model\ProductModel");

        if ($this->request->getMethod() == "post") {
            if ($p = $this->request->getVar("gift")) {
                $n = $this->request->getVar("note");
                if ($p) {
                    foreach ($p as $k => $v) {
                        $updata["gift_wrapping"] = $v;
                        $updata["gift_wrapping_note"] = $n[$k];
                        $res = $this->userModel->do_action(
                            "cart",
                            $k,
                            "id",
                            "update",
                            $updata,
                            ""
                        );
                    }
                }
            }
            if ($freebie = $this->request->getVar("freebie")) {
                $session = session();
                if ($session->get("userLoggedin")) {
                    @$user_id = $session->get("userLoggedin");
                } else {
                    @$user_id = session_id();
                }
                $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
                $this->userModel->customQueryy($sql);
                foreach ($freebie as $k => $v) {
                    $p["product_id"] = $v;
                    $p["quantity"] = 1;
                    $p["user_id"] = $user_id;
                    $p["discount_percentage"] = 100;
                    $res = $this->userModel->do_action(
                        "cart",
                        "",
                        "",
                        "insert",
                        $p,
                        ""
                    );
                }
            }
        }

        $user_id = session()->get("userLoggedin");
        

        if (session()->get("userLoggedin")) {
            $user_id = session()->get("userLoggedin");
        } else {
            $user_id = session_id();
        }

        $req="
        select cart.product_id,
        cart.quantity,
        products.sku,
        products.type,
        products.ez_price,
        products.max_qty_order,
        products.order_interval 
        from cart 
        inner join products on cart.product_id=products.product_id 
        where cart.user_id='".$user_id."'";

        $res=$this->userModel->customQuery($req);

        $cart_coupon_discount = $this->orderModel->cart_total_coupon_discount($user_id);
        $user_address = $this->userModel->get_user_address($user_id);
        $total_cart = $this->orderModel->total_cart($user_id);
        $total = $total_cart - $cart_coupon_discount;
        $cart_charges = $this->orderModel->cart_total_charges($user_id , $total , $user_address->city);
        
        // Get cart valid applicable offer
        // $cart = $this->orderModel->get_user_cart($user_id);
        // $offers = $this->offerModel->_get_valid_offers($this->offerModel->_get_offers_list() , null , $cart);
        // if(sizeof($offers) > 0){
        //     $offer_discount = ($offers[0]->discount_type == "Percentage") ? $total * $offers[0]->discount_value / 100 : $offers[0]->discount_value;
        //     $total = $total - $offer_discount;  
        //     $offers[0]->application = $this->offerModel->_apply_offer($offers[0]);
        //     $data["offer"] = $offers[0];  
        // }

        // Get cart valid applicable offer
        $cart = $this->orderModel->get_user_cart($user_id);
        $offers = $this->offerModel->_get_valid_offers($this->offerModel->_get_offers_list(null , $cart) , null , $cart);
        if(sizeof($offers) > 0){
            $offer_discount = 0;
            foreach($offers as $offer){
                if($this->offerModel->_apply_offer($offer) == "Discount"){
                    switch ($offer->discount_type) {
                        case 'Amount':
                            # code...
                            $offer_discount += $offer->discount_value;
                            break;
                        
                        default:
                            # code...
                            if($offer_discount == 0)
                            $offer_discount = $total * $offer->discount_value / 100;
                            else
                            break 1;
                            break;
                    }
                }
                $offer->application =$this->offerModel->_apply_offer($offer);
                $data["offers"][] = $offer;  
            }
            $total = $total - $offer_discount;  
        }

        if($res){
            $counter=0;
            $restricted=$p_max_order_qty=$dc_availability=array();
            // check if there is a bundle product in the cart if true check the quantity if it is max 1
                foreach ($res as $key => $value) {
                    # code...
                    // if($value->type == '12' && (int)$value->quantity > 1){
                    //     $counter++;
                    // }

                    // check if the cart has digital codes & check their availability
                    if($value->type == '6' && false){
                        $available = $this->ezpinModel->ezpin_get_catalogs_availabity($value->sku , $value->quantity , $value->ez_price);
                        if(!$available)
                        array_push($dc_availability , $value->product_id);
                    }
        
                    // Check the max order quantity
                    if($value->max_qty_order !== null && $value->max_qty_order > 0){
                        if($value->quantity > $value->max_qty_order)
                        $p_max_order_qty[$value->product_id]=$value->max_qty_order;
                        // $counter++;
                    }
    
                    // check the order period allowed
                    if($value->order_interval !== "Unlimited" && !$value->order_interval == null){
                        $user_email= $this->userModel->get_user_email($user_id);
                        if($user_email)
                        $restricted[$value->product_id]=$productModel->order_restricted($user_email,$value->product_id,$value->order_interval);
                    }
                }
    
          
            
            // Filter the retricted order products
            $restricted = array_filter($restricted , function($v){
                return $v == true;
            });
            // var_dump($p_max_order_qty);die();
            if(sizeof($p_max_order_qty) > 0){
                $this->cart(array("max_order_qty"=>$p_max_order_qty));
            }
            
            else if(sizeof($restricted) > 0){
                // var_dump($restricted);
                $this->cart(array("p_restricted"=>$restricted));
            }
            
            else if(sizeof($dc_availability) > 0){
                // var_dump($p_max_order_qty);die();
                $this->cart(array("dc_availability"=>$dc_availability));
            }
            
            else {
                echo $this->header();
                echo view("Checkout" , array_merge($data , array("msg" => $msg_er)));
                echo $this->footer(array("tabby_js" => view("tabby/Tabby_script" , ["total" => $total+$cart_charges["total_charges"]])));
            }

        }

        else {
            echo $this->header();
            echo view("Checkout" , array_merge($data , array("msg" => $msg_er)));
            echo $this->footer(array("tabby_js" => view("tabby/Tabby_script" , ["total" => $total+$cart_charges["total_charges"]])));
        }

       
    }

    public function productDetail2($id)
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p["product_id"];
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $sql = " select * from product_review where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $this->session->setFlashdata(
                    "error",
                    "You have already reviewed this product."
                );
                return redirect()->to(
                    site_url("product/" . $p["product_id"] . "#review")
                );
            } else {
                $p["user_id"] = $user_id;
                $res = $this->userModel->do_action(
                    "product_review",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                $this->session->setFlashdata(
                    "success",
                    "Thank you for your review. It has been submitted to the admin for approval."
                );
                return redirect()->to(
                    site_url("product/" . $p["product_id"] . "#review")
                );
            }
        }
        $data["flashData"] = $this->session->getFlashdata();
        echo $this->header();
        $sql = "select * from products where product_id='$id';";
        $data["products"] = $this->userModel->customQuery($sql);
        $sql = "select * from product_review where product_id='$id' AND status='Active'";
        $data["review"] = $this->userModel->customQuery($sql);
        $sql = "select avg(rating) as rat from product_review where product_id='$id' AND status='Active'";
        $drat = $this->userModel->customQuery($sql);
        $data["pro_over_rating"] = $drat[0]->rat;
        $sql = "select * from product_image where product='$id';";
        $data["product_image"] = $this->userModel->customQuery($sql);
        $cid = $data["products"][0]->category;
        $sql = "select * from master_category where category_id='$cid';";
        $data["master_category"] = $this->userModel->customQuery($sql);
        $sql = "select * from products inner join   related_products on products.product_id=related_products.related_product where related_products.product_id='$id' AND status='Active'  ";
        $data["sproducts"] = $this->userModel->customQuery($sql);
        if ($data["sproducts"]) {
        } else {
            $sql = "select * from products where category='$cid' AND status='Active' limit 12;";
            $data["sproducts"] = $this->userModel->customQuery($sql);
        }
        $bid = $data["products"][0]->brand;
        $sql = "select * from brand where id=$bid;";
        $data["brands"] = $this->userModel->customQuery($sql);
        $coid = $data["products"][0]->color;
        $sql = "select * from color where id=$coid;";
        $data["color"] = $this->userModel->customQuery($sql);
        $aid = $data["products"][0]->age;
        $sql = "select * from age where id=$aid;";
        $data["age"] = $this->userModel->customQuery($sql);
        $sid = $data["products"][0]->suitable_for;
        $sql = "select * from suitable_for where id=$sid;";
        $data["suitable_for"] = $this->userModel->customQuery($sql);
        echo view("pd", $data);
        echo $this->footer();
    }

    public function addWishtlist()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p["product_id"];
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $sql = " select * from wishlist where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $res = $this->userModel->do_action(
                    "wishlist",
                    $ext[0]->id,
                    "id",
                    "delete",
                    "",
                    ""
                );
                $r["msg"] = "Item successfully removed from your wishlist";
                $r["action"] = "Add to wishlist";
                print_r(json_encode($r));
                exit();
            } else {
                $p["user_id"] = $user_id;
                $res = $this->userModel->do_action(
                    "wishlist",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                $r["msg"] = "Item successfully added to your wishlist";
                $r["action"] = "Add to wishlist";
                print_r(json_encode($r));
                exit();
            }
        }
    }
    
    public function buyNowSubmitForm_original()
    {
        $session = session();
        $productModel = Model("App\Model\ProductModel");
        $data = [];
        $msg = null;
        helper(["form", "url"]);

        if ($this->request->getMethod() == "post") {
            $product_type = $this->productModel->product_nature($this->request->getVar("product_id"));
            $p = $this->request->getVar();

            // checking if the form has been correctly sent
            if ( $productModel->has_options($p["product_id"]) && $p["bundle_opt"] == "" ) {
                $msg = "Please select an option";
            }

            // If product id variation get it ID
            if($product_type == "Variable"){
                if(isset($_POST["product_variation"]) && sizeof($_POST["product_variation"]) > 0){
                    $p_variation = $productModel->get_product_from_variation($_POST["product_variation"] , $this->request->getVar("product_id"));
                    if(!is_null($p_variation) && $p_variation !== ""){
                        $p["product_id"] = $p_variation->product_id ;
                        $p["pre_order_enabled"] = $p_variation->pre_order_enabled ;
                        $p["pre_order_before_payment_percentage"] = $p_variation->pre_order_before_payment_percentage ;
                        $p["assemble_professionally_price"] = $p_variation->assemble_professionally_price ;
                    }
                    else
                    return (json_encode(["errors" => "select a valid product option"]));

                    // var_dump($p_variation);die();
                }
                else{
                    return(json_encode(["errors" => "Please select a product option"]));
                }
            }

            // check if the the quantity selected is less then stock availability 
            if ( $this->request->getVar("quantity") > 0 && $this->request->getVar("quantity") != "" && $msg == "" && $productModel->is_in_stock($p["product_id"] , $this->request->getVar("quantity"))) {
                
                // check if product has discount
                $discount = $productModel->get_discounted_percentage($this->offerModel->offers_list , $p["product_id"]);
                $p["discount_percentage"] = ($discount["discount_type"] == "Percentage") ? $discount["discount_value"] : 0;
                $p["discount_amount"] = ($discount["discount_amount"] > 0) ? $discount["discount_amount"] : 0;

                // Product options
                $options = $productModel->get_product_options(
                    $p["product_id"],
                    $this->request->getVar("bundle_opt")
                );

                // User ID
                $user_id = ($session->get("userLoggedin")) ? @$user_id = $session->get("userLoggedin") : @$user_id = session_id();

                // Check if User has the product in the cart
                $sql = " select * from cart where user_id='$user_id' AND product_id='".$p["product_id"]."'";
                if ($options !== false && sizeof($options) > 0) {
                    $co = 1;
                    foreach($options as $opt){
                        // $sql .= ($co < sizeof($options)) ? " And bundle_opt ='" . $options->id . "' AND" : " bundle_opt ='" . $options->id . "'";
                        $sql .= ($co < sizeof($options)) ? " AND FIND_IN_SET(".$opt->id." , bundle_opt) AND" : " FIND_IN_SET(".$opt->id." , bundle_opt) ";
                        $co++;
                    }
                }

                $ext = $this->userModel->customQuery($sql);
                // If product exist in the cart
                if ($ext) {
                    if(!$productModel->is_in_stock($p["product_id"] , ($ext[0]->quantity + $p["quantity"]))){
                        $msg = "Quantity selected is not in stock";
                        print_r(json_encode(["errors" => $msg]));
                        exit;
                    }

                    $pd["quantity"] = $ext[0]->quantity + $p["quantity"];
                    $pd[
                        "assemble_professionally_price"
                    ] = $this->request->getVar("assemble_professionally_price");

                    $res = $this->userModel->do_action(
                        "cart",
                        $ext[0]->id,
                        "id",
                        "update",
                        $pd,
                        ""
                    );
                }

                // If product deosn't exist in the cart
                else {
                    unset($p["product_name"]);
                    unset($p["product_image"]);
                    unset($p["product_variation"]);
                    $p["user_id"] = $user_id;
                    if ($options !== false && sizeof($options) > 0) {
                        $p["bundle_opt"] = implode("," , $this->request->getVar("bundle_opt"));
                    }

                    $p["discount_rounded"] = ($productModel->is_discount_rounded($p["product_id"])) ? "Yes" : "No";

                    $res = $this->userModel->do_action(
                        "cart",
                        "",
                        "",
                        "insert",
                        $p,
                        ""
                    );
                    // var_dump($p);die();

                }

                // Confirm insertion of the product in the cart
                $sql = " select * from cart where user_id='$user_id'  ";
                $ext = $this->userModel->customQuery($sql);
                if ($ext) {
                    $r["msg"] = "Item successfully added to your cart";
                    $r["action"] = "Add to cart";
                    $r["value"] = count($ext);
                    print_r(json_encode($r));
                    exit();
                }
            } 
            else {
                // array_push($msg["errors"] , "Please define order quantity");

                // redirect to the product page
                // var_dump($msg);
                $msg = "Quantity selected is not in stock";
                print_r(json_encode(["errors" => $msg]));
            }
        }
    }

    public function add_to_cart($product_cart)
    {
        $session = session();
        $productModel = Model("App\Model\ProductModel");
        $flags = [
            "missing_option" => false,
            "invalid_option" => false,
            "missing_variation" => false,
            "out_of_stock" => false,
            "added_to_cart" => false,
            "cart_count" => 0,
        ];
        helper(["form", "url"]);

        $product_type = $this->productModel->product_nature($product_cart["product_id"]);
        $p = $product_cart;

        // checking if the form has been correctly sent
        if ( $productModel->has_options($p["product_id"]) && $p["bundle_opt"] == "" ) {
            $flags["missing_option"] = true;
            return $flags;
        }

        // If product id variation get it ID
        if($product_type == "Variable"){
            if(isset($_POST["product_variation"]) && sizeof($_POST["product_variation"]) > 0){
                $p_variation = $productModel->get_product_from_variation($_POST["product_variation"] , $product_cart["product_id"]);
                if(!is_null($p_variation) && $p_variation !== ""){
                    $p["product_id"] = $p_variation->product_id ;
                    $p["pre_order_enabled"] = $p_variation->pre_order_enabled ;
                    $p["pre_order_before_payment_percentage"] = $p_variation->pre_order_before_payment_percentage ;
                    $p["assemble_professionally_price"] = $p_variation->assemble_professionally_price ;
                }
                else{
                    $flags["invalid_option"] = true;
                    return $flags;
                }

                // var_dump($p_variation);die();
            }
            else{
                $flags["missing_variation"] = true;
                return $flags;
            }
        }

        // check if the the quantity selected is less then stock availability 
        if ( $product_cart["quantity"] > 0 && !empty($product_cart["quantity"]) && $productModel->is_in_stock($p["product_id"] , $product_cart["quantity"])) {
            
            // check if product has discount
            $discount = $productModel->get_discounted_percentage($this->offerModel->offers_list , $p["product_id"]);
            $p["discount_percentage"] = ($discount["discount_type"] == "Percentage") ? $discount["discount_value"] : 0;
            $p["discount_amount"] = ($discount["discount_amount"] > 0) ? $discount["discount_amount"] : 0;

            // Product options
            $options = $productModel->get_product_options(
                $p["product_id"],
                $product_cart["bundle_opt"]
            );

            // User ID
            $user_id = ($session->get("userLoggedin")) ? @$user_id = $session->get("userLoggedin") : @$user_id = session_id();

            // Check if User has the product in the cart
            $sql = " select * from cart where user_id='$user_id' AND product_id='".$p["product_id"]."'";
            if ($options !== false && sizeof($options) > 0) {
                $co = 1;
                foreach($options as $opt){
                    // $sql .= ($co < sizeof($options)) ? " And bundle_opt ='" . $options->id . "' AND" : " bundle_opt ='" . $options->id . "'";
                    $sql .= ($co < sizeof($options)) ? " AND FIND_IN_SET(".$opt->id." , bundle_opt) AND" : " FIND_IN_SET(".$opt->id." , bundle_opt) ";
                    $co++;
                }
            }

            $ext = $this->userModel->customQuery($sql);
            // If product exist in the cart
            if ($ext) {
                if(!$productModel->is_in_stock($p["product_id"] , ($ext[0]->quantity + $p["quantity"]))){
                    $msg = "Quantity selected is not in stock";
                    print_r(json_encode(["errors" => $msg]));
                    exit;
                }

                $pd["quantity"] = $ext[0]->quantity + $p["quantity"];
                $pd[
                    "assemble_professionally_price"
                ] = $product_cart["assemble_professionally_price"];

                $res = $this->userModel->do_action(
                    "cart",
                    $ext[0]->id,
                    "id",
                    "update",
                    $pd,
                    ""
                );
            }

            // If product deosn't exist in the cart
            else {
                unset($p["product_name"]);
                unset($p["product_image"]);
                unset($p["product_variation"]);
                $p["user_id"] = $user_id;
                if ($options !== false && sizeof($options) > 0) {
                    $p["bundle_opt"] = implode("," , $product_cart["bundle_opt"]);
                }

                $p["discount_rounded"] = ($productModel->is_discount_rounded($p["product_id"])) ? "Yes" : "No";

                $res = $this->userModel->do_action(
                    "cart",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                // var_dump($p);die();

            }

            // Confirm insertion of the product in the cart
            $sql = " select * from cart where user_id='$user_id'  ";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $flags["added_to_cart"] = true;
                $flags["cart_count"] = count($ext);
                return $flags;
            }
        } 
        else {
            $flags["out_of_stock"] = true;
            return $flags;
        }

    }

    public function buyNowSubmitForm(){

        if ($this->request->getMethod() == "post"){
            // var_dump($this->request->getVar());die();
            if(is_null($this->request->getVar("is_bundle"))){
                $flags = $this->add_to_cart($this->request->getVar());
                switch (true) {
                    case $flags["missing_option"]:
                        # code...
                        print_r(json_encode(["errors" => "Please select an option"]));
                        break;
    
                    case $flags["invalid_option"]:
                        # code...
                        print_r(json_encode(["errors" => "select a valid product option"]));
                        break;
    
                    case $flags["missing_variation"]:
                        # code...
                        print_r(json_encode(["errors" => "Please select a product option"]));
                        break;
    
                    case $flags["out_of_stock"]:
                        # code...
                        print_r(json_encode(["errors" => "Quantity selected is not in stock"]));
                        break;
    
                    case $flags["added_to_cart"]:
                        # code...
                        print_r(json_encode(["action" => "Add to cart" , "value" => $flags["cart_count"]]));
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            else{
                foreach ($this->request->getVar("bndl_product") as $value) {
                    # code...
                    $flags = $this->add_to_cart(["product_id" => $value , "quantity" => 1]);
                    if(!$flags["added_to_cart"])
                    $status = false;
                }
                if($status)
                print_r(json_encode(["errors" => "Operation failed !"]));
                else
                print_r(json_encode(["action" => "Add to cart" , "value" => $flags["cart_count"]]));
            }
        }

    }

    private function _subcat($c_id)
    {
        $cats = [];

        $sql_sub_cat =
            "select category_id from master_category where parent_id='" .
            $c_id .
            "'";
        $main_sub_cats = $this->userModel->customQuery($sql_sub_cat);
        // return $main_sub_cats;

        if ($main_sub_cats) {
            foreach ($main_sub_cats as $k => $v) {
                array_push($cats, $v->category_id);
            };
        }

        return $cats;

        // var_dump($cats);
    }


    public function getSearchData(){

        if ($this->request->getMethod() == "post"){
            // var_dump($this->request->getVar());die();
            $data = $this->productModel->product_filter_query($this->request->getVar());
            $data["filters"] = $this->request;
            // $data["offers_list"] = $this->offerModel->offers_list;
            $data["offerModel"] = $this->offerModel;
            echo view("SearchProductDatatable", $data);
        }
    }

    public function index()
    {
        echo $this->header();
        echo view("Home");
        echo $this->footer();
    }

    public function productList($cat=null,$brand=null,$offers=null,$preorders=null)
    {
        $uri = service("uri");

        $data = array(
            "data" =>array()
        );

        if($cat !== null && $cat !=="")
        $data["data"]["category"]=$cat;

        if($brand !== null && $brand !== "")
        $data["data"]["brand"]=$brand;

        if($offers !==null && $offers !==""){
            $data["data"]["show-offer"] = "yes";
        }

        if($preorders !==null && $preorders !==""){
            $data["data"]["pre-order"] = "enabled";
            // $data["data"]["type"] = "5";


        }

        if(sizeof($this->request->getVar()) > 0){
            if(isset($_GET["ws-search-category"]) && !isset($_GET["type"]) && array_key_exists($_GET["ws-search-category"] , $this->productModel->type_segments))
            $data["data"]["type"] = implode("," , $this->productModel->type_segments[$_GET["ws-search-category"]]);
            $data["data"]=array_merge($data["data"],$this->request->getVar());
        }

        // var_dump($data);die();
        // var_dump($brand);

        echo $this->header();
        echo view("ProductList",$data);
        echo $this->footer();
    }
    
    public function category()
    {
        echo $this->header();
        $uri = service("uri");
        if (count(@$uri->getSegments()) > 0) {
            $id = @$uri->getSegment(1);
        }
        if (count(@$uri->getSegments()) > 1) {
            $id = @$uri->getSegment(2);
        }
        if (count(@$uri->getSegments()) > 2) {
            $id = @$uri->getSegment(3);
        }
        $sql = "select * from master_category where parent_id='$id';";
        $data["category"] = $this->userModel->customQuery($sql);
        if ($id == "e-mobility-1634548852") {
            echo view("Category-e-mobility", $data);
        } else {
            echo view("Category", $data);
        }
        echo $this->footer();
    }

    public function productDetail($id)
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p["product_id"];
            $session = session();
            @$user_id = $session->get("userLoggedin");
            $sql = " select * from product_review where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $this->session->setFlashdata(
                    "error",
                    "You have already reviewed this product."
                );
                return redirect()->to(
                    site_url("product/" . $p["product_id"] . "#review")
                );
            } else {
                $p["user_id"] = $user_id;
                $res = $this->userModel->do_action(
                    "product_review",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                $this->session->setFlashdata(
                    "success",
                    "Thank you for your review. It has been submitted to the admin for approval."
                );
                return redirect()->to(
                    site_url("product/" . $p["product_id"] . "#review")
                );
            }
        }
        $data["flashData"] = $this->session->getFlashdata();
        echo $this->header();
        $sql = "select * from products where product_id='$id';";
        $data["products"] = $this->userModel->customQuery($sql);
        
        $sql = "select * from product_review where product_id='$id' AND status='Active'";
        $data["review"] = $this->userModel->customQuery($sql);
        
        $sql = "select avg(rating) as rat from product_review where product_id='$id' AND status='Active'";
        $drat = $this->userModel->customQuery($sql);
        $data["pro_over_rating"] = $drat[0]->rat;
        
        $sql = "select * from product_image where product='$id';";
        $data["product_image"] = $this->userModel->customQuery($sql);
        
        $cid = $data["products"][0]->category;
        $sql = "select * from master_category where category_id='$cid';";
        $data["master_category"] = $this->userModel->customQuery($sql);
       
        $sql = "select * from products inner join   related_products on products.product_id=related_products.related_product where related_products.product_id='$id' AND status='Active'  ";
        $data["sproducts"] = $this->userModel->customQuery($sql);
        
        if ($data["sproducts"]) {
        } else {
            $sql = "select * from products where product_nature<>'Variation' AND category='$cid' AND status='Active' limit 12;";
            $data["sproducts"] = $this->userModel->customQuery($sql);
        }
        $bid = $data["products"][0]->brand;
        
        $sql = "select * from brand where id=$bid;";
        $data["brands"] = $this->userModel->customQuery($sql);
        $coid = $data["products"][0]->color;
        
        $sql = "select * from color where id=$coid;";
        $data["color"] = $this->userModel->customQuery($sql);
        $aid = $data["products"][0]->age;
       
        $sql = "select * from age where id=$aid;";
        $data["age"] = $this->userModel->customQuery($sql);
        
        $sid = $data["products"][0]->suitable_for;
        $sql = "select * from suitable_for where id=$sid;";
        $data["suitable_for"] = $this->userModel->customQuery($sql);

        // Valid Cart offers for this Product
        $data["cart_offers"] = $this->offerModel->_get_valid_offers($this->offerModel->offers_list , $id , null , true);
        $sortByProductList= function($a, $b) {
            return sizeof($b->product_list) < sizeof($a->product_list);
        };
        if(sizeof($data["cart_offers"]) > 0)
        array_walk($data["cart_offers"] , function($offer)use(&$sortByProductList){
            return uasort($offer->conditions , $sortByProductList);
        });
        // Valid Cart offers for this Product
        
        echo view("ProductDetail", $data);
        echo $this->footer();
    }

    public function cms($id)
    {
        echo $this->header();
        $sql = "select * from cms where id=$id;";
        $data["cms"] = $this->userModel->customQuery($sql);
        echo view("CMS", $data);
        echo $this->footer();
    }

    public function faq()
    {
        echo $this->header();
        $sql = "select * from faq where status='Active'  ";
        $data["faq"] = $this->userModel->customQuery($sql);
        echo view("Faq", $data);
        echo $this->footer();
    }

    public function contact()
    {
        echo $this->header();
        $sql = "select * from cms  ";
        $data["cms"] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data["settings"] = $this->userModel->customQuery($sql);
        $data["settings"] = $data["settings"][0];
        $data["flashData"] = $this->session->getFlashdata();
        echo view("Contact", $data);
        echo $this->footer();
    }

    public function header()
    {
        // if(!is_null($data))
        return view("Common/Header");
        // else
        // return view("Common/Header" , $data);

    }

    public function footer($data = [])
    {
        return view("Common/Footer" , $data);
    }

    public function ourstores()
    {   
        echo view("Common/Header");
        echo view("stores/Ourstores");
        echo view("Common/Footer");
    }

    public function updateprice(){
        
        $response = ["errors" => [], "response" => ""];

        if ($this->request->getMethod() == "post") {
            $req = "select price,discount_percentage,discount_rounded from products where product_id='" . $this->request->getVar("product_id") . "'";
            $price = $this->userModel->customQuery($req);

            // $additional_price = $this->userModel->customQuery( "select additional_price from bundle_opt where id='" . $this->request->getVar("bundle_opt_id") . "'"
            $additional_price = $this->userModel->customQuery( "select sum(additional_price) as additional_price from bundle_opt where FIND_IN_SET(id , '".implode("," , $this->request->getVar("bundle_opt_id"))."')");

            // var_dump($additional_price);
            
            if($price[0]->discount_percentage == 0 || $price[0]->discount_percentage == null)
            $new_price = $additional_price[0]->additional_price + $price[0]->price;
            
            else 
            $new_price = ($price[0]->discount_rounded == "Yes") ? $additional_price[0]->additional_price + round(bcdiv(($price[0]->price-($price[0]->price*$price[0]->discount_percentage/100)),1,2)) : $additional_price[0]->additional_price + (bcdiv(($price[0]->price-($price[0]->price*$price[0]->discount_percentage/100)),1,2));
            
          

            if ($new_price !== 0) {
                $response["response"] = $new_price;
            } else {
                array_push(
                    $response["errors"],
                    "Something went wrong during the price calculation"
                );
            }
        }

        echo json_encode($response);
    }
    
    public function search_keyword(){
        
        $productModel = model("App\Models\ProductModel");
        $categoryModel = model("App\Models\Category");
        $brandModel = model("App\Models\BrandModel");

        $response = array(
            "status" => 0,
            "result" => null
        );

        $result = array();

        if($this->request->getMethod() == "post"){
            // var_dump($this->request->getVar("keyword"));die();
            $p_result = $productModel->search_product($this->request->getVar("keyword"));
            $c_result = $categoryModel->search_product($this->request->getVar("keyword"));
            $b_result = $brandModel->search_brand($this->request->getVar("keyword"));
            
            // $result = $productModel->search_product("fifa");
            // echo view("Common/Header");
            // echo view("Searchkeyword",array("products"=>$result));
            // echo view("Common/Footer");
            // exit;
            if($c_result)
                $result["categories"] = $c_result;

            if($p_result)
                $result["products"] = $p_result;
                
            if($b_result)
                $result["brands"] = $b_result;

            $result["offers_list"] = $this->offerModel->offers_list;

            if(sizeof($result) > 0){

                $response["result"] = view("Searchkeyword", $result);
                $response["status"] = 1;
                

            }
        }
        // var_dump(json_encode($response));
        switch (get_cookie("language")) {
            case 'AR':
                # code...
                // var_dump($response);
                echo(json_encode($response , JSON_UNESCAPED_UNICODE));
                break;
            
            default:
                # code...
                echo(json_encode($response));
                break;
        }
        
        
    }
    
    public function payment_page($url=null){
        echo view("Common/Header");
        echo view("PaymentPage" , array("url" => $url));
        echo view("Common/Footer");
    }
    
    public function update_preorders(){
        $timezone = new \DateTimeZone(TIME_ZONE);
        $now = new \DateTime("now" , $timezone);
        $req = "update products set pre_order_enabled='No' where pre_order_enabled ='Yes' and release_date <= :r_date:";
    
        $res = $this->userModel->db->query($req , ["r_date" => $now->format("Y-m-d")]);
    }
    
    public function getcart(){
        $productModel = model("App\Model\ProductModel");
        $orderModel = model("App\Model\OrderModel");
        $session = session();

        $user_id = ($session->get("userLoggedin")) ? $session->get("userLoggedin") : session_id();

        $html = "";
        if($productModel->total_cart() > 0){
            // $cart = $productModel->products_in_cart();
            $cart = $orderModel->get_user_cart($user_id);
            $total_amount = $orderModel->total_cart($user_id);
            if(sizeof($cart) > 0){   
                $html .='
                <div class="col-12 pb-3">
                    <h4 class="text-center ws-cart-title"> '. sizeof($cart).' '.lg_get_text("lg_332").'</h4>
                </div>
                ';

                $html .='<div class="col-12 row m-0 p-0">';
                foreach($cart as $product){
                    $title = (strlen($product->name) > 50) ? substr($product->name,0,50)."..." : $product->name;
                    $html .= '
                        <div class="products_list_gg row col-12 mb-2 m-0 p-0 py-2" data-id="'.$product->id.'">
                            <div class="card_thumbnailk col-4 p-0 text-center">
                                <img src="'.base_url().'/assets/uploads/'.$product->image.'" id="cart-img">
                            </div>
                            <div class="col-4 p-0 justify-content-center align-items-center row m-0">
                                <p id="cart-heading" class="m-0 px-2">'.$title.'</p>
                            </div>
                            <div class="col-2 p-0 text-center justify-content-center align-items-center row m-0">
                                <p class="m-0 cart-qty">'.$product->quantity.'</p>
                            </div>

                            <div class="col-2 p-0 text-center justify-content-center align-items-center row m-0">
                                <div class="remove_prdct">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17.5 20" width="24" height="24">
                                        <path d="M9.5,17.63a.63.63,0,0,1-1.25,0V9.5a.63.63,0,0,1,1.25,0Zm3.13,0a.63.63,0,0,1-1.25,0V9.5a.63.63,0,0,1,1.25,0Zm3.13,0a.63.63,0,0,1-1.25,0V9.5a.63.63,0,0,1,1.25,0ZM15.65,3l1.43,2.15h2.73a.94.94,0,0,1,0,1.88H19.5V18.88A3.12,3.12,0,0,1,16.38,22H7.63A3.12,3.12,0,0,1,4.5,18.88V7H4.19a.94.94,0,0,1,0-1.87H6.91L8.35,3a2.19,2.19,0,0,1,1.82-1h3.66a2.19,2.19,0,0,1,1.82,1ZM9.17,5.13h5.66L14.09,4a.31.31,0,0,0-.26-.14H10.17c-.1,0-.23.05-.26.14ZM6.38,18.88a1.25,1.25,0,0,0,1.25,1.25h8.75a1.25,1.25,0,0,0,1.25-1.25V7H6.38Z" transform="translate(-3.25 -2)" style="fill:#a2a2a2"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    ';
                }
                $html .='</div>';

                $html .= '
                    <div class="col-12 row m-0 mt-3 justify-content-center ws-cart-total" '.content_from_right(false).'>
                        <div class="col-9 row m-0 justify-content-between">
                            <span><b>'.lg_get_text("lg_198").':</b></span>
                            <span class="ws-cart-total-amount">
                                <span>'.$total_amount.'</span> '.lg_get_text("lg_102").'
                            </span>
                        </div>
                    </div> 
                ';
            }
        }   
        else
            $html.='
            <div class="row justify-content-center align-items-center col-12 m-0" dir="ltr">
                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" viewBox="0 0 859.98 802"><title>basket</title><path d="M879.6,539.46H329l10.74,50.46H869l-15.64,74.53c-10.44,49.75-54.89,85.44-106.44,85.44H374.26l8.6,40.92c1.37-.08,2.75-.12,4.14-.12a75.17,75.17,0,0,1,72.64,55.83H673a75.15,75.15,0,1,1,0,38.65H459.65A75.16,75.16,0,1,1,345.9,802.93L214.57,177.65H129.34a19.33,19.33,0,0,1,0-38.65H245.94l28,133.27H707.25a163.66,163.66,0,0,0-19,130.84H299l10.74,50.46H712.36a163.52,163.52,0,0,0,171.81,64.1ZM753.25,442.84c-1.33-1.47-2.64-3-3.91-4.52C750.61,439.85,751.91,441.37,753.25,442.84Zm-3.91-163c1.27-1.54,2.58-3,3.91-4.52C751.91,276.82,750.61,278.34,749.35,279.87Zm0,158.45c1.27,1.54,2.57,3,3.91,4.52C751.92,441.37,750.61,439.85,749.35,438.32ZM962.43,316.27c-1.4-3.81-3-7.55-4.72-11.18A125.29,125.29,0,0,0,947,287q-1.74-2.43-3.59-4.79c-.62-.78-1.25-1.56-1.88-2.33-1.27-1.54-2.58-3-3.91-4.52-.68-.74-1.35-1.47-2-2.19s-1.39-1.44-2.09-2.14a124.54,124.54,0,0,0-176.12,0l-1.22,1.25-.87.89c-.69.72-1.36,1.45-2,2.19-1.33,1.47-2.64,3-3.91,4.52-.64.77-1.27,1.55-1.88,2.33q-1.85,2.35-3.59,4.79a125.29,125.29,0,0,0-10.69,18.1c-1.75,3.63-3.33,7.37-4.72,11.18a125,125,0,0,0,.45,86.85q1.92,5.11,4.27,10a125.29,125.29,0,0,0,10.69,18.1q1.74,2.43,3.59,4.79c.62.78,1.25,1.56,1.88,2.33,1.27,1.54,2.58,3,3.91,4.52.68.74,1.35,1.47,2,2.19s1.39,1.43,2.09,2.14c2.12,2.1,4.29,4.14,6.56,6.11l.34.3h0a124.69,124.69,0,0,0,129,20.53h0a124.77,124.77,0,0,0,40.18-26.94c.71-.7,1.41-1.42,2.09-2.14s1.36-1.45,2-2.19c1.33-1.47,2.64-3,3.91-4.52.63-.77,1.26-1.55,1.88-2.33q1.85-2.35,3.59-4.79a125.29,125.29,0,0,0,10.69-18.1c1.75-3.63,3.33-7.37,4.72-11.18a125.11,125.11,0,0,0,0-85.65ZM753.25,442.84c-1.33-1.47-2.64-3-3.91-4.52C750.61,439.85,751.91,441.37,753.25,442.84Zm0-167.49c-1.34,1.47-2.64,3-3.91,4.52C750.61,278.34,751.92,276.82,753.25,275.35Zm188.29,163c-1.27,1.54-2.58,3-3.91,4.52C939,441.37,940.28,439.85,941.55,438.32Zm-3.91-163c1.33,1.47,2.64,3,3.91,4.52C940.28,278.34,939,276.82,937.64,275.35ZM753.25,442.84c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm0,167.49c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm188.29,163c-1.27,1.54-2.57,3-3.91,4.52C939,441.37,940.28,439.85,941.55,438.32Zm0-158.45c-1.27-1.54-2.58-3-3.91-4.52C939,276.82,940.28,278.34,941.55,279.87Zm-188.29-4.52c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Zm0,167.49c-1.34-1.47-2.64-3-3.91-4.52C750.61,439.85,751.92,441.37,753.25,442.84Zm0-167.49c-1.33,1.47-2.64,3-3.91,4.52C750.61,278.34,751.91,276.82,753.25,275.35Z" transform="translate(-110.01 -139)" style="fill:#22398d82"/><text style="transform:translate(685px,266px); font-size:144px;fill:#ffffff;font-family:TTInterphases-Bold, TT Interphases;font-weight:700">0</text></svg>
                <h5 style="font-size:1.3rem; color: #353535ab" class="'.text_from_right(true).' col-12 text-center">'. lg_get_text("lg_196").'</h5>
            </div>
            ';
        // echo($html);

        return json_encode(["cart" => $html]);
    }

    public function update_new_products(){
        $date = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        var_dump($date);die();
        $req = "update products set precedence=1001 where new_from";
        $res = $this->userModel->customQuery($req);
        var_dump($res);
    }

    public function update_invalid_products(){
        $invalid_products = $this->productModel->invalid_active_product_list();
        if(sizeof($invalid_products) > 0){
            foreach($invalid_products as $product){
                $this->userModel->do_action("products" , $product->product_id , "product_id" , "update" , ["status" => "Inactive"] , "");
            }
        }

    }
    public function update_valid_products(){
        $valid_products = $this->productModel->valid_inactive_product_list();
        if(sizeof($valid_products) > 0){
            foreach($valid_products as $product){
                $this->userModel->do_action("products" , $product->product_id , "product_id" , "update" , ["status" => "Active"] , "");
            }
        }

    }

    public function change_language($language){
        $lang = array( "EN" , "AR" );
        $feedback = array("status" => 0 , "message" => "");
        if(in_array($language , $lang)){
            set_cookie("language" , $language , 300);
            $feedback["status"] = 1;
    
            switch ($language) {
                case 'EN':
                    # code...
                $feedback["message"] = "Language updated successfully to English";
    
                break;
                
                default:
                    # code...
                $feedback["message"] = "Language updated successfully to Arabic";
    
                break;
            }
        }
        else 
        $feedback["message"] = "Language not recognized";
    
        return json_encode($feedback);
    }

    public function permission_denied(){
        echo view('errors/html/permission_denied');
    }
    
    
}
