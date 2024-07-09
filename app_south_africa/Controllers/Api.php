<?php
namespace App\Controllers;
require APPPATH.'ThirdParty/php-jwt-master/src/JWT.php';
require APPPATH.'ThirdParty/php-jwt-master/src/ExpiredException.php';
require APPPATH.'ThirdParty/php-jwt-master/src/SignatureInvalidException.php';
require APPPATH.'ThirdParty/php-jwt-master/src/BeforeValidException.php';
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\UserModel;
use \Firebase\JWT\JWT;
use CodeIgniter\RESTful\ResourceController;
class Api extends ResourceController
{
 protected $jwt_secrect;
 protected $token;
 protected $issuedAt;
 protected $expire;
 protected $jwt;
  /* helper(['form','url']);
  $_args=$this->request->headers('X-Auth-Token');*/
    //   print_r(getallheaders()['X-Auth-Token']);
  public function __construct()
  {
    $userModel = new UserModel();
        // set your default time-zone
    date_default_timezone_set('Asia/Kolkata');
    $this->issuedAt = time();
        // Token Validity (3600 second = 1hr)
    $this->expire = $this->issuedAt + 3600;
        // Set your secret or signature
    $this->jwt_secrect = "sanjoobtoys.com";  
  }
  
  // ################## Start Myorders #####################
// ################## Start Myorders #####################
public function myOrders()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $sql="SELECT  * FROM  orders where user_id='$user_id' order by created_at desc";
      $udata = $userModel->customQuery($sql);   
      if($udata){
        foreach( $udata as $k=>$v){



          
         /* if($v->image){
            $udata[$k]->image=base_url().'/assets/uploads/'.$v->image;
          }else {
           $udata[$k]->image=base_url().'/assets/uploads/noimg.png';
         }*/
       }
       $response = [
         'status' => 200,
         'error' => false,
         'messages' => '',
         'data' => $udata
       ];
       return $this->respondCreated($response);
     }else{
       $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Your  orders list is currently empty.',
        'data' => []
      ];
      return $this->respondCreated($response);   
    }
  }else{
    $response = [
     'status' => 401,
     'error' => true,
     'messages' => 'Invailid Token',
     'data' => []
   ];
   return $this->respondCreated($response); 
 }
} catch (Exception $ex) {
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Access denied',
  'data' => []
];
return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END Myorders #####################
// ################## END Myorders ##################### 
  
 
 // ################## Start add kids #####################
