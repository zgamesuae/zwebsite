<div class="row blogs col-sm-12 col-md-9 col-lg-10 p-0 px-3 pb-5 m-0" style="height: 100vh; overflow-Y: scroll">
    <?php 
    if($blogs){
        foreach($blogs as $k=>$v){
        ?>
        <div class="col-12 col-md-6 col-lg-3 mt-4">

            <div class="shadow-m rounded blog-item">

                <div class="image_thubmnail d-flex j-c-center a-a-center">
                    <img alt="<?php echo $v->title ?>" src="<?php echo base_url()?>/assets/uploads/<?php if($v->image) echo $v->image; else echo 'noimg.png'?>" class="" alt="">
                </div>

                <div class="blog_content px-2 py-3">
                    <div class="blog-title-sec">
                        <h4 class="h5 mt-2 blog-title">
                            <a class=" text-white" href='<?php echo base_url();?>/blogs/<?php if(!is_null($v->slug)) echo $v->slug; else echo $v->blog_id;?>'>
                                <strong>
                                    <?php echo substr($v->title,0,200);?>
                                </strong>
                            </a>
                        </h4>
                    </div>
                    <div class="blog-description-sec">
                        <p class="text-gray">
                            <?php echo substr(strip_tags($v->description),0,180);?>...
                        </p>
                    </div>
                    <!-- <a href="<?php echo base_url();?>/blog/<?php if(!is_null($v->slug)) echo $v->slug; else echo $v->blog_id;?>" class="btn btn-primary w-100">View </a> -->
                </div>
                <div class="row col-12 m-0 px-3 pb-3 blog-auth-date justify-content-between">
                    <p class="px-1 m-0 text-left"><?php echo (new \DateTime($v->created_at , new \DateTimeZone(TIME_ZONE)) )->format("Y-m-d H:i"); ?></p>
                    <?php if(isset($v->created_by) && !is_null($v->created_by) && trim($v->created_by) !== ""):?>
                        <p class="px-1 m-0 text-left">By: <?php echo $v->creator?></p>
                    <?php endif;?>
                </div>

            </div>

        </div>
        <?php
        }
    }
    ?>
</div>