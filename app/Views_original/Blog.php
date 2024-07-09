  
<?php include 'Common/Breadcrumb.php';?>

<div class="container pt-5 pb-5">
  <div class="row">
      <?php if($blog){
      foreach($blog as $k=>$v){
      ?>
    <div class="col-lg-4 col-md-4 col-sm-6 mt-4">
      <div class="shadow-m rounded">
        <div class="image_thubmnail">
          <img src="<?php echo base_url();?>/assets/uploads/<?php if($v->image) echo $v->image; else echo 'noimg.png'?>" class="w-100 h-150" alt="" >
        </div>
        <div class="project_content p-2">
          <h4 class="h5 mt-2"><strong><?php echo substr($v->title,0,40);?></strong></h4>
          <p class="text-gray"><?php echo substr(strip_tags($v->description),0,180);?>...</p>
          <a href="<?php echo base_url();?>/blog-detail/<?php echo $v->blog_id;?>" class="btn btn-primary w-100">View </a>
        </div>
      </div>
    </div> 
 <?php
 }
 }
 ?>
  </div>
</div>
