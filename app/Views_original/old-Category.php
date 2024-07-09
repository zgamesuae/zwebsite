
<?php include 'Common/Breadcrumb.php';?>
<?php
$userModel = model('App\Models\UserModel', false);
 
?>
<div class="container pb-4 mt-3 mobile_cate_design">
  <div class="row justify-content-between">
       
<?php 
$uri = service('uri'); 
$l=base_url().'/category/';
if($category){
foreach($category as $k=>$v){
    $uri1=$uri2=$uri3=$l="";
if(count(@$uri->getSegments())>0){
  
  $l=$l.'/'.@$uri->getSegment(1); 
  
} 
if(count(@$uri->getSegments())>1){
  $l=$l.'/'.@$uri->getSegment(2); 
 
} 
if(count(@$uri->getSegments())>2){
 $l=base_url().'/search/'.@$uri->getSegment(2).'/'.@$uri->getSegment(3);
 
  
 
} 
    
    
    
     $sql="select * from category_image where     category='$v->category_id' and status='Active'";
              $category_image=$userModel->customQuery($sql);
?>
    <div class="col-md-4 col-sm-6 pt-4">
        <div class="category_box_secondary">
          <div class="box_thumbnail">
           
              <a href="<?php echo $l.'/'.$v->category_id;?>" 
              >
            <img src="<?php echo base_url();?>/assets/uploads/<?php if($category_image[0]->image) echo $category_image[0]->image;else echo 'noimg.png';?>" class="h-400" alt="">
                  </a>
          </div>
          <div class="box_category_content  text-center text-capitalize pt-3">
            <h6 class="text-capitalize"><strong><?php echo $v->category_name;?></strong></h6>
            <p class="text-gray"><?php echo substr($v->category_description,0,30);?></p>
            <a href="<?php echo $l.'/'.$v->category_id;?>" class="text-small btn btn-black" > Show More </a>
          </div>
      </div>
    </div> 
   <?php } } ?>
    </div>
  </div>
</div>


