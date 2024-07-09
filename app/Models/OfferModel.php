<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class OfferModel extends Model{
    private $userModel;

    // OFFER CONDITIONS
    public $conditions = [
        "on_product" => [
            "_relation" => "All" || "Single",
            "categories" => [],
            "brands" => [],
            "types" => [],
            "quantity" => 2
        ],
        "on_cart" => [
            "spend_amount" => 1000
        ]
    ];

    // [ #1 ] BUY N (QTY) PRODUCT, GET N (QTY)
    public $product_buy_N_get_N = [
        "get_qty" => 1,
        "_relation" => "All" || "Single" ,
    ];
    
    // [ #4 , #6 , #5 , #7 ] SPEND N AMOUNT, GET (N AED || N%) DISCOUNT | BUY N (QTY) (FOR-EACH || IN) (CATEGORY-BRAND-TYPE), GET (N AED || N%) DISCOUNT
    public $cart_spend_N_get_discount = [
        "discount_type" => ("Percentage" || "Amount"),
        "discount_value" => ("Amount") ? "50" : "15%" ,
        "_relation" => "All" || "Single",
    ];
    
    // [ #3 ] 
    public $cart_spend_N_get_prize = [
        "prizes" => [
            "PPC_1" => [],
            "PPC_2" => [],
            "PPC_3" => [],
        ],
        "_relation" => "All" || "Single" ,
        "prize_agregation" => "All" || "Single",
    ];

    public $offers_list;

    public function __construct(){
        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");
        // $this->orderModel = model("App\Models\OrderModel");
        $this->offers_list = $this->_get_offers_list();
    }

    // Get offer Conditions
    public function _get_offer_conditions($offer_id): Array
    {

        // Get the condition categories
        $_get_condition_categories = function($conditions): Array{
            $categories = [];
            
            if(!is_null($conditions) && trim($conditions) !== "") 
            return explode("," , $conditions);

            return [];
        };

        // Get the condition Brands
        $_get_condition_brands = function($condition_id): Array {
            $brands = [];
            $req = "
            select brand_id from offer_condition_brands 
            where condition_id=$condition_id
            ";
    
            $res = $this->userModel->customQuery($req);
            if($res && sizeof($res) > 0){
                array_map(function($brand) use (&$brands){
                    $brands[] = $brand->brand_id;
                } , $res);
            }
            return $brands;
    
            return [];
        };

        // Get Condition Types
        $_get_condition_types = function ($condition_id): Array
        {   
            $type_ids = [];
            $req = "
            select type_id from offer_condition_types 
            where condition_id=$condition_id
            ";
    
            $types = $this->userModel->customQuery($req);
    
            if($types && sizeof($types) > 0){
                array_map(function($type) use(&$type_ids) {
                    $type_ids [] = $type->type_id;
                } , $types);
            }
            return $type_ids;
    
            return [];
        };

        // Get Condition Products
        $_get_condition_products = function ($condition_id): Array
        {   
            $product_ids = [];
            $req = "
            select product_id from offer_condition_products 
            where condition_id=$condition_id
            ";
    
            $products = $this->userModel->customQuery($req);
    
            if($products && sizeof($products) > 0){
                array_map(function($product) use(&$product_ids) {
                    $product_ids [] = $product->product_id;
                } , $products);
            }
            return $product_ids;
    
            return [];
        };

        $req = "
        select offer_conditions.* 
        from offers 
        inner join offer_condition_relation on offers.offer_id=offer_condition_relation.offer_id 
        left join offer_conditions on offer_condition_relation.condition_id=offer_conditions.id 
        where offers.offer_id=$offer_id
        ";

        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){

            array_map(function($condition) use (&$_get_condition_categories , &$_get_condition_brands , &$_get_condition_types , &$_get_condition_products){

                $condition->on_product_categories = $_get_condition_categories($condition->on_product_categories);
                $condition->on_product_brands = $_get_condition_brands($condition->id);
                $condition->on_product_types = $_get_condition_types($condition->id);
                $condition->product_list = $_get_condition_products($condition->id);
                $condition->on_product_qty = (intval($condition->on_product_qty) == 0) ? 1 : $condition->on_product_qty;
                return $condition;
            } , $res);


            return $res;
        }

        return [];
    }

    // Get Offer Prizes
    public function _get_offer_prizes($offer_id): Array{

        $_get_product = function($prize_id){
            $req = "
                select product_sku 
                from product_prizes
                where prize_id=$prize_id
            ";

            $res = $this->userModel->customQuery($req);
            if($res && sizeof($res) > 0){
                foreach ($res as $value) {
                    # code...
                    $products [] .= $value->product_sku;
                }
            }

            return $products;   

            return [];
        };

        $req = "
        select prizes.* 
        from prizes 
        inner join offer_prizes on prizes.prize_id=offer_prizes.prize_id
        where offer_prizes.offer_id = $offer_id
        ";

        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            array_map(function($prize_set) use(&$_get_product){
                $prize_set->products = $_get_product($prize_set->prize_id);
                return $prize_set;
            } , $res);
            
            return $res;
        }
        return [];

    }

    // Get Offer By ID
    public function _get_offer($offer_id = null):Object
    {
        $offer = (Object)[];

        $req = "
        select * 
        from offers 
        where offer_id = $offer_id
        ";
        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            $offer = $res[0];
            $offer->conditions = $this->_get_offer_conditions($res[0]->offer_id);
            $offer->prizes = $this->_get_offer_prizes($res[0]->offer_id);
        }

        return $offer;
    }

    // Get offers List
    public function _get_offers_list($product_id = null , $cart = null):Array{
        $date = date("Y-m-d h:i:s");
        $on_product = (!is_null($product_id) && trim($product_id) !== "");
        $on_cart = (!is_null($cart) && is_array($cart) && sizeof($cart) > 0);

        $req = "select * from offers where '$date' between start_date AND end_date and status='Active' ";
        $req .= ($on_product) ? " AND level = 'Product' " : " ";
        $req .= ($on_cart) ? " AND level = 'Cart' " : " ";
        $req .= "order by priority asc";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            foreach ($res as $offer) {
                # code...
                $offer->conditions = $this->_get_offer_conditions($offer->offer_id);
                $offer->prizes = $this->_get_offer_prizes($offer->offer_id);
            }
            return $res;
        }

        return [];
    }

    // Get Running Offers
    public function _get_valid_offers($offers , $product_id = null , $cart = null , $force_cart_level_flag = false): Array{

        $orderModel = model("App\Models\OrderModel");
        $valid_offers = [];
        $on_product = (!is_null($product_id) && trim($product_id) !== "");
        $on_cart = (!is_null($cart) && is_array($cart) && sizeof($cart) > 0);
        $valid_products = [];

        // Filter offers List
        $fillter_product_offers = function($offer){
            return $offer->level == "Product";
        };
        $fillter_cart_offers = function($offer){
            return $offer->level == "Cart";
        };

        // check if The Offer is valid for a cart - Only On Cart Offers
        $cart_condition_complies = function($cart , $condition) use ($orderModel , &$valid_products):Array{
            // var_dump($cart);die();
            // $results = [];
            $total_qty = 0;
            
            $filter_flag = false;
            $product_flag = false;
            $result_flag = false;

            // $sub_total = $orderModel->total_cart($cart->user_id);

            $min_qty = (!is_null($condition->on_product_qty) && $condition->on_product_qty > 0) ? (int)$condition->on_product_qty : 0;
            $has_filter = (sizeof($condition->on_product_categories) > 0 || sizeof($condition->on_product_brands) > 0 || sizeof($condition->on_product_types) > 0);
            $has_product_list = (sizeof($condition->product_list) > 0);

            // loop on the cart products
            // array_map(function($product_cart) use (&$total_qty , &$sub_total , &$min_qty , &$condition , &$filter_flag , &$product_flag , &$results) {
            foreach($cart as $product_cart){
                $not_discounted = ((int)$product_cart->discount_percentage == 0 || is_null($product_cart->discount_percentage)) && ((int)$product_cart->discount_amount == 0 || is_null($product_cart->discount_amount)) && is_null($product_cart->coupon_code);
                $not_preorder = ($product_cart->pre_order_enabled !== "Yes");
                // Check if cart has Product in the condition product list and enough qty
                if($not_discounted && $not_preorder && $has_product_list && in_array($product_cart->product_id , $condition->product_list)){
                    $total_qty += $product_cart->quantity;
                    // array_push($products , $product_cart->product_id);
                    if(!array_key_exists($product_cart->product_id , $valid_products))
                    $valid_products[$product_cart->product_id] = ["id" => $product_cart->product_id , "cart_id" => $product_cart->id ,  "name" => $product_cart->name , "qty" => intval($product_cart->quantity) , "price" => $product_cart->price , "offer_condition" => $condition->description , "aggregation" => $condition->on_product_aggregation , "offer_condition_qty" => $condition->on_product_qty];
                }

                // check if product belong to the filter and has enought qty
                else if($not_discounted && $not_preorder && $has_filter){
                    $flag = true;

                    $product = $this->productModel->get_product_infos($product_cart->product_id);

                    // Check if the product type match the type condition
                    if(sizeof($condition->on_product_types) > 0){
                        $intersect = array_intersect(explode("," , $product->type) , $condition->on_product_types);
                        $flag = sizeof($intersect) > 0;
                        // $flag = ($min_qty > 0) ? (sizeof($intersect) > 0 && $product_cart->quantity >= $min_qty) : sizeof($intersect);
                    }

                    // Check if the product brand match the brand condition
                    if(sizeof($condition->on_product_brands) > 0 && $flag){
                        $flag = in_array($product->brand , $condition->on_product_brands);
                        // $flag = ($min_qty > 0) ? ($flag && $product_cart->quantity >= $min_qty) : $flag;
                    }

                    // Check if the product Category match the category condition
                    if(sizeof($condition->on_product_categories) > 0 && $flag){
                        $intersect = array_intersect(explode("," , $product->category) , $condition->on_product_categories);
                        $flag = sizeof($intersect) > 0;

                        // $flag = ($min_qty > 0) ? (sizeof($intersect) > 0 && $product_cart->quantity >= $min_qty) : sizeof($intersect);
                    }

                    if($flag){
                        $total_qty += $product_cart->quantity;
                        // array_push($products , $product_cart->product_id);
                        if(!array_key_exists($product_cart->product_id , $valid_products))
                        $valid_products[$product_cart->product_id] = ["id" => $product_cart->product_id , "cart_id" => $product_cart->id ,  "name" => $product_cart->name , "qty" => intval($product_cart->quantity) , "price" => $product_cart->price , "offer_condition" => $condition->description , "aggregation" => "Single" , "offer_condition_qty" => $condition->on_product_qty];
                        $filter_flag = true;
                    }

                }
                $sub_total += ($not_discounted) ? $product_cart->price * $product_cart->quantity : 0;

            } 

            // $results [] = [ $condition->description => [$product_cart->name => $relation_flag]];

            // Condition Has product List
            if($has_product_list){
                switch ($condition->on_product_aggregation) {
                    case 'All':
                        # code...
                        if(sizeof(array_intersect(array_keys($valid_products) , $condition->product_list)) == sizeof($condition->product_list))
                        $product_flag = (!empty($condition->on_product_qty)) ? ($total_qty >= (sizeof($condition->product_list) * $condition->on_product_qty)) : $total_qty >= sizeof($condition->product_list);
                        else
                        $product_flag = false;
                        break;
                    
                    default:
                        # code...
                        if(sizeof(array_intersect(array_keys($valid_products) , $condition->product_list)) > 0){
                            $product_flag = (!empty($condition->on_product_qty)) ? $total_qty >= $condition->on_product_qty : $total_qty >= 1;
                        }
                        else
                        $product_flag = false;
                        break;
                }

                if(!is_null($condition->on_cart_spend_amount) && trim($condition->on_cart_spend_amount) !== "")
                $result_flag = ($condition->_relation == "All") ? ($product_flag && $sub_total > $condition->on_cart_spend_amount) : ($product_flag || $sub_total > $condition->on_cart_spend_amount);
                else
                $result_flag = $product_flag;

            }

            // Condition Has Product Filter
            else if($has_filter){
                
                $filter_flag = (!empty($condition->on_product_qty)) ? $total_qty >= $condition->on_product_qty && $filter_flag : $filter_flag ;

                if(!is_null($condition->on_cart_spend_amount) && trim($condition->on_cart_spend_amount) !== "")
                $result_flag = ($condition->_relation == "All") ? ($filter_flag && $sub_total > $condition->on_cart_spend_amount) : ($filter_flag || $sub_total > $condition->on_cart_spend_amount);
                
                else
                $result_flag = $filter_flag;
            }

            // Condition Has Only On cart Amout
            else{

                if(!is_null($condition->on_cart_spend_amount) && trim($condition->on_cart_spend_amount) !== "")
                $result_flag = $sub_total > $condition->on_cart_spend_amount;
                
                else
                $result_flag = false;
            }
        
            return ["status" => $result_flag];

        };

        if($on_cart || $force_cart_level_flag)
        $offers = array_filter($offers , $fillter_cart_offers);
        
        else if($on_product)
        $offers = array_filter($offers , $fillter_product_offers);

        if($offers && sizeof($offers) > 0){
            array_map(function($offer) use (&$valid_offers , &$cart_condition_complies , &$on_product , &$on_cart , &$product_id , &$cart , &$valid_products , &$force_cart_level_flag){
                // $offer = $this->_get_offer($row->offer_id);
                $valid_products = [];
                $offer_valid = ($offer->_relation == "All") ? true : false ;
                $offer->valid_cart_products = [];
                switch (true) {
                    case $on_product:

                        # Check if the offer is valid for the given products
                        $is_bundle_offer = ($force_cart_level_flag) ? ($this->_apply_offer($offer) == "Discount") : false;
                        $f_b= false;
                        $f_c= true;
                        foreach ($offer->conditions as $condition) {
                            # code...
                            $condition_valid = $this->product_condition_complies($product_id , $condition);

                            if($is_bundle_offer){

                                if(sizeof($condition->product_list) > 0 && in_array($product_id , $condition->product_list))
                                $f_b = true;

                                if(!empty($condition->on_product_categories) || !empty($condition->on_product_brands) || !empty($condition->on_product_types)){
                                    $f_b = false;
                                    break;
                                }
                            }
                            else{

                                if($condition_valid && $offer->_relation == "Single")
                                $offer_valid = true;
    
                                else if(!$condition_valid && $offer->_relation == "All")
                                $offer_valid = false;
                            }

                            
                        }

                        $offer_valid = ($force_cart_level_flag) ? ($f_b && $f_c): $offer_valid;
                        
                        if($offer_valid)
                        $valid_offers[] = $offer;                        

                    break;
                    
                    case $on_cart:
                        # code...

                        foreach ($offer->conditions as $condition) {
                            # code...
                            $condition_valid = $cart_condition_complies($cart , $condition);

                            if($condition_valid["status"] && $offer->_relation == "Single")
                            $offer_valid = true;

                            else if(!$condition_valid["status"] && $offer->_relation == "All")
                            $offer_valid = false;
                            
                            // $offer->valid_cart_products [] = $condition_valid["products"];
                            // $offer->valid_cart_products += $condition_valid["products"];
                        }                      

                        $offer->valid_cart_products = $valid_products;
                        if($offer_valid){
                            // If it is Bundle multiply the discount amount by the cart bundle qty
                            if($this->_apply_offer($offer) == "Discount" && $offer->discount_type == "Amount"){
                                $qts = [];
                                $applicable = [];
                                if(true){
                                    array_map(function($product)use(&$qts){ 
                                        $min = 100;
                                        if($product["aggregation"] == "Single"){
                                            $qts[$product["offer_condition"]]["qty"] += $product["qty"];
                                        }
                                        else{
                                            $min = ($product["qty"] < $min) ? $product["qty"] : $min;
                                            $qts[$product["offer_condition"]]["qty"] = (intdiv($min , $product["offer_condition_qty"]) > 0) ? intdiv($min , $product["offer_condition_qty"]) : 1;
                                        }
                                        $qts[$product["offer_condition"]]["aggregation"] = $product["aggregation"];
                                        $qts[$product["offer_condition"]]["condition_qty"] = $product["offer_condition_qty"];

                                    } , $offer->valid_cart_products);

                                    array_map(function($result) use(&$applicable){
                                        $applicable[] += (($result["aggregation"] == "Single")) ? intdiv($result["qty"] , $result["condition_qty"]) : $result["qty"];
                                    } , $qts);

                                    $offer->discount_amount = ($offer->_relation == "All") ? $offer->discount_value * min($applicable) : $offer->discount_value * sum($applicable);
                                }
                                if(false){

                                    array_map(function($product)use(&$qts){ 
                                        $q = intdiv($product["qty"] , $product["offer_condition_qty"]);
                                        if($q > 0)
                                        $qts[] += $q;
                                    } , $offer->valid_cart_products);
                                    // var_dump($qts);
                                    $offer->discount_amount = (sizeof($qts) > 0) ? $offer->discount_value * min($qts) : $offer->discount_value;
                                }
                            }
                            // Remove products that has previously offer applied
                            $cart = (!is_null($valid_products) && sizeof($valid_products)> 0) ? 
                            array_filter($cart , function($cart_product)use(&$valid_products){
                                return (array_key_exists($cart_product->product_id , $valid_products)) ? false : true;
                            }) :
                             $cart;
                            $valid_offers[] = $offer;
                        }

                    break;
                    
                    default:
                        # code...
                        // $offers[] = $offer;
                    break;
                }

            } , $offers);

        }

        return $valid_offers;
    }

    // Select offer valid prizes
    public function _select_offer_valid_prize($offer , $user_id): Array{
        // var_dump($offer->valid_cart_products);
        $prizes = [];
        // Choose a prize
        $shuffl = function(Array $prizes):object{
            $number = array_rand($prizes);
            return $prizes[$number];
        };

        // calculate the total quantity of the valid cart products
        foreach ($offer->valid_cart_products as $product) {
            # code...
            $total_qty += $product["qty"];
        }


        // Single aggregation prize array contruction
        $condition_product_agg_single = function($offer , $min_qty) use(&$prizes , &$shuffl , $total_qty , &$user_id){
            if($offer->prize_aggregation == "Single"){
                $list = [];
                $k = 0;
                usort($offer->valid_cart_products , function($a , $b){
                    return $a["qty"] < $b["qty"]; 
                });
                
                // foreach($offer->valid_cart_products as $valid_cart_product){
                    // Pick Random Prize
                    // for($i=1 ; $i<= intdiv($valid_cart_product["qty"] , $min_qty) ;$i++){
                    for($i=1 ; $i<= intdiv($total_qty , $min_qty) ;$i++){
                        
                        $list = (sizeof($list) == 0) ? $offer->prizes : $list;
                        $p = $shuffl($list);
                        
                        if(array_key_exists($p->prize_id , $prizes))
                        $prizes[$p->prize_id]->quantity += 1;
                        else{
                            $p->quantity = 1;
                            $prizes[$p->prize_id] = $p;
                        }
                        // if($user_id == "1703060891"){
                        //     var_dump($offer->valid_cart_products[$i-1]["cart_id"]);
                        // }
                        $k = ($i > sizeof($offer->valid_cart_products) && $k > sizeof($offer->valid_cart_products)-1) ? 0 : $k++;
                        $prizes[$p->prize_id]->related_cart_id = $offer->valid_cart_products[$k]["cart_id"];
                        
                        $list = array_filter($list , function($pr)use(&$p){
                            return $pr->prize_id !== $p->prize_id;
                        });
                    }

                // }
                
            }
            else{
                $prizes = $offer->prizes;
                foreach($offer->valid_cart_products as $valid_cart_product){
                    array_map(function($prize){
                        if(!isset($prize->quantity))
                        $prize->quantity = intdiv($valid_cart_product["qty"] , $min_qty);
                        else
                        $prize->quantity += intdiv($valid_cart_product["qty"] , $min_qty);
                        $prize->related_cart_id = $valid_cart_products[0]["cart_id"];
                    } , $prizes);
                }
            }

        };

        $condition_product_agg_all = function($offer , $min_qty , $total_qty) use(&$prizes){
            
            $prizes = $offer->prizes;
            array_map(function($prize)use(&$min_qty){
                $prize->quantity = intdiv($total_qty , $min_qty);
            } , $prizes);
        };

        $no_discount = (is_null($offer->discount_value) || $offer->discount_value == 0 || empty($offer->discount_value));
        $not_Get_N = (empty($offer->get_qty) || is_null($offer->get_qty));
        switch (true) {
            case (($offer->level == 'Cart' || $offer->level == 'Product') && $no_discount && $not_Get_N):
                # code...
                // Calculate Minimum Qty for the offer considering 1 condition on the offer for prize offers
                $min_qty = 1;
                if(sizeof($offer->conditions[0]->product_list) > 0){
                    if($offer->conditions[0]->on_product_aggregation == "Single"){
                        $min_qty = $offer->conditions[0]->on_product_qty;
                        $condition_product_agg_single($offer , $min_qty);
                    } 
                    else{
                        $min_qty = $offer->conditions[0]->on_product_qty * sizeof($offer->conditions[0]->product_list);
                        $condition_product_agg_all($offer , $min_qty);

                    }
                }
                else{
                    $min_qty = $offer->conditions[0]->on_product_qty;
                    $condition_product_agg_single($offer , $min_qty);
                }
                $this->save_cart_product_prizes($prizes , $user_id , $offer->offer_id);
                return $prizes;
            break;
            
            default:
                # code...

                return [];
            break;
        }

        // return [];

    }

    // Get Offer prizes products
    public function _get_offer_prize_products($prizes):Array{

        $products = [];
        $get_product_details = function($prize_id)use(&$user_id):Array{
            
            $req = "
                select products.product_id,products.sku,products.name,products.price,product_image.image 
                from product_prizes left join products on product_prizes.product_sku = products.product_id 
                left join product_image on products.product_id=product_image.product 
                where product_prizes.prize_id=$prize_id 
                group by products.product_id
            ";

            $res = $this->userModel->customQuery($req);

            return ($res && sizeof($res) > 0) ? $res : [];
        };

        if(sizeof($prizes) > 0){
            array_map(function($prize) use(&$products , &$get_product_details){
                $product_results = $get_product_details($prize->prize_id);
                if(sizeof($product_results) > 0)
                $products [$prize->description] = $product_results;

            } , $prizes);
        }
        return $products;

    }

    // Apply the offer Cart: Discount - Prize| Product: Discount - Get_N - Prize
    public function _apply_offer($offer): String{

        $result = "";
        // var_dump($offer);die();
        switch ($offer->level) {
            case "Cart":
                # code...
                if(!is_null($offer->discount_value) && !is_null($offer->discount_type) && !empty(trim($offer->discount_value)))
                $result = "Discount";
                else if(!is_null($offer->get_qty) && !empty($offer->get_qty))
                $result = "Get_N";
                else if(!is_null($offer->prizes) && sizeof($offer->prizes) > 0)
                $result = "Prize";

            break;

            case "Product":
                # code...
                if(!is_null($offer->discount_value && !is_null($offer->discount_type) && !empty($offer->discount_value)))
                $result = "Discount";
                else if(!is_null($offer->prizes) && sizeof($offer->prizes) > 0)
                $result = "Prize";
            break;
            
            default:
                # code...
            break;
        }

        return $result;
    }

    // Get Get_N product List
    public function _get_cart_GetN_products($offer){

        $min_cart_products = ($offer->_relation == "All") ? 0 : [];
        $free_items = [];
        

        if(isset($offer->valid_cart_products) && sizeof($offer->valid_cart_products) > 0 && $offer->level == "Cart"){
            
            // Calculate the cart minimum qty
            foreach($offer->conditions as $condition){
                switch ($offer->_relation) {
                    case 'All':
                        # code...
                        if(sizeof($condition->product_list) > 0 && $condition->on_product_aggregation == "All"){
                            $min_cart_products += (int)$condition->on_product_qty * sizeof($condition->product_list);
                        }
                        else
                        $min_cart_products += (int)$condition->on_product_qty;
            
                    break;
                    
                    default:
                        # code...
                        if(sizeof($condition->product_list) > 0 && $condition->on_product_aggregation == "All"){
                            $min_cart_products [$condition->description] += (int)$condition->on_product_qty * sizeof($condition->product_list) + (int)$offer->get_qty;;
                        }
                        else{
                            $min_cart_products [$condition->description] = (int)$condition->on_product_qty + (int)$offer->get_qty;
                        }
                    break;
                }

                $i++;
                
            }; 
            // var_dump($min_cart_products);die();
            if(!is_array($min_cart_products) && is_int($min_cart_products))
            $min_cart_products += $offer->get_qty;
            else{
                $min_cart_products = min($min_cart_products);
            }

            $sortByPrice= function($a, $b) {
                return $b['price'] < $a['price'];
            };

            uasort($offer->valid_cart_products , $sortByPrice);

            // Get valid products total QTY
            foreach ($offer->valid_cart_products as $product) {
                # code...
                $total_qty += $product["qty"];
            }
            $free_qty = intdiv($total_qty,$min_cart_products) * $offer->get_qty;

            // Function to extract the Free Items
            $get_free_items = function($products) use (&$free_items , &$free_qty){
                $i = 0;
                
                foreach ($products as $key => $value) {
                    # code...
                    if ($free_qty > 0 && $i < sizeof($products)) {
                        # code...
    
                        if($value["qty"] <= $free_qty){
                            $free_qty -= $value["qty"];
                        }
    
                        else if($value["qty"] > $free_qty){
                            $value["qty"] = $free_qty;
                            $free_qty = 0;
                        }
    
    
                        $free_items [$key] = $value;
                        
                        $i++;
                    }
                    else
                    break;
                }

            };


            // Extract the free GET_N products
            if($free_qty > 0){
                // echo "Applicable <br>";
                $get_free_items($offer->valid_cart_products);

                return ["free_items" => $free_items];

            }
            else{
                $msg = "Add ".($min_cart_products - $total_qty)." more item(s) with the badge {$offer->offer_title} to get {$offer->get_qty} for free";
                return ["free_items" => $free_items , "msg" => $msg];
            }

            // echo (intdiv($total_qty,$min_cart_products) * $offer->get_qty)." items will be free";
            // var_dump($offer->valid_cart_products , $total_qty , $free_items);
            // return $min_cart_products;
        }

        return $free_items;

    }

    // Get Get_N offer which the given product complies with
    public function product_Get_N_offer_comply($product_id){
        $offer = null;
        $Get_N_offers_list = array_filter($this->offers_list , function($offer){
            if((!is_null($offer->get_qty) && trim($offer->get_qty) !== "") && $offer->level == "Cart")
            return true;
            return false;
        });

        $is_comply = function($condition) use (&$product_id){
            return $this->product_condition_complies($product_id , $condition);
        };

        foreach($Get_N_offers_list as $Get_N_offer){
            $offer_valid = ($Get_N_offer->_relation == "All") ? true : false ;
            $buy_qty = [];
            foreach ($Get_N_offer->conditions as $condition) {
                # code...
                $bool = $is_comply($condition);
                $buy_qty [] = (intval($condition->on_product_qty) > 0) ? $condition->on_product_qty : 1;
                if($bool && $Get_N_offer->_relation == "Single"){
                    $offer_valid = true;
                }

                else if(!$bool && $Get_N_offer->_relation == "All"){
                    $offer_valid = false;
                }
                
            }

            if($offer_valid){
                $Get_N_offer->buy_qty = ($Get_N_offer->_relation == "All") ? array_sum($buy_qty) : min($buy_qty);
                return $Get_N_offer;
            }
        }
        return $offer;
    }

    // Get Prize offer which the given product complies with
    public function product_prize_offer_comply($product_id){
        $offer = null;
        $prize_offers_list = array_filter($this->offers_list , function($offer){
            if((is_null($offer->get_qty) || trim($offer->get_qty) == "") && sizeof($offer->prizes)>0 && (is_null($offer->discount_value) || trim($offer->discount_value) == "") && $offer->level == "Cart")
            return true;
            return false;
        });
        
        $is_comply = function($condition) use (&$product_id){
            return $this->product_condition_complies($product_id , $condition);
        };

        foreach($prize_offers_list as $prize_offer){
            $offer_valid = ($prize_offer->_relation == "All") ? true : false ;
            $buy_qty = [];
            foreach ($prize_offer->conditions as $condition) {
                # code...
                $bool = $is_comply($condition);
                $buy_qty [] = (intval($condition->on_product_qty) > 0) ? $condition->on_product_qty : 1;
                if($bool && $prize_offer->_relation == "Single"){
                    $offer_valid = true;
                }

                else if(!$bool && $prize_offer->_relation == "All"){
                    $offer_valid = false;
                }
                
            }

            if($offer_valid){
                $prize_offer->buy_qty = ($prize_offer->_relation == "All") ? array_sum($buy_qty) : min($buy_qty);
                return $prize_offer;
            }
        }
        return $offer;
    }

    // Check if a product complies with offer conditions
    public function product_condition_complies($product_id , $condition):bool{
        $flag = false;
        $filter_flag = true;
        $product = $this->productModel->get_product_infos($product_id);
        $not_pre_order = ($product->pre_order_enabled !== "Yes");
        if(sizeof($condition->product_list) > 0){
            $flag = (in_array($product_id , $condition->product_list));
        }

        else if($not_pre_order){
            // Check if the product type match the type condition
            if(sizeof($condition->on_product_types) > 0){
                $intersect = array_intersect(explode("," , $product->type) , $condition->on_product_types);
                $filter_flag = (sizeof($intersect) > 0);
                // $filter_flag = in_array($product->type , $condition->on_product_types);
            }

            // Check if the product brand match the brand condition
            if(sizeof($condition->on_product_brands) > 0 && $filter_flag){
                $filter_flag = in_array($product->brand , $condition->on_product_brands);
            }

            // Check if the product Category match the category condition
            if(sizeof($condition->on_product_categories) > 0 && $filter_flag){
                $intersect = array_intersect(explode("," , $product->category) , $condition->on_product_categories);
                $filter_flag = (sizeof($intersect) > 0);
            }

            $flag = $filter_flag;
        }

        return $flag;
    }

    // Get offers product level and Get_N cart conditions categories, brands, types and products list 
    public function get_offers_conditions_filters($offers = null){
        $filters = [];

        $offers = (is_null($offers)) ? array_filter($this->offers_list , function($offer){
            
            /**
             * Buy N Get N                      ====> $offer->level == 'Cart' && !is_null($offer->get_qty)
             * Product Discount                 ====> $offer->level == 'Product'
             * Buy N Get A Prize                ====> $offer->level == 'Cart' && is_null($offer->get_qty) && is_null($offer->discount_value) && sizeof($offer->prizes) > 0
             * Cart Discount (Bundle/Single)    ====> $offer->level == 'Cart' && is_null($offer->get_qty) && !is_null($offer->discount_value)
             */
            
            if(
                ($offer->level == 'Cart' && is_null($offer->get_qty) && !is_null($offer->discount_value)) 
                || ($offer->level == 'Cart' && !is_null($offer->get_qty) && is_null($offer->discount_value)) 
                || ($offer->level == 'Cart' && is_null($offer->get_qty) && is_null($offer->discount_value) && sizeof($offer->prizes) > 0)
                || $offer->level == 'Product' 
            )
            return true;
            else
            return false;
        }) : $offers;

        array_map(function($offer)use(&$filters){
            
            foreach ($offer->conditions as $condition) {
                # code...

                if(sizeof($condition->product_list) > 0){
                    if(!isset($filters[$condition->id]["products"]))
                    $filters[$condition->id] = ["products" => []];
                    $filters[$condition->id]["products"] = array_unique(array_merge($filters[$condition->id]["products"] , $condition->product_list));
                }
                else{
                    $filters[$condition->id]["categories"] = $condition->on_product_categories;
                    $filters[$condition->id]["brands"] = $condition->on_product_brands;
                    $filters[$condition->id]["types"] = $condition->on_product_types;
                    
                }
            }
        } , $offers);

        return $filters;    
    }

    // Get user cart prizes
    public function get_cart_product_prizes($user_id , $offer_id = null){
        $req = "
            select cart_product_prizes.*,product_prizes.product_sku 
            from cart_product_prizes 
            inner join product_prizes on cart_product_prizes.prize_id=product_prizes.prize_id 
            right join cart on cart_product_prizes.cart_id=cart.id 
            where cart_product_prizes.user_id='$user_id'
        ";
        $req .= (!is_null($offer_id)) ? " AND cart_product_prizes.offer_id=$offer_id" : "";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];
    }

    // Save user cart prizes
    public function save_cart_product_prizes($prizes , $user_id , $offer_id){
        // Delete Old Combinations
        // $this->userModel->do_action("cart_product_prizes" , $user_id , "user_id" , "delete" , "" , "");
        if(sizeof($prizes) > 0){
            array_map(function($prize) use(&$user_id , &$offer_id){

                // Save prize
                $data = [
                    "prize_id" => $prize->prize_id,
                    "cart_id" => $prize->related_cart_id,
                    "offer_id" => $offer_id,
                    "description" => $prize->description,
                    "quantity" => $prize->quantity,
                    "user_id" => $user_id
                ];

                $this->userModel->do_action("cart_product_prizes" , "" , "" , "insert" , $data , "");
            } , $prizes);
        }
    }
}