<style>
  .slidecontainer{width:100%}.sliderr{-webkit-appearance:none;appearance:none;width:100%;height:25px;background:#d3d3d3;outline:0;opacity:.7;-webkit-transition:.2s;transition:opacity .2s}.sliderr:hover{opacity:1}.sliderr::-webkit-slider-thumb{-webkit-appearance:none;appearance:none;width:25px;height:25px;background:#04aa6d;cursor:pointer}.sliderr::-moz-range-thumb{width:25px;height:25px;background:#04aa6d;cursor:pointer}.filter_btns a{width:100%;text-align:center}.filter_btns{padding:15px 0}@media screen and (max-width:600px){.bg-light{background-color:#efefef!important}p-10px{padding:3px 6px!important;margin-bottom:3px!important}.pricing-card .card-text{font-size:21px}.product_box_content{padding:4px 4px}.product_qty{display:none}form.products_add_to_cart button{height:unset}form.products_add_to_cart a{width:unset;padding:7px 3px}form.products_add_to_cart button{font-size:12px!important}.product_box_image .product_label_offer{left:7px}.outer_container_div{overflow-x:hidden}}.drop_down_sort_by_option{z-index:9!important}.drop_down_sort_by_option::after{left:75%}@media only screen and (max-width:600px){.drop_down_sort_by_option::after{left:14px}}
</style>
<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
}
$cid="";
$sql="select * from settings";
$settings=$userModel->customQuery($sql);
$sql="select * from cms";
$cms=$userModel->customQuery($sql);
$sql1="";
$uri1=$uri2=$uri3="";
$request = \Config\Services::request();
if($cid= @$_GET['category']){
  $sql1="  ";
  $sql1= "select * from master_category where  parent_id= '$cid'";
  $cat2=$userModel->customQuery($sql1); 
} 
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="select type_id,title,count(product_id) as c from type
   inner join products on type.type_id=products.type
  
   where";
  /* foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
  
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
  
  $sql=$sql."      group by type.type_id";
}else{
  $sql="select type_id,title,count(product_id) as c from type
  inner join products on type.type_id=products.type
 
  where  FIND_IN_SET('$cid', products.category)   
  group by type.type_id";
}
}else{
  $sql="select type_id,title,count(product_id) as c from type
  inner join products on type.type_id=products.type
  ";
  if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 
  if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 
 
 
 $sql=$sql."  group by type.type_id";
}
 
@$type=$userModel->customQuery($sql);
if ($cid) {
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
   $sql="select id,title,count(product_id) as c  from brand
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
  $sql="select id,title,count(product_id) as c  from brand
  inner join products on brand.id=products.brand
 
  where  FIND_IN_SET('$cid', products.category)   
  group by brand.id";
}
}else{
  $sql="select id,title,count(product_id) as c  from brand
  inner join products on brand.id=products.brand
 ";
  if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 
 $sql=$sql."  group by brand.id";
} 
 
@$brand=$userModel->customQuery($sql);
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="select id,title,count(product_id) as c  from suitable_for
   inner join products on suitable_for.id=products.suitable_for
  
   where";
   /*foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
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
  
  $sql=$sql."       group by suitable_for.id";
}else{
 $sql="
 select id,title,count(product_id) as c  from suitable_for
 inner join products on suitable_for.id=products.suitable_for

 where 
 FIND_IN_SET('$cid', products.category)    
 
 group by suitable_for.id
 ";
}
}else{
 $sql="
 select id,title,count(product_id) as c  from suitable_for
 inner join products on suitable_for.id=products.suitable_for

 ";
 if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 if ($b=@$_GET['brand']) {
   $sql=$sql."   where  products.brand = '$b'  ";
 }
 
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 $sql=$sql."  group by suitable_for.id
 ";
}
@$suitable_for=$userModel->customQuery($sql);
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="  select id,title,count(product_id) as c  from color
   inner join products on  FIND_IN_SET(color.id , products.color)  
  
   where";
  /* foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
  
  
  
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
  
  
  
  
  
  $sql=$sql."        group by color.id";
}else{
 $sql="
 select id,title,count(product_id) as c  from color
 inner join products on  FIND_IN_SET(color.id , products.color) 

 where 
 
  FIND_IN_SET('$cid', products.category)   
 group by color.id
 ";
}
}else{
 $sql="
 select id,title,count(product_id) as c  from color
 inner join products on  FIND_IN_SET(color.id , products.color) 

 ";
 if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 
 if ($b=@$_GET['brand']) {
   $sql=$sql."   where  products.brand = '$b'  ";
 }
 
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 $sql=$sql."  group by color.id
 ";
}
@$color=$userModel->customQuery($sql);
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="   select id,title,count(product_id) as c  from age
   inner join products on age.id=products.age
  
   where";
  /* foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
  
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
  
  if ($b=@$_GET['brand']) {
   $sql=$sql."    AND  products.brand = '$b'  ";
 }
  
  $sql=$sql."         group by age.id";
}else{
 $sql="
 select id,title,count(product_id) as c  from age
 inner join products on age.id=products.age

 where  FIND_IN_SET('$cid', products.category)   
 group by age.id
 ";
} 
}else{
 $sql="
 select id,title,count(product_id) as c  from age
 inner join products on age.id=products.age

 ";
 if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 
  if ($b=@$_GET['brand']) {
   $sql=$sql."   where  products.brand = '$b'  ";
 }
 
 
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 $sql=$sql."   group by age.id
 ";
}
 
@$age=$userModel->customQuery($sql);
// categorylist start
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="select category_id,category_name,count(product_id) as c from master_category  
   inner join products on master_category.category_id=products.category
   where";
 /*  foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
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
  
  
  
  $sql=$sql."      group by master_category.category_id";
}else{
 $sql="select category_id,category_name,count(product_id) as c from master_category  
 inner join products on master_category.category_id=products.category
 where  FIND_IN_SET('$cid', products.category)   
 group  group by master_category.category_id";
}
}else{
 $sql="select category_id,category_name,count(product_id) as c from master_category  
 inner join products on master_category.category_id=products.category";
 if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 $sql=$sql."   group by master_category.category_id";
}
@$LeftCat=$userModel->customQuery($sql);
// categorylist end



















if($cid= @$_GET['category']){
  $sql1="  ";
  $sql1= "select * from master_category where  parent_id= '$cid'";
  $cat2=$userModel->customQuery($sql1); 
} 
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="select type_id,title,count(product_id) as c from type
   inner join products on type.type_id=products.type
  
   where";
  /* foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."       products.category='$lcat'   ";   
    }else{
      $sql=$sql."       products.category='$lcat' OR ";     
    }
  }*/
  
  
  
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
}else{
  $sql="select type_id,title,count(product_id) as c from type
  inner join products on type.type_id=products.type
 
  where  FIND_IN_SET('$cid', products.category)    ";
}
}else{
  $sql="select type_id,title,count(product_id) as c from type
  inner join products on type.type_id=products.type
  ";
  if ($keyword=@$_GET['keyword']) {
   $sql=$sql."   where  products.name like '%$keyword%'  ";
 }
 
  if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 
 
 
}
 
 $sql=$sql." AND type.type_id=5";

