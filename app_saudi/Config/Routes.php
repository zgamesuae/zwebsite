<?php
namespace Config;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
$uri = Services::uri();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
  require SYSTEMPATH . 'Config/Routes.php';
}



$cat=model("App\Models\Category");
$product_model = model("App\Models\ProductModel");
$brands = model("App\Models\BrandModel");

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */





$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
// $routes->setDefaultController('Under_maintenance');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->add('cat/hello', 'cat/Hello');
$routes->add('customercart/cart', 'customercart/Cart/getcart');
// $routes->add('cat/playstation', 'cat/Playstation');
// $routes->add('cat/xbox', 'cat/Xbox');
// $routes->add('cat/nintendo_switch', 'cat/Nintendo_switch');
$routes->add('get_a_quote/check_request', 'Get_a_quote/check_request');



/** 
 * --------------------------------------------------------------------
 * setup the products page url before loading
 * --------------------------------------------------------------------
 * */  
// var_dump($uri->getSegment(1));die();

if($uri->getSegment(1) == "product" && trim($uri->getSegment(2)) !== "" && $product_model->get_product_id_from_slug($uri->getSegment(2))){
    $product_id = $product_model->get_product_id_from_slug($uri->getSegment(2))->product_id;
    $slug = $uri->getSegment(2);
    // var_dump($slug);die();

    $routes->add("product/".$slug, 'Page::productDetail/'.$product_id);
  
}


/** 
 * --------------------------------------------------------------------
 * setup the brand page url before loading
 * --------------------------------------------------------------------
 * */  

// var_dump($brands->get_brand_id_from_slug($uri->getSegment(2)));die();

if($uri->getSegment(1) == "product-list" && $brands->get_brand_id_from_slug($uri->getSegment(2))){
    $brand_id =  $brands->get_brand_id_from_slug($uri->getSegment(2));
    $slug = $uri->getSegment(2);
    $routes->add("product-list/".$slug, 'Page::productList//'.$brand_id);

}


/** 
 * --------------------------------------------------------------------
 * setup the offer page url before loading
 * --------------------------------------------------------------------
 * */  
if($uri->getSegment(1) == "product-list" && $uri->getSegment(2)=="offers"){
  $slug = $uri->getSegment(2);
  $routes->add("product-list/".$slug, 'Page::productList///offers');
}

/** 
 * --------------------------------------------------------------------
 * setup the pre-order page url before loading
 * --------------------------------------------------------------------
 * */  
if($uri->getSegment(1) == "product-list" && $uri->getSegment(2)=="pre-orders"){
  $slug = $uri->getSegment(2);
  $routes->add("product-list/".$slug, 'Page::productList////pre-orders');
}



// preg_match("/brand=(\d+)/" , $uri->getQuery() , $brand_id);
// var_dump($brand_id[1]);die();

$routes->add('about-us', 'Page::cms/1');
$routes->add('terms-and-conditions', 'Page::cms/2');
$routes->add('privacy-and-policy', 'Page::cms/3');
$routes->add('delivery-information', 'Page::cms/4');
$routes->add('refund-policy', 'Page::cms/5');
$routes->add('product/(:any)', 'Page::productDetail/$1');
$routes->add('product2/(:any)', 'Page::productDetail2/$1');
$routes->add('category/(:any)', 'Page::category/$1');
$routes->add('search/(:any)', 'Page::search/$1');
$routes->add('product-list', 'Page::productList');
$routes->add('blogs/(:any)', 'Blogs::blogDetail/$1');
$routes->get('blogs/category/(:any)', 'Blogs::index/$1');
$routes->add('invoice/(:any)', 'Page::invoice/$1');
$routes->add('cart', 'Page::cart');
$routes->add('logout', 'Auth::logout');
$routes->add('contact-us', 'Page::contact');
// $routes->add('blog', 'Page::blog');
$routes->add('faq', 'Page::faq');
$routes->add('success', 'Page::success');
$routes->add('order-success', 'Page::orderSuccess');
$routes->add('order-submit', 'Page::orderSubmit');
$routes->add('checkout', 'Page::checkout');
$routes->add('packages', 'Page::packages');
$routes->add('reset-password/(:any)', 'Page::resetPassword/$1');
$routes->add('login/resend-verification-code/(:any)', 'Auth::resend_verification_email/$1');
$routes->add('verify/(:any)', 'Auth::verify/$1');
$routes->add('account-verified', 'Page::accountVerified');
$routes->add('payment-success/(:any)', 'Page::paymentSuccess/$1'); 

$routes->add('payment-failed', 'Page::paymentFailed'); 

$routes->add('payment-success-wallet/(:any)', 'Page::paymentSuccessWallet/$1'); 
$routes->add('order-success-wallet', 'Page::orderSuccessWallet');
$routes->add('back-to-school', 'Yahiacheck::bts_page');

// Customized routes for categories

if(true){
  $urls=$cat->categories_urls();
  foreach($urls as $key => $value){
    if($value !== "playstation" && $value !== "xbox" && $value !== "nintendo-switch"){
      $routes->add($value,'Page::productList/'.$key);
    }
    
    else{
      if($value == "nintendo-switch")
      $routes->add($value , 'cat/'.ucfirst(preg_replace("/\-/" , "_" , $value)));
      else
      $routes->add($value,'cat/'.ucfirst($value));
    
    }
  
  }
}


/** 
 * --------------------------------------------------------------------
 * Supercontrol routes
 * --------------------------------------------------------------------
 **/ 

 $routes->add('supercontrol/stores/store_agents' , 'Supercontrol/Zgstores/Stores::store_agents');
 $routes->add('supercontrol/stores/store_customers' , 'Supercontrol/Zgstores/Stores::store_customers');
 $routes->add('supercontrol/stores/store_reviews' , 'Supercontrol/Zgstores/Stores::store_reviews');
 
 /**
  * --------------------------------------------------------------------
  * ZATCA ROUTING
  * --------------------------------------------------------------------
  */
 $routes->add("zatca/zatca/test" , "zatca/Zatca::test");
 
 /** 
 * --------------------------------------------------------------------
 * Back Ends Tournament routes
 * --------------------------------------------------------------------
 **/ 
 $routes->add('supercontrol/tournaments/registrations' , 'Supercontrol/tournaments/Tournaments::registrations');


 /** 
 * --------------------------------------------------------------------
 * Front End Tournament routes
 * --------------------------------------------------------------------
 **/ 
//  $routes->add('cr/(:any)' , 'tournament/Tournament::cr/$1');
 $routes->add('tournament/register' , 'Tournament/Tournament::register');
 $routes->add('tournament' , 'Tournament/Tournament');




if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
  require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}