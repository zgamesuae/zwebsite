<?php

namespace App\Controllers;

class Review extends BaseController{

    protected $reviewModel,$userModel,$productModel;


    public function __construct(){
        $this->reviewModel = model("App\Models\ReviewModel");
        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");

    }

    public function add($productid){

        if(sizeof($_POST) > 0 && trim($productid) !== ""){
            $result = $this->reviewModel->add_review($_POST);
            if($result["status"]){
                return redirect()->to($this->productModel->getproduct_url($_POST["product"]));
            }

            else{
                return redirect()->to($this->productModel->getproduct_url($_POST["product"]."?message=".$result["message"]));
            }

        }
        else{
            echo "dfgdfg";
        }   
    }

    
}

?>