// ################## Start add kids #####################
public function addkids()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $rules = [
       "name" => "required" ,
       "date_of_birth" => "required" ,
       "gender" => "required" ,
       "status" => "required" ,
     ];
     $messages = [
      "name" => ["required" => "name is required"],
      "date_of_birth" => ["required" => "date_of_birth is required"],
      "gender" => ["required" => "gender is required"],
      "status" => ["required" => "status is required"],
    ];
    if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
       'status' => 200,
       'error' => true,
       'messages' => $ht,
       'data' => []
     ];
     return $this->respondCreated($response); 
   }
   else{
    if($pid=$this->request->getVar("name")){
                // 
     if($pid=$this->request->getVar("kids_id")){
       $p=$this->request->getVar();
       $sql="select * from kids where user_id='$user_id' AND kids_id='$pid'";
       $udata = $userModel->customQuery($sql);
       if($udata){
         $res=$userModel->do_action('kids',$pid,'kids_id','update',$p,''); 
         $response = [
          'status' => 200,
          'error' => false,
          'messages' => 'kids updated successfully',
          'data' => []
        ];
        return $this->respondCreated($response); 
      }else{
       $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'kids not exist in user kids list',
        'data' => []
      ];
      return $this->respondCreated($response);  
    }
  }else{
                // 
   $p=$this->request->getVar();
   $p['user_id']=$user_id;
    helper(['form','url']);
    
    
     $input = $this->validate([
            'image' => [
               'uploaded[image]',
               'mime_in[image,image/jpg,image/jpeg,image/png]',
            ]
         ]);
         if (!$input) {}else{
            if($this->request->getFile('image')){
               $img = $this->request->getFile('image');
               $img->move(ROOTPATH.'/assets/uploads/');
               $p['image']=$img->getName();
            }
         } 
   
 
   
   
   $res=$userModel->do_action('kids','','','insert',$p,''); 
   $response = [
    'status' => 200,
    'error' => false,
    'messages' => 'kids successfully added to your user kids list.',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}
}
}
else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add kids #####################
// ################## END add kids ##################### 
// ################## Start MyKids #####################
// ################## Start MyKids #####################
public function myKids()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $sql="SELECT  * FROM  kids where user_id='$user_id' order by created_at desc";
      $udata = $userModel->customQuery($sql);   
      if($udata){
        foreach( $udata as $k=>$v){
          if($v->image){
            $udata[$k]->image=base_url().'/assets/uploads/'.$v->image;
          }else {
           $udata[$k]->image=base_url().'/assets/uploads/noimg.png';
         }
       }
       $response = [
         'status' => 200,
         'error' => false,
         'messages' => '',
         'data' => $udata
       ];
       return $this->respondCreated($response);
     }else{
       $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Your  kids list is currently empty.',
        'data' => []
      ];
      return $this->respondCreated($response);   
    }
  }else{
    $response = [
     'status' => 401,
     'error' => true,
     'messages' => 'Invailid Token',
     'data' => []
   ];
   return $this->respondCreated($response); 
 }
} catch (Exception $ex) {
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Access denied',
  'data' => []
];
return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END MyKids #####################
// ################## END MyKids ##################### 
// ################## Start add kids #####################
// ################## Start add kids #####################
public function deletekids()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $rules = [
       "kids_id" => "required" 
     ];
     $messages = ["kids_id" => ["required" => "kids_id is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    }
    else{
     if($pid=$this->request->getVar("kids_id")){
      $sql="select * from kids where user_id='$user_id' AND kids_id='$pid'";
      $udata = $userModel->customQuery($sql);
      if($udata){
       $res=$userModel->do_action('kids',$pid,'kids_id','delete','',''); 
       $response = [
        'status' => 200,
        'error' => false,
        'messages' => 'kids removed from your kids list',
        'data' => []
      ];
      return $this->respondCreated($response); 
    }else{
     $response = [
      'status' => 200,
      'error' => true,
      'messages' => 'kids not exist in user kids list',
      'data' => []
    ];
    return $this->respondCreated($response);  
  }
}
}
}
else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add kids #####################
// ################## END add kids ##################### 
  
  
  
  // ################## Start productDetail Login #####################
// ################## Start productDetail Login #####################
public function productDetail()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
   $rules = [
   "language" => "required" ,"product_id" => "required" ];
   $messages = ["language" => ["required" => "language is required"] ,"product_id" => ["required" => "product_id is required"] ];
   if (!$this->validate($rules, $messages)) {
     $msg[0]='error';
     $ht="";
     foreach( $this->validator->getErrors() as $v){
      $ht=$ht." ".$v." ";
    }
    $response = [
    'status' => 200,
    'error' => true,
    'messages' => $ht,
    'data' => []
    ];
    return $this->respondCreated($response); 
  } else {
   $data = [];
   helper(['form','url']);
   if ($this->request->getMethod() == "post" ) {
       $pid=$this->request->getVar("product_id");
    if($this->request->getVar("language")=="arabic"){
      $sql="select products.product_id as product_id,
      products.arabic_name  as products_name,price,
      products.available_stock as available_stock,
      products.discount_percentage as discount_percentage,
      products.arabic_description as products_description,
      products.arabic_feature as products_features,
      products.gift_wrapping as gift_wrapping,
      products.category as category_id,
      
      master_category.category_name_arabic as category_name,
      master_category.category_description_arabic as category_description,
      
       brand.arabic_title as brand_title,
      color.arabic_title as color_title,
      suitable_for.arabic_title as suitable_for_title,
      age.arabic_title as age_title
      
      from products 
      
      inner join brand on products.brand=brand.id
      inner join color on products.color=color.id
       inner join suitable_for on products.suitable_for=suitable_for.id
        inner join age on products.age=age.id
      
      
      inner join master_category on products.category=master_category.category_id
      where products.status='Active' AND products.product_id='$pid'";
    }else{
      $sql="select products.product_id as product_id,
      products.name  as products_name,price,
      products.available_stock as available_stock,
      products.discount_percentage as discount_percentage,
      products.description as products_description,
      products.features as products_features,
      
      
      
      
      
       products.gift_wrapping as gift_wrapping,
     products.category as category_id,
      master_category.category_name as category_name,
      master_category.category_description as category_description,
      brand.title as brand_title,
      color.title as color_title,
      suitable_for.title as suitable_for_title,
      age.title as age_title
      
      from products 
      
       inner join brand on products.brand=brand.id
      inner join color on products.color=color.id
       inner join suitable_for on products.suitable_for=suitable_for.id
        inner join age on products.age=age.id
        
      inner join master_category on products.category=master_category.category_id
      where products.status='Active' AND products.product_id='$pid' ";
    }
    $data=$userModel->customQuery($sql); 
    if (!empty($data)) {
     foreach($data as $k=>$v){
      $img=[];
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      if($product_image){
       foreach($product_image as $k2=>$v2){
        $img[]=base_url().'/assets/uploads/'.$v2->image; 
      }
    }
    
    if($v->gift_wrapping=="Yes"){
     $sql="select * from gift_wrapping where     status='Active' ";
      $gift_wrapping=$userModel->customQuery($sql); 
      if($gift_wrapping){
       foreach($gift_wrapping as $k2=>$v2){
        $gift_wrapping[$k2]->image=base_url().'/assets/uploads/'.$v2->image; 
      }
    }
      $data[$k]->gift_wrapping_list=$gift_wrapping;
     }else{
          $data[$k]->gift_wrapping_list=array(); 
     }
     
     
     
    //  simlliar start
     $scid=$v->category_id;
    if($this->request->getVar("language")=="arabic"){
  $sql="select products.product_id as product_id,
  products.category as category_id,
  products.arabic_name  as products_name,price,
  products.available_stock as available_stock,
  products.discount_percentage as discount_percentage,
  products.arabic_description as products_description,
  products.arabic_feature as products_features,
  master_category.category_name_arabic as category_name,
  master_category.category_description_arabic as category_description
  from products 
  inner join master_category on products.category=master_category.category_id
  where products.status='Active' AND products.category='$scid'";
}else{
  $sql="select products.product_id as product_id,
  products.category as category_id,
  products.name  as products_name,price,
  products.available_stock as available_stock,
  products.discount_percentage as discount_percentage,
  products.description as products_description,
  products.features as products_features,
  master_category.category_name as category_name,
  master_category.category_description as category_description
  from products 
  inner join master_category on products.category=master_category.category_id
  where products.status='Active' AND products.category='$scid' ";
}   
$simillar=$userModel->customQuery($sql); 
if (!empty($simillar)) {
 foreach($simillar as $sk=>$sv){
  $simg=[];
  $pid=$sv->product_id;
  $sql="select * from product_image where     product='$pid' and status='Active' ";
  $product_image_similar=$userModel->customQuery($sql); 
  if($product_image_similar){
   foreach($product_image_similar as $sk2=>$sv2){
    $simg[]=base_url().'/assets/uploads/'.$sv2->image; 
  }
}
$simillar[$k]->product_image=$simg;
}
    $data[$k]->related_products=$simillar; 
}else{
     $data[$k]->related_products=array();
}
    //  smillar end
     
     
     
     
     
  
    $data[$k]->product_image=$img;
  }
  $response = [
  'status' => 200,
  'error' => false,
  'messages' => '',
  'data' => $data[0]
  ];
  return $this->respondCreated($response);  
} else {
 $response = [
 'status' => 200,
 'error' => true,
 'messages' => 'product not found',
 'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
  $response = [
  'status' => 200,
  'error' => true,
  'messages' => 'product not found',
  'data' => []
  ];
  return $this->respondCreated($response);  
}
}
}else{
  $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid ApiKey',
  'data' => []
  ];
  return $this->respondCreated($response);  
}
}
// ################## END productDetail Login #####################
// ################## END productDetail Login #####################
  
  
  
  
  
  
// ################## Start add user_address #####################
// ################## Start add user_address #####################
  public function editUserAddress()
  {
   $key=$this->ApiKeyValidation();
   if($key){ 
    $ApiKey = $this->request->header("ApiKey");
    if(!empty($this->request->header("Token")) ){
     $Token= $this->request->header("Token");
     $token = $Token->getValue();
     try {
      $decoded = JWT::decode($token, $key, array("HS256"));
      if ($decoded) {
        $user_id=$decoded->data;
        $userModel = new UserModel();  
        $rules = [
         "address_id" => "required" 
       ];
       $messages = ["address_id" => ["required" => "address_id is required"] ];
       if (!$this->validate($rules, $messages)) {
         $msg[0]='error';
         $ht="";
         foreach( $this->validator->getErrors() as $v){
          $ht=$ht." ".$v." ";
        }
        $response = [
          'status' => 200,
          'error' => true,
          'messages' => $ht,
          'data' => []
        ];
        return $this->respondCreated($response); 
      }
      else{
       if($pid=$this->request->getVar("address_id")){
         $p=$this->request->getVar();
         $sql="select * from user_address where user_id='$user_id' AND address_id='$pid'";
         $udata = $userModel->customQuery($sql);
         if($udata){
           if($this->request->getVar("status")=="Active"){
             $pd['status']="Inactive";
             $res1=$userModel->do_action('user_address',$user_id,'user_id','update',$pd,''); 
           }
           $res=$userModel->do_action('user_address',$pid,'address_id','update',$p,''); 
           $response = [
            'status' => 200,
            'error' => false,
            'messages' => 'Address updated successfully',
            'data' => []
          ];
          return $this->respondCreated($response); 
        }else{
         $response = [
          'status' => 200,
          'error' => true,
          'messages' => 'Address not exist in user address list',
          'data' => []
        ];
        return $this->respondCreated($response);  
      }
    }
  }
}
else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END Edit user_address #####################
// ################## END Edit user_address ##################### 
// ################## Start add cart #####################
// ################## Start add cart #####################
public function deletecart()
{   
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
       "cart_id" => "required" 
     ];
   
     $messages = ["cart_id" => ["required" => "cart_id is required"] ];
     if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
       'status' => 200,
       'error' => true,
       'messages' => $ht,
       'data' => []
     ];
     return $this->respondCreated($response); 
   }
   else{
    if($pid=$this->request->getVar("cart_id")){
     $sql="select * from cart where user_id='$user_id' AND id='$pid'";
     $udata = $userModel->customQuery($sql);
     if($udata){
      $res=$userModel->do_action('cart',$pid,'id','delete','',''); 
      
      
        $sql="select * from cart where user_id='$user_id'  ";
     $cd = $userModel->customQuery($sql);
     if($cd){
         $cdata=count($cd);
     }else{
         $cdata=0;
     }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Product removed from your cart',
        'data' => ['cart_count'=> $cdata]
      ];
      return $this->respondCreated($response); 
    }else{
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Product not exist in cart',
        'data' => ['cart_count'=> 0]
      ];
      return $this->respondCreated($response);  
    }
  }
}
}
else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Access denied',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add cart #####################
// ################## END add cart ##################### 
// ################## Start add cart #####################
// ################## Start add cart #####################
public function addcart()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
       "product_id" => "required" , "quantity" => "required" 
     ];
     $messages = ["product_id" => ["required" => "product_id is required"] ,"quantity" => ["required" => "quantity is required"] ];
     if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
       'status' => 200,
       'error' => true,
       'messages' => $ht,
       'data' => []
     ];
     return $this->respondCreated($response); 
   }
   else{
    if($pid=$this->request->getVar("product_id")){
     $sql="select * from cart where user_id='$user_id' AND product_id='$pid'";
     $udata = $userModel->customQuery($sql);
     if($udata){
       $p['product_id']=$pid;
       $p['quantity']=$this->request->getVar("quantity");
       $p['user_id']=$user_id;
       $q=$udata[0]->quantity+$this->request->getVar("quantity");
       $sql="UPDATE cart SET quantity='$q' where user_id='$user_id' AND product_id='$pid'";
       $userModel->customQueryy($sql);
        $sql="select * from cart where user_id='$user_id'  ";
     $cd = $userModel->customQuery($sql);
     if($cd){
         $cdata=count($cd);
     }else{
         $cdata=0;
     }
       $response = [
         'status' => 200,
         'error' => false,
         'messages' => 'Product successfully added to your cart.',
         'data' => ['cart_count'=> $cdata]
       ];
       return $this->respondCreated($response);
     }else{
       $p['product_id']=$pid;
       $p['quantity']=$this->request->getVar("quantity");
       $p['user_id']=$user_id;
       $res=$userModel->do_action('cart','','','insert',$p,''); 
       
        $sql="select * from cart where user_id='$user_id'  ";
     $cd = $userModel->customQuery($sql);
     if($cd){
         $cdata=count($cd);
     }else{
         $cdata=0;
     }
       $response = [
         'status' => 200,
         'error' => false,
         'messages' => 'Product successfully added to your cart.',
         'data' => ['cart_count'=> $cdata]
       ];
       return $this->respondCreated($response);
     }
   }
 }
}
else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Access denied',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add cart #####################
// ################## END add cart ##################### 
// ################## Start User cart #####################
// ################## Start User cart #####################
public function usercart()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
       "language" => "required" ];
       $messages = ["language" => ["required" => "language is required"] ];
       if (!$this->validate($rules, $messages)) {
        $msg[0]='error';
        $ht="";
        foreach( $this->validator->getErrors() as $v){
         $ht=$ht." ".$v." ";
       }
       $response = [
         'status' => 200,
         'error' => true,
         'messages' => $ht,
         'data' => []
       ];
       return $this->respondCreated($response); 
     } else {
       if($this->request->getVar("language")=="arabic"){
        $sql="select cart.id as cart_id,cart.quantity as quantity,cart.assemble_professionally_price as assemble_professionally_price,cart.gift_wrapping_note as gift_wrapping_note,cart.gift_wrapping as gift_wrapping  products.product_id as product_id,
        products.arabic_name  as products_name,
        products.available_stock as available_stock,
        products.discount_percentage as discount_percentage,
        products.arabic_description as products_description,
        products.arabic_feature as products_features,
        master_category.category_name_arabic as category_name,
        master_category.category_description_arabic as category_description
        from cart
        inner join products on cart.product_id=products.product_id
        inner join master_category on products.category=master_category.category_id
        where products.status='Active' AND cart.user_id='$user_id'";
      }else{
       $sql="select cart.id as cart_id,cart.quantity as quantity,cart.assemble_professionally_price as assemble_professionally_price,cart.gift_wrapping_note as gift_wrapping_note,cart.gift_wrapping as gift_wrapping ,  products.product_id as product_id,
       products.name  as products_name,
       products.available_stock as available_stock,
       products.discount_percentage as discount_percentage,
       products.description as products_description,
       products.features as products_features,
       master_category.category_name as category_name,
       master_category.category_description as category_description
       from cart
       inner join products on cart.product_id=products.product_id
       inner join master_category on products.category=master_category.category_id
       where products.status='Active' AND cart.user_id='$user_id'";
     }
     $udata = $userModel->customQuery($sql);   
     if($udata){
      foreach($udata as $k=>$v){
          
          
          if($gwid=$v->gift_wrapping){
               $sql="select * from gift_wrapping where     id='$gwid' and status='Active' ";
       $gift_wrapping=$userModel->customQuery($sql); 
       $udata[$k]->gift_wrapping=$gift_wrapping[0];
          }else{
               $udata[$k]->gift_wrapping=array();
          }
          
          
       $img=[];
       $pid=$v->product_id;
       $sql="select * from product_image where     product='$pid' and status='Active' ";
       $product_image=$userModel->customQuery($sql); 
       if($product_image){
        foreach($product_image as $k2=>$v2){
         $img[]=base_url().'/assets/uploads/'.$v2->image; 
       }
     }
     $udata[$k]->product_image=$img;
   }
   $response = [
     'status' => 200,
     'error' => false,
     'messages' => '',
     'data' => $udata
   ];
   return $this->respondCreated($response);
 }else{
  $response = [
    'status' => 200,
    'error' => true,
    'messages' => 'Your cart is currently empty.',
    'data' => []
  ];
  return $this->respondCreated($response);   
}
}
}else{
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Invailid Token',
    'data' => []
  ];
  return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Access denied',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}else{
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Invailid Token',
    'data' => []
  ];
  return $this->respondCreated($response);  
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END User cart #####################
// ################## END User cart ##################### 
// ################## Start add user_address #####################
// ################## Start add user_address #####################
public function deleteUserAddress()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $rules = [
       "address_id" => "required" 
     ];
     $messages = ["address_id" => ["required" => "address_id is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    }
    else{
     if($pid=$this->request->getVar("address_id")){
      $sql="select * from user_address where user_id='$user_id' AND address_id='$pid'";
      $udata = $userModel->customQuery($sql);
      if($udata){
       $res=$userModel->do_action('user_address',$pid,'address_id','delete','',''); 
       $response = [
        'status' => 200,
        'error' => false,
        'messages' => 'Address removed from your address list',
        'data' => []
      ];
      return $this->respondCreated($response); 
    }else{
     $response = [
      'status' => 200,
      'error' => true,
      'messages' => 'Address not exist in user address list',
      'data' => []
    ];
    return $this->respondCreated($response);  
  }
}
}
}
else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add user_address #####################
// ################## END add user_address ##################### 
 // ################## Start add user_address #####################
// ################## Start add user_address #####################
public function addUserAddress()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $rules = [
       "apartment_house" => "required" ,
       "address" => "required" ,
       "name" => "required" ,
       "street" => "required" ,
     ];
     $messages = [
      "apartment_house" => ["required" => "apartment_house is required"],
      "name" => ["required" => "name is required"],
      "street" => ["required" => "street is required"],
      "address" => ["required" => "address is required"],
    ];
    if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
       'status' => 200,
       'error' => true,
       'messages' => $ht,
       'data' => []
     ];
     return $this->respondCreated($response); 
   }
   else{
    if($pid=$this->request->getVar("address")){
                // 
     if($pid=$this->request->getVar("address_id")){
       $p=$this->request->getVar();
       $sql="select * from user_address where user_id='$user_id' AND address_id='$pid'";
       $udata = $userModel->customQuery($sql);
       if($udata){
         if($this->request->getVar("status")=="Active"){
           $pd['status']="Inactive";
           $res1=$userModel->do_action('user_address',$user_id,'user_id','update',$pd,''); 
         }
         if($this->request->getVar("status")=="Active"){
           $pd['status']="Inactive";
           $res1=$userModel->do_action('user_address',$user_id,'user_id','update',$pd,''); 
         } 
         $res=$userModel->do_action('user_address',$pid,'address_id','update',$p,''); 
         $response = [
          'status' => 200,
          'error' => false,
          'messages' => 'Address updated successfully',
          'data' => []
        ];
        return $this->respondCreated($response); 
      }else{
       $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Address not exist in user address list',
        'data' => []
      ];
      return $this->respondCreated($response);  
    }
  }else{
                // 
   $p=$this->request->getVar();
   $p['user_id']=$user_id;
   if($this->request->getVar("status")=="Active"){
     $pd['status']="Inactive";
     $res1=$userModel->do_action('user_address',$user_id,'user_id','update',$pd,''); 
   }
   $res=$userModel->do_action('user_address','','','insert',$p,''); 
   $response = [
    'status' => 200,
    'error' => false,
    'messages' => 'Address successfully added to your user address list.',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}
}
}
else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add user_address #####################
// ################## END add user_address ##################### 
// ################## Start User user_address #####################
// ################## Start User user_address #####################
public function userAddressList()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
      $user_id=$decoded->data;
      $userModel = new UserModel();  
      $sql="SELECT  address_id,apartment_house,address,name,status,street FROM  user_address where user_id='$user_id' order by created_at desc";
      $udata = $userModel->customQuery($sql);   
      if($udata){
       $response = [
         'status' => 200,
         'error' => false,
         'messages' => '',
         'data' => $udata
       ];
       return $this->respondCreated($response);
     }else{
       $response = [
        'status' => 200,
        'error' => true,
        'messages' => 'Your  address list is currently empty.',
        'data' => []
      ];
      return $this->respondCreated($response);   
    }
  }else{
    $response = [
     'status' => 401,
     'error' => true,
     'messages' => 'Invailid Token',
     'data' => []
   ];
   return $this->respondCreated($response); 
 }
} catch (Exception $ex) {
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Access denied',
  'data' => []
];
return $this->respondCreated($response);
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid Token',
  'data' => []
];
return $this->respondCreated($response);  
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END User user_address #####################
// ################## END User user_address ##################### 
  // ################## Start add Wishlist #####################
