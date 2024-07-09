<?php
namespace App\Controllers;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;


class Variations extends \App\Controllers\BaseController {


    // protected $userModel,$productModel,$attributeModel;


    public function __construct(){
        // $this->userModel = model("App\Models\UserModel");
        // $this->productModel = model("App\Models\ProductModel");
        // $this->attributeModel = model("App\Models\AttributeModel");
    }


    public function update_attrbite_sections(){
        // var_dump($_GET);
        // foreach ($_GET["req_attributes"] as $attribute){
            $res = $this->productModel->get_product_options_on_attribute($_GET["attribute"] , $_GET["option"] , $_GET["req_attributes"][0] , $_GET["parent"]);
            if($res){
                foreach($res as $option){
                    $option->option_id = (int)preg_replace("/\"/" , "" , $option->option_id);
                    $option->name = $this->attributeModel->get_option($option->option_id)->name;
                    // $option->stock = $option->available_stock;

                }
            }

            return json_encode($res);
               
        // }

    }

    public function update_variable_price(){
        $data = array("price" => null , "offer_price" => null , "name" => null , "image" => null , "is_preorder" => false );
        if(sizeof($_GET) > 0){
            $product = $this->productModel->get_product_from_variation($_GET["variation"] , $_GET["parent"]);
            if($product && $product !== null ){
                $product_images = $this->userModel->customQuery("select * from product_image where product='".$product->product_id."'");
                $data["price"] = bcdiv($product->price, 1, 2);
                $data["image"] = (sizeof($product_images) > 0 && $product_images !== null) ? view("products/Pdetails_images" , ["products" => [$product] , "product_image" => $product_images]) : null;
                $data["name"] = $product->name;
                if($product->pre_order_enabled == "Yes")
                $data["is_preorder"] = true;
                $discount = $this->productModel->get_discounted_percentage($this->offerModel->offers_list , $product->product_id);
                if($discount["discount_amount"] > 0){
                    $data["offer_price"] = $discount["new_price"];
                }
                
            }

        }
        return json_encode($data);
    }
}