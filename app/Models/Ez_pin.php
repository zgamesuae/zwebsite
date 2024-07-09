<?php 
namespace App\Models;
use CodeIgniter\Model;


class Ez_pin extends Model{

    private $api_info=array(
        // test credential
        // "client_id"=>"1554897",
        // "secret_key"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzayI6IjY2MThlMzFiLWQ5YjktNGY1YS1iMDk0LTQwN2FkNjViMGQ0NSJ9.Z5tH0qr-bQQoS_AIGdOCHonBSohfye8fciwNxahu4Ag",
        
        "client_id"=>"1523690",
        // Production
        "secret_key"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzayI6ImYyODVkYmYyLTU2NDAtNGMzMS1hOGY1LTRlOTg1ZjYwZTgxNyJ9.H2NCyyN3J4xooU2LZzGKkcU732lnxmNGjgz5rCI0BcI",
        // Sandbox
        // "secret_key"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzayI6IjgwMjA4NzY5LTVhM2YtNDdmMi04ODQ1LTE5MjBlNTViMjkwMiJ9.DUCvuMjmFYBFfwJy-vEvVyjx3x11pP7aYbp4l172nuc",
    );
    private $terminal_pin = "4752";
    public $endpoint;
    public $method;
    public $result;
    private $token;
    private $last_time_token;
    private $token_validity;
    private $confidential_key;
    public $userModel;
    public $productModel;
    
    public function __construct($endpoint = "" , $method = "GET"){
        $this->endpoint=$endpoint;
        $this->method=$method;
        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");
        $res = $this->userModel->customQuery("select * from ezpin_api where id=1");
        $this->token = (is_null($res) || sizeof($res) == 0 || empty($res[0]->token)) ? null : $res[0]->token;
        $this->confidential_key = (is_null($res) || sizeof($res) == 0 || empty($res[0]->token)) ? null : $res[0]->confidential_key;
        // $this->token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhY2Nlc3NfaWQiOjU4LCJleHAiOjE3MTQ1ODI5MTIsInByb3RlY3Rfa2V5IjoiQzZERjBGNERFQjA4OTI3MDVGNDI4OUYxQzFEOTFGREIiLCJ1c2VyX2lkIjoyMzQ4LCJtZXJjaGFudF9pZCI6MzM2Nn0.0SE0NV1ewLtJhsPdI3AHErxJCM_Dj2m0W1RvZMjGHcg";
    }

