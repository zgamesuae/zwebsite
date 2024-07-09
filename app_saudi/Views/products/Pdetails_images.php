            
            <?php
                // var_dump($products);die();
            ?>
            
            <!-- Carousel -->
            <div id="carousel" class="single_page_slider carousel slide gallery" data-ride="carousel" data-interval="false" data-interval="10000">
                <div class="carousel-inner">

                    <?php if(@$products[0]->youtube_link){ 
                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', @$products[0]->youtube_link, $match); 
                    $youtube_id = $match[1]; 
                    ?>
                    <div class="carousel-item active" data-slide-number="0" data-toggle="lightbox" data-gallery="gallery" data-remote="https://source.unsplash.com/vbNTwfO9we0/1600x900.jpg">
                        <iframe id="youtubeIfram" style="width:100%;height:500px"src="https://www.youtube.com/embed/<?php echo @$youtube_id;?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <?php 
                    }

                    if($product_image){ 
                        foreach($product_image as $k=>$v){  
                    ?>
                    <div class="carousel-item <?php if(@$products[0]->youtube_link=="" &&  $k==0) echo 'active'; ?>" data-slide-number="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>" data-toggle="lightbox" data-gallery="gallery" data-remote="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>">
                        <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="d-block   pdetail-img" alt="<?php echo $products[0]->name ?>">
                    </div>
                    <?php 
                        } 
                    }
                    else{ 
                    ?>
                    <div class="carousel-item active" data-slide-number="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>" data-toggle="lightbox" data-gallery="gallery" data-remote="<?php echo base_url();?>/assets/uploads/noimg.png">
                        <img src="<?php echo base_url();?>/assets/uploads/noimg.png" class="d-block w-100" alt="...">
                    </div>
                    <?php 
                    } 
                    ?>
                </div>
                <?php  
                if($product_image){ 
                    if(count(@$product_image)>1){ 
                ?>
                <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="box_control_nav" aria-hidden="true">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                               <path fill="none" d="M0 0h24v24H0z" /> 
                               <path d="M10.828 12l4.95 4.95-1.414 1.414L8 12l6.364-6.364 1.414 1.414z" /> 
                           </svg> 
                       </span>
                    <span class="sr-only"><?php echo lg_get_text("Previous") ?></span>
                </a>
                <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="box_control_nav" aria-hidden="true">
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"> 
                               <path fill="none" d="M0 0h24v24H0z" /> 
                               <path d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" /> 
                           </svg> 
                       </span>
                    <span class="sr-only"><?php echo lg_get_text("lg_167") ?></span>
                </a>
                <a class="carousel-fullscreen" href="#carousel" role="button">
                    <span class="carousel-fullscreen-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo lg_get_text("lg_168") ?></span>
                </a>
                <a class="carousel-pause pause" href="#carousel" role="button">
                    <span class="carousel-pause-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo lg_get_text("lg_169") ?></span>
                </a>
                <?php }} ?>
            </div>
            <!-- Carousel Navigatiom -->
            <div id="carousel-thumbs" class="carousel slide" data-ride="carousel" data-interval="10000">
                <div class="carousel-inner">
                    <?php  

                    $i=1; 
                    if($product_image){ 
                        if(count($product_image)>1){ 
                            foreach($product_image as $k=>$v){  
                                if($i==1){ 
                    ?>
                    <div class="carousel-item <?php if($k==0) echo 'active';?>" data-slide-number="<?php echo $k;?>">
                        <div class="row mx-0">
                                <?php       
                                }  
                                if(@$products[0]->youtube_link!="" AND $k==0){ 
                                ?>
                            <div id="carousel-selector-<?php echo $k;?>" class="thumb col-3 px-1 py-2 selected" data-target="#carousel" data-slide-to="<?php echo $k;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/yt.jpg" class="img-fluid" alt="Youtube video">
                            </div>
                            <?php } ?>
                            <div id="carousel-selector-<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>" class="thumb col-3 px-1 py-2" data-target="#carousel" data-slide-to="<?php if(@$products[0]->youtube_link!="") echo $k+1;else echo $k;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="img-fluid" alt="<?php echo $products[0]->name." img ".$k ?>">
                            </div>
                            <?php 
                            if(   (count($product_image) < 4  &&  count($product_image)==1 && $i==1 )   ||  (count($product_image) < 4  &&  count($product_image)==2 && $i==2 )  ||  (count($product_image) < 4  &&  count($product_image)==3 && $i==3 )    ||@$products[0]->youtube_link!="" && $i==3 || @$products[0]->youtube_link=="" && $i==4 || count($product_image)==1 || count($product_image)==2 && $i>1){ 
                              $i=1; 
                              ?>
                        </div>
                    </div>
                    <?php 
                    }
                    else{ 
                        $i++; 
                    } 
                    ?>
                    <?php 
                            } 
                        }
                    } 
                    ?>
                </div>
                <?php  
                if($product_image){ 
                    if(count($product_image)>1){ 
                ?>
                <style>
                    .carousel-control-prev, .carousel-control-next { display: none !important; }
                </style>
                <a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo lg_get_text("lg_166") ?></span>
                </a>
                <a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo lg_get_text("lg_167") ?></span>
                </a>
                <?php
                    }
                } 
                ?>
            </div>