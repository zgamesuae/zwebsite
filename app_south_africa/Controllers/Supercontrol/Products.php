<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class Products extends \App\Controllers\BaseController {
    public function header() {
        return view('/Supercontrol/Common/Header');
    }
    
    private function clear_blanc($array){
        foreach ($array as $key => $value) {
            # code...
            if($value == null or $value== "")
            unset($array[$key]);
        }
        return $array;
    }
    private function clear_whitespace($array){
        $pattern = array("/\s+/","/[\$!\#'\",]/");
        if(is_array($array) && sizeof($array) > 0){
            foreach($array as $key => $value){
                $array[$key] = preg_replace($pattern , array("_","") , $value);
            }
        }

        return $array;
    }
    
    private function stringify_array_elements($products){
        foreach ($products as $key => $value) {
            # code...
            if(is_array($value)){
                if(sizeof($value) > 1)
                $products[$key]=implode(",",$products[$key]);
                else
                $products[$key]=$value[0];

            }
        }

        return $products;
    }
    // yahia bulk function
    public function bulkUpload(){

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $category_model=model("App\Models\Category");
        $data = [];
        $recognized_field = array(
            "category" =>                               array("required_fo_update"=>false , "required_for_creation"=>true),
            "sub_category" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
            "sub_category_sub" =>                       array("required_fo_update"=>false , "required_for_creation"=>false),
            "type" =>                                   array("required_fo_update"=>false , "required_for_creation"=>true),
            "name" =>                                   array("required_fo_update"=>false , "required_for_creation"=>true),
            "arabic_name" =>                            array("required_fo_update"=>false , "required_for_creation"=>false),
            "brand" =>                                  array("required_fo_update"=>false , "required_for_creation"=>true),
            "suitable_for" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
            "age" =>                                    array("required_fo_update"=>false , "required_for_creation"=>false),
            "genre" =>                                  array("required_fo_update"=>false , "required_for_creation"=>false),
            "price" =>                                  array("required_fo_update"=>false , "required_for_creation"=>true),
            "available_stock" =>                        array("required_fo_update"=>false , "required_for_creation"=>true),
            "discount_percentage" =>                    array("required_fo_update"=>false , "required_for_creation"=>false),
            "description" =>                            array("required_fo_update"=>false , "required_for_creation"=>true),
            "arabic_description" =>                     array("required_fo_update"=>false , "required_for_creation"=>false),
            "features" =>                               array("required_fo_update"=>false , "required_for_creation"=>false),
            "arabic_features" =>                        array("required_fo_update"=>false , "required_for_creation"=>false),
            "gift_wrapping" =>                          array("required_fo_update"=>false , "required_for_creation"=>false),
            "assemble_professionally" =>                array("required_fo_update"=>false , "required_for_creation"=>false),
            "assemble_professionally_price" =>          array("required_fo_update"=>false , "required_for_creation"=>false),
            "sku" =>                                    array("required_fo_update"=>true , "required_for_creation"=>true),
            "youtube_link" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
            "show_this_product_in_home_page" =>         array("required_fo_update"=>false , "required_for_creation"=>false),
            "product_image" =>                          array("required_fo_update"=>false , "required_for_creation"=>true),
            "product_screenshot" =>                     array("required_fo_update"=>false , "required_for_creation"=>false),
            "freebie" =>                                array("required_fo_update"=>false , "required_for_creation"=>false),
            "evergreen" =>                              array("required_fo_update"=>false , "required_for_creation"=>false),
            "exclusive" =>                              array("required_fo_update"=>false , "required_for_creation"=>false),
            "pre_order_enabled" =>                      array("required_fo_update"=>false , "required_for_creation"=>false),
            "pre_order_before_payment_percentage" =>    array("required_fo_update"=>false , "required_for_creation"=>false),
            "release_date" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
            "google_category" =>                        array("required_fo_update"=>false , "required_for_creation"=>false),
            
            "max_qty_order" =>                          array("required_fo_update"=>false , "required_for_creation"=>false),
            "order_interval" =>                         array("required_fo_update"=>false , "required_for_creation"=>false),
            
            "discount_type" =>                          array("required_fo_update"=>false , "required_for_creation"=>false),
            "offer_start_date" =>                       array("required_fo_update"=>false , "required_for_creation"=>false),
            "offer_end_date" =>                         array("required_fo_update"=>false , "required_for_creation"=>false),
            
            "new_from" =>                               array("required_fo_update"=>false , "required_for_creation"=>false),
            "new_until" =>                              array("required_fo_update"=>false , "required_for_creation"=>false),
            "slug" =>                                   array("required_fo_update"=>false , "required_for_creation"=>false),
            
            "product_nature" =>                         array("required_fo_update"=>false , "required_for_creation"=>true),
            "parent" =>                                 array("required_fo_update"=>false , "required_for_creation"=>false),
            "attribute_variation" =>                    array("required_fo_update"=>false , "required_for_creation"=>false),
            "attributes" =>                             array("required_fo_update"=>false , "required_for_creation"=>false),
            
            "precedence" =>                             array("required_fo_update"=>false , "required_for_creation"=>false),
            "status" =>                                 array("required_fo_update"=>false , "required_for_creation"=>false),
        );

    



        $headers=$header_helper=array();

        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $input = $this->validate(['file' => ['uploaded[file]']]);
            if (!$input) {
            } 
            else {
                if ($this->request->getFile('file')) {
                    $_file = $this->request->getFile('file');
                    $_file->move(ROOTPATH . '/assets/uploads/');
                    $fullPath = ROOTPATH . '/assets/uploads/' . $_file->getName();
                    // $fullPath = ROOTPATH . '/assets/uploads/upload_test_y_2.csv';
                    // $fullPath = ROOTPATH . '/assets/uploads/pc_gaming_upload.csv';
                    // $fullPath = ROOTPATH . '/assets/uploads/csv/ara_upload_test.csv';



                    $j = 0;
                    $arra = array();
                    $row = 0;
                    if (($handle = fopen($fullPath, "r")) !== FALSE) {

                        // construct Two-dimensional array of the data contained in the CSV file
                        while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                            $num = sizeof($data);
                            $row++;
                            
                            if ($row > 1) {
                                for ($c = 0;$c < $num;$c++) {
                                    // if ($c % 28 == 0) {
                                    //     $j++;
                                    // }
                                    $arra[$row-1][] = $data[$c];
                                }
                            }
                            else{
                                $headers = $data;
                                foreach($headers as $k => $v ){
                                    $headers_helper[$v]=$k;
                                }
                            }
                        }
                        
                        
                        // Close the CSV file
                        fclose($handle);
                        
                        // check if all the headers are recognized and has the required field
                        $boolean=true;
                        $r=$ru=0;

                        // foreach ($headers as $key => $value) {
                        //     # code...
                        //     // echo (mb_detect_encoding(iconv("UTF-8" , "ASCII" , $value)).'</br>');
                        //     // echo($value=="sku");
                        //     if(array_key_exists(trim($value) , $recognized_field)){
                        //         if($recognized_field[$value]["required_fo_update"] == true)
                        //         $r++;
                        //         if($recognized_field[$value]["required_for_creation"] == true)
                        //         $ru++;
                        //     }
                        //     else 
                        //     $boolean=false;
                        // }

                        for ($i = 1 ; $i < sizeof($headers) ; $i++) {
                            # code...
                            if(array_key_exists(trim($headers[$i]) , $recognized_field)){
                                if($recognized_field[$headers[$i]]["required_fo_update"] == true)
                                $r++;
                                if($recognized_field[$headers[$i]]["required_for_creation"] == true)
                                $ru++;
                            }
                            else 
                            $boolean=false;
                        }
                        

                        // foreach ($arra as $key => $value) {
                        //     # code...
                        //     for($i=0 ; $i < sizeof($value) ; $i++){
                        //         echo(($value[$i]).'</br>');
                        //     }
                        // }


                        // echo(utf8_decode("sku"));
                        // var_dump($arra , $r , $boolean);die();

                        // if all the headers are recognized step de the data processing
                        if($boolean && $r == 1){

                            for($i=1 ; $i<sizeof($arra)+1 ; $i++){
                                $products=array();
                                $category_ids;

                                $category=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["category"]]));
                                $sub_category=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["sub_category"]]));
                                $sub_category_sub=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["sub_category_sub"]]));
                                $type=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["type"]]));
                                $genre=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["genre"]]));
                                $suitable_for=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["suitable_for"]]));
                                
                                
                                $p_image=$this->clear_whitespace($this->clear_blanc(explode(',',$arra[$i][$headers_helper["product_image"]])));
                                $p_screenshots=$this->clear_whitespace($this->clear_blanc(explode(',',$arra[$i][$headers_helper["product_screenshot"]])));
                                $attributes = $this->clear_blanc(explode(',',$arra[$i][$headers_helper["attributes"]]));
                                $variations = $this->clear_blanc(explode(',',$arra[$i][$headers_helper["attribute_variation"]]));

                                // var_dump($category);
                                // var_dump($sub_category);
                                // var_dump($sub_category_sub);
                                // die();

                                foreach ($arra[$i] as $key => $value) {
                                    # code...
                                    switch (trim($headers[$key])) {


                                        case  ("category"):
                                            # code...
                                            if(sizeof($category) > 0){
                                                foreach ($category as $key=>$value) {
                                                    # code...
                                                    if(!$category_model->category_exist_by_name(trim($value),0)){
                                                        $insert_id=url_title($value, '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                                        $category_model->create_category(
                                                            array(
                                                                // "parent_id"=>0,  
                                                                "category_name" => $value ,
                                                                 "category_id" => $insert_id)
                                                            );
                                                        $id_category = $insert_id;
                                                    }
    
                                                    else 
                                                    $id_category = $category_model->get_category_id(trim($value),0);


                                                    if(!$products["category"])
                                                    $products["category"]=array();
                                                    
    
                                                    if(isset($sub_category) && !isset($sub_category[$key])){
                                                        if($sub_category[$key]!=="")
                                                        array_push($products["category"],$id_category);

                                                    }
                                                    // $products["master_category"]=$category;
                                                }
                                            }
                                        break;
                                            
                                        case "sub_category":
                                            # code...
                                            if(sizeof($sub_category) > 0){
                                                // var_dump($sub_category);
                                                foreach ($sub_category as $key => $value) {
                                                //     # code...
                                                    $parent_id=$category_model->get_category_id(trim($category[$key]),0);
                                                    if(!$category_model->category_exist_by_name(trim($value),$parent_id)){

                                                        $insert_id=url_title($value, '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                                        $category_model->create_category(
                                                            array(
                                                                "parent_id"=>$parent_id,
                                                                "category_name" => $value ,
                                                                 "category_id" => $insert_id)
                                                            );
                                                        $id_category = $insert_id;


                                                    }
    
                                                    else {
                                                        $id_category = $category_model->get_category_id(trim($value),$parent_id);
                                                    }
    
    
    
                                                    if(!$products["category"])
                                                    $products["category"]=array();
                                                    
                                                    if(isset($sub_category_sub) && !isset($sub_category_sub[$key]))
                                                    array_push($products["category"],$id_category);
                                                    
                                                }
                                                // $products["sub_category"]=$sub_category;

                                            }
                                        break;
                                            
                                        case "sub_category_sub":
                                            # code...

                                            if(sizeof($sub_category_sub) > 0){
                                                foreach ($sub_category_sub as $key => $value) {
                                                //     # code...
                                                    $m_cat_id=$category_model->get_category_id($category[$key],0);
                                                    $parent_id=$category_model->get_category_id(trim($sub_category[$key]),$m_cat_id);
                                                    
                                                    $exist_=$category_model->category_exist_by_name(trim($value),$parent_id);
                                                    if(!$exist_){
                                                        $insert_id=url_title($value, '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                                        $category_model->create_category(
                                                            array(
                                                                "parent_id"=>$parent_id,
                                                                "category_name" => $value,
                                                                 "category_id" => $insert_id)
                                                            );
                                                            $id_category=$insert_id;

                                                    }
    
                                                    else {
                                                        $id_category = $category_model->get_category_id(trim($value),$parent_id);
                                                    }
    
    
    
                                                    if(!$products["category"])
                                                    $products["category"]=array();
                                                    
                                                    array_push($products["category"],$id_category);
                                                    
                                                }
                                                // $products["sub_category"]=$sub_category;

                                            }

                                        break;
                                            
                                        case "type":
                                            # code...
                                            if(sizeof($type) > 0){
                                                foreach ($type as $key => $value) {
                                                    # code...
                                                    if(!$products["type"])
                                                    $products["type"]=array();

                                                    $type_id=$this->userModel->customQuery("select type_id from type where title='".$value."'");
    
                                                    if(!$type_id){
                                                        $type_id=$this->userModel->do_action("type","","","insert",array("title"=>$value),"");
                                                        array_push($products["type"],$type_id);
                                                        
                                                    }
                                                    else
                                                        array_push($products["type"],$type_id[0]->type_id);

                                                    
    
                                                }
                                                // $products["type"]=implode(",",$products["type"]);
                                            }

                                        break;
                                            
                                        case "brand":
                                            # code...
                                            if($value!==""){
                                                $brand_id=$this->userModel->customQuery("select id from brand where title='".$value."'");
                                            if(!$brand_id){
                                                $brand_id=$this->userModel->do_action("brand","","","insert",array("title"=>$value),"");
                                                $products["brand"]=$brand_id;
                                            }

                                            else
                                            $products["brand"]=$brand_id[0]->id;
                                            }

                                        break;
                                            
                                        case "suitable_for":
                                            # code...
                                            if(sizeof($suitable_for) > 0){
                                                foreach ($suitable_for as $k => $v) {
                                                    # code...
                                                    $suitable_for_id=$this->userModel->customQuery("select id from suitable_for where title='".$v."'");
                                                    // var_dump($suitable_for_id[0]);

                                                    if(!$suitable_for_id)
                                                    $suitable_for_id=$this->userModel->do_action("suitable_for","","","insert",array("title"=>$v),"");
                                                    
                                                    if(!array_key_exists("suitable_for",$products))
                                                    $products["suitable_for"]=array();
                                                    array_push($products["suitable_for"],$suitable_for_id[0]->id);

                                                }
                                            }
                                            
                                        break;
                                            
                                        case "age":
                                            # code...
                                            if($value !== ""){
                                                $age_id=$this->userModel->customQuery("select id from age where title='".$value."'");

                                            if(!$age_id){
                                                $age_id=$this->userModel->do_action("age","","","insert",array("title"=>$value),"");
                                                $products["age"]=$age_id;
                                                
                                            }
                                            else
                                                $products["age"]=$age_id[0]->id;
                                            }
                                            
                                            
                                        break;
                                            
                                        case "genre":
                                            # code...

                                            if(sizeof($genre) > 0){
                                                foreach ($genre as $k => $v) {
                                                    # code...
                                                    if(!array_key_exists("color",$products))
                                                    $products["color"]=array();
    
                                                    $genre_id=$this->userModel->customQuery("select id from color where title='".$v."'");
                                                    
                                                    if(!$genre_id){
                                                        $genre_id=$this->userModel->do_action("color","","","insert",array("title"=>$v),"");
                                                        array_push($products["color"],$genre_id);
                                                    }
                                                    else
                                                    array_push($products["color"],$genre_id[0]->id);
                                                    
                                                    
    
                                                }
                                            }

                                            
                                        break;
                                            
                                        case "product_image":
                                            # code...
                                            if(sizeof($p_image) > 0)
                                            $products["product_image"]=$p_image;

                                        break;
                                            
                                        case "product_screenshot":
                                            # code...
                                            if(sizeof($p_screenshots) > 0)
                                            $products["product_screenshot"]=$p_screenshots;

                                        break;
                                        
                                        case "order_interval":
                                            if(in_array($value,array("Daily","Unlimited","Monthly","Weekly")))
                                            $products[$headers[$key]]=$value;

                                        break;
                                        
                                        case "offer_start_date":
                                            $start_date = (new \dateTime($value,new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                                            $products[$headers[$key]]=$start_date;
                                        break;

                                        case "offer_end_date":
                                            $end_date = (new \dateTime($value,new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                                            $products[$headers[$key]]=$end_date;

                                        break;
                                        
                                        case "slug":
                                            $slug = $this->productModel->createurl($value);
                                            if($slug !== false)
                                            $products[$headers[$key]]= $slug;
                                        break;
                                        
                                        case "parent":
                                            $product_id = $this->productModel->get_product_id_from_sku($value);
                                            if($this->productModel->product_exist($product_id)){
                                                $products[$headers[$key]] = $product_id;
                                            }
                                            else{
                                                $products[$headers[$key]] = null;

                                            }
                                        break;

                                        case "product_nature":
                                            $nature = array("Variable" , "Variation" , "Simple");
                                            if(in_array(ucfirst(trim($value)) , $nature))
                                            $products[$headers[$key]] = ucfirst(trim($value));
                                        break;

                                        case "attributes":
                                            $tab = array_map(array($this->attributeModel , "get_attribute_id") , $attributes);
                                            if(sizeof($tab) > 0 && $this->attributeModel->attributes_exist($tab)){
                                                $products[$headers[$key]] = implode(",",$tab);
                                            }
                                            else{
                                                $products[$headers[$key]] = null;

                                            }
                                        break;

                                        case "attribute_variation":
                                            if(sizeof($variations) > 0){
                                                $atts = array();
                                                $vars = array();
                                                $table = array();
                                                $bbool = true;

                                                foreach($variations as $variation){
                                                    $var = explode(":" , $variation);
                                                    array_push($atts , $var[0]);
                                                    array_push($vars , $var[1]);
                                                }

                                                $atts_ids = array_map(array($this->attributeModel , "get_attribute_id") , $atts);
                                                $vars_ids = array_map(array($this->attributeModel , "get_option_id") , $vars);
                                                foreach($atts_ids as $kk => $id){
                                                    $req = "select count(id) as nbr from attribute_options where attribute_id=".$id." and id=".$vars_ids[$kk];
                                                    $res = $this->userModel->customQuery($req);

                                                    if($res && $res[0]->nbr > 0)
                                                    $table[$id] = $vars_ids[$kk];
                                                    else
                                                    $bbool = false;
                                                }

                                                if(sizeof($table) > 0 && $bbool)
                                                $products[$headers[$key]] = json_encode(array($table));
                                                else
                                                $products[$headers[$key]] = null;


                                            }
                                        break;

                                        case "status":
                                            if(in_array($value , ["Active" , "Inactive"]))
                                            $products[$headers[$key]]=$value;


                                        break;

                                        default:
                                            # code...
                                            if($recognized_field[$headers[$key]])
                                            $products[$headers[$key]]=$value;
                                            break;
                                    }
                                }

                                // here start process of update or create product

                                // check if the product line exist already
                                $product_id=$this->userModel->customQuery("select product_id from products where sku='".$products["sku"]."'");

                                // product exist
                                if($product_id){
                                    // // update the products images and screenshots
                                        if(array_key_exists("product_image",$products)){
                                            $b=true;
                                            $b=$this->userModel->do_action("product_image",$product_id[0]->product_id,"product","delete","","");

                                            foreach($products["product_image"] as $value){
                                                $b=$this->userModel->do_action("product_image","","","insert",array("product"=>$product_id[0]->product_id,"image"=>$value),"");
                                            }
                                            unset($products["product_image"]);

                                        }

                                        if(array_key_exists("product_screenshot",$products)){
                                            $bb=true;
                                            $bb=$this->userModel->do_action("product_screenshot",$product_id[0]->product_id,"product","delete","","");

                                            foreach($products["product_screenshot"] as $value){
                                                $bb=$this->userModel->do_action("product_screenshot","","","insert",array("product"=>$product_id[0]->product_id,"image"=>$value),"");
                                            }
                                            unset($products["product_screenshot"]);

                                        }

                                        

                                    //     // stringify the array elements of the products array
                                        $products=$this->stringify_array_elements($products);
                                        // var_dump($products);die();
                                    //     // update the product
                                        if(true)
                                        $this->userModel->do_action("products",$products["sku"],"sku","update",$products,"");


                                        
                                }

                                // product does not exist
                                else {
                                   if($ru >= 10){
                                    
                                        //     // stringify the array elements of the products array
                                            if(strlen($products["name"]) > 28)
                                            $product_id=url_title(substr($products['name'], 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);

                                            else 
                                            $product_id=url_title($products["name"], '-', TRUE) . '-' . time() . '' . rand(0, 9999);


                                            $p_image=array();
                                            $p_screenshot=array();

                                            if(array_key_exists("product_image",$products))
                                            {
                                                $p_image=$this->clear_blanc($products["product_image"]);
                                                unset($products["product_image"]);
                                            }


                                            if(array_key_exists("product_screenshot",$products))
                                            {
                                                $p_screenshot=$this->clear_blanc($products["product_screenshot"]);
                                                unset($products["product_screenshot"]);
                                            }


                                            $products["product_id"]=$product_id;

                                            $products=$this->stringify_array_elements($products);
                                    
                                        //     // update the product
                                            $insert=$this->userModel->do_action("products","","","insert",$products,"");
                                            // if($insert){
                                                // // create the product images and screenshots
                                                if(sizeof($p_image) > 0){
                                                    $b=true;
                                                
                                                    foreach($p_image as $key => $value){
                                                        $b=$this->userModel->do_action("product_image","","","insert",array("product"=>$product_id,"image"=>$value),"");
                                                    }
                                                
                                                }
                                            
                                                if(sizeof($p_screenshot) > 0){
                                                    $bb=true;
                                                
                                                    foreach($p_screenshot as $key => $value){
                                                        $bb=$this->userModel->do_action("product_screenshot","","","insert",array("product"=>$product_id,"image"=>$value),"");
                                                    }

                                                
                                                }
                                            // }
                                   }
                                }
                            }

                            
                            
                        }


                        // var_dump($products);
                        // var_dump($headers_helper);
                        // var_dump($arra);
                        // die();

                        // loop on the two-dimensional data array 
                        // foreach($headers as $k = >$v){
                        //     if($v in_array())
                        // }


                        
                    }
                }
            }
            return redirect()->to(site_url('/supercontrol/Products'));
        } // POST END
        echo $this->header();
        echo view('/Supercontrol/bulkUpload');
        echo $this->footer();
    }

    public function resize($tmp , $type , $width , $height, $scale_percent , $applycrop){
       // start resizing 
       $source_image=null;
        $bool = false;
       if($type == "image/png"){
           $source_image = imagecreatefrompng($tmp);
       }

       else if($type == "image/jpg" || $type == "image/jpeg"){
           $source_image = imagecreatefromjpeg($tmp);
       }

       if(!$applycrop){            
            $thumb = imagecreatetruecolor($width*$scale_percent, $height*$scale_percent);
            if($type == "image/png"){
                imagesavealpha($thumb, true);
                $bg = imagecolorallocatealpha($thumb , 0 , 0 , 0 , 127);
                imagefill($thumb, 0, 0, $bg);
            }
            $bool = imagecopyresampled($thumb, $source_image, 0, 0, 0, 0, $width*$scale_percent, $height*$scale_percent, $width, $height);
       }

       else{

            if($width > $height){
                $x = 0;
                $y = (800 - ($height*$scale_percent)) /2;
            }
        
            else{
                $y = 0;
                $x = (800 - ($width*$scale_percent)) /2;
            }
            $thumb = imagecreatetruecolor(800, 800);
        
            $color = imagecolorallocate($thumb, 255, 255, 255);
            imagefill($thumb, 0, 0, $color);
        
            $bool = imagecopyresampled($thumb, $source_image, $x, $y, 0, 0, $width*$scale_percent, $height*$scale_percent, $width, $height);

       }

       imagedestroy($source_image);
       // $dest_image = imagecrop($image, ['x' => 0, 'y' => 0, 'width' => 512, 'height' => 512]);

       if($bool)
       return $thumb;

       else return false;

    }

    public function upload() {
        $input = $this->validate(['file' => ['uploaded[file]' , 'mime_in[file,image/jpg,image/jpeg,image/png]']]);
        $b=false;
        if (!$input) {
        } 
        else {
            if ($this->request->getFile('file')) {
                $img = $this->request->getFile('file');
                $type = $_FILES["file"]["type"];
                $tmp = $_FILES["file"]["tmp_name"];
                list($width, $height) = getimagesize($tmp);

                $scale_percent = 80000/(max($width , $height))/100;
                if($thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , true)){
                    $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $img->getName());
                    $ext = substr($img->getName() , strrpos($img->getName() , "."));

                    imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$this->clear_whitespace(array($filename))[0].$ext , 85);
                    $b=true;
                    imagedestroy($thumb);
                }
                //  $p['category_image']=$img->getName();
                return $b;
            }
        }
    }
    
    public function upload_screenshots() {
        $input = $this->validate(['file' => ['uploaded[file]' , 'mime_in[file,image/jpg,image/jpeg,image/png]']]);
        $b=false;
        if (!$input) {
        } 
        else {
            
            if ($this->request->getFile('file')) {
                $img = $this->request->getFile('file');
                $type = $_FILES["file"]["type"];
                $tmp = $_FILES["file"]["tmp_name"];
                list($width, $height) = getimagesize($tmp);

                $scale_percent = 100000/(max($width , $height))/100;
               

                $thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , false);
                if($thumb){
                    
                    $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $img->getName());
                    $ext = substr($img->getName() , strrpos($img->getName() , "."));
                    echo($this->clear_whitespace(array($filename))[0].$ext);
                    imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$this->clear_whitespace(array($filename))[0].$ext);
                    $b=true;
                    imagedestroy($thumb);
                }
                //  $p['category_image']=$img->getName();
                return $b;
            }
        }
    }
    
    public function upload_other() {
        $input = $this->validate(['file' => ['uploaded[file]' , 'mime_in[file,image/jpg,image/jpeg,image/png]']]);
        $b=false;
        if (!$input) {
            echo("hey");
        } 
        else {
            
            if ($this->request->getFile('file')) {
                $img = $this->request->getFile('file');
                $type = $_FILES["file"]["type"];
                $tmp = $_FILES["file"]["tmp_name"];
                list($width, $height) = getimagesize($tmp);
                
                $scale_percent = 100000/(max($width , $height))/100;
               

                $thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , false);
                
                if($thumb){
                    
                    // $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $img->getName());
                    $filename = $img->getName();
                    // $ext = substr($img->getName() , strrpos($img->getName() , "."));
                    if(in_array(strtolower($type) , ["image/jpeg","image/jpg"]))
                    imagejpeg($thumb , ROOTPATH . '/assets/others/'.$img->getName());
                    else if(strtolower($type) === "image/png")
                    imagepng($thumb , ROOTPATH . '/assets/others/'.$img->getName());
                    $b=true;
                    imagedestroy($thumb);
                }
                //  $p['category_image']=$img->getName();
                return $b;
            }
        }
    }
    
    public function uploadImage() {
        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        echo $this->header();
        echo view('/Supercontrol/uploadImage');
        echo $this->footer();
    }
    
    public function links() {

        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('products');
        $crud->setSubject('Product', 'Product');
        $crud->columns(['sku' , "name" , "slug"]);
        $crud->callbackColumn('slug', function ($value, $row) {
            $url = $this->productModel->getproduct_url($row->product_id);
            return "<a target='_blank' href='$url' >".str_replace(base_url() , "" , $url)."</a>";
        });
        $crud->editFields(['slug']);
        $crud->displayAs('slug', 'Url');
        $crud->defaultOrdering('products.created_at', 'desc');
        $output = $crud->render();
        return $this->_example_output($output);

    }

    public function ex() {
        $sql = "select * from product_screenshot  ";
        $img = $this->userModel->customQuery($sql);
        if ($img) {
            foreach ($img as $k => $v) {
                $d = explode("/", $v->image);
                if ($d[1]) {
                    $pi['image'] = $d[1];
                    $resIMG = $this->userModel->do_action('product_screenshot', $v->id, 'id', 'update', $pi, '');
                }
            }
        }
    }

    public function footer() {
        return view('/Supercontrol/Common/Footer');
    }

    public function OLDbulkUpload() {
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $input = $this->validate(['file' => ['uploaded[file]']]);
            if (!$input) {
            } else {
                if ($this->request->getFile('file')) {
                    $img = $this->request->getFile('file');
                    $img->move(ROOTPATH . '/assets/uploads/');
                    $fullPath = ROOTPATH . '/assets/uploads/' . $img->getName();
                    $j = 0;
                    $arra = array();
                    $row = 1;
                    if (($handle = fopen($fullPath, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            $num = count($data);
                            $row++;
                            if ($row > 2) {
                                for ($c = 0;$c < $num;$c++) {
                                    if ($c % 22 == 0) {
                                        $j++;
                                    }
                                    $arra[$j][] = $data[$c];
                                }
                            }
                        }
                        fclose($handle);
                        foreach ($arra as $k => $v) {
                            $insertData = array();
                            // ##########Category CHecking Start##########
                            if ($cat = $v[0]) {
                                $stcat = strtolower($cat);
                                $sql = "select * from master_category where  LOWER(category_name)='$stcat' AND parent_id=0  ";
                                $master_category = $this->userModel->customQuery($sql);
                                if ($master_category) {
                                    $pcat = $master_category[0]->category_id;
                                } else {
                                    $p['category_name'] = $cat;
                                    $p['category_id'] = url_title($p['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                    $res = $this->userModel->do_action('master_category', '', '', 'insert', $p, '');
                                    $pcat = $p['category_id'];
                                }
                            }
                            // ###########Category checking END ###########
                            // ##############################################
                            // ##########Sub Category CHecking Start##########
                            if ($scat = $v[1]) {
                                $scatv = strtolower($scat);
                                $sql = "select * from master_category where  LOWER(category_name)='$scatv' AND parent_id='$pcat'  ";
                                $master_category = $this->userModel->customQuery($sql);
                                if ($master_category) {
                                    @$insertData['category'] = $master_category[0]->category_id;
                                    $subCatSub = $master_category[0]->category_id;
                                } else {
                                    $ps['parent_id'] = $pcat;
                                    $ps['category_name'] = $scat;
                                    $ps['category_id'] = url_title($ps['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                    $subCatSub = $ps['category_id'];
                                    $res = $this->userModel->do_action('master_category', '', '', 'insert', $ps, '');
                                    @$insertData['category'] = $ps['category_id'];
                                }
                            }
                            // ###########Sub Category checking END ###########
                            // ##############################################
                            // ##############################################
                            // ##########Sub Category Sub CHecking Start##########
                            $cateArray = explode(",", $v[2]);
                            if (count($cateArray) > 1) {
                                $temCat = "";
                                foreach ($cateArray as $ck => $cv) {
                                    if ($ck > 0) {
                                        $temCat = $temCat . ",";
                                    }
                                    $scatv = strtolower($cv);
                                    $sql = "select * from master_category where  LOWER(category_name)='$scatv' AND parent_id='$subCatSub'  ";
                                    $master_category = $this->userModel->customQuery($sql);
                                    if ($master_category) {
                                        $temCat = $temCat . "" . $master_category[0]->category_id;
                                    } else {
                                        $ps['parent_id'] = $subCatSub;
                                        $ps['category_name'] = $cv;
                                        $ps['category_id'] = url_title($ps['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                        $res = $this->userModel->do_action('master_category', '', '', 'insert', $ps, '');
                                        $temCat = $temCat . "" . $ps['category_id'];
                                    }
                                }
                                @$insertData['category'] = $temCat;
                            } else {
                                if ($scat = $v[2]) {
                                    $scatv = strtolower($scat);
                                    $sql = "select * from master_category where  LOWER(category_name)='$scatv' AND parent_id='$subCatSub'  ";
                                    $master_category = $this->userModel->customQuery($sql);
                                    if ($master_category) {
                                        @$insertData['category'] = $master_category[0]->category_id;
                                    } else {
                                        $ps['parent_id'] = $subCatSub;
                                        $ps['category_name'] = $scat;
                                        $ps['category_id'] = url_title($ps['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                        $res = $this->userModel->do_action('master_category', '', '', 'insert', $ps, '');
                                        @$insertData['category'] = $ps['category_id'];
                                    }
                                }
                            }
                            // ###########Sub Category sub checking END ###########
                            // ##############################################
                            // ##########Type CHecking Start##########
                            if ($type = $v[3]) {
                                if ($typev = explode(",", $type)) {
                                    foreach ($typev as $kt => $vt) {
                                        if ($vt) {
                                            $stv = strtolower($vt);
                                            $sql = "select * from type where  LOWER(title)='$stv'   ";
                                            $typeRes = $this->userModel->customQuery($sql);
                                            if ($typeRes) {
                                                if (@$insertData['type']) @$insertData['type'] = @$insertData['type'] . ',' . $typeRes[0]->type_id;
                                                else @$insertData['type'] = $typeRes[0]->type_id;
                                            } else {
                                                $pt['title'] = $vt;
                                                $pt['type_id'] = $this->userModel->do_action('type', '', '', 'insert', $pt, '');
                                                if (@$insertData['type']) @$insertData['type'] = @$insertData['type'] . ',' . $pt['type_id'];
                                                else @$insertData['type'] = $pt['type_id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########Type checking END ###########
                            // ##############################################
                            // ##########Type name Start##########
                            if ($name = $v[4]) {
                                $insertData['name'] = $name;
                            }
                            // ###########Type name END ###########
                            // ##############################################
                            // ##########Type brand Start##########
                            if ($brand = $v[5]) {
                                if ($barray = explode(",", $brand)) {
                                    foreach ($barray as $kb => $vb) {
                                        if ($vb) {
                                            $svb = strtolower($vb);
                                            $sql = "select * from brand where  LOWER(title)='$svb'   ";
                                            $brandRes = $this->userModel->customQuery($sql);
                                            if ($brandRes) {
                                                if (@$insertData['brand']) @$insertData['brand'] = @$insertData['brand'] . ',' . $brandRes[0]->id;
                                                else @$insertData['brand'] = $brandRes[0]->id;
                                            } else {
                                                $pt['title'] = $vb;
                                                $pt['id'] = $this->userModel->do_action('brand', '', '', 'insert', $pt, '');
                                                if (@$insertData['brand']) @$insertData['brand'] = @$insertData['brand'] . ',' . $pt['id'];
                                                else @$insertData['brand'] = $pt['id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########Type brand END ###########
                            // ##############################################
                            // ##########suitable_for CHecking Start##########
                            if ($suitable_for = $v[6]) {
                                if ($suitable_forv = explode(",", $suitable_for)) {
                                    foreach ($suitable_forv as $kst => $vst) {
                                        if ($vst) {
                                            $stv = strtolower($vst);
                                            $sql = "select * from suitable_for where  LOWER(title)='$stv'   ";
                                            $typeRes = $this->userModel->customQuery($sql);
                                            if ($typeRes) {
                                                if (@$insertData['suitable_for']) @$insertData['suitable_for'] = @$insertData['suitable_for'] . ',' . $typeRes[0]->id;
                                                else @$insertData['suitable_for'] = $typeRes[0]->id;
                                            } else {
                                                $pt['title'] = $vst;
                                                $pt['id'] = $this->userModel->do_action('suitable_for', '', '', 'insert', $pt, '');
                                                if (@$insertData['suitable_for']) @$insertData['suitable_for'] = @$insertData['suitable_for'] . ',' . $pt['id'];
                                                else @$insertData['suitable_for'] = $pt['id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########suitable_for checking END ###########
                            // ##############################################
                            // ##############################################
                            // ##########age CHecking Start##########
                            if ($age = $v[7]) {
                                if ($agev = explode(",", $age)) {
                                    foreach ($agev as $kst => $vst) {
                                        if ($vst) {
                                            $stv = strtolower($vst);
                                            $sql = "select * from age where  LOWER(title)='$stv'   ";
                                            $typeRes = $this->userModel->customQuery($sql);
                                            if ($typeRes) {
                                                if (@$insertData['age']) @$insertData['age'] = @$insertData['age'] . ',' . $typeRes[0]->id;
                                                else @$insertData['age'] = $typeRes[0]->id;
                                            } else {
                                                $pt['title'] = $vst;
                                                $pt['id'] = $this->userModel->do_action('age', '', '', 'insert', $pt, '');
                                                if (@$insertData['age']) @$insertData['age'] = @$insertData['age'] . ',' . $pt['id'];
                                                else @$insertData['age'] = $pt['id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########age checking END ###########
                            // ##############################################
                            // ##############################################
                            // ##########color CHecking Start##########
                            if ($color = $v[8]) {
                                if ($colorv = explode(",", $color)) {
                                    foreach ($colorv as $kst => $vst) {
                                        if ($vst) {
                                            $stv = strtolower($vst);
                                            $sql = "select * from color where  LOWER(title)='$stv'   ";
                                            $typeRes = $this->userModel->customQuery($sql);
                                            if ($typeRes) {
                                                if (@$insertData['color']) @$insertData['color'] = @$insertData['color'] . ',' . $typeRes[0]->id;
                                                else @$insertData['color'] = $typeRes[0]->id;
                                            } else {
                                                $pt['title'] = $vst;
                                                $pt['id'] = $this->userModel->do_action('color', '', '', 'insert', $pt, '');
                                                if (@$insertData['color']) @$insertData['color'] = @$insertData['color'] . ',' . $pt['id'];
                                                else @$insertData['color'] = $pt['id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########color checking END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  price Start##########
                            if ($price = $v[9]) {
                                $insertData['price'] = $price;
                            }
                            // ###########  price END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  available_stock Start##########
                            if ($available_stock = $v[10]) {
                                $insertData['available_stock'] = $available_stock;
                            }
                            // ###########  available_stock END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  discount_percentage Start##########
                            if ($discount_percentage = $v[11]) {
                                $insertData['discount_percentage'] = $discount_percentage;
                            }
                            // ###########  discount_percentage END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  description Start##########
                            if ($description = $v[12]) {
                                $insertData['description'] = $description;
                            }
                            // ###########  description END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  features Start##########
                            if ($features = $v[13]) {
                                $insertData['features'] = $features;
                            }
                            // ###########  features END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  gift_wrapping Start##########
                            if ($gift_wrapping = $v[14]) {
                                $insertData['gift_wrapping'] = $gift_wrapping;
                            }
                            // ###########  gift_wrapping END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  assemble_professionally Start##########
                            if ($assemble_professionally = $v[15]) {
                                $insertData['assemble_professionally'] = $assemble_professionally;
                            }
                            // ###########  assemble_professionally END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  assemble_professionally_price Start##########
                            if ($assemble_professionally_price = $v[16]) {
                                $insertData['assemble_professionally_price'] = $assemble_professionally_price;
                            }
                            // ###########  assemble_professionally_price END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  sku Start##########
                            if ($sku = $v[17]) {
                                $insertData['sku'] = $sku;
                            }
                            // ###########  sku END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  youtube_link Start##########
                            if ($youtube_link = $v[18]) {
                                $insertData['youtube_link'] = $youtube_link;
                            }
                            // ###########  youtube_link END ###########
                            // ##############################################
                            // ##############################################
                            // ##########  show_this_product_in_home_page Start##########
                            if ($show_this_product_in_home_page = $v[19]) {
                                $insertData['show_this_product_in_home_page'] = $show_this_product_in_home_page;
                            }
                            // ###########  show_this_product_in_home_page END ###########
                            // ##############################################
                            // ##############################################
                            // ##########image CHecking Start##########
                            if ($product_image = $v[20]) {
                                $product_imagev = explode(",", $product_image);
                                if ($product_imagev) {
                                } else {
                                    $product_imagev[] = $product_image;
                                }
                            }
                            // ###########image checking END ###########
                            // ##############################################
                            // ##############################################
                            // ##########screenshot CHecking Start##########
                            if ($scrren = $v[21]) {
                                $sreenshotv = explode(",", $scrren);
                                if ($sreenshotv) {
                                } else {
                                    $sreenshotv[] = $scrren;
                                }
                            }
                            // ###########screenshot checking END ###########
                            // ##############################################
                            // ##############Action Start############
                            if ($insertData) {
                                if (strlen($insertData['name']) > 28) {
                                    $insertData['product_id'] = url_title(substr($insertData['name'], 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                } else {
                                    $insertData['product_id'] = url_title($insertData['name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                }
                                if ($sku2 = $v[17]) {
                                    /* echo  $this->userModel->getLastQuery();
                                     exit;*/
                                    $sql = "select * from products where  sku='$sku2' ";
                                    $prExisit = $this->userModel->customQuery($sql);
                                    if ($prExisit) {
                                        $this->userModel->do_action('products', $sku2, 'sku', 'update', $insertData, '');
                                        $this->userModel->do_action('product_image', $insertData['product_id'], 'product', 'delete', '', '');
                                        $this->userModel->do_action('product_screenshot', $insertData['product_id'], 'product', 'delete', '', '');
                                        if ($product_imagev) {
                                            foreach ($product_imagev as $key => $value) {
                                                $pi['image'] = $value;
                                                $pi['product'] = $insertData['product_id'];
                                                $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                                            }
                                        }
                                        if ($sreenshotv) {
                                            foreach ($sreenshotv as $key => $value) {
                                                $pi['image'] = $value;
                                                $pi['product'] = $insertData['product_id'];
                                                $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi, '');
                                            }
                                        }
                                    } else {
                                        $this->userModel->do_action('products', '', '', 'insert', $insertData, '');
                                        if ($product_imagev) {
                                            foreach ($product_imagev as $key => $value) {
                                                $pi['image'] = $value;
                                                $pi['product'] = $insertData['product_id'];
                                                $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                                            }
                                        }
                                        if ($sreenshotv) {
                                            foreach ($sreenshotv as $key => $value) {
                                                $pi['image'] = $value;
                                                $pi['product'] = $insertData['product_id'];
                                                $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi, '');
                                            }
                                        }
                                    }
                                }
                            }
                            // ##############Action END##############
                            
                        }
                    }
                }
            }
            return redirect()->to(site_url('/supercontrol/Products'));
        }
        echo $this->header();
        echo view('/Supercontrol/bulkUpload');
        echo $this->footer();
    }

    public function productImage() {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('product_image');
        $crud->setSubject('product image', 'product image');
        helper(['form', 'url']);
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
        }
        $crud->where(['product_image.product' => $uri1]);
        $crud->columns(['product', 'image', 'status']);
        $crud->callbackColumn('image', function ($value, $row) {
            $html = '<img class="brand-logo" width="50" src="' . base_url() . '/assets/uploads/' . $row->image . '">';
            return "<a   >$html</a>";
        });
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function deleteImage() {
        $data = [];
        helper(['form', 'url']);
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
            $uri2 = @$uri->getSegment(5);
            $res = $this->userModel->do_action('product_image', $uri1, 'id', 'delete', '', '');
            //   $this->session->setFlashdata('success', 'Category Deleted successfully!');
            return redirect()->to(site_url('supercontrol/Products/edit/' . $uri2 . '/image'));
        }
    }

    public function deleteScreenImage() {
        $data = [];
        helper(['form', 'url']);
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
            $uri2 = @$uri->getSegment(5);
            $res = $this->userModel->do_action('product_screenshot', $uri1, 'id', 'delete', '', '');
            //   $this->session->setFlashdata('success', 'Category Deleted successfully!');
            return redirect()->to(site_url('supercontrol/Products/edit/' . $uri2 . '/image'));
        }
    }

    public function delete() { 
        //   Access Start
        // Checking access user Start ################
        $session = session();
        $uri = service('uri');
        @$admin_id = $session->get('adminLoggedin');
        $addFlag = 0;
        $editFlag = 0;
        $deleteFlag = 0;
        $uri1 = $uri2 = $uri3 = "";
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(2);
        }
        if (count(@$uri->getSegments()) > 2) {
            $uri2 = @$uri->getSegment(3);
        }
        if (count(@$uri->getSegments()) > 3) {
            $uri3 = @$uri->getSegment(4);
        }
        if (@$admin_id) {
            $accessFlag = 0;
            $viewFlag = 0;
            $sql = "select * from access_group_master where  admin_id='$admin_id' ";
            $access_group_master = $this->userModel->customQuery($sql);
            if ($access_group_master) {
                foreach ($access_group_master as $k1 => $v1) {
                    $group_id = $v1->group_id;
                    $sql = "select * from groups_assigned where  group_id='$group_id' ";
                    $groups_assigned = $this->userModel->customQuery($sql);
                    if ($groups_assigned) {
                        foreach ($groups_assigned as $k2 => $v2) {
                            $access_modules_id = $v2->access_modules_id;
                            $sql = "select * from access_modules where  access_modules_id='$access_modules_id' ";
                            $access_modules = $this->userModel->customQuery($sql);
                            if (@$access_modules[0]->segment_1 == $uri1) {
                                $viewFlag = 1;
                                if (@$access_modules[0]->segment_3 == 'add') {
                                    $addFlag = 1;
                                }
                                if (@$access_modules[0]->segment_3 == 'edit') {
                                    $editFlag = 1;
                                }
                                if (@$access_modules[0]->segment_3 == 'delete') {
                                    $deleteFlag = 1;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            return redirect()->to(base_url() . '/supercontrol/Login');
        }
    

        if ($deleteFlag == 0) {
            echo "Operation not allowed";
            exit;
        }

        // Checking Access user END##############
        // Access END
        $data = [];
        helper(['form', 'url']);
        $uri = service('uri');
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
            $res = $this->userModel->do_action('master_category', $uri1, 'product_id', 'delete', '', '');
            $this->session->setFlashdata('success', 'Category Deleted successfully!');
            return redirect()->to(site_url('supercontrol/Category'));
        }
    }

    public function edit() {
        $session = session();
        // Access Check
          $access = $this->userModel->grant_access(false);
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "name" => [
                    "label" => "Name",
                    "rules" => "required"
                ],
                "price" => [
                    "label" => "Price",
                    "rules" => "required|regex_match[/^-?\d+(\.\d+)?$/]",
                    "errors" => [
                        "regex_match" => "Please enter a valid price format"
                    ]
                ],
                "status" => [
                    "label" => "status",
                    "rules" => "required"
                ]
            ];
            if ($this->validate($rules)) {
                $p = $this->request->getVar();
                asort($_FILES['file']['name'] , SORT_STRING);
                // var_dump($_FILES['file']['name']);die();
                /*  $input = $this->validate([
                'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
                ]
                ]);
                if (!$input) {}else{
                if($this->request->getFile('file')){
                $img = $this->request->getFile('file');
                $img->move(ROOTPATH.'/assets/uploads/');
                $p['product_image']=$img->getName();
                }
                }*/

                if ($_FILES['file']['name'][0]) {
                    $input = $this->validate(['file' => ['uploaded[file]']]);
                    if (!$input) {
                    } else {
                        if ($this->request->getFileMultiple('file')) {
                            for($i=0 ; $i<sizeof($_FILES["file"]["name"]) ; $i++){
                                $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $_FILES["file"]["name"][$i]);
                                $ext = substr($_FILES["file"]["name"][$i] , strrpos($_FILES["file"]["name"][$i] , "."));

                                $filename = $this->clear_whitespace(array($filename))[0];
                                $filename = $filename.$ext;
                                
                                $type = $_FILES["file"]["type"][$i];
                                $tmp = $_FILES["file"]["tmp_name"][$i];
                                list($width, $height) = getimagesize($tmp);

                                $scale_percent = 80000/(max($width , $height))/100;
                                if($thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , true)){
                                    imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$filename , 85);
                                    $b=true;
                                    imagedestroy($thumb);
                                    $pi['image'] = $filename;
                                    $pi['product'] = $p['product_id'];
                                    $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                                }
                            }
                        }
                    }
                }

                if ($_FILES['file2']['name'][0]) {
                    if ($this->request->getFileMultiple('file2')) {
                        for($i=0 ; $i<sizeof($_FILES["file2"]["name"]) ; $i++){
                            $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $_FILES["file2"]["name"][$i]);
                            $ext = substr($_FILES["file2"]["name"][$i] , strrpos($_FILES["file2"]["name"][$i] , "."));

                            $filename = $this->clear_whitespace(array($filename))[0];
                            $filename = $filename.$ext; 
                            
                            $type = $_FILES["file2"]["type"][$i];
                            $tmp = $_FILES["file2"]["tmp_name"][$i];
                            list($width, $height) = getimagesize($tmp);

                            $scale_percent = 80000/(max($width , $height))/100;
                            if($thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , false)){
                                imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$filename , 85);
                                $b=true;
                                imagedestroy($thumb);
                                $pi2['image'] = $filename;
                                $pi2['product'] = $p['product_id'];
                                $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi2, '');
                            }
                        }
                    }
                }

                $res = $this->userModel->do_action('related_products', $p['product_id'], 'product_id', 'delete', '', '');
                if ($t = $this->request->getVar('related_products')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['related_product'] = $vt;
                        $resIMG = $this->userModel->do_action('related_products', '', '', 'insert', $pi2, '');
                    }
                }

                $res = $this->userModel->do_action('attributes', $p['product_id'], 'product_id', 'delete', '', '');
                if ($t = $this->request->getVar('type')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'type';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['type']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['type'] = implode(",", $this->request->getVar('type'));
                }

                // Here check if the product is a bundle with options
                if ($bdl_opt_ = $this->request->getVar('bundle_opt_enabled')) {
                    if ($bdl_opt_ == "Yes"){
                        $opt = $this->request->getVar('bundle_opt');
                        $opt_price = $this->request->getVar('additional_price');
                        if(!$this->productModel->is_valid_bundle_options($opt , $opt_price))
                        $data["validation"]="Please select at least 2 options for each option group";  

                        else{
                            $this->userModel->do_action('opt_group', $p["product_id"], 'product_id', 'delete', '', '');
                            $this->productModel->create_product_bundle_options($opt , $opt_price , $p["product_id"]);
                            
                            $p["bundle_opt_enabled"]="Yes";
                            unset($p["bundle_opt"]);
                            unset($p["additional_price"]);

                        }                
                    }
                    else{
                        $p["bundle_opt_enabled"]="No";
                        $this->userModel->do_action('opt_group', $p["product_id"], 'product_id', 'delete', '', '');
                        unset($p["bundle_opt"]);
                        unset($p["additional_price"]);

                    }
                }

                if ($t = $this->request->getVar('suitable_for')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'suitable_for';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['suitable_for']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['suitable_for'] = implode(",", $this->request->getVar('suitable_for'));
                }

                if ($t = $this->request->getVar('age')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'age';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['age']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['age'] = implode(",", $this->request->getVar('age'));
                }

                if ($t = $this->request->getVar('color')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'color';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['color']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['color'] = implode(",", $this->request->getVar('color'));
                }

                if($this->request->getVar('discount_type') == "")
                unset($p["discount_type"]);
                
                if($this->request->getVar('offer_end_date')!==""){
                    $p["offer_end_date"] = (new \dateTime($this->request->getVar('offer_end_date'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('offer_start_date')!==""){
                    $p["offer_start_date"] = (new \dateTime($this->request->getVar('offer_start_date'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('valid_from')!==""){
                    $p["valid_from"] = (new \dateTime($this->request->getVar('valid_from'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('valid_until')!==""){
                    $p["valid_until"] = (new \dateTime($this->request->getVar('valid_until'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                $p["set_as_new"] = $this->request->getVar("set_as_new");
                if($p["set_as_new"] == "Yes"){
                    if($this->request->getVar('new_from')!==""){
                        $p["new_from"] = (new \dateTime($this->request->getVar('new_from'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                    }

                    if($this->request->getVar('new_until')!==""){
                        $p["new_until"] = (new \dateTime($this->request->getVar('new_until'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                    }
                }
                
                if(trim($this->request->getVar('slug')) !== ""){
                    $slug = $this->productModel->createurl($this->request->getVar("slug"));
                    $p["slug"] = $slug;
                }
                
                if($p["product_nature"] == "Simple"){
                    unset($p["parent"]);
                    unset($p["attribute_variation"]);
                    unset($p["attributes"]);

                }

                elseif($p["product_nature"] == "Variable"){
                    if(sizeof($p["attributes"]) > 0 && $p["attributes"] !== null && $this->attributeModel->attributes_exist($p["attributes"])){
                        $p["attributes"] = implode("," , $p["attributes"]);
                    }
                    unset($p["parent"]);
                    unset($p["attribute_variation"]);
                }

                elseif($p["product_nature"] == "Variation"){
                    unset($p["attributes"]);
                    if(sizeof($p["attribute_variation"]) > 0 && trim($p["parent"]) !== ""){

                        $condition = $this->attributeModel->is_valid_variation($p["attribute_variation"] , $p["parent"]);
                        if($condition){
                            $p["attribute_variation"] = $this->attributeModel->variation_to_json($p["attribute_variation"]);
                        }
                        
                    }
                    else unset($p["attribute_variation"]);
                }

                if($this->request->getVar('google_category') != "" && is_int($this->request->getVar('google_category'))){
                    $p["google_product"] == $this->request->getVar('google_category');
                }
                

                unset($p['product_id']);
                unset($p['related_products']);
                unset($p['additional_price']);

                $p['category'] = implode(",", $this->request->getVar('category'));

                // var_dump($p);die();

                if(true)
                $res = $this->userModel->do_action('products', $this->request->getVar('product_id'), 'product_id', 'update', $p, '');
                // else{

                // }
                $this->session->setFlashdata('success', 'Product updated successfully!');
                return redirect()->to(site_url('supercontrol/Products'));
            } 
            else {
                // $data["validation"] = $validation->getErrors();
                $errors = "";
                array_walk($validation->getErrors() , function($error)use(&$errors){
                    $errors .= $error." <br>";
                });
                $session->setFlashdata("Error" , $errors);
            }
        }

        $gp = $this->productModel->get_gp_list();
        echo $this->header();
        echo view('/Supercontrol/AddProducts',array("gp"=>$gp));
        echo $this->footer();
    }
    
    public function add() {
        $session = session();
        // Access Check
            $access = $this->userModel->grant_access(false);
            if(is_array($access)){
              if ($access["viewFlag"] == 0){
                  return view("errors/html/permission_denied");
                  exit;
              }
            }
        // Access Check

        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            // var_dump($this->request->getVar());die();
            $validation = \Config\Services::validation();
            $rules = [
                "name" => [
                    "label" => "Name",
                    "rules" => "required"
                ],
                "price" => [
                    "label" => "Price",
                    "rules" => "required|regex_match[/^-?\d+(\.\d+)?$/]",
                    "errors" => [
                        "regex_match" => "Please enter a valid price format"
                    ]
                ],
                "status" => [
                    "label" => "status",
                    "rules" => "required"
                ]
            ];
            if ($this->validate($rules)) {
                $p = $this->request->getVar();
                if (strlen($p['name']) > 28) {
                    $p['product_id'] = url_title(substr($p['name'], 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                } 
                else {
                    $p['product_id'] = url_title($p['name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                }

                if ($sku = $this->request->getVar('sku')) {
                    $sql = "select * from products where  sku='$sku' ";
                    $esku = $this->userModel->customQuery($sql);
                    if ($esku) {
                        $data["validation"] = "Product not added. SKU already exists for another product!";
                        echo $this->header();
                        echo view('/Supercontrol/AddProducts', $data);
                        echo $this->footer();
                        exit;
                    }
                }

                if ($_FILES['file']['name'][0]) {
                    $input = $this->validate(['file' => ['uploaded[file]']]);
                    if (!$input) {
                    } else {

                        if ($this->request->getFileMultiple('file')) {
                            asort($_FILES['file']['name'] , SORT_STRING);
                            for($i=0 ; $i<sizeof($_FILES["file"]["name"]) ; $i++){
                                $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $_FILES["file"]["name"][$i]);
                                $ext = substr($_FILES["file"]["name"][$i] , strrpos($_FILES["file"]["name"][$i] , "."));

                                $filename = $this->clear_whitespace(array($filename))[0];
                                $filename = $filename.$ext;
                                $type = $_FILES["file"]["type"][$i];
                                $tmp = $_FILES["file"]["tmp_name"][$i];
                                list($width, $height) = getimagesize($tmp);

                                $scale_percent = 80000/(max($width , $height))/100;
                                if($thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , true)){
                                    imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$filename , 85);
                                    $b=true;
                                    imagedestroy($thumb);
                                    $pi['image'] = $filename;
                                    $pi['product'] = $p['product_id'];
                                    $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                                }
                            }
                        }
                    }
                }

                if ($_FILES['file2']['name'][0]) {
                    if ($this->request->getFileMultiple('file2')) {
                        for($i=0 ; $i<sizeof($_FILES["file2"]["name"]) ; $i++){
                            $filename = preg_replace(array("/(.jpeg)/","/(.jpg)/","/(.png)/","/(.gif)/") , array("","","") , $_FILES["file2"]["name"][$i]);
                            $ext = substr($_FILES["file2"]["name"][$i] , strrpos($_FILES["file2"]["name"][$i] , "."));

                            $filename = $this->clear_whitespace(array($filename))[0];
                            $filename = $filename.$ext;
                            $type = $_FILES["file2"]["type"][$i];
                            $tmp = $_FILES["file2"]["tmp_name"][$i];
                            list($width, $height) = getimagesize($tmp);

                            $scale_percent = 80000/(max($width , $height))/100;
                            if($thumb = $this->resize($tmp , $type , $width , $height , $scale_percent , false)){
                                imagejpeg($thumb , ROOTPATH . '/assets/uploads/'.$filename , 85);
                                $b=true;
                                imagedestroy($thumb);
                                $pi2['image'] = $filename;
                                $pi2['product'] = $p['product_id'];
                                $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi2, '');
                            }
                        }
                    }
                }

                if ($t = $this->request->getVar('type')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'type';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['type']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['type'] = implode(",", $this->request->getVar('type'));
                }

                // Here check if the product is a bundle with options
                if ($bdl_opt_ = $this->request->getVar('bundle_opt_enabled')) {
                    if ($bdl_opt_ == "Yes"){
                        $opt = $this->request->getVar('bundle_opt');
                        $opt_price = $this->request->getVar('additional_price');
                        if(!$this->productModel->is_valid_bundle_options($opt , $opt_price))
                        $data["validation"]="Please select at least 2 options for each option group";  

                        else{
                            $this->userModel->do_action('opt_group', $p["product_id"], 'product_id', 'delete', '', '');
                            $this->productModel->create_product_bundle_options($opt , $opt_price , $p["product_id"]);
                            
                            $p["bundle_opt_enabled"]="Yes";
                            unset($p["bundle_opt"]);
                            unset($p["additional_price"]);

                        }                
                    }
                    else{
                        $p["bundle_opt_enabled"]="No";
                        $this->userModel->do_action('opt_group', $p["product_id"], 'product_id', 'delete', '', '');
                        unset($p["bundle_opt"]);
                        unset($p["additional_price"]);

                    }
                }

                if ($t = $this->request->getVar('suitable_for')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'suitable_for';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['suitable_for']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['suitable_for'] = implode(",", $this->request->getVar('suitable_for'));
                }

                if ($t = $this->request->getVar('age')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'age';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['age']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['age'] = implode(",", $this->request->getVar('age'));
                }

                if ($t = $this->request->getVar('color')) {
                    foreach ($t as $kt => $vt) {
                        $pi2['type'] = 'color';
                        $pi2['product_id'] = $p['product_id'];
                        $pi2['attribute_id'] = $vt;
                        unset($p['color']);
                        $resIMG = $this->userModel->do_action('attributes', '', '', 'insert', $pi2, '');
                    }
                    $p['color'] = implode(",", $this->request->getVar('color'));
                }

                if($this->request->getVar('discount_type') == "")
                unset($p["discount_type"]);
                
                if($this->request->getVar('offer_end_date')!==""){
                    $p["offer_end_date"] = (new \dateTime($this->request->getVar('offer_end_date'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('offer_start_date')!==""){
                    $p["offer_start_date"] = (new \dateTime($this->request->getVar('offer_start_date'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('valid_from')!==""){
                    $p["valid_from"] = (new \dateTime($this->request->getVar('valid_from'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }

                if($this->request->getVar('valid_until')!==""){
                    $p["valid_until"] = (new \dateTime($this->request->getVar('valid_until'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                }


                $p["set_as_new"] = $this->request->getVar("set_as_new");
                if($p["set_as_new"] == "Yes"){
                    if($this->request->getVar('new_from')!==""){
                        $p["new_from"] = (new \dateTime($this->request->getVar('new_from'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                    }

                    if($this->request->getVar('new_until')!==""){
                        $p["new_until"] = (new \dateTime($this->request->getVar('new_until'),new \dateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
                    }
                }
                
                if(trim($this->request->getVar('slug')) !== ""){
                    $slug = $this->productModel->createurl($this->request->getVar("slug"));

                    $p["slug"] = $slug;
                }
                
                if(!$p["product_nature"] == "simple"){
                    unset($p["parent"]);
                    unset($p["attribute_variation"]);
                    unset($p["attributes"]);

                }

                elseif($p["product_nature"] == "Variable"){
                    if($p["attributes"] !== null && sizeof($p["attributes"]) > 0 && $this->attributeModel->attributes_exist($p["attributes"])){
                        $p["attributes"] = implode("," , $p["attributes"]);
                    }
                    unset($p["parent"]);
                    unset($p["attribute_variation"]);
                }

                elseif($p["product_nature"] == "Variation"){
                    unset($p["attributes"]);
                    if(sizeof($p["attribute_variation"]) > 0 && trim($p["parent"]) !== ""){

                        $condition = $this->attributeModel->is_valid_variation($p["attribute_variation"] , $p["parent"]);
                        if($condition){
                            $p["attribute_variation"] = $this->attributeModel->variation_to_json($p["attribute_variation"]);
                        }
                        
                    }
                    else unset($p["attribute_variation"]);
                }

                if($this->request->getVar('google_category') != "" && is_int($this->request->getVar('google_category'))){
                    $p["google_product"] == $this->request->getVar('google_category');
                }

                $p['category'] = implode(",", $this->request->getVar('category'));
                unset($p['related_products']);
                unset($p['additional_price']);
                // var_dump($p);die();

                $res = $this->userModel->do_action('products', '', '', 'insert', $p, '');

                if ($t = $this->request->getVar('related_products')) {
                    foreach ($t as $kt => $vt) {
                        $rpData['product_id'] = $p['product_id'];
                        $rpData['related_product'] = $vt;
                        $resIMG = $this->userModel->do_action('related_products', '', '', 'insert', $rpData, '');
                    }
                }
                $this->session->setFlashdata('success', 'Product Added successfully!');

                return redirect()->to(site_url('supercontrol/Products'));
            } 
            else {
                // $data["validation"] = $validation->getErrors();
                $errors = "";
                array_walk($validation->getErrors() , function($error)use(&$errors){
                    $errors .= $error." <br>";
                });
                $session->setFlashdata("Error" , $errors);
                
            }
            exit;
        }

        $gp = $this->productModel->get_gp_list();
        echo $this->header();
        echo view('/Supercontrol/AddProducts' , array("gp"=>$gp , "validation" => $data["validation"]));
        echo $this->footer();
    }

    public function index() {
        // die();
        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
          $crud->unsetAdd();

        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('products');
        $crud->setRelation("type" , "type", "title");
        $crud->setRelation("brand" , "brand", "title");
        $crud->setRelation("google_category" , "google_product_categories", "category");
        $crud->displayAs('type','Product type');
        $crud->displayAs('set_as_new','Is new');
        $crud->setSubject('Product', 'Products');
        $crud->columns([
                'sku',
                'precedence',
                'name', 
                'parent',
                'type',
                'brand',
                'product_nature',
                'images',
                'price',
                'set_as_new',
                'show_this_product_in_home_page',
                'available_stock',
                'category', 
                'description',
                "pre_order_enabled",
                "show_this_product_in_home_page",
                'google_category',
                'status',
                'created_at'
                ]);
        // $crud->where(["products.type != ?" => "6"]);
        // Show product images
        $crud->callbackColumn('images', function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html = '<img class="brand-logo" width="50" src="' . base_url() . '/assets/uploads/' . $pimg[0]->image . '">';
            } else {
                $html = '<img class="brand-logo" width="50" src="' . base_url() . '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });

        // make quantity as field settable
        $crud->callbackColumn('available_stock', function ($value, $row) {
            $sql = "select available_stock from products where product_id='".$row->product_id."'";
            $p_stock = $this->userModel->customQuery($sql);
            // var_dump($p_stock);die();
            if ($p_stock) {
                $html = '<input class="edit_stock_qty" type="number" name="dg_produc_stock" p_id="'.$row->product_id.'" value="'.$p_stock[0]->available_stock.'">';
            } else {
                $html = '<input class="edit_stock_qty" type="number" name="dg_produc_stock" p_id="'.$row->product_id.'" value="">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });
        
        // make precedence as settable field
        $crud->callbackColumn('precedence', function ($value, $row) {
            $sql = "select precedence from products where product_id='".$row->product_id."'";
            $p_precedence = $this->userModel->customQuery($sql);
            // var_dump($p_precedence);die();
            if ($p_precedence) {
                $html = '<input class="edit_precedence" type="number" name="dg_produc_precedence" p_id="'.$row->product_id.'" value="'.$p_precedence[0]->precedence.'">';
            } else {
                $html = '<input class="edit_precedence" type="number" name="dg_produc_precedence" p_id="'.$row->product_id.'" value="">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });

        // Display categories names
        $crud->callbackColumn('category', function ($value, $row) {
            $html = "";
            $cats = array_map(function($id) use (&$html){
                if($id !=="0"){
                    $title = $this->category->_getcatname($id);
                    $html .= "<span class='p-2 m-1 bg-dark' style='color: white'>$title</span>";
                }
            } , explode("," , $value));

            return '<div class="p-1">'.$html.'</div>';
        });

        // make set as new settable field
        $crud->callbackColumn('set_as_new', function ($value, $row) {
            $sql = "select set_as_new from products where product_id='".$row->product_id."'";
            $is_new = $this->userModel->customQuery($sql);
            // var_dump($p_precedence);die();
            if ($is_new) {
                $yes_selected=$no_selected="selected";

                if($is_new[0]->set_as_new == "Yes")
                    $no_selected="";
                else
                    $yes_selected = "";

                $html = '
                <select class="edit_set_as_new" name="dg_set_as_new" p_id="'.$row->product_id.'">
                    <option '.$yes_selected.' value="Yes">Yes</option>
                    <option '.$no_selected.' value="No">No</option>
                </select>
                ';
            } else {
                $html = '';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });

        // Edit product rights
        if($editFlag !== 0)
        $crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return '/supercontrol/Products/edit/' . $row->product_id;
        }, false);

        // Add duplicate button
        if($addFlag !== 0)
        $crud->setActionButton("Duplicate" , "fa-regular fa-copy" , function($row){
            return base_url()."/supercontrol/products/duplicate_product/".$row->product_id;
        });
        
        $crud->defaultOrdering('products.created_at', 'desc');
        $output = $crud->render();
        // var_dump($output);die();
        return $this->_example_output($output);
    }

    private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;

        }
        echo view('/Supercontrol/Common/Header', (array)$output);
        echo view('/Supercontrol/Crud.php', (array)$output);
        echo view('/Supercontrol/Common/Footer', (array)$output);
    }

    private function _getDbData() {
        $db = (new \Config\Database())->default;
        return ['adapter' => ['driver' => 'Pdo_Mysql', 'host' => $db['hostname'], 'database' => $db['database'], 'username' => $db['username'], 'password' => $db['password'], 'charset' => 'utf8']];
    }

    private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

    public function yahia(){
        $msg=array();
        $flag=$this->request->getVar("flag");

        if($flag == "edit_stock"){
            if(is_int((int)$this->request->getVar('stock_qty'))){
                if(!$this->userModel->do_action('products', $this->request->getVar('product_id'),'product_id', 'update', array("available_stock"=>$this->request->getVar('stock_qty')),''))
                $msg[0]="Something went wrong";
            }
            else{
                $msg[0]="Please enter a valid quantity";
            }
        }

        else if($flag == "edit_precedence"){
            
            if($this->request->getVar("precedence")){
                
                if(is_int((int)$this->request->getVar('precedence'))){
                    $req="update products set precedence='".$this->request->getVar('precedence')."' where product_id='".$this->request->getVar('product_id')."'";
                    $res=$this->userModel->customQuery($req);
                }
                else{
                    $msg[0]="Please enter a valid number";
                }
            }
        }

        else if($flag == "edit_set_as_new"){
            if($this->request->getVar("set_as_new")){
                
                if(in_array($this->request->getVar('set_as_new') , ["Yes" , "No"])){
                    $req="update products set set_as_new='".$this->request->getVar('set_as_new')."' where product_id='".$this->request->getVar('product_id')."'";
                    $res=$this->userModel->customQuery($req);
                }
                else{
                    $msg[0]="Please enter a valid choice";
                }
            }
        }

        echo(json_encode($msg));
        
    }

    public function export(){

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        // $category_model=model("App\Models\Category","false");
        // $products= $category_model->customQuery("select sku,name,price,available_stock,brand,color,age,discount_percentage,category from products where status='Active'");
        // $products= $category_model->customQuery("select * from brand");
   
        $productmodel= model("App\Models\ProductModel");
        $userModel= model("App\Models\UserModel");
        $products= $userModel->customQuery("select * from products where status='Active'");

        // echo(ROOTPATH."assets\exports\products.csv");die();
        $path=ROOTPATH."assets/exports";
        if(!file_exists($path)){
            $b=mkdir($path);
        }
                        
        $csv=array(array(
            "SKU",
            "NAME",
            "PARENT",
            "TYPE",
            "NATURE",
            "CATEGORIES",
            // "BRAND",
            // "IS PREORDER",
            // "AGE",
            "PRICE",
            "discount_type",
            "discount_percentage",
            "offer_start_date",
            "offer_end_date",
            "AVAILABLE STOCK",
            // "SUITABLE FOR",
            // "LINK",
            // "PRODUCT IMAGE",
            // "PRODUCT SCREENSHOTS"
        ));
        foreach ($products as $key => $value) {
            # code...
            
            $ligne=array(
                /* SKU */                   $value->sku,
                /* NAME */                  $value->name,
                /* PARENT */                $productmodel->get_product_sku_from_id($value->parent),
                /* PRODUCT TYPE */          $productmodel->get_product_types($value->type),
                /* PRODUCT NATURE */        $value->product_nature,
                /* PRODUCT CATEGORIES */    $productmodel->get_product_categories($value->category),
                // /* BRAND */                 $productmodel->get_brand_names($value->brand),
                // /* IS PREORDER */                 $value->pre_order_enabled,
                // /* AGE RATING */            $productmodel->get_product_age($value->age),
                /* PRICE */                 $value->price,
                /* DISCOUNT TYPE */         $value->discount_type,
                /* DISCOUNT AMOUNT */       $value->discount_percentage,
                /* OFFER START DATE */      $value->offer_start_date,
                /* OFFER END DATE */        $value->offer_end_date,
                /* AVAILBALE STOCK */       $value->available_stock,
                // /* SUITABLE FOR */          $productmodel->get_suitable_for($value->suitable_for),
                // /* PRODUCT PAGE LINK */     base_url()."/product/".$value->product_id,
                // /* PRODUCT IMAGE */         $productmodel->get_product_image($value->product_id),
                // /* PRODUCT SCRENSHOTS */    $productmodel->get_product_screenshots($value->product_id),
            );
         
            array_push($csv,$ligne);
        }

        $file_name="products_export".rand(555,105000).".csv";
        $fp = fopen($path."/".$file_name, 'a');

        foreach ($csv as $fields) {
            fputcsv($fp, $fields,",");
        }

        fclose($fp);


        // return redirect()->to(site_url('/supercontrol/Products'));
        return redirect()->to(base_url()."/assets/exports/".$file_name);


    }
    
    public function imagelist(){

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $images  = array_merge(glob(ROOTPATH."/assets/uploads/*.jpg" , GLOB_NOSORT ) , glob(ROOTPATH."/assets/uploads/*.png" , GLOB_NOSORT ));
        array_multisort(array_map('filemtime', $images), SORT_NUMERIC , SORT_DESC , $images);
        echo view("Supercontrol/Common/Header");
        echo view("Supercontrol/Imagelist" , ["images" => $images]);
        echo view("Supercontrol/Common/Footer");

    }
    
    public function delete_uploaded_image(){
        $stat = ["success" => 0];
        if($this->request->getMethod() == "post"){
            $image = ROOTPATH.$this->request->getVar("file_name");
            if(file_exists($image) && unlink($image)){
                $stat["success"] = 1;
            }
        }
    
        return json_encode($stat);
    }

    public function search_uploaded_images(){
        $result = array();
        $html = "";
        $i = 0;
        if($this->request->getMethod() == "post"){
            // var_dump($_POST);
            $offset = (isset($_POST["offset"])) ? $this->request->getVar("offset") : 0 ;
            $limit = 29;
            $keyword = (trim($this->request->getVar("keyword")) == "") ? "*" : "*".$this->request->getVar("keyword")."*";
            // echo($keyword);
            // if(trim($keyword) !== ""){
                $files = array_merge(glob(ROOTPATH."/assets/uploads/".$keyword.".jpg") , glob(ROOTPATH."/assets/uploads/".$keyword.".png") , glob(ROOTPATH."/assets/others/".$keyword.".jpg") , glob(ROOTPATH."/assets/others/".$keyword.".png"));
                array_multisort(array_map('filemtime', $files), SORT_NUMERIC , SORT_DESC , $files);
                // var_dump($files);
                foreach ($files as $key => $value) {
                // for($i=$offset ; $i<=$limit ; $i++) {
                    # code...
                    if($i >= $offset && $i <= $limit+$offset){
                        preg_match("/others/" , $value , $match);
                        $dir = (sizeof($match) > 0) ? "/assets/others/" : "/assets/uploads/" ;
                        $html .= '
                        <div class="col-2 element p-1">
                            <div class="col-12 image-container d-flex a-a-center j-c-center p-0">
                                <div class="img_ctrl col-12">
                                    <button class="del_btn btn btn-danger ">Delete</button>
                                </div>
                                <img src="'.base_url().$dir.basename($value).'" alt="" data="'.str_replace(ROOTPATH , "" , pathinfo($value)["dirname"]).'/'.basename($value).'">
                            </div>
                        </div>
                        ';
                    }
                    
                    $i++;
                }
                return $html;
            // }
        }
    
        // return json_encode($stat);
    }

    public function duplicate_product($id){

        // Access Check
          $access = $this->userModel->grant_access(false);
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $product = array();
        $screenshots = array();
        $req1 = "select * from products where product_id='".$id."'";
        $req2 = "select image from product_screenshot where product='".$id."'";
        $product_res = $this->userModel->customQuery($req1);
        $product_screenshots = $this->userModel->customQuery($req2);
        // var_dump($product_res , $product_screenshots);die();
        if($product_res){
            // prepare product
            $product = [
                "product_id" => rand(100 , 10000).(new \DateTime("now"))->getTimestamp(),
                "category" => $product_res[0]->category,
                "google_category" => $product_res[0]->google_category,
                "type" => $product_res[0]->type,
                "product_nature" => $product_res[0]->product_nature,
                "parent" => $product_res[0]->parent,
                "attribute_variation" => $product_res[0]->attribute_variation,
                "attributes" => $product_res[0]->attributes,
                "name" => $product_res[0]->name,
                "arabic_name" => $product_res[0]->arabic_name,
                "brand" => $product_res[0]->brand,
                "suitable_for" => $product_res[0]->suitable_for,
                "age" => $product_res[0]->age,
                "price" => $product_res[0]->price,
                "available_stock" => $product_res[0]->available_stock,
                "description" => $product_res[0]->description,
                "arabic_description" => $product_res[0]->arabic_description,
                "features" => $product_res[0]->features,
                "arabic_features" => $product_res[0]->arabic_features,
                "pre_order_enabled" => $product_res[0]->pre_order_enabled,
                "release_date" => $product_res[0]->release_date,
                "sku" => $product_res[0]->sku."-1",
                "status" => "Inactive",
                "page_keywords" => $product_res[0]->page_keywords,
                "page_description" => $product_res[0]->page_description,
                "precedence" => $product_res[0]->precedence,
                "freebie" => $product_res[0]->freebie,
                "evergreen" => $product_res[0]->evergreen,
                "exclusive" => $product_res[0]->exclusive,
            ];
            // var_dump($product);die();

            // create product
            $this->userModel->do_action("products" , "" , "" , "insert" , $product , "");

            // create screenshots
            if($product_screenshots)
            foreach ($product_screenshots as $key => $value) {
                # code...
                $this->userModel->do_action("product_screenshot" , "" , "" , "insert" , ["product" => $product["product_id"] , "image" => $value->image] , "");
            }

        }

        return redirect()->to(site_url("/supercontrol/Products"));
    }

    public function ezpin(){

        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check
        
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('products');
        $crud->setRelation("type" , "type", "title");
        $crud->setRelation("google_category" , "google_product_categories", "category");
        $crud->displayAs('type','Product type');
        $crud->displayAs('set_as_new','Is new');
        $crud->setSubject('EWPIN Product', 'EWPIN Products');
        $crud->where(["type" => "6" ]);
        $crud->columns(['sku' , 'precedence' , 'name', 'type' , 'images' , 'price' , 'ez_price' , 'set_as_new' , 'available_stock' , 'category', 'description' , "pre_order_enabled" ,  'google_category' , 'price_fixed' , 'currency' , 'regions' , 'status' ,  'created_at']);
        
        // Show product images
        $crud->callbackColumn('images', function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html = '<img class="brand-logo" width="50" src="' . base_url() . '/assets/uploads/' . $pimg[0]->image . '">';
            } else {
                $html = '<img class="brand-logo" width="50" src="' . base_url() . '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });

        // make quantity as field settable
        $crud->callbackColumn('available_stock', function ($value, $row) {
            $sql = "select available_stock from products where product_id='".$row->product_id."'";
            $p_stock = $this->userModel->customQuery($sql);
            // var_dump($p_stock);die();
            if ($p_stock) {
                $html = '<input class="edit_stock_qty" type="number" name="dg_produc_stock" p_id="'.$row->product_id.'" value="'.$p_stock[0]->available_stock.'">';
            } else {
                $html = '<input class="edit_stock_qty" type="number" name="dg_produc_stock" p_id="'.$row->product_id.'" value="">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });
        
        // make precedence as settable field
        $crud->callbackColumn('precedence', function ($value, $row) {
            $sql = "select precedence from products where product_id='".$row->product_id."'";
            $p_precedence = $this->userModel->customQuery($sql);
            // var_dump($p_precedence);die();
            if ($p_precedence) {
                $html = '<input class="edit_precedence" type="number" name="dg_produc_precedence" p_id="'.$row->product_id.'" value="'.$p_precedence[0]->precedence.'">';
            } else {
                $html = '<input class="edit_precedence" type="number" name="dg_produc_precedence" p_id="'.$row->product_id.'" value="">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });

        // make set as new settable field
        $crud->callbackColumn('set_as_new', function ($value, $row) {
            $sql = "select set_as_new from products where product_id='".$row->product_id."'";
            $is_new = $this->userModel->customQuery($sql);
            // var_dump($p_precedence);die();
            if ($is_new) {
                $yes_selected=$no_selected="selected";

                if($is_new[0]->set_as_new == "Yes")
                    $no_selected="";
                else
                    $yes_selected = "";

                $html = '
                <select class="edit_set_as_new" name="dg_set_as_new" p_id="'.$row->product_id.'">
                    <option '.$yes_selected.' value="Yes">Yes</option>
                    <option '.$no_selected.' value="No">No</option>
                </select>
                ';
            } else {
                $html = '';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return $html;
        });


        $crud->unsetAdd();
        $crud->unsetEdit();
        // $crud->editFields(["price" , "available_stock" , "pre_order_enabled" , ]);
        if($editFlag !== 0)
        $crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return '/supercontrol/Products/edit/' . $row->product_id;
        }, false);

        // Add duplicate button
        if($addFlag !== 0)
        $crud->setActionButton("Duplicate" , "fa-regular fa-copy" , function($row){
            return base_url()."/supercontrol/products/duplicate_product/".$row->product_id;
        });
        
        $crud->defaultOrdering('products.created_at', 'desc');
        $output = $crud->render();
        // var_dump($output);die();
        return $this->_example_output($output);
    }

    public function update_codes(){
        $access = $this->userModel->grant_access();

        if($access["viewFlag"] == 1){
            $this->ezpinModel->zg_ezpin_catalog_update();
            return redirect()->to(site_url("supercontrol/products/ezpin"));
        }

        return view("errors/html/permission_denied");
    }
}
