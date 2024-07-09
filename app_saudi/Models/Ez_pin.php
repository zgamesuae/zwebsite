<?php 
namespace App\Models;
use CodeIgniter\Model;


class Ez_pin extends Model{

    private $api_info=array(
        // test credential
        "client_id"=>"1554897",
        "secret_key"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzayI6IjY2MThlMzFiLWQ5YjktNGY1YS1iMDk0LTQwN2FkNjViMGQ0NSJ9.Z5tH0qr-bQQoS_AIGdOCHonBSohfye8fciwNxahu4Ag"

        //  "client_id"=>"1554897",
        // "secret_key"=>"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzayI6IjBmNmJkYmEzLTk4NTUtNGNmNy05MzhlLTRjOTUzNjE2NjkxNyJ9.Zj58TuqkiOrKk71iO_nduUrrpV3-NVlAxwCsXUYXmis"
    );
    public $endpoint;
    public $method;
    public $result;
    private $token;
    private $last_time_token;
    private $token_validity;
    public $userModel;

    public function __construct($endpoint = "" , $method = "GET"){
        $this->endpoint=$endpoint;
        $this->method=$method;
        $this->get_authorization();
        $this->userModel = model("App\Models\UserModel");
    }

    public function get_data($data = null) {
        // $date=new DateTime();
        // $d=$date->format("Y-m-d H:i:s");
        // if($this->is_token_expired())
        // $this->get_authorization();

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

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer ".$this->token,
            // 'Content-Type: application/json'
            // 'Content-Length: ' . sizeof($post_string),
        ));
    
        
        $content = curl_exec($ch);
        if($content){
            curl_close($ch);
            return json_decode($content);
            // return $content;
        }else{
            curl_close($ch);
            return curl_error($ch);
            // return "error";
        }
    
    }

    public function get_result($data = null){
        // $data=array(
        //     "sku"=>$sku,
        //     "quantity"=>1,
        //     "pre_order"=>"false",
        //     "price"=>$price,
        //     "pin"=>7777
        // );
        
        // 
        $res=$this->get_data($data);
        return $res;

    }


    public function is_token_expired(){
        $date=new \DateTime("now");
        $d1=$this->last_time_token->format("s");
        $d2=$date->format("s");
        if(($d2-$d1) < $this->token_validity)
        return false;
        else
        return true;
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

    public function ezpin_get_catalogs_availabity($sku , $quantity , $price){
        $this->endpoint = "catalogs/$sku/availability/";
        $data=array(
            "item_count" => (int)$quantity,
            "price" => $price
        );
    
        $result = $this->get_result($data)->availability;
        // var_dump($sku , $data , $result);die();
        if(!is_null($result) && $result)
        return true;
    
        return false;
    }

    public function ezpin_create_order($details , $digital_codes){
        $session = session();
        $this->endpoint = "orders/";
        $this->method = "POST";
        $codes = array();

        foreach($digital_codes as $digital_code){
            $data = [
                "sku" => $digital_code->sku,
                "quantity" => (int)$digital_code->quantity,
                "pre_order" => ($digital_code->pre_order_enabled == "Yes") ? 0 : 0,
                "price" => (float)$digital_code->ez_price,
                "delivery_type" => 1,
                "destination" => $details["email"],
                "reference_code" => $this->guidv4(),
                "terminal_pin"=>"7777"

            ];

            $result = $this->get_result($data);
            // var_dump($result);die();
            if(!is_null($result)){
                if(isset($result->status)){
                    $session->setFlashdata("Success" , "Operation succeded!");
                    $code = [
                        "product_id" =>  $digital_code->product_id,
                        "order_id" => $details["order_id"],
                        "reference_code" => $data["reference_code"],
                        "share_link" => $result->share_link,
                        "status_text" => $result->status_text,
                        "price" => $digital_code->ez_price,
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
                $session->setFlashdata("Error" , "Operation failed");
            }
            
        }
        // var_dump($codes);die();

        $this->save_ezpin_order_codes($codes);
        // var_dump($return);die();
        return $codes;
    }

    public function ezpin_get_card_info($reference_code){
        $this->endpoint = "orders/$reference_code/cards/";
        $this->method = "GET";

        $result = $this->get_result();

        if(!is_null($result->results) && sizeof($result->results) > 0)
        return $result->results;

        else return null;
    }

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

    // Get the catalog full list
    public function ezpin_get_full_catalogs($offset = 0 , $limit = 100){
        $this->endpoint = "catalogs/";
        $data=array(
            "offset" => $offset,
            "limit" => $limit,
        );

        $result = $this->get_result($data)->results;
        // var_dump($result);

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
        
        $reg = [];
        if(is_array($regions) && sizeof($regions) > 0 ){
            foreach($regions as $region)
            array_push($reg , $region->name);
        }
        else array_push($reg , $regions->name);
        return implode("," , $reg);
    }

    // Create EZPIN digital code in the ZGames database
    public function zg_ezpin_create_catalog($catalog , $image){
        
        $product = $this->userModel->do_action("products" , "" , "" , "insert" , $catalog , "");
        $img = $this->save_ezpin_catalog_image($image);
        if($img)
        $this->userModel->do_action("product_image" , "" , "" , "insert" , ["product" => $catalog["product_id"] , "image" => $img] , "");
    }

    // Update the Zgames digital code from EZpin catalog
    public function zg_ezpin_catalog_update(){
        
        $catalog = $this->ezpin_get_full_catalogs(0, 150);
        $session = session();
        // var_dump($catalog);die();

        if($catalog && sizeof($catalog) > 0){
            foreach ($catalog as $key => $value) {
                # code...
                $rate = $this->zg_get_currency_exchange_rate($value->currency->code , CURRENCY);
                $local_p = ($value->min_price == $value->max_price) ? ($value->max_price * $rate) : ($value->min_price * $rate);
                $ez_price = ($value->min_price == $value->max_price) ? $value->max_price : $value->min_price;
                $stock = (!$this->ezpin_get_catalogs_availabity($value->sku , 2 , $ez_price)) ? "0" : "50";

                if(!$this->zg_ezpin_catalog_exist($value->sku)){
                    if (strlen($value->title) > 28) {
                        $product_id = url_title(substr($value->title, 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                    } 
                    else {
                        $product_id = url_title($value->title, '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                    }

                    $rate = $this->zg_get_currency_exchange_rate($value->currency->code , CURRENCY);
                    $local_p = ($value->min_price == $value->max_price) ? ($value->max_price * $rate) : ($value->min_price * $rate);
                    $ez_price = ($value->min_price == $value->max_price) ? $value->max_price : $value->min_price;
                    $stock = (!$this->ezpin_get_catalogs_availabity($value->sku , 2 , $ez_price)) ? "0" : "50";

                    $this->zg_ezpin_create_catalog(
                        [
                            "product_id" => $product_id,
                            "sku" => $value->sku, 
                            "name" => $value->title, 
                            "price" => $local_p,
                            "ez_price" => $ez_price, 
                            "price_fixed" => ($value->min_price == $value->max_price) ? "Yes" : "No",
                            "pre_order_enabled" => ($value->pre_order) ? "Yes" : "No", 
                            "description" => $this->ezpin_catalog_desc_tostring($value->description), 
                            "type" => "6",
                            "discount_percentage" => $value->percentage_of_buying_price, 
                            "currency" => $value->currency->code,
                            "regions" => $this->ezpin_catalog_regions_tostring($value->regions),
                            "max_qty_order" => 5,
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
                        "ez_price" => $ez_price, 
                        "pre_order_enabled" => ($value->pre_order) ? "Yes" : "No",
                        "discount_percentage" => $value->percentage_of_buying_price,
                        "description" => $this->ezpin_catalog_desc_tostring($value->description), 
                        "type" => "6",
                        "available_stock" => $stock,
                        "max_qty_order" => 5,

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
            $session->setFlashData("Success" , "Successful operation!");
        }
        else 
        $session->setFlashData("Error" , "Operation failed, No data retrieved from EZPIN.");
    }

    // Download EZPIN catalog image
    public function save_ezpin_catalog_image($url){
        $infos = pathinfo($url);
        $destination = ROOTPATH."/assets/uploads/".$infos["filename"].".".$infos["extension"]; 
        $imageData = file_get_contents($url);

        if ($imageData !== false){
            file_put_contents($destination, $imageData);
            return $infos["filename"].".".$infos["extension"];
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
        foreach ($result->results as $key => $value) {
            # code...
            echo("from_currency: ".$value->from_currency->code." | to_currency: ".$value->to_currency->code." | rate: $value->rate <br>");
        
        }
        if(!is_null($result))
        return $result;
    
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
        
        $req = "select rate from ezpin_currency_exchange where from_code='".$from_code."' AND to_code='".$to_code."'";
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0)
        return (float)$res[0]->rate;
    
        return 1;
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

}

?>