@$freebiChecking=$userModel->customQuery($sql);

?>  
<div class="container-fluid bg-lightt p-0">
  <?php include 'Common/Breadcrumb.php';?>
  <div class="container outer_container_div pb-5">
    <div class="m-10px row">
<!--     <div class="p-10px col-md-12 mt-3">
<div class="col-xs-12 ry-pg-title rounded overflow-hidden" style="background-image: url('img/notfound.jpg'); background-size: cover;">
<div class="col-xs-12 ry-container" style="position: relative;"><div>
<h1 class="ry-responsive-title"><strong>Super Savings!</strong></h1>
</div>
</div>
</div>
</div> -->
<div class="p-10px col-lg-3 mb-2 ">
  <div class="mobile_search_products d-block d-lg-none" >
    <div class="icon_filter_m border" id="filter_open_mobile">
      <span>Filter by</span>
      <svg viewBox="0 0 16 13" id="icon-filter" xmlns="http://www.w3.org/2000/svg"><path d="M.3 2.395h9.458c.177.888.977 1.618 1.955 1.618.978 0 1.778-.73 1.956-1.618h2.026c.16 0 .302-.107.302-.267 0-.16-.142-.267-.301-.267h-2.01c-.124-1.066-.959-1.76-1.973-1.76-1.013 0-1.867.694-1.974 1.76H.3c-.16 0-.302.107-.302.267 0 .16.142.267.302.267zM11.713.652c.765 0 1.387.622 1.387 1.387s-.622 1.387-1.387 1.387a1.388 1.388 0 0 1-1.387-1.387A1.39 1.39 0 0 1 11.713.652zm3.983 5.654c.16 0 .302.107.302.266 0 .16-.142.267-.302.267H7.589c-.178.889-.978 1.618-1.955 1.618-.978 0-1.778-.73-1.956-1.618H.3c-.16 0-.302-.107-.302-.267 0-.16.143-.266.302-.266h3.36c.125-1.067.96-1.76 1.974-1.76 1.013 0 1.849.693 1.973 1.76h8.089zM5.634 7.87c.764 0 1.386-.622 1.386-1.387 0-.764-.622-1.386-1.386-1.386-.765 0-1.387.622-1.387 1.386 0 .765.622 1.387 1.387 1.387zm10.062 2.88c.16 0 .302.107.302.267 0 .16-.142.266-.302.266h-4.054c-.177 1.067-.977 1.618-1.955 1.618-.978 0-1.778-.551-1.956-1.618H.301c-.16 0-.303-.107-.303-.266 0-.16.143-.267.302-.267h7.413c.107-1.067.96-1.76 1.974-1.76s1.85.693 1.974 1.76h4.035zm-6.01 1.582c.765 0 1.388-.622 1.388-1.387s-.623-1.387-1.387-1.387c-.765 0-1.387.622-1.387 1.387s.622 1.387 1.387 1.387z" fill-rule="evenodd"></path></svg>
    </div>
  </div>
  <div class="product_filter rounded bg-white shadow-none ">
    <form action="<?php echo base_url();?>/page/getSearchData" method="post" id="getsearchform"> 
      <h4 class="pt-3 pb-0 d-block d-lg-none "><strong>Filter </strong> <div class="close_serach_products" >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"></path></svg>
      </div></h4>
      <div class="filter_btns">
        <a href="<?php echo base_url();?>/product-list?category=<?php echo @@$_GET['category']?>"    class="JagatFilterInput">clear all filter</a>
      </div>
