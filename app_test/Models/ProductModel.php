<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class ProductModel extends Model
{
    // protected $table = 'users';
    // protected $primaryKey = 'user_id';
    // protected $allowedFields = ['name','phone'];
    public $current_d;
    // public $userModel=model('App\Models\UserModel'); 
    public $userModel;

    public $type_segments = [
        "video-games" =>["5"],
        "accessories" =>["7","26","27","28","29","30","31","34","37","62","64","67","72","76","93"],
        "pc-and-consoles" =>["18","36","45","77","82","83","84","92"],
        "merchandize" =>["41","43","46","47","50","51","52","54","55","58","59","60","61","88","95","96"],
    ];

    public function __construct(){
        $this->userModel= model('App\Models\UserModel');
        $this->categoryModel= model('App\Models\Category');
        // $this->$offerModel= model('App\Models\OfferModel');

        $this->type_segments["other"] = $this->get_types_list(true , "other");

        // $this->construct_type_segments();

        $this->current_d = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d h:i:s");
    }

    public function get_types_list($only_ids = true , $seg = "All"){
        $list = [];
        $req = "select type_id";
        $req .= ($only_ids) ? "" : ",title,arabic_title,precedence";
        $req .= " from type where status='Active'";

        if($seg == "other"){
            $cat_filter = implode("," , array_unique(array_merge($this->type_segments["video-games"] , $this->type_segments["accessories"] , $this->type_segments["pc-and-consoles"] , $this->type_segments["merchandize"])));
            $req .= " AND type_id NOT IN ($cat_filter)";
        }

        $res = $this->userModel->customQuery($req);
        if($res && !is_null($res)){
            if($only_ids)
            array_walk($res , function($type) use(&$list){
                array_push($list , $type->type_id);
            });
            else
            $list = $res;
        }

        return $list;
    }

    // Home page section - fetching data
    public function home_best_offers(){
        
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");

        $sql="select * from products 
        where status='Active' 
        AND products.product_nature <>'Variation' 
        AND show_this_product_in_home_page='Yes' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        order by precedence asc limit 20";
        $list=$this->userModel->customQuery($sql);
        

        return $list;
    }
    
    public function home_new_arrivales(){
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND (
            ( 
            TIMESTAMP('".$this->current_d."') between products.new_from and products.new_until 
            )
            OR
            (
                new_until='0000-00-00 00:00:00'
                OR new_until=''
                OR new_until is null
            )
            )
        AND set_as_new = 'Yes' 
        AND pre_order_enabled <> 'Yes'";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function home_new_arrivales_softwares(){
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND products.product_nature <>'Variation' 
        AND show_this_product_in_home_page='Yes' 
        AND (
            ( 
            TIMESTAMP('".$this->current_d."') between products.new_from and products.new_until 
            )
            OR
            (
                new_until='0000-00-00 00:00:00'
                OR new_until=''
                OR new_until is null
            )
            )
        AND set_as_new = 'Yes' 
        AND products.type='5' 
        AND pre_order_enabled <> 'Yes'";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }
    

    public function home_new_arrivales_accessories(){
        
        
        // $sql="select * from products where products.status='Active' AND products.product_nature <>'Variation' AND show_this_product_in_home_page='Yes' AND products.precedence<'1000' AND (FIND_IN_SET('7',products.type) OR FIND_IN_SET('29',products.type)) AND pre_order_enabled<> 'Yes' ";
        $sql="select * from products 
        where products.status='Active' 
        AND products.product_nature <>'Variation' 
        AND show_this_product_in_home_page='Yes' 
        AND (
            ( 
            TIMESTAMP('".$this->current_d."') between products.new_from and products.new_until 
            )
            OR
            (
                new_until='0000-00-00 00:00:00'
                OR new_until=''
                OR new_until is null
            )
            )
        AND set_as_new = 'Yes' 
        AND FIND_IN_SET(products.type , '7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57') 
        AND pre_order_enabled<> 'Yes' ";
        $sql=$sql."order by created_at desc limit 18";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function home_coming_soon(){
        
        
        $sql="select * from products where products.status='Active' AND products.product_nature <>'Variation' AND show_this_product_in_home_page='Yes' and products.pre_order_enabled='Yes'";
        // $sql=$sql."order by products.precedence asc limit 6";
        $sql=$sql."order by products.release_date asc limit 12";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function home_more_games(){
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND products.product_nature <>'Variation' 
        AND show_this_product_in_home_page='Yes' 
        AND products.type=5 
        AND products.precedence>'1000'";
        $sql=$sql."order by precedence asc limit 20";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function home_more_accessories(){
        
        
        $sql="select * from products where products.status='Active' AND products.product_nature <>'Variation' AND show_this_product_in_home_page='Yes' AND FIND_IN_SET(products.type , '7,55,63,27,62,37,26,29,61,31,28,30,49,64,34,57') AND products.precedence>'1000' ";
        $sql=$sql."group by products.brand order by created_at desc limit 20";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function home_trending_products(){
        
        $cdate=date("Y-m-d");
        $sql="select * from products inner join trending_products on products.product_id=trending_products.product where '$cdate' between trending_products.start_date  AND trending_products.end_date AND products.status='Active' AND trending_products.status='Active' order by products.precedence asc limit 20";
        $list=$this->userModel->customQuery($sql);

        // var_dump($list);
        // die();

        return $list;
    }

    public function filter($filters){
        $cat_model=model("Category");
        $offerModel=model("OfferModel");
        $c_date =(new \DateTime("now"))->format("Y-m-d H:i:s");
        $sql=" ";
        $filter=array(
            "keyword"=>"products.name like",
            "type"=>"FIND_IN_SET",
            "show-offer"=>"products.discount_percentage > 0 
                            AND (
                                TIMESTAMP('".$c_date."') BETWEEN products.offer_start_date AND products.offer_end_date 
                                OR (products.offer_start_date is null AND products.offer_end_date is null) 
                                OR (products.offer_start_date='0000-00-00 00:00:00' AND products.offer_end_date='0000-00-00 00:00:00') 
                                ) ",
            "brand"=>"products.brand=",
            "suitable_for"=>"enabled",
            "regions"=>"enabled",
            "new_realesed"=>"enabled",
            "pre-order"=>"products.pre_order_enabled='Yes'",
            "freebie"=>"products.freebie=",
            "evergreen"=>"products.evergreen=",
            "exclusive"=>"products.exclusive=",
            "priceupto"=>"products.price <=",
            "age"=>"age=",
            "category" =>"enabled",
            "categoryList" =>"enabled",
            "genre"=>"enabled",
            "stock-status"=>"enabled",

        );
        $i=0;
        $j=0;
        $h=0;

        foreach($filters as $key => $value){
            if($filter[$key])
            $h++;
        }

        foreach ($filters as $key => $value) {
            # code...

            if($filter[$key]){

                if($i==0){
                    $sql.=" where ";
                    $i++;
                }

                    switch (true) {
                        case ($key == 'show-offer'):
                            # code...
                            $offers_cdn = explode("," , $filters["offer_cdn"]);
                            $has_specific_offer_filter = (isset($filters["offer_cdn"]) && sizeof($offers_cdn) > 0);
                            $sql = $sql . " ( ";

                            // Direct product discount
                            if(!$has_specific_offer_filter):
                            $sql = $sql . " (".$filter[$key].")";
                            // $sql .= " OR (offer_start_date='' OR offer_end_date='') ";
                            endif;
                            // Direct product discount
                        
                        
                        
                            // collect the offers condition filters (Brands, Categories, Types and product lists)
                            $offers_filters = $offerModel->get_offers_conditions_filters();
                        
                            // Filter the offer_filters if an is in the post filters
                            if($has_specific_offer_filter)
                            $offers_filters = array_filter($offers_filters , function($key)use($offers_cdn){
                                return in_array($key , $offers_cdn);
                            } , ARRAY_FILTER_USE_KEY);
                        
                            $sql_offer = "";
                        
                            foreach ($offers_filters as $c_filter) {
                                # code...
                            
                                $has_types = isset($c_filter["types"]) && sizeof($c_filter["types"]) > 0 ;
                                $has_brands = isset($c_filter["brands"]) && sizeof($c_filter["brands"]) > 0 ;
                                $has_categories = isset($c_filter["categories"]) && sizeof($c_filter["categories"]) > 0;
                            
                                $c_t = ($has_types && !isset($filters["type"])) || ($has_types && isset($filters["type"]) && sizeof(array_intersect($c_filter["types"] , explode("," , $filter["type"]))) > 0);
                                $c_b = ($has_brands && !isset($filters["brand"])) || ($has_brands && isset($filters["brand"]) && sizeof(array_intersect($c_filter["brands"] , $filter["brand"])) > 0);
                                $c_c = ($has_categories && !isset($filters["categoryList"])) || ($has_categories && isset($filters["categoryList"]) && sizeof(array_intersect($c_filter["categories"] , $filter["categoryList"])) > 0);

                                $c_sql = "";
                                if(isset($c_filter["products"])){
                                    $c_sql .= " FIND_IN_SET(products.product_id , '".implode("," , $c_filter["products"])."')";
                                } 
                                else{
                                
                                    if($c_t || $c_b || $c_c){
                                    
                                        // Offer Condition Type filter
                                        if(($c_t && !$has_brands && !$has_categories) || ($c_t && $c_b && !$has_categories) || ($c_t && $c_c && !$has_brands) || ($c_t && $c_b && $c_c)){
                                            $c_sql .= " FIND_IN_SET( products.type , '".implode("," , $c_filter["types"])."') ";
                                        }
                                    
                                        // Offer Condition Brand filter
                                        if(($c_b && !$has_types && !$has_categories) || ($c_b && $c_t && !$has_categories) || ($c_b && $c_c && !$has_types) || ($c_t && $c_b && $c_c)){
                                            $c_sql .= ($c_t) ? " AND " : "";
                                            $c_sql .= " FIND_IN_SET( products.brand , '".implode("," , $c_filter["brands"])."') ";
                                        }
                                    
                                        // Offer Condition Category filter
                                        if(($c_c && !$has_types && !$has_brands) || ($c_c && $c_t && !$has_brands) || ($c_c && $c_b && !$has_types) || ($c_t && $c_b && $c_c)){
                                            $k = 0;
                                            $c_sql .= ($has_types || $has_brands) ? " AND ( " : " ( ";
                                            foreach ($c_filter["categories"] as $category) {
                                                # code...
                                                $c_sql .= ($k > 0) ? " OR " : "" ;
                                                $c_sql .= " FIND_IN_SET('$category' , products.category)" ;
                                                $k++;
                                            }
                                            $c_sql .= ")";
                                        }
                                    
                                    }   
                                }

                                if(trim($c_sql) !== "")
                                $sql_offer .= ($co == 0) ? " ($c_sql) ": " OR ($c_sql)";
                                $co += (trim($c_sql) !== "") ? 1 : 0;
                            }

                            if(!$has_specific_offer_filter)
                            $sql .= (trim($sql_offer) !== "") ? " OR ($sql_offer)": "";
                            else
                            $sql .= (trim($sql_offer) !== "") ? " ($sql_offer)": "";
                        
                            // $sql .= (trim($sql_offer) !== "") ? " ($sql_offer)": "";
                            $sql = $sql . " ) ";


                            break;
                        case ($key =='pre-order'):
                            # code...
                            $sql.=$filter[$key];
                            break;

                        case ($key =='type'):
                            
                            $tab = explode("," , $value);
                            $sql .=" (";
                            foreach ($tab as $k => $v) {
                                # code...
                                if($k == 0)
                                $sql .= "FIND_IN_SET('".$v."' , products.type)";
                                else
                                $sql .= " OR FIND_IN_SET('".$v."' , products.type)";
                            }
                            $sql .=") ";
                            break;
                        
                        case ($key =='keyword'):
                            if(false):
                            $i = 0;
                            $words = explode(" " , $value);
                            $condition = "";
                            if(sizeof($words)>1){
                                foreach ($words as $k_word) {
                                    # code...
                                    if($i == 0)
                                    $condition .= " (".$filter[$key]." '%".$k_word."%' ";
                                    else
                                    $condition .= " and ".$filter[$key]." '%".$k_word."%' ";
                                    $i++;
                                }
                                $condition .= ") ";
                            }
                        
                            else {
                                # code...
                                $condition = "(".$filter[$key]." '%".$value."%' or products.sku ='".$value."') ";
                            
                            }
                            endif;
                
                            // $sql.=$condition;
                            $search_keyword = $this->search_product($value , false);
                            $sql.= $search_keyword["condition"];

                            break;

                        case ($key =='category'):
                            $sql.=$cat_model->subcat_query($value)." ";
                            break;

                        case ($key =='categoryList'):
                            $cats = explode("," , $value);
                            $cat_filter = "";
                            foreach ($cats as $key => $category_id) {
                                # code...
                                if($key == (sizeof($cats)-1))
                                $cat_filter .= " FIND_IN_SET('$category_id' , products.category) ";
                            
                                else
                                $cat_filter .= " FIND_IN_SET('$category_id' , products.category) OR";

                            }
                            $sql.=" ($cat_filter) ";
                            break;

                        case ($key =='new_realesed'):
                            $sql.="products.precedence < 1000 ";
                            break;

                        case ($key =='genre'):
                            $sql.="FIND_IN_SET('".$value."',products.color)";
                            break;

                        case ($key =='suitable_for'):
                            $tab = explode("," , $value);
                            $sql .=" (";
                            foreach ($tab as $k => $v) {
                                # code...
                                if($k == 0)
                                $sql .= "FIND_IN_SET('".$v."' , products.suitable_for)";
                                else
                                $sql .= " OR FIND_IN_SET('".$v."' , products.suitable_for)";
                            }
                            $sql .=") ";
                            break;

                        case ($key =='regions'):
                            $tab = explode("," , $value);
                            $sql .=" (";
                            foreach ($tab as $k => $v) {
                                # code...
                                if($k == 0)
                                $sql .= "FIND_IN_SET('".$v."' , products.regions)";
                                else
                                $sql .= " OR FIND_IN_SET('".$v."' , products.regions)";
                            }
                            $sql .=") ";
                            break;
                        case ($key =='new_realesed'):
                            if($value == "Yes")
                            $sql.= "precedence <= 1000";
                            break;
                        case ($key == 'stock-status'):
                            if($value == "in")
                            $sql.= "available_stock > 0";
                            else if($value == "out")
                            $sql.= "available_stock = 0";
                            break;


                        default:
                            # code...
                            $sql.=$filter[$key].$value;
                            break;
                    }
                    $sql .= ($j < $h-1) ? " AND " : "";
                
            }

            $j++;

        }        
        // echo($sql);die();
        return $sql;
    }

    public function home_pc_new_arrivales(){
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND (
            ( 
            TIMESTAMP('".$this->current_d."') between products.new_from and products.new_until 
            )
            OR
            (
                new_until='0000-00-00 00:00:00'
                OR new_until=''
                OR new_until is null
            )
            )
        AND set_as_new = 'Yes' 
        AND FIND_IN_SET('32',products.type)";
        $sql=$sql."order by precedence asc limit 6";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }

    public function get_brand_names($brands){
        
        $brands=array_map('trim',explode(",",$brands));
        $brand_names=array();
        if(is_array($brands)){
            foreach($brands as $v){
                $n=$this->userModel->customQuery("select title from brand where id ='".$v."'");
                
                array_push($brand_names,$n[0]->title);
            }
        }

        return implode(",",$brand_names);
    }
    
    public function get_brand_name($id){
        $req="select title from brand where id='".$id."'";
        $res = $this->userModel->customQuery($req);
        if($res)
        return $res[0]->title;
        return false;
    }

    public function get_product_types($array){
        
        $array=array_map('trim',explode(",",$array));
        $type_names=array();
        if(is_array($array)){
            foreach($array as $v){
                $n=$this->userModel->customQuery("select title from type where type_id ='".$v."'");
                
                array_push($type_names,$n[0]->title);
            }
        }
        

        return implode(",",$type_names);
    }

    public function get_product_genres($array){
        
        $array=array_map('trim',explode(",",$array));
        $genre_names=array();
        if(is_array($array)){
            foreach($array as $v){
                $n=$this->userModel->customQuery("select title from color where id =".$v);
                
                array_push($genre_names,$n[0]->title);
            }
        }
        

        return implode(",",$genre_names);
    }

    public function get_product_age($array){
        
        $array=array_map('trim',explode(",",$array));
        $ages=array();
        if(is_array($array)){
            foreach($array as $v){
                $n=$this->userModel->customQuery("select title from age where id ='".$v."'");
                
                array_push($ages,$n[0]->title);
            }
        }
       

        return implode(",",$ages);
    }

    public function get_suitable_for($array){
        
        $array=array_map('trim',explode(",",$array));
        $ages=array();
        if(is_array($array)){
            foreach($array as $v){
                $n=$this->userModel->customQuery("select title from suitable_for where id ='".$v."'");
                
                array_push($ages,$n[0]->title);
            }
        }
       

        return implode(",",$ages);
    }

    public function extract_root_categories($array){
        
        $parent=array();

        foreach($array as $v){
            if($v !== "0"){
                $p=$this->userModel->customQuery("select parent_id from master_category where category_id ='".$v."'");
                if($parent[0]->category_id == "0")
                array_push($parent,$p);
            }
        }
        return $parrent;

    }

    public function get_product_categories($array){
        
        $array=array_map('trim',explode(",",$array));
        $categories=array();


        
        if(is_array($array)){

            foreach($array as $v){
                if($v !== "0"){
                    $p=$this->userModel->customQuery("select category_name from master_category where category_id ='".$v."'");
                    array_push($categories,$p[0]->category_name);
                    
                }
            }
        }
       

        return implode(",",$categories);
    }

    public function get_product_image($id , $all = false , $link = true){
        
        $images = array();

        $req="select image from product_image where product='".$id."' and status ='Active'";
        $res=$this->userModel->customQuery($req);

        if($res !== null && $res){
            if($all && sizeof($res) > 1){
                foreach($res as $image){
                    array_push($images , base_url()."/assets/uploads/".$image->image);
                }
            }
            else
            $image=$res[0]->image;
        }

        if(!$all && $image !== "" && $link)
        return base_url()."/assets/uploads/".$image;

        else if(!$all && $image !== "" && !$link)
        return $image;

        else if($all && sizeof($images) > 1)
        return $images;

        else return "";
    }

    public function product_image_exist($sku , $image){
        $req = "select count(*) as no from products left join product_image on products.product_id = product_image.product where products.sku='$sku' and product_image.image='$image' and product_image.status='Active'";
        $res = $this->userModel->customQuery($req);

        if(is_null($res) || $res[0]->no == 0)
        return false;

        return true;
    }

    public function get_product_screenshots($id){
        
        $req="select image from product_screenshot where product='".$id."' and status ='Active'";
        $res=$this->userModel->customQuery($req);

        if($res !== null && $res){
            // $image=$res[0]->image;
            $screenshots=implode(",",array_map(function ($s){return base_url()."/assets/uploads/".$s;} , array_column($res,"image") ));
            
        }

        if($screenshots !== "")
        return $screenshots;

        else return "";
    }

    public function has_options($id){
        
        $req="select bundle_opt_enabled from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);

        if($res[0]->bundle_opt_enabled == "Yes")
        return true;

        else return false;
    }

    public function get_product_options($id,$opt_id){
        

        if($this->has_options($id) && is_array($opt_id)){
            // $req="select * from bundle_opt where product_id='".$id."' and id='".$opt_id."'";
            $req = "select bundle_opt.* from opt_group inner join bundle_opt on opt_group.id=bundle_opt.option_group_id where bundle_opt.id IN (".implode("," , $opt_id).") and opt_group.product_id='".$id."'";
            $res=$this->userModel->customQuery($req);
            if($res !== null && $res !== ""){   
                return $res;
            }

            else
            return false;
        }

        else
        return false;
    }

    public function is_discounted($id){
        
        $req="select discount_percentage from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);
        if($res[0]->discount_percentage > 0)
        return true;

        else return false;

    }

    public function get_discounted_percentage($offers_list , $id){
        $offerModel= model('App\Models\OfferModel');

        $discount = [
            "new_price" => 0,
            "discount_type" => "",
            "discount_value" => 0,
            "discount_amount" => 0,
        ];

        $req="select price,discount_percentage,offer_start_date,offer_end_date,discount_rounded,discount_type from products where product_id='".$id."'";
        $product=$this->userModel->customQuery($req);
        if($product){

            $discount_cond1 = $product[0]->discount_percentage > 0 && !$this->has_daterange_discount($product[0]->offer_start_date,$product[0]->offer_end_date);
            $discount_cond2 = $product[0]->discount_percentage > 0 && $this->has_daterange_discount($product[0]->offer_start_date,$product[0]->offer_end_date) && $this->is_date_valide_discount($id);
            if(($discount_cond1 || $discount_cond2) && !is_null($product[0]->discount_type)){
                // $discount["new_price"] = bcdiv($product[0]->price - ($product[0]->price * $product[0]->discount_percentage / 100) , 1 , 2);
                $discount["new_price"] = ($product[0]->discount_type == "percentage") ? $product[0]->price - ($product[0]->price * $product[0]->discount_percentage / 100) : $product[0]->price - $product[0]->discount_percentage;
                $discount["discount_type"] = $product[0]->discount_type;
                $discount["discount_value"] = $product[0]->discount_percentage;
                $discount["discount_amount"] = bcdiv(($product[0]->price * $product[0]->discount_percentage / 100) , 1 , 2);
            }

            elseif(is_null($offerModel->product_Get_N_offer_comply($id))){
                // Check valid Product applicable offer
                $offers = $offerModel->_get_valid_offers($offers_list , $id , null);
                // var_dump($offers);
                if(sizeof($offers) > 0){
                    $offer_application = $offerModel->_apply_offer($offers[0]);

                    if($offer_application == "Discount"){
                        $discount["discount_amount"] = ($offers[0]->discount_type == "Percentage") ? bcdiv(($product[0]->price * $offers[0]->discount_value / 100) , 1 , 2) : $offers[0]->discount_value;
                        $discount["new_price"] = ($product[0]->price - $discount["discount_amount"]);
                        $discount["discount_type"] = $offers[0]->discount_type;
                        $discount["discount_value"] = $offers[0]->discount_value;
                    }
                    
                }
            }
            $discount["new_price"] =  ($product[0]->discount_rounded == "Yes") ?  bcdiv(round($discount["new_price"]) , 1 , 2) : bcdiv($discount["new_price"] , 1 , 2);
        }
        return $discount;

    }

    public function has_daterange_discount($start,$end){
        

            switch (($start !== "" && $end !== "") && ($start !== "0000-00-00 00:00:00" && $end !== "0000-00-00 00:00:00") && ($start !== null && $end !== null)) {
                case 'true':
                    # code...
                    return true;
                    break;
                
                default:
                    # code...
                    return false;
                    break;
            }

        return false;
    }

    public function has_validity($start,$end){
        

            switch (($start !== "" && $end !== "") && ($start !== "0000-00-00 00:00:00" && $end !== "0000-00-00 00:00:00") && ($start !== null && $end !== null)) {
                case 'true':
                    # code...
                    return true;
                    break;
                
                default:
                    # code...
                    return false;
                    break;
            }

        return false;
    }

    public function is_date_valide_discount($id){
        $timezone = new \DateTimeZone(TIME_ZONE);
        $date = new \dateTime("now",$timezone);
        $res=$this->userModel->customQuery("select offer_start_date as start,offer_end_date as end from products where product_id='".$id."'");
        if($res && $this->has_daterange_discount($res[0]->start,$res[0]->end)){
            // ->setTimestamp(strtotime("10-06-2022 12:00:00"))
            $start = (new \dateTime($res[0]->start,$timezone));
            $end = (new \dateTime($res[0]->end,$timezone));

            if($end > $start && $date > $start && $date < $end){
                return true;
            }
            
        }
        return false;
    }

    public function is_valid($id){
        $timezone = new \DateTimeZone(TIME_ZONE);
        $date = new \dateTime("now",$timezone);
        $res=$this->userModel->customQuery("select valid_from as start,valid_until as end from products where product_id='".$id."'");
        if($res && $this->has_validity($res[0]->start,$res[0]->end)){
            // ->setTimestamp(strtotime("10-06-2022 12:00:00"))
            $start = (new \dateTime($res[0]->start,$timezone));
            $end = (new \dateTime($res[0]->end,$timezone));

            if($end > $start && $date > $start && $date < $end){
                return true;
            }

            else
            return false;
            
        }
        return true;
    }

    public function get_offer_date($id){
        $res=$this->userModel->customQuery("select offer_start_date as start,offer_end_date as end from products where product_id='".$id."'");
        if($res){
            return array("start"=>$res[0]->start,"end"=>$res[0]->end);
        }

        return false;
    }

    public function order_restricted($user_email,$p_id,$interval){
        
        $bool=false;
        $intervals=array(
            "Daily"=>"1",
            "Weekly"=>"7",
            "Monthly"=>"30",
        );

        $timezone=new \DateTimeZone(TIME_ZONE);
        $today =(new \DateTime("now"))->setTimezone($timezone);

        // $dd =(new \DateTime("2022-02-01"));

        $req="select MAX(order_products.created_at) as order_date from order_products inner join orders on order_products.order_id=orders.order_id where orders.email ='".$user_email."' AND orders.order_status<>'Canceled' AND order_products.product_id='".$p_id."'";
        $res=$this->userModel->customQuery($req);
        
        if(!is_null($res[0]->order_date)){
            $product_order_date=(new \DateTime($res[0]->order_date))->setTimezone($timezone);
            $diff=$product_order_date->diff($today);
            $s_diff=($diff->m*3600*24*30) + ($diff->d*3600*24) +($diff->h*3600) + ($diff->i*60) + ($diff->s);
            if(($s_diff) < ($intervals[$interval]*3600*24))
            $bool = true;
        }

        return $bool;
    }

    public function get_product_name($id){
        
        $req="select name from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);

        if($res)
        return $res[0]->name;
    }

    public function get_order_restriction_periode($id){
        
        $intervals=array(
            "Daily"=>"1",
            "Weekly"=>"7",
            "Monthly"=>"30",
        );
        $req="select order_interval from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);

        if($res)
        return $intervals[$res[0]->order_interval];
    }

    public function get_max_order_qty($id){
        
        $req="select max_qty_order from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);

        if($res)
        return $res[0]->max_qty_order;
        
        return false;
    }

    public function reduce_product_title($name){
        return substr($name, 0, 24).'..';
    }

    public function _discounted_price($id){
        
        $discounted_price=0;
        $req="select price,discount_percentage from products where product_id='".$id."'";
        $res=$this->userModel->customQuery($req);

        if($res){
            if($res[0]->discount_percentage > 0){
                $discounted_price = round(bcdiv($res[0]->price - ($res[0]->price * $res[0]->discount_percentage /100),1,2));
                return $discounted_price;
            }
        }
            
        
        return $discounted_price;
    }

    public function increment_stock($id,$qty){
        
        
        $res=$this->userModel->do_action("products",$id,"product_id","update",array("available_stock"=>$qty),"");

        if($res){
            return true;
        }

        return false;
    }
    
    public function get_product_list(){
        
        $req="select product_id,name from products order by precedence";
        $list = array();

        $res= $this->userModel->customQuery($req);
        if($res){
            foreach($res as $key => $value){
                $list[$value->product_id] = $value->name;
            }
        }

        return $list;
    }
    
    public function preorders_exist(){
        $bool=false;
        
        $req="select count(product_id) as c from products where products.status='Active' AND products.pre_order_enabled='Yes'";
        $res=$this->userModel->customQuery($req);

        if($res){
            if($res[0]->c > 0)
            $bool=true;
        }

        return $bool;
    }

    public function offers_exist(){
        $bool=false;
        // BEST OFFERS
		$offers_filter = [
            "showOffer" => "yes",
            "limit" => 10,
        ];
        $offers = $this->product_filter_query($offers_filter);

        if(!is_null($offers["product"]) && sizeof($offers["product"]) > 0){
            $bool=true;
        }

        return $bool;
    }
    
    public function search_product($keyword , $result = true){
        $res = false;
        $words = explode(" " , $keyword);
        if($keyword !== null && trim($keyword) !== ""){
            
            if(is_arabic_text($keyword))
            $condition = "products.arabic_name like '%".$keyword."%' and (products.arabic_name is not null or products.arabic_name<>'')";

            else{
                $score_line="";
                $condition .= "((products.name REGEXP '[[:<:]]".str_replace("'" , "''" , $keyword)."')";
                $score_line.="(products.name REGEXP '[[:<:]]".str_replace("'" , "''" , $keyword)."')";
                preg_match("/\D+/" , $keyword , $match);
                if(sizeof($words) > 0 && sizeof($match) > 0){
                    $condition .= " OR ";
                    $score_line .= " + ";
                    for($i = 0 ; $i < sizeof($words) ; $i++) {
                        $metaphone = metaphone($words[$i]);
                        $score_line .= " (products.name REGEXP '[[:<:]]".str_replace("'" , "''" , $words[$i])."' OR products.indexing like '%$metaphone%') ";
                        $condition .= " (products.name REGEXP '[[:<:]]".str_replace("'" , "''" , $words[$i])."' OR products.indexing like '%$metaphone%') ";
                        // $score_line .= " (products.name like '%".str_replace("'" , "''" , $words[$i])."%' OR products.indexing like '%$metaphone%') ";
                        // $condition .= " (products.name like '%".str_replace("'" , "''" , $words[$i])."%' OR products.indexing like '%$metaphone%') ";
                        if($i < sizeof($words)-1){
                            $score_line .= " + ";
                            $condition .= " OR ";
                        }
                        
                    }
                }
                else{
                    $condition .= " or (products.sku = '".$keyword."')";
                }
                $condition.=") ";
                // $condition .= (sizeof($words) > 1) ? " and match_score > 1 " : "";
                $score_line.=" AS match_score ";
            }

            if($result){
                $score_limit = (sizeof($words) > 1) ? sizeof($words) : 0 ;
                $req = "select 
                *,
                match_score 
                from (
                select
                product_image.image,
                products.product_id,
                products.name,products.arabic_name,
                products.price,
                products.discount_percentage,
                ".$score_line." 
                from products 
                inner join product_image on products.product_id=product_image.product 
                where ".$condition." 
                and products.product_nature in ('Variable','Simple') 
                and products.status='Active' ) as sub_query 
                where match_score >= $score_limit
                group by sub_query.product_id 
                order by match_score DESC limit 20";
                // echo $req;
                $result = $this->userModel->customQuery($req);
                if($result !== null && $result)
                $res = $result;
            }
            else
            $res = ["condition" => $condition , "score" => $score_line];
        }
        // var_dump($req);
        return $res;
    }

    public function createurl($slug){
        if(trim($slug) !== ""){
            $url = preg_replace("/(\s'|@ù!:;,\*\.\$\^)+/" , "-" , trim($slug));
            return $url;
        }

        else return false;
    }

    public function get_product_id_from_slug($slug , $all=false){
        if(!$all)
        $id = $this->userModel->customQuery("select product_id from products where slug='".$slug."'");
        else
        $id = $this->userModel->customQuery("select * from products where slug='".$slug."'");
        
        if($id){
            return $id[0];
        }

        else{
            if(!$all)
            $id = $this->userModel->customQuery("select product_id from products where product_id='".$slug."'");
            else
            $id = $this->userModel->customQuery("select * from products where product_id='".$slug."'");

            if($id)
            return $id[0];
        }

        return false;
    }

    public function get_product_sku_from_id($id){

        
        $req = "select sku from products where product_id='$id'";
        $res = $this->userModel->customQuery($req);

        if($res && !is_null($res))
        return $res[0]->sku;

        return null;
    }
    
    public function product_exist($id){
        $res = $this->userModel->customQuery("select product_id from products where product_id='".$id."'");
        if($res)
        return true;
        return false;
    }

    public function get_product_slug($id){
        $slug = $this->userModel->customQuery("select slug from products where product_id='".$id."'");
        if($slug){
            return $slug[0]->slug;
        }
        return false;
    }

    public function getproduct_url($id){
        $slug = $this->get_product_slug($id);

        if($slug && trim($slug) !== "")
            return base_url()."/product/".$slug;
        else
            return base_url()."/product/".$id;
    }

    public function product_urls($variables = true){
        $urls = array();
        $sql = "select product_id from products where status='Active'";
        $sql .= ($variables) ? "" : " AND product_nature in ('Variation','Simple')";
        $list = $this->userModel->customQuery($sql);
        if($list){
            foreach($list as $id){
                $urls[$id->product_id] = $this->getproduct_url($id->product_id);
            }

            return $urls;
        }

        return false;
    }

    public function getlastmodified($id){
        $date = $this->userModel->customQuery("select updated_at from products where product_id='".$id."'");
        if($data){
            var_dump($data[0]->updated_at);die();
            return $data[0]->updated_at;
        }
        
        return false;
    }
    
    public function calculate_vat($price , $quantity){
        $vat = 0;
        if($price > 0){
            $vat =  ($price - ($price/1.05))* $v->quantity;
        }
        
        return $vat;

    }
    
    public function get_product_name_from_slug($slug){
        $req = "select name from products where slug='".$slug."'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res[0]->name;
        }

        else 
        return $this->get_product_name($slug);

        return false;
    }
    
    public function get_attributes($id){
        $req="select attributes from products where product_id='".$id."' and product_nature='Variable'";
        $res = $this->userModel->customQuery($req);

        if($res && trim($res[0]->attributes) !== ""){
            return explode(',' , $res[0]->attributes);
        }

        return array();
    }

    public function get_variations($id , $attribute_id=null){
        // $productModel = model("App\Models\ProductModel");
        $req = "select attribute_variation from products where product_id='".$id."'";

        $res = $this->userModel->customQuery($req);

        if($res && trim($res[0]->attribute_variation !== "" && $res[0]->attribute_variation !== null)){
            return json_decode($res[0]->attribute_variation);
        }

        return array();
    }
    
    public function product_nature($id){
        $req = "select product_nature from products where product_id='".$id."'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res[0]->product_nature;
        }

        return null;
    } 

    public function get_product_id_from_sku($sku){
        $req = "select product_id from products where sku='".$sku."'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res[0]->product_id;
        }

        return null;
    }

    // Select specific option values on variations that have specific value for a specific attribute
    public function get_product_options_on_attribute($att_id=null , $opt_val=null , $att_id_requested , $parent_id){
        if($opt_val !== null && $att_id !== null){
            $req = "select available_stock,json_extract(attribute_variation, '$[0].\"".$att_id_requested."\"') as option_id from products where json_extract(attribute_variation, '$[0].\"".$att_id."\"') = '".$opt_val."' and parent='".$parent_id."' and product_nature='Variation' and status='Active'";
        }

        else{
            $req = "select available_stock,json_extract(attribute_variation, '$[0].\"".$att_id_requested."\"') as option_id from products where parent='".$parent_id."' and product_nature='Variation' and status='Active' group by option_id";
        }

        // echo($req);die();
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }
    }

    public function get_all_product_variations($id){
        $attributes = $this->get_attributes($id);

        // var_dump($attributes);

        if(sizeof($attributes) > 0){
            // var_dump($this->get_product_options_on_attribute($attributes[0] , '2' , '2'));

            $req = "select attribute_variation from products where parent ='".$id."' and attribute_variation is not null";
            $res = $this->userModel->customQuery($req);

            $variations = array();

            // var_dump(json_decode($res[0]->attribute_variation)[0]);
            if($res){
                foreach($res as $var){
                    $variation = json_decode($var->attribute_variation);
                    // var_dump($variation);
                }
            }
        }


        return null;
    }

    public function get_product_from_variation($variations , $parent){
        $attributeModel = model("App\Models\AttributeModel");
        // var_dump(sizeof($variations));
        if(sizeof($variations) > 0 && $attributeModel->is_valid_variation($variations , $parent)){
            $i = 1;
            // $req = "select products.*,product_image.image from products inner join product_image on products.product_id=product_image.product where ";
            $req = "select products.* from products where ";
            foreach($variations as $variation){
                $var = explode(":" , $variation);
                $req .= "json_extract(products.attribute_variation, '$[0].\"".$var[0]."\"') = '".$var[1]."'";

                if($i < sizeof($variations))
                $req .= " And ";

                $i++;
            }
            $req.= " And parent ='".$parent."' group by products.product_id";

            $res = $this->userModel->customQuery($req);
            if($res)
            return $res[0];

        }
    }

    public function get_variation_total_stock($variations , $parent){
        $attributeModel = model("App\Models\AttributeModel");

        if(sizeof($variations) > 0 && $attributeModel->is_valid_variation($variations , $parent)){
            $i = 1;
            $req = "select sum(available_stock) as total from products where ";
            foreach($variations as $variation){
                $var = explode(":" , $variation);
                $req .= "json_extract(attribute_variation, '$[0].\"".$var[0]."\"') = '".$var[1]."'";

                if($i < sizeof($variations))
                $req .= " And ";

                $i++;
            }
            
            $req.= " And parent ='".$parent."'";
            $res = $this->userModel->customQuery($req);
            if($res)
            return (int)$res[0]->total;

        }

        return 0;
    }

    public function get_roduct_image_from_variation_option($attribute_id , $option , $parent){
        $attributeModel = model("App\Models\AttributeModel");

        if($attributeModel->attributes_exist(array($attribute_id))){
            $req = "select product_image.image from product_image inner join products on product_image.product=products.product_id where products.parent='".$parent."' and json_extract(products.attribute_variation, '$[0].\"".$attribute_id."\"') = '".$option."' group by product_image.product";
            // echo($req);
            $res = $this->userModel->customQuery($req);

            if($res)
            return $res[0]->image;
        }

        return null;
    }

    public function product_has_atribute_option($attribute , $option , $product_id){
        $req = "select count(attribute_variation) as op from products where json_extract(attribute_variation , '$[0].\"".$attribute."\"') = '".$option."' and product_id='".$product_id."'";
        $res = $this->userModel->customQuery($req);
        if($res && $res[0]->op > 0)
        return true;

        return false;
    }

    public function get_product_infos($id , $variable = true){
        $req = "select * from products where product_id='".$id."'";
        // $req .= ($variable) ? "" : " AND product_nature in ('Variation' , 'Simple')"; 
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res[0];
        }

        else return false;
    }

    public function get_gp_list(){
        $req = "select * from google_product_categories";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        else return false;
    }

    public function get_gp_category_name($id){
        $req = "select category from google_product_categories where id=".$id;
        $res = $this->userModel->customQuery($req);

        if($res && $res !== null)
        return $res[0]->category;
        
        return null;

    }

    public function is_discount_rounded($product_id){
        $req = "select discount_rounded from products where product_id='".$product_id."'";
        $res = $this->userModel->customQuery($req);

        if($res && $res != null)
        return $res[0]->discount_rounded;
        else
        return null;
    }
    
    public function is_valid_bundle_options($bundle_opt , $additional_price){
        $bool = true;

        if(sizeof($bundle_opt) > 0 && sizeof($additional_price) > 0){
            foreach($bundle_opt as $key => $group){
                if(sizeof($group) < 2 || sizeof($additional_price[$key]) < 2)
                $bool = false;
            }
        }
        else $bool = false;

        return $bool;
    }

    public function delete_product_bundle_options($product_id){
        $res = $this->do_action("opt_group" , $product_id , "product_id" , "delete" , "" , "");
        if($res !== null )
        return true;
        else return false;

    }

    public function create_product_bundle_options($bundle_opt , $additional_price , $product_id){
        foreach($bundle_opt as $key => $group){
            $group_id = $this->userModel->do_action("opt_group" , "" , "" , "insert" , ["product_id" => $product_id] , "");
            foreach($group as $k => $option){
                $this->userModel->do_action("bundle_opt" , "" , "" , "insert" , [
                    "option_group_id" => $group_id,
                    "option_title" => $option,
                    "additional_price" => $additional_price[$key][$k]
                ] , "");
            }
        }
    }

    public function get_bundle_options_on_group_id($group_id , $return_size=false){
        $options = array();
        $req = "select bundle_opt.* from bundle_opt where option_group_id=".$group_id;
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            foreach($res as $option){
                array_push($options , array(
                    "option_id" => $option->id,
                    "option_title" => $option->option_title,
                    "additional_price" => $option->additional_price
                ));
            }

            
        }
        if(!$return_size)
        return $options;
        else return sizeof($options);
    }

    public function get_bundle_option_groups($product_id , $return_size=false){
        $groups = array();
        $req = "select opt_group.* from opt_group where product_id='".$product_id."'";
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            foreach($res as $group){
                array_push($groups , $group->id);
            }
        }
        
        if(!$return_size)
        return $groups;
        else 
        return sizeof($groups);
    }

    public function cart_product_bundle_total_additional_price($options){
        $total_addition = 0;
        if(sizeof($options) > 0){
            foreach($options as $option){
                $total_addition += $option->additional_price;
            }
        }
        // var_dump($total_addition);
        return $total_addition;
    }

    public function cart_product_bundle_total_additional_title($options){
        $total_addition = "";
        if(sizeof($options) > 0){
            foreach($options as $option){
                $total_addition .= " + ".$option->option_title;
            }
        }
        // var_dump($total_addition);
        return $total_addition;
    }
    
    public function is_in_stock($id , $qty){
        $req = "select available_stock,sku from products where product_id='".$id."'";
        $res = $this->userModel->customQuery($req);
        // var_dump($res);die();
        if(!is_null($res) && isset($res[0]->available_stock) && $res[0]->available_stock>0 && $res[0]->available_stock >= $qty)
        return true;
        return false;
    }
    
    public function products_in_cart($cart_id = null , $product_id = null){

        $session = session();
        if ($session->get("userLoggedin")) {
            @$user_id = $session->get("userLoggedin");
        } else {
            @$user_id = session_id();
        }

        $condition = (!is_null($cart_id)) ? " AND cart.id = $cart_id" : "";
        $condition .= (!is_null($product_id)) ? " AND products.product_id = '$product_id'" : "";

        $req = "select product_image.image,y_cart.* from (select products.product_id,products.name,cart.quantity,cart.id as cart_id from cart inner join products on cart.product_id=products.product_id where cart.user_id='".$user_id."' $condition) as y_cart left join product_image on y_cart.product_id=product_image.product group by y_cart.product_id ";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) !== 0){
            return $res;
        }

        return false;
    }

    public function total_cart(){
        $session = session();
        if ($session->get("userLoggedin")) {
            @$user_id = $session->get("userLoggedin");
        } else {
            @$user_id = session_id();
        }

        $html="";

        $req = "select count(id) as totalcart from cart where user_id='".$user_id."'";
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            return $res[0]->totalcart;
        }

        return false;
    }
    
    public function get_product_stock($product_id , $variable=false){
        $stock = 0;
        if($variable)
        $req = "select sum(available_stock) as available_stock from products where parent='".$product_id."'";
        else
        $req = "select available_stock from products where product_id='".$product_id."'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        $stock = (int) $res[0]->available_stock;

        return $stock;
    }

    public function is_new($id){
        $req = "select set_as_new,new_from,new_until from products where product_id='".$id."'";
        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res)>0){

            switch ($res[0]->set_as_new) {
                case 'Yes':
                    # code...
                    $date = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)));
                    $from = (new \DateTime($res[0]->new_from , new \DateTimeZone(TIME_ZONE)));
                    $until = (new \DateTime($res[0]->new_until , new \DateTimeZone(TIME_ZONE)));

                    $valid_date_cond1 = ($res[0]->new_from !== "" && !is_null($res[0]->new_from) && $res[0]->new_from !== "0000-00-00 00:00:00");
                    $valid_date_cond2 = ($res[0]->new_until !== "" && !is_null($res[0]->new_until) && $res[0]->new_until !== "0000-00-00 00:00:00");
                    if($valid_date_cond1 && $valid_date_cond2){
                        $cond3 = ($until > $from && $date > $from && $date < $until);
                        if(!$cond3)
                        return false;
                    }
                    
                    return true;
                    break;
                
                default:
                    # code...
                    return false;
                    break;
            }

        }

        return false;
    }

    public function invalid_active_product_list(){
        $current_date = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        $req = "
        select product_id,sku 
        from products 
        where status='Active' 
        AND (TIMESTAMP('".$current_date."') > valid_from) 
        AND (TIMESTAMP('".$current_date."') > valid_until) 
        AND (valid_from <> '0000-00-00 00:00:00')
        AND (valid_until <> '0000-00-00 00:00:00')
        AND (valid_from is not NULL and valid_until is not NULL)
        ";


        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res;
        }
        return [];
    }
    public function valid_inactive_product_list(){
        $current_date = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        $req = "
        select product_id,sku 
        from products 
        where status='Inactive' 
        AND (TIMESTAMP('".$current_date."') > valid_from) 
        AND (TIMESTAMP('".$current_date."') < valid_until) 
        AND (valid_from <> '0000-00-00 00:00:00')
        AND (valid_until <> '0000-00-00 00:00:00')
        AND (valid_from is not NULL and valid_until is not NULL)
        ";


        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res;
        }
        return [];
    }

    public function parent_variation_products($id){
        $req = "select * from products where parent='".$id."' and status='Active'";
        $res = $this->userModel->customuery($req);

        if($res && sizeof($res) > 0){
            return $res;
        }

        return [];  
    }

    public function parent_discounted_variation($id){
        $discounts = [];
        $max_discount = 0;
        $children = $this->parent_variation_products($id);
        if(sizeof($children) > 0){
            foreach ($children as $variation) {
                # code...
                $discount = $this->get_discounted_percentage([] , $variation->product_id);
                $max_discount = ($discount[""] > $max_discount) ? $discount : $max_discount;
                array_push($discounts , $discount);
            }

            return max($discounts);
        }

        return 0;
    }

    public function product_variable_price($product){
        $prices = [];
        $children = $this->parent_variation_products($product->product_id);
        if(sizeof($children) > 0){
            foreach ($children as $variation) {
                # code...
                $price = $variation->price;
                array_push($prices , $price);
            }

            return min($discounts);
        }

        return $product->price;
    }

    // Back to School product carousels
    public function bts_videogames(){
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND products.product_nature <>'Variation' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        AND FIND_IN_SET(products.type , '5')"; 
        // AND FIND_IN_SET('6', products.color)";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);

        return $list;
    }
    public function bts_controllers(){
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND products.product_nature <>'Variation' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        AND FIND_IN_SET(products.type , '27')";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);
        return $list;
    }
    public function bts_figurines(){
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND products.product_nature <>'Variation' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        AND FIND_IN_SET(products.type , '41')";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);
        return $list;
    }
    public function bts_consoles(){
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND products.product_nature <>'Variation' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        AND FIND_IN_SET(products.type , '18')";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);
        return $list;
    }
    public function bts_monitors(){
        $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        
        
        $sql="select * from products 
        where products.status='Active' 
        AND show_this_product_in_home_page='Yes' 
        AND products.product_nature <>'Variation' 
        AND discount_percentage>0 
        AND ( 
            ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
            OR (offer_start_date='' OR offer_end_date='') 
            OR (offer_start_date='0000-00-00 00:00:00' 
            OR offer_end_date='0000-00-00 00:00:00') 
            OR (offer_start_date IS NULL 
            OR offer_end_date IS NULL)
            ) 
        AND FIND_IN_SET(products.type , '42')";
        $sql=$sql."order by precedence asc limit 12";
        $list=$this->userModel->customQuery($sql);
        return $list;
    }
    // Back to School product carousels

    // Get product's top level category
    public function get_product_top_level_category($product_id){
        
        $categoryModel = model("App\Models\Category");
        $category_name = "Gaming";

        $req = "select category from products where product_id='$product_id'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0 && trim($res[0]->category) !== ""){
            $categories = explode("," , $res[0]->category);
            if(isset($categories[1]))
            $category_name = $categoryModel->_getcatname($categories[1]);
        }

        return $category_name;
    }

    // SQL build prodcut filter Query
    public function product_filter_query($filter){
        $categoryModel = model("App\Models\Category");
        $offerModel = model("App\Models\OfferModel");
        $data = [];
        $sql = $order_by = $keywords_score= $groupby ="";
        $limit = (isset($filter["limit"])) ? $filter["limit"] : 52;
        // var_dump($filter);
        // die();
        if ($master_category = $filter["master_category"]) {
            $sub_categories = $categoryModel->_subcat($master_category , false , true);
            

            $sql .=
                " AND (FIND_IN_SET('" .
                $master_category .
                "',products.category) ";

            if (sizeof($sub_categories) > 0) {
                $sql .= " OR ";
                foreach ($sub_categories as $key => $value) {
                    # code...
                    if ($key < sizeof($sub_categories) - 1) {
                        $sql .= " FIND_IN_SET('$value', products.category)  OR ";
                    } else {
                        $sql .= " FIND_IN_SET('$value', products.category) ";
                    }
                }
            }

            foreach ($sub_categories as $key => $value) {
                # code...
                $sub_sub_categories = $categoryModel->_subcat($value , false , true);
                // echo(sizeof($sub_sub_categories));

                if (sizeof($sub_sub_categories) > 0) {
                    $sql .= " OR ";

                    foreach ($sub_sub_categories as $kkey => $vvalue) {
                        # code...
                        if ($kkey < sizeof($sub_sub_categories) - 1) {
                            $sql .= " FIND_IN_SET('$vvalue', products.category)  OR ";
                        } else {
                            $sql .= " FIND_IN_SET('$vvalue', products.category) ";
                        }
                    }
                }
            }
            $sql .= " ) ";
        }
        if ($id1 = $filter["categoryList"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql .
                        "      FIND_IN_SET('$v', products.category)  ";
                } else {
                    $sql =
                        $sql .
                        "   OR  FIND_IN_SET('$v', products.category)  ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($cat = $filter["keyword"]) {
            // $cat = preg_replace("/'/","\'",$cat);                
            $words = explode(" " , $cat);
            $search_keyword = $this->search_product($cat , false);
            $keywords_score = $search_keyword["score"];
            $condition = $search_keyword["condition"];
            $sql .= " AND ".$condition;
            // $sql = $sql . "   AND  (products.name like '%$cat%' or products.sku='".$cat."')  ";
        }
        if ($id1 = $filter["offer"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql . "      products.discount_percentage='$v'  ";
                } else {
                    $sql =
                        $sql .
                        "   OR   products.discount_percentage='$v'  ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["brand"]) {
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
        if ($id1 = $filter["preOrder"]) {

            if ($id1[0] == "Yes") {
                $sql =
                    $sql .
                    "  AND    (     products.pre_order_enabled='$id1[0]'  ";
            }
            
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["freebie"]) {
            if ($id1[0] == "Yes") {
                $sql = $sql . "  AND    (     products.freebie='$id1[0]'  ";
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["evergreen"]) {
            if ($id1[0] == "Yes") {
                $sql =
                    $sql . "  AND    (     products.evergreen='$id1[0]'  ";
            }
           
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["exclusive"]) {
            if ($id1[0] == "Yes") {
                $sql =
                    $sql . "  AND    (     products.exclusive='$id1[0]'  ";
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["priceupto"]) {
            $sql = $sql . "   AND    ( products.price <= '$id1' )";
        }
        if ($id1 = $filter["show_in_homepage"]) {
            $sql = $sql . "   AND    ( products.show_this_product_in_home_page = '$id1' )";
        }
        if ($id1 = $filter["precedence"]) {
            $sql = $sql . "   AND    ( products.precedence >= '$id1' )";
        }
        if ($id1 = $filter["showOffer"]) {
            $today = (new \dateTime("now",new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
            if ($id1 == "yes") {
                $offers_cdn = explode("," , $filter["offer_cdn"]);
                $has_specific_offer_filter = (isset($filter["offer_cdn"]) && sizeof($offers_cdn) > 0);
                $sql = $sql . " AND ( ";

                // Direct product discount
                if(!$has_specific_offer_filter):
                $sql = $sql . "
                (
                products.discount_percentage > 0 
                AND (
                        ( '".$today."' BETWEEN offer_start_date  AND offer_end_date ) 
                        OR (offer_start_date='0000-00-00 00:00:00' 
                        OR offer_end_date='0000-00-00 00:00:00') 
                        OR (offer_start_date IS NULL OR offer_end_date IS NULL) 
                    )
                )";
                // $sql .= " OR (offer_start_date='' OR offer_end_date='') ";
                endif;
                // Direct product discount



                // collect the offers condition filters (Brands, Categories, Types and product lists)
                $offers_filters = $offerModel->get_offers_conditions_filters();

                // Filter the offer_filters if an is in the post filters
                if($has_specific_offer_filter)
                $offers_filters = array_filter($offers_filters , function($key)use($offers_cdn){
                    return in_array($key , $offers_cdn);
                } , ARRAY_FILTER_USE_KEY);

                $sql_offer = "";

                foreach ($offers_filters as $c_filter) {
                    # code...

                    $has_types = isset($c_filter["types"]) && sizeof($c_filter["types"]) > 0 ;
                    $has_brands = isset($c_filter["brands"]) && sizeof($c_filter["brands"]) > 0 ;
                    $has_categories = isset($c_filter["categories"]) && sizeof($c_filter["categories"]) > 0;

                    $c_t = ($has_types && !isset($filter["type"])) || ($has_types && isset($filter["type"]) && sizeof(array_intersect($c_filter["types"] , $filter["type"])) > 0);
                    $c_b = ($has_brands && !isset($filter["brand"])) || ($has_brands && isset($filter["brand"]) && sizeof(array_intersect($c_filter["brands"] , $filter["brand"])) > 0);
                    $c_c = ($has_categories && !isset($filter["categoryList"])) || ($has_categories && isset($filter["categoryList"]) && sizeof(array_intersect($c_filter["categories"] , $filter["categoryList"])) > 0);
                    
                    $c_sql = "";
                    if(isset($c_filter["products"])){
                        $c_sql .= " FIND_IN_SET(products.product_id , '".implode("," , $c_filter["products"])."')";
                    } 
                    else{

                        if($c_t || $c_b || $c_c){

                            // Offer Condition Type filter
                            if(($c_t && !$has_brands && !$has_categories) || ($c_t && $c_b && !$has_categories) || ($c_t && $c_c && !$has_brands) || ($c_t && $c_b && $c_c)){
                                $c_sql .= " FIND_IN_SET( products.type , '".implode("," , $c_filter["types"])."') ";
                            }

                            // Offer Condition Brand filter
                            if(($c_b && !$has_types && !$has_categories) || ($c_b && $c_t && !$has_categories) || ($c_b && $c_c && !$has_types) || ($c_t && $c_b && $c_c)){
                                $c_sql .= ($c_t) ? " AND " : "";
                                $c_sql .= " FIND_IN_SET( products.brand , '".implode("," , $c_filter["brands"])."') ";
                            }

                            // Offer Condition Category filter
                            if(($c_c && !$has_types && !$has_brands) || ($c_c && $c_t && !$has_brands) || ($c_c && $c_b && !$has_types) || ($c_t && $c_b && $c_c)){
                                $k = 0;
                                $c_sql .= ($has_types || $has_brands) ? " AND ( " : " ( ";
                                foreach ($c_filter["categories"] as $category) {
                                    # code...
                                    $c_sql .= ($k > 0) ? " OR " : "" ;
                                    $c_sql .= " FIND_IN_SET('$category' , products.category)" ;
                                    $k++;
                                }
                                $c_sql .= ")";
                            }

                        }   
                    }
                    
                    if(trim($c_sql) !== "")
                    $sql_offer .= ($co == 0) ? " ($c_sql) ": " OR ($c_sql)";
                    $co += (trim($c_sql) !== "") ? 1 : 0;
                }
                
                if(!$has_specific_offer_filter)
                $sql .= (trim($sql_offer) !== "") ? " OR ($sql_offer)": "";
                else
                $sql .= (trim($sql_offer) !== "") ? " ($sql_offer)": "";

                // $sql .= (trim($sql_offer) !== "") ? " ($sql_offer)": "";
                $sql = $sql . "   ) ";
            }
        }
        if (isset($filter["type"]) || (isset($filter["ws-search-category"]) && array_key_exists($filter["ws-search-category"] , $this->type_segments))) {
            if(array_key_exists($filter["ws-search-category"] , $this->type_segments)){
                $id1 = (isset($filter["type"])) 
                ? array_unique(array_merge($filter["type"] ,$this->type_segments[$filter["ws-search-category"]])) 
                : $this->type_segments[$filter["ws-search-category"]];
            }
            else
            $id1 = $filter["type"];
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql = $sql . " FIND_IN_SET($v , products.type) ";
                } else {
                    $sql = $sql . " OR FIND_IN_SET($v , products.type) ";
                }
            }
            // $sql .= "FIND_IN_SET(products.type , '".implode(',' , $id1)."')";
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["color"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql . "         FIND_IN_SET($v , products.color) ";
                } else {
                    $sql =
                        $sql .
                        "   Or     FIND_IN_SET($v , products.color)   ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["age"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql . "        FIND_IN_SET($v , products.age)  ";
                } else {
                    $sql =
                        $sql . "   OR    FIND_IN_SET($v , products.age)  ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["suitable_for"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql .
                        "       FIND_IN_SET($v , products.suitable_for)  ";
                } else {
                    $sql =
                        $sql .
                        "   OR    FIND_IN_SET($v , products.suitable_for)  ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($id1 = $filter["regions"]) {
            $sql = $sql . "   AND    ( ";
            foreach ($id1 as $k => $v) {
                if ($k == 0) {
                    $sql =
                        $sql .
                        "       FIND_IN_SET($v , products.regions)  ";
                } else {
                    $sql =
                        $sql .
                        "   OR    FIND_IN_SET($v , products.regions)  ";
                }
            }
            $sql = $sql . "   ) ";
        }
        if ($new_r = $filter["new_realesed"]) {
            if ($new_r[0] == "Yes") {
                $current_d = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d h:i:s");
                // $sql = $sql . " AND  products.precedence < 1000 AND pre_order_enabled<>'Yes'";
                $sql = $sql . " 
                AND (
                    ( 
                    TIMESTAMP('".$current_d."') between products.new_from and products.new_until 
                    )
                    OR
                    (
                        new_until='0000-00-00 00:00:00'
                        OR new_until=''
                        OR new_until is null
                    )
                    )
                AND set_as_new = 'Yes'
                AND pre_order_enabled<>'Yes'
                ";

            }
        }
        if ($stock_status = $filter["stock_status"]) {

            $sql .= (in_array("in" , $stock_status)) ? " AND available_stock > 0 " : "";
            $sql .= (in_array("out" , $stock_status)) ? " AND available_stock = 0 " : "";
            
        }

        if(isset($filter["groupby"]) && in_array($filter["groupby"] , ["brand" , "type"])){
            $groupby = " group by ".$filter["groupby"]." "; 
        }
        
        // Sorting
        switch ($filter["sort"]) {
            case 'Newest':
                # code...
                $order_by = " order by created_at desc  ";
                break;

            case 'Oldest':
                # code...
                $order_by = " order by created_at asc  ";
                break;

            case 'Highest':
                # code...
                $order_by = " order by price desc  ";
                break;

            case 'Lowest':
                # code...
                $order_by = " order by price asc  ";
                break;
            
            default:
                # code...
                $order_by = " order by precedence asc  ";
                break;
        }

        // Limit and offset
        // if ($filter["page"] > 1) {
        //     $data["page"] = $filter["page"];
        // }
        $s = ((isset($filter["page"]) && trim($filter["page"]) !== "" )) ? (int)$filter["page"] * (int)$limit - $limit : 0 ;
        $page = ((isset($filter["page"]) && trim($filter["page"]) !== "" )) ? (int)$filter["page"] * (int)$limit : $limit;

        // $sql = (trim($keywords_score) !=="") ? "select *,CASE ".$keywords_score." ELSE 0 END AS match_score from products where products.status='Active' AND products.product_nature <> 'Variation' ".$sql : "select * from products where products.status='Active' AND products.product_nature <> 'Variation' ".$sql;
        $sql = (trim($keywords_score) !=="") ? "select *,".$keywords_score." from products where products.status='Active' AND products.product_nature <> 'Variation' ".$sql :
         "select * from products where products.status='Active' AND products.product_nature <> 'Variation' ".$sql;
        $score_limit = (isset($words) && sizeof($words) > 1) ? sizeof($words) : 0;
        $sql = (trim($keywords_score) !=="") ? "select * from ($sql) as main where match_score >= $score_limit" : $sql;
        $data["total_products"] = $this->userModel->customQuery($sql);
        $sql .= $groupby;
        $sql = (trim($keywords_score) !=="") ? $sql." order by match_score DESC " : $sql.$order_by;
        $sql .= " limit $s,".$limit;
        
        // echo $sql;
        $data["product"] = $this->userModel->customQuery($sql);

        return $data;
    }


}   