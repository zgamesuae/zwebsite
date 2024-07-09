<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Nintendo_switch extends \App\Controllers\BaseController{


    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category', false);

        $banners=$categoryModel->get_category_page_banners("nintendo-switch-1634548899");
        $data=array(
            "category_banners" => $banners
        );

        // HEADSETS SECTION
        $headsets_filter = [
            "master_category" => "nintendo-switch-1634548899",
            "type" => ["26"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($headsets_filter))
		$data["headsets"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_94")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&type=26");
        
        
        // CONTROLLERS SECTION
        $controllers_filter = [
            "categoryList" => ["nintendo-switch-1634548899" , "controllers-1641137726"],
            "type" => ["27"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($controllers_filter))
		$data["controllers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_95")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&type=27");
        
        // ADVENTURE GAMES SECTION
        $adventure_games_filter = [
            "categoryList" => ["nintendo-switch-1634548899" , "tiles-1634549085"],
            "type" => ["5"],
            "color" => ["5"],
            // "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($adventure_games_filter))
		$data["adventure_games"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_96")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&type=5&genre=5");

        // PREORDERS SECTION
        $preorders_filter = [
            "master_category" => "nintendo-switch-1634548899",
            "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($preorders_filter))
		$data["preorders"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_22")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&pre-order=enabled");

        // NEW RELEASES SECTION
        $new_releases_filter = [
            "master_category" => "nintendo-switch-1634548899",
            "type" => ["5"],
            "new_realesed" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($new_releases_filter))
		$data["new_realeses"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_36")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&type=5&new_realesed=Yes");

        // OFFERS SECTION
        $offers_filter = [
            "master_category" => "nintendo-switch-1634548899",
            "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($offers_filter))
		$data["offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_26")),"link"=> base_url()."/product-list?category=nintendo-switch-1634548899&show-offer=yes");


        echo view("Common/Header");
        echo view("Category_sw",$data);
        echo view("Common/Footer");

    }

}


?>