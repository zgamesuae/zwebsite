<?php
  global $userModel;
  $userModel = model("App\Model\UserModel");


  function order_categories($categories){
    $cats = array(
      0 => array(
        "name" => "root",
        "id" => 12,
        "subcats" => array(),
        "article_count" => 5
      )
    );
    if(sizeof($categories)>0){
      foreach($categories as $category){

      }
    }

    return $cats;
  }

  function nbr_article($cat_id){
    $n=0;
    $req="select count(category) as c from blog where category='".$cat_id."'";
    $res=$GLOBALS["userModel"]->customQuery($req);

    if(!is_null($res) && sizeof($res)>0)
    $n = $res[0]->c;

    return $n;
  }
?>

    <style>
      .breadcrumbs_nav ul li {
        padding-right: 0px;
      }
    
      .main-blog-description img {
        max-width: 100%;
      }
    </style>


    <div class="row blogs justify-content-center col-sm-12 col-md-9 col-lg-10 p-0 px-3 pb-5 m-0" style="height: 100vh; overflow-Y: scroll">

      <!-- BreadCrump -->
      <div class="row col-12 breadcrumbs_nav">
        <ul>
          <?php
            $uri = service('uri'); 

            $sql1="";
            $uri1=$uri2=$uri3="";
            if(count(@$uri->getSegments())>0){
            $uri1=@$uri->getSegment(1); 
          ?>
          <li>
            <span>&nbsp</span> <a href="<?php echo base_url();?>/<?php echo $uri1;?>"> <?php echo str_replace('-', ' ', $uri1) ;?> </a> 
          </li>
            
          <?php
            } 
            if(count(@$uri->getSegments())>1){
              $uri2=@$uri->getSegment(2); 
          ?>
          <li>
            <span> / &nbsp</span> <a href="<?php echo base_url();?>/blogs/<?php echo $uri2;?>"> <?php echo $blog[0]->title?> </a> 
          </li>
          <?php } ?>
            
            
        </ul>
      </div>
      <!-- BreadCrump -->

      <div class="row col-12 pt-4 pb-5 px-0" >
          <section class="col-sm-12 col-lg-8 ws-blog-details px-0">
            <div class="image_thubmbail d-flex align-item-center flex-column justify-content-center mb-4">
              <img alt="<?php echo $blog[0]->title ?>" src="<?php echo base_url()?>/assets/uploads/<?php if($blog[0]->image) echo $blog[0]->image; else echo 'noimg.png'?>" class="w-100 rounded-lg">
            </div>

            <div class="col-12">
              <!-- Post content-->
              <div class="col-12 px-0 py-3">
                <h1 class="h5 mt-2">
                  <strong> <?php echo $blog[0]->title?> </strong>
                </h1>
                <div class="col-12 px-1">
                  <p class="blog-date" style="color: rgb(56, 56, 56)">
                    <?php echo (new \DateTime($blog[0]->created_at , new \DateTimeZone(TIME_ZONE)))->format("D. d F Y - H:i") ?>
                  </p>
                </div>
              </div>

              <div class="main-blog-description">
                <?php echo $blog[0]->description?>
              </div>
              <!-- Post content-->
            </div>            
          </section>
          

          <div class="col-sm-12 col-lg-4 m-0">

            <?php if(sizeof($related_blogs) > 0): ?>
              <div class="col-12 px-0 ws-related-blogs">

                <div class="col-12 ws-related-blogs-title">
                  <h2 class="text-white">Related posts:</h2>
                </div>

                <ul class="m-0 related-blogs px-1">
                  <?php foreach($related_blogs as $blog): ?>
                  <a href="<?php echo base_url() ?>/blogs/<?php if(!is_null($blog->slug)) echo $blog->slug; else echo $blog->blog_id; ?>">

                    <li class="blog-row col-12 p-0 m-0 row my-3 p-1 py-2 align-items-start">

                      <div class="col-4 blog-image d-flex-row align-items-center">
                        <img alt="<?php echo $blog->title ?>" src="<?php echo base_url() ?>/assets/uploads/<?php if($blog->image) echo $blog->image; else echo 'noimg.png' ?>" alt="">
                      </div>

                      <div class="col-8 px-0 px-md-1 row">

                        <div class="col-12 blog-title-sec">
                          <h4 class="blog-title">
                            <?php 
                                $title = (strlen($blog->title) > 75) ? substr($blog->title , 0 , 70)."..." : $blog->title;
                                echo $title 
                            ?>
                          </h4>
                        </div>  

                        <div class="col-12 blog-description-sec">
                          <?php 
                            $description = strip_tags($blog->description);
                          ?>
                          <p>
                            <?php echo substr($description , 0 , 100)."..." ?>
                          </p>
                        </div>

                        <div class="col-12 blog-date">
                          <span>
                            <?php echo (new \DateTime($blog->created_at , new DateTimeZone(TIME_ZONE)))->format("D. d F Y - H:i") ?>
                          </span>
                        </div>

                      </div>

                    </li>
                  </a>
                  <?php endforeach; ?>

                </ul>

              </div>
            <?php endif; ?>

          </div>

      </div>
    </div>
    
          <?php if(false): ?>
          <aside class="col-lg-4">
            <!-- Sidebar-->
            <div class="offcanvas offcanvas-collapse  ms-lg-auto" id="blog-sidebar" style="max-width: 22rem;">
          
              <div class="offcanvas-body py-grid-gutter py-lg-1 px-lg-4" data-simplebar="init"
                data-simplebar-auto-hide="true">
                <div class="simplebar-wrapper">
                  <div class="simplebar-height-auto-observer-wrapper">
                    <div class="simplebar-height-auto-observer"></div>
                  </div>
                  <div class="simplebar-mask">
                    <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
          
                      <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
          
                        <div class="simplebar-content" style="padding: 4px 24px;">
                          <!-- Categories-->
                          <div class="widget widget-links mb-grid-gutter pb-grid-gutter border-bottom mx-lg-2">
                            <h3 class="widget-title">Blog categories</h3>
                            <ul class="widget-list">
                              <?php
                                    if($blog_cat){
                                        foreach($blog_cat as $k=>$v){          
                                    ?>

                              <li class="widget-list-item">
                                <a class="widget-list-link d-flex justify-content-between align-items-center"
                                  href="<?php echo base_url();?>/blog?category=<?echo $v->cat?>">
                                  <span>
                                    <?php echo $v->name?>
                                  </span><span class="fs-xs text-muted ms-3">(
                                    <?php echo nbr_article($v->id) ?>)
                                  </span>
                                </a>
                              </li>
                                  
                              <?php
                                        }
                                    }
                                    ?>
                            </ul>
                          </div>
                          <!-- Categories-->
                                  
                          <!-- Trending posts-->
                          <!-- Trending posts-->
                        </div>
                                  
                      </div>
                                  
                    </div>
                  </div>
                  <div class="simplebar-placeholder">
                  </div>
                </div>
                                  
                                  
                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                  <div class="simplebar-scrollbar" style="width: 0px; display: none;">
                  </div>
                </div>
                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                  <div class="simplebar-scrollbar" style="height: 0px; display: none;">
                  </div>
                </div>
              </div>
            </div>
          </aside>
          <?php endif; ?>
                                  
       