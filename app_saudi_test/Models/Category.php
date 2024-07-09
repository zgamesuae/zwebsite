<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class Category extends Model
{

    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->db = \Config\Database::connect();
    //     // OR $this->db = db_connect();
    // }
    
    public $current_d;
    public $userModel;
    public $slugs;
    public $categories;

    public function __construct($v = true){

        $this->userModel=model('App\Models\UserModel');
        $this->current_d = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d h:i:s");
        // $this->slugs = $this->categories_slugs();
        $this->categories = $this->_getcategories(false);
        // $this->categories = ($v) ? $this->_getcategories(false) : [];
    }

    public function _subcat($c_id , $show_inmenu = false , $active = false){

        
        $cats=array();

        // $sql_sub_cat="select category_id from master_category where parent_id='".$c_id."'";
        // $main_sub_cats=$this->userModel->customQuery($sql_sub_cat);
        // if($show_inmenu)
        // $sql_sub_cat .= " AND show_in_menu = 'Yes'";
        // if($active)
        // $sql_sub_cat .= " AND status ='Active'";
        // // return $main_sub_cats;

        // if($main_sub_cats)
        $main_sub_cats = array_filter($this->categories , function($category) use(&$show_inmenu , &$active , &$c_id){
            $b = $category["parent_id"] == $c_id;

            if($show_inmenu)
            $b = $b && $category["show_in_menu"] == "Yes";

            if($active)
            $b = $b && $category["status"] == "Active";

            return $b;
            });

        foreach($main_sub_cats as $k=>$v){
            array_push($cats,$k);
        }

        return $cats;

        // var_dump($cats);
    }
    // check if a category exist by it's name
    public function category_exist_by_name($cat_name,$parent_id){

        $count=$this->userModel->customQuery("select count(category_name) as c from master_category where category_name='".$cat_name."' and parent_id='".$parent_id."'");
        // echo("select count(category_name) as c from master_category where category_name='".$cat_name."' and parent_id='".$parent_id."'");
        
        if($count[0]->c > 0) 
        return true;
        
        else 
        return false;
    }

    // check if a category exist by it's id
    public function category_exist_by_id($cat_id,$parent_id):bool{

        $count=$this->userModel->customQuery("select count(category_name) as c from master_category where category_id='".$cat_id."' and parent_id='".$parent_id."'");
        if($count[0]->c > 0) 
        return true;
        
        else 
        return false;
    }

    public function create_category($array){

        $category_id = $this->userModel->do_action('master_category', '', '', 'insert', $array, '');

        return $category_id;

    }

    public function delete_category($id){
        $category_id = $this->userModel->do_action('master_category', $id, 'category_id', 'delete', '', '');
        if($category_id)
        return true;
        else return false;
    }

    public function get_category_id($n,$parent_id){
        $id = $this->userModel->customQuery("select category_id from master_category where category_name='".$n."' and parent_id='".$parent_id."'");
        
        return $id[0]->category_id;
    }


    public function subcat_query($master_category):string{

        $sql="";
        $i = 0;


        // process start
        if ($master_category !== null) {
            $sql.=" FIND_IN_SET('".$master_category."',products.category) ";
            $sub_categories=$this->_subcat($master_category);


            if(sizeof($sub_categories) > 0){

                $sql.=" OR ";
                foreach ($sub_categories as $key => $value) {

                    # code...
                    if($key < sizeof($sub_categories)-1)
                    $sql.=" FIND_IN_SET('$value', products.category)  OR ";

                    else
                    $sql.=" FIND_IN_SET('$value', products.category) ";
                    $i++;
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
                            $i++;
                        }
    
                        
                    }
    
                }

            }


            // $sql.=" ) ";
            if($i >= 1)
            $sql = "(".$sql.")";

        }

        return $sql;
    }

    public function _getcategories($show_inmenu=false){
        
        $cats=array();
        // $req="select category_id from master_category where status='Active' and parent_id='0'";
        $req="select * from master_category where status='Active'";
        if($show_inmenu)
        $req .= " AND show_in_menu='Yes'";
        $req .=" order by category_name ASC";



        $res = $this->userModel->customQuery($req);
        if($res){
            array_walk($res , function($category , $key)use(&$cats){
                // is level 1
                $cats [$category->category_id] = [
                    "category_name" => $category->category_name,
                    "category_name_arabic" => $category->category_name_arabic,
                    "precedence" => $category->precedence,
                    "parent_id" => $category->parent_id,
                    "slug" => $category->slug,
                    "show_category_page" => $category->show_category_page,
                    "show_in_menu" => $category->show_in_menu,
                    "status" => $category->status,
                ];
            });

        }

        if($res && false){
            $i=0;
            foreach($res as $m_cat){
                // $sub_cats=$sub_cats_sub=array();
                // $cats[$i]=array($m_cats->category_id=>array("level2"=>array()));
                array_push($cats,array($m_cat->category_id=>array("level2"=>array())));
                $sub_cat = $this->_subcat($m_cat->category_id , true , true);
                if(sizeof($sub_cat)>0){

                    foreach($sub_cat as $s_cat){
                        // var_dump($cats);
                        // array_push($cats[$i][$m_cat->category_id]["level2"][$s_cat] = array("level3"=>array()));
                        $cats[$i][$m_cat->category_id]["level2"][$s_cat]=array("level3"=>array());
                        $sub_cat_sub = $this->_subcat($s_cat , true , true);
                        if(sizeof($sub_cat_sub)>0){

                            foreach($sub_cat_sub as $s_cat_s){
                                array_push($cats[$i][$m_cat->category_id]["level2"][$s_cat]["level3"],$s_cat_s);
                            }
                        }
                    }
                }
                $i++;
            }
        }
        return $cats;
    }


    public function _getcatname($cat_id , $arabic = false){
        
        $req="select category_name,category_name_arabic from master_category where category_id='".$cat_id."'";
        $res=$this->userModel->customQuery($req);

        if($res){
            return ($arabic) ? $res[0]->category_name_arabic : $res[0]->category_name;
        }
        else return false;
    }

    public function _getcatnames(Array $category){
        $string = "";

        if($category[0] == 0 || trim($category[0]) == "")
        unset($category[0]);

        $cats = array_map(array($this, '_getcatname') , $category);

        $string = implode("/" , $cats);

        return $string;
    }

    public function is_mastercat($catid){
        
        $req="select parent_id from master_category where category_id='".$catid."'";
        $res=$this->userModel->customQuery($req);
        if($res){
            if($res[0]->parent_id == '0')
            return true;
        }

        return false;
    }

    public function get_parent_category($catid){
        
        $req="select parent_id from master_category where category_id='".$catid."'";
        $res=$this->userModel->customQuery($req);
        if($res){
            return $res[0]->parent_id;
        }

        return false;
    }

    public function get_master_parent_cat($catid){
        
        $is_master=$this->is_mastercat($catid);

        if(!$is_master){
            $catid=$this->get_parent_category($catid);
            $is_master=$this->is_mastercat($catid);

            if(!$is_master){
                $catid=$this->get_parent_category($catid);
                $is_master=$this->is_mastercat($catid);

                if($is_master){
                    return $catid;
                }

                else return false;
            }

            else
            return $catid;
        }

        else return $catid;


    }

    public function createurl($slug){
        if($slug !== ""){
            $url = strtolower(preg_replace("/(\s|@ù!:;,\*\.\$\^)+/" , "-" , trim($slug)));
            return $url;
        }

        else return "";
    }
    
    public function get_cat_from_slug($slug){
        if(trim($slug) !== ""){
            $cat = $this->userModel->customQuery("select * from master_category where slug='".$slug."'");
            if($cat){
                return $cat[0];
            }
        }

        return false;
    }

    public function get_slug_from_id($id){
        $slug = $this->userModel->customQuery("select slug from master_category where category_id='$id'");
        if($slug)
        return $slug[0]->slug;
        else
        return false;
    }

    public function categories_slugs(){
        $slugs = [];

        $req = "select category_id,slug from master_category where status='Active'";
        $res = $this->userModel->customquery($req);

        if(!is_null($res) && sizeof($res) > 0){
            array_walk($res , function($value , $key)use(&$slugs){

                if(!is_null($value->slug) && trim($value->slug) !== "")
                $slugs[$value->category_id] = $value->slug;

            });
        }
        
        return $slugs;
    }
    
    public function categories_urls($cats = null){
        $cats = (is_null($cats)) ? $this->categories : $cats;
        // var_dump($cats);die();
        $urls=array();

        $has_slug = function($slug){
            if(!is_null($slug) && !empty($slug))
            return true;
            
            return false;
        };

        $pattern = '/[|]+/';

        if(sizeof($cats)>0){

            $level1 = array_filter($cats , function($category){ return $category["parent_id"] == "0"; });
            $level2 = [];
            array_walk($level1 , function($p1 , $id1) use(&$level2 , &$cats) {
                $level2 = array_merge($level2 , array_filter($cats , function($category)use(&$id1){ return $category["parent_id"] == $id1; }));
            });
            $level3 = [];
            array_walk($level2 , function($p2 , $id2) use(&$level3 , &$cats) {
                $level3 = array_merge($level3 , array_filter($cats , function($category)use(&$id2){ return $category["parent_id"] == $id2; }));
            });

            foreach($cats as $category_id => $category){

                // is level 1
                if(array_key_exists($category_id , $level1))
                $urls [$category_id] = ($has_slug($category["slug"])) ? $category["slug"] : "product-list?category=$category_id";

                // is level2
                elseif(array_key_exists($category_id , $level2)){
                    $urls [$category_id] = ($has_slug($category["slug"]) && $has_slug($level1[$category["parent_id"]]["slug"])) ? $level1[$category["parent_id"]]["slug"]."/".$category["slug"] : "product-list?category=$category_id";
                }

                // is level3
                elseif(array_key_exists($category_id , $level3)){
                    $urls [$category_id] = ($has_slug($category["slug"]) && $has_slug($level2[$category["parent_id"]]["slug"]) && $has_slug($level1[$level2[$category["parent_id"]]["parent_id"]]["slug"])) 
                    ? $level1[$level2[$category["parent_id"]]["parent_id"]]["slug"]."/".$level2[$category["parent_id"]]["slug"]."/".$category["slug"] 
                    : "product-list?category=$category_id";
                }

            }
        }
        return $urls;
    }

    public function getlastmodified($id){
        $date = $this->userModel->customQuery("select updated_at from master_category where category_id='".$id."'");
        if($date){
            return $date[0]->updated_at;
        }

        return false;
    }
    
    public function cat_hierarchy($id , $flag){
        $h = $this->_getcatname($id);
        $parent = $this->get_parent_category($id);
        $tab = array($id);
        while($parent !== 0 || $parent !== "0"){
            if($this->_getcatname($parent)){
                $h = $this->_getcatname($parent)."/".$h;

                // to return structured data of the category hierarchy
                if($flag){
                    array_push($tab , $parent);
                }

                $id = $parent;
                $parent = $this->get_parent_category($id);
            }
            else
            break;
        }

        if($flag)
        return $tab;

        else
        return $h;
    }

    public function search_product($keyword){
        $res = false;
        if($keyword !== null && trim($keyword) !== ""){

            if(is_arabic_text($keyword))
            $condition = "category_name_arabic like'%".$keyword."%'";
            else
            $condition = "category_name like'%".$keyword."%'";

            $req = "select category_id from master_category where ".$condition." and status = 'Active' and parent_id IS NOT NULL";
            $result = $this->userModel->customQuery($req);
            if($result !== null && $result)
            $res = $result;
        }

        return $res;
    }
    
    public function get_parent_categories($offset , $limit){

        $c = $this->categories;
        $f = function ($a , $b){
            return $a["precedence"] <=> $b["precedence"];
        };
        $parents = array_filter($c , function($category){ return $category["parent_id"] == "0"; });
        $parents = array_slice($parents , $offset , $limit);
        uasort($parents , $f);

        return $parents;

        
        $req="select 
        category_id,category_name,category_name_arabic 
        from master_category 
        where parent_id='0'
        and status='Active' 
        and show_in_menu = 'Yes' 
        order by precedence LIMIT ".$offset.",".$limit;
        $res=$this->userModel->customQuery($req);
        if($res){
            return $res;
        }

        return [];
    }

    public function get_category_hierarchy($id , $categories){

        foreach ($categories as $key => $value) {
            # code...
            // var_dump(in_array($id , $value));
            if(array_key_exists($id , $value))
            return $value[$id];
        }

        return [];
    }

    public function get_category($id){
        
        $req = "select * from master_category where category_id = '".$id."'";
        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res[0];

        return false;
    }

    public function menu_category_url($category_id , $categories_urls , $show_category_page){
        if(is_null($categories_urls))
        $categories_urls = $this->categories_urls();
        // $category = $this->get_category($category_id);
        return base_url()."/".$categories_urls[$category_id];
        $slug = $this->get_slug_from_id($category_id);

        // if($show_category_page == "Yes")
        // $category_url = (array_key_exists($category_id , $categories_urls)) ? base_url().'/'.$categories_urls[$category_id] : base_url().'/cat/'.$cat_pages[$category_id];
        // else
        // $category_url = (array_key_exists($category_id , $categories_urls)) ? base_url().'/'.$categories_urls[$category_id] : base_url()."/product-list?category=".$category_id;
        if($slug)
        $category_url = base_url()."/".$categories_urls[$category_id];
        else
        $category_url = base_url()."/product-list?category=".$category_id;
        return 
        $category_url;
    }

    public function get_category_menu_banners($id , $location){
        
        $current_date = (new \DateTime("now" , new \DateTimeZone(TIME_ZONE)))->format("Y-m-d H:i:s");
        $req = "
            select * from category_banner 
            where category_id='".$id."' 
            AND location='".$location."' 
            AND status='Active' 
            AND (
                ( TIMESTAMP('".$current_date."') > start_date AND TIMESTAMP('".$current_date."') < end_date ) 
                OR ( TIMESTAMP('".$current_date."') > start_date AND end_date = '0000-00-00 00:00:00' )
                OR ( TIMESTAMP('".$current_date."') > start_date AND end_date is NULL )
                OR ( start_date = '0000-00-00 00:00:00' AND end_date = '0000-00-00 00:00:00' )
                OR ( start_date is NULL AND end_date is NULL )
            ) 
            order by precedence asc
        ";
        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;

        return [];
    }

    public function get_category_brands($id){
        
        $subcat_query = $this->subcat_query($id);
        // echo $subcat_query; die();
        $req="
        select brand.*,count(brand.id) as occurence 
        from products inner join brand on products.brand = brand.id 
        where ".$subcat_query." 
        and products.status = 'Active' 
        and products.product_nature<>'Variation' 
        and brand.status='Active' 
        and brand.image<>'' 
        group by brand.id 
        order by occurence desc 
        limit 0,8";
        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;

        return [];
    }
    
    public function get_categories_brands($cats){
        
        if(sizeof($cats) > 0){
            $i = 0;
            $subcat_query = "";
            foreach($cats as $k => $category){
                $subcat_query .= $this->subcat_query($k);
                if($i < sizeof($cats)-1)
                $subcat_query .= " OR ";
                $i++;
            }
        }
        $req="
        select brand.*,count(brand.id) as occurence 
        from products inner join brand on products.brand = brand.id 
        where products.status = 'Active' 
        and products.product_nature<>'Variation' 
        and brand.status='Active' 
        and brand.image <> '' 
        and (".$subcat_query.")  
        group by brand.id 
        order by occurence desc 
        limit 0,8";
        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;

        return [];
    }

    function show_category_page($id){
        $show = "No";
        $req = "select show_category_page from master_category where category_id='$id'";
        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0)
        $show = $res[0]->show_category_page;

        return $show;
    }

    public function get_category_page_banners($category_id){
        $req="
        select * from category_banner 
        where status='Active' 
        AND category_id='".$category_id."' 
        AND location='Page' 
        AND 
        (
            ( TIMESTAMP('".$this->current_d."') between start_date and end_date )
            OR
            (
                (end_date='0000-00-00 00:00:00' OR end_date='' OR end_date is null) AND TIMESTAMP('".$this->current_d."') > start_date 
            )
            OR
            (
                (start_date='0000-00-00 00:00:00' OR start_date='' OR start_date is null) AND TIMESTAMP('".$this->current_d."') < end_date 

            )
            OR
            (
                (start_date='0000-00-00 00:00:00' OR start_date='' OR start_date is null) AND (end_date='0000-00-00 00:00:00' OR end_date='' OR end_date is null)
            )
        )
        order by precedence asc
        ";

        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res;

        return [];
    }

    public function filter_menu_categories(){

        $this->categories = array_filter($this->categories , function($category){ return $category["show_in_menu"] == "Yes"; });

    }
    
}