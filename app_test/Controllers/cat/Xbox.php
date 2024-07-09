<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Xbox extends \App\Controllers\BaseController{

    
    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category', false);

        $banners=$categoryModel->get_category_page_banners("xbox-1634548911");
        $data=array(
            "category_banners" => $banners
        );


        // HEADSETS BEST SELLERS SECTION
        $headsets_bestsellers_filter = [
            "master_category" => "xbox-1634548911",
            "type" => ["26"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($headsets_bestsellers_filter))
		$data["headsets_best_seller"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_94")),"link"=> base_url()."/product-list?category=xbox-1634548911&type=26");
        
        // BEST IN XB SERIES X SECTION
        $best_series_x_filter = [
            "master_category" => "xbox-series-xs-1634549432",
            // "type" => ["27"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($best_series_x_filter))
		$data["best_series_x"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_98")),"link"=> base_url()."/product-list?category=xbox-series-xs-1634549432");
        
        // CONTROLLERS BEST SELLERS SECTION
        $controllers_best_sellers_filter = [
            "categoryList" => ["xbox-1634548911" , "controllers-1641114146" ],
            "type" => ["27"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($controllers_best_sellers_filter))
		$data["controllers_best_seller"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_95")),"link"=> base_url()."/product-list?category=xbox-1634548911&type=27");
        
        // FIGHTING GAMES SECTION
        $fighting_games_filter = [
            "categoryList" => ["xbox-1634548911" , "tiles-1634549043" , "xbox-one-1634549411" , "xbox-series-xs-1634549432"],
            "type" => ["5"],
            "color" => ["18"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($fighting_games_filter))
		$data["fighting_games"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_99")),"link"=> base_url()."/product-list?category=xbox-1634548911&type=5&genre=18");
        
        // PREORDERS SECTION
        $preorders_filter = [
            "master_category" => "xbox-1634548911",
            "preOrder" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($preorders_filter))
		$data["preorders"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_22")),"link"=> base_url()."/product-list?category=xbox-1634548911&pre-order=enabled");
        
        // NEW RELEASES SECTION
        $new_releases_filter = [
            "master_category" => "xbox-1634548911",
            "type" => ["5"],
            "new_realesed" => ["Yes"],
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($new_releases_filter))
		$data["new_realeses"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_36")),"link"=> base_url()."/product-list?category=xbox-1634548911&type=5&new_realesed=Yes");
        
        // $this->xbx_subcat();
        echo view("Common/Header");
        echo view("Category_xbx",$data);
        echo view("Common/Footer");

    }

}


?>