// ################## Start add Wishlist #####################
public function deleteWishlist()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
       "wishlist_id" => "required" 
     ];
     $messages = ["wishlist_id" => ["required" => "wishlist_id is required"] ];
     if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
      'status' => 200,
      'error' => true,
      'messages' => $ht,
      'data' => []
    ];
    return $this->respondCreated($response); 
  }
  else{
    if($pid=$this->request->getVar("wishlist_id")){
     $sql="select * from wishlist where user_id='$user_id' AND id='$pid'";
     $udata = $userModel->customQuery($sql);
     if($udata){
      $res=$userModel->do_action('wishlist',$pid,'id','delete','',''); 
      $response = [
       'status' => 200,
       'error' => false,
       'messages' => 'Product removed from your wishlist',
       'data' => []
     ];
     return $this->respondCreated($response); 
   }else{
    $response = [
     'status' => 200,
     'error' => true,
     'messages' => 'Product not exist in wishlist',
     'data' => []
   ];
   return $this->respondCreated($response);  
 }
}
}
}
else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Access denied',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add Wishlist #####################
// ################## END add Wishlist ##################### 
 // ################## Start add Wishlist #####################
// ################## Start add Wishlist #####################
public function addWishlist()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
       "product_id" => "required" 
     ];
     $messages = ["product_id" => ["required" => "product_id is required"] ];
     if (!$this->validate($rules, $messages)) {
      $msg[0]='error';
      $ht="";
      foreach( $this->validator->getErrors() as $v){
       $ht=$ht." ".$v." ";
     }
     $response = [
      'status' => 200,
      'error' => true,
      'messages' => $ht,
      'data' => []
    ];
    return $this->respondCreated($response); 
  }
  else{
    if($pid=$this->request->getVar("product_id")){
     $sql="select * from wishlist where user_id='$user_id' AND product_id='$pid'";
     $udata = $userModel->customQuery($sql);
     if($udata){
      $response = [
       'status' => 200,
       'error' => true,
       'messages' => 'Product already in wishlist',
       'data' => []
     ];
     return $this->respondCreated($response);  
   }else{
     $p['product_id']=$pid;
     $p['user_id']=$user_id;
     $res=$userModel->do_action('wishlist','','','insert',$p,''); 
     $response = [
      'status' => 200,
      'error' => false,
      'messages' => 'Product successfully added to your wishlist.',
      'data' => []
    ];
    return $this->respondCreated($response);
  }
}
}
}
else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Access denied',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}else{
 $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END add Wishlist #####################
