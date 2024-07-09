<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class BrandModel extends Model{

    protected $userModel;

    public function __construct(){
        parent::__construct();
        $this->userModel = model("App\Models\UserModel");
    }

    public function _getbrands(){
        

        $req="select * from brand where status='Active'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        return false;
    }

    public function _getbrandname($id , $arabic = false){
        

        $req="select title,arabic_title from brand where id='".$id."'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return ($arabic) ? $res[0]->arabic_title : $res[0]->title;
        }

        return false;
    }

    public function createurl1($id){
        $brand = $this->_getbrandname($id);
        if($brand){
            $url = strtolower(preg_replace("/(\s|@ù!:;,\*\.\$\^)+/" , "-" , trim($brand)));
            return $url;
        }

        else return false;
    }
    public function createurl($slug){
        $brand = $slug;
        if($brand !== ""){
            $url = strtolower(preg_replace("/(\s|@ù!:;,\*\.\$\^)+/" , "-" , trim($brand)));
            return $url;
        }

        else return "";
    }


    public function get_brand_id_from_slug($slug){

        if($slug !== ""){
            $id = $this->userModel->customQuery("select id from brand where slug ='".$slug."'");

        if($id){
            return $id[0]->id;
        }

        }
        return false;
    }

    public function get_slug_from_id($id){
        $slug = $this->userModel->customQuery("select slug from brand where id ='".$id."'");
        if($slug){
            return $slug[0]->slug;
        }

        return false;
    }

    public function getlastmodified($id){
        $date = $this->userModel->customQuery("select updated_at from brands where product_id='".$id."'");
        if($data){
            var_dump($data[0]->updated_at);die();
            return $data[0]->updated_at;
        }
        
        return false;
    }

    public function brand_urls(){
        $urls = array();
        $brands = $this->_getbrands();
        foreach($brands as $brand){
            if(trim($brand->slug) !== "")
            $urls[$brand->id] = 'product-list/'.$brand->slug;
            else
            $urls[$brand->id] = 'product-list?brand='.$brand->id;

        }

        return $urls;
    }
    
    public function get_brand_url($id){
        $slug = $this->get_slug_from_id($id);

        if(trim($slug) !== "")
        return base_url()."/product-list/".$slug;
        else
        return base_url()."/product-list?brand=".$id;
    }
    
    public function search_brand($keyword){
        $res = false;
        if($keyword !== null && trim($keyword) !== ""){

            if(is_arabic_text($keyword))
            $condition = "arabic_title like'%".$keyword."%'"; 
            else
            $condition = "title like'%".$keyword."%'";

            $result = $this->userModel->customQuery("select id from brand where ".$condition." and status = 'Active'");
            if($result !== null && $result)
            $res = $result;
        }

        return $res;
    }

    public function get_brand_from_slug($slug){
        if($slug !== ""){
            $res = $this->userModel->customQuery("select * from brand where slug ='".$slug."'");

            if($res && sizeof($res) > 0){
                return $res[0];
            }

        }
        return false;
    }
}