<!--     <div class="filter_header border-bottom">search component
<div class="serach_fomr_input">
<input type="text" name="searchpro" id="seacrh_pro" placeholder="search..">
</div>
</div>-->
<input name="showOffer" id="showOffer" type="hidden" value="<?php echo @@$_GET['show-offer'];?>" >
<input name="short" id="short" type="hidden" value="<?php echo @@$_GET['short'];?>" >
<input name="keyword" id="keyword" type="hidden" value="<?php echo @@$_GET['keyword'];?>" >
<input name="master_category" id="master_category" type="hidden" value="<?php echo @$cid;?>" >
<?php if($cid){ ?>
<?php if(@$LeftCat7){ ?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Categories</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body" style="display: none;">
    <div class="multilavel_drop_down">
      <ul>
       <?php 
         foreach($LeftCat as $k=>$v){
// categorylist start
          if ($cid2=$v->category_id) {
            $sql2="select * from master_category where parent_id='$cid2'";
            $mcat=$userModel->customQuery($sql2); 
            if($mcat){
             $sql="select category_id,category_name,count(product_id) as c from master_category  
             inner join products on master_category.category_id=products.category
             where";
            /* foreach($mcat as $km=>$mv){
              $lcat=$mv->category_id;
              if($km==count($mcat)-1){
                $sql=$sql."       products.category='$lcat'   ";   
              }else{
                $sql=$sql."       products.category='$lcat' OR ";     
              }
            }*/
            
            
            
            
     $Fla=0;$brandFlag=0;
    //  $sql=$sql." AND (";
  $sql=$sql."     FIND_IN_SET('$cid2', products.category)      OR ( "; 
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
            
            
            
            
            
            $sql=$sql."      group by master_category.category_id";
          }else{
           $sql="select category_id,category_name,count(product_id) as c from master_category  
           inner join products on master_category.category_id=products.category
           where  
            FIND_IN_SET('$cid2', products.category)   
           group  group by master_category.category_id";
         }
       }else{
         $sql="select category_id,category_name,count(product_id) as c from master_category  
         inner join products on master_category.category_id=products.category";
         if ($keyword=@$_GET['keyword']) {
           $sql=$sql."   where  products.name like '%$keyword%'  ";
         }
         
         if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
         
         $sql=$sql."   group by master_category.category_id";
       }
       @$LeftCat2=$userModel->customQuery($sql);
// categorylist end
       ?>
       <li data_open_id="open_drop_down_32">
         <label class="checkbox_label"><?php echo $v->category_name;?> 
         <!--(<?php echo $v->c;?>)-->
           <input <?php if(@@$_GET['category']== $v->category_id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="categoryList" value="<?php echo $v->category_id;?>" name="categoryList">
           <span class="checkmark"></span>
         </label>
         <div class="drop_down_ion"></div>
       </li>
       <?php
       if($LeftCat2){
         foreach($LeftCat2 as $k2=>$v2){  
           ?>
           <div id="open_drop_down_32">
             <ul>
               <li>
                <label class="checkbox_label"><?php echo $v2->category_name;?> 
                <!--(<?php echo $v2->c;?>)-->
                 <input <?php if(@@$_GET['category']== $v2->category_id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="categoryList" value="<?php echo $v2->category_id;?>" name="categoryList">
                 <span class="checkmark"></span>
               </label>  
             </li> 
           </ul>
         </div>
         <?php
       }
      
   }
 }
 ?>
</ul>
</div>
</div>
</div>

<?php } }?>
<?php  if($type){ ?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Type</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body" style="display:<?php if(@@$_GET['type']) echo 'block';else echo 'none'?>;">
    <ul>
      <?php
     
        foreach($type as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->title;?> 
            <!--(<?php echo $v->c;?>)-->
              <input <?php if(@@$_GET['type']== $v->type_id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="type" value="<?php echo $v->type_id;?>" name="type">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        }
      
      ?> 
    </ul>
  </div>
</div>
<?php } ?>
<?php   if($brand){?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Brands</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['brand']) echo 'block';else echo 'none'?>;">
    <ul>
      <?php
    
        foreach($brand as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->title;?>
            <!--(<?php echo $v->c;?>)-->
              <input <?php if(@@$_GET['brand']==$v->id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="brand" value="<?php echo $v->id;?>" name="brand">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        }
      
      ?> 
    </ul>
  </div>
</div>
<?php } ?>
<?php 
  if($age){
?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Age</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['age']) echo 'block';else echo 'none'?>;">
    <ul>
      <?php
    
        foreach($age as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->title;?> 
            <!--(<?php echo $v->c;?>)-->
              <input type="checkbox" class="JagatFilterInput" id="age" value="<?php echo $v->id;?>" name="age">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        
      }
      ?> 
    </ul>
  </div>
</div>
<?php } ?>
<?php   if($suitable_for){?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Suitable for</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['suitable_for']) echo 'block';else echo 'none'?>;">
    <ul>
      <?php
    
        foreach($suitable_for as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->title;?> 
            <!--(<?php echo $v->c;?>) -->
              <input type="checkbox" class="JagatFilterInput" id="suitable_for" value="<?php echo $v->id;?>" name="suitable_for">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        
      }
      ?>
    </ul>
  </div>
</div>
<?php 
}
if($color){  ?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Genre</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['genre']) echo 'block';else echo 'none'?>;">
    <ul>
      <?php
     
        foreach($color as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->title;?> 
            <!--(<?php echo $v->c;?>) -->
              <input <?php if(@@$_GET['genre']==$v->id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="color" value="<?php echo $v->id;?>" name="color">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        }
       
      ?>
    </ul>
  </div>
</div>
<?php } ?>
<?php
if ($cid) {
  $sql2="select * from master_category where parent_id='$cid'";
  $mcat=$userModel->customQuery($sql2); 
  if($mcat){
   $sql="   select discount_percentage,count(product_id) as c from products where  discount_percentage>0 AND  status= 'Active' and (";
   foreach($mcat as $km=>$mv){
    $lcat=$mv->category_id;
    if($km==count($mcat)-1){
      $sql=$sql."        category='$lcat'   ";   
    }else{
      $sql=$sql."        category='$lcat' OR ";     
    }
  }
  $sql=$sql."     )    group by discount_percentage";
} 
}else{
 $sql=" select discount_percentage,count(product_id) as c from products where 
 ";
 if ($keyword=@$_GET['keyword']) {
   $sql=$sql."     products.name like '%$keyword%'  AND  ";
 }
 if ($t=@$_GET['type']) {
   $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
 }
 
 
 
 $sql=$sql."  
 discount_percentage>0 AND  status= 'Active'  group by discount_percentage";
}
$dis=$userModel->customQuery($sql); 
if($dis){
  ?>
  <div class="filter_category">
    <div class="titie_heasder">
      <h3>Offer</h3>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
    </div>
    <div class="cate_data_body"  style="display:<?php if(@@$_GET['offer']) echo 'block';else echo 'none'?>;">
      <ul>
        <?php
        foreach($dis as $k=>$v){
          ?>
          <li>
            <label class="checkbox_label"><?php echo $v->discount_percentage;?>  
            <!--(<?php echo $v->c;?>) -->
              <input <?php if(@@$_GET['offer']!="" && @@$_GET['offer']==$v->discount_percentage) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="offer" value="<?php echo $v->discount_percentage;?>" name="offer">
              <span class="checkmark"></span>
            </label>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
  </div>
<?php } ?>
<?php
?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Price</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"   style="display:<?php if(@@$_GET['priceupto']) echo 'block';else echo 'none'?>;">
   <div class="slidecontainer">
    <input type="range" min="1" max="10000"  class="sliderr JagatFilterInput" id="myRange" name="priceupto" value="<?php if(@@$_GET['priceupto']) echo @@$_GET['priceupto'];?>">
    <p>Price: AED <span id="demo"></span></p>
  </div>
</div>
</div>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>Pre Order</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['pre-order']) echo 'block';else echo 'none'?>;">
    <ul>
      <li>
        <label class="checkbox_label">Yes
          <input <?php if(@@$_GET['pre-order']=="enabled") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="Yes" name="preOrder">
          <span class="checkmark"></span>
        </label>
      </li>
      <li>
        <label class="checkbox_label">No
          <input <?php if(@@$_GET['pre-order']=="No") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="No" name="preOrder">
          <span class="checkmark"></span>
        </label>
      </li>
    </ul>
  </div>
</div>


<?php if(@$freebiChecking[0]->c>0){?>
<div class="filter_category">
  <div class="titie_heasder">
    <h3>freebie</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['freebie']) echo 'block';else echo 'none'?>;">
    <ul>
      <li>
        <label class="checkbox_label">Yes
          <input <?php if(@@$_GET['freebie']=="Yes") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="Yes" name="freebie">
          <span class="checkmark"></span>
        </label>
      </li>
      <li>
        <label class="checkbox_label">No
          <input <?php if(@@$_GET['freebie']=="No") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="No" name="freebie">
          <span class="checkmark"></span>
        </label>
      </li>
    </ul>
  </div>
</div>



<div class="filter_category">
  <div class="titie_heasder">
    <h3>evergreen</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['evergreen']) echo 'block';else echo 'none'?>;">
    <ul>
      <li>
        <label class="checkbox_label">Yes
          <input <?php if(@@$_GET['evergreen']=="Yes") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="Yes" name="evergreen">
          <span class="checkmark"></span>
        </label>
      </li>
      <li>
        <label class="checkbox_label">No
          <input <?php if(@@$_GET['evergreen']=="No") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="No" name="evergreen">
          <span class="checkmark"></span>
        </label>
      </li>
    </ul>
  </div>
