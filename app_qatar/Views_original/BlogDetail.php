<style>
.breadcrumbs_nav ul li {
     padding-right: 0px;
}




    </style>

<div class="container breadcrumbs_nav">
  <ul>
    <li><a href="<?php echo base_url();?>">Home</a></li>
    
    
    
    
    
    
    
    
    <?php
    
    $uri = service('uri'); 
 
$sql1="";
$uri1=$uri2=$uri3="";
if(count(@$uri->getSegments())>0){
   
  $uri1=@$uri->getSegment(1); 
 ?>
 <li><span> / &nbsp</span> <a href="<?php echo base_url();?>/<?php echo $uri1;?>"><?php echo str_replace('-', ' ', $uri1) ;?></a>  </li>
    
 <?php
} 
if(count(@$uri->getSegments())>1){
  $uri2=@$uri->getSegment(2); 
   ?>
 <li><span> / &nbsp</span> <a href="<?php echo base_url();?>/<?php echo $uri2;?>"><?php echo $blog[0]->title?></a>  </li>
    
    
    <?php
} ?>
    
     
  </ul>
</div>
<div class="container pt-4 pb-5">
      <div class="row ">
        <section class="col-lg-8">
          <!-- Post meta-->

          <!-- Gallery-->
         
          <div class="image_thubmbail mb-3">
            <img src="<?php echo base_url();?>/assets/uploads/<?php if($blog[0]->image) echo $blog[0]->image; else echo 'noimg.png'?>" class="w-100 rounded-lg">
          </div>
          <!-- Post content-->
          <h4 class="h5 mt-2"><strong><?php echo $blog[0]->title?></strong></h4>
          <p><?php echo $blog[0]->description?></p>
         
 
        </section>
        <aside class="col-lg-4">
          <!-- Sidebar-->
          <div class="offcanvas offcanvas-collapse  ms-lg-auto" id="blog-sidebar" style="max-width: 22rem;">
            
            <div class="offcanvas-body py-grid-gutter py-lg-1 px-lg-4" data-simplebar="init" data-simplebar-auto-hide="true"><div class="simplebar-wrapper" ><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 4px 24px;">
              <!-- Categories-->
              <div class="widget widget-links mb-grid-gutter pb-grid-gutter border-bottom mx-lg-2">
                <h3 class="widget-title">Blog categories</h3>
                <ul class="widget-list">
                    <?php
                    if($blog_cat){
                        foreach($blog_cat as $k=>$v){
                            ?>
                             <li class="widget-list-item"><a class="widget-list-link d-flex justify-content-between align-items-center" href="<?php echo base_url();?>/blog?category=<?echo $v->cat?>"><span><?echo $v->cat?></span><span class="fs-xs text-muted ms-3"><?echo $v->count?></span></a></li>
                 
                            <?php
                        }
                    }
                    ?>
              </ul>
              </div>
              <!-- Trending posts-->
           
             
             
            </div></div></div></div><div class="simplebar-placeholder" ></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="height: 0px; display: none;"></div></div></div>
          </div>
        </aside>
      </div>
    </div>

