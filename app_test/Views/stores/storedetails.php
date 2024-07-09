<?php 
    
    // var_dump($store);die();

?>

<div class="row preview-detail j-c-center">
    
    <?php if(!is_null($store->image_1) || !is_null($store->image_2) || !is_null($store->image_3) || !is_null($store->image_4) || !is_null($store->image_5) || !is_null($store->image_6)): ?>
    <!-- Gallery -->
    <div class="col-12 gallery">
        <div class="row">
            <div class="col-12 py-3">
                <h4 class=" <?php text_from_right() ?>"><?php echo lg_get_text("lg_326") ?></h4>
            </div>
            <div class="col-12 store-images">
                <div class="row justify-content-center align-items-start">
                    <?php if(isset($store->image_1) && !is_null($store->image_1)): ?>    
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_1 ?>" alt="">
                    <?php endif; ?>

                    <?php if(isset($store->image_2) && !is_null($store->image_2)): ?>
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_2 ?>" alt="">
                    <?php endif; ?>

                    <?php if(isset($store->image_3) && !is_null($store->image_3)): ?>
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_3 ?>" alt="">
                    <?php endif; ?>

                    <?php if(isset($store->image_4) && !is_null($store->image_4)): ?>
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_4 ?>" alt="">
                    <?php endif; ?>

                    <?php if(isset($store->image_5) && !is_null($store->image_5)): ?>
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_5 ?>" alt="">
                    <?php endif; ?>

                    <?php if(isset($store->image_6) && !is_null($store->image_6)): ?>
                    <img class="m-1" src="<?php echo base_url() ?>/assets/others/stores/<?php echo $store->image_6 ?>" alt="">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if(!is_null($store->description) && trim($store->description) !== ""): ?>
        <!-- About the store -->
        <div class="col-12">
            <div class="row about">
                <div class="col-12 py-3">
                    <h4 class=" <?php text_from_right() ?>"><?php echo lg_get_text("lg_327") ?></h4>
                </div>
                <div class="col-12">
                    <?php echo $store->description ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(true): ?>
        <!-- Working hours -->
        <div class="col-12">
            <div class="row about">
                <div class="col-12 py-3">
                    <h4 class=" <?php text_from_right() ?>"><?php echo lg_get_text("lg_62") ?></h4>
                </div>
                <div class="col-12">
                    <p class=" <?php text_from_right() ?>">
                        <span style="color: #89ff89"> <?php echo lg_get_text("lg_63") ?>: </span>  <?php echo (new \DateTime($store->weekdays_start , new \DateTimeZone(TIME_ZONE)))->format("h:i A")."-".(new \DateTime($store->weekdays_end , new \DateTimeZone(TIME_ZONE)))->format("h:i A") ?> <br>
                        <span style="color: #89ff89"><?php echo lg_get_text("lg_64") ?>:</span>  <?php echo (new \DateTime($store->weekends_start , new \DateTimeZone(TIME_ZONE)))->format("h:i A")."-".(new \DateTime($store->weekends_end , new \DateTimeZone(TIME_ZONE)))->format("h:i A") ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if(!is_null($store->location) && trim($store->location) !== ""): ?>
        <!-- Location of the store -->
        <div class="col-12">
            <div class="row location">
                <div class="col-12 py-3">
                    <h4 class=" <?php text_from_right() ?>"><?php echo lg_get_text("lg_13") ?></h4>
                </div>
                
                <div class="col-12">
                    <?php echo $store->location ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>