// ################## END add Wishlist ##################### 
// ################## Start User Wishlist #####################
// ################## Start User Wishlist #####################
public function userWishlist()
{
 $key=$this->ApiKeyValidation();
 if($key){ 
  $ApiKey = $this->request->header("ApiKey");
  if(!empty($this->request->header("Token")) ){
   $Token= $this->request->header("Token");
   $token = $Token->getValue();
   try {
    $decoded = JWT::decode($token, $key, array("HS256"));
    if ($decoded) {
     $user_id=$decoded->data;
     $userModel = new UserModel();  
     $rules = [
      "language" => "required" ];
      $messages = ["language" => ["required" => "language is required"] ];
      if (!$this->validate($rules, $messages)) {
        $msg[0]='error';
        $ht="";
        foreach( $this->validator->getErrors() as $v){
         $ht=$ht." ".$v." ";
       }
       $response = [
         'status' => 200,
         'error' => true,
         'messages' => $ht,
         'data' => []
       ];
       return $this->respondCreated($response); 
     } else {
       if($this->request->getVar("language")=="arabic"){
        $sql="select wishlist.id as wishlist_id,  products.product_id as product_id,
        products.arabic_name  as products_name,
        products.price  as price,
        products.available_stock as available_stock,
        products.discount_percentage as discount_percentage,
        products.arabic_description as products_description,
        products.arabic_feature as products_features,
        master_category.category_name_arabic as category_name,
        master_category.category_description_arabic as category_description
        from wishlist
        inner join products on wishlist.product_id=products.product_id
        inner join master_category on products.category=master_category.category_id
        where products.status='Active' AND wishlist.user_id='$user_id'";
      }else{
       $sql="select wishlist.id as wishlist_id,  products.product_id as product_id,
       products.name  as products_name,
       products.available_stock as available_stock, products.price  as price,
       products.discount_percentage as discount_percentage,
       products.description as products_description,
       products.features as products_features,
       master_category.category_name as category_name,
       master_category.category_description as category_description
       from wishlist
       inner join products on wishlist.product_id=products.product_id
       inner join master_category on products.category=master_category.category_id
       where products.status='Active' AND wishlist.user_id='$user_id'";
     }
     $udata = $userModel->customQuery($sql);   
     if($udata){
      foreach($udata as $k=>$v){
       $img=[];
       $pid=$v->product_id;
       $sql="select * from product_image where     product='$pid' and status='Active' ";
       $product_image=$userModel->customQuery($sql); 
       if($product_image){
        foreach($product_image as $k2=>$v2){
         $img[]=base_url().'/assets/uploads/'.$v2->image; 
       }
     }
     $udata[$k]->product_image=$img;
   }
   $response = [
     'status' => 200,
     'error' => false,
     'messages' => '',
     'data' => $udata
   ];
   return $this->respondCreated($response);
 }else{
  $response = [
   'status' => 200,
   'error' => true,
   'messages' => 'Your Wishlist is currently empty.',
   'data' => []
 ];
 return $this->respondCreated($response);   
}
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response); 
}
} catch (Exception $ex) {
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Access denied',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid Token',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid ApiKey',
  'data' => []
];
return $this->respondCreated($response);  
}
}
// ################## END User Wishlist #####################
// ################## END User Wishlist ##################### 
   // ################## Start filterList   #####################
// ################## Start filterList   #####################
public function filterList()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
    $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
        $sql="select id,arabic_title as title from color where status='Active'  ";
        $data['color'] = $userModel->customQuery($sql);
        $sql="select id,arabic_title as title,arabic_description as description,color_code from age where status='Active'  ";
        $data['age']  = $userModel->customQuery($sql);
        $sql="select id,arabic_title as title,image from brand where status='Active'  ";
        $data['brand']  = $userModel->customQuery($sql);
        $sql="select id,arabic_title as title from suitable_for where status='Active'  ";
        $data['suitable_for']  = $userModel->customQuery($sql);
      }else{
        $sql="select id,title from color where status='Active'  ";
        $data['color']  = $userModel->customQuery($sql);
        $sql="select id,title as title,description as description,color_code from age where status='Active'  ";
        $data['age']  = $userModel->customQuery($sql);
        $sql="select id,title,image from brand where status='Active'  ";
        $data['brand']  = $userModel->customQuery($sql);
        $sql="select id,title from suitable_for where status='Active'  ";
        $data['suitable_for']  = $userModel->customQuery($sql);
      }
      if($data['age']){
        foreach( $data['age'] as $k=>$v){
          if($v->image){
            $data['age'][$k]->image=base_url().'/assets/uploads/'.$v->image;
          }else {
            $data['age'][$k]->image=base_url().'/assets/uploads/noimg.png';
          }
        }
      } 
      if($data['brand']){
       foreach( $data['brand'] as $k=>$v){
         if($v->image){
           $data['brand'][$k]->image=base_url().'/assets/uploads/'.$v->image;
         }else {
           $data['brand'][$k]->image=base_url().'/assets/uploads/noimg.png';
         }
       }
     } 
     if (!empty($data)) {
       /* foreach($data as $k=>$v){
           if($v->image){
              $data[$k]->image=base_url().'/assets/uploads/'.$v->image;
           }else {
              $data[$k]->image=base_url().'/assets/uploads/noimg.png';
           }
         }*/
         $response = [
           'status' => 200,
           'error' => false,
           'messages' => '',
           'data' => $data
         ];
         return $this->respondCreated($response);  
       } else {
        $response = [
         'status' => 200,
         'error' => true,
         'messages' => 'colorList not found',
         'data' => []
       ];
       return $this->respondCreated($response);
     }
   }
 }else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END colorList Login #####################
