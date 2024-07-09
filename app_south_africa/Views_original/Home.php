<?php
  $userModel = model('App\Models\UserModel', false);
  $brandModel = model("App\Models\BrandModel");
  $session = session();
  @$user_id=$session->get('userLoggedin'); 
  $sql="select * from cms";
  $cms=$userModel->customQuery($sql);
  $sql="select * from color where status='Active' AND show_in_home_page='Yes'";
  $color=$userModel->customQuery($sql);
  $sql="select * from banner where status='Active'  order by precedence asc";
  $banner=$userModel->customQuery($sql);
  $sql="select * from blog where status='Active' order by created_at desc";
  $blog=$userModel->customQuery($sql);
  $sql="select * from mobile_banner where status='Active'";
  $mobile_banner=$userModel->customQuery($sql);
  $sql="select * from offer_banner where status='Active'";
  $offer_banner=$userModel->customQuery($sql);



  $sql="select * from brand where status='Active' AND image<>''";
  $brand=$userModel->customQuery($sql);


  $sql="select * from home_slider where status='Active' AND type='left'";
  $left=$userModel->customQuery($sql);


  $sql="select * from home_slider where status='Active' AND type='right'";
  $right=$userModel->customQuery($sql);



?>

<?php if(false):?>
<div id="myCarousel" class="home_slider_boostrap carousel slide container-fluid home-sec" data-ride="carousel">
    <ol class="carousel-indicators">

        <?php if($banner){ 
        foreach($banner as $k=>$v){?>
        <li data-target="#myCarousel" data-slide-to="<?php echo $k;?>" class="<?php if($k==0) echo 'active';?>"></li>
        <?php }} ?>
    </ol>
    <div class="carousel-inner">
        <?php if($banner){ 
        foreach($banner as $k=>$v){?>

        <div class="carousel-item <?php if($k==0) echo 'active';?>">
            <div class="container-fluid p-0" id="banner_slider">
                <a href="<?php echo $v->link;?>">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" class="w-100 desltop_s_banner_home_sldier">
                    <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" class="w-100 mobile_banner_home_sldier" style="display: none;">
                </a>
                <?php if($v->title){?>

                <div class="container" id="banner_overlay_text">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="banner_text_content">
                                <h1><?php echo $v->title;?></h1>
                                <div><?php echo $v->description;?></div>
                                <?php if($v->show_button=="Yes"){?>
                                <div class="banner_button">
                                    <a href="<?php echo $v->link;?>" class="btn btn-primary">Buy Now</a>
                                    <!--<a href="<?php echo base_url();?>/product-list" class="btn btn-default">Live demo</a>-->
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
        <?php }} ?>


    </div>
</div>
<?php endif;?>


<?php if(true): ?>

<div class="container-fluid home-sec d-flex j-c-center">
    <div class="owl-carousel owl-theme m_home_slider col-lg-10 col-md-12 col-sm-12 m-0 p-0">
        <?php
        $timezone = new \DateTimeZone("Asia/Dubai");
        foreach ($banner as $key => $value):?>
        <?php
            $date = new \DateTime("now" , $timezone);
            $start = new DateTime($value->start_date , $timezone);
            $end = new DateTime($value->end_date , $timezone);
            $cond1 = $date->getTimestamp() > $start->getTimestamp();
            $cond2 = $date->getTimestamp() < $end->getTimestamp();
            $cond3 = ($value->start_date == null || $value->start_date == "0000-00-00 00:00:00") && ($value->end_date == null || $value->end_date == "0000-00-00 00:00:00");
            if(($cond1 && $cond2) || $cond3):
                // var_dump($start->format("Y-m-d H:i:s"),$date->format("Y-m-d H:i:s"),$end->format("Y-m-d H:i:s"));
        ?>
        <div class="item p-0" style="height:auto" id="banner_slider">
            <a href="<?php echo $value->link;?>">
                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $value->image;?>" class="desltop_s_banner_home_sldier">
            </a>
            <a href="<?php echo $value->link;?>">
                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $value->mobile_image;?>" class="mobile_banner_home_sldier" style="display: none;">
            </a>
            
        </div>
        <?php endif;?>
        <!-- <div class="item" style="height:auto"><img src="https://static.geekay.com/newsletters/202202/d11/imgs/logitech-g413.gif" alt=""></div> -->
        <?php endforeach; ?>

    </div>
</div>
<?php endif;?>


<!-- Best deals section -->
<?php if(FALSE){?>
<div class="container-fluid pt-4 best_offers_parent_con home-sec pb-4">
    <div class="row j-c-center">
        <!--<div class="col-md-10 col-sm-12">-->
        <!--        <div class="sec_title text-dark ">-->
        <!--            <h2 class="text-white">GOOD DEAL</h2>-->
        <!--        </div>-->
        <!--</div>-->
        <div class="col-md-12 col-sm-12 col-lg-10 mt-3 overflow-hidden ">
            <div class="owl-carousel owl-theme catpage_h_slider">
                <div class="item" style="height:auto"><a href=""><img src="<?php echo base_url() ?>/assets/uploads/HTC_Vive_Flow.gif" alt=""></a></div>
                <div class="item" style="height:auto"><a href=""><img src="<?php echo base_url() ?>/assets/uploads/NIntendo_Switch.gif" alt=""></a></div>
                <div class="item" style="height:auto"><a href=""><img src="<?php echo base_url() ?>/assets/uploads/Oculus_Quest 2.gif" alt=""></a></div>
                <div class="item" style="height:auto"><a href=""><img src="<?php echo base_url() ?>/assets/uploads/PS_VR.gif" alt=""></a></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<?php include "Home_shopbycategory.php"?>


<!-- Best offers -->

<?php 
if($best_offers)
echo view("Product_carousel" , $best_offers) 
?>

<?php include "Home_xboxshopby.php";?>
<?php include "Home_psshopby.php";?>
<?php if(false){ ?>
<?php include "Home_build_your_pc.php";?>
<?php } ?>

<?php if(false){ ?>
<?php include "Home_exclusivities.php"?>
<?php } ?>


<?php 
if($new_in_pc_gaming)
echo view("Product_carousel" , (array)$new_in_pc_gaming) ;
?>

<!-- Horizontal banner -->
<?php if(true){ ?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="https://zamzamgames.com/get_a_quote"><img class="desktop_img" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc.gif" alt=""></a>
        <a href="https://zamzamgames.com/get_a_quote"><img class="mobile_img" src="<?php echo base_url()?>/assets/uploads/customize_your_gaming_pc_mobile.gif" alt=""></a>
    </div>
</div>
<?php } 

if($new_arrivals_softwares)
echo view("Product_carousel" , (array)$new_arrivals_softwares) ;

if($new_arrivals_accessories)
echo view("Product_carousel" , (array)$new_arrivals_accessories) ;


if($coming_soon)
echo view("Product_carousel" , (array)$coming_soon);
?>

 <!--Horizontal banner cutomized consoles-->
<?php if(true){?>
<div class="container-fluid home-sec">
    <div class="row col-md-12 col-sm-12 col-lg-10 home_h_banner d-flex-row">
        <a href="https://zamzamgames.com/product-list?category=customization-console-1652792153"><img class="desktop_img" src="<?php echo base_url()?>/assets/uploads/craft_by_merlin_website_banner.gif" alt=""></a>
        <a href="https://zamzamgames.com/product-list?category=customization-console-1652792153"><img class="mobile_img" src="<?php echo base_url()?>/assets/uploads/craft_by_merlin_website_banner_mobile.gif" alt=""></a>
    </div>
</div>
<?php
} 

if(true)
include "Other_cats.php";
?>





<!-- Shop games by genre -->
<div class="container-fluid home-sec">
    <div class="row services_area pt-4 pb-4" id="services_area">
        <div class="col-md-10 mb-4 mt-3" style="margin:auto">
            <div class="sec_title">
                <h2><?php echo $cms[7]->heading;?></h2>
                <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
            </div>
        </div>

        <div class="container-fluid full_cate_sliders mt-3">

            <div class="owl-carousel service_box_animated_sliders owl-theme col-lg-10 .col-sm-12 p-0" style="margin:auto">
                <?php if($color){
          $i=0;
          foreach($color as $k=>$v){
            if($v->image!="" && $v->mobile_image!=""){
             if($i<10){
              ?>
                <div class="item">
                    <div class="service_box_min_new ">
                        <div class="service_box">
                            <a href="<?php echo base_url();?>/product-list?genre=<?php echo $v->id;?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->image;?>" alt="">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->mobile_image;?>" alt="" class="mobile_image" style="display: none;">
                                <div class="box_overlay_content">
                                    <!-- <img src="<?php echo base_url();?>/assets/uploads/<?php echo $v->icon;?>" alt="">-->
                                    <h6><?php echo $v->title;?> <span class="icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M13.172 12l-4.95-4.95 1.414-1.414L16 12l-6.364 6.364-1.414-1.414z" />
                                            </svg></span></h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php 
          }
          $i++;
          } 
          }
          }
          ?>
            </div>
        </div>
    </div>

</div>


<?php 
if($more_games)
echo view("Product_carousel" , (array)$more_games);

if($more_accessories)
echo view("Product_carousel" , (array)$more_accessories) ;

if($trending_products)
echo view("Product_carousel" , (array)$trending_products) ;
?>


<!-- shop by brand -->
<?php 
    if($brand){
?>
    <div class="container-fluid home-sec pt-4 pb-4 shop_brand_shop_by">
        <div class="row j-c-center">
            <div class="col-md-12 col-sm-12 col-lg-10">
                <div class=" sec_title mb-4 text-center text-capitalize">
                    <h2><b>SHOP BY BRAND <?php  ?></b></h2>
                    <!--<a class="right_posiation_buttton bnt btn-primary">View All</a>-->
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-lg-10 pl-2 mb-2">
                <div class="owl-carousel owl-theme two_rows_grid_sliders">

                    <?php
                      $j=0;
                      $k=1;
                     
                       for($i=0;$i<count($brand)/2;$i++):
                    ?>

                    <div class="item">
                        
                        <?php if($brand[$j]->image !== "" && $brand[$j]->title): ?>
                        <div class="new_design_box_categoryies shadow-sm bg-white border rounded">
                            <!-- <h2 style="position:absolute;top:5px;left:5px;color:green;z-index:1000"><?php echo($brand[$j]->title) ?></h2> -->
                            <a href="<?php echo $brandModel->get_brand_url($brand[$j]->id);?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $brand[$j]->image;?>">
                            </a>
                        </div>
                       <?php endif; ?>
                        <?php if($brand[$k]->title && $brand[$k]->image !== ""): ?>
                        <div class="new_design_box_categoryies shadow-sm bg-white border rounded mt-2">
                            <!-- <h2 style="position:absolute;top:5px;left:5px;color:green;z-index:1000"><?php echo($brand[$k]->title) ?></h2> -->
                            <a href="<?php echo $brandModel->get_brand_url($brand[$k]->id);?>">
                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$brand[$k]->image;?>">
                            </a>
                        </div>
                       <?php endif; ?>

                    </div>
                    <?php   
                        $j=$j+2;
                        $k=$k+2;

                    endfor;?>

                </div>
            </div>


        </div>
    </div>
<?php } ?>



<!-- Subscribe to news letter -->
<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize">
    <div class="container p-0">
        <div class="row">
            <div class="col-md-8 mt-2">
                <div class="heading">
                    <h3 class="text-white">Subscribe to our newsletter</h3>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <?php  
       if(@$flashData['success']){?>
                <p style="margin-bottom: 0; padding-bottom: 10px; color: #fff; font-weight: 500;"><?php echo $flashData['success'];?></p>
                <?php } ?>
                <form method="post" class="d-flex" action="<?php echo base_url();?>/page/newsletter">
                    <input type="email" placeholder="Email Address" required name="email">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</div>