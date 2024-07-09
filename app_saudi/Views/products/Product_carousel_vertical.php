<?php 
$session = session(); 

$userModel= model('App\Models\UserModel');
$productModel= model('App\Models\ProductModel');
$session = 
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
        <div class="row m-0 p-0 col-12 col-lg-10 justify-content-center align-items-center">
            <div class="col-12 col-md-12 col-lg-6 mt-3">
                <?php if(isset($section_background) && sizeof($section_background) > 0 || true): ?>
                    <div class="col-12 p-0 m-0" style="width:100%; max-height: 450px; overflow:hidden; position:relative">
                        <img src="<?php echo $section_background["desktop"] ?>" class="d-none d-md-block w-100 w-lg-auto h-auto h-lg-100" alt="main section background">
                        <img src="<?php echo $section_background["mobile"] ?>" class="d-sm-block d-md-none w-100" alt="main section background">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-12 col-md-12 col-lg-6 mt-3 p-0 overflow-hidden">
                <div class="owl-carousel owl-theme product_carrousel_vertical" <?php if(isset($section_background) && sizeof($section_background) > 0): ?>style="position:relative; margin-top:0"<?php endif; ?>>
                    <?php 
                    if($list){
                    //   foreach($list as $k=>$v){ 
                      for($i=0 ; $i< sizeof($list) ; $i+=2){ 
                        // $price = bcdiv($list[$i]->price, 1, 2);
                        // if($productModel->get_discounted_percentage($list[$i]->product_id) > 0){
                        //     $price = ($list[$i]->discount_rounded == "Yes") ? round(bcdiv($list[$i]->price - ($list[$i]->discount_percentage*$list[$i]->price)/100, 1, 2)) : bcdiv($list[$i]->price - ($list[$i]->discount_percentage*$list[$i]->price)/100, 1, 2) ;
                        // }
                        ?>  
                        <div class="item" <?php content_from_right() ?>>
                            <div class="row m-0">

                                <?php if(isset($list[$i])): ?>
                                <div class="col-12 p-2">
                                    <?php 
                                        $pid=$list[$i]->product_id;
                                        $sql="select * from product_image where product='$pid' and status='Active'";
                                        $product_image=$userModel->customQuery($sql); 
                                    ?>
                                    <?php
                                        if(isset($list[$i]))
                                        echo view("products/Product_box" , ["v" => $list[$i] , "product_image" => $product_image , "hr" => true]); 
                                    ?>
                                </div>
                                <?php endif; ?>

                                <?php if(isset($list[$i+1])): ?>
                                <div class="col-12 p-2">
                                    <?php 
                                        $pid=$list[$i+1]->product_id;
                                        $sql="select * from product_image where product='$pid' and status='Active'";
                                        $product_image=$userModel->customQuery($sql); 
                                    ?>
                                    <?php
                                        echo view("products/Product_box" , ["v" => $list[$i+1] , "product_image" => $product_image , "hr" => true]); 
                                    ?>
                                </div>
                                <?php endif; ?>

                                <?php if(false): ?>
                                <?php if(isset($list[$i+2])): ?>
                                <div class="col-6 p-2">
                                    <?php 
                                        $pid=$list[$i+2]->product_id;
                                        $sql="select * from product_image where product='$pid' and status='Active'";
                                        $product_image=$userModel->customQuery($sql); 
                                    ?>
                                    <?php
                                        if(isset($list[$i+2]))
                                        echo view("products/Product_box" , ["v" => $list[$i+2] , "product_image" => $product_image , "hr" => true]); 
                                    ?>
                                </div>
                                <?php endif; ?>

                                <?php if(isset($list[$i+3])): ?>
                                <div class="col-6 p-2">
                                    <?php 
                                        $pid=$list[$i+3]->product_id;
                                        $sql="select * from product_image where product='$pid' and status='Active'";
                                        $product_image=$userModel->customQuery($sql); 
                                    ?>
                                    <?php
                                        if(isset($list[$i+3]))
                                        echo view("products/Product_box" , ["v" => $list[$i+3] , "product_image" => $product_image , "hr" => true]); 
                                    ?>
                                </div>
                                <?php endif; ?>
                                <?php endif; ?>


                            </div>
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
</div>
<?php } ?>