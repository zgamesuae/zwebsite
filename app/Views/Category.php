<style>
.slider_center_four_items_s .owl-stage{margin:auto}.category_new_home_page_Design img{border-radius:4px;width:100%;object-fit:cover;object-position:center}body.page-category{background:#171717}
</style>
<?php

 $cdate=date("Y-m-d");
$userModel = model('App\Models\UserModel', false);
$session = session();
@$user_id=$session->get('userLoggedin'); 
$uri = service('uri'); 
$uri1=$uri2=$uri3="";
if(count(@$uri->getSegments())>0){
 $uri1=@$uri->getSegment(1); 
} 
if(count(@$uri->getSegments())>1){
 $uri2=@$uri->getSegment(2); 
} 
if(count(@$uri->getSegments())>2){
  $uri3=@$uri->getSegment(3);  
} 
if($uri2){
 $sql="select * from category_banner where status='Active' AND category_id='$uri2'   order by id desc";
 $banner=$userModel->customQuery($sql);
 $sql="select * from master_category where status='Active' AND parent_id='$uri2'  order by precedence asc ";
 $subcate=$userModel->customQuery($sql);
}
if($uri2=="playstation-1634548926"){
  $aid="accessories-1636468761";   
}else if($uri2=="xbox-1634548911"){
  $aid="accessories-1636468795";   
}else if($uri2=="nintendo-switch-1634548899"){
  $aid="accessories-1636468817";   
}












if ($cid=$aid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
/*   $sql="select id,title,count(product_id) as c  from brand
   inner join products on brand.id=products.brand
  
   where";
   foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }
  
  */
   $sql="select id,image,title,count(product_id) as c  from brand
   inner join products on brand.id=products.brand
  
   where";
  
     $Fla=0;$brandFlag=0;
    //  $sql=$sql." AND (";
  $sql=$sql."     FIND_IN_SET('$cid', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    
     if($brandFlag==1){
          $sql=$sql."  OR  FIND_IN_SET('$mv->category_id', products.category)      ";$brandFlag=0;
     }else{
          $sql=$sql."    FIND_IN_SET('$mv->category_id', products.category)    OR ";
     }
         
    
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
          $brandFlag=1;
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
  
  
  $sql=$sql."      group by brand.id";
  
  
  
  
}else{
  $sql="select id,image,title,count(product_id) as c  from brand
  inner join products on brand.id=products.brand
 
  where  FIND_IN_SET('$cid', products.category)   
  group by brand.id";
}
}else{
  $sql="select id,image,title,count(product_id) as c  from brand
  inner join products on brand.id=products.brand
 ";
  if ($keyword=$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 if ($t=$_GET['type']) {
   $sql=$sql."      where   $t in (products.type)  ";
 }
 
 
 $sql=$sql."  group by brand.id";
} 
 
@$brandsNew=$userModel->customQuery($sql);












$sql="select *     from products 
inner join trending_products on products.product_id=trending_products.product
where products.status='Active'
AND '$cdate' between trending_products.start_date  AND trending_products.end_date 
 ";
if ($id1=$uri2) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND (  FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
$sql=$sql." ) order by products.precedence desc limit 20";
 
$trending_products=$userModel->customQuery($sql); 





$sql="select brand     from products 
 
where products.status='Active' 
 ";
if ($id1=$aid) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND ( FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
$sql=$sql." )  group by brand  ";
//  echo $sql;
$accessories=$userModel->customQuery($sql); 

 


$sql="select *     from products 
 
where products.status='Active' 
 ";
if ($id1=$aid) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND ( FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
$sql=$sql.") order by products.precedence desc limit 20";
$access=$userModel->customQuery($sql); 

 




$sql="select *     from products 

where products.status='Active'
AND products.pre_order_enabled='Yes'
 ";
if ($id1=$uri2) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND  ( FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
 
$sql=$sql." ) order by products.precedence desc limit 20";
$preorder=$userModel->customQuery($sql); 





$sql="select *     from products 

where products.status='Active'

AND FIND_IN_SET(31, products.color) 
 ";
if ($id1=$uri2) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND ( FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
$sql=$sql." ) order by products.precedence desc limit 20";
$action=$userModel->customQuery($sql); 




$sql="select *     from products 

where products.status='Active'

AND 2 in (products.color) 
 ";
if ($id1=$uri2) {
 $sql2="select * from master_category where parent_id='$id1'";
 $mcat=$userModel->customQuery($sql2); 
 if($mcat){$Fla=0;
    //  $sql=$sql." AND (";
  $sql=$sql."   AND ( FIND_IN_SET('$id1', products.category)      OR ( "; 
  foreach($mcat as $km=>$mv){
    $scats=$mv->category_id;
    $sql2="select * from master_category where parent_id='$scats'";
    $ssmcat=$userModel->customQuery($sql2); 
    if($ssmcat){
     $Fla=1;
     foreach($ssmcat as $sbk=>$sbv){
      $lcat2=$sbv->category_id;
      if($sbk==count($ssmcat)-1){
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
     }else{
       $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
     }
   }
 }else{
  $lcat=$mv->category_id;
  if($km==count($mcat)-1){
    $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
  }else{
    if($Fla==1){$Fla==0;
     $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
   }else{
     $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
   }
 }
}
}
$sql=$sql."   ) ";
}else{
 $sql=$sql."   AND    FIND_IN_SET('$id1', products.category)  ";    
}
}
$sql=$sql." ) order by products.precedence desc limit 20";
$schooter=$userModel->customQuery($sql); 


?>
<div id="myCarousel" class="home_slider_boostrap carousel slide" data-ride="carousel">
 <ol class="carousel-indicators">
   <?php if($banner){ 
    foreach($banner as $k=>$v){?>
      <li data-target="#myCarousel" data-slide-to="<?php echo $k;?>" class="<?php if($k==0) echo 'active';?>"></li> 
    <?php }} ?>
  </ol>
  <div class="carousel-inner">
   <?php if($banner){ 
    foreach($banner as $k=>$v){?>
      <div class="carousel-item <?php if($k==0) echo 'active';?>">
          
       <div class="container-fluid p-0" id="banner_slider">
             <a href="<?php echo $v->link;?>" >
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="w-100 desltop_s_banner_home_sldier"  >
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" class="w-100 mobile_banner_home_sldier" style="display: none;" >
        </a>
       <?php
       if( $v->title){?>
        <div class="container" id="banner_overlay_text">
         <div class="row">
          <div class="col-md-6">
           <div class="banner_text_content">
            <h1><?php echo $v->title;?></h1>
            <div><?php echo $v->description;?></div>
            <div class="banner_button">
             <a href="<?php echo $v->link;?>" class="btn btn-primary">Buy Now</a>
             <!--<a href="<?php echo base_url();?>/product-list" class="btn btn-default">Live demo</a>-->
           </div>
         </div>
       </div>
     </div>
   </div>
   
   
   <?php } ?>
   
 </div>
</div>
<?php }} ?>
<a class="home_slider_indictes carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
 <span>‹</span>
</a>
<a class="home_slider_indictes carousel-control-next" href="#myCarousel" role="button" data-slide="next">
 <span>›</span>
</a>
</div>
</div>
<div class="container-fluid bg-black">
    <div class="container pt-4 pb-4">
 <div class="row">
  <div class="col-12">
   <div class="owl-carousel owl-theme slider_center_four_items_s">
    <?php 
    if($subcate){
     foreach($subcate as $k=>$v){ 
      $sql2="select * from category_image where category='$v->category_id'";
      $cimage=$userModel->customQuery($sql2); 
      ?>
      <div class="item">
       <div class="category_new_home_page_Design ">
        <div class="service_box">
         <a href="<?php echo base_url();?>/product-list?category=<?php echo $v->category_id;?>">
          <img src="<?php echo base_url();?>/assets/uploads/<?php if(@$cimage[0]->image) echo @$cimage[0]->image;else echo 'noimg.png';?>">
          <img src="<?php echo base_url();?>/assets/uploads/<?php if(@$cimage[0]->image) echo @$cimage[0]->image;else echo 'noimg.png';?>" alt="" class="mobile_image" style="display: none;">
          <div class="box_overlay_content">
           <h6><?php echo $v->category_name;?> 
           <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z"></path></svg></span></h6>
         </div>
       </a>
     </div>
   </div>
 </div>
<?php }} ?>
</div>
</div>
</div>
</div>
</div>
<?php if($trending_products){?>
 <div class="container-fluid  pt-4 best_offers_parent_con pb-4">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Trending Games</h2>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
   <div class="owl-carousel owl-theme category_list_home_page  ">
    <?php 
    if($trending_products){
     foreach($trending_products as $k=>$v){ 
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      ?>
      <div class="item">
        <div class="product_box shadow-none bg-white rounded ">
          <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
           <div class="product_box_image">
            <?php 
            if($v->discount_percentage > 0 ){
             ?>
             <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
           <?php } ?>
           <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
         </div>
       </a>
       <div class="product_box_content">
         <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
         <?php 
         if($v->discount_percentage > 0 ){
          ?>
          <div class="pricing-card">
           <div class="card-subtitle">
            <span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
          </span>
        </div>
        <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
      </div>
    <?php } else {
     ?>
     <div class="pricing-card">
      <div class="card-subtitle">
       <span> <span>  &nbsp </span>
     </span>
   </div>
   <p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
 </div>
 <?php
}?>
<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
  <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
  <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
  <div class="product_qty">
   <input name="quantity" type="number" value="1" required min="1" >
 </div>
 <?php if(@$v->available_stock>0){?><?php 
   ?>
   <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
   <?php  
 }else{
  ?>
  <button disabled class="btn btn-primary">Out of stock</button>
  <?php
}
?>
<?php
if($user_id){
  $pid=$v->product_id;
  $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
  $pwishlist=$userModel->customQuery($sql); 
  ?>
  <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
  <?php
}else{
 ?>
 <a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
</a>
<?php
}
?>
</form>
</div>
</div>
</div>
<?php }} ?>
</div>
</div>
</div>
</div>
<?php } ?>
<?php if($access){?>
 <div class="container-fluid  pt-4 best_offers_parent_con bg-black pb-4">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Best in gaming gear</h2>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
   <div class="owl-carousel owl-theme category_list_home_page  ">
    <?php 
    if($access){
     foreach($access as $k=>$v){ 
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      ?>
      <div class="item">
        <div class="product_box shadow-none bg-white rounded ">
          <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
           <div class="product_box_image">
            <?php 
            if($v->discount_percentage > 0 ){
             ?>
             <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
           <?php } ?>
           <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
         </div>
       </a>
       <div class="product_box_content">
         <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
         <?php 
         if($v->discount_percentage > 0 ){
          ?>
          <div class="pricing-card">
           <div class="card-subtitle">
            <span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
          </span>
        </div>
        <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
      </div>
    <?php } else {
     ?>
     <div class="pricing-card">
      <div class="card-subtitle">
       <span> <span>  &nbsp </span>
     </span>
   </div>
   <p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
 </div>
 <?php
}?>
<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
  <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
  <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
  <div class="product_qty">
   <input name="quantity" type="number" value="1" required min="1" >
 </div>
 <?php if(@$v->available_stock>0){?><?php 
   ?>
   <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
   <?php  
 }else{
  ?>
  <button disabled class="btn btn-primary">Out of stock</button>
  <?php
}
?>
<?php
if($user_id){
  $pid=$v->product_id;
  $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
  $pwishlist=$userModel->customQuery($sql); 
  ?>
  <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
  <?php
}else{
 ?>
 <a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
</a>
<?php
}
?>
</form>
</div>
</div>
</div>
<?php }} ?>
</div>
</div>
</div>
</div>
<?php } ?>
<?php if($preorder){?>
 <div class="container-fluid  pt-4 best_offers_parent_con pb-4">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Pre orders</h2>
     <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&pre-order=enabled" class="right_posiation_buttton bnt btn-primary">View All</a>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
   <div class="owl-carousel owl-theme category_list_home_page  ">
    <?php 
    if($preorder){
     foreach($preorder as $k=>$v){ 
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      ?>
      <div class="item">
        <div class="product_box shadow-none bg-white rounded ">
          <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
           <div class="product_box_image">
            <?php 
            if($v->discount_percentage > 0 ){
             ?>
             <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
           <?php } ?>
           <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
         </div>
       </a>
       <div class="product_box_content">
         <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
         <?php 
         if($v->discount_percentage > 0 ){
          ?>
          <div class="pricing-card">
           <div class="card-subtitle">
            <span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
          </span>
        </div>
        <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
      </div>
    <?php } else {
     ?>
     <div class="pricing-card">
      <div class="card-subtitle">
       <span> <span>  &nbsp </span>
     </span>
   </div>
   <p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
 </div>
 <?php
}?>
<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
  <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
  <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
  <div class="product_qty">
   <input name="quantity" type="number" value="1" required min="1" >
 </div>
 <?php if(@$v->available_stock>0){?><?php 
   ?>
   <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
   <?php  
 }else{
  ?>
  <button disabled class="btn btn-primary">Out of stock</button>
  <?php
}
?>
<?php
if($user_id){
  $pid=$v->product_id;
  $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
  $pwishlist=$userModel->customQuery($sql); 
  ?>
  <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
  <?php
}else{
 ?>
 <a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
</a>
<?php
}
?>
</form>
</div>
</div>
</div>
<?php }} ?>
</div>
</div>
</div>
</div>
<?php } ?>
<?php if(1){?>
 <div class="container-fluid  pt-4 best_offers_parent_con bg-black pt-4 pb-4">
  <div class="row justify-content-center">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Shop games by price</h2>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
    <div class="owl-carousel owl-theme category_severn_box_sliders arrow_center_cate_slider_point">
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=25">
               <h1>up to</h1>
               <h2>25 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=50">
               <h1>up to</h1>
               <h2>50 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=100">
               <h1>up to</h1>
               <h2>100 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=150">
               <h1>up to</h1>
               <h2>150 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=200">
               <h1>up to</h1>
               <h2>200 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=250">
               <h1>up to</h1>
               <h2>250 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
        <div class="item">
             <div class="shop_by_games_box">
              <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&priceupto=300">
               <h1>up to</h1>
               <h2>300 <span class="text-uppercase"><?php echo CURRENCY ?></span></h2>
             </a>
           </div>
        </div>
    </div>
</div>
</div>
</div>
<?php } ?>
<?php 
/*
if($accessories){
 ?>
<!-- <div class="container-fluid  pt-4 best_offers_parent_con pb-4">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Shop Accessories by brand</h2>
   </div>
 </div>
 <div class="col-12  mt-3 overflow-hidden ">
  <div class="owl-carousel owl-theme category_list_home_page  ">
   <?php 
   if($accessories){
    foreach($accessories as $k=>$v){ 
     $pid=$v->product_id;
     $sql="select * from  brand where id='$v->brand' and status='Active' ";
     $bdetail=$userModel->customQuery($sql); 
     ?>
     <div class="item">
      <div class="shop_accessies_by_brand">
       <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&brand=<?php echo $v->brand;?>">
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $bdetail[0]->image;?>" alt="">
      </a>
    </div>  
  </div>
<?php }} ?>
</div>
</div>
</div>
</div>-->
<?php } */ ?>

<?php if($brandsNew){?>
<div class="container-fluid bg-light pt-4 pb-4 shop_brand_shop_by">
    <div class="row">
        <div class="col-md-12">
            <div class="heading_design_four mb-4 text-center text-capitalize">
                <h2><b>Shop Accessories by brand</b></h2>
                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>
        <div class="col-12 pl-2 mb-2">
            <div class="owl-carousel owl-theme two_rows_grid_sliders arrow_center_cate_slider_point">
               
               
                <?php 
   if($brandsNew){
    foreach($brandsNew as $k=>$v){ 
   /*  $pid=$v->product_id;
     $bid=$v->brand;
     $sql="select * from  brand where id='$bid' and status='Active' ";
     $bdetail=$userModel->customQuery($sql);*/ 
     ?>
                <div class="item">
                    <div class="new_design_box_categoryies shadow-sm bg-white border rounded">
                         <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&brand=<?php echo $v->id;?>">
                            <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>"> 
                        </a>
                    </div>
                </div>
                
                <?php }} ?>
                  
              
            </div>
        </div>
        
 
    </div>
</div>
<?php } ?>

<?php if($action){?>
 <div class="container-fluid  pt-4 best_offers_parent_con pb-4 bg-black">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Action Games</h2>
     <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&genre=31" class="right_posiation_buttton bnt btn-primary">View All</a>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
   <div class="owl-carousel owl-theme category_list_home_page  ">
    <?php 
    if($action){
     foreach($action as $k=>$v){ 
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      ?>
      <div class="item">
        <div class="product_box shadow-none bg-white rounded ">
          <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
           <div class="product_box_image">
            <?php 
            if($v->discount_percentage > 0 ){
             ?>
             <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
           <?php } ?>
           <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
         </div>
       </a>
       <div class="product_box_content">
         <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
         <?php 
         if($v->discount_percentage > 0 ){
          ?>
          <div class="pricing-card">
           <div class="card-subtitle">
            <span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
          </span>
        </div>
        <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
      </div>
    <?php } else {
     ?>
     <div class="pricing-card">
      <div class="card-subtitle">
       <span> <span>  &nbsp </span>
     </span>
   </div>
   <p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
 </div>
 <?php
}?>
<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
  <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
  <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
  <div class="product_qty">
   <input name="quantity" type="number" value="1" required min="1" >
 </div>
 <?php if(@$v->available_stock>0){?><?php 
   ?>
   <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
   <?php  
 }else{
  ?>
  <button disabled class="btn btn-primary">Out of stock</button>
  <?php
}
?>
<?php
if($user_id){
  $pid=$v->product_id;
  $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
  $pwishlist=$userModel->customQuery($sql); 
  ?>
  <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
  <?php
}else{
 ?>
 <a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
</a>
<?php
}
?>
</form>
</div>
</div>
</div>
<?php }} ?>
</div>
</div>
</div>
</div>
<?php } ?>
<?php if($schooter){?>
 <div class="container-fluid  pt-4 best_offers_parent_con pb-4">
  <div class="row">
   <div class="col-12">
    <div class="heading heading_design_2 text-dark " >
     <h2 class="text-white">Shooter Games</h2>
     <a href="<?php echo base_url();?>/product-list?category=<?php echo $uri2;?>&genre=2" class="right_posiation_buttton bnt btn-primary">View All</a>
   </div>
 </div>
 <div class="col-12 mt-3 overflow-hidden ">
   <div class="owl-carousel owl-theme category_list_home_page  ">
    <?php 
    if($schooter){
     foreach($schooter as $k=>$v){ 
      $pid=$v->product_id;
      $sql="select * from product_image where     product='$pid' and status='Active' ";
      $product_image=$userModel->customQuery($sql); 
      ?>
      <div class="item">
        <div class="product_box shadow-none bg-white rounded ">
          <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
           <div class="product_box_image">
            <?php 
            if($v->discount_percentage > 0 ){
             ?>
             <div class="product_label_offer"><?php echo $v->discount_percentage;?>% off</div>
           <?php } ?>
           <img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
         </div>
       </a>
       <div class="product_box_content">
         <h5><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo $v->name;?></a></strong></h5>
         <?php 
         if($v->discount_percentage > 0 ){
          ?>
          <div class="pricing-card">
           <div class="card-subtitle">
            <span><?php echo number_format($v->price);?><span> <?php echo CURRENCY ?> </span>
          </span>
        </div>
        <p class="offer-price card-text"><?php echo number_format($v->price - ($v->discount_percentage*$v->price)/100);?><span><?php echo CURRENCY ?></span></p>
      </div>
    <?php } else {
     ?>
     <div class="pricing-card">
      <div class="card-subtitle">
       <span> <span>  &nbsp </span>
     </span>
   </div>
   <p class="offer-price card-text"><?php echo number_format($v->price);?><span><?php echo CURRENCY ?></span></p>
 </div>
 <?php
}?>
<form class="products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
  <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
  <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
  <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
  <input name="discount_percentage" type="hidden" value="<?php echo $v->discount_percentage;?>" required  >
  <input name="pre_order_before_payment_percentage" type="hidden" value="<?php echo $v->pre_order_before_payment_percentage;?>" required  >
  <input name="pre_order_enabled" type="hidden" value="<?php echo $v->pre_order_enabled;?>" required  >
  <div class="product_qty">
   <input name="quantity" type="number" value="1" required min="1" >
 </div>
 <?php if(@$v->available_stock>0){?><?php 
   ?>
   <button type="submit" class="btn btn-primary"><?php if($v->pre_order_enabled=="Yes") echo 'Pre Order';else echo 'Add To Cart';?></button>
   <?php  
 }else{
  ?>
  <button disabled class="btn btn-primary">Out of stock</button>
  <?php
}
?>
<?php
if($user_id){
  $pid=$v->product_id;
  $sql="select * from wishlist where     product_id='$pid' and user_id='$user_id' ";
  $pwishlist=$userModel->customQuery($sql); 
  ?>
  <a class="<?php echo $v->product_id;?>  <?php if($pwishlist) echo 'active';?>" href="javascript:void(0);" onClick="addToWishlist('<?php echo $v->product_id;?>','<?php echo $v->name;?>','<?php if($product_image[0]->image) echo $product_image[0]->image; ?>');">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
  </a>
  <?php
}else{
 ?>
 <a href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"></path><path d="M12.001 4.529c2.349-2.109 5.979-2.039 8.242.228 2.262 2.268 2.34 5.88.236 8.236l-8.48 8.492-8.478-8.492c-2.104-2.356-2.025-5.974.236-8.236 2.265-2.264 5.888-2.34 8.244-.228zm6.826 1.641c-1.5-1.502-3.92-1.563-5.49-.153l-1.335 1.198-1.336-1.197c-1.575-1.412-3.99-1.35-5.494.154-1.49 1.49-1.565 3.875-.192 5.451L12 18.654l7.02-7.03c1.374-1.577 1.299-3.959-.193-5.454z"></path></svg>
</a>
<?php
}
?>
</form>
</div>
</div>
</div>
<?php 
}
}
?>
</div>
</div>
</div>
</div>
<?php } ?>
<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize" >
 <div class="container p-0">
  <div class="row">
   <div class="col-md-8 mt-2">
    <div class="heading">
     <h3 class="text-white">Subscribe to our newsletter</h3>
   </div>
 </div>
 <div class="col-md-4 mt-2">
  <?php  
  if(@$flashData['success']){?>
    <p style="margin-bottom: 0;
    padding-bottom: 10px;
    color: #fff;
    font-weight: 500;"><?php echo $flashData['success'];?></p>
  <?php } ?>
  <form method="post" class="d-flex" action="<?php echo base_url();?>/page/newsletter">
    <input type="email" placeholder="Email Adderess" required name="email">
    <button type="submit" class="btn btn-primary">Subscribe</button>
  </form>
</div>
</div>
</div>
</div>