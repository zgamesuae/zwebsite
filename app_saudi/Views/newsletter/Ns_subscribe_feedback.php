<?php if($status): ?>
<div class="row m-0 justify-content-center w-100 pb-4" >
    <img class="border col-12 p-0" src="<?php echo base_url() ?>/assets/img/subscribe_&_win_armored_core.jpg" alt="">
</div>
<p class="text-center">
<?php echo lg_get_text("lg_346") ?>                                                   
</p>
<p class="text-justify">
<?php echo lg_get_text("lg_347") ?>
</p>
<p class="text-center">
    <span style="font-size: 1.3rem; color: #e5ba17;"><b><?php echo lg_get_text("lg_348") ?></b></span>
</p>
<div class="row m-0 p-0 justify-content-center w-100" style="font-size: 1.6rem;">
    <div class="col-2 d-flex justify-content-center">
        <a style="color: white" href="<?php echo $settings[0]->facebook ?>">
            <i class="fa-brands fa-facebook"></i>
        </a>
    </div>
    <div class="col-2 d-flex justify-content-center">
        <a style="color: white" href="<?php echo $settings[0]->instagram ?>">
            <i class="fa-brands fa-instagram"></i>
        </a> 
    </div>
    <div class="col-2 d-flex justify-content-center">
        <a style="color: white" href="<?php echo $settings[0]->tiktok ?>">
            <i class="fa-brands fa-tiktok"></i>
        </a>
    </div>
</div>
<?php else: ?>
<p class="text-justify ">
    <?php echo lg_get_text("lg_349") ?>                
</p>
<?php endif; ?>
