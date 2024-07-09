<?php
namespace App\Controllers;
class Page extends BaseController {
    public function paymentFailed() {
        echo $this->header();
        $sql = "select * from cms  ";
        $data['cms'] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data['settings'] = $this->userModel->customQuery($sql);
        $data['settings'] = $data['settings'][0];
        $data['flashData'] = $this->session->getFlashdata();
        echo view('PaymentFailed', $data);
        echo $this->footer();
    }
    public function paymentSuccessWallet($oid) {
        if ($oid = base64_decode($oid)) {
            $sql = "select * from wallet where order_id='$oid'  ";
            $payment_txn = $this->userModel->customQuery($sql);
            $params = array('ivp_method' => 'check', 'ivp_store' => STOREID, 'ivp_authkey' => AUTHKEY, 'order_ref' => $payment_txn[0]->ref, 'ivp_test' => PGTEST);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            if (curl_exec($ch) === false) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                $results = curl_exec($ch);
                $results = json_decode($results, true);
            }
            curl_close($ch);
            if ($results) {
                if (@$results['order']['status']['text'] == "Paid") {
                    $oup['status'] = "Active";
                    $oup['transaction_ref'] = @$results['order']['transaction']['ref'];
                    $odetail = $this->userModel->do_action('wallet', $oid, 'order_id', 'update', $oup, '');
                    return redirect()->to(base_url() . '/order-success-wallet?ref=' . base64_encode($oid));
                }
            }
        }
    }
    public function newsletter() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = ["email" => ["label" => "email", "rules" => "required"]];
            $pdata = $this->request->getVar();
            if ($e = $pdata['email']) {
                $sql = "select * from newsletter where email='$e'  ";
                $res = $this->userModel->customQuery($sql);
                if ($res) {
                    $this->session->setFlashdata('success', 'You are already subscribed to our newsletter.');
                } else {
                    $res = $this->userModel->do_action('newsletter', '', '', 'insert', $pdata, '');
                    $this->session->setFlashdata('success', 'You have successfully subscribed to the Newsletter.');
                }
                return redirect()->to(site_url('#newsletter'));
            }
        }
    }
    public function selectAddress($aid) {
        if ($aid) {
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $pdata['user_id'] = $user_id;
            $status['status'] = 'Inactive';
            $res = $this->userModel->do_action('user_address', $user_id, 'user_id', 'update', $status, '');
            $status2['status'] = 'Active';
            $res = $this->userModel->do_action('user_address', $aid, 'address_id', 'update', $status2, '');
            return redirect()->to(site_url('/checkout'));
        }
    }
    public function saveAddress() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = ["name" => ["label" => "name", "rules" => "required"]];
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $pdata = $this->request->getVar();
            $pdata['user_id'] = $user_id;
            if ($pdata['status'] == 'Active') {
                $status['status'] = 'Inactive';
                $res = $this->userModel->do_action('user_address', $user_id, 'user_id', 'update', $status, '');
            }
            $res = $this->userModel->do_action('user_address', '', '', 'insert', $pdata, '');
            $this->session->setFlashdata('success', 'Address added successfully!');
            return redirect()->to(site_url('/checkout'));
        }
    }
    public function paymentSuccess($oid) {
        if ($oid = base64_decode($oid)) {
            $sql = "select * from payment_txn where order_id='$oid'  ";
            $payment_txn = $this->userModel->customQuery($sql);
            $sql = "select * from orders where order_id='$oid'  ";
            $orders = $this->userModel->customQuery($sql);
            $sql = "select * from order_products where order_id='$oid'  ";
            $cartt = $this->userModel->customQuery($sql);
            $params = array('ivp_method' => 'check', 'ivp_store' => STOREID, 'ivp_authkey' => AUTHKEY, 'order_ref' => $payment_txn[0]->ref, 'ivp_test' => PGTEST);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
            if (curl_exec($ch) === false) {
                echo 'Curl error: ' . curl_error($ch);
            } else {
                $results = curl_exec($ch);
                $results = json_decode($results, true);
            }
            curl_close($ch);
            if ($results) {
                $pd['amount'] = @$results['order']['amount'];
                $pd['currency'] = @$results['order']['currency'];
                $pd['description'] = @$results['order']['description'];
                $pd['status'] = @$results['order']['status']['text'];
                $pd['transaction_ref'] = @$results['order']['transaction']['ref'];
                $pd['transaction_type'] = @$results['order']['transaction']['type'];
                $pd['transaction_class'] = @$results['order']['transaction']['class'];
                $pd['transaction_status'] = @$results['order']['transaction']['status'];
                $pd['transaction_code'] = @$results['order']['transaction']['code'];
                $pd['transaction_message'] = @$results['order']['transaction']['message'];
                $pd['paymethod'] = @$results['order']['paymethod'];
                $pd['email'] = @$results['order']['customer']['email'];
                $pd['name'] = @$results['order']['customer']['name']['forenames'];
                $pd['line1'] = @$results['order']['customer']['address']['line1'];
                $pd['line2'] = @$results['order']['customer']['address']['line2'];
                $pd['city'] = @$results['order']['customer']['address']['city'];
                $pd['state'] = @$results['order']['customer']['address']['state'];
                $pd['country'] = @$results['order']['customer']['address']['country'];
                $pd['areacode'] = @$results['order']['customer']['address']['areacode'];
                $pd['mobile'] = @$results['order']['customer']['address']['mobile'];
                if (@$results['order']['status']['text'] == "Paid") {
                    $oup['payment_status'] = "Paid";
                    $oup['transaction_ref'] = @$results['order']['transaction']['ref'];
                    $odetail = $this->userModel->do_action('orders', $oid, 'order_id', 'update', $oup, '');
                    $d = $this->userModel->do_action('payment_txn', $oid, 'order_id', 'update', $pd, '');
                    //  wallet deduction start
                    if ($orders[0]->wallet_use == "Yes") {
                        $user_id = $orders[0]->user_id;
                        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
                        $wallet = $this->userModel->customQuery($sql);
                        if ($wallet) {
                            $rest_amount = $orders[0]->total;
                            foreach ($wallet as $wk => $wv) {
                                if ($wv->available_balance >= $orders[0]->total) {
                                    $wupdate['status'] = 'Used';
                                    $wupdate['available_balance'] = $wv->available_balance - $orders[0]->total;
                                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                                    break;
                                } else {
                                    $rest_amount = $rest_amount - $wupdate['available_balance'];
                                    $wupdate['status'] = 'Used';
                                    $wupdate['available_balance'] = 0;
                                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                                    if ($rest_amount == 0) {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    //  wallet deduction END
                    //#############   SEND EMAIL STRT
                    $sql = "select * from orders where order_id='$oid'  ";
                    $odrr = $this->userModel->customQuery($sql);
                    if ($to = $odrr[0]->email) {
                        $eoid = $odrr[0]->order_id;
                        $sql = " select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products 
     inner join products on order_products.product_id=products.product_id
     where order_products.order_id='$eoid'  ";
                        $edata['order_products'] = $this->userModel->customQuery($sql);
                        $od = $odrr;
                        if ($od[0]->coupon_code == "") unset($od[0]->coupon_code);
                        if ($od[0]->coupon_discount == "") unset($od[0]->coupon_discount);
                        unset($od[0]->products);
                        unset($od[0]->coupon_type);
                        unset($od[0]->coupon_value);
                        unset($od[0]->invoice);
                        unset($od[0]->updated_at);
                        $edata['orders'] = $od[0];
                        $sql = " select * from order_charges where order_id='$eoid'  ";
                        $edata['order_charges'] = $this->userModel->customQuery($sql);
                        $subject = 'Your order was successfully submitted. Order Id ' . $idata['order_id'];
                        $message = view('BookingEmail', $edata);
                        $email = \Config\Services::email();
                        $email->setTo($to);
                        $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        if ($email->send()) {
                            //   echo 'Email successfully sent';
                            
                        } else {
                            /* $data = $email->printDebugger(['headers']);
                             print_r($data);*/
                        }
                    }
                    //############# SEND EMIAL END
                    return redirect()->to(base_url() . '/order-success?ref=' . base64_encode($oid));
                }
            }
        }
    }
    public function packages() {
        echo $this->header();
        $sql = "select * from cms  ";
        $data['cms'] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data['settings'] = $this->userModel->customQuery($sql);
        $data['settings'] = $data['settings'][0];
        $data['flashData'] = $this->session->getFlashdata();
        echo view('Packages', $data);
        echo $this->footer();
    }
    public function accountVerified() {
        $session = session();
        @$user_id = $session->get('userLoggedin');
        if (@$user_id) {
            return redirect()->to(base_url() . '/profile');
        } else {
            echo $this->header();
            echo view('accountVerified');
            echo $this->footer();
        }
    }
    public function resetPassword($id) {
        echo $this->header();
        echo view('ResetPassword');
        echo $this->footer();
    }
    public function sendEmailTest() {
        $to = 'reply2jagat@gmail.com';
        $subject = 'subject';
        $message = "mg";
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@zamzamdistribution.com', 'Test');
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            echo 'Email successfully sent';
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
        }
    }
    public function applyCouponCode() {
        $session = session();
        @$user_id = $session->get('userLoggedin');
        $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
        $this->userModel->customQueryy($sql);
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $cid = $this->request->getVar('coupon_code');
            $cdate = date("Y-m-d");
            $sql = "select * from coupon where coupon_code='$cid'  AND status='Active'  AND '$cdate' between start_date  AND end_date ";
            $res = $this->userModel->customQuery($sql);

            if ($res) {
                if ($res[0]->coupon_type == "specific") {
                    $cust_id == $session->get('userLoggedin');
                    $sql = "select * from coupon_sent where coupon_code='$cid'  AND customer='$user_id' ";
                    $spec = $this->userModel->customQuery($sql);
                    if ($spec) {
                        if (@$user_id) {
                            $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                        } 
                        else {
                            $sid = session_id();
                            $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                        }
                        $cart = $this->userModel->customQuery($sql);
                        if ($cart) {
                            foreach ($cart as $k => $v) {
                                if ($v->discount_percentage > 0) {
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
                    else {
                        $r['msg'] = "This coupon code not valid for you!";
                        $r['action'] = "failed";
                        print_r(json_encode($r));
                        exit;
                    }
                } 
                else if ($res[0]->coupon_type == "generic") {
                    @$user_id = $session->get('userLoggedin');
                    if (@$user_id) {
                        $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                    } 
                    else {
                        $sid = session_id();
                        $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                    }
                    $cart = $this->userModel->customQuery($sql);
                    if ($cart) {
                        foreach ($cart as $k => $v) {
                            if ($v->discount_percentage > 0) {
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
                    $sql = "select * from coupon_uses where coupon_code='$cid'  AND customer='$user_id' ";
                    $spec = $this->userModel->customQuery($sql);
                    if ($spec) {
                        $r['msg'] = "Coupon code already used!";
                        $r['action'] = "failed";
                        print_r(json_encode($r));
                        exit;
                    } 
                    else {
                        @$user_id = $session->get('userLoggedin');
                        if (@$user_id) {
                            $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                        } else {
                            $sid = session_id();
                            $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$sid'";
                        }
                        $cart = $this->userModel->customQuery($sql);
                        if ($cart) {
                            foreach ($cart as $k => $v) {
                                if ($v->discount_percentage > 0) {
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
    public function sendEmail() {
        $subject = "subject";
        $message = 'message';
        $email = \Config\Services::email();
        $email->setTo('reply2jagat@gmail.com');
        $email->setFrom('reply2jagat@gmail.com', 'Contact Us');
        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            $msg = 'Email successfully sent';
        } else {
            $data = $email->printDebugger(['headers']);
            print_r($data);
            $msg = 'Email send failed';
        }
    }
    public function invoice() {
        echo view('Invoice');
    }
    public function orderSuccess() {
        helper(['form', 'url']);
        if ($this->request->getMethod() == "get") {
            $oid = base64_decode($this->request->getVar('ref'));
            echo $this->header();
            $sql = "select * from orders where order_id='$oid'";
            $udetail['data'] = $this->userModel->customQuery($sql);
            if ($udetail) {
                echo view('PaymentSuccess', $udetail);
            }
            echo $this->footer();
        }
    }
    public function orderSuccessWallet() {
        helper(['form', 'url']);
        if ($this->request->getMethod() == "get") {
            $oid = base64_decode($this->request->getVar('ref'));
            echo $this->header();
            $sql = "select * from wallet where order_id='$oid'";
            $udetail['data'] = $this->userModel->customQuery($sql);
            if ($udetail) {
                echo view('PaymentSuccessWallet', $udetail);
            }
            echo $this->footer();
        }
    }

    public function order_email_confirmation($idata){
        if($to = $idata['email']){
            $eoid = $idata['order_id'];
            $sql = " select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products inner join where order_products.order_id='$eoid'  ";
            $edata['order_products'] = $this->userModel->customQuery($sql);

            $sql = " select * from orders where order_id='$eoid'  ";
            $od = $this->userModel->customQuery($sql);

            if ($od[0]->coupon_code == "") unset($od[0]->coupon_code);
            if ($od[0]->coupon_discount == "") unset($od[0]->coupon_discount);
            unset($od[0]->products);
            unset($od[0]->coupon_type);
            unset($od[0]->coupon_value);
            unset($od[0]->invoice);
            unset($od[0]->updated_at);
            $edata['orders'] = $od[0];
            $sql = " select * from order_charges where order_id='$eoid'  ";
            $edata['order_charges'] = $this->userModel->customQuery($sql);
            $subject = 'Your order was successfully submitted. Order Id ' . $idata['order_id'];
            $message = view('BookingEmail', $edata);
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send()) {
                // echo 'Email successfully sent';
                return true;
            } 
            else {
                $data = $email->printDebugger(['headers']);
                print_r($data);
                return false;
            }
        }
    }
    
    public function COD_use_wallet($idata,$wallet_used=0){
        $b=true;

        $oud['wallet_used_amount'] = $wallet_used;
        $odetail = $this->userModel->do_action('orders', $idata['order_id'], 'order_id', 'update', $oud, '');
        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
        $wallet = $this->userModel->customQuery($sql);
        if ($wallet) {
            $rest_amount = $idata['total'];
            foreach ($wallet as $wk => $wv) {
                if ($wv->available_balance >= $idata['total']) {
                    $wupdate['status'] = 'Used';
                    $wupdate['available_balance'] = $wv->available_balance - $idata['total'];
                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                    
                } 
                else {
                    $rest_amount = $rest_amount - $wupdate['available_balance'];
                    $wupdate['status'] = 'Used';
                    $wupdate['available_balance'] = 0;
                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                    if ($rest_amount == 0) {
                        
                    }
                }
            }
        }

        else
        $b=false;


        return $b;
    }

    public function telr_payment($idata,$wallet_used=0){
        $b=false;
        $payName = explode(' ', $idata['name']);
        $params = array('ivp_method' => 'create', 
                        'ivp_tranclass' => 'ecom', 
                        'ivp_store' => STOREID, 
                        'ivp_authkey' => AUTHKEY, 
                        'ivp_amount' => $idata['total'] - $wallet_used, 
                        'ivp_currency' => 'AED', 
                        'ivp_test' => PGTEST, 
                        'ivp_cart' => $idata['order_id'], 
                        'ivp_desc' => 'Payment for order id : ' . $idata['order_id'], 
                        'bill_title' => '', 
                        'bill_fname' => @$payName[0], 
                        'bill_sname' => @$payName[1], 
                        'bill_addr1' => $idata['address'], 
                        'bill_addr2' => '', 
                        'bill_addr3' => '', 
                        'bill_city' => @$idata['street'], 
                        'bill_region' => @$idata['apartment_house'], 
                        'bill_country' => 'ae', 
                        'bill_zip' => '', 
                        'bill_email' => $idata['email'], 
                        'bill_phone' => $idata['phone'], 
                        'return_auth' => base_url() . '/payment-success/' . base64_encode($idata['order_id']), 
                        'return_can' => base_url() . '/payment-failed', 
                        'return_decl' => base_url() . '/payment-failed',

            );
        
            /*  echo "<pre>";
         print_r($params);exit;*/
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        if (curl_exec($ch) === false) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $results = curl_exec($ch);
            $results = json_decode($results, true);
        }
        curl_close($ch);
        if (empty($ref) || empty($url)) {
            $ref = trim(@@$results['order']['ref']);
            $url = trim(@@$results['order']['url']);
            $ptp['order_id'] = $idata['order_id'];
            $ptp['ref'] = $ref;
            $ptp['link'] = $url;
            $ptp['customer'] = $idata['user_id'];
            // $this->session->set_userdata('pay_pending',$idata['order_id']);
            $res = $this->userModel->do_action('payment_txn', '', '', 'insert', $ptp, '');
            // return redirect()->to($url);
            $b=true;
        }

       
        return $b;
        // echo "<pre>";
        // print_r($results);
        // if (empty($ref) || empty($url)) {
        //     echo ' Failed to create order';
        // }
        // exit;
    }

    public function use_wallet($idata){
        $b=true;
        $oud['payment_status'] = "Paid";
        $oud['wallet_used_amount'] = $idata['total'];
        $odetail = $this->userModel->do_action('orders', $idata['order_id'], 'order_id', 'update', $oud, '');
        $sql = "select * from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at asc";
        $wallet = $this->userModel->customQuery($sql);
        if ($wallet) {
            $rest_amount = $idata['total'];
            foreach ($wallet as $wk => $wv) {
                if ($wv->available_balance >= $idata['total']) {
                    $wupdate['status'] = 'Used';
                    $wupdate['available_balance'] = $wv->available_balance - $idata['total'];
                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                    // break; 
                } 
                else {
                    $rest_amount = $rest_amount - $wupdate['available_balance'];
                    $wupdate['status'] = 'Used';
                    $wupdate['available_balance'] = 0;
                    $odetail = $this->userModel->do_action('wallet', $wv->id, 'id', 'update', $wupdate, '');
                    if ($rest_amount == 0) {
                        // break; 
                    }
                }
            }
        }
        else
        return $b;

    }



    public function orderSubmit() {
        $data = [];
        helper(['form', 'url']);
        $b=false;
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            if ($this->request->getVar('wallet_use')) {
                $idata['wallet_use'] = 'Yes';
            } else {
                $idata['wallet_use'] = 'No';
            }
            $session = session();
            if (@$user_id = $session->get('userLoggedin')) {
                $idata['order_id'] = time() . rand(0, 9);
                $idata['user_id'] = $user_id;
                $idata['name'] = $p['name'];
                $idata['street'] = $p['street'];
                $idata['city'] = $p['city'];
                $idata['apartment_house'] = $p['apartment_house'];
                $idata['address'] = $p['address'];
                $idata['payment_method'] = $p['payment_method'];

                $sql = "select *,cart.pre_order_enabled as pre_order_enabled,cart.pre_order_before_payment_percentage as pre_order_before_payment_percentage,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id'";
                $cart = $this->userModel->customQuery($sql);

                if ($cart) {
                    $stotal = 0;
                    foreach ($cart as $k => $v) {

                        $ptotal = 0;
                        
                        $ins['product_id'] = $v->product_id;
                        $ins['pre_order_enabled'] = $v->pre_order_enabled;
                        $ins['pre_order_before_payment_percentage'] = $v->pre_order_before_payment_percentage;
                        $ins['coupon_code'] = $v->coupon_code;
                        $ins['coupon_type'] = $v->coupon_type;
                        $ins['coupon_value'] = $v->coupon_value;
                        if ($v->coupon_code) {
                            $idata['coupon_code'] = $v->coupon_code;
                            $idata['coupon_type'] = $v->coupon_type;
                            $idata['coupon_value'] = $v->coupon_value;
                        }
                        $ins['assemble_professionally_price'] = $v->app;
                        $ins['gift_wrapping'] = $v->gw;
                        $ins['gift_wrapping_note'] = $v->gift_wrapping_note;
                        $ggid = $v->gw;
                        $sql = "select * from gift_wrapping where     id='$ggid'   ";
                        $gift_wrapping = $this->userModel->customQuery($sql);
                        if ($gift_wrapping) {
                            $ins['gift_wrapping_price'] = $gift_wrapping[0]->price;
                            $gw_price = $gift_wrapping[0]->price;
                            $ins['gift_wrapping_image'] = $gift_wrapping[0]->image;
                        }
                        $pid = $v->product_id;
                        $sql = "select * from product_image where     product='$pid' and status='Active' ";
                        $product_image = $this->userModel->customQuery($sql);
                        if ($product_image) {
                            $ins['product_image'] = $product_image[0]->image;
                        }
                        $ins['product_name'] = $v->name;
                        @$ins['sku'] = @$v->sku;
                        if ($v->dp > 0) {
                            $ins['product_price'] = round($v->price - (($v->dp * $v->price) / 100));
                        } else {
                            $ins['product_price'] = $v->price;
                        }
                        $ins['user_id'] = $v->user_id;
                        $ins['quantity'] = $v->quantity;
                        $ins['discount_percentage'] = $v->dp;
                        $ins['product_original_price'] = $v->price;
                        $ins['package'] = $v->package;
                        $ins['order_id'] = $idata['order_id'];

                        // save the ordered products
                        $res = $this->userModel->do_action('order_products', '', '', 'insert', $ins, '');

                        // update the products stock quantity
                        $porUpdate['available_stock'] = $v->available_stock - $v->quantity;
                        $res = $this->userModel->do_action('products', $pid, 'product_id', 'update', $porUpdate, '');


                        if ($v->dp > 0) {
                            if ($v->app == 0 || $v->app > 0) {
                                $ptotal = $ptotal + (round(($v->price - ($v->dp * $v->price) / 100)) + $v->app + $gw_price) * $v->quantity;
                            } else {
                                $ptotal = $ptotal + (round(($v->price - ($v->dp * $v->price) / 100)) + $gw_price) * $v->quantity;
                            }
                        } 

                        else {
                            if ($v->app == 0 || $v->app > 0) {
                                $app = $v->app;
                            } else {
                                $app = 0;
                            }
                            // dis new
                            $tpro = ($v->price + $app + $gw_price) * $v->quantity;
                            if ($v->coupon_code) {
                                if ($v->coupon_type == "Percentage") {
                                    $ptotal = $ptotal + (($tpro - ($tpro * $v->coupon_value) / 100));
                                } else {
                                    $ptotal = $ptotal + (($tpro - $v->coupon_value));
                                }
                            } else {
                                $ptotal = $ptotal + ($v->price + $app + $gw_price) * $v->quantity;
                            }
                            //  dis end
                            /* if($v->app==0 || $v->app>0){
                            $ptotal=$ptotal+($v->price+$v->app+$gw_price)*$v->quantity;
                            }else{
                            $ptotal=$ptotal+($v->price+$gw_price)*$v->quantity;
                            }*/
                        }
                        $stotal = $stotal + $ptotal;
                    }
                }

                $chr = 0;
                $sql = "select * from user_address where user_id='$user_id' AND status='Active'";
                $user_address = $this->userModel->customQuery($sql);

                // if the user address is registred
                if ($user_address) {
                    if ($idata['street']) {
                    } 

                    // if customer did not set the address take the one already registrer
                    else {
                        $idata['name'] = $user_address[0]->name;
                        $idata['city'] = $user_address[0]->city;
                        $cidd = $user_address[0]->city;
                        $idata['street'] = $user_address[0]->street;
                        $idata['apartment_house'] = $user_address[0]->apartment_house;
                        $idata['address'] = $user_address[0]->address;
                    }
                } 

                // If the user address is not registred create a new one
                else {
                    $uaddress['name'] = $idata['name'];
                    $uaddress['city'] = $idata['city'];
                    $cidd = $idata['city'];
                    $uaddress['street'] = $idata['street'];
                    $uaddress['apartment_house'] = $idata['apartment_house'];
                    $uaddress['address'] = $idata['address'];
                    $uaddress['user_id'] = $user_id;
                    $uaddress['status'] = 'Active';
                    $res = $this->userModel->do_action('user_address', '', '', 'insert', $uaddress, '');
                }

                // Calculating the applicable charges (delivery charge depending on the city address)
                $sql = "select * from charges where status='Active' AND (city='all' || city='$cidd')";
                $charges = $this->userModel->customQuery($sql);
                if ($charges) {
                    foreach ($charges as $k2 => $v2) {
                        if ($stotal >= $v2->applicable_minimum_amount && $stotal <= $v2->applicable_maximum_amount) {
                            $inc['value'] = $v2->value;
                            $inc['title'] = $v2->title;
                            $inc['type'] = $v2->type;
                            $inc['user_id'] = $v->user_id;
                            if ($v2->type == "Percentage") {
                                $inc['price'] = ($stotal * $v2->value) / 100;
                            } else {
                                $inc['price'] = ($v2->value);
                            }
                            $chr = $chr + $inc['price'];
                            $inc['order_id'] = $idata['order_id'];
                            $res = $this->userModel->do_action('order_charges', '', '', 'insert', $inc, '');
                        }
                    }
                }



                $idata['sub_total'] = bcdiv($stotal, 1, 2);
                $idata['charges'] = bcdiv($chr, 1, 2);
                $idata['total'] = bcdiv($stotal + $chr, 1, 2);
                $sql = "select * from users where user_id='$user_id'";
                $udetail = $this->userModel->customQuery($sql);
                $idata['email'] = $udetail[0]->email;
                $idata['phone'] = $udetail[0]->phone;

                // var_dump($idata);die();
                // Create the order
                $res = $this->userModel->do_action('orders', '', '', 'insert', $idata, '');

                // clear the cart 
                $session = session();
                $res = $this->userModel->do_action('cart', $session->get('userLoggedin'), 'user_id', 'delete', '', '');

                $sql = "select * from settings";
                $settings = $this->userModel->customQuery($sql);
                $idata['settings'] = $settings[0];


                if ($idata['payment_method'] == "Online payment") {
                    // if (@$this->request->getVar('wallet_use') == 'Yes') {
                    if($idata['wallet_use'] == "Yes"){
                        @$user_id = $session->get('userLoggedin');
                        $sql = "select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at desc";
                        $cbal = $this->userModel->customQuery($sql);

                        if ($cbal[0]->total) {

                            // custmer's wallet balance cover the total order --- 
                            if ($cbal[0]->total >= $idata['total']) {
                                $b=use_wallet($idata);
                            } 

                            // the customer balance is not enough to pay the total order
                            else {
                                $oud['wallet_used_amount'] = $cbal[0]->total;
                                $odetail = $this->userModel->do_action('orders', $idata['order_id'], 'order_id', 'update', $oud, '');
                                $b=telr_payment($idata,$cbal[0]->total);
                                
                            }
                        }
                    } 
                    
                    else {
                        $b=telr_payment($idata);
                    }
                } 
                
                else {
                    // wallet start
                    if (@$this->request->getVar('wallet_use') == 'Yes') {
                        @$user_id = $session->get('userLoggedin');
                        $sql = "select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at desc";
                        $cbal = $this->userModel->customQuery($sql);
                        if ($cbal[0]->total) {
                            // Wallet balance can cover the total order IN COD
                            if ($cbal[0]->total >= $idata['total']) {
                                $b=use_wallet($idata);
                            } 
                            // wallet balance cannot cover the total order in COD
                            else {
                                $b=COD_use_wallet($idata,$cbal[0]->total);
                                
                            }
                        }
                    }

                    $b=true;
                       
                }

                if($b){

                    order_email_confirmation($idata);
                    return redirect()->to(site_url('/order-success?ref=' . base64_encode($idata['order_id'])));
                }
            }
        }
    }
    public function cart() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "get") {
            if ($rcid = $this->request->getVar('rcid')) {
                $res = $this->userModel->do_action('cart', $rcid, 'id', 'delete', '', '');
            }
            if ($pcid = $this->request->getVar('pcid')) {
                $session = session();
                $userModel = model('App\Models\UserModel', false);
                $uri = service('uri');
                @$user_id = $session->get('userLoggedin');
                if (@$user_id) {
                    $sql = " DELETE FROM `cart` WHERE package='$pcid' AND user_id='$user_id'";
                    $this->userModel->customQueryy($sql);
                } else {
                    $sid = session_id();
                    $sql = " DELETE FROM `cart` WHERE package='$pcid' AND user_id='$sid'";
                    $this->userModel->customQueryy($sql);
                }
            }
            if ($cid = $this->request->getVar('cid')) {
                $updata['quantity'] = $this->request->getVar('quantity');
                $res = $this->userModel->do_action('cart', $cid, 'id', 'update', $updata, '');
            }
        }
        if ($this->request->getMethod() == "post") {
            if ($freebie = $this->request->getVar('freebie')) {
                $session = session();
                if ($session->get('userLoggedin')) {
                    @$user_id = $session->get('userLoggedin');
                } else {
                    @$user_id = session_id();
                }
                $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
                $this->userModel->customQueryy($sql);
                foreach ($freebie as $k => $v) {
                    $p['product_id'] = $v;
                    $p['quantity'] = 1;
                    $p['user_id'] = $user_id;
                    $p['discount_percentage'] = 100;
                    $res = $this->userModel->do_action('cart', '', '', 'insert', $p, '');
                }
            }
        }
        echo $this->header();
        echo view('Cart');
        echo $this->footer();
    }
    public function checkout() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            if ($p = $this->request->getVar('gift')) {
                $n = $this->request->getVar('note');
                if ($p) {
                    foreach ($p as $k => $v) {
                        $updata['gift_wrapping'] = $v;
                        $updata['gift_wrapping_note'] = $n[$k];
                        $res = $this->userModel->do_action('cart', $k, 'id', 'update', $updata, '');
                    }
                }
            }
            if ($freebie = $this->request->getVar('freebie')) {
                $session = session();
                if ($session->get('userLoggedin')) {
                    @$user_id = $session->get('userLoggedin');
                } else {
                    @$user_id = session_id();
                }
                $sql = " DELETE FROM `cart` WHERE  discount_percentage='100' AND user_id='$user_id'";
                $this->userModel->customQueryy($sql);
                foreach ($freebie as $k => $v) {
                    $p['product_id'] = $v;
                    $p['quantity'] = 1;
                    $p['user_id'] = $user_id;
                    $p['discount_percentage'] = 100;
                    $res = $this->userModel->do_action('cart', '', '', 'insert', $p, '');
                }
            }
        }
        echo $this->header();
        echo view('Checkout');
        echo $this->footer();
    }
    public function productDetail2($id) {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p['product_id'];
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $sql = " select * from product_review where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $this->session->setFlashdata('error', 'You have already reviewed this product.');
                return redirect()->to(site_url('product/' . $p['product_id'] . '#review'));
            } else {
                $p['user_id'] = $user_id;
                $res = $this->userModel->do_action('product_review', '', '', 'insert', $p, '');
                $this->session->setFlashdata('success', 'Thank you for your review. It has been submitted to the admin for approval.');
                return redirect()->to(site_url('product/' . $p['product_id'] . '#review'));
            }
        }
        $data['flashData'] = $this->session->getFlashdata();
        echo $this->header();
        $sql = "select * from products where product_id='$id';";
        $data['products'] = $this->userModel->customQuery($sql);
        $sql = "select * from product_review where product_id='$id' AND status='Active'";
        $data['review'] = $this->userModel->customQuery($sql);
        $sql = "select avg(rating) as rat from product_review where product_id='$id' AND status='Active'";
        $drat = $this->userModel->customQuery($sql);
        $data['pro_over_rating'] = $drat[0]->rat;
        $sql = "select * from product_image where product='$id';";
        $data['product_image'] = $this->userModel->customQuery($sql);
        $cid = $data['products'][0]->category;
        $sql = "select * from master_category where category_id='$cid';";
        $data['master_category'] = $this->userModel->customQuery($sql);
        $sql = "select * from products inner join   related_products on products.product_id=related_products.related_product where related_products.product_id='$id' AND status='Active'  ";
        $data['sproducts'] = $this->userModel->customQuery($sql);
        if ($data['sproducts']) {
        } else {
            $sql = "select * from products where category='$cid' AND status='Active' limit 12;";
            $data['sproducts'] = $this->userModel->customQuery($sql);
        }
        $bid = $data['products'][0]->brand;
        $sql = "select * from brand where id=$bid;";
        $data['brands'] = $this->userModel->customQuery($sql);
        $coid = $data['products'][0]->color;
        $sql = "select * from color where id=$coid;";
        $data['color'] = $this->userModel->customQuery($sql);
        $aid = $data['products'][0]->age;
        $sql = "select * from age where id=$aid;";
        $data['age'] = $this->userModel->customQuery($sql);
        $sid = $data['products'][0]->suitable_for;
        $sql = "select * from suitable_for where id=$sid;";
        $data['suitable_for'] = $this->userModel->customQuery($sql);
        echo view('pd', $data);
        echo $this->footer();
    }
    public function addWishtlist() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p['product_id'];
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $sql = " select * from wishlist where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $res = $this->userModel->do_action('wishlist', $ext[0]->id, 'id', 'delete', '', '');
                $r['msg'] = "Item successfully removed from your wishlist";
                $r['action'] = "Add to wishlist";
                print_r(json_encode($r));
                exit;
            } else {
                $p['user_id'] = $user_id;
                $res = $this->userModel->do_action('wishlist', '', '', 'insert', $p, '');
                $r['msg'] = "Item successfully added to your wishlist";
                $r['action'] = "Add to wishlist";
                print_r(json_encode($r));
                exit;
            }
        }
    }
    public function buyNowSubmitForm() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            if ($this->request->getVar('quantity') > 0 && $this->request->getVar('quantity') != "") {
                $p = $this->request->getVar();
                $pid = $p['product_id'];
                $session = session();
                if ($session->get('userLoggedin')) {
                    @$user_id = $session->get('userLoggedin');
                } else {
                    @$user_id = session_id();
                }
                $sql = " select * from cart where user_id='$user_id' AND product_id='$pid'";
                $ext = $this->userModel->customQuery($sql);
                if ($ext) {
                    $pd['quantity'] = $ext[0]->quantity + $p['quantity'];
                    $pd['assemble_professionally_price'] = $this->request->getVar('assemble_professionally_price');
                    $res = $this->userModel->do_action('cart', $ext[0]->id, 'id', 'update', $pd, '');
                } else {
                    unset($p['product_name']);
                    unset($p['product_image']);
                    $p['user_id'] = $user_id;
                    $res = $this->userModel->do_action('cart', '', '', 'insert', $p, '');
                }
                $sql = " select * from cart where user_id='$user_id'  ";
                $ext = $this->userModel->customQuery($sql);
                if ($ext) {
                    $r['msg'] = "Item successfully added to your cart";
                    $r['action'] = "Add to cart";
                    $r['value'] = count($ext);
                    print_r(json_encode($r));
                    exit;
                }
            } else {
            }
        }
    }

    private function _subcat($c_id){

        $cats=array();

        $sql_sub_cat="select category_id from master_category where parent_id='".$c_id."'";
        $main_sub_cats=$this->userModel->customQuery($sql_sub_cat);
        // return $main_sub_cats;

        if($main_sub_cats)
        foreach($main_sub_cats as $k=>$v){
            array_push($cats,$v->category_id);
        }

        return $cats;

        // var_dump($cats);
    }

    public function getSearchData() {
        $data = [];
        helper(['form', 'url']);
        //  var_dump($this->request);
        //  die();
        if ($this->request->getMethod() == "post") {
            $sql = "select * from products where products.status='Active'";

            
            //   inner join master_category on products.category=master_category.category_id
            /*
            if ($id1=$this->request->getVar('master_category')) {
            $sql2="select * from master_category where parent_id='$id1'";
            $mcat=$this->userModel->customQuery($sql2);
            if($mcat){
            $sql=$sql."   AND  FIND_IN_SET('$id1', products.category)      OR ( ";
            foreach($mcat as $km=>$mv){
             $scats=$mv->category_id;
             $sql2="select * from master_category where parent_id='$scats'";
             $ssmcat=$this->userModel->customQuery($sql2); 
             if($ssmcat){
               foreach($ssmcat as $sbk=>$sbv){
                $lcat2=$sbv->category_id;
                if($sbk==count($ssmcat)-1){
                  $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
                }else{
                  $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
                }
              }
            }else{
              $lcat=$mv->category_id;
              if($km==count($mcat)-1){
                $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
              }else{
                $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR ";     
              }
            }
            }
            $sql=$sql."   ) ";
            }else{
            $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";
            }
            }*/


            // YAHIA CODE

                // echo($sql);
                // die();

            
            if ($master_category = $this->request->getVar('master_category')) {
                $sub_categories=$this->_subcat($master_category);
    
                $sql.=" AND (FIND_IN_SET('".$master_category."',products.category) ";

                if(sizeof($sub_categories) > 0){

                    $sql.=" OR ";
                    foreach ($sub_categories as $key => $value) {

                        # code...
                        if($key < sizeof($sub_categories)-1)
                        $sql.=" FIND_IN_SET('$value', products.category)  OR ";
    
                        else
                        $sql.=" FIND_IN_SET('$value', products.category) ";
    
                    }
               

                }

                foreach ($sub_categories as $key => $value) {
                    # code...
                    $sub_sub_categories=$this->_subcat($value);
                    // echo(sizeof($sub_sub_categories));
        
                    if(sizeof($sub_sub_categories) > 0){
                        $sql.=" OR ";

                        foreach ($sub_sub_categories as $kkey => $vvalue) {

                            # code...
                            if($kkey < sizeof($sub_sub_categories)-1)
                            $sql.=" FIND_IN_SET('$vvalue', products.category)  OR ";
        
                            else
                            $sql.=" FIND_IN_SET('$vvalue', products.category) ";
        
                        }

           
                        
                    }

                }
                $sql.=" ) ";

            }

            // echo($sql);
            // die();

            // OLD JAGAT CODE
            // if ($id1 = $this->request->getVar('master_category')) {
            //     $sql2 = "select * from master_category where parent_id='$id1'";
            //     $mcat = $this->userModel->customQuery($sql2);
            //     $sql = $sql . " AND ( ";
            //     if ($mcat) {
            //         $Fla = 0;
            //         $brandFlag = 0;
            //         //  $sql=$sql." AND (";
            //         $sql = $sql . "     FIND_IN_SET('$id1', products.category)      OR ( ";


            //         foreach ($mcat as $km => $mv) {
            //             $scats = $mv->category_id;

            //             if ($brandFlag == 1) {
            //                 $sql = $sql . "  OR  FIND_IN_SET('$mv->category_id', products.category)      ";
            //                 $brandFlag = 0;
            //             } 
                        
            //             else {
            //                 $sql = $sql . "    FIND_IN_SET('$mv->category_id', products.category)    OR ";
            //             }
            //             $sql2 = "select * from master_category where parent_id='$scats'";
            //             $ssmcat = $this->userModel->customQuery($sql2);


            //             if ($ssmcat) {
            //                 $Fla = 1;
            //                 foreach ($ssmcat as $sbk => $sbv) {
            //                     $lcat2 = $sbv->category_id;

            //                     if ($sbk == count($ssmcat) - 1) {
            //                         $brandFlag = 1;
            //                         $sql = $sql . "    FIND_IN_SET('$lcat2', products.category)      ";
            //                     } else {
            //                         $sql = $sql . "    FIND_IN_SET('$lcat2', products.category)    OR ";
            //                     }
            //                 }
            //             } 

            //             else {
            //                 $lcat = $mv->category_id;
            //                 if ($km == count($mcat) - 1) {
            //                     $sql = $sql . "  FIND_IN_SET('$lcat', products.category)         ";
            //                 } else {
            //                     if ($Fla == 1) {
            //                         $Fla == 0;
            //                         $sql = $sql . " OR FIND_IN_SET('$lcat', products.category)      OR ";
            //                     } else {
            //                         $sql = $sql . "  FIND_IN_SET('$lcat', products.category)      OR ";
            //                     }
            //                 }
            //             }
            //         }
                    

            //         $sql = $sql . "   ) ";
            //     } 
                
            //     else {
            //         $sql = $sql . "      FIND_IN_SET('$id1', products.category)  ";
            //     }


            //     $sql = $sql . "   ) ";
            // }

            

            // Cat END##############
            if ($id1 = $this->request->getVar('categoryList')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "      FIND_IN_SET('$v', products.category)  ";
                    } else {
                        $sql = $sql . "   OR  FIND_IN_SET('$v', products.category)  ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($cat = $this->request->getVar('keyword')) {
                $sql = $sql . "   AND  products.name like '%$cat%'  ";
            }
            if ($id1 = $this->request->getVar('offer')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "      products.discount_percentage='$v'  ";
                    } else {
                        $sql = $sql . "   OR   products.discount_percentage='$v'  ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('brand')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "      products.brand='$v'  ";
                    } else {
                        $sql = $sql . "  OR    products.brand='$v'  ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('preOrder')) {
                // $sql=$sql."   AND    ( ";
                if ($id1[0] == "Yes") $sql = $sql . "  AND    (     products.pre_order_enabled='$id1[0]'  ";
                // foreach($id1 as $k=>$v){
                // if($k==0){
                // $sql=$sql."      products.pre_order_enabled='$v'  ";
                // }
                // else{
                //  $sql=$sql."  OR    products.pre_order_enabled='$v'  ";
                //  }
                //  }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('freebie')) {
                if ($id1[0] == "Yes") $sql = $sql . "  AND    (     products.freebie='$id1[0]'  ";
                //   $sql=$sql."   AND    ( ";
                //   foreach($id1 as $k=>$v){
                //     if($k==0){
                //       $sql=$sql."      products.freebie='$v'  ";
                //     }else{
                //      $sql=$sql."  OR    products.freebie='$v'  ";
                //    }
                //  }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('evergreen')) {
                if ($id1[0] == "Yes") $sql = $sql . "  AND    (     products.evergreen='$id1[0]'  ";
                //   $sql=$sql."   AND    ( ";
                //   foreach($id1 as $k=>$v){
                //     if($k==0){
                //       $sql=$sql."      products.evergreen='$v'  ";
                //     }else{
                //      $sql=$sql."  OR    products.evergreen='$v'  ";
                //    }
                //  }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('exclusive')) {
                if ($id1[0] == "Yes") $sql = $sql . "  AND    (     products.exclusive='".$id1[0]."'  ";
                // $sql=$sql."   AND    ( ";
                // foreach($id1 as $k=>$v){
                // if($k==0){
                // $sql=$sql."      products.exclusive='$v'  ";
                // }else{
                //  $sql=$sql."  OR    products.exclusive='$v'  ";
                //  }
                //  }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('priceupto')) {
                $sql = $sql . "   AND    ( ";
                $sql = $sql . "      products.price<='".$id1."'  ";
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('showOffer')) {
                if ($id1 == "yes") {
                    $sql = $sql . "   AND    ( ";
                    $sql = $sql . "      products.discount_percentage>0  ";
                    $sql = $sql . "   ) ";
                }
            }
            if ($id1 = $this->request->getVar('type')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "        FIND_IN_SET($v , products.type) ";
                    } else {
                        $sql = $sql . "   OR   FIND_IN_SET($v , products.type) ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('color')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "         FIND_IN_SET($v , products.color) ";
                    } else {
                        $sql = $sql . "   Or     FIND_IN_SET($v , products.color)   ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('age')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "        FIND_IN_SET($v , products.age)  ";
                    } else {
                        $sql = $sql . "   OR    FIND_IN_SET($v , products.age)  ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($id1 = $this->request->getVar('suitable_for')) {
                $sql = $sql . "   AND    ( ";
                foreach ($id1 as $k => $v) {
                    if ($k == 0) {
                        $sql = $sql . "       FIND_IN_SET($v , products.suitable_for)  ";
                    } else {
                        $sql = $sql . "   OR    FIND_IN_SET($v , products.suitable_for)  ";
                    }
                }
                $sql = $sql . "   ) ";
            }
            if ($new_r = $this->request->getVar('new_realesed')) {
                if ($new_r[0] == "Yes") $sql = $sql . " AND  products.precedence < 1000 ";
            }
            if ($this->request->getVar('sort') == "Newest") {
                $sql = $sql . "    order by products.created_at desc  ";
            }
            if ($this->request->getVar('sort') == "Oldest") {
                $sql = $sql . "    order by products.created_at asc  ";
            }
            if ($this->request->getVar('sort') == "Highest") {
                $sql = $sql . "    order by products.price desc  ";
            }
            if ($this->request->getVar('sort') == "Lowest") {
                $sql = $sql . "    order by products.price asc  ";
            }
            

            $data['total_products'] = $this->userModel->customQuery($sql);
            if (@$this->request->getVar('page')) {
                if ($this->request->getVar('page') > 1) {
                    $data['pagee'] = $this->request->getVar('page');
                }
                $s = ($this->request->getVar('page') * 52) - 52;
                $page = $this->request->getVar('page') * 52;
            } else {
                $s = 0;
                $page = 52;
            }
            $sql = $sql . "     limit $s,52 ";
            // echo($sql);die();
            $data['product'] = $this->userModel->customQuery($sql);
            // echo($sql);
            // die();
            
        }
        echo view('SearchProductDatatable', $data);
    }
    public function index() {
        echo $this->header();
        echo view('Home');
        echo $this->footer();
    }
    public function productList() {
        echo $this->header();
        echo view('ProductList');
        echo $this->footer();
    }
    public function category() {
        echo $this->header();
        $uri = service('uri');
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
        $data['category'] = $this->userModel->customQuery($sql);
        if ($id == "e-mobility-1634548852") {
            echo view('Category-e-mobility', $data);
        } else {
            echo view('Category', $data);
        }
        echo $this->footer();
    }
    public function productDetail($id) {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $p = $this->request->getVar();
            $pid = $p['product_id'];
            $session = session();
            @$user_id = $session->get('userLoggedin');
            $sql = " select * from product_review where user_id='$user_id' AND product_id='$pid'";
            $ext = $this->userModel->customQuery($sql);
            if ($ext) {
                $this->session->setFlashdata('error', 'You have already reviewed this product.');
                return redirect()->to(site_url('product/' . $p['product_id'] . '#review'));
            } else {
                $p['user_id'] = $user_id;
                $res = $this->userModel->do_action('product_review', '', '', 'insert', $p, '');
                $this->session->setFlashdata('success', 'Thank you for your review. It has been submitted to the admin for approval.');
                return redirect()->to(site_url('product/' . $p['product_id'] . '#review'));
            }
        }
        $data['flashData'] = $this->session->getFlashdata();
        echo $this->header();
        $sql = "select * from products where product_id='$id';";
        $data['products'] = $this->userModel->customQuery($sql);
        $sql = "select * from product_review where product_id='$id' AND status='Active'";
        $data['review'] = $this->userModel->customQuery($sql);
        $sql = "select avg(rating) as rat from product_review where product_id='$id' AND status='Active'";
        $drat = $this->userModel->customQuery($sql);
        $data['pro_over_rating'] = $drat[0]->rat;
        $sql = "select * from product_image where product='$id';";
        $data['product_image'] = $this->userModel->customQuery($sql);
        $cid = $data['products'][0]->category;
        $sql = "select * from master_category where category_id='$cid';";
        $data['master_category'] = $this->userModel->customQuery($sql);
        $sql = "select * from products inner join   related_products on products.product_id=related_products.related_product where related_products.product_id='$id' AND status='Active'  ";
        $data['sproducts'] = $this->userModel->customQuery($sql);
        if ($data['sproducts']) {
        } else {
            $sql = "select * from products where category='$cid' AND status='Active' limit 12;";
            $data['sproducts'] = $this->userModel->customQuery($sql);
        }
        $bid = $data['products'][0]->brand;
        $sql = "select * from brand where id=$bid;";
        $data['brands'] = $this->userModel->customQuery($sql);
        $coid = $data['products'][0]->color;
        $sql = "select * from color where id=$coid;";
        $data['color'] = $this->userModel->customQuery($sql);
        $aid = $data['products'][0]->age;
        $sql = "select * from age where id=$aid;";
        $data['age'] = $this->userModel->customQuery($sql);
        $sid = $data['products'][0]->suitable_for;
        $sql = "select * from suitable_for where id=$sid;";
        $data['suitable_for'] = $this->userModel->customQuery($sql);
        echo view('ProductDetail', $data);
        echo $this->footer();
    }
    public function cms($id) {
        echo $this->header();
        $sql = "select * from cms where id=$id;";
        $data['cms'] = $this->userModel->customQuery($sql);
        echo view('CMS', $data);
        echo $this->footer();
    }
    public function faq() {
        echo $this->header();
        $sql = "select * from faq where status='Active'  ";
        $data['faq'] = $this->userModel->customQuery($sql);
        echo view('Faq', $data);
        echo $this->footer();
    }
    public function blog() {
        echo $this->header();
        if ($this->request->getMethod() == "get" && $this->request->getVar('category') != "") {
            $p = $this->request->getVar('category');
            $sql = "select * from blog where status='Active' AND category='$p'  ";
        } else {
            $sql = "select * from blog where status='Active'  ";
        }
        $data['blog'] = $this->userModel->customQuery($sql);
        $data['flashData'] = $this->session->getFlashdata();
        echo view('Blog', $data);
        echo $this->footer();
    }
    public function blogDetail($id) {
        echo $this->header();
        $sql = "select * from blog where status='Active' AND blog_id='$id'  ";
        $data['blog'] = $this->userModel->customQuery($sql);
        $sql = "select category as cat,count(blog_id) as count from blog where status='Active' group by category  ";
        $data['blog_cat'] = $this->userModel->customQuery($sql);
        $data['flashData'] = $this->session->getFlashdata();
        echo view('BlogDetail', $data);
        echo $this->footer();
    }
    public function contact() {
        echo $this->header();
        $sql = "select * from cms  ";
        $data['cms'] = $this->userModel->customQuery($sql);
        $sql = "select * from settings  ";
        $data['settings'] = $this->userModel->customQuery($sql);
        $data['settings'] = $data['settings'][0];
        $data['flashData'] = $this->session->getFlashdata();
        echo view('Contact', $data);
        echo $this->footer();
    }
    public function header() {
        return view('Common/Header');
    }
    public function footer() {
        return view('Common/Footer');
    }
    public function test($name) {
        echo ("hello world " . $name);
    }
}