    public function get_data($data = null) {

        $post_string = $data;

        
        $ch = curl_init();
        if($this->method=="POST"){
            curl_setopt($ch, CURLOPT_URL,"https://api.ezpaypin.com/vendors/v2/".$this->endpoint);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        }
        else{
            if($post_string!==null)
            curl_setopt($ch, CURLOPT_URL,"https://api.ezpaypin.com/vendors/v2/".$this->endpoint."?".http_build_query($post_string));
            else
            curl_setopt($ch, CURLOPT_URL,"https://api.ezpaypin.com/vendors/v2/".$this->endpoint);
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . $this->token,
            'Content-Type: application/json'
        ));
        
        
        $content = curl_exec($ch);
        // var_dump($content);die();
        if($content){
            curl_close($ch);
            return json_decode($content);
        }
        else{
            return curl_error($ch);
            curl_close($ch);
        }
    
    }

    public function get_result($data = null){

        $this->check_token();
        $res=$this->get_data($data);
        return $res;

    }


    public function is_token_expired(){
        $res = $this->userModel->customQuery("select * from ezpin_api where id=1");

        if(is_null($res) || sizeof($res) == 0 || empty($res[0]->token))
        return true;

        else{
            // $last_time_token = $res[0]->last_time_token;
            // $validity = $res[0]->token_validity;
            // $date=new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
            // $last_time = new \DateTime( $last_time_token , new \DateTimeZone(TIME_ZONE));
            // $diff = $date->diff($last_time);
            // $seconds = ($diff->d*24*60*60) + $diff->h*60*60 + $diff->i*60 + $diff->s;

            // if($seconds > $validity && false){
            //     return true;
            // }

            $this->token = $res[0]->token;
            return false;
        }
    }

    public function check_token() {
        $status = false;

        if(!is_null($this->token) || !empty($this->token)) {

            $status = $this->retreive_webhooks();

            if(is_null($status)) {
                $this->get_authorization();
            }
        } else {
            $this->get_authorization();
        }

        return $status !== false;
        
    }

    public function get_authorization() {

        // sleep(1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.ezpaypin.com/vendors/v2/auth/token/");
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->api_info);
        

        $content = curl_exec($ch);
        // var_dump($content);die();

        if($content){
            $this->token= json_decode($content)->access;
            $this->last_time_token=new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
            $this->token_validity=json_decode($content)->expire*0.001;
            $data = [
                "token"=>$this->token ,
                "last_time_token"=>$this->last_time_token->format("Y-m-d H:i:s") ,
                "token_validity"=>$this->token_validity
            ];
            $this->userModel->do_action("ezpin_api" , 1 , "id" , "update" , $data , "");
            curl_close($ch);
            return $content;

        }
        else{
            curl_close($ch);
            return curl_error($ch);
        }
    
    }

    function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
    
        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    
        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }



    // Create EZpin order
    public function ezpin_create_order($details , $digital_codes){
        $session = session();
        $this->endpoint = "orders/";
        $this->method = "POST";
        $codes = array();
        foreach($digital_codes as $digital_code){
            $data = [
                "sku" => $digital_code->sku,
                "quantity" => (int)$digital_code->quantity,
                "pre_order" => ($digital_code->pre_order_enabled == "Yes") ? 1 : 0,
                "price" => (float)$digital_code->ez_price,
                "delivery_type" => 1,
                "destination" => $details["email"],
                "reference_code" => $this->guidv4(),
                "terminal_pin"=> $this->terminal_pin
            ];

            $result = $this->get_result(json_encode($data));
            if(!is_null($result)){
                if(isset($result->status)){
                    $session->setFlashdata("Success" , "Operation succeded!");
                    $code = [
                        "product_id" =>  $digital_code->product_id,
                        "order_id" => $details["order_id"],
                        "reference_code" => $data["reference_code"],
                        "share_link" => $result->share_link,
                        "price" => $digital_code->ez_price,
                        "status_text" => $result->status_text,
                        "ez_order_id" => $result->order_id,
                    ];
                }
                else if(isset($result->code) && $result->code == "788"){
                    $session->setFlashdata("Error" , "The transaction was rejected by EZPIN");

                    $code = [
                        "product_id" =>  $digital_code->product_id,
                        "order_id" => $details["order_id"],
                        "price" => $digital_code->ez_price,
                        "status_text" => "reject",
                    ];
                }
                else{
                    $session->setFlashdata("Error" , "Unknown Error occured");
                }

                if(isset($digital_code->order_code_id)){
                    $code["order_code_id"] = $digital_code->order_code_id;
                }
                array_push($codes ,  $code);
            }   
            else{
                $session->setFlashdata("Error" , "Operation failed on ordering code(s), kindly <a href='".base_url()."/contact-us'>contact</a> our agents");
            }
        }

        $this->save_ezpin_order_codes($codes);
        return $codes;
    }

    // Save EZpin Order Codes
    public function save_ezpin_order_codes($codes){
        if(sizeof($codes) > 0){
            foreach($codes as $code){
                if(!isset($code["order_code_id"])){
                    $this->userModel->do_action("ezpin_codes_order" , "" , "" , "insert" , $code , "");
                }
                else{
                    $code_order_id = $code["order_code_id"];
                    unset($code["order_code_id"]);
                    $this->userModel->do_action("ezpin_codes_order" , $code_order_id , "id" , "update" , $code  , "");
                }
            }
        }

    }

    // Get ZGames digital order reference code
    public function zg_get_order_digital_by_ez_order_id($order_id){

        $req = "select * from ezpin_codes_order where ez_order_id='$order_id'";
        $res = $this->userModel->customQuery($req);

        return (!is_null($res) && sizeof($res) > 0) ? $res[0] : null;
    }

    // Update EZpin Order
    public function ezpin_update_order_status($data){

        if(sizeof($data) > 0 && isset($data["ez_order_id"])){
            $ez_order_id = $data["ez_order_id"];
            unset($data["ez_order_id"]);

            if($data["status_text"] == "accept"){
                $zg_digital_order = $this->zg_get_order_digital_by_ez_order_id($ez_order_id);
                $ez_digital_info = $this->ezpin_get_order_info($zg_digital_order->reference_code);
                if(!is_null($ez_digital_info)){
                    $data["share_link"] = $ez_digital_info->share_link;
                }
            }

            $res = $this->userModel->do_action("ezpin_codes_order" , $ez_order_id , "ez_order_id" , "update" , $data , "");
            if(!is_null($res) && $res)
            return true;
        }

        return false;
    }

    // Get EZpin Order Info
    public function ezpin_get_order_info($reference_code){
        $this->endpoint = "orders/$reference_code/";
        $this->method = "GET";

        $result = $this->get_result();
        if(!is_null($result))
        return $result;

        else return null;
    }

    // Get order code info
    public function ezpin_get_card_info($reference_code){
        $this->endpoint = "orders/$reference_code/cards/";
        $this->method = "GET";

        $result = $this->get_result();

        if(!is_null($result->results) && sizeof($result->results) > 0)
        return $result->results;

        else return null;
    }

    // get Order details of pending orders
    public function zg_digital_orders_list($status){
        
        $req = "select * from ezpin_codes_order where status_text='$status'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            return $res;
        }

        return [];
        
    }

    // Update EZpin pending orders
    public function update_pending_orders(){
        $pending_orders = $this->zg_digital_orders_list("pending");

        foreach ($pending_orders as $order) {
            # code...
            $ez_digital_info = $this->ezpin_get_order_info($order->reference_code);
            // var_dump($ez_digital_info);
            // if($ez_digital_info->status_text !== $order->status_text)
            $data = [
                "status_text" => $ez_digital_info->status_text ,
                "share_link" => (!empty($ez_digital_info->share_link)) ? $ez_digital_info->share_link : null 
            ];
            $res = $this->userModel->do_action("ezpin_codes_order" , $ez_digital_info->order_id , "ez_order_id" , "update" , $data , "");
            // sleep(0.8);
        }

    }



    // Check Catalog availability
    public function ezpin_get_catalogs_availabity($sku , $quantity , $price){
        $this->endpoint = "catalogs/$sku/availability/";
        $data=array(
            "item_count" => (int)$quantity,
            "price" => $price
        );
    
        $result = $this->get_result($data)->availability;
        if(!is_null($result) && $result)
        return true;
    
        return false;
    }

    // Get catalog full list
    public function ezpin_get_full_catalogs($offset = 0 , $limit = 100){
        $this->endpoint = "catalogs/";
        $data=array(
            "offset" => $offset,
            "limit" => $limit,
        );

        $result = $this->get_result($data)->results;
        // var_dump($result);die();

        if(!is_null($result)){
            // foreach ($result as $key => $value) {
            //     # code...
            //     echo("sku: $value->sku | Preorder: $value->pre_order | UPC: $value->upc | title: $value->title | min price: $value->min_price | max price: $value->max_price | price: ".$value->showing_price->price." | currency: ".$value->currency->code." | image: $value->image<br>");
            // }
            return $result;
        }

        return null;
    }

    // Check if the ezpin digital code is listed in the zgames database
    public function zg_ezpin_catalog_exist($sku){
        
        $req = "select count(sku) as nbr from products where sku='$sku'";
        $res = $this->userModel->customQuery($req);

        if(sizeof($res) > 0 && $res[0]->nbr > 0)
        return true;

        return false;
    }

    // Transform catalog regions to storig
    public function ezpin_catalog_regions_tostring($regions){
        
        $ids = [];
        $titles = [];
        if(is_array($regions) && sizeof($regions) > 0 ){
            foreach($regions as $region){
                array_push($ids , $this->zg_save_region($region->name));
                array_push($titles , $region->name);
            }
        }
        else{
            array_push($ids , $this->zg_save_region($regions->name));
            array_push($titles , $regions->name);
        } 
        return ["ids" => implode("," , $ids) , "titles" => implode("," , $titles)];
    }

    // Create EZPIN digital code in the ZGames database
    public function zg_ezpin_create_catalog($catalog , $image_url){
        
        // Save CODE Product
        if(true);
        $product = $this->userModel->do_action("products" , "" , "" , "insert" , $catalog , "");
        
        if(!empty($image_url) && !is_null($image_url) && true){
            $infos = pathinfo($image_url);
            $file = (empty($infos["filename"]) || is_null($infos["filename"])) ? "ezpin_".$catalog["sku"] : $infos["filename"];
            $file .= ".".$infos["extension"];

            // Save DIGITAL-CODE Image file
            if(!file_exists(ROOTPATH."/assets/uploads/" . $file) && false){
                $img = $this->save_ezpin_catalog_image($image_url , $file);
                // if($img)
            }

            // Save DIGITAL-CODE Image DB
            if(!$this->productModel->product_image_exist($catalog["sku"] , $file) && !empty($file))
            $this->userModel->do_action("product_image" , "" , "" , "insert" , ["product" => $catalog["product_id"] , "image" => $file] , "");
        }
    }

    // Update the Zgames digital code from EZpin catalog
    public function zg_ezpin_catalog_update(){
        
        $catalog = $this->ezpin_get_full_catalogs(0, 250);
        $session = session();

        if($catalog && sizeof($catalog) > 0){
            foreach ($catalog as $key => $value) {
                if(!is_null($value)){

                    # code...
                    $rate = $this->zg_get_currency_exchange_rate($value->currency->code , CURRENCY);
                    $local_p = ($value->min_price == $value->max_price) ? ($value->max_price * $rate) : ($value->min_price * $rate);
                    $ez_price = ($value->min_price == $value->max_price) ? $value->max_price : $value->min_price;
                    $regions = $this->ezpin_catalog_regions_tostring($value->regions);
                    // $stock = (!$this->ezpin_get_catalogs_availabity($value->sku , 2 , $ez_price)) ? "0" : "50";
                    $stock = 10;
                    if(!$this->zg_ezpin_catalog_exist($value->sku)){
                        if (strlen($value->title) > 28) {
                            $product_id = url_title(substr($value->title, 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                        } 
                        else {
                            $product_id = url_title($value->title, '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                        }
                        $this->zg_ezpin_create_catalog(
                            [
                                "product_id" => $product_id,
                                "product_nature" => "Simple",
                                "sku" => $value->sku, 
                                "name" => $value->title . " (".$regions["titles"].") " . "$ez_price ".$value->currency->code,
                                "price" => bcdiv($local_p , 1 , 2),
                                "ez_price" => $ez_price, 
                                "price_fixed" => ($value->min_price == $value->max_price) ? "Yes" : "No",
                                "pre_order_enabled" => ($value->pre_order) ? "Yes" : "No", 
                                "description" => $this->ezpin_catalog_desc_tostring($value->description), 
                                "type" => "6",
                                "discount_percentage" => ($value->percentage_of_buying_price > 0) ? $value->percentage_of_buying_price : null,
                                "discount_type" => ($value->percentage_of_buying_price > 0) ? 'percentage' : 'amount',
                                "currency" => $value->currency->code,
                                "regions" => $regions["ids"],
                                "max_qty_order" => 5,
                                "google_category" => 5032,
                                "available_stock" => $stock,
                                "status" => "Inactive"
                            ]
                            ,
                            $value->image 
                        );
                    }

                    else{
                        $data = [
                            "price" => $local_p,
                            "name" => $value->title . " (".$regions["titles"].") " . "$ez_price ".$value->currency->code,
                            "ez_price" => $ez_price, 
                            "pre_order_enabled" => ($value->pre_order) ? "Yes" : "No",
                            "discount_percentage" => ($value->percentage_of_buying_price > 0) ? $value->percentage_of_buying_price : null,
                            "discount_type" => ($value->percentage_of_buying_price > 0) ? 'percentage' : 'amount',
                            "description" => $this->ezpin_catalog_desc_tostring($value->description), 
                            "regions" => $regions["ids"],
                            "type" => "6",
                            "available_stock" => $stock,
                            "max_qty_order" => 5,
                            // "status" => "Active"

                        ];
                        $this->userModel->do_action(
                            "products" , 
                            $value->sku , 
                            "sku" , 
                            "update" , 
                            $data , 
                            ""
                        );
                    }
                }
            }
            $session->setFlashData("Success" , "Successful operation!");
        }
        else 
        $session->setFlashData("Error" , "Operation failed, No data retrieved from EZPIN.");
    }

    // Download EZPIN catalog image
    public function save_ezpin_catalog_image($url , $file){
        $destination = ROOTPATH."/assets/uploads/".$file; 
        $imageData = file_get_contents($url);

        if ($imageData !== false){
            file_put_contents($destination, $imageData);
            return $file;
        }

        return false;
    }

    // Organize EZPIN catalog description
    public function ezpin_catalog_desc_tostring($description){
        $desc = "";

        $content = json_decode($description);
        if(isset($content->content) && sizeof($content->content) > 0){
            foreach ($content->content as $value) {
                # code...
                $desc .= "<p><b>$value->title</b></p>";
                $desc .= "<p>$value->description</p>";
            }
        }


        return $desc;
    }





    // get the exchange Rates
    public function ezpin_exchange_rates(){
        $this->endpoint = "exchange_rates/";
        $result = $this->get_result();

        if(!empty($result)){
            foreach ($result->results as $key => $value) {
                # code...
                echo("from_currency: ".$value->from_currency->code." | to_currency: ".$value->to_currency->code." | rate: $value->rate <br>");
            
            }
            return $result;
        }
    
        return null;
    }
    
    // Check currency exchange exit
    public function zg_currency_exchange_exist($from_code , $to_code){
        
        $req = "select count(rate) as nbr from ezpin_currency_exchange where from_code='$from_code' and to_code='$to_code'";
        $res = $this->userModel->customQuery($req);
    
        if(sizeof($res) > 0)
        return ($res[0]->nbr > 0);
    
        return false;
    }
    
    // update currency exchange rates table
    public function zg_currency_exchange_update(){
        
        $rates = $this->ezpin_exchange_rates();
        if(!is_null($rates)){   
            foreach($rates->results as $value){
                if($this->zg_currency_exchange_exist($value->from_currency->code , $value->to_currency->code)){
                    $req = "
                        update ezpin_currency_exchange 
                        set rate = $value->rate 
                        where from_code ='". $value->from_currency->code."' 
                        AND to_code='".$value->to_currency->code."'";
                    $this->userModel->customQuery($req);
                }
            
                else{
                    $data = [
                        "from_code" => $value->from_currency->code,
                        "to_code" => $value->to_currency->code,
                        "rate" => $value->rate,
                    ];
                
                    $res = $this->userModel->do_action("ezpin_currency_exchange" , "" , "" , "insert" , $data , "");
                }
            
            
            }
        }
    }
    
    // get exchange rate
    public function zg_get_currency_exchange_rate($from_code , $to_code){
        
        // $req = "select rate from ezpin_currency_exchange where from_code='".$from_code."'";
        // $res = $this->userModel->customQuery($req);
        // if(!is_null($res) && sizeof($res) > 0){
        //     $req = "select rate from "
        //     return (float)$res[0]->rate;
        // }
    
        // return 1;

        $rate = 1;
        switch ($from_code == "USD") {
            case false:
                # code...
                // Original Currency is Not DOllar
                $ext_rate_req = "select rate from ezpin_currency_exchange where to_code='$from_code'";
                $local_rate_req = "select rate from ezpin_currency_exchange where to_code='$to_code'";
                
                $ext_rate_res = $this->userModel->customQuery($ext_rate_req);
                $local_rate_res = $this->userModel->customQuery($local_rate_req);

                if((!is_null($ext_rate_res) && !is_null($local_rate_req)) && (sizeof($ext_rate_res) > 0 && sizeof($local_rate_res) > 0))
                $rate = (float)($local_rate_res[0]->rate / $ext_rate_res[0]->rate);
            break;
            
            default:
                # code...
                $req = "select rate from ezpin_currency_exchange where from_code='".$from_code."' and to_code='$to_code'";
                $res = $this->userModel->customQuery($req);
                if($res && sizeof($res) > 0)
                $rate = $res[0]->rate;
            break;
        }
        
        
        return $rate;

    }

    // get failed ordered code by id
    public function get_failed_ordered_code($order_code_id){
        
        $req = "
        select 
        ezpin_codes_order.id as order_code_id,
        products.sku,
        products.pre_order_enabled,
        ezpin_codes_order.price as ez_price,
        order_products.quantity,
        products.product_id 
        from ezpin_codes_order inner join products on ezpin_codes_order.product_id = products.product_id 
        inner join order_products on ezpin_codes_order.product_id=order_products.product_id 
        where ezpin_codes_order.id=$order_code_id 
        AND ezpin_codes_order.status_text='reject'
        ";
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            return $res;
        }

        return [];
    }


    // Regions
    public function zg_save_region($region){
        $id = "";

        $req = "select * from ezpin_regions where title='$region'";
        $res = $this->userModel->customQuery($req);

        if(empty($res) || sizeof($res) == 0){
            $id = $this->userModel->do_action("ezpin_regions" , "" , "" , "insert" , ["title" => $region] , "");
        }
        else{
            $id = $res[0]->id;
        }

        return $id; 
    }


    // Register Webhook
    public function register_webhook($url){
        $this->endpoint = "notification_config/";
        $this->method = "POST";
        $data = [
            "endpoint" => $url,
            "confidential_key" => $this->confidential_key
        ];
        
        $result = $this->get_result();
        if(!is_null($result) && $result->code == 801)
        return true;

        return false;
    }

    // Get EZpin Registred Webhooks
    public function retreive_webhooks(){
        $status = 0;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.ezpaypin.com/vendors/v2/notification_config/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $this->token));

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status == 200)
        return json_decode($result);
        
        return null;
    }

}

?>