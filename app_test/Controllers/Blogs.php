<?php
namespace App\Controllers;
class Blogs extends BaseController
{


    public function index($cat=null)
    {
        echo view("Common/blog/Header");
        $data["cats"] = $this->blogModel->get_blog_categories();
        
        if($cat && trim($cat) !== ""){
            $data["blogs"] = $this->blogModel->get_blogs(null , $cat);
            $data["cat_slug"] = $cat;

        }
        else
        $data["blogs"] = ($this->request->getMethod() == "get" && trim($this->request->getVar("category")) != "") ? $this->blogModel->get_blogs($this->request->getVar("category")) : $this->blogModel->get_blogs();

        $data["flashData"] = $this->session->getFlashdata();

        echo view("blogs/Blogpage", $data);
        echo view("Common/Footer");

    }

    public function blogDetail($slug){
        echo view("Common/blog/Header");
        $blog = $this->blogModel->get_blog(null , $slug);
        $data["blog"] = ($blog) ? $blog : $this->blogModel->get_blog($slug , null);
        $data["cats"] = $this->blogModel->get_blog_categories();
        $data["b_category"] = $blog[0]->category;
        $data["related_blogs"] = $this->blogModel->get_related_blogs($blog[0]->blog_id , $blog[0]->category);

        $data["flashData"] = $this->session->getFlashdata();
        echo view("blogs/Blogpage", $data);
        echo view("Common/Footer");
    }
    

}