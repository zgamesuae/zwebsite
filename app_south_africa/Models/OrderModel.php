<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class OrderModel extends Model{
    public $text="yahia";
    private $productModel,$userModel,$offerModel;
    private $offers;
    public function __construct(){
        $this->productModel = model("App\Models\ProductModel");
        $this->userModel = model("App\Models\UserModel");
        $this->offerModel = model("App\Models\OfferModel");
        // $this->offers_list = (new OfferModel())->offers_list;
    }

    // public function cart_product_price($user_id , $product_id , $vat=true){
    public function cart_product_price($cartid , $vat=true){

        // $userModel = model("App\Model\UserModel");
        $offerModel = model("App\Model\OfferModel");
        // $productModel = model("App\Model\ProductModel");
        $orderModel = model("App\Model\OrderModel");
        $session = session();
        $user_id = ($session->get("userLoggedin")) ?? session_id();
        $preorder_price = false;
        $price=$total_price=$gift_wrapping_price=$assemble_professionally=$discount_amount=0;
        $quantity = 1;
        $product_name = "";
        $data_price = [
            "product_name" => $product_name ,
            "price" => $total_price ,
            "original_price" => $price ,
            "preorder_price" => $preorder_price ,
            "gift_wrapping_price" => $gift_wrapping_price ,
            "quantity" => $quantity ,
            "assemble_professionally" => $assemble_professionally,
            "discount_amount" => $discount_amount,
        ];

        $get_cart_element = function($cart , $cartid){
            foreach ($cart as $value) {
                # code...
                if($value->id == $cartid)
                return [$value];
                
            }
        };

        $cart = $orderModel->get_user_cart($user_id);

        // $req = "select products.name,products.price,cart.* from cart inner join products on cart.product_id=products.product_id where cart.user_id='".$user_id."' and cart.product_id='".$product_id."'";
        // $req = "select products.name,products.price,cart.* from cart inner join products on cart.product_id=products.product_id where cart.id=".$cartid;
        // $res = $this->userModel->customQuery($req);

        $res = $get_cart_element($cart , $cartid);
        if($res && sizeof($res) > 0){

            $value = $res[0];
             // if product has options
             $options = $this->productModel->get_product_options(
                $value->product_id,
                explode("," , $value->bundle_opt)
            );
            // var_dump($options);

            $quantity = $value->quantity;

            // product has additional price
            $price= ($options !== false) ? $value->price + $this->productModel->cart_product_bundle_total_additional_price($options) : $value->price ;
            $product_name= ($options !== false) ? lg_put_text($value->name , $value->arabic_name , false).$this->productModel->cart_product_bundle_total_additional_title($options) : lg_put_text($value->name , $value->arabic_name , false) ;


            $discounted = $this->productModel->get_discounted_percentage($this->offerModel->offers_list , $value->product_id);
            $quantity = $value->quantity;                                                               

            // Product is discounted
            $total_price = ($discounted["discount_amount"] > 0) ? $discounted["new_price"]: bcdiv($price, 1, 2);

            // product is on pre-order with percentage
            if($value->pre_order_enabled == "Yes"){
                $preorder_price = ($value->pre_order_before_payment_percentage > 0) ? ($total_price * $value->pre_order_before_payment_percentage / 100) : $total_price;
            }

            // Product has gift wrapping
            if(!is_null($value->gift_wrapping) && trim($value->gift_wrapping) !== ""){
                $gift_wrapping = $this->get_gift_wrapping($value->gift_wrapping);
                $gift_wrapping_price = (sizeof($gift_wrapping) > 0) ? $gift_wrapping[0]->price : 0;
            }

            // Product has assemble professionally
            if( !is_null($value->assemble_professionally_price) && (int)$value->assemble_professionally_price > 0 ){
                $assemble_professionally = $value->assemble_professionally_price;
            }

            $total_product_price = 
                ($value->pre_order_enabled == "Yes" && $value->pre_order_before_payment_percentage > 0) ? 
                $preorder_price * $quantity + $gift_wrapping_price + $assemble_professionally : 
                $total_price * $quantity + $gift_wrapping_price + $assemble_professionally;

            $offers = $this->offerModel->_get_valid_offers($this->offerModel->offers_list , null , $cart);
            $free_products = [];

            foreach($offers as $offer){
                if($this->offerModel->_apply_offer($offer) == "Get_N"){
                    $free_products = $this->offerModel->_get_cart_GetN_products($offer)["free_items"];
                }
                if(sizeof($free_products) > 0 && array_key_exists($res[0]->product_id , $free_products)){
                    $total_product_price -= $free_products[$res[0]->product_id]["qty"] * $free_products[$res[0]->product_id]["price"];
                    break;
                }
            }

            // $free_products = (!is_null($offers[0]) && $this->offerModel->_apply_offer($offers[0]) == "Get_N") ? $this->offerModel->_get_cart_GetN_products($offers[0])["free_items"] : [];

            // If it is GET_N product
            // if(sizeof($free_products) > 0 && array_key_exists($res[0]->product_id , $free_products)){
            //     $total_product_price -= $free_products[$res[0]->product_id]["qty"] * $free_products[$res[0]->product_id]["price"];
            // }

            $data_price["price"] = ($vat) ? $total_price : bcdiv($total_price/1.05 , 1 , 2);
            $data_price["original_price"] = ($vat) ? $price : bcdiv($price/1.05 , 1 , 2);
            $data_price["preorder_price"] = ($vat) ? $preorder_price : bcdiv($preorder_price/1.05 , 1 , 2);
            $data_price["total_product_price"] = ($vat) ? $total_product_price : bcdiv($total_product_price/1.05 , 1 , 2);
            $data_price["product_name"] = $product_name;
            $data_price["gift_wrapping_price"] = $gift_wrapping_price;
            $data_price["assemble_professionally"] = $assemble_professionally;
            $data_price["quantity"] = $quantity;
            $data_price["discount_amount"] = $discounted["discount_amount"];


        }

        return $data_price;
    }

    public function cart_has_coupon_applied($user_id){
        $cart = $this->get_user_cart($user_id);
        $applied = false;
        $coupon = [];
        foreach ($cart as $key => $value) {
            # code...
            if(!is_null($value->coupon_code)){
                $applied = true;
                $coupon = [
                            "coupon_code" => $value->coupon_code,
                            "coupon_value" => $value->coupon_value,
                            "coupon_type" => $value->coupon_type
                ];
                break;
            }
        }

        return ["applied" => $applied , "coupon" => $coupon];
    }

    public function cart_total_coupon_discount($user_id){
        $cart = $this->get_user_cart($user_id);
        $total_discount = 0;

        if($this->cart_has_coupon_applied($user_id)["applied"]){

            foreach ($cart as $key => $product) {
                # code...
                if($product->coupon_type == "Percentage"){
                    $product_price = $this->cart_product_price($product->id);
                    $total_discount += $product_price["price"] * $product->quantity *  $product->coupon_value / 100;
                }
                else if($product->coupon_type == "Amount"){
                    $total_discount = $product->coupon_value;
                }

            }
        }

        return bcdiv($total_discount , 1 , 2);
        
    }

    public function total_cart($user_id,$brand=null,$category=null){
        $total = 0; 
        $userModel = model("App\Models\UserModel");
        $productModel = model("App\Models\ProductModel");
        // $sql = "select *,cart.gift_wrapping as gw from cart inner join products on cart.product_id=products.product_id where cart.user_id='$user_id' and cart.coupon_code is null";
        // $sql = "select products.price,products.discount_percentage,cart.product_id,cart.quantity,cart.discount_rounded,cart.bundle_opt from cart inner join products on cart.product_id=products.product_id where cart.user_id='".$user_id."' and cart.coupon_code is null";

        // $sql = "select products.price,products.discount_percentage,cart.product_id,cart.quantity,cart.discount_rounded,cart.bundle_opt from cart inner join products on cart.product_id=products.product_id where cart.user_id='".$user_id."'";
        $sql = "select products.price,products.discount_percentage,cart.product_id,cart.* from cart inner join products on cart.product_id=products.product_id where cart.user_id='".$user_id."'";

        if($brand!==null)
        $sql.=" AND products.brand='".$brand."'";

        if($category !== null){
            $sql.=" AND (";
            $i=0;
            foreach(explode(",",$category) as $value){
                $sql.=($i == sizeof(explode(",",$category))-1) ? " FIND_IN_SET('".$value."',products.category)" : " FIND_IN_SET('".$value."',products.category) OR";
                $i++;
            }
            $sql.=")";

        }

        $res=$userModel->customQuery($sql);

        if($res){
            
            foreach($res as $key => $value){

                $data_price = $this->cart_product_price($value->id);
                $total_price = $data_price["total_product_price"];
                $total += $total_price;

            }

            return bcdiv($total ,1 ,2);

        }
    }

    public function coupon_discounted_amount($total,$coupon_code){

        $userModel=model("App\Models\UserModel");
        $discounted = 0;

        $req="select * from coupon where coupon_code='".$coupon_code."'";

        $res=$userModel->customQuery($req);

        if($res){
            if ($res[0]->type == "Percentage") {
                $discounted = ($total * $res[0]->value) / 100;
            }
            else
            {
                $discounted = $res[0]->value ;

            }
        }

        // var_dump($discounted);die();

        return $discounted;

        
    }

    public function get_coupon_id($coupon_code){
        $userModel = model("App\Models\UserModel");
        $req="select * from coupon where coupon_code='".$coupon_code."' and status ='Active'";
        $res=$userModel->customQuery($req);
        // var_dump($res);
        if($res){
            return $res[0]->id;
        }

        return null;
    }

    public function get_promo_coupon_code($coupon_id){
        $userModel = model("App\Models\UserModel");
        // $ids=implode(",",$coupon_ids);
        $req="select * from coupon where id='".$coupon_id."' and status ='Active'";
        $res=$userModel->customQuery($req);

        if($res && $res[0]->coupon_type == "one_time_coupon"){
            return $res;
        }

        // var_dump($coupon);

        return false;
    }

    public function can_use_promo_code($min_cart,$user_id){
        $total_cart=$this->total_cart($user_id);
        // var_dump($total_cart);
        if($total_cart >= $min_cart){
            return true;
        }

        return false;
    }

    public function _getproducts_ordered($order_id){
        $userModel=model("App\Models\UserModel");
        $req="select 
        order_products.product_id,
        order_products.quantity,
        order_products.product_name,
        order_products.product_price,
        order_products.discount_percentage,
        order_products.product_original_price,
        order_products.gift_wrapping_price,
        order_products.assemble_professionally_price,
        products.available_stock,
        products.brand,
        products.category from order_products inner join products on order_products.product_id=products.product_id where order_id='".$order_id."'";
        $res=$userModel->customQuery($req);
        // var_dump($res);
        if($res){
            return($res);
        }

        return false;
    }

    public function order_status($order_id){
        $userModel=model("App\Models\UserModel");
        $req="select order_status from orders where order_id='".$order_id."'";
        $res=$userModel->customQuery($req);
        // var_dump($res);
        if($res){
            return($res[0]);
        }

        return false;
    }

    public function _getproductcart_bybrand($user_id){ 
        $userModel = model("App\Model\UserModel");
        $brands_id =array();
        $req="select products.brand from cart inner join products on cart.product_id=products.product_id where user_id='".$user_id."' group by products.brand";
        $res=$userModel->customQuery($req);
        if($res){
            foreach($res as $value)
            array_push($brands_id,$value->brand);
        }

        return $brands_id;
    }

    public function _getproductcart_bycategory($user_id){
        $userModel = model("App\Model\UserModel");
        $cat_id =array();
        $req="select products.category from cart inner join products on cart.product_id=products.product_id where user_id='".$user_id."' group by products.category";
        $res=$userModel->customQuery($req);
        if($res){
            foreach($res as $value){
                
                $cat_id=array_merge($cat_id,explode(",",$value->category));

            }
        }

        return $cat_id;
    }

    public function coupon_exist_onbrand($brand_ids){
        $userModel = model("App\Model\UserModel");
        $brands = implode(",",$brand_ids);
        $codes=array();

        $req="select coupon_code from coupon where on_brand IN (".$brands.") group by on_brand";
        $res=$userModel->customQuery($req);

        if($res){
            foreach($res as $value){
                array_push($codes,$value->coupon_code);
            }
        }
        return $codes;
    }


    public function coupon_exist_ontcart($total_cart,$brands){
        $userModel = model("App\Model\UserModel");
        $codes=array();
        $brands = implode(",",$brands);
        $date = date("Y-m-d");

        $req="select coupon_code from coupon 
        where (min_cart_amount <= '".$total_cart."' OR on_brand in (".$brands.")) 
        AND status='Active' 
        AND '$date' between start_date AND end_date group by coupon_code";
        $res=$userModel->customQuery($req);

        if($res){
            foreach($res as $value){
                array_push($codes,$value->coupon_code);
            }
        }
        return $codes;
    }

    public function get_user_cart($user_id){
     $userModel = model("App\Model\UserModel");

     $req = "select product_image.image,a_cart.* from (select products.name,products.price,products.sku,products.type,cart.* from cart inner join products on cart.product_id=products.product_id where user_id='".$user_id."' group by cart.id) as a_cart inner join product_image on a_cart.product_id=product_image.product group by a_cart.id";
     $res = $userModel->customQuery($req);

     if($res && sizeof($res)>0)
     return $res;
     else
     return []; 

    }

    public function get_users_abondoned_carts($duration){
        $userModel = model("App\Model\UserModel");
        $users= [];

        $req = "select * from (select users.user_id,users.name,users.email,TIMESTAMPDIFF(minute,max(cart.created_at),CURRENT_TIMESTAMP) as diff,count(users.user_id) as product_count from cart inner join users on cart.user_id=users.user_id where users.user_type<>'Guest' group by users.user_id) as custom where custom.diff<".$duration;
        $res = $userModel->customQuery($req);

        if($res && sizeof($res)>0){

            foreach($res as $value){

                array_push($users , array(
                    "id"=>$value->user_id,
                    "name"=>$value->name,
                    "email" => $value->email,
                    "since"=>$value->diff,
                    "product_count"=>$value->product_count,
                ));

            }

        }
        return $users;
    }
    
    public function get_last_order_date($user_id){
        $userModel = model("App\Model\UserModel");
        $req = "select max(created_at) as created_at from orders where user_id='".$user_id."'";
        $res = $userModel->customQuery($req);
        
        if(!is_null($res) && sizeof($res)>0 && $res[0]->created_at!==null){
            return $res[0]->created_at;
        }

        return false;
    }

    public function user_has_order($user_id , $order_id){
        $userModel = model("App\Model\UserModel");

        $req ="select count(user_id) as c from orders where user_id='".$user_id."' and order_id='".$order_id."'";
        $res = $userModel->customQuery($req);

        if($res && $res[0]->c !== 0)
        return true;
        else return false;
    }

    public function get_gift_wrapping($id){
        $userModel = model("App\Model\UserModel");

        $req = "select * from gift_wrapping where id='$id'";
        $res = $userModel->customQuery($req);
        if($res && sizeof($res) > 0){
            return $res;
        }

        return [];

    }

    public function create_order_products($user_id,$cart,$order){
        $status = false;
        $order_products=[];

        foreach($cart as $product){
            $_products=[];
            $product_price = $this->cart_product_price($product->id);
            $gift_wrapping = $this->get_gift_wrapping($product->gift_wrapping);

            $_products["order_id"] = $order["order"]["order_id"];
            $_products["user_id"] = $user_id;
            $_products["product_id"] = $product->product_id;
            $_products["sku"] = $product->sku;
            $_products["product_name"] = $product_price["product_name"];
            $_products["product_image"] = $product->image;
            $_products["product_price"] = ($product_price["preorder_price"] !== false && $product_price["preorder_price"] > 0) ? $product_price["preorder_price"] : $product_price["price"];
            $_products["product_original_price"] = $product_price["original_price"];
            $_products["quantity"] = $product->quantity;

            // check if the cart product has fee quantity
            array_walk($order["offers"] , function($offer , $index) use(&$_products ,&$product){

                if(isset($offer["free_products"]) && is_array($offer["free_products"]) && array_key_exists($product->product_id , $offer["free_products"])){
                    $_products["free_quantity"] = $offer["free_products"][$product->product_id]["qty"];
                    return;
                }
            
            });
            
            $_products["discount_percentage"] = $product->discount_percentage;
            $_products["discount_amount"] = $product_price["discount_amount"];
            $_products["coupon_code"] = $product->coupon_code;
            $_products["coupon_type"] = $product->coupon_type;
            $_products["coupon_value"] = $product->coupon_value;
            $_products["pre_order_enabled"] = $product->pre_order_enabled;
            $_products["pre_order_before_payment_percentage"] = $product->pre_order_before_payment_percentage;
            $_products["gift_wrapping"] = $product->gift_wrapping;
            $_products["gift_wrapping_image"] = (sizeof($gift_wrapping) > 0) ? $gift_wrapping[0]->image : null ;
            $_products["gift_wrapping_price"] = (sizeof($gift_wrapping) > 0) ? $gift_wrapping[0]->price : null ;
            $_products["gift_wrapping_note"] = $product->gift_wrapping_note;
            $_products["assemble_professionally_price"] = $product_price["assemble_professionally"];

            array_push($order_products , $_products);
        }

        return $order_products;
    }

    public function save_order_products($order_products){
        $userModel = model("App\Model\UserModel");
        $status = true;
        if(sizeof($order_products) > 0){    
            foreach ($order_products as $product) {
                # code...

                $res = $userModel->do_action("order_products", "", "", "insert", $product, "");
                if(!$res || is_null($res))
                $status = false;
            }
        }

        return $status;
    }

    public function prepare_order_details($user_address , $payment_method , $user_id = null , $order_id = null){
        $userModel = model("App\Model\UserModel");
        $offerModel = model("App\Model\OfferModel");
        $session = session();
        @$user_id = (!is_null($user_id)) ? $user_id : $session->get("userLoggedin");
        $cart_discount = 0;
        $order_offers = [];
        
        // $order_id = $this->user_cart_id($user_id);
        if(is_null($order_id))
        $order_id = time() . rand(0, 9);

        

        // CALCULATE THE DISCOUNT
        $cart_coupon_applied = $this->cart_has_coupon_applied($user_id);
        $cart_coupon_discount = $this->cart_total_coupon_discount($user_id);

        // CALCULATE THE TOTAL CART
        $total_cart = $this->total_cart($user_id);

        // CALCULATE THE CHARGES
        $cart_charges = $this->cart_total_charges($user_id , $total_cart , $user_address->city);

        // Check valid cart applicable offer
        $offers = $offerModel->_get_valid_offers($this->offerModel->offers_list , null , $this->get_user_cart($user_id));   
        if(sizeof($offers) > 0){
            $order_offer = [];
            $cart_discount = 0;
            foreach ($offers as $offer) {
                # code...
                $offer->application = $offerModel->_apply_offer($offer);
                $order_offer = [
                    "order_id" => $order_id,
                    "offer_title" => $offer->offer_title,
                    "offer_arabic_title" => $offer->offer_arabic_title,
                ];
                if($offer->application == "Discount"){
                    switch ($offer->discount_type) {
                        case 'Amount':
                            # code...
                            $cart_discount += $offer->discount_amount;
                            $order_offer += [
                                "amount" => $offer->discount_amount,
                            ];
                            break;
                        
                        default:
                            # code...
                            if($cart_discount == 0){
                                $cart_discount = $total_cart * $offer->discount_value / 100;
                                $order_offer += [
                                    "amount" => $cart_discount,
                                ];
                            }
                            else{
                                break 1;
                            }
                            break;
                    }
                    $order_offer += [
                        "discount_type" => $offer->discount_type,
                        "value" => $offer->discount_value,
                    ];
                }
                elseif($offer->application == "Prize"){
                    $saved_prizes = $offerModel->get_cart_product_prizes($user_id , $offer->$offer_id);
                    $order_offer += [
                        "prizes" => (sizeof($saved_prizes) > 0) ? $saved_prizes : $offerModel->_select_offer_valid_prize($offer , $user_id)
                    ];
                }

                elseif($offer->application == "Get_N"){
                    $free_products = $offerModel->_get_cart_GetN_products($offer);
                    if(sizeof($free_products["free_items"]) > 0 && !isset($free_products["msg"]))
                    $order_offer += [
                        "free_products" => $free_products["free_items"]
                    ];
                }

                $order_offers[] = $order_offer;
            }
        }
        

        // CALCULATE THE TOTAL
        $total = $total_cart + $cart_charges["total_charges"] - $cart_coupon_discount - $cart_discount;

        $order = [];
        $order["order_id"] = $order_id;
        $order["user_id"] = $user_id;
        $order["name"] = $user_address->name;
        $order["email"] = $userModel->get_user_email($user_id);
        $order["phone"] = $userModel->get_user_phone($user_id);
        $order["street"] = $user_address->street;
        $order["city"] = $user_address->city;
        $order["apartment_house"] = $user_address->apartment_house;
        $order["address"] = $user_address->address;
        $order["coupon_code"] = ($cart_coupon_applied["applied"] && sizeof($cart_coupon_applied["coupon"]) > 0) ? $cart_coupon_applied["coupon"]["coupon_code"] : null;
        $order["coupon_value"] = ($cart_coupon_applied["applied"] && sizeof($cart_coupon_applied["coupon"]) > 0) ? $cart_coupon_applied["coupon"]["coupon_value"] : null;
        $order["coupon_type"] = ($cart_coupon_applied["applied"] && sizeof($cart_coupon_applied["coupon"]) > 0) ? $cart_coupon_applied["coupon"]["coupon_type"] : null;;
        $order["coupon_discount"] = $cart_coupon_discount;
        $order["sub_total"] = $total_cart;
        $order["charges"] = $cart_charges["total_charges"];
        $order["total"] = $total;
        $order["payment_method"] = $payment_method;

        return ["order" => $order , "offers" => $order_offers];
    }

    public function create_order($order){
        $offerModel = model("App\Model\OfferModel");
        $userModel = model("App\Model\UserModel");
        if(sizeof($order["order"]) > 0 && (isset($order["order"]["email"]) && !empty($order["order"]["email"]))){
            
            // Save order details
            $order_id = $userModel->do_action("orders", "", "", "insert", $order["order"], "");

            // If order has offer prizes - Save order offer prizes
            // if(isset($order["offer"]["prizes"])){
            $prizes = $offerModel->get_cart_product_prizes($order["order"]["user_id"]);
            if(sizeof($prizes) > 0){
                $order_id = $order["order"]["order_id"];
                array_map(function($prize) use($order_id , $userModel){
                    // if(isset($prize->products) && is_array($prize->products)){
                    //     foreach ($prize->products as $product_id) {
                    //         # code...
                    //         $details = $this->productModel->get_product_infos($product_id);
                            
                    //         $order_prize_product = [
                    //             "order_id" => $order_id,
                    //             // "prize_id" => $prize->prize_id,
                    //             "sku" => $details->sku,
                    //             "quantity" => 1,
                    //             "value" => $details->price,
                    //         ];
    
                    //         // Save order offer' prizes products
                    //         $userModel->do_action("order_prizes", "", "", "insert", $order_prize_product, "");
    
                    //     }
                    // }
                    // else{
                        $details = $this->productModel->get_product_infos($prize->product_sku);
                            
                            $order_prize_product = [
                                "order_id" => $order_id,
                                // "prize_id" => $prize->prize_id,
                                "sku" => $details->sku,
                                "quantity" => $prize->quantity,
                                "value" => $details->price,
                            ];
    
                            // Save order offer' prizes products
                            $userModel->do_action("order_prizes", "", "", "insert", $order_prize_product, "");
                    // }

                } , $prizes);

            }

            // Save Order Offers
            array_map(function($offer) use(&$userModel){
                unset($offer["prizes"]);
                $userModel->do_action("order_offers", "", "", "insert", $offer, "");
            } , $order["offers"]);
            

            return ($order_id!==false && $order_id !== null)  ? $order_id : false;
        }
        else
        return false;
    }

    public function get_order_details($order_id){
        $userModel = model("App\Model\UserModel");
        $req = "
        select orders.* 
        from orders 
        where orders.order_id='".$order_id."'
        ";
        $res = $userModel->customQuery($req);
        if($res && sizeof($res) > 0){
            $prizes = (array)$this->order_prizes($order_id);
            $offers = $this->order_offers($order_id);
            // if(sizeof($prizes) > 0){
                return array_merge((array)$res[0] , ["prizes" => $prizes] , ["offers" => $offers]);
            // }
            // return (array)$res[0];
        }

        return [];
    }

    public function get_order_products($order_id){
        $userModel = model("App\Model\UserModel");

        $req = "select * from order_products where order_id='".$order_id."'";
        $res = $userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            return (array)$res;
        }

        return [];
    }

    public function order_total_charges($order_id){
        $userModel = model("App\Model\UserModel");
        $total_charges = array("total_charges" => 0 , "charges"=>[]);
        $chr = 0;
        $sql = "select * from order_charges where order_id='".$order_id."'";
        $charges = $userModel->customQuery($sql);
        if ($charges) {
            foreach ($charges as $key => $value) {
                $charge = [];
                $charge["value"] = $value->value;
                $charge["title"] = $value->title;
                $charge["arabic_title"] = $value->arabic_title;
                $charge["type"] = $value->type;
                $charge["price"] = $value->price;
                $charge["code"] = $value->code;
                $chr += $charge["price"];

                array_push($total_charges["charges"] , $charge);

            }
            $total_charges["total_charges"] = $chr;
        }

        return $total_charges;
    }

    public function save_order_charges($user_id , $order_id ,$cart_charges){
        $userModel = model("App\Model\UserModel");

        if($cart_charges["total_charges"] > 0 && sizeof($cart_charges["charges"]) > 0){
            foreach ($cart_charges["charges"] as $key => $value) {
                # code...
                unset($value["user_id"]);
                $data = array_merge($value , ["user_id" => $user_id , "order_id" => $order_id]);
                $userModel->do_action("order_charges","","","insert",$data,"");
            }
        }
    }

    public function cart_total_charges($user_id , $total_cart, $city_id=null){
        $userModel = model("App\Model\UserModel");
        $total_charges = array("total_charges" => 0 , "charges"=>[]);
        $chr = 0;

        // $sql = "select * from charges where status='Active' AND (city='all' OR city='".$city_id."')";
        $sql = "
        select charges.*,charge_categories.code 
        from charges inner join charge_categories 
        on charges.category=charge_categories.id 
        where status='Active' 
        AND (city='all' OR city='".$city_id."')";
        $charges = $userModel->customQuery($sql);
        if ($charges && !$this->cart_only_digital_codes($user_id)) {
            foreach ($charges as $key => $value) {
                if ($total_cart >= $value->applicable_minimum_amount && $total_cart <= $value->applicable_maximum_amount) {
                    $charge = [];
                    $charge["code"] = $value->code;
                    $charge["value"] = $value->value;
                    $charge["title"] = $value->title;
                    $charge["arabic_title"] = $value->arabic_title;
                    $charge["type"] = $value->type;
                    $charge["user_id"] = $user_id;
                    if ($value->type == "Percentage") {
                        $charge["price"] = bcdiv(($total_cart * $value->value) / 100 , 1 , 2);
                    } else {
                        $charge["price"] = $value->value;
                    }
                    $chr += $charge["price"];

                    array_push($total_charges["charges"] , $charge);
                }

            }
            $total_charges["total_charges"] = $chr;
        }

        return $total_charges;
    }

    public function clear_cart($user_id = null){
        $session = session();
        $userModel = model("App\Model\UserModel");
        $user_id = (!is_null($user_id)) ? $user_id : $session->get("userLoggedin") ; 
        $res = $userModel->do_action(
            "cart",
            $user_id,
            "user_id",
            "delete",
            "",
            ""
        );
    }

    public function decrease_products_stock($products){
        $bool = true;
        $userModel = model("App\Model\UserModel");
        if($products && sizeof($products) > 0){
            foreach ($products as $key => $product) {
                # code...

                $req = "update products set available_stock = (available_stock-".$product["quantity"].") where product_id='".$product["product_id"]."'";
                $res = $userModel->customQuery($req);
                if(!$res || is_null($res))
                $bool = false;
            }
        }

        return $bool;

    }
    
    public function increase_products_stock($cart){
        $bool = true;
        $userModel = model("App\Model\UserModel");
        if($cart && sizeof($cart) > 0){
            foreach ($cart as $key => $product) {
                # code...

                $req = "update products set available_stock = (available_stock+".$product->quantity.") where product_id='".$product->product_id."'";
                $res = $userModel->customQuery($req);
                if(!$res || is_null($res))
                $bool = false;
            }
        }

        return $bool;

    }

    public function telr_pay($idata){
        $userModel = model("App\Model\UserModel");
        $telr_data = ["status"  => false , "url" => null];
        
        $payName = explode(" ", $idata["name"]);
        $params = [
            "ivp_method" => "create",
            "ivp_tranclass" => "ecom",
            "ivp_store" => STOREID,
            "ivp_authkey" => AUTHKEY,
            "ivp_amount" => $idata["total"],
            "ivp_currency" => CURRENCY,
            "ivp_test" => PGTEST,
            "ivp_cart" => $idata["order_id"],
            "ivp_desc" => "Payment for order id : " . $idata["order_id"],
            "ivp_framed" => 2,
            "bill_title" => "",
            "bill_fname" => @$payName[0],
            "bill_sname" => @$payName[1],
            "bill_addr1" => $idata["address"],
            "bill_addr2" => "",
            "bill_addr3" => "",
            "bill_city" => @$idata["street"],
            "bill_region" => @$idata["apartment_house"],
            "bill_country" => "ae",
            "bill_zip" => "",
            "bill_email" => $idata["email"],
            "bill_phone" => $idata["phone"],
            "return_auth" =>
                base_url() .
                "/payment-success/" .
                base64_encode($idata["order_id"]),
            "return_can" => base_url() . "/payment-failed",
            "return_decl" => base_url() . "/payment-failed",
        ];
        /*  echo "<pre>";
         print_r($params);exit;*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Expect:"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);


        if (curl_exec($ch) === false) {
            echo "Curl error: " . curl_error($ch);
        } else {
            $results = json_decode(curl_exec($ch), true);
            $ref_cond = isset($results["order"]["ref"]) && $results["order"]["ref"] !== "";
            $url_cond = isset($results["order"]["url"]) && $results["order"]["url"] !== "";

            if($ref_cond && $url_cond){
                $ref = trim(@@$results["order"]["ref"]);
                $url = trim(@@$results["order"]["url"]);
                $ptp["order_id"] = $idata["order_id"];
                $ptp["ref"] = $ref;
                $ptp["link"] = $url;
                $ptp["customer"] = $idata["user_id"];
                $res = $userModel->do_action("payment_txn", "", "", "insert", $ptp, "");
                // return redirect()->to($url);
                $telr_data["status"] = true;
                $telr_data["url"] = $url;
            }
            
        }
        curl_close($ch);

        return $telr_data;
    }

    public function telr_check_payment($transaction_redf){
        $pd = [];
        $params = [
            "ivp_method" => "check",
            "ivp_store" => STOREID,
            "ivp_authkey" => AUTHKEY,
            "order_ref" => $transaction_redf,
            "ivp_test" => PGTEST,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Expect:"]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);


        if (curl_exec($ch) === false) {
            echo "Curl error: " . curl_error($ch);
        } else {
            $results = json_decode(curl_exec($ch), true);

            $pd["amount"] =                         @$results["order"]["amount"];
            $pd["currency"] =                       @$results["order"]["currency"];
            $pd["description"] =                    @$results["order"]["description"];
            $pd["status"] =                         @$results["order"]["status"]["text"];
            $pd["transaction_ref"] =                @$results["order"]["transaction"]["ref"];
            $pd["transaction_type"] =               @$results["order"]["transaction"]["type"];
            $pd["transaction_class"] =              @$results["order"]["transaction"]["class"];
            $pd["transaction_status"] =             @$results["order"]["transaction"]["status"];
            $pd["transaction_code"] =               @$results["order"]["transaction"]["code"];
            $pd["transaction_message"] =            @$results["order"]["transaction"]["message"];
            $pd["paymethod"] =                      @$results["order"]["paymethod"];
            $pd["email"] =                          @$results["order"]["customer"]["email"];
            $pd["name"] =                           @$results["order"]["customer"]["name"]["forenames"];
            $pd["line1"] =                          @$results["order"]["customer"]["address"]["line1"];
            $pd["line2"] =                          @$results["order"]["customer"]["address"]["line2"];
            $pd["city"] =                           @$results["order"]["customer"]["address"]["city"];
            $pd["state"] =                          @$results["order"]["customer"]["address"]["state"];
            $pd["country"] =                        @$results["order"]["customer"]["address"]["country"];
            $pd["areacode"] =                       @$results["order"]["customer"]["address"]["areacode"];
            $pd["mobile"] =                         @$results["order"]["customer"]["address"]["mobile"];
        }

        curl_close($ch);

        return $pd;
    }
    
    public function get_city_name($city_id){
        $userModel = model("App\Model\UserModel");
        $req = "select title,arabic_title from city where city_id='".$city_id."'";
        $res = $userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res[0];

        return false;
    }
    
    public function get_city_list(){
        $userModel = model("App\Model\UserModel");
        $req = "select * from city where status='Active' AND title <> 'All'";
        $res = $userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];
    }
    
    public function cart_has_preorder($cart){
        $bool = false;

        if(sizeof($cart) > 0){
            foreach($cart as $value){
                if($value->pre_order_enabled == "Yes")
                $bool = true;
            }
        }

        return $bool;
    }

    public function cart_only_digital_codes($user_id){
        $bool = true;
        $is_digital = function($type){
            if(sizeof($type) == 1 && in_array("6" , $type))
            return true;
            return false;
        };
        $cart = $this->get_user_cart($user_id);
        array_walk($cart , function($product)use(&$bool , &$is_digital){

            $type = explode("," , $product->type);
            if(!$is_digital($type))
            $bool = false;

        });

        return $bool;
    }
    
    public function order_total_quantity($order_id){
        $userModel = model("App\Model\UserModel");
        $req = "select sum(quantity) as total from order_products where order_id =".$order_id;
        $res = $userModel->customQuery($req);

        if($res && sizeof($res) > 0)
        return $res[0]->total;

        return null;
    }
    
    public function order_digital_code($order_id){
        $userModel = model("App\Model\UserModel");
        $req = "select 
        products.product_id,
        products.sku,
        order_products.quantity,
        order_products.pre_order_enabled,
        products.ez_price 
        from order_products inner join products 
        on order_products.product_id = products.product_id 
        where order_products.order_id='$order_id' 
        AND products.type='6'";
        $res = $userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;
        
        return [];
    }

    public function user_digital_codes($user_id){
        $userModel = model("App\Model\UserModel");
        $req = "
        select user_codes.*,order_products.quantity,products.name,product_image.image 
        from 
        (select ezpin_codes_order.* 
        from ezpin_codes_order 
        inner join orders on ezpin_codes_order.order_id=orders.order_id 
        where orders.user_id='1653904122') 
        as user_codes 
        inner join order_products on user_codes.order_id=order_products.order_id 
        AND user_codes.product_id=order_products.product_id 
        inner join products on user_codes.product_id=products.product_id
        left join product_image on products.product_id=product_image.product 
        group by products.product_id
        ";
        $res = $userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;
        
        return [];
    }

    public function cart_has_digital_codes($user_id){
        $userModel = model("App\Model\UserModel");
        $req = "select count(products.type) as nbr 
        from cart 
        inner join products on cart.product_id=products.product_id 
        where products.type='6'
        ";
        $res = $userModel->customQuery($req);

        if($res && sizeof($res) > 0 && $res[0]->nbr > 0)
            return true;

        return false;
    }

    public function send_email($to , $subject , $content  ,  $cc = null , $from = "info@zamzamdistribution.com" , $name = "ZGames"){
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom(
            $from,
            $name
        );
        if(!is_null($cc))
        $email->setCC($cc);
        $email->setSubject($subject);
        $email->setMessage($content);

        if (!$email->send()){
            $data = $email->printDebugger(["headers",]);
            print_r($data);
        } 
    }

    public function user_order_history($user_id){
        $userModel = model("App\Model\UserModel");

        $req = "
            select 
            created_at,
            total,
            order_status,
            name,phone,email,
            street,apartment_house,address,city,
            from orders 
            where user_id='$user_id'
        ";

        $res = $userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];
    }

    public function user_cart_id($user_id){
        $userModel = model("App\Models\UserModel");
        $req = "select sum(id) as id from cart where user_id='$user_id'";
        $res = $userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res[0]->id;

        return null;
    }

    public function get_transaction($order_id){

        $userModel = model("App\Models\UserModel");
        $req = "select * from payment_txn where order_id='$order_id'";
        $res = $userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res[0];

        return null;

    }

    public function online_payment_order_process($oid , $user_id , $payment_id = null){

        // $session = session();
        // @$user_id = $session->get("userLoggedin");

        $userModel = model("App\Models\UserModel");
        $tabbyModel = new Tabby\TabbyModel();
        $ezpinModel = model("App\Models\Ez_pin");
        $systemModel = model("App\Models\SystemModel");

        $order_process = false;

        if(!is_null($payment_id))
        $cond = " and ref = '".$payment_id."'";


        if ($oid && $user_id) {
            $oid = base64_decode($oid);
            $payment_method = "Online payment";
            // echo $oid; die();
            $sql = "select * from payment_txn where order_id='".$oid."'".$cond;
            $payment_txn = $userModel->customQuery($sql);

            // $order_details = $this->orderModel->get_order_details($oid , $user_id);
            // $order_products = $this->orderModel->get_order_products($oid);
            // $order_charges = $this->orderModel->order_total_charges($oid);

            // Repeated later calculation in Prepare order details
            $cart_coupon_discount = $this->cart_total_coupon_discount($user_id);
            $total_cart = $this->total_cart($user_id);
            // $total = $total_cart - $cart_coupon_discount;
            // Repeated later calculation
            
            $cart = $this->get_user_cart($user_id);            
            $user_address = $userModel->get_user_address($user_id);
            $cart_charges = $this->cart_total_charges($user_id , $total_cart , $user_address->city);
            $order_details = $this->prepare_order_details($user_address , $payment_method , $user_id , $oid);
            $order_products = $this->create_order_products($user_id , $cart , $order_details);

            // Check the transaction status
            switch ($payment_txn[0]->paymethod) {

                // Tabby payment request
                case 'Tabby':
                    # code...
                    $payment_id = (!is_null($payment_id)) ? $payment_id : $payment_txn[0]->transaction_ref;
                    $tabby_request = $tabbyModel->retrieve_request($payment_id);
                    // var_dump($tabby_request);die();
                    if($tabby_request)
                    $order_process = true;

                    break;

                // Telr Payment check
                default:
                    # code...
                    $results = $this->telr_check_payment($payment_txn[0]->ref); //return transaction infos array
                    if(sizeof($results) > 0 && $results["status"] == "Paid"){
                        $d = $userModel->do_action("payment_txn", $oid, "order_id", "update", $results, "");
                        $order_process = true;
                    }
                    break;
            }

            // var_dump($order_process);die();

            // var_dump($cart_charges , $total);die();
            if($order_process){
                // Create the order
                $this->create_order($order_details);

                // save order products
                $this->save_order_products($order_products);

                // save charges
                $this->save_order_charges($user_id , $order_details["order"]["order_id"] ,$cart_charges);


                // If order has EZPIN products => create EZPIN order
                $digital_codes = $this->order_digital_code($oid);
                if(sizeof($digital_codes) > 0){
                    $pp = $ezpinModel->ezpin_create_order($order_details["order"] , $digital_codes);
                }

                // Update the order
                if($payment_txn[0]->paymethod == "Tabby"){
                    $odetail = $userModel->do_action("orders" ,$oid, "order_id", "update", ["payment_status" => "Paid" , "transaction_ref" => $payment_txn[0]->id], "");
                }
                else if(isset($results))
                    $odetail = $userModel->do_action("orders" ,$oid, "order_id", "update", ["payment_status" => @$results["status"] , "transaction_ref" => $payment_txn[0]->id], "");

                // die();
                
                // decrease ordered prodcut stock
                $this->decrease_products_stock($order_products);

                // Clear cart
                $this->clear_cart($user_id);

                //  wallet deduction start
                if ($order_details["order"]["wallet_use"] == "Yes" && false) {
                    $user_id = $order_details["order"]["user_id"];
                    $sql = "select * from wallet where user_id='$user_id' And (status='Active' OR status='Used') order by created_at asc";
                    $wallet = $this->userModel->customQuery($sql);
                    if ($wallet) {
                        $rest_amount = $order_details["order"]["total"];
                        foreach ($wallet as $wk => $wv) {
                            if ($wv->available_balance >= $order_details["order"]["total"]) {
                                $wupdate["status"] = "Used";
                                $wupdate["available_balance"] = $wv->available_balance - $order_details["order"]["total"];
                                $odetail = $this->userModel->do_action("wallet", $wv->id, "id", "update", $wupdate, "");
                                break;
                            } 
                            else {
                                $rest_amount = $rest_amount - $wupdate["available_balance"];
                                $wupdate["status"] = "Used";
                                $wupdate["available_balance"] = 0;
                                $odetail = $this->userModel->do_action("wallet", $wv->id, "id", "update", $wupdate, "");
                                if ($rest_amount == 0) {
                                    break;
                                }
                            }
                        }
                    }
                }
                //  wallet deduction END

                // ### Send order Notification to admin
                    $subject = "ZGames | New order from ".$order_details["order"]["name"];
                    $content = view("emails/Admin_order_notification", ["orderdetails" => $order_details["order"] , "products" => $order_products]);
                    $admin_email = $systemModel->get_website_settings()->email_2;
                    if(!is_null($admin_email) && trim($admin_email) !== "")
                    $this->send_email($admin_email , $subject , $content);
                // ### Send Order notification to Admin


                //### SEND EMAIL STRT TO CUSTOMER
                    if ($to = $order_details["order"]["email"]) {

                        $edata["order_products"] = $order_products;
                        $edata["orders"] = $order_details;
                        $edata["order_charges"] = $order_charges;

                        $subject = "Your order was successfully submitted. Order Id " . $order_details["order"]["order_id"];
                        $message = view("BookingEmail", $edata);
                        $email = \Config\Services::email();
                        $email->setTo($to);
                        $email->setFrom( "info@zamzamdistribution.com", "ZGames");
                        $email->setSubject($subject);
                        $email->setMessage($message);

                        if ($email->send()) {
                            //   echo 'Email successfully sent';
                        } else {
                            /* $data = $email->printDebugger(['headers']);
                             print_r($data);*/
                        }
                    }
                //### SEND EMIAL TO CUSTOMER END
                
                return true;
                
            }
            exit;
        }

        return false;
    }

    public function order_prizes($order_id){
        $req = "
        select order_prizes.sku,order_prizes.value,order_prizes.quantity,products.name  
        from order_prizes inner join products on order_prizes.sku=products.sku 
        where order_prizes.order_id='$order_id';
        ";

        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];
    }

    public function order_offers($order_id){
        $req = "
        select * from order_offers 
        where order_id ='$order_id'
        ";

        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];
    }

    public function is_coupon_used($cid , $user_id){
        $userModel = model("App\Models\UserModel");
        $sql = "select * from coupon_uses where coupon_code='$cid' AND customer='$user_id'";
        $res = $userModel->customQuery($sql);
        // echo($sql);die();
        if(!is_null($res) && sizeof($res) > 0)
        return true;
        return false;
    }

    public function order_products_daywise($start = '' , $end = ''){

        $sql = "
        select 
        date(orders.created_at) as order_date,order_products.product_name,order_products.product_id,sum(order_products.product_price) as total_sale,sum(order_products.quantity) as total_qty,orders.payment_status
        from order_products 
        right join orders on orders.order_id=order_products.order_id 
        where orders.payment_status = 'Paid' 
        ";
        $sql .= (!empty($start) && !empty($start)) ? "AND date(orders.created_at) between '$start' and '$end' " : "";
        $sql .= "
        group by order_date,order_products.product_id 
        order by orders.created_at desc
        ";
        $res = $this->userModel->customQuery($sql);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];

    }

}

