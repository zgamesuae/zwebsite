
<?php
    $lang = get_cookie("language"); 
    $categoryModel = $GLOBALS["category_model"];
    $productModel = model("App\Model\ProductModel");
    // filter only menu Categories
    $categoryModel->filter_menu_categories();
    $parent_categories = $categoryModel->get_parent_categories(0,5);
    $other_categories = $categoryModel->get_parent_categories(5,10);
    $categories_urls = $categoryModel->categories_urls();

    // var_dump($parent_categories);
    // $brands = $categoryModel->get_categories_brands($other_categories);
    // var_dump($other_categories);
    // var_dump($categoryModel->get_category_hierarchy());


    // die();
?>


<!-- Main menu Start -->
<div class="row justify-content-center menu col-md-8 col-lg-12 m-0 p-0">

    <div class="main-menu row col-lg-12 justify-content-center align-content-start py-0 p-0 m-0 <?php text_from_right() ?>" <?php content_from_right() ?>>
        <!-- Close button on mobile -->
        <div class="close col-12 row m-0 my-2 p-0 justify-content-end">
            <i class="fa-solid fa-xmark col-auto"></i>
        </div>
        <!-- Close button on mobile -->

        <!-- main menu elements 1st Layer -->
        <ul class="main-menu-elements col-12 m-0 px-2">

            <?php if(!$user_loggedin): ?>
            <!-- Mobile User login | Registration -->
            <div class="col-12 row m-0 my-3 justify-content-between align-items-center mobile-user-account">
                <div class="col-5 p-0 d-flex flex-row justify-content-center align-items-center">
                    <div class="col-auto p-0">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </div>
                    <div class="col-auto <?php if($lang == "AR") echo 'mr-2'; else echo 'ml-2' ?> p-0">
                        <a href="javascript:void();" data-toggle="modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
                            <span><?php echo lg_get_text("lg_83") ?></span>
                        </a>
                    </div>
                </div>
                <div class="col-auto p-0">
                    <div class="vl"></div>
                </div>
                <div class="col-5 p-0 d-flex flex-row justify-content-center align-items-center">
                    <div class="col-auto ml-2 p-0">
                        <a href="javascript:void();" data-toggle="modal" data-target="#login-modal" data-form="register" onClick="get_form(this.getAttribute('data-form'))">
                            <span><?php echo lg_get_text("lg_146") ?></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mobile User login | Registration -->
            <?php endif; ?>
            
            
            <?php if(true): ?>
            <!-- Menu content -->
            <div class="col-auto px-0 px-md-2 d-lg-flex flex-row justify-content-center main-menu-content">

                <?php 
                if(true):
                    foreach($parent_categories as $p_id => $p_category):

                        $parent_name =  lg_put_text($p_category["category_name"] , $p_category["category_name_arabic"] , false);
                        $show_cat_page = $p_category["show_category_page"];                        
                        $category_url = $categoryModel->menu_category_url($p_id , $categories_urls , $show_cat_page);
                        $cat_level_2 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p_id){ return $category["parent_id"] == $p_id; });

                        $banners = $categoryModel->get_category_menu_banners($p_id , 'Menu');
                        $brands = $categoryModel->get_category_brands($p_id);

                ?>

                <li class="parent-element col-12 col-lg-auto align-items-center mx-sm-0 mx-md-0 mx-lg-1 py-lg-3 px-md-2 py-1 px-0">
                    <span><a href="<?php echo $category_url?>"><?php echo $parent_name ?></a></span>

                    <?php if(sizeof($cat_level_2) > 0): ?>
                        <span><i class="fa-solid fa-caret-down"></i></span>
                    <?php endif; ?>

                    <!-- Sub category 2nd layer -->
                    <?php if(sizeof($cat_level_2) > 0 && true): ?>
                    <div class="col-12 row m-0 mt-2 mt-md-0 p-0 children-elements" style="background-color: white">
                        <div class="col-lg-4 col-12 py-2 px-0 sub-elements" style="background-color: <?php echo '#1d3351'; ?>">
                            <ul class="col-12 p-0 pl-3">
                                <?php foreach ($cat_level_2 as $p2_id => $p2_category): 
                                    $category_name = lg_put_text($p2_category["category_name"] , $p2_category["category_name_arabic"] , false);
                                    $category_url = $categoryModel->menu_category_url($p2_id , $categories_urls , $show_cat_page);
                                    $show_cat_page = $p_category["show_category_page"];
                                    $cat_level_3 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p2_id){ return $category["parent_id"] == $p2_id; });
                                ?>

                                <li class="py-2 row m-0 col-12 justify-content-between child-element">
                                    <span class="col-auto p-0"><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span> 

                                    <?php if(sizeof($cat_level_3) > 0): ?>
                                        <span class="col-auto toggler"><i class="fa-solid fa-caret-down"></i></span>
                                    <?php endif; ?>
                                    
                                    <?php if(sizeof($cat_level_3) > 0):?>
                                    <!-- Sub Sub category 3rd layer -->
                                    <div class="col-12 row m-0 schildren-elements p-0">
                                        <div class="sub-sub-elements px-0" style="height: auto">
                                            <ul class="col-12 p-0 <?php if($lang == "AR") echo 'pr-4'; else echo 'pl-4'; ?>">
                                                <?php foreach($cat_level_3 as $p3_id => $p3_category ):
                                                    $category_name = lg_put_text($p3_category["category_name"] , $p3_category["category_name_arabic"] , false);
                                                    $show_cat_page = $p3_category["show_category_page"];
                                                    $category_url = $categoryModel->menu_category_url($p3_id , $categories_urls , $show_cat_page);
                                                ?>
                                                <li class="py-1"><span><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span></li>
                                                <?php 
                                                endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Sub Sub category 3rd layer -->
                                    <?php endif; ?>



                                </li>
                                <?php 
                                endforeach; ?>
                                
                            </ul>
                        </div>
                        <div class="col-lg-8 col-12 p-0 d-flex align-items-center" style="background-color:white; min-height: 250px;height: 100%;">
                            <div class="col-12 row justify-content-between m-0">
                                <!-- Category Marketing content -->
                                <!-- <img src="https://a.nooncdn.com/cms/pages/20230213/c96f4d7b2d224cb48d64fe32ae815b1b/en_B1.png" alt="" style="max-width: 100%"> -->
                                <?php 
                                if(isset($banners) && sizeof($banners) > 0):
                                    $date = new \DateTime("now" , $timezone);
                                    foreach($banners as $banner):
                                        $start = new DateTime($banner->start_date , $timezone);
                                        $end = new DateTime($banner->end_date , $timezone);
                                        $cond1 = $date->getTimestamp() > $start->getTimestamp();
                                        $cond2 = $date->getTimestamp() < $end->getTimestamp();
                                        $cond3 = ($banner->start_date == null || $banner->start_date == "0000-00-00 00:00:00") && ($banner->end_date == null || $banner->end_date == "0000-00-00 00:00:00");
                                        if(($cond1 && $cond2) || $cond3):
                                ?>
                                <div class="col-12 col-md-4 d-flex flex-row justify-centent-center align-items-center category_menu_banner">
                              
                                    <a href="<?php echo $banner->link ?>">
                                        <img src="<?php echo base_url()?>/assets/others/category_banners_sa/<?php echo $banner->image ?>" alt="<?php echo $banner->title ?>" style="width: 100%; max-height: 100%">
                                        <!-- <img src="<?php echo base_url()?>/assets/uploads/<?php echo $banner->image ?>" alt="" style="width: 100%; max-height: 100%"> -->
                                    </a>

                                </div>
                                <?php 
                                        endif;
                                    endforeach;                                    
                                ?>
                                <?php else: ?>
                                <div class="col-12 d-flex flex-column justify-centent-center align-items-center category_menu_banner px-0">
                                    <div class="row col-12 col-md-12 m-0 p-0 flex-wrap">
                                        <?php if(true): ?>
                                        <div class="col-12 d-flex flex-row my-2 justify-content-start">
                                            <h3 style="color: black; font-size: 1rem"><?php echo lg_get_text("lg_331") ?></h3>    
                                        </div>
                                        <?php endif; ?>
                                        <?php
                                        if(isset($brands) && sizeof($brands) > 0):
                                            foreach($brands as $brand):
                                        ?>
                                        <a href="<?php echo base_url() ?>/product-list?category=<?php echo $parent_categories[$i]->category_id ?>&brand=<?php echo $brand->id ?>" class="col-6 col-md-3 py-2 px-1">
                                            <img class="border rounded" src="<?php echo base_url()?>/assets/uploads/<?php echo $brand->image ?>" alt="<?php echo $brand->title ?>" style="width: 100%; max-height: 150px;">
                                        </a>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- Sub category 2nd layer -->

                </li>

                <?php 
                    endforeach; 
                endif;
                ?>

                <!-- Other Categories  -->
                <li class="parent-element col-12 col-lg-auto align-items-center mx-sm-0 mx-md-0 mx-lg-1 py-lg-3 px-md-2 py-1 px-0">
                    <span><?php echo lg_get_text("lg_333") ?></span>
                    <span><i class="fa-solid fa-caret-down"></i></span>

                    <?php if(true): ?>
                    <!-- 2nd layer -->
                    <div class="col-12 row m-0 mt-2 mt-md-0 p-0 children-elements" style="background-color: white">
                        <div class="col-lg-4 col-12 py-2 px-0 sub-elements" style="background-color: #1d3351">
                            <ul class="col-12 p-0 pl-3">
                                <?php                                
                                foreach($other_categories as $p_id => $p_category):

                                    $parent_name =  lg_put_text($p_category["category_name"] , $p_category["category_name_arabic"] , false);
                                    $cat_level_2 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p_id){ return $category["parent_id"] == $p_id; });
                                    $show_cat_page = $p_category["show_category_page"];                        
                                    $category_url = $categoryModel->menu_category_url($p_id , $categories_urls , $show_cat_page);
                                ?>
                                <li class="py-2 row m-0 col-12 justify-content-between child-element">
                                    <span class="col-auto p-0"><a href="<?php echo $category_url ?>"><?php echo $parent_name ?></a></span> 
                                    <?php if(sizeof($cat_level_2) > 0): ?>
                                        <span class="col-auto toggler"><i class="fa-solid fa-caret-down"></i></span>
                                    <?php endif; ?>

                                    <!-- 3rd layer -->
                                    <?php if(sizeof($cat_level_2) > 0):?>
                                    <div class="col-12 row m-0 schildren-elements p-0">
                                        <div class="sub-sub-elements px-0" style="height: auto">
                                            <ul class="col-12 p-0 <?php if($lang == "AR") echo 'pr-4'; else echo 'pl-4'; ?>">

                                                <?php 
                                                foreach($cat_level_2 as $p2_id => $p2_category): 
                                                    $category_name =  lg_put_text($p2_category["category_name"] , $p2_category["category_name_arabic"] , false);
                                                    $show_cat_page = $p2_category["show_category_page"];
                                                    $category_url = $categoryModel->menu_category_url($p2_id , $categories_urls , $show_cat_page);
                                                    $cat_level_3 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p2_id){ return $category["parent_id"] == $p2_id; });
                                                ?>
                                                <li class="py-1 row m-0 col-12 justify-content-between child-element px-0">
                                                    <span><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span>
                                                    <?php if(sizeof($cat_level_3) > 0): ?>
                                                    <span class="col-auto toggler"><i class="fa-solid fa-caret-down"></i></span>
                                                    <?php endif; ?>

                                                    <!-- 4th layer -->
                                                    <?php if(sizeof($cat_level_3) > 0): ?>
                                                    <div class="col-12 row m-0 schildren-elements p-0">
                                                        <div class="sub-sub-elements px-0" style="height: auto">
                                                            <ul class="col-12 p-0 <?php if($lang == "AR") echo 'pr-4'; else echo 'pl-4'; ?>">
                                                                <?php 
                                                                foreach($cat_level_3 as $p3_id => $p3_category): 
                                                                    $category_name = lg_put_text($p3_category["category_name"] , $p3_category["category_name_arabic"] , false);
                                                                    $show_cat_page = $p3_category["show_category_page"];                       
                                                                    $category_url = $categoryModel->menu_category_url($p3_id , $categories_urls , $show_cat_page);    
                                                                ?>
                                                                <li class="py-1">
                                                                    <span><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- 4th layer -->
                                                    <?php endif; ?>
                                                </li>
                                                <?php endforeach; ?>

                                            </ul>
                                        </div>
                                    </div>
                                    <!-- 3rd layer -->

                                    <?php
                                    endif;
                                    ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-lg-8 col-12 p-0 d-flex align-items-center" style="background-color:white; min-height: 250px;height: 100%;">
                            <div class="col-12 d-flex flex-column justify-centent-center align-items-center category_menu_banner px-0">
                                <div class="row col-12 col-md-12 m-0 p-0 flex-wrap">
                                    <?php if(true): ?>
                                        <div class="col-12 d-flex flex-row my-2 justify-content-start">">
                                            <h3 style="color: black; font-size: 1rem"><?php echo lg_get_text("lg_331") ?></h3>    
                                        </div>
                                        <?php endif; ?>
                                    <?php
                                    $brands = $categoryModel->get_categories_brands($other_categories);
                                    if(sizeof($brands) > 0):
                                        foreach($brands as $brand):
                                    ?>
                                    <a href="<?php echo base_url() ?>/product-list?brand=<?php echo $brand->id ?>" class="col-6 col-md-3 py-2 px-1">
                                        <img class="border rounded" src="<?php echo base_url()?>/assets/uploads/<?php echo $brand->image ?>" alt="<?php echo $brand->title ?>" style="width: 100%; max-height: 150px;">
                                    </a>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 2nd layer -->
                    <?php endif; ?>

                </li>
                <!-- Other Categories  -->
                
                <!-- Preorders & Offers -->
                <?php if($productModel->preorders_exist()): ?>
                <li class="parent-element col-12 col-lg-auto align-items-center mx-sm-0 mx-md-0 mx-lg-1 py-lg-3 px-md-2 py-1 px-0" style="background-color:#8b006a">
                    <span><a href="<?php echo base_url() ?>/product-list/pre-orders"><?php echo lg_get_text("lg_34") ?></a></span>
                </li>
                <?php endif; ?>
                
                <?php if($productModel->offers_exist()): ?>
                <li class="parent-element col-12 col-lg-auto align-items-center mx-sm-0 mx-md-0 mx-lg-1 py-lg-3 px-md-2 py-1 px-0" style="background-color:#008b51">
                    <span><a href="<?php echo base_url() ?>/product-list/offers"><?php echo lg_get_text("lg_82") ?></a></span>
                </li>
                <?php endif; ?>
                <!-- Preorders & Offers -->
                <?php if(true): ?>
                <li class="parent-element col-12 col-lg-auto align-items-center mx-sm-0 mx-md-0 mx-lg-1 py-lg-3 px-md-2 py-1 px-0">
                    <span><a href="<?php echo base_url() ?>/blogs"><?php echo lg_get_text("lg_335") ?></a></span>
                </li>
                <?php endif; ?>

            </div>
            <!-- Menu content -->
            <?php endif; ?>


            <!-- Mobile Contact and social links -->
            <div class="col-12 row m-0 my-3 justify-content-around align-items-center mobile-contact-infos">
                

                <!-- Online Store location -->
                <div class="col-auto p-0 d-md-none ws-online-locations">
                    <div class="dropdown">
                      <button class="dropdown-toggle text-white" style="border: none; background: transparent; outline: none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Online Location
                      </button>
                      <div class="dropdown-menu" style="background: #000d19" aria-labelledby="dropdownMenu2">
                        <a href="https://zgames.ae">
                            <div class="dropdown-item d-flex flex-row justify-content-between ">
                                <div class="col-5 p-0 ">
                                    <span class="text-white">UAE</span>
                                </div>
                                <div class="col-auto p-0">
                                    <img src="https://zgames.ae/assets/others/stores/uae_flag.png" height="25px" width="auto" alt="">
                                </div>
                            </div>
                        </a>
                        
                      </div>
                    </div>
                </div>
                <!-- Online Store location -->

                <div class="col-auto d-none">
                    <div class="vl"></div>
                </div>
                
                <!-- Our Stores -->
                <div class="col-5 d-flex flex-row justify-content-center align-items-center stores-location me-2">
                    <div class="col-auto p-0">
                        <i class="fa-sharp fa-solid fa-location-dot"></i>
                    </div>
                    <div class="col-auto <?php if($lang == "AR") echo 'mr-2'; else echo 'ml-2' ?> p-0">
                        <a href="<?php echo base_url() ?>/page/ourstores">
                            <span>Our Stores</span>
                        </a>
                    </div>
                </div>
                <!-- Our Stores -->

                <!-- Social Links -->
                <div class="col-12 d-flex flex-row justify-content-center align-items-center social-links mt-4 py-3" style="font-size: 1.8rem">
                    <div class="col-auto <?php if($lang == "AR") echo 'ml-3'; else echo 'mr-3' ?> p-0">
                        <a href="<?php echo $settings[0]->facebook ?>">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                    </div>
                    <div class="col-auto <?php if($lang == "AR") echo 'ml-3'; else echo 'mr-3' ?> p-0">
                        <a href="<?php echo $settings[0]->instagram ?>">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                    <div class="col-auto p-0">
                        <a href="<?php echo $settings[0]->tiktok ?>">
                            <i class="fa-brands fa-tiktok"></i>
                        </a>
                    </div>
                </div>
                <!-- Social Links -->

            </div>
            <!-- Mobile Contact and social links -->
        </ul>

    </div>  
</div>
<!-- Main menu End -->