<?php 
$session = session(); 

$userModel= model('App\Models\UserModel');
$productModel= model('App\Models\ProductModel');
@$user_id=$session->get('userLoggedin');  

if($list){?>
<div class="container-fluid <?php if(!isset($no_bg) || !$no_bg): echo "home-sec"; endif; ?> pt-3 best_offers_parent_con">
    <div class="row j-c-center">
        <div class="col-md-12 col-sm-12 col-lg-10">
            <div class="sec_title">
                <h2 <?php if(isset($bts_font) && $bts_font): ?>style="font-family: 'HandWrite' , 'sans-serif';" <?php endif; ?>><?php echo $title ?></h2>
                <?php if(isset($link) && $link !== ""): ?>
                <a href="<?php echo $link?>" class="right_posiation_buttton bnt btn-primary"><?php echo lg_get_text("lg_32")?></a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-lg-10 mt-3 overflow-hidden ">
            <?php if(isset($section_background) && sizeof($section_background) > 0): ?>
                <div class="col-12 p-0 m-0" style="height:<?php if(isset($section_division) && sizeof($section_division) > 3): echo "auto"; else: echo "auto"; endif; ?>; overflow:hidden; position:relative">
                    <?php 
                    $end = new \DateTime("2023-11-13T00:00:01" , new \DateTimeZone(TIME_ZONE));
                    if($countdown && (now() < $end->getTimestamp())): 
                    ?>
                        <div style="position: absolute; top:0px; right:0px;" class="col-12 col-lg-4 p-0">
                            <?php echo view("products/Countdown" , ["end_date" => "2023-11-13T00:00:01" , "count_down_title" => "OFFER STARTS IN"]); ?>
                        </div>
                    <?php endif; ?>
                    <img width="100%" src="<?php echo $section_background["desktop"] ?>" class="d-none d-lg-block" alt="main section background">
                    <img width="100%" src="<?php echo $section_background["mobile"] ?>" class="d-sm-block d-lg-none" alt="main section background">
                    <!-- Section carrousel subcategories banners -->
                    <?php if(isset($section_division) && sizeof($section_division) > 3): ?>
                    <div class="row owl-carousel owl-theme section_home_cat_slider justify-content-center m-0 p-0 col-12" style="position: absolute; bottom: 10px;">
                        <div class="col-md-12 col-sm-12 mt-3 overflow-hidden p-0">
                            <div class="owl-carousel owl-theme catpage_h_slider">

                                <div class="item py-0 d-flex flex-row justify-content-center" style="height:auto;">
                                    <a href="<?php echo $section_division[0]["link"] ?>">
                                        <img height="auto" alt="Collectible card games" style="border-radius: 8px" src="<?php echo $section_division[0]["img"] ?>" alt="Category illustration">
                                    </a>
                                </div>

                                <div class="item py-0 d-flex flex-row justify-content-center" style="height:auto;">
                                    <a href="<?php echo $section_division[1]["link"] ?>">
                                        <img height="auto" alt="Drinkware gaming merchandise" style="border-radius: 8px" src="<?php echo $section_division[1]["img"] ?>" alt="Category illustration">
                                    </a>
                                </div>

                                <div class="item py-0 d-flex flex-row justify-content-center" style="height:auto;">
                                    <a href="<?php echo $section_division[2]["link"] ?>">
                                        <img height="auto" alt="Stationary gaming merchandise" style="border-radius: 8px" src="<?php echo $section_division[2]["img"] ?>" alt="Category illustration">
                                    </a>
                                </div>

                                <div class="item py-0 d-flex flex-row justify-content-center" style="height:auto;">
                                    <a href="<?php echo $section_division[3]["link"] ?>">
                                        <img height="auto" alt="Apparels gaming merchandise" style="border-radius: 8px" src="<?php echo $section_division[3]["img"] ?>" alt="Category illustration">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- Section carrousel subcategories banners -->

                </div>
            <?php endif; ?>
            <div class="owl-carousel owl-theme category_list_home_page" <?php if(isset($section_background) && sizeof($section_background) > 0): ?>style="position:relative; margin-top:0"<?php endif; ?>>
                <?php 
                    if($list){
                      foreach($list as $k=>$v){
                        $pid=$v->product_id;
                        // $is_valid = $productModel->is_valid($pid);
                        // var_dump($is_valid);
                        // if($is_valid):
                        $sql="select * from product_image where product='$pid' and status='Active'";
                        $product_image=$userModel->customQuery($sql); 
                        
                        $price = bcdiv($v->price, 1, 2);
                        $discount = $productModel->get_discounted_percentage($GLOBALS["offerModel"]->offers_list , $v->product_id);
                        if($discount["discount_amount"] > 0){
                            $price =  $discount["new_price"] ;
                        }
                        ?>
                        <div class="item" <?php content_from_right() ?>>
                            <?php echo view("products/Product_box" , ["user_id"=> $user_id , "v" => $v , "product_image" => $product_image , "hr" => false]); ?>
                        </div>
                    <?php 
                        // endif;
                        }
                    } 
                ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>