// ################## END colorList Login #####################
  // ################## Start setting Login #####################
// ################## Start setting Login #####################
public function mobileBanner()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
   $sql="select * from mobile_banner where status='Active'   ";
   $data = $userModel->customQuery($sql);
   if (!empty($data)) {
    foreach($data as $k=>$v){
     if($v->image){
      $data[$k]->image=base_url().'/assets/uploads/'.$v->image; 
    }else {
      $data[$k]->image=base_url().'/assets/uploads/noimg.png'; 
    }
  } 
  $response = [
   'status' => 200,
   'error' => false,
   'messages' => '',
   'data' => $data
 ];
 return $this->respondCreated($response);  
} else {
  $response = [
   'status' => 200,
   'error' => true,
   'messages' => 'Mobile Banner not found',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END setting Login #####################
// ################## END setting Login #####################
 // ################## Start productList Login #####################
// ################## Start productList Login #####################
public function productList()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
      
      
      
       $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      
      
   $data = [];
   helper(['form','url']);
   if ($this->request->getMethod() == "post" ) {
       
        if($this->request->getVar("language")=="arabic"){
                $sql="select products.product_id as product_id,
    products.arabic_name  as products_name,price,
    products.available_stock as available_stock,
    products.discount_percentage as discount_percentage,
    products.arabic_description as products_description,
    products.arabic_feature as products_features,
    master_category.category_name_arabic as category_name,
    master_category.category_description_arabic as category_description
    from products 
    inner join master_category on products.category=master_category.category_id
    where products.status='Active' ";
        }else{
                $sql="select products.product_id as product_id,
    products.name  as products_name,price,
    products.available_stock as available_stock,
    products.discount_percentage as discount_percentage,
    products.description as products_description,
    products.features as products_features,
    master_category.category_name as category_name,
    master_category.category_description as category_description
    from products 
    inner join master_category on products.category=master_category.category_id
    where products.status='Active' ";
        }
   
   
    if ( @$this->request->getVar('offer')=="Yes") {
    if ($id1=@$this->request->getVar('offer')) {
     $sql=$sql."   AND  products.discount_percentage>0  ";
   }    }   

    if ($id1=@$this->request->getVar('category')) {
     $sql=$sql."   AND  products.category='$id1'  ";
   }
   if ($id1=$this->request->getVar('color')) {
     foreach($id1 as $k=>$v){
      $sql=$sql."   AND  products.color='$v'  ";
    }
  }
  if ($id1=$this->request->getVar('brand')) {
   foreach($id1 as $k=>$v){
    $sql=$sql."   AND  products.brand='$v'  ";
  }
}
if ($id1=$this->request->getVar('age')) {
 foreach($id1 as $k=>$v){
  $sql=$sql."   AND  products.age='$v'  ";
}
}
if ($id1=$this->request->getVar('suitable_for')) {
 foreach($id1 as $k=>$v){
  $sql=$sql."   AND  products.suitable_for='$v'  ";
}
}
if ($cat=$this->request->getVar('keyword')) {
 $sql=$sql."   AND  products.product_name like '%$cat%'  ";
}
if ($this->request->getVar('sort')=="Newest") {
 $sql=$sql."    order by created_at desc  ";
}
if ($this->request->getVar('sort')=="Oldest") {
 $sql=$sql."    order by created_at asc  ";
}
if ($this->request->getVar('sort')=="Highest") {
 $sql=$sql."    order by price desc  ";
}
if ($this->request->getVar('sort')=="Lowest") {
 $sql=$sql."    order by price asc  ";
}  
$data=$userModel->customQuery($sql); 
if (!empty($data)) {
 foreach($data as $k=>$v){
     
    if($data[$k]->discount_percentage>0){
         $data[$k]->discounted_price =  $data[$k]->price - (($data[$k]->price*$data[$k]->discount_percentage)/100);
    }else{
         $data[$k]->discounted_price =  $data[$k]->price;
    }
   
     
     
  $img=[];
  $pid=$v->product_id;
  $sql="select * from product_image where     product='$pid' and status='Active' ";
  $product_image=$userModel->customQuery($sql); 
  if($product_image){
   foreach($product_image as $k2=>$v2){
    $img[]=base_url().'/assets/uploads/'.$v2->image; 
  }
}
$data[$k]->product_image=$img;
}
$response = [
  'status' => 200,
  'error' => false,
  'messages' => '',
  'data' => $data
];
return $this->respondCreated($response);  
} else {
 $response = [
  'status' => 200,
  'error' => true,
  'messages' => 'product not found',
  'data' => []
];
return $this->respondCreated($response);
}
}else{
  $response = [
   'status' => 200,
   'error' => true,
   'messages' => 'product not found',
   'data' => []
 ];
 return $this->respondCreated($response);  
}

}

}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END productList Login #####################
// ################## END productList Login #####################
// ################## Start setting Login #####################
// ################## Start setting Login #####################
public function setting()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
   $sql="select * from settings   ";
   $data = $userModel->customQuery($sql);
   if (!empty($data)) {
    foreach($data as $k=>$v){
     if($v->logo){
      $data[$k]->logo=base_url().'/assets/uploads/'.$v->logo;
      $data[$k]->favicon=base_url().'/assets/uploads/'.$v->favicon;
    }else {
      $data[$k]->logo=base_url().'/assets/uploads/noimg.png';
      $data[$k]->favicon=base_url().'/assets/uploads/noimg.png';
    }
  } 
  $response = [
   'status' => 200,
   'error' => false,
   'messages' => '',
   'data' => $data[0]
 ];
 return $this->respondCreated($response);  
} else {
  $response = [
   'status' => 200,
   'error' => true,
   'messages' => 'settings not found',
   'data' => []
 ];
 return $this->respondCreated($response);
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END setting Login #####################
// ################## END setting Login #####################
  // ################## Start suitableFor Login #####################
// ################## Start suitableFor Login #####################
public function suitableFor()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
    $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
        $sql="select id,arabic_title as title from suitable_for where status='Active'  ";
      }else{
        $sql="select id,title from suitable_for where status='Active'  ";
      }
      $data = $userModel->customQuery($sql);
      if (!empty($data)) {
       /* foreach($data as $k=>$v){
           if($v->image){
              $data[$k]->image=base_url().'/assets/uploads/'.$v->image;
           }else {
              $data[$k]->image=base_url().'/assets/uploads/noimg.png';
           }
         }*/
         $response = [
           'status' => 200,
           'error' => false,
           'messages' => '',
           'data' => $data
         ];
         return $this->respondCreated($response);  
       } else {
        $response = [
         'status' => 200,
         'error' => true,
         'messages' => 'suitable_for not found',
         'data' => []
       ];
       return $this->respondCreated($response);
     }
   }
 }else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END suitableFor Login #####################
