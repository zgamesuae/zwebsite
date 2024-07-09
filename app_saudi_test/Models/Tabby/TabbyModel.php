<?php 
namespace App\Models\Tabby; 
use CodeIgniter\Model;


class TabbyModel extends Model{

    private $api_info=array(
        // test credential
        "merchant_code"=> TABBY_MERCHANT_CODE,
        "secret_key"=> TABBY_SECRET_KEY,
        "public_key"=> TABBY_PUBLIC_KEY
    );

    public $userModel;
    public $endpoint;
    public $method;
    public $result;
    private $token;
    private $last_time_token;
    private $token_validity;
    private $header_key;
    private $version = "v2";

    public function __construct($endpoint = "" , $method = "GET"){
        $this->endpoint=$endpoint;
        $this->method=$method;
        $this->get_authorization();
        $this->header_key = $this->api_info["public_key"];
        $this->userModel = model("App\Models\UserModel");
    }


    public function get_data($data = null , $hdrs = []) {
        // $date=new DateTime();
        // $d=$date->format("Y-m-d H:i:s");
        // if($this->is_token_expired())
        // $this->get_authorization();
        $headers =  array(
            "Authorization: Bearer ".$this->header_key,
            'Content-Type: application/json',
            // 'Content-Length: ' . sizeof($post_string),
        ); 

        $headers = array_merge($headers , $hdrs);
        $post_string = $data;
        $ch = curl_init();
        if($this->method=="POST" || $this->method=="PUT"){
            curl_setopt($ch, CURLOPT_URL,"https://api.tabby.ai/api/$this->version/".$this->endpoint);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        }
        else{
            if($post_string!==null)
            curl_setopt($ch, CURLOPT_URL,"https://api.tabby.ai/api/$this->version/".$this->endpoint."?".http_build_query($post_string));
            else
            curl_setopt($ch, CURLOPT_URL,"https://api.tabby.ai/api/$this->version/".$this->endpoint);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
    
        
        $content = curl_exec($ch);
        if($content){
            curl_close($ch);
            // return json_decode($content);
            return $content;
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

    // Preparing data structure for API calls
    public function structure_data($cart , $order , $user_address , $user_id , $scoring = true){
        
        $orderModel = model("App\Models\OrderModel");
        $productModel = model("App\Models\ProductModel");

        $user_infos = $this->userModel->get_user_infos($user_id);
        // $reference_id = $orderModel->user_cart_id($user_id); 

        // Creating the ORDER ID
        $reference_id = time() . rand(0, 9);
        $items = [];

        $offer_discounts = array_filter($order["offers"] , function($offer){
            return (($offer["value"]) > 0);
        });

        $discount = 0;
        array_walk($offer_discounts , function($offer)use(&$discount){
            $discount += $offer["value"];
        });

        // Loop on user cart's product and construct it's data structure
        foreach($cart as $product){
            $cart_price = $orderModel->cart_product_price($product->id);
            $item = [
                "title" => $cart_price["product_name"],
                "quantity" => (int)($cart_price["quantity"]),
                "unit_price" => ($cart_price["original_price"]),
                "discount_amount" => (string)($cart_price["original_price"] - $cart_price["price"]),    
                "reference_id" => $product->product_id,
                // "product_url" => $productModel->getproduct_url($product->product_id),    
                "category" => $productModel->get_product_top_level_category($product->product_id)
            ];
            array_push($items , $item);
        }

        $session_body_request = [
            "payment" => [
                "amount" => (string)$order["order"]["total"],
                "currency" => CURRENCY,
                "buyer" => [
                    "phone" => (true) ? $user_infos->phone : "500000001",
                    "email" => (true) ? $user_infos->email : "card.success@tabby.ai",
                    "name" => (true) ? $user_infos->name : "Yahia abderrahmane",
                ],
                "shipping_address" => [
                    "city" => $orderModel->get_city_name($user_address->city)->title,
                    "address" => "$user_address->street $user_address->apartment_house $user_address->address",
                    "zip" => "00000",
                ],
                "order" => [
                    "shipping_amount" => (string)($order["order"]["charges"]),
                    "discount_amount" => ($order["order"]["coupon_discount"] + $discount),
                    "reference_id" => $reference_id,
                    "items" => $items,
                ],                
            ],
            "lang" => (get_cookie("language") == "AR") ?  "ar" :   "en",
            "merchant_code" => $this->api_info["merchant_code"],
                     
        ];

        // add More Information when api is called for submiting taby payment
        if(!$scoring){
            // Buyer history
            if(!is_null($user_infos) && $user_infos->status == "Active"){
                $session_body_request["payment"]["buyer_history"] = [
                    "registered_since" => (new \DateTime($user_infos->created_at , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d\Th:i:s\Z"),
                    "loyalty_level" => $this->userModel->get_customer_loyalty_level($user_id),
                ];
            }
            
            // User order History
            $user_order_history = $orderModel->user_order_history($user_id);
            if(sizeof($user_order_history) > 0){

                $session_body_request["payment"]["order_history"] = [];

                foreach ($user_order_history as $order) {
                    # code...
                    $user_order_h = [
                        "purchased_at" => $order->created_at,
                        "amount" => $order->total,
                        "status" => $order->status,
                        "buyer" => [
                            "phone" => $order->phone,
                            "email" => $order->email,
                            "name" => $order->name,
                        ],
                        "shipping_address" => [
                            "city" => $orderModel->get_city_name($order->city)->title,
                            "address" => "$order->street $order->apartment_house $order->address",
                            "zip" => "00000",
                        ],
                    ];
                    array_push($session_body_request["payment"]["order_history"] , $user_order_h);
                }
            }
            // ENd User order History

            // Merchant URLs 
            $session_body_request["merchant_urls"] = [
                "success" => site_url("/payment-success/".base64_encode($reference_id)),
                "cancel" => site_url("/checkout"),
                "failure" => site_url("/payment-failed")
            ];
            // END Merchant URLs 

            
            $session_body_request["create_token"] = false;
            $session_body_request["token"] = null;
        }

        return $session_body_request;

    }

    // Pre scoring for checking if customer checkout is eligible for Tabby split in 4
    public function tabby_prescoring($data){

        $this->method = "POST";
        $this->endpoint = "checkout";
    
        $result = json_decode($this->get_result($data));
    
        if(isset($result->status))
        return $result;
    
        return null;
    }

    // Tabby payment processing API call
    public function tabby_payment_processing($data){
        $session = session();
        
        $this->method = "POST";
        $this->endpoit = "checkout";    

        $result = json_decode($this->get_result($data));
        // var_dump($result->payment->id);die();
        if(isset(($result->payment->id))){
            // Save the payment transaction id 
            $pdata = [
                "order_id" => $result->payment->order->reference_id,
                "customer" => $session->get("userLoggedin"),
                "ref" => $result->payment->id,
                "link" => $result->configuration->available_products->installments[0]->web_url,
                "amount" => $result->payment->amount,
                "currency" => $result->payment->currency,
                "description" => "Tabby pay in 4",
                "status" => "Unpaid",
                "transaction_message" => $result->payment->status,
                "email" => $result->payment->buyer->email,
                "name" => $result->payment->buyer->name,
                "mobile" => $result->payment->buyer->phone,
                "line1" => $result->payment->shipping_address->address,
                "city" => $result->payment->shipping_address->city,
                "paymethod" => "Tabby",
                "transaction_ref" => $result->payment->id
            ];

            $this->userModel->do_action("payment_txn" , "" , "" , "insert" , $pdata , "");


            return $result;
        }

        return null;

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

                if($tabby_request->status == "AUTHORIZED"){
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
    public function tabby_capture_request($id , $amount){
        
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
    public function tabby_refund($id , $amount){

        
        $this->method = "POST";
        $this->endpoint = "payments/$id/refunds";

        $tabby_refund = $this->get_result(["amount" => $amount]);
    }

    // Close Tabby payment
    public function tabby_close_payment($id){

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