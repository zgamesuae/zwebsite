<style>
   .breadcrumbs_nav ul li {
    padding-right: 0px;
 }
</style>
<?php
   global $categoryModel ;
   $categoryModel = model("App\Models\Category");
?>
<div class="container breadcrumbs_nav <?php echo text_from_right() ?>">
   <ul>
      <li>
         <a href="<?php echo base_url();?>"><?php echo lg_get_text("lg_119") ?></a>
      </li>

      <?php

      $uri = service('uri'); 
      $sql1="";
      $uri1=$uri2=$uri3="";

      if(count(@$uri->getSegments())>0){
        $uri1=@$uri->getSegment(1); 

         if($uri1=="product-list"){

            if($cid=@$_GET['category']){

               $sql="select * from master_category where category_id='$cid'";
               $cat2=$userModel->customQuery($sql);
               if($cat2){
                  $c=$cat2[0]->parent_id;

                  $sql="select * from master_category where  category_id='$c'";
                  $cat1=$userModel->customQuery($sql);

                  if($cat1){
                     $c0=$cat1[0]->parent_id;
                     $sql="select * from master_category where  category_id='$c0'";
                     $cat0=$userModel->customQuery($sql);
                  }

               }
  
  
      ?>
           
      <?php if(@$cat0[0]){ ?>
         <li><span> / &nbsp </span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1;?>?category=<?php echo    @$cat0[0]->category_id   ;?>"><?php lg_put_text(@$cat0[0]->category_name , @$cat0[0]->category_name);  ?> </a>  
         </li>
      <?php } ?>
           
      <?php if(@$cat1[0]){ ?>
         <li><span> / &nbsp </span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1;?>?category=<?php echo    @$cat1[0]->category_id   ;?>"><?php lg_put_text(@$cat0[0]->category_name , @$cat0[0]->category_name);  ?></a>
         </li>
      <?php } ?>
             
             
      <?php if(@$cat2[0]){ ?>
         <li><span> / &nbsp </span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1;?>?category=<?php echo    @$cat2[0]->category_id   ;?>"><?php lg_put_text(@$cat0[0]->category_name , @$cat0[0]->category_name);  ?></a>  
         </li>
      <?php } ?>
             
              
            <?php
            }
            ?>
     
         <?php  
         }  

   else{
      // var_dump($categoryModel->get_cat_from_slug($uri1)->category_name , $uri1);die();

      if(count(@$uri->getSegments())>0){
        $uri1=@$uri->getSegment(1); 
        ?>
         <li><span> / &nbsp</span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1;?>"><?php if(get_cookie("language") == "AR") echo $categoryModel->get_cat_from_slug($uri1)->category_name_arabic; else echo $categoryModel->get_cat_from_slug($uri1)->category_name; ?></a>  
         </li>
       <?php
      } 

      if(count(@$uri->getSegments())>1){
          $uri2=@$uri->getSegment(2); 
       ?>
         <li><span> / &nbsp</span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1."/".$uri2;?>"><?php if(get_cookie("language") == "AR") echo $categoryModel->get_cat_from_slug($uri2)->category_name_arabic; else echo $categoryModel->get_cat_from_slug($uri2)->category_name; ?></a>  
         </li>
          <?php
      } 

      if(count(@$uri->getSegments())>2){
          $uri3=@$uri->getSegment(3);  
       ?>
         <li><span> / &nbsp</span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1."/".$uri2."/".$uri3;?>"><?php if(get_cookie("language") == "AR") echo $categoryModel->get_cat_from_slug($uri3)->category_name_arabic; else echo $categoryModel->get_cat_from_slug($uri3)->category_name; ?></a>  
         </li>
       <?php
      } 

      if(count(@$uri->getSegments())>3){
         $uri4=@$uri->getSegment(4);  
         ?>
         <li><span> / &nbsp</span> 
            <a href="<?php echo base_url();?>/<?php echo $uri1."/".$uri2."/".$uri3."/".$uri4;?>"><?php if(get_cookie("language") == "AR") echo $categoryModel->get_cat_from_slug($uri4)->category_name_arabic; else echo $categoryModel->get_cat_from_slug($uri4)->category_name; ?></a>  
         </li>
         <?php
      } 

   }
}
?>
</ul>
</div>