// ################## END suitableFor Login #####################
  // ################## Start colorList Login #####################
// ################## Start colorList Login #####################
public function colorList()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
    $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
        $sql="select id,arabic_title as title from color where status='Active'  ";
      }else{
        $sql="select id,title from color where status='Active'  ";
      }
      $data = $userModel->customQuery($sql);
      if (!empty($data)) {
       /* foreach($data as $k=>$v){
           if($v->image){
              $data[$k]->image=base_url().'/assets/uploads/'.$v->image;
           }else {
              $data[$k]->image=base_url().'/assets/uploads/noimg.png';
           }
         }*/
         $response = [
           'status' => 200,
           'error' => false,
           'messages' => '',
           'data' => $data
         ];
         return $this->respondCreated($response);  
       } else {
        $response = [
         'status' => 200,
         'error' => true,
         'messages' => 'colorList not found',
         'data' => []
       ];
       return $this->respondCreated($response);
     }
   }
 }else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END colorList Login #####################
// ################## END colorList Login #####################
 // ################## Start cityList Login #####################
// ################## Start cityList Login #####################
public function cityList()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
    $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
       $sql="select city_id,arabic_title as title , shipping_charges from city where status='Active'  ";
     }else{
      $sql="select city_id,title as title , shipping_charges from city where status='Active'  ";
    }
    $data = $userModel->customQuery($sql);
    if (!empty($data)) {
       /* foreach($data as $k=>$v){
           if($v->image){
              $data[$k]->image=base_url().'/assets/uploads/'.$v->image;
           }else {
              $data[$k]->image=base_url().'/assets/uploads/noimg.png';
           }
         }*/
         $response = [
           'status' => 200,
           'error' => false,
           'messages' => '',
           'data' => $data
         ];
         return $this->respondCreated($response);  
       } else {
        $response = [
         'status' => 200,
         'error' => true,
         'messages' => 'cityList not found',
         'data' => []
       ];
       return $this->respondCreated($response);
     }
   }
 }else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END cityList Login #####################
