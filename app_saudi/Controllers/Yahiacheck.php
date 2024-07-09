<?php
namespace App\Controllers;
use App\Controllers\cat\Xbox;
class Yahiacheck extends BaseController{
    
public function index1(){
    
    if(false):
        $orderModel = model("App\Model\OrderModel");
        $ab = $orderModel->get_users_abondoned_carts(144000);
            if(sizeof($ab)>0 && !is_null($ab)){
    
                foreach($ab as $value){
                    $cart = $orderModel->get_user_cart($value["id"]);
                    if(sizeof($cart)>0){
                        // send the email to the customer
                        // var_dump($value);
                        $email_content = view("Cart_notification" , array("infos" =>[
                                            "user"=>$value,
                                            "carts_product"=>$cart,
                                            ] ));
                                            
                                            echo $email_content;
                        $subject = "Items in your cart";
                        $message = $email_content;
                        $email = \Config\Services::email();
                        $email->setTo($value["email"]);
                        $email->setFrom(
                            "info@zamzamdistribution.com",
                            "Zamzam Games"
                        );
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        $email->send();
                    }
    
    
                }
    
            }
        
    endif;
        
    if ($to = "yahia@3gelectronics.biz" && false) {
        $subject = "Spining wheel prize!!";
        
        $message = '
            <div style="width: 550px; background-color: white; margin: 15px auto">
                <p style="font-size: 16px; font-weight: 500;">
                    Thank you <b>YAHIA ABDERRAHMANE</b> for shoping with ZGames, you will get the folowing item as a prize with your last order <b><i>N° 6544789321</i></b>.
                </p>
                <table style="width:100%; height:auto; margin: 55px 0; border: solid rgba(0, 0, 0, 0.356) 1px">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background: #22398d;">
                                <h3 style="color:rgb(245, 245, 245); font-size: 20px; padding: 15px 10px; text-align:center; margin:0px">Congratulation you won a prize!</h3>
                            </td>
                        </tr>
    
                        <tr>
                            <td style="width: 50%; text-align:center">
                                <img src="https://zamzamgames.com/assets/uploads/135.jpg" style="max-height:180px " alt="">
                            </td>
                            <td style="width: 50%; text-align:center; padding: 5px">
                                <div style="color: rgb(255, 255, 255); background-color: rgb(0, 102, 5);padding: 15px 10px">
                                    <p style="font-size: 18px;">Pop! Marvel: What If…? - Killmonger (BKLT)</p>
                                </div>
                            </td>
                        </tr>
    
                        <tr>
                            <td colspan="2" style="padding: 10px 5px">
                                <p style="text-align: center; font-size: 12px; color: rgb(143, 143, 143); line-height: 15px; padding: 0px 15px">
                                    Terms & Conditions: The above item is not replaceable or refundable. 
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
    
                <table style="width: 100%; ">
                    <tr>
                        <td>
                            <p style="font-size: 12px; padding: 5px 20px; text-align:center">
                                Tel: +971 56 8016 786 <br>
                                Email: contact@zamzamgames.com <br>
                                © ZGames | Business Bay - Opus by Omniat.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <a href="https://www.facebook.com/zamzam.games" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                <img alt="" src="https://zamzamgames.com/assets/uploads/ns_facebook.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                            </a> 
                            <a href="https://www.instagram.com/zamzam.games" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                <img alt="" src="https://zamzamgames.com/assets/uploads/ns_instagram.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                            </a> 
                            <a href="https://www.tiktok.com/@zgames" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                <img alt="" src="https://zamzamgames.com/assets/uploads/ns_tiktok.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                            </a>
                        </td>
                    </tr>
                </table>
    
            </div>
        ';
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom(
            "info@zamzamdistribution.com",
            "Zamzam Games"
        );
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->send();
        echo($email->printDebugger(['headers']));
       
    }
    // echo view("Cart_notification");
    $routes = \Config\Services::routes();
      var_dump($routes);
}

public function accessories(){
    // if ($to = "alantinedj@hotmail.fr") {
    //     $subject = "CRON TEST";
    //     // $ud["user"] = $res[0];
    //     $ud["user"] = "yahia abderrahmane";
    //     $message = "hi yahia this is a test for the cron job";
    //     $email = \Config\Services::email();
    //     $email->setTo($to);
    //     $email->setFrom(
    //         "info@zamzamdistribution.com",
    //         "Zamzam Games"
    //     );
    //     $email->setSubject($subject);
    //     $email->setMessage($message);
    //     $email->send();
    //     echo($email->printDebugger(['headers']));
       
    // }
    
    // $userModel = model("App/Models/UserModel");
   
    $req = "select sku,name,arabic_name,description,features from products where status='Active' and type='7' and arabic_name is not null";
    $res = $this->userModel->customQuery($req);
    // var_dump($res);
    if($res){
        $page = '
        <div style="max-width:90vw; margin:auto">
        <table style="margin:auto; width: 100%">
            <thead>
                <tr>
                    <th> SKU </td>
                    <th> NAME </td>
                    <th> ARABIC NAME </td>
                    <th> DESCRIPTION </td>
                    <th> FEATURES </td>
                </tr>
            </thead>
            <tbody>';

        foreach($res as $product){
               $page .= '
               <tr>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->sku.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->name.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px; text-align: right" dir="rtl"> '.$product->arabic_name.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px">  </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> </td>
                </tr>';
        }
        
            $page .= '</tbody>
        </table>
        </div>';
        echo $page;
    }
  
}

public function videogames(){
    
    $req = "select sku,name,arabic_name,description,features from products where status='Active' and type='5' and arabic_name is not null";
    $res = $this->userModel->customQuery($req);
    // var_dump($res);
    if($res){
        $page = '
        <div style="max-width:90vw; margin:auto">
        <table style="margin:auto; width: 100%">
            <thead>
                <tr>
                    <th> SKU </td>
                    <th> NAME </td>
                    <th> ARABIC NAME </td>
                    <th> DESCRIPTION </td>
                    <th> FEATURES </td>
                </tr>
            </thead>
            <tbody>';

        foreach($res as $product){
               $page .= '
               <tr>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->sku.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->name.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px; text-align: right" dir="rtl"> '.$product->arabic_name.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> </td>
                </tr>';
        }
        
            $page .= '</tbody>
        </table>
        </div>';
        echo $page;
    }
  
}

public function allproducts(){
    
    $req = "select sku,name,arabic_name,description,arabic_description,features,arabic_features from products where status='Active' order by created_at asc";
    $req2 = "select total.*,done.* from (select count(sku) as c_total from products where status='Active') as total INNER join (select count(sku) as c_done from products where status='Active' and ((arabic_name is not null and arabic_name <> '') or (arabic_description is not null or arabic_description <> ''))) as done";
    $res2 = $this->userModel->customQuery($req2);
    $ara_updated = '
        <div style="max-width:90vw; margin:auto">
            <h2 style="text-align:center; padding: 15px 10px">'.$res2[0]->c_done.' From '.$res2[0]->c_total.' product translated</h2>
        </div>
    ';
    echo($ara_updated);
    $res = $this->userModel->customQuery($req);
    // var_dump($res);
    if($res){
        $page = '
        <div style="max-width:90vw; margin:auto">
        <table style="margin:auto; width: 100%">
            <thead>
                <tr>
                    <th> SKU </td>
                    <th> NAME </td>
                    <th> ARABIC NAME </td>
                    <th> DESCRIPTION </td>
                    <th> ARABIC DESCRIPTION </td>
                    <th> FEATURES </td>
                    <th> ARABIC FEATURES </td>
                </tr>
            </thead>
            <tbody>';

        foreach($res as $product){
               $page .= '
               <tr>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->sku.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->name.' </td>
                    <td style="border: 1px black solid; max-width: 800px; padding: 10px 5px; text-align:right"> '.$product->arabic_name.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px; overflow-y: auto"> '.$product->description.' </td>
                    <td style="border: 1px black solid; max-width: 800px; padding: 10px 5px;text-align:right; overflow-y: auto"> '.$product->arabic_description.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px"> '.$product->features.' </td>
                    <td style="border: 1px black solid; max-width: 500px; padding: 10px 5px;text-align:right"> '.$product->arabic_features.' </td>
                </tr>';
        }
        
            $page .= '</tbody>
        </table>
        </div>';
        echo $page;
    }
  
}

public function change_language($language){
    $lang = array( "EN" , "AR" );
    $feedback = array("status" => 0 , "message" => "");
    if(in_array($language , $lang)){
        set_cookie("language" , $language , 300);
        $feedback["status"] = 1;

        switch ($language) {
            case 'EN':
                # code...
            $feedback["message"] = "Language updated successfully to English";

            break;
            
            default:
                # code...
            $feedback["message"] = "Language updated successfully to Arabic";

            break;
        }
    }
    else 
    $feedback["message"] = "Language not recognized";

    return json_encode($feedback);
}

public function u_products(){
    $p=array(
        "5030939124947" => 2593,
        "5026555364751" => 2594,
        "5051893241693" => 2595,
        "5030917291005" => 2596,
        "5060146468459" => 2597,
        "3391892006919" => 2598,
        "711719345305" => 2599,
        "5026555429467" => 2600,
        "5026555432597" => 2601,
        "811949035196" => 2602,
        "5060760886684" => 2603,
        "5026555432061" => 2604,
        "3701529502866" => 2605,
        "45496420369" => 2606,
        "3760156487786" => 2607,
        "5030917282928" => 2608,
        "5030935123500" => 2609,
        "5051893235036" => 2610,
        "5026555070225" => 2611,
        "45496423780" => 2612,
        "45496420437" => 2613,
        "3391892014853" => 2614,
        "3391892023022" => 2615,
        "3760156483856" => 2616,
        "5030932123718" => 2617,
    );
    $i=0;
        foreach($p as $sku => $precedence){
            $req="update products set precedence=".$precedence." where sku='".$sku."'";
            $res = $this->userModel->customQuery($req);
            if($res!== false or !is_null($res))
            $i++;
        }
        echo ($i." from ".sizeof($p)." Updated");
}


public function bts_page(){
    // $userModel = model("App\Model\UserModel");
    // $v = new Xbox();
    // $query_bestseller_3=$v->build_query("controllers-1641114146",$v->_subcat("controllers-1641114146"));
    // $list = $userModel->customQuery($query_bestseller_3);
    // var_dump($list , $query_bestseller_3);
    $data = $this->bts_products_carousel();
    echo view("Common/Header");
    echo view("Bts_page" , $data);
    echo view("Common/Footer");
    
}

private function bts_products_carousel(){
    $data=array();
	$product_model=model('App\Models\ProductModel');
	if($product_model->bts_videogames())
	$data["videogames"] = array("list"=>$product_model->bts_videogames(),"title"=>lg_get_text("lg_338"),"link"=> base_url()."/product-list/offers?type=5");
	if($product_model->bts_controllers())
	$data["controllers"] = array("list"=>$product_model->bts_controllers(),"title"=>lg_get_text("lg_339"),"link"=> base_url()."/product-list/offers?type=27");
	if($product_model->bts_figurines())
	$data["figurines"] = array("list"=>$product_model->bts_figurines(),"title"=>lg_get_text("lg_340"),"link"=> base_url()."/product-list/offers?type=41");
	if($product_model->bts_consoles())
	$data["consoles"] = array("list"=>$product_model->bts_consoles(),"title"=>lg_get_text("lg_341"),"link"=> base_url()."/product-list/offers?type=18");
	if($product_model->bts_monitors())
	$data["monitors"] = array("list"=>$product_model->bts_monitors(),"title"=>lg_get_text("lg_342"),"link"=> base_url()."/product-list/offers?type=42");
	
    return $data;
}

public function test(){
    // var_dump($this->tabbyModel->register_webhook("https://test.zgames.ae/notifications/tabby/listener"));
    // var_dump($this->tabbyModel->update_webhook("78c4e9f3-57bc-42c3-9f86-ebdb9b10823a" , "https://zgames.sa/notifications/tabby/listener" , false));
    // var_dump($this->tabbyModel->retreive_webhooks());
    // echo " ".CURRENCY;
    $this->userModel->get_user_infos_by_email("yahiaabd@gmail.com" , true);
}

}   