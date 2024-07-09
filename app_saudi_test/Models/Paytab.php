<?php 
namespace App\Models;
use CodeIgniter\Model;

class Paytab extends Model{

    private $api_info=array(
        // test credential
        "profile_id"=> PAYTAB_PROFILE_ID,
        "server_key"=> PAYTAB_SERVER_KEY,
        "client_key"=> PAYTAB_CLIENT_KEY
    );

    public $endpoint;
    public $method;
    public $result;
    private $token;
    private $last_time_token;
    private $token_validity;
    private $header_key;
    private $tran_type;
    private $tran_class;
    public $userModel;
    public function __construct($endpoint = "request" , $method = "POST" , $tran_type = "sale" , $tran_class = "ecom"){
        $this->endpoint=$endpoint;
        $this->method=$method;
        // $this->get_authorization();
        $this->header_key = $this->api_info["server_key"];
        $this->tran_type = $tran_type;
        $this->tran_class = $tran_class;
        $this->userModel = model("App\Models\UserModel");
    }


    public function get_data($data = null , $hdrs = []) {
        // $date=new DateTime();
        // $d=$date->format("Y-m-d H:i:s");
        // if($this->is_token_expired())
        // $this->get_authorization();
        $headers =  array(
            "authorization:" . $this->header_key,
            'Content-Type: application/json',
            // 'Content-Length: ' . sizeof($post_string),
        ); 
        $headers = array_merge($headers , $hdrs);
        $post_string = $data;
        $ch = curl_init();
        if($this->method=="POST" || $this->method=="PUT"){
            curl_setopt($ch, CURLOPT_URL,"https://secure.paytabs.sa/payment/".$this->endpoint);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_string));
        }
        else{
            if($post_string!==null)
            curl_setopt($ch, CURLOPT_URL,"https://secure.paytabs.sa/payment/".$this->endpoint."?".http_build_query($post_string));
            else
            curl_setopt($ch, CURLOPT_URL,"https://secure.paytabs.sa/payment/".$this->endpoint);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
    
        
        $content = curl_exec($ch);
        if($content){
            curl_close($ch);
            return json_decode($content);
            // return $content;
        }else{
            return curl_error($ch);
            curl_close($ch);
            // return "error";
        }
    
    }

    public function get_result($data = null){
        $res=$this->get_data($data);
        return $res;
    }

    // Preparing data structure for API calls - Hosted Payment Page
    public function structure_data($order_details){
       
        
        $orderModel = model("App\Models\OrderModel");
        $productModel = model("App\Models\ProductModel");

        // $user_infos = $this->userModel->get_user_infos($user_id);
        // Creating the ORDER ID
        $reference_id = time() . rand(0, 9);
        $city = lg_put_text($orderModel->get_city_name($order_details["order"]["city"])->title , $orderModel->get_city_name($order_details["order"]["city"])->arabic_title , false);
        $body_request = [
            "profile_id" => $this->api_info["profile_id"],
            "tran_type" => "sale", //auth - capture - void - refund
            "tran_class" => "ecom", 
            "cart_id" => $order_details["order"]["order_id"],
            "cart_currency" => CURRENCY,
            "cart_amount" => $order_details["order"]["total"],
            "cart_description" => "ZGames KSA ".$order_details["order"]["name"]."' order with reference ".$order_details["order"]["order_id"],
            "paypage_lang" => (false) ? "EN" : strtolower(get_cookie("language")),
            // "payment_methods" => ["creditcard" , "mada" , "stcpay" , "applepay" , "samsungpay" , "unionpay"],
            "payment_methods" => ["all"],
            "customer_details" => [
                "name" => $order_details["order"]["name"],
                "email" => $order_details["order"]["email"],
                "phone" => $order_details["order"]["phone"],
                "street1" => $order_details["order"]["street"],
                "city" => $city,
                "state" => $city,
                "country" => "SA",
                // "zip" => "",
            ],
            "shipping_details" => [
                "name" => $order_details["order"]["name"],
                "email" => $order_details["order"]["email"],
                "phone" => $order_details["order"]["phone"],
                "street1" => $order_details["order"]["street"],
                "city" => $city,
                "state" => $city,
                "country" => "SA",
                // "zip" => "",
            ],
            // "callback" => "",
            "return" => base_url()."/payment-success/".base64_encode($order_details["order"]["order_id"])."?user={$order_details["order"]["user_id"]}",
            "framed" => false,
            // "framed_return_top" => true,
            // "framed_return_parent" => false,
            
        ];

        return $body_request;

    }

    // Initial payment page
    public function paytab_initiate_payment_page($payload , $user_id){
        $paytab_data = ["status"  => false , "url" => null];
        $res = $this->get_data($payload);
        if(!empty($res->redirect_url)){
            $ptp["order_id"] = $res->cart_id;
            $ptp["ref"] = $res->tran_ref;
            $ptp["link"] = $res->redirect_url;
            $ptp["customer"] = $user_id;
            $this->userModel->do_action("payment_txn", "", "", "insert", $ptp, "");
            // return redirect()->to($url);
            $paytab_data["status"] = true;
            $paytab_data["url"] = $res->redirect_url;
        }

        return $paytab_data;
    }

    // Check Payment Status
    public function paytab_check_payment($transaction_ref){

        $this->endpoint = "query";
        $payload = [
            "profile_id" => $this->api_info["profile_id"],
            "tran_ref" => $transaction_ref,
        ];

        $results = $this->get_data($payload);
        
        if(!is_null($results)){
            $pd["amount"] =                         @$results->cart_amount;
            $pd["currency"] =                       @$results->cart_currency;
            $pd["description"] =                    @$results->cart_description;
            $pd["status"] =                         (@$results->payment_result->response_status == "A") ? "Paid" : "Not Paid";
            $pd["transaction_ref"] =                @$results->tran_ref;
            $pd["transaction_type"] =               @$results->tran_type;
            $pd["transaction_class"] =              "Ecom";
            $pd["transaction_status"] =             @$results->payment_result->response_status;
            // $pd["transaction_code"] =               @$results->;
            $pd["transaction_message"] =            @$results->payment_result->response_message;
            $pd["paymethod"] =                      "Card";
            $pd["email"] =                          @$results->customer_details->email;
            $pd["name"] =                           @$results->customer_details->name;
            $pd["line1"] =                          @$results->customer_details->street1;
            // $pd["line2"] =                          @$results->;
            $pd["city"] =                           $results->customer_details->city;
            $pd["state"] =                          $results->customer_details->state;
            $pd["country"] =                        $results->customer_details->country;
            // $pd["areacode"] =                       $results->customer_details->street1;
            $pd["mobile"] =                         $results->customer_details->phone;

            return $pd;
        }
        return false;


    }

    // Verify Post request on return url
    public function paytab_verify_request($signature_fields){

        $serverKey = $this->header_key;
        $requestSignature = $signature_fields["signature"];

        unset($signature_fields["signature"]);
        $signature_fields = array_filter($signature_fields);
        ksort($signature_fields);
        $query = http_build_query($signature_fields);
        $signature = hash_hmac('sha256', $query, $serverKey);
        
        return hash_equals($signature,$requestSignature);
    }





    public function get_authorization() {
        
        // $date=new DateTime();
        // $d=$date->format("Y-m-d H:i:s");
        $ch = curl_init();
        // https://api.ezpaypin.com/vendors/v1/auth/token/catalogs/".$sku."/availability/
        curl_setopt($ch, CURLOPT_URL,"https://api.ezpaypin.com/vendors/v1/auth/token/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            // 'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->api_info);
    
        
        $content = curl_exec($ch);

        if($content){
            $this->token= json_decode($content)->access;
            $this->last_time_token=new \DateTime("now");
            $this->token_validity=json_decode($content)->expire*0.001;
            // echo("expire in :".json_decode($content)->expire);
            // var_dump(json_decode($content)->access);
            curl_close($ch);
            // return ;
            // return $content;
        }else{
            return curl_error($ch);
            curl_close($ch);
        }
    
    }

    // Retreive payment request
    public function retrieve_request($ref){
        
        $req = "select * from payment_txn where ref='$ref'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){

            // Execute Tabby retrieve request API call
            $this->method = "GET";
            $this->endpoint = "payments/".$ref;
            $this->header_key = $this->api_info["secret_key"]; 
            
            $tabby_request = json_decode($this->get_result());
            // var_dump($tabby_request);die();
            if(isset($tabby_request->status)){
                $pdata = [
                    "transaction_message" => $tabby_request->status
                ];

                if($tabby_request->status = "AUTHORIZED"){
                    $pdata["status"] = "Paid";
                    $this->userModel->do_action("payment_txn" , $res[0]->ref , "ref" , "update" , $pdata , "");
                    $capture = $this->tabby_capture_request($res[0]->ref , $tabby_request->amount);
                    return true;
                }

            }
        }

        return false;
    }

    // Capture Tabby payment
    public function paytab_capture_request($id , $amount){
        
        $this->method = "POST";
        $this->endpoint = "payments/$id/captures";
        $this->version = "v1";
        $this->header_key = $this->api_info["secret_key"];

        $tabby_capture = $this->get_result(json_encode(["amount" => $amount]));
        // var_dump($tabby_capture);die();
        if(isset($tabby_capture->status) && ($tabby_capture->status == "CLOSED" || $tabby_capture->status == "AUTHORIZED")){
            $this->userModel->do_action("payment_txn" , $id , "ref" , "update" , ["transaction_message" => $tabby_capture->status] , "");
            return true;
        }

        return false;
    } 

    // Process Tabby refund
    public function paytab_refund($id , $amount){

        
        $this->method = "POST";
        $this->endpoint = "payments/$id/refunds";

        $tabby_refund = $this->get_result(["amount" => $amount]);
    }

    // Close Tabby payment
    public function paytab_close_payment($id){

        $this->method = "POST";
        $this->endpoint = "payments/$id/close";

        $tabby_refund = $this->get_result();

    }

    // Register a Webhook
    public function register_webhook($url){

        $this->endpoint = "webhooks";
        $this->method = "POST";
        $this->version = "v1";
        $this->header_key = $this->api_info["secret_key"];

        $headers = ["X-Merchant-Code: ".TABBY_MERCHANT_CODE];
        $data = [
            "url" => $url,
            "is_test" => true,
        ];

        $result = json_decode($this->get_data(json_encode($data) , $headers));
        if(!is_null($result) && isset($result->id)){
            return $result;
        }

        return null;

    }

    // Retreive Webhooks
    public function retreive_webhooks(){

        $this->endpoint = "webhooks";
        $this->method = "GET";
        $this->version = "v1";
        $this->header_key = $this->api_info["secret_key"];

        $headers = ["X-Merchant-Code: ".TABBY_MERCHANT_CODE];

        $result = json_decode($this->get_data(null , $headers));
        if(!is_null($result) && sizeof($result) > 0){
            return $result;
        }

        return null;
    }

    // Update Webhook
    public function update_webhook($id , $url , $test=false){

        $this->endpoint = "webhooks/$id";
        $this->method = "PUT";
        $this->version = "v1";
        $this->header_key = $this->api_info["secret_key"];

        $headers = ["X-Merchant-Code: ".TABBY_MERCHANT_CODE];
        $data = [
            "url" => $url,
            "is_test" => $test,
        ];

        $result = json_decode($this->get_data(json_encode($data) , $headers));
        if(!is_null($result)){
            return $result;
        }

        return null;

    }

}