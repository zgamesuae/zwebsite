
<?php if(isset($categories_elements) && sizeof($categories_elements) > 0): ?>
<div class="container-fluid pt-4 home-sec pb-4">
    <div class="row j-c-center">

        <?php if(isset($title)): ?>
        <div class="col-12 col-lg-10">
            <div class="sec_title">
                <h2 <?php if(isset($bts_font) && $bts_font): ?>style="font-family: 'HandWrite' , 'sans-serif';" <?php endif; ?>><?php echo $title ?></h2>
            </div>
        </div>
        <?php endif; ?>

        <div class="col-12 col-xl-10 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme home_category_slider_top">
                <?php foreach($categories_elements as $element): ?>
                <div class="item d-flex flex-row ws-hcat-carousel-item justify-content-center d-flex flex-column justify-content-between">
                    <div class="rounded-circle d-flex justify-content-center">
                        <a href="<?php echo $element["link"] ?>">
                            <img src="<?php echo $element["img"] ?>" alt="<?php echo $element["eng_title"] ?>" <?php if(isset($img_max_width)) echo "style='max-width: $img_max_width'" ?>>
                        </a>
                    </div>
                    <div class="col-12 mt-3" style="color:rgb(15, 15, 15); ">
                        <h1 style="font-size: 1.2rem" class="text-center"><?php echo lg_put_text($element["eng_title"] , $element["ara_title"]) ?></h1>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>