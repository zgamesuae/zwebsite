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

    public function bulkUpload(){


        $category_model=model("App\Models\Category");
        $data = [];
        $recognized_field = array(
                "category" =>                               array("required_fo_update"=>false , "required_for_creation"=>true),
                "sub_category" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
                "sub_category_sub" =>                       array("required_fo_update"=>false , "required_for_creation"=>false),
                "type" =>                                   array("required_fo_update"=>false , "required_for_creation"=>true),
                "name" =>                                   array("required_fo_update"=>false , "required_for_creation"=>true),
                "brand" =>                                  array("required_fo_update"=>false , "required_for_creation"=>true),
                "suitable_for" =>                           array("required_fo_update"=>false , "required_for_creation"=>true),
                "age" =>                                    array("required_fo_update"=>false , "required_for_creation"=>false),
                "genre" =>                                  array("required_fo_update"=>false , "required_for_creation"=>false),
                "price" =>                                  array("required_fo_update"=>false , "required_for_creation"=>true),
                "available_stock" =>                        array("required_fo_update"=>false , "required_for_creation"=>true),
                "discount_percentage" =>                    array("required_fo_update"=>false , "required_for_creation"=>false),
                "description" =>                            array("required_fo_update"=>false , "required_for_creation"=>true),
                "features" =>                               array("required_fo_update"=>false , "required_for_creation"=>false),
                "gift_wrapping" =>                          array("required_fo_update"=>false , "required_for_creation"=>false),
                "assemble_professionally" =>                array("required_fo_update"=>false , "required_for_creation"=>false),
                "assemble_professionally_price" =>          array("required_fo_update"=>false , "required_for_creation"=>false),
                "sku" =>                                    array("required_fo_update"=>true , "required_for_creation"=>true),
                "youtube_link" =>                           array("required_fo_update"=>false , "required_for_creation"=>false),
                "show_this_product_in_home_page" =>         array("required_fo_update"=>false , "required_for_creation"=>false),
                "product_image" =>                          array("required_fo_update"=>false , "required_for_creation"=>true),
                "product_screenshot" =>                     array("required_fo_update"=>false , "required_for_creation"=>true),
                "freebie" =>                                array("required_fo_update"=>false , "required_for_creation"=>false),
                "evergreen" =>                              array("required_fo_update"=>false , "required_for_creation"=>false),
                "exclusive" =>                              array("required_fo_update"=>false , "required_for_creation"=>false),
                "pre_order_enabled" =>                      array("required_fo_update"=>false , "required_for_creation"=>false),
                "pre_order_before_payment_percentage" =>    array("required_fo_update"=>false , "required_for_creation"=>false),
                "release_date" =>                           array("required_fo_update"=>false , "required_for_creation"=>false)
        );

    



        $headers=$header_helper=array();

        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $input = $this->validate(['file' => ['uploaded[file]']]);
            if (!$input) {
            } 
            else {
                if ($this->request->getFile('file')) {
                    // $_file = $this->request->getFile('file');
                    // $_file->move(ROOTPATH . '/assets/uploads/');
                    // $fullPath = ROOTPATH . '/assets/uploads/' . $_file->getName();
                    // $fullPath = ROOTPATH . '/assets/uploads/upload_test_y_2.csv';
                    $fullPath = ROOTPATH . '/assets/uploads/PC_gaming.csv';


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
                        foreach ($headers as $key => $value) {
                            # code...
                            if(array_key_exists(trim($value) , $recognized_field)){
                                if($recognized_field[$value]["required_fo_update"] == true)
                                $r++;
                                if($recognized_field[$value]["required_for_creation"] == true)
                                $ru++;
                            }
                            else 
                            $boolean=false;
                        }
                        // echo(sizeof($arra[1]));

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
                                $p_image=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["product_image"]]));
                                $p_screenshots=$this->clear_blanc(explode(',',$arra[$i][$headers_helper["product_screenshot"]]));
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
                                            if($value!=""){
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
                                            
                                        default:
                                            # code...
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
                                    //     // update the product
                                        $this->userModel->do_action("products",$products["sku"],"sku","update",$products,"");


                                        
                                }
                                // product does not exist
                                else {
                                   if($ru == 11){
                                    
                                        //     // stringify the array elements of the products array
                                            if(strlen($products["name"]) > 28)
                                            $product_id=url_title(substr($products['name'], 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);

                                            else 
                                            $product_id=url_title($products["name"], '-', TRUE) . '-' . time() . '' . rand(0, 9999);


                                            $p_image=array();
                                            $p_screenshot=array();

                                            if(array_key_exists("product_image",$products))
                                            {
                                                $p_image=$products["product_image"];
                                                unset($products["product_image"]);
                                            }


                                            if(array_key_exists("product_screenshot",$products))
                                            {
                                                $p_screenshot=$products["product_screenshot"];
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
                                                
                                                    foreach($p_image as $value){
                                                        $b=$this->userModel->do_action("product_image","","","insert",array("product"=>$product_id[0]->product_id,"image"=>$value),"");
                                                    }

                                                
                                                }
                                            
                                                if(sizeof($p_screenshot) > 0){
                                                    $bb=true;
                                                
                                                    foreach($p_screenshot as $value){
                                                        $bb=$this->userModel->do_action("product_screenshot","","","insert",array("product"=>$product_id[0]->product_id,"image"=>$value),"");
                                                    }

                                                
                                                }
                                            // }
                                   }
                                }
                            }

                            
                            
                        }


                        var_dump($products);
                        // var_dump($headers_helper);
                        // var_dump($arra);
                        die();

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

    public function bulkUpload_okd() {
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

                        // construct Two-dimensional array of the data contained in the CSV file
                        while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                            $num = count($data);
                            $row++;
                            if ($row > 2) {
                                for ($c = 0;$c < $num;$c++) {
                                    if ($c % 28 == 0) {
                                        $j++;
                                    }
                                    $arra[$j][] = $data[$c];
                                }
                            }
                        }

                        // var_dump($arra);

                        // Close the CSV file
                        fclose($handle);

                        // loop on the two-dimensional data array 
                        foreach ($arra as $k => $v) {
                            $insertData = array();
                            $catID1 = array();
                            $catID2 = array();
                            $catID3 = array();
                            if ($v[0]) {
                                $cateArray = explode(",", $v[0]);
                            } else {
                                $cateArray = array();
                            }
                            if ($v[1]) {
                                $cateArray2 = explode(",", $v[1]);
                            } else {
                                $cateArray2 = array();
                            }
                            if ($v[2]) {
                                $cateArray3 = explode(",", $v[2]);
                            } else {
                                $cateArray3 = array();
                            }
                            // ##########Category CHecking Start##########
                            if ($cat = $v[0]) {
                                //   $cateArray=explode(",",$v[0]);
                                $v_j=0;

                                foreach ($cateArray as $ck => $cv) {
                                    $stcat = strtolower($cv);
                                    $sql = "select * from master_category where  LOWER(category_name)='$stcat' AND parent_id='0' ";
                                    $master_category = $this->userModel->customQuery($sql);

                                    // if catgory exist
                                    if ($master_category) {
                                        $pcat = $master_category[0]->category_id;
                                        $catID1[$ck] = $master_category[0]->category_id;

                                        if ($cateArray2[$ck]) {
                                        } 

                                        else {
                                            if (!@$insertData['category']) {
                                                @$insertData['category']=$master_category[0]->category_id;
                                                
                                            } 
                                            else {

                                                @$insertData['category'] = @$insertData['category'] . ',' . $master_category[0]->category_id;
                                            }
                                        }
                                    } 

                                    else {
                                        $p['category_name'] = $cv;
                                        $p['category_id'] = url_title($p['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                        $res = $this->userModel->do_action('master_category', '', '', 'insert', $p, '');
                                        $pcat = $p['category_id'];
                                        $catID1[$ck] = $p['category_id'];

                                        if ($cateArray2[$ck]) {
                                        } 
                                        
                                        else {
                                            if (!@$insertData['category']) {
                                                @$insertData['category']= $p['category_id'];
                                                
                                            } else {
                                                @$insertData['category'] = @$insertData['category'] . ',' . $p['category_id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########Category checking END ###########
                            // ##############################################


                            // ##########Sub Category CHecking Start##########
                            if ($scat = $v[1]) {
                                //   $cateArray2=explode(",",$v[1]);
                                foreach ($cateArray2 as $ck2 => $cv2) {
                                    $temppcat2 = $catID1[$ck2];
                                    $scatv = strtolower($cv2);
                                    $sql = "select * from master_category where  LOWER(category_name)='$scatv' AND parent_id='$temppcat2'  ";
                                    $master_category = $this->userModel->customQuery($sql);


                                    if ($master_category) {
                                        //   @$insertData['category']=$master_category[0]->category_id;
                                        $subCatSub = $master_category[0]->category_id;
                                        $catID2[$ck2] = $master_category[0]->category_id;

                                        if ($cateArray3[$ck2]) {
                                        } 
                                        
                                        else {
                                            if (!@$insertData['category']) {
                                                @$insertData['category']=$master_category[0]->category_id;
                                                
                                            } else {
                                                @$insertData['category'] = @$insertData['category'] . ',' . $master_category[0]->category_id;
                                            }
                                        }
                                    } 
                                    
                                    else {
                                        $ps['parent_id'] = $temppcat2;
                                        $ps['category_name'] = $cv2;
                                        $ps['category_id'] = url_title($ps['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                        $subCatSub = $ps['category_id'];
                                        $res = $this->userModel->do_action('master_category', '', '', 'insert', $ps, '');
                                        //   @$insertData['category']=$ps['category_id'];
                                        $catID2[$ck2] = $ps['category_id'];

                                        if ($cateArray3[$ck2]) {
                                        } 
                                        
                                        else {
                                            if (!@$insertData['category']) {
                                                @$insertData['category']= $ps['category_id'];
                                                
                                            } else {
                                                @$insertData['category'] = @$insertData['category'] . ',' . $ps['category_id'];
                                            }
                                        }
                                    }
                                }
                            }
                            // ###########Sub Category checking END ###########
                            // ##############################################
                            //  // ##############################################


                            // ##########Sub Category SUB CHecking Start##########
                            if ($scat = $v[2]) {
                                // $cateArray3=explode(",",$v[2]);

                                foreach ($cateArray3 as $ck3 => $cv3) {
                                    $temppcat3 = $catID2[$ck3];
                                    $scatv = strtolower($cv3);
                                    $sql = "select * from master_category where  LOWER(category_name)='$scatv' AND parent_id='$temppcat3'  ";
                                    $master_category = $this->userModel->customQuery($sql);
                                    if ($master_category) {
                                        $subCatSub = $master_category[0]->category_id;
                                        $catID3[$ck3] = $master_category[0]->category_id;
                                        if (!@$insertData['category']) {
                                            @$insertData['category']=$master_category[0]->category_id;
                                            
                                        } 
                                        
                                        else {
                                            @$insertData['category'] = @$insertData['category'] . ',' . $master_category[0]->category_id;
                                        }
                                    } 
                                    
                                    else {
                                        $ps['parent_id'] = $temppcat3;
                                        $ps['category_name'] = $cv3;
                                        $ps['category_id'] = url_title($ps['category_name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                        $subCatSub = $ps['category_id'];
                                        $res = $this->userModel->do_action('master_category', '', '', 'insert', $ps, '');
                                        //   @$insertData['category']=$ps['category_id'];
                                        $catID3[$ck3] = $ps['category_id'];
                                        if (!@$insertData['category']) {
                                            @$insertData['category']= $ps['category_id'];
                                            
                                        } else {
                                            @$insertData['category'] = @$insertData['category'] . ',' . $ps['category_id'];
                                        }
                                    }
                                }
                            }
                            // ###########Sub Category SUB checking END ###########
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
                                            } 
                                            
                                            else {
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
                            if (@$scrren = $v[21]) {
                                $sreenshotv = explode(",", $scrren);
                                if ($sreenshotv) {
                                } else {
                                    $sreenshotv[] = $scrren;
                                }
                            }
                            /* ##screenshot checking END ###########
                             ######################################*/
                            if (@$insertData['freebie'] = $v[22]) {
                            }
                            if (@$insertData['evergreen'] = $v[23]) {
                            }
                            if (@$insertData['exclusive'] = $v[24]) {
                            }
                            if (@$insertData['pre_order_enabled'] = $v[25]) {
                            }
                            if (@$insertData['pre_order_before_payment_percentage'] = $v[26]) {
                            }
                            if (@$insertData['pre_order_enabled'] == 'Yes' || @$insertData['pre_order_enabled'] == 'yes') {
                                if ($insertData['release_date'] = $v[27]) {
                                    if ($v[27] != "") {
                                        $insertData['release_date'] = date("Y-m-d", strtotime($insertData['release_date']));
                                    }
                                }
                            }
                            // var_dump($insertData);
                            // die();

                            // ##############Action Start############
                            if ($insertData) {
                                if (strlen($insertData['name']) > 28) {
                                    $insertData['product_id'] = url_title(substr($insertData['name'], 0, 28), '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                } else {
                                    if ($insertData['name']) $insertData['product_id'] = url_title($insertData['name'], '-', TRUE) . '-' . time() . '' . rand(0, 9999);
                                }
                                if ($sku2 = $v[17]) {
                                    /* echo  $this->userModel->getLastQuery();
                                     exit;*/
                                    $sql = "select * from products where  sku='$sku2' ";
                                    $prExisit = $this->userModel->customQuery($sql);
                                    if ($prExisit) {
                                        if ($insertData['name']) 
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
        } // POST END
        echo $this->header();
        echo view('/Supercontrol/bulkUpload');
        echo $this->footer();
    }
    public function test() {
        echo rand(0, 999);
    }
    public function upload() {
        $input = $this->validate(['file' => ['uploaded[file]', 'mime_in[file,image/jpg,image/jpeg,image/png]', ]]);
        if (!$input) {
        } else {
            if ($this->request->getFile('file')) {
                $img = $this->request->getFile('file');
                $img->move(ROOTPATH . '/assets/uploads/');
                //  $p['category_image']=$img->getName();
                return true;
            }
        }
    }
    public function uploadImage() {
        echo $this->header();
        echo view('/Supercontrol/uploadImage');
        echo $this->footer();
    }
    public function links() {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('products');
        $crud->setSubject('Product', 'Product');
        $crud->columns(['sku', 'product_id']);
        $crud->callbackColumn('product_id', function ($value, $row) {
            return "<a target='_blank' href='" . base_url() . "/product/" . $row->product_id . "' >" . base_url() . '/product/' . $row->product_id . "</a>";
        });
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
        if ($addFlag == 0) {
        }
        if ($editFlag == 0) {
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit;
        }
        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return '/supercontrol/Products/edit/' . $row->product_id;
        }, false);
        // Checking Access user END##############
        // Access END
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
    public function delete() { //   Access Start
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
        if ($addFlag == 0) {
            $crud->unsetAdd();
        }
        if ($editFlag == 0) {
            $crud->unsetEdit();
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
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
        } 
        else {
            return redirect()->to(base_url() . '/supercontrol/Login');
        }
        if ($addFlag == 0) {
            $crud->unsetAdd();
        }
        if ($editFlag == 0) {
            $crud->unsetEdit();
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit;
        }
        // Checking Access user END ##############
        // Access END
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = ["name" => ["label" => "Name", "rules" => "required"], "status" => ["label" => "status", "rules" => "required"]];
            if ($this->validate($rules)) {
                $p = $this->request->getVar();
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
                            foreach ($this->request->getFileMultiple('file') as $file) {
                                $file->move(ROOTPATH . '/assets/uploads/');
                                $pi['image'] = $file->getName();
                                $pi['product'] = $p['product_id'];
                                $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                            }
                        }
                    }
                }

                if ($_FILES['file2']['name'][0]) {
                    if ($this->request->getFileMultiple('file2')) {
                        foreach ($this->request->getFileMultiple('file2') as $file) {
                            $file->move(ROOTPATH . '/assets/uploads/');
                            $pi2['image'] = $file->getName();
                            $pi2['product'] = $p['product_id'];
                            $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi2, '');
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
                        $opt=  $this->request->getVar('bundle_opt');

                        if(sizeof($opt) < 2 )
                        $data["validation"]="Please select at least 2 options";  

                        else{
                            $this->userModel->do_action('bundle_opt', $p["product_id"], 'product_id', 'delete', '', '');

                            $opt_array=array();
                            foreach ($opt as $key => $value) {
                                # code...
                                $opt_array["product_id"]=$p['product_id'];
                                $opt_array["opt_product_id"]= $value;                                
                                $ins_opt=$this->userModel->do_action('bundle_opt', '', '', 'insert', $opt_array, '');
                            }
                            $p["bundle_opt_enabled"]="Yes";
                            unset($p["bundle_opt"]);
                        }                
                    }
                    else{
                        $p["bundle_opt_enabled"]="Yes";
                        $this->userModel->do_action('bundle_opt', $p["product_id"], 'product_id', 'delete', '', '');
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

                unset($p['product_id']);
                unset($p['related_products']);
                $p['category'] = implode(",", $this->request->getVar('category'));

                // var_dump($p);die();

                if(false)
                $res = $this->userModel->do_action('products', $this->request->getVar('product_id'), 'product_id', 'update', $p, '');
                // else{

                // }
                $this->session->setFlashdata('success', 'Product updated successfully!');
                return redirect()->to(site_url('supercontrol/Products'));
            } 
            else {
                $data["validation"] = $validation->getErrors();
            }
        }
        echo $this->header();
        echo view('/Supercontrol/AddProducts');
        echo $this->footer();
    }
    public function add() {
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
        } 
        else {
            return redirect()->to(base_url() . '/supercontrol/Login');
        }


        if ($addFlag == 0) {
            $crud->unsetAdd();
        }
        if ($editFlag == 0) {
            $crud->unsetEdit();
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit;
        }


        // Checking Access user END##############
        // Access END
        $data = [];
        helper(['form', 'url']);
        if ($this->request->getMethod() == "post") {
            // var_dump($this->request->getVar());die();
            $validation = \Config\Services::validation();
            $rules = ["name" => ["label" => "Name", "rules" => "required"], "status" => ["label" => "status", "rules" => "required"]];
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
                        $data["validation"] = "Product not added.SKU already exists for another product!";
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
                            foreach ($this->request->getFileMultiple('file') as $file) {
                                $file->move(ROOTPATH . '/assets/uploads/');
                                $pi['image'] = $file->getName();
                                $pi['product'] = $p['product_id'];
                                $resIMG = $this->userModel->do_action('product_image', '', '', 'insert', $pi, '');
                            }
                        }
                    }
                }

                if ($_FILES['file2']['name'][0]) {
                    if ($this->request->getFileMultiple('file2')) {
                        foreach ($this->request->getFileMultiple('file2') as $file) {
                            $file->move(ROOTPATH . '/assets/uploads/');
                            $pi2['image'] = $file->getName();
                            $pi2['product'] = $p['product_id'];
                            $resIMG = $this->userModel->do_action('product_screenshot', '', '', 'insert', $pi2, '');
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
                        $opt=  $this->request->getVar('bundle_opt');

                        if(sizeof($opt) < 2 )
                        $data["validation"]="Please select at least 2 options";  

                        else{
                            $this->userModel->do_action('bundle_opt', $p["product_id"], 'product_id', 'delete', '', '');

                            $opt_array=array();
                            foreach ($opt as $key => $value) {
                                # code...
                                $opt_array["product_id"]=$p['product_id'];
                                $opt_array["opt_product_id"]= $value;                                
                                $ins_opt=$this->userModel->do_action('bundle_opt', '', '', 'insert', $opt_array, '');
                            }
                            $p["bundle_opt_enabled"]="Yes";
                            unset($p["bundle_opt"]);
                        }                
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

                $p['category'] = implode(",", $this->request->getVar('category'));
                unset($p['related_products']);
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
                $data["validation"] = $validation->getErrors();
            }
            exit;
        }
        echo $this->header();
        echo view('/Supercontrol/AddProducts');
        echo $this->footer();
    }
    public function index() {
        // die();
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('products');
        $crud->setSubject('Product', 'Product');
        // $crud->columns(['category', 'name', 'images', 'price', 'sku', 'status']);
        $crud->columns(['category', 'name', 'images', 'price', 'sku', 'status' , 'precedence' , 'available_stock' , 'created_at']);

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
        if ($addFlag == 0) {
        }
        if ($editFlag == 0) {
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit;
        }
        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return '/supercontrol/Products/edit/' . $row->product_id;
        }, false);
        // Checking Access user END##############
        // Access END
        /*$crud->addFields(['access_modules_id', 'section_name','segment_1','segment_2','segment_3']);
        //   $crud->requiredFields(['access_modules_id', 'section_name','segment_1']);
        $crud->unsetFields(['created_at','updated_at']);
        $crud->uniqueFields(['access_modules_id']);
        $crud->columns(['section_name','segment_1','segment_2','segment_3','groups_assigned']);
        $crud->fieldType('access_modules_id','hidden');
        $crud->requiredFields(['section_name','segment_1']);
        $crud->callbackBeforeInsert(function ($stateParameters) {
        $stateParameters->data['access_modules_id'] =  ucwords($stateParameters->data['segment_3']).''.   str_replace(' ', '', ucwords($stateParameters->data['section_name']));
        return $stateParameters;
        });
        $crud->setRelationNtoN('groups_assigned', 'groups_assigned', 'admin_group', 'access_modules_id', 'group_id', 'name');*/
        /*$crud->setRelation('color', 'color', 'title');
        $crud->setRelation('brand', 'brand', 'title');
        $crud->setRelation('age', 'age', 'title');
        $crud->setRelation('suitable_for', 'suitable_for', 'title');*/
        // $crud->setRelation('category', 'master_category', 'category_name');
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
        // do_action($table_name,$id,$fieldname,$action,$data,$limit);
        // echo($this->request->getVar('product_id')."  ".$this->request->getVar('stock_qty'));
        $msg=array();
        if(is_int((int)$this->request->getVar('stock_qty'))){
            if(!$this->userModel->do_action('products', $this->request->getVar('product_id'),'product_id', 'update', array("available_stock"=>$this->request->getVar('stock_qty')),''))
            $msg[0]="Something went wrong";
        }
        else{
            $msg[0]="Please enter a valid quantity";
        }

        if($this->request->getVar("precedence")){
            if(is_int((int)$this->request->getVar('precedence'))){
                if(!$this->userModel->do_action('products', $this->request->getVar('product_id'),'product_id', 'update', array("precedence"=>$this->request->getVar('precedence')),''))
                $msg[0]="Something went wrong";
            }
            else{
                $msg[0]="Please enter a valid number";
            }
        }

        echo(json_encode($msg));
        
        // echo($this->userModel->do_action('products', 'ps4-ryans-rescue-squad-pegi-16470009693885','product_id', 'update', array("available_stock"=>"88"),''));

        
    }
}
