<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class BlogModel extends Model{

    public $userModel;

    public function __construct(){
        $this->userModel = model("App\Model\UserModel");
    }

    public function get_blog($blog_id=null , $slug){
        
        $req = "select * from blog where status = 'Active' and ";     
        $req .= (is_null($blog_id) ) ? "slug='".$slug."'" : "blog_id='".$blog_id."'";
      
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return false;
    }

    public function get_blogs($category_id=null , $slug=null){
        
        $category_id = (!is_null($slug)) ? $this->get_blog_category_id_from_slug($slug) : $category_id;
        if(!is_null($category_id))
        $req = "select * from blog where status = 'Active' and category=".$category_id;
        else
        $req = "select * from blog where status = 'Active'";
        $req .= " order by created_at desc"; 
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return false;
    }
    
    
    public function get_blogs_url(){
        $urls = [];
        $blogs = $this->get_blogs();

        if(sizeof($blogs) > 0 && !is_null($blogs)){
            foreach ($blogs as $key => $blog) {
                # code...
                // $url = base_url()."/blog/";

                // if($blog->slug !== null && trim($blog->slug) !== "")
                // $url .= $blog->slug;

                // else
                // $url .= $blog->blog_id;
                
                
                $url = ($blog->slug !== null && trim($blog->slug) !== "") ? base_url()."/blogs/".$blog->slug : base_url()."/blog-detail/".$blog->blog_id;

                array_push($urls , $url);
            }
        }

        return $urls;
    }


    public function get_blog_categories(){
        
        $req = "select * from blog_categories order by cat_parent asc";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return false;
    }

    public function get_blog_category_id_from_slug($slug){
        
        $req = "select id from blog_categories where slug='".$slug."'";
        $res = $this->userModel->customQuery($req);
        if($res && sizeof($res) > 0)
        return $res[0]->id;
        
        return false;
    }

    public function blog_category_url($category){
        $url = ($category->slug && !is_null($category->slug) && trim($category->slug) !== "") ? "blogs/category/".$category->slug : "blogs?category=".$category->id;
        return base_url()."/".$url;
    }
    
    public function get_related_blogs($blog_id , $category , $limit=5):Array{
        
        $req = "select * from blog where category=".$category." and blog_id <> '".$blog_id."' order by created_at desc limit ".$limit;
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            return $res;
        }

        return [];
    }

}