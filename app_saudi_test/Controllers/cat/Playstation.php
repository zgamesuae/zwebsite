<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Playstation extends \App\Controllers\BaseController{


    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category');

        $banners=$categoryModel->get_category_page_banners("playstation-1634548926");
        $data=array(
            "category_banners" => $banners
        );


        // CONTROLLERS SECTION
        $controllers_filter = [
            "master_category" => "playstation-1634548926",
            "type" => ["27"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($controllers_filter))
		$data["controllers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_95")),"link"=> base_url()."/product-list?category=playstation-1634548926&type=27");
        
        
        // HEADSETS SECTION
        $headsets_filter = [
            "master_category" => "playstation-1634548926",
            "type" => ["26"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($headsets_filter))
		$data["headsets"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_94")),"link"=> base_url()."/product-list?category=playstation-1634548926&type=26");
        
        // ACTION SECTION
        $rpg_games_filter = [
            "master_category" => "playstation-1634548926",
            "type" => ["5"],
            "color" => ["246"],
            // "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($rpg_games_filter))
		$data["rpg_games"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_360")),"link"=> base_url()."/product-list?category=playstation-1634548926&genre=4&type=5");

        // PREORDERS SECTION
        $preorders_filter = [
            "master_category" => "playstation-1634548926",
            "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($preorders_filter))
		$data["preorders"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_34")),"link"=> base_url()."/product-list?category=playstation-1634548926&pre-order=enabled");

        // NEW RELEASES SECTION
        $new_releases_filter = [
            "master_category" => "playstation-1634548926",
            "new_realesed" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($new_releases_filter))
		$data["new_realeses"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_36")),"link"=> base_url()."/product-list?category=playstation-1634548926&new_realesed=Yes");

        // OFFERS SECTION
        $offers_filter = [
            "master_category" => "playstation-1634548926",
            "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($offers_filter))
		$data["offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_26")),"link"=> base_url()."/product-list?category=playstation-1634548926&show-offer=yes");

        // PLAYSTATION EXCLUSIVE
        $ps_exclusive_filter = [
            "master_category" => "playstation-exclusive-1699520584",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 24,
        ];
        if($products = $this->productModel->product_filter_query($ps_exclusive_filter))
		$data["ps_exclusive"] = array("list"=>$products["product"],"title"=>strtoupper("Playstation exclusive"),"link"=> base_url()."/playstation-exclusive");

        echo view("Common/Header");
        echo view("Category_ps",$data);
        echo view("Common/Footer");

    }
    
}


?>