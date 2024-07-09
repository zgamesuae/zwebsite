<?php 
namespace App\Controllers\cat;
use App\Controllers\BaseController;
class Digital_codes_and_gift_cards extends \App\Controllers\BaseController{


    public function index(){

        $userModel = model('App\Models\UserModel', false);
        $categoryModel = model('App\Models\Category');
        $banners=$categoryModel->get_category_page_banners("digital-codes-gift-cards-1715689747761");
        // Shop By Categories
        $shopby_categories = [
            [
                "eng_title" => "Playstation",
                "ara_title" => "بلايستيشن",
                "link" => base_url() . "/digital-codes-and-gift-cards/playstation",
                "img" => base_url() . "/assets/uploads/zg-digital-psn-01.jpg",
            ],
            [
                "eng_title" => "Xbox",
                "ara_title" => "أكس بوكس",
                "link" => base_url() . "/digital-codes-and-gift-cards/xbox",
                "img" => base_url() . "/assets/uploads/zg-digital-xbox-01.jpg",
            ],
            [
                "eng_title" => "Nintedo",
                "ara_title" => "ننتندو",
                "link" => base_url() . "/digital-codes-and-gift-cards/nintendo",
                "img" => base_url() . "/assets/uploads/zg-digital-nintendo-01.jpg",
            ],
            [
                "eng_title" => "Apple Itunes",
                "ara_title" => "أبل أيتيونز",
                "link" => base_url() . "/digital-codes-and-gift-cards/apple-itunes",
                "img" => base_url() . "/assets/uploads/zg-digital-itunes-01.jpg",
            ],
            [
                "eng_title" => "Steam",
                "ara_title" => "ستيم",
                "link" => base_url() . "/digital-codes-and-gift-cards/steam",
                "img" => base_url() . "/assets/uploads/zg-digital-steam-01.jpg",
            ],
            [
                "eng_title" => "Google Play",
                "ara_title" => "غوغل بلاي",
                "link" => base_url() . "/digital-codes-and-gift-cards/google-play",
                "img" => base_url() . "/assets/uploads/zg-digital-google-play-01.jpg",
            ],
            [
                "eng_title" => "Roblox  ",
                "ara_title" => "روبلوكس",
                "link" => base_url() . "/digital-codes-and-gift-cards/roblox",
                "img" => base_url() . "/assets/uploads/zg-digital-roblox-categ.jpg",
            ],
            [
                "eng_title" => "Games Cards",
                "ara_title" => "كروت الألعاب",
                "link" => base_url() . "/digital-codes-and-gift-cards/game-cards",
                "img" => base_url() . "/assets/uploads/zg-digital-pubg-01.jpg",
            ],
        ];

        $shop_by_region = [
            [
                "eng_title" => "United Arabe Emirate",
                "ara_title" => "الامارات العربية المتحدة",
                "link" => base_url() . "/product-list?type=6&regions=2",
                "img" => base_url() . "/assets/uploads/digital-flag-uae.png",
            ],
            [
                "eng_title" => "United States",
                "ara_title" => "الولايات المتحدة الأمريكية",
                "link" => base_url() . "/product-list?type=6&regions=1",
                "img" => base_url() . "/assets/uploads/digital-flag-usa.png",
            ],
            [
                "eng_title" => "United Kingdom",
                "ara_title" => "المملكة المتحدة",
                "link" => base_url() . "/product-list?type=6&regions=13",
                "img" => base_url() . "/assets/uploads/digital-flag-uk.png",
            ],
            [
                "eng_title" => "Qatar",
                "ara_title" => "قطر",
                "link" => base_url() . "/product-list?type=6&regions=24",
                "img" => base_url() . "/assets/uploads/digital-flag-qatar.png",
            ],
            [
                "eng_title" => "Bahrain",
                "ara_title" => "البحرين",
                "link" => base_url() . "/product-list?type=6&regions=27",
                "img" => base_url() . "/assets/uploads/digital-flag-bahrain.png",
            ],
            [
                "eng_title" => "Kuwait",
                "ara_title" => "الكويت",
                "link" => base_url() . "/product-list?type=6&regions=23",
                "img" => base_url() . "/assets/uploads/digital-flag-kuwait.png",
            ],
            [
                "eng_title" => "Oman",
                "ara_title" => "سلطنة عمان",
                "link" => base_url() . "/product-list?type=6&regions=21",
                "img" => base_url() . "/assets/uploads/digital-flag-oman.png",
            ],
        ];

        
        $data=array(
            "category_banners" => $banners,
            "categories_elements" => $shopby_categories,
            "shop_by_region" => $shop_by_region
        );

        // OFFERS SECTION
        $filter = [
            "type" => [6],
            "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 20,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["offers"] = array("list"=>$products["product"],"title"=>strtoupper(lg_get_text("lg_26")),"link"=> base_url()."/product-list?type=6&show-offer=yes");
        
        // Entertainment
        $filter = [
            "categoryList" => ["music-17156897548652","netflix-17156897665436","twitch-17156897562971"],
            "type" => [6],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 15,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["entertainment"] = array("list"=>$products["product"],"title"=>strtoupper("Entertainment"),"link"=> base_url()."/product-list?type=6&categoryList=music-17156897548652,netflix-17156897665436,twitch-17156897562971");
        
        // Shopping
        $filter = [
            "categoryList" => ["shopping-17156897488124"],
            "type" => [6],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 15,
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["shopping"] = array("list"=>$products["product"],"title"=>strtoupper("Shopping"),"link"=> base_url()."/digital-codes-and-gift-cards/shopping");
        
        // Xbox Digitals
        $filter = [
            "categoryList" => ["xbox-17156897516721"],
            "type" => [6],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 15,
            "groupby" => "price",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["xbox_digitals"] = array("list"=>$products["product"],"title"=>strtoupper("Xbox Digital"),"link"=> base_url()."/digital-codes-and-gift-cards/xbox");
        
        // Playstation Digitals
        $filter = [
            "categoryList" => ["playstation-17156897504136"],
            "type" => [6],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 15,
            "groupby" => "price",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["playstation_digitals"] = array("list"=>$products["product"],"title"=>strtoupper("Playstation Digital"),"link"=> base_url()."/digital-codes-and-gift-cards/playstation");
        
        
        // Game Cards
        $filter = [
            "master_category" => "game-cards-17156897472147",
            "type" => [6],
            // "showOffer" => "yes",
            "sort" => "Newest", // Newest, Oldest, Highest, Lowest
            "page" => 1,
            "limit" => 15,
            "groupby" => "price",
        ];
        if($products = $this->productModel->product_filter_query($filter))
		$data["game_cards"] = array("list"=>$products["product"],"title"=>strtoupper("Game Cards"),"link"=> base_url()."/digital-codes-and-gift-cards/game-cards");
        
        

        echo view("Common/Header");
        echo view("Category_codes",$data);
        echo view("Common/Footer");

    }
    
}


?>