</div>


<div class="filter_category">
  <div class="titie_heasder">
    <h3>exclusive</h3>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
  </div>
  <div class="cate_data_body"  style="display:<?php if(@@$_GET['exclusive']) echo 'block';else echo 'none'?>;">
    <ul>
      <li>
        <label class="checkbox_label">Yes
          <input <?php if(@@$_GET['exclusive']=="Yes") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="Yes" name="exclusive">
          <span class="checkmark"></span>
        </label>
      </li>
      <li>
        <label class="checkbox_label">No
          <input <?php if(@@$_GET['exclusive']=="No") echo 'checked';?> type="checkbox" class="JagatFilterInput"  value="No" name="exclusive">
          <span class="checkmark"></span>
        </label>
      </li>
    </ul>
  </div>
</div>

<?php } ?>





</form>
</div>
</div>
<div class="p-10px col-lg-9 ">
  <div class="row mb-3 mobile_product_list_box">
    <?php 
    if(@$cat2){?>
<!--   <div class="col-md-12">
<h4 class="text-capitalize  h5 pb-1 "><strong>Shop by category</strong></h4>
<div class="owl-carousel owl-theme category_boxes">
<?php
foreach(@$cat2 as $k=>$v){ 
$sql="select * from category_image where     category='$v->category_id' and status='Active'";
$category_image=$userModel->customQuery($sql);
?>
<div class="item">
<a href="<?php echo base_url();?>/product-list?category=<?php echo $v->category_id; ?>" class="category_box_on_the_top shadow-none border p-0 pb-2 text-capitalize rounded overflow-hidden">
<div class="box box_cate_products_list_s" style=" background-image: url('<?php echo base_url();?>/assets/uploads/<?php if($category_image[0]->image) echo $category_image[0]->image;else echo 'noimg.png';?>');">
</div>
<h5><strong><?php echo $v->category_name;?></strong></h5>
</a>
</div>
<?php }  ?> 
</div>
</div>-->
<?php } ?>
</div>
<i id="loading" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
<div class="m-10px row" id="Jagat-datatable">
</div>
<div class="col-12 mt-3 text-center pag mb-5">
  <p class="m-0 text-capitalize " id="pageingation"><span id="pgCount2"> </span> of <span id="ofPrduct"></span> Products showing</p>
  <input type="hidden" name="currentPage" id="currentPage" value="1" >
  <i id="loading2" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
  <button class="btn btn-primary rounded-pill "  id="LoadMore">Load More</button>
</div>
</div>
</div>
</div>
</div> 
<script>
 var slider = document.getElementById("myRange");
 var output = document.getElementById("demo");
 output.innerHTML = slider.value;
 slider.oninput = function() {
  output.innerHTML = this.value;
}
</script>