// ################## END cityList Login #####################
// ################## Start categoryList Login #####################
// ################## Start categoryList Login #####################
public function categoryList()
{
 $key =   $this->ApiKeyValidation();
 $userModel = new UserModel();
 if($key){
  $rules = [
   "language" => "required" ];
   $messages = ["language" => ["required" => "language is required"] ];
   if (!$this->validate($rules, $messages)) {
     $msg[0]='error';
     $ht="";
     foreach( $this->validator->getErrors() as $v){
      $ht=$ht." ".$v." ";
    }
    $response = [
      'status' => 200,
      'error' => true,
      'messages' => $ht,
      'data' => []
    ];
    return $this->respondCreated($response); 
  } else {
   $cid= $v->category_id;
   if($this->request->getVar("language")=="arabic"){
    if($parent_id=$this->request->getVar('parent_id')){
      $sql="select category_id,category_name_arabic as category_name,color_name,category_description_arabic as category_description from master_category where status='Active' AND parent_id='$parent_id'  ";  
    }else{
     $sql="select  category_id,category_name_arabic as category_name,color_name,category_description_arabic as category_description from master_category where status='Active'  ";
   }
 }else{
  if($parent_id=$this->request->getVar('parent_id')){
    $sql="select category_id,category_name,color_name,category_description from master_category where status='Active' AND parent_id='$parent_id'  ";  
  }else{
   $sql="select category_id,category_name,color_name,category_description from master_category where status='Active'  ";
 }
}
$data = $userModel->customQuery($sql);
if (!empty($data)) {
 foreach($data as $k=>$v){
  $img=[];
  $cid= $v->category_id;
  $sql="select * from category_image where status='Active' AND category='$cid'  ";
  $catImage = $userModel->customQuery($sql);
  if($catImage){
   foreach($catImage as $k2=>$v2){
    $img[]=base_url().'/assets/uploads/'.$v2->image; 
  }
}
else{
 $img[]=base_url().'/assets/uploads/noimg.png';  
}
$data[$k]->image=$img;
}
$response = [
 'status' => 200,
 'error' => false,
 'messages' => '',
 'data' => $data
];
return $this->respondCreated($response);  
} else {
 $response = [
  'status' => 200,
  'error' => true,
  'messages' => 'category not found',
  'data' => []
];
return $this->respondCreated($response);
}
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END categoryList Login #####################
// ################## END categoryList Login #####################
// ################## Start ageSlab Login #####################
// ################## Start ageSlab Login #####################
public function ageSlab()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
   $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
       $sql="select id,arabic_title as title,arabic_description as description,color_code from age where status='Active'  ";
     }else{
       $sql="select id,title as title,description as description,color_code from age where status='Active'  ";
     }
     $data = $userModel->customQuery($sql);
     if (!empty($data)) {
       $response = [
        'status' => 200,
        'error' => false,
        'messages' => '',
        'data' => $data
      ];
      return $this->respondCreated($response);  
    } else {
     $response = [
      'status' => 200,
      'error' => true,
      'messages' => 'Age Slab not found',
      'data' => []
    ];
    return $this->respondCreated($response);
  }
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END ageSlab Login #####################
// ################## END ageSlab Login #####################
// ################## Start brandList Login #####################
// ################## Start brandList Login #####################
public function brandList()
{
  $key =   $this->ApiKeyValidation();
  $userModel = new UserModel();
  if($key){
    $rules = [
     "language" => "required" ];
     $messages = ["language" => ["required" => "language is required"] ];
     if (!$this->validate($rules, $messages)) {
       $msg[0]='error';
       $ht="";
       foreach( $this->validator->getErrors() as $v){
        $ht=$ht." ".$v." ";
      }
      $response = [
        'status' => 200,
        'error' => true,
        'messages' => $ht,
        'data' => []
      ];
      return $this->respondCreated($response); 
    } else {
      if($this->request->getVar("language")=="arabic"){
        $sql="select id,arabic_title as title,image from brand where status='Active'  ";
      }else{
       $sql="select id,title,image from brand where status='Active'  ";
     }
     $data = $userModel->customQuery($sql);
     if (!empty($data)) {
       foreach($data as $k=>$v){
        if($v->image){
         $data[$k]->image=base_url().'/assets/uploads/'.$v->image;
       }else {
         $data[$k]->image=base_url().'/assets/uploads/noimg.png';
       }
     }
     $response = [
      'status' => 200,
      'error' => false,
      'messages' => '',
      'data' => $data
    ];
    return $this->respondCreated($response);  
  } else {
   $response = [
    'status' => 200,
    'error' => true,
    'messages' => 'brand list not found',
    'data' => []
  ];
  return $this->respondCreated($response);
}
}
}else{
  $response = [
   'status' => 401,
   'error' => true,
   'messages' => 'Invailid ApiKey',
   'data' => []
 ];
 return $this->respondCreated($response);  
}
}
// ################## END brandList Login #####################
// ################## END brandList Login #####################
    // ENCODING THE TOKEN
public function _jwt_encode_data($iss,$data){
  $this->token = array(
            //Adding the identifier to the token (who issue the token)
   "iss" => $iss,
   "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
   "iat" => $this->issuedAt,
            // Token expiration
   "exp" => $this->expire,
            // Payload
   "data"=> $data
 );
  $this->jwt = JWT::encode($this->token, $this->jwt_secrect);
  return $this->jwt;
}
    //DECODING THE TOKEN
public function _jwt_decode_data($jwt_token){
  try{
   $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
   return $decode->data;
 }
 catch(\Firebase\JWT\ExpiredException $e){
   return $e->getMessage();
 }
 catch(\Firebase\JWT\SignatureInvalidException $e){
   return $e->getMessage();
 }
 catch(\Firebase\JWT\BeforeValidException $e){
   return $e->getMessage();
 }
 catch(\DomainException $e){
   return $e->getMessage();
 }
 catch(\InvalidArgumentException $e){
   return $e->getMessage();
 }
 catch(\UnexpectedValueException $e){
   return $e->getMessage();
 }
}
public function index()
{
 /*       $token = $this->_jwt_encode_data(
    'http://localhost/php_jwt/',
    array("email"=>"john@email.com","id"=>21)
  );*/
  $key = 1;
  $userdata=1;
                    $iat = time(); // current timestamp value
                    $nbf = $iat + 10;
                    $exp = $iat + 3600;
                    $payload = array(
                      "iss" => "The_claim",
                      "aud" => "The_Aud",
                        "iat" => $iat, // issued at
                        "nbf" => $nbf, //not before in seconds
                        "exp" => $exp, // expire time in seconds
                        "data" => $userdata,
                      );
                    $token = JWT::encode($payload, $key);
                    print_r($token);
/*echo "<strong>Your Token is -</strong><br> $token";
 $data =  $this->_jwt_decode_data(trim($token));
    var_dump($data);
    echo "<br><hr>";*/
  } 
  public function register()
  {
    $rules = [
     "name" => "required",
     "email" => "required|is_unique[users.email]|min_length[6]",
     "phone_no" => "required",
     "password" => "required",
   ];
   $messages = [
     "name" => [
      "required" => "Name is required"
    ],
    "email" => [
      "required" => "Email required",
      "valid_email" => "Email address is not in format"
    ],
    "phone_no" => [
      "required" => "Phone Number is required"
    ],
    "password" => [
      "required" => "password is required"
    ],
  ];
  if (!$this->validate($rules, $messages)) {
   $response = [
    'status' => 200,
    'error' => true,
    'messages' => $this->validator->getErrors(),
    'data' => []
  ];
} else {
 $data = [
  "name" => $this->request->getVar("name"),
  "email" => $this->request->getVar("email"),
  "phone_no" => $this->request->getVar("phone_no"),
  "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT),
];
if ($userModel->insert($data)) {
  $response = [
   'status' => 200,
   "error" => false,
   'messages' => 'Successfully, user has been registered',
   'data' => []
 ];
} else {
  $response = [
   'status' => 200,
   "error" => true,
   'messages' => 'Failed to create user',
   'data' => []
 ];
}
}
return $this->respondCreated($response);
}
private function getKey($device)
{
  $userModel = new UserModel();
  $sql="select * from api_key where status='Active' AND device='$device'";
  $userdata = $userModel->customQuery($sql);
  return $userdata[0]->api_key;
}
public function ApiKeyValidation()
{
  $ApiKey = $this->request->header("ApiKey");
  $Device = $this->request->header("Device");
  if(!empty($this->request->header("ApiKey")) &&  !empty($this->request->header("Device"))){
   $key = $this->getKey($Device->getValue());
   if($ApiKey->getValue() == $key){
    return $key;exit;
  }else{
    return false;exit;
  }
}else{
 return false;exit;
}
}
// ################## Start User SIGNUP #####################
// ################## Start User SIGNUP #####################
public function userSignup()
{
  $key=$this->ApiKeyValidation();
  if($key){ 
   $data = [];
   helper(['form','url']);
   if ($this->request->getMethod() == "post") {
    $validation =  \Config\Services::validation();
    $rules = [
     "email" => [
      "label" => "email", 
      "rules" => "required|is_unique[users.email]"
    ],
    "name" => [
      "label" => "name", 
      "rules" => "required"
    ],
    "phone" => [
      "label" => "phone", 
      "rules" => "required"
    ],
    "password" => [
      "label" => "Password", 
      "rules" => "required"
    ],
    "confirm_password" => [
      "label" => "Confirm Password", 
      "rules" => "required|matches[password]"
    ]
  ];
  if ($this->validate($rules)) {
   $email=$this->request->getVar('email');
   $pass=base64_encode($this->request->getVar('password'));
   $p=$this->request->getVar();
   unset($p['confirm_password']);
   $p['user_id']=time();
   $p['password']=  $pass;
   $userModel = new UserModel();
   $res=$userModel->do_action('users','','','insert',$p,''); 
 /*  $response = [
    'status' => 200,
    'error' => false,
    'messages' => 'You Have Successfully Registered.',
    'data' => []
  ];
  return $this->respondCreated($response);*/
  /*######## user LOGING START ###########*/
  $userModel = new UserModel();
  $e=$this->request->getVar("email");
  $p=base64_encode($this->request->getVar("password"));
  $sql="select * from users where email='$e' AND password ='$p'";
  $userdata = $userModel->customQuery($sql);
  if (!empty($userdata)) {
    if ($userdata[0]->name) {
     $user_id=$userdata[0]->user_id;
     if($key){
                     $iat = time(); // current timestamp value
                     $nbf = $iat + 10;
                     $exp = $iat + 51840000000;
                     $payload = array(
                       "iss" => "sanjoobtoys.com",
                       "aud" => "The_Aud",
                        "iat" => $iat, // issued at
                        "nbf" => $nbf, //not before in seconds
                        "exp" => $exp, // expire time in seconds
                        "data" => $user_id,
                      );
                     $token = JWT::encode($payload, $key);
                     $response = [
                       'status' => 200,
                       'error' => false,
                       'messages' => 'User logged In successfully',
                       'data' => [
                        'token' => $token
                      ]
                    ];
                    return $this->respondCreated($response);
                  }else{
                    $response = [
                     'status' => 401,
                     'error' => true,
                     'messages' => 'Invailid ApiKey',
                     'data' => []
                   ];
                   return $this->respondCreated($response);  
                 }
               } else {
                 $response = [
                  'status' => 200,
                  'error' => true,
                  'messages' => 'Incorrect details',
                  'data' => []
                ];
                return $this->respondCreated($response);
              }
            } else {
              $response = [
               'status' => 200,
               'error' => true,
               'messages' => 'Oops, Something Went Wrong!',
               'data' => []
             ];
             return $this->respondCreated($response);
           }
           /* ###### USER LOGIN END ######## */
         } else {
           $msg[0]='error';
           $ht="";
           foreach($validation->getErrors() as $v){
            $ht=$ht." ".$v." ";
          }
          $response = [
            'status' => 200,
            'error' => true,
            'messages' => $ht,
            'data' => []
          ];
          return $this->respondCreated($response); 
        }
      } else {
        $response = [
         'status' => 200,
         'error' => true,
         'messages' => 'Invailid Method',
         'data' => []
       ];
       return $this->respondCreated($response); 
     }
   }else{
     $response = [
      'status' => 401,
      'error' => true,
      'messages' => 'Invailid ApiKey',
      'data' => []
    ];
    return $this->respondCreated($response); 
  }
}
// ################## END User SIGNUP #####################
// ################## END User SIGNUP #####################
// ################## Start User Login #####################
// ################## Start User Login #####################
public function userLogin()
{
  $key =   $this->ApiKeyValidation();
  $rules = [
   "email" => "required|min_length[6]",
   "password" => "required",
 ];
 $messages = [
   "email" => [
    "required" => "Email required",
    "valid_email" => "Email address is not in format"
  ],
  "password" => [
    "required" => "password is required"
  ],
];
if (!$this->validate($rules, $messages)) {
 $response = [
  'status' => 200,
  'error' => true,
  'messages' => $this->validator->getErrors(),
  'data' => []
];
return $this->respondCreated($response);
} else {
 $userModel = new UserModel();
 $e=$this->request->getVar("email");
 $p=base64_encode($this->request->getVar("password"));
 $sql="select * from users where email='$e' AND password ='$p'";
 $userdata = $userModel->customQuery($sql);
 if (!empty($userdata)) {
  if ($userdata[0]->name) {
   $user_id=$userdata[0]->user_id;
   if($key){
                     $iat = time(); // current timestamp value
                     $nbf = $iat + 10;
                     $exp = $iat + 51840000000;
                     $payload = array(
                       "iss" => "sanjoobtoys.com",
                       "aud" => "The_Aud",
                        "iat" => $iat, // issued at
                        "nbf" => $nbf, //not before in seconds
                        "exp" => $exp, // expire time in seconds
                        "data" => $user_id,
                      );
                     $token = JWT::encode($payload, $key);
                     $response = [
                       'status' => 200,
                       'error' => false,
                       'messages' => 'User logged In successfully',
                       'data' => [
                        'token' => $token
                      ]
                    ];
                    return $this->respondCreated($response);
                  }else{
                    $response = [
                     'status' => 401,
                     'error' => true,
                     'messages' => 'Invailid ApiKey',
                     'data' => []
                   ];
                   return $this->respondCreated($response);  
                 }
               } else {
                 $response = [
                  'status' => 200,
                  'error' => true,
                  'messages' => 'Incorrect details',
                  'data' => []
                ];
                return $this->respondCreated($response);
              }
            } else {
              $response = [
               'status' => 200,
               'error' => true,
               'messages' => 'User not found',
               'data' => []
             ];
             return $this->respondCreated($response);
           }
         }
       }
// ################## END User Login #####################
// ################## END User Login #####################
// ################## Start User Profile #####################
// ################## Start User Profile #####################
       public function userProfile()
       {
         $key=$this->ApiKeyValidation();
         if($key){ 
          $ApiKey = $this->request->header("ApiKey");
          if(!empty($this->request->header("Token")) ){
           $Token= $this->request->header("Token");
           $token = $Token->getValue();
           try {
            $decoded = JWT::decode($token, $key, array("HS256"));
            if ($decoded) {
             $user_id=$decoded->data;
             $userModel = new UserModel();
             $sql="select name,email,image,phone,city,address from users where user_id='$user_id' AND status ='Active'";
             $udata = $userModel->customQuery($sql);
             if($udata){
              $udata[0]->image=base_url().'/assets/uploads/'.$udata[0]->image;
              $response = [
               'status' => 200,
               'error' => false,
               'messages' => 'User details',
               'data' => $udata[0]
             ];
             return $this->respondCreated($response);
           }else{
            $response = [
             'status' => 200,
             'error' => true,
             'messages' => 'Something went wrong.',
             'data' => []
           ];
           return $this->respondCreated($response);   
         }
       }else{
         $response = [
          'status' => 401,
          'error' => true,
          'messages' => 'Invailid Token',
          'data' => []
        ];
        return $this->respondCreated($response); 
      }
    } catch (Exception $ex) {
      $response = [
       'status' => 401,
       'error' => true,
       'messages' => 'Access denied',
       'data' => []
     ];
     return $this->respondCreated($response);
   }
 }else{
   $response = [
    'status' => 401,
    'error' => true,
    'messages' => 'Invailid Token',
    'data' => []
  ];
  return $this->respondCreated($response);  
}
}else{
 $response = [
  'status' => 401,
  'error' => true,
  'messages' => 'Invailid ApiKey',
  'data' => []
];
return $this->respondCreated($response);  
}
}
// ################## END User Profile #####################
// ################## END User Profile ##################### 
}