<?php
namespace App\Controllers;
class Profile extends BaseController
{
    public function refundWallet() {
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 2)
        {
            $uri1 = @$uri->getSegment(3);
            //
            $sql = "select * from  orders where order_id='$uri1'";
            $ord = $this
                ->userModel
                ->customQuery($sql);
            if ($ord)
            {
                //   PG START
                $params = array(
                    'ivp_store' => STOREID,
                    'ivp_authkey' => AUTHKEYREMOTE,
                    'ivp_trantype' => 'refund',
                    'ivp_tranclass' => 'ecom',
                    'ivp_desc' => 'Payment for order id : ' . $ord[0]->order_id,
                    'ivp_cart' => $ord[0]->order_id,
                    'ivp_currency' => CURRENCY,
                    'ivp_amount' => $ord[0]->total,
                    'tran_ref' => $ord[0]->transaction_ref,
                    'ivp_test' => PGTEST
                );
                //  print_r($params);exit;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/remote.html");
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Expect:'
                ));
                $results = curl_exec($ch);
                curl_close($ch);
                parse_str($results);
                echo $auth_message . "<br>";
                echo $auth_tranref;
                if ($auth_message == "Accepted" && $auth_tranref != "")
                {
                    $pu['status'] = 'Refunded';
                    $pu['cancel_trans_ref'] = $auth_tranref;
                    $pu['status'] = 'Refunded';
                    //
                    $this
                        ->userModel
                        ->do_action('wallet', $uri1, 'order_id', 'update', $pu, '');
                    $this
                        ->session
                        ->setFlashdata('success', 'wallet updated successfully!');
                }
                // END PG END
                
            }
            else
            {
                $sql = "select * from  wallet where order_id='$uri1'";
                $ord = $this
                    ->userModel
                    ->customQuery($sql);
                if ($ord)
                {
                    //   PG START
                    $params = array(
                        'ivp_store' => STOREID,
                        'ivp_authkey' => AUTHKEYREMOTE,
                        'ivp_trantype' => 'refund',
                        'ivp_tranclass' => 'ecom',
                        'ivp_desc' => 'Payment for order id : ' . $ord[0]->order_id,
                        'ivp_cart' => $ord[0]->order_id,
                        'ivp_currency' => CURRENCY,
                        'ivp_amount' => $ord[0]->total,
                        'tran_ref' => $ord[0]->transaction_ref,
                        'ivp_test' => PGTEST
                    );
                    //  print_r($params);exit;
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/remote.html");
                    curl_setopt($ch, CURLOPT_POST, count($params));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Expect:'
                    ));
                    $results = curl_exec($ch);
                    curl_close($ch);
                    parse_str($results);
                    echo $auth_message . "<br>";
                    echo $auth_tranref;
                    if ($auth_message == "Accepted" && $auth_tranref != "")
                    {
                        $pu['status'] = 'Refunded';
                        $pu['cancel_trans_ref'] = $auth_tranref;
                        $pu['status'] = 'Refunded';
                        //
                        $this
                            ->userModel
                            ->do_action('wallet', $uri1, 'order_id', 'update', $pu, '');
                        $this
                            ->session
                            ->setFlashdata('success', 'wallet updated successfully!');
                    }
                    // END PG END
                    
                }
            }
        }
        return redirect()
            ->to(site_url('profile/Wallet'));
    }

    public function AddMoney(){
      if($this->request->getMethod() == "post"){

        // ------------- Validate the submited form-------------
          $validation = \Config\Services::validation();
          // $rules = ["amount" => ["label" => "amount", "rules" => "required"]];
          $rules = array(
            "amount" => [
              "rules" => "required|decimal",
              "errors" => [
                  "required" => "The amount field is required",
                  "decimal" => "Please enter a valid amount"
              ]
            ],
          );
          $validation->setRules($rules);
          $form_validation = $this->validate($rules);
        // ------------- Validate the submited form-------------

        if ($this->validate($rules)){
            $amount = $this->request->getVar('amount');
            $session = session();
            @$user_id = $session->get('userLoggedin');

            if($user_id){
              // Get the user informations
                $user_infos = $this->userModel->get_user($user_id);
                $name = explode(" " , $user_infos->name);
                $city = $this->orderModel->get_city_name($user_infos->city);
                $order_id = time() . rand(0, 99);
              // Get the user informations

              $params = [
                'ivp_method' => 'create',
                'ivp_tranclass' => 'ecom',
                'ivp_store' => STOREID,
                'ivp_authkey' => AUTHKEY,
                'ivp_amount' => $amount,
                'ivp_currency' => CURRENCY,
                'ivp_test' => PGTEST,
                'ivp_cart' => $order_id,
                'ivp_desc' => 'Payment for order id : ' . $order_id,
                'bill_title' => '',
                'bill_fname' => $name[0],
                'bill_sname' => $name[1],
                'bill_addr1' => $user_infos->address,
                'bill_addr2' => '',
                'bill_addr3' => '',
                'bill_city' => $city->title,
                'bill_region' => '',
                'bill_country' => 'ae',
                'bill_zip' => '',
                'bill_email' => $user_infos->email,
                'bill_phone' => $user_infos->country_code.$user_infos->phone,
                'return_auth' => base_url() . '/payment-success-wallet/' . base64_encode($order_id) ,
                'return_can' => base_url() . '/payment-failed',
                'return_decl' => base_url() . '/payment-failed',
              ];
              // make the Telr payment request
              $payment_request = $this->walletModel->telr_payment($params);

              if($payment_request["status"] && !is_null($payment_request["url"])){
                // Prepared the wallet line transaction to be inserted
                $ins['available_balance'] = $amount;
                $ins['total'] = $amount;
                $ins['user_id'] = $user_id;
                $ins['status'] = 'Inactive';
                $ins['order_id'] = $order_id;
                $ins['type'] = 'credited_from_card';
                $ins['ref'] = $payment_request["ref"];
                $res = $this->userModel->do_action('wallet', '', '', 'insert', $ins, '');

                return redirect()->to($payment_request["url"]);
              }

              else 
              $this->wallet(["errors" => ["Operation failed, please try again"]]);
            }

        }
        else{
          // var_dump($validation->getErrors());
          $this->wallet(["errors" =>  $validation->getErrors() , "data" => $form]);
        }

      }
    }

    public function Wallet($data = []) {
        echo $this->header();
        echo view('Wallet' , $data);
        echo $this->footer();
    }

    public function myOrders($data = []) {
        echo $this->header();
        echo view('Myorders' , $data);
        echo $this->footer();
    }

    public function cancelOrder__() {
        $uri = service("uri");
        $orderModel = model("App\Models\OrderModel");
        $productModel = model("App\Models\ProductModel");

        if (count(@$uri->getSegments()) > 2)
        {
            $uri1 = @$uri->getSegment(3);
            $pu["order_status"] = "Canceled";
            //
            $sql = "select * from  orders where order_id='$uri1'";
            $ord = $this->userModel->customQuery($sql);

            $products_ordered = $orderModel->_getproducts_ordered($uri1);
            if ($products_ordered)
            {
                foreach ($products_ordered as $value)
                {
                    $q = ((int)$value->available_stock + (int)$value->quantity);
                    $res = $productModel->increment_stock($value->product_id, $q);
                    // var_dump($res);die();
                    
                }
            }
            // var_dump($ord[0]);die();
            if ($ord[0]->payment_status == "Paid")
            {
                $winsert["user_id"] = $ord[0]->user_id;
                $winsert["order_id"] = $ord[0]->order_id;
                $winsert["total"] = $ord[0]->total;
                $winsert["available_balance"] = $ord[0]->total;
                $winsert["type"] = "credited_from_order_cancel";
                $res = $this
                    ->userModel
                    ->do_action("wallet", "", "", "insert", $winsert, "");
                $pu["payment_status"] = "Refunded";
            }
            elseif ($ord[0]->payment_status == "Not Paid" && $ord[0]->wallet_use == "Yes" && $ord[0]->wallet_used_amount < $ord[0]->total)
            {
                $winsert["user_id"] = $ord[0]->user_id;
                $winsert["order_id"] = $ord[0]->order_id;
                $winsert["total"] = $ord[0]->wallet_used_amount;
                $winsert["available_balance"] = $ord[0]->wallet_used_amount;
                $winsert["type"] = "credited_from_order_cancel";
                $res = $this
                    ->userModel
                    ->do_action("wallet", "", "", "insert", $winsert, "");
                $pu["payment_status"] = "Refunded";
            }
            //
            $res = $this->userModel->do_action("orders", $uri1, "order_id", "update", $pu, "");

            $this->session->setFlashdata("success", "Order updated successfully!");
            return redirect()->to(site_url("profile/myOrders"));
        }
    }

    public function cancelOrder($order_id) {
        $session = session();
        $user_id = $session->get("userLoggedin");

        $order_details = $this->orderModel->get_order_details($order_id , $user_id);
        $order_products = $this->orderModel->get_order_products($order_id);
        $order_charges = $this->orderModel->order_total_charges($order_id);

        $timezone= new \DateTimeZone(TIME_ZONE);
        $date = new \DateTime("now" , $timezone);
        $cancel_period = ((new \DateTime($order_details["created_at"] , $timezone))->diff($date , true)->d == 0);

        $can_cancel = ($cancel_period && $order_details["payment_status"] == "Not Paid" && $order_details["order_status"] =="Submited") ? true : false;
        if($can_cancel){
          $res = $this->userModel->do_action("orders",$order_details["order_id"],"order_id","update",["order_status"=>"Canceled"],"");
          if($res){
            $this->orderModel->increase_products_stock($order_products);
            
            $this->session->setFlashdata("success", "Order updated successfully!");
            return redirect()->to(site_url("profile/myOrders"));

          } 
        }
        else{
          $this->myorders(["errors"=>["Sorry! the order cannot be canceled."]]);
        }
    }

    public function cancelOrderOLD() {
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 2)
        {
            $uri1 = @$uri->getSegment(3);
            $sql = "select * from orders where order_id='$uri1'  ";
            $res = $this
                ->userModel
                ->customQuery($sql);
            if ($res[0]->payment_status == "Paid" && $res[0]->payment_method == "Online payment" && $res[0]->order_status == "Submited")
            {
                $params = array(
                    'ivp_store' => STOREID,
                    'ivp_authkey' => AUTHKEYREMOTE,
                    'ivp_trantype' => 'refund',
                    'ivp_tranclass' => 'ecom',
                    'ivp_desc' => 'Payment for order id : ' . $res[0]->order_id,
                    'ivp_cart' => $res[0]->order_id,
                    'ivp_currency' => CURRENCY,
                    'ivp_amount' => $res[0]->total,
                    'tran_ref' => $res[0]->transaction_ref,
                    'ivp_test' => PGTEST
                );
                /* echo "<pre>";
                 print_r($params);*/
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/remote.html");
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Expect:'
                ));
                $results = curl_exec($ch);
                curl_close($ch);
                parse_str($results);
                echo $auth_message . "<br>";
                echo $auth_tranref;
                /*$pddd['capture_auth_message']=$auth_message;
                $pddd['capture_auth_tranref']=$auth_tranref;
                $pddd['capture_amount']=$dd[0]->total_price;*/
                if ($auth_message == "Accepted" && $auth_tranref != "")
                {
                    $pu['payment_status'] = 'Refunded';
                    $pu['cancel_trans_ref'] = $auth_tranref;
                }
            }
            $pu['order_status'] = 'Canceled';
            $res = $this
                ->userModel
                ->do_action('orders', $uri1, 'order_id', 'update', $pu, '');
            $this
                ->session
                ->setFlashdata('success', 'Order updated successfully!');
            return redirect()
                ->to(site_url('profile/myOrders'));
        }
    }

    public function deleteKids() {
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 2)
        {
            $uri1 = @$uri->getSegment(3);
            $res = $this
                ->userModel
                ->do_action('kids', $uri1, 'kids_id', 'delete', '', '');
            $this
                ->session
                ->setFlashdata('success', 'kids deleted successfully!');
            return redirect()
                ->to(site_url('profile/myKids'));
        }
    }

    public function deleteAddress() {
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 2)
        {
            $uri1 = @$uri->getSegment(3);
            $res = $this
                ->userModel
                ->do_action('user_address', $uri1, 'address_id', 'delete', '', '');
            $this
                ->session
                ->setFlashdata('success', 'Address deleted successfully!');
            return redirect()
                ->to(site_url('profile/address'));
        }
    }

    public function editAddress() {
        helper(['form', 'url']);
        $data = [];
        $session = session();
        @$user_id = $session->get('userLoggedin');


        if ($this->request->getMethod() == "post")
        {
            $validation = \Config\Services::validation();
            $rules = [
                "address_id" => [
                    "label" => "address_id",
                    "rules" => "required"
                ],

                "name" => [
                    "label" => "name", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "street" => [
                    "label" => "street", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "apartment_house" => [
                    "label" => "apartment_house", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "city" => [
                    "label" => "city", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "address" => [
                    "label" => "address", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],
            ];

            if ($this->validate($rules)){
                $address_id = $this->request->getVar('address_id');
                $pdata = $this->request->getVar();

                if ($pdata['status'] == 'Active'){
                    $status['status'] = 'Inactive';
                    $res = $this->userModel->do_action('user_address', $user_id, 'user_id', 'update', $status, '');
                }

                $res = $this->userModel->do_action('user_address', $address_id, 'address_id', 'update', $pdata, '');
                $this->session->setFlashdata('success', 'Address updated successfully!');
                return redirect()->to(site_url('profile/address'));
            }
            else
            $data = $validation->getErrors();
        }

        echo $this->header();
        echo view('EditAddress' , $data);
        echo $this->footer();
    }

    public function addAddress() {
        helper(['form', 'url']);

        $data = [];
        $session = session();
        @$user_id = $session->get('userLoggedin');
        
        
        if ($this->request->getMethod() == "post"){
            $validation = \Config\Services::validation();
            $rules = [
                "name" => [
                    "label" => "name", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "street" => [
                    "label" => "street", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "apartment_house" => [
                    "label" => "apartment_house", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "city" => [
                    "label" => "city", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],

                "address" => [
                    "label" => "address", 
                    "rules" => "required",
                    "errors" =>[
                        "required" => "is required"
                    ]
                ],
            ];
            $validation->setRules($rules);

            $pdata = $this->request->getVar();

            $boolean = $validation->run($pdata);
            if(!$boolean){
                // Send the error Meassage to the form page and load it
                $data = $validation->getErrors();
                
            }
            else{

                $pdata['user_id'] = $user_id;
                if ($pdata['status'] == 'Active'){
    
                    $status['status'] = 'Inactive';
                    $res = $this->userModel->do_action('user_address', $user_id, 'user_id', 'update', $status, '');
    
                }
                $res = $this->userModel->do_action('user_address', '', '', 'insert', $pdata, '');
                $this->session->setFlashdata('success', 'Address added successfully!');
                return redirect()->to(site_url('profile/address'));
                
            }
        }

        

        echo $this->header();
        echo view('EditAddress' , $data);
        echo $this->footer();
    }

    public function address() {
        $data = [];
        helper(['form', 'url']);
        if ($this
            ->request
            ->getMethod() == "post")
        {
            $validation = \Config\Services::validation();
            $rules = ["id" => ["label" => "id", "rules" => "required"]];
            if ($this->validate($rules))
            {
                $p = $this
                    ->request
                    ->getVar('id');
            }
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $res = $this
                ->userModel
                ->do_action('wishlist', $p, 'id', 'delete', $p, '');
            $this
                ->session
                ->setFlashdata('success', 'Item removed from wishlist!');
            return redirect()
                ->to(site_url('profile/wishlist'));
        }
        $data['flashData'] = $this
            ->session
            ->getFlashdata();
        echo $this->header();
        echo view('MyAddress', $data);
        echo $this->footer();
    }

    public function wishlist() {
        $data = [];
        helper(['form', 'url']);
        if ($this
            ->request
            ->getMethod() == "post")
        {
            $validation = \Config\Services::validation();
            $rules = ["id" => ["label" => "id", "rules" => "required"]];
            if ($this->validate($rules))
            {
                $p = $this
                    ->request
                    ->getVar('id');
            }
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $res = $this
                ->userModel
                ->do_action('wishlist', $p, 'id', 'delete', $p, '');
            $this
                ->session
                ->setFlashdata('success', 'Item removed from wishlist!');
            return redirect()
                ->to(site_url('profile/wishlist'));
        }
        echo $this->header();
        echo view('Wishlist');
        echo $this->footer();
    }

    public function changePassword() {
        $data = [];
        helper(['form', 'url']);
        if ($this ->request ->getMethod() == "post")
        {
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $has_password = $this->userModel->user_has_password($user_id);

            $validation = \Config\Services::validation();
            $rules = [
                "new_password" => [
                    "label" => "new password", 
                    "rules" => "required"
                ],
                "confirm_password" => [
                    "label" => "confirm password", 
                    "rules" => "required|matches[new_password]"
                ]
            ];

            if($has_password){
                $rules["old_password"] = [
                    "label" => "old password",
                    "rules" => "required"
                ];
            }
            if ($this->validate($rules)){
                
                $pass = base64_encode($this->request->getVar('old_password'));
                $sql = "select * from users where user_id='$user_id' AND status='Active'";
                $sql .= ($has_password) ? "AND password ='$pass'" : "";

                $res = $this->userModel->customQuery($sql);
                if ($res){
                    $p = $this->request->getVar();
                    $pd['password'] = base64_encode($p['new_password']);
                    $res = $this->userModel->do_action('users', $user_id, 'user_id', 'update', $pd, '');
                    $this->session->setFlashdata('success', 'Password changed successfully!');
                    return redirect()->to(site_url('profile/changePassword'));
                }
                else{
                    $this->session->setFlashdata('error', 'Old password is wrong!');
                }
            }
            else
            {
                $ht = "";
                foreach ($validation->getErrors() as $v){
                    $ht = $ht . " " . $v . "<br>";
                }
                $this->session->setFlashdata('error', $ht);
            }
        }
        $data['flashData'] = $this->session->getFlashdata();
        echo $this->header();
        echo view('ChangePassword', $data);
        echo $this->footer();
    }

    public function index() {
        $session = session();
        if (@$user_id = $session->get('userLoggedin'))
        {
            $data = [];
            helper(['form', 'url']);
            if ($this->request->getMethod() == "post")
            {
                $validation = \Config\Services::validation();
                $rules = [
                    "name" =>  ["label" => "name", "rules" => "required"],
                    "phone" => ["label" => "phone", "rules" => "required"]
                ];
                if ($this->validate($rules)) {
                    $p = $this ->request ->getVar();
                    $input = $this->validate(['file' => ['uploaded[file]', 'mime_in[file,image/jpg,image/jpeg,image/png]', ]]);
                    if ($input) {
                        if ($this ->request ->getFile('file')){
                            $img = $this->request->getFile('file');
                            $img->move(ROOTPATH . '/assets/uploads/');
                            $p['image'] = $img->getName();
                        }
                    }
                }
                unset($p['email']);
                $res = $this->userModel->do_action('users', $user_id, 'user_id', 'update', $p, '');
                $this->session->setFlashdata('success', 'Profile updated successfully!');
                return redirect()->to(site_url('profile'));
            }
            echo $this->header();
            echo view('Profile');
            echo $this->footer();
        }
        else
        {
            return redirect()->to(site_url());
        }
    }

    public function productDetail($id) {
        echo $this->header();
        $sql = "select * from products where product_id='$id';";
        $data['products'] = $this
            ->userModel
            ->customQuery($sql);
        $sql = "select * from product_image where product='$id';";
        $data['product_image'] = $this
            ->userModel
            ->customQuery($sql);
        $cid = $data['products'][0]->category;
        $sql = "select * from master_category where category_id='$cid';";
        $data['master_category'] = $this
            ->userModel
            ->customQuery($sql);
        $sql = "select * from products where category='$cid' AND status='Active' limit 12;";
        $data['sproducts'] = $this
            ->userModel
            ->customQuery($sql);
        $bid = $data['products'][0]->brand;
        $sql = "select * from brand where id=$bid;";
        $data['brands'] = $this
            ->userModel
            ->customQuery($sql);
        $coid = $data['products'][0]->color;
        $sql = "select * from color where id=$coid;";
        $data['color'] = $this
            ->userModel
            ->customQuery($sql);
        $aid = $data['products'][0]->age;
        $sql = "select * from age where id=$aid;";
        $data['age'] = $this
            ->userModel
            ->customQuery($sql);
        $sid = $data['products'][0]->suitable_for;
        $sql = "select * from suitable_for where id=$sid;";
        $data['suitable_for'] = $this
            ->userModel
            ->customQuery($sql);
        echo view('ProductDetail', $data);
        echo $this->footer();
    }

    public function cms($id) {
        echo $this->header();
        $sql = "select * from cms where id=$id;";
        $data['cms'] = $this
            ->userModel
            ->customQuery($sql);
        echo view('CMS', $data);
        echo $this->footer();
    }

    public function contact() {
        echo $this->header();
        echo view('contact');
        echo $this->footer();
    }

    public function blog() {
        echo $this->header();
        echo view('blog');
        echo $this->footer();
    }

    public function header() {
        return view('Common/Header');
    }

    public function footer() {
        return view('Common/Footer');
    }
    
    public function changeaddress($flag){
        echo view("forms/Change_address" , ["flag" => $flag]);
    }

    public function act_addrss($addrss_id){
        
        $response = ["status"=> false];
        
        $user_id = (session())->get("userLoggedin");
        $has_address = $this->userModel->user_has_address($addrss_id);

        if(strtoupper($this->request->getMethod()) == "POST" && $has_address){
            
            $req = "update user_address set status = 'Active' where address_id='".$addrss_id."' and user_id ='".$user_id."'";
            $req2 = "update user_address set status = 'Inactive' where user_id ='".$user_id."'";

            $res1 = $this->userModel->customQuery($req2);
            if($res1){
                $res = $this->userModel->customQuery($req);
                if($res)
                $response["status"] = true;
            }
        }

        return json_encode($response);
    }

    public function mycodes($data = []){
        echo $this->header();
        echo view('Mycodes' , $data);
        echo $this->footer();
    }
}

