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

        
    public $userModel;
    
    public function __construct(){

        $this->userModel=model('App\Models\UserModel');

    }

    public function _subcat($c_id){

        $userModel = model('App\Models\UserModel', false);
        $cats=array();

        $sql_sub_cat="select category_id from master_category where parent_id='".$c_id."'";
        $main_sub_cats=$userModel->customQuery($sql_sub_cat);
        // return $main_sub_cats;

        if($main_sub_cats)
        foreach($main_sub_cats as $k=>$v){
            array_push($cats,$v->category_id);
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
    public function category_exist_by_id($cat_id,$parent_id):boolean{

        $count=$userModel->customQuery("select count(category_name) as c from master_category where category_id='".$cat_id."' and parent_id='".$parent_id."'");
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
        $userModel = model('App\Models\UserModel', false);

        $sql="";



        // process start
        if ($master_category !== null) {
            $sql.=" (FIND_IN_SET('".$master_category."',products.category) ";
            $sub_categories=$this->_subcat($master_category);


            if(sizeof($sub_categories) > 0){

                $sql.=" OR ";
                foreach ($sub_categories as $key => $value) {

                    # code...
                    if($key < sizeof($sub_categories)-1)
                    $sql.=" FIND_IN_SET('$value', products.category)  OR ";

                    else
                    $sql.=" FIND_IN_SET('$value', products.category) ";

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
        
                        }
    
                        
                    }
    
                }

            }

            $sql.=" ) ";

        }

        return $sql;
    }

}