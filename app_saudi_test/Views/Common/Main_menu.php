
<?php
    $lang = get_cookie("language"); 
    $categoryModel = $GLOBALS["category_model"];
    $productModel = model("App\Model\ProductModel");
    // filter only menu Categories
    $categoryModel->filter_menu_categories();
    $parent_categories = $categoryModel->get_parent_categories(0,20);
    // $other_categories = $categoryModel->get_parent_categories(5,10);
    $categories_urls = $categoryModel->categories_urls();

    // var_dump($categories_urls);
    // $brands = $categoryModel->get_categories_brands($other_categories);
    // var_dump($other_categories);
    // var_dump($categoryModel->get_category_hierarchy());


    // die();
?>
    
<?php if(false): ?>
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
            <div class="col-12 row m-0 my-3 justify-content-between align-items-center mobile-contact-infos">

                <!-- Online Store location -->
                <div class="col-auto p-0 d-md-none ws-online-locations">
                    <div class="dropdown">
                      <button class="dropdown-toggle text-white" style="border: none; background: transparent; outline: none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo lg_get_text("lg_373") ?>
                        <img src="<?php echo base_url() ?>/assets/others/stores/ksa_flag.png" height="25px" width="auto" alt="">
                      </button>
                      <div class="dropdown-menu" style="background: #000d19" aria-labelledby="dropdownMenu2">
                        <a href="<?php echo base_url() ?>">
                            <div class="dropdown-item d-flex flex-row justify-content-between ">
                                <div class="col-5 p-0 ">
                                    <span class="text-white"><?php echo lg_get_text("lg_374") ?></span>
                                </div>
                                <div class="col-auto p-0">
                                    <img src="<?php echo base_url() ?>/assets/others/stores/uae_flag.png" height="25px" width="auto" alt="">
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

                <div class="col-12 d-flex flex-row justify-content-center align-items-center social-links mt-4 py-3">
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

            </div>
            <!-- Mobile Contact and social links -->
        </ul>

    </div>  
</div>
<!-- Main menu End -->
<?php endif; ?>

<style>

    /* Main Menu Element Styling */
        .ws-main-menu-element-1{
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border: 0px!important;        
            z-index: 1;
            position: unset;
            min-width: 150px;
            cursor: pointer;
        }
    
        .ws-main-menu-element-1 > *{
            font-size: 16px!important;       
        }
    
        ul li.ws-main-menu-element-1{
            background-color: #007ef1;
        }
        /* ul > li.ws-main-menu-element-1:first-child{
            background-color: #1e4da5;
        } */
    
        ul li.ws-main-menu-element-1:hover{
            background-color: #026bcb;
            box-shadow: #060606e8 0px 0px 7px;
        }

    /* Main Menu Element Styling */


    /* Categories layer */
        .main-menu-categories{
            position: absolute;
            top: 100%;
            left: 0;
            min-height: 400px;
            /* background-color: #254058; */
            display: none;
            background: #032546;
        }

        .main-menu-categories ul{
            max-height: 600px;
            overflow-y: scroll;
            overflow-x: visible;
            <?php if(get_cookie("language") == "AR"): ?>
            direction: ltr;
            <?php else: ?>
            direction: rtl;
            <?php endif; ?>
        }

        .ws-sm{
            position: absolute;

            <?php if(get_cookie("language") == "AR"): ?>
            right:100%;
            <?php else: ?>
            left:100%;
            <?php endif; ?>

            top: 0;
            width: 300%;
            height: 100%;
            display: none;
        }
        

        .sub-menu-categories,.sub-menu-categories-sub{
            position: absolute;
            top: 0;
            left: 100%;
            width: 100%;
            background: #0e324d;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.863);
            z-index: 10;
            /* height: 100%; */
        }

        /* @media screen and (min-width: 800px) { */
            .menu-element:hover{
                border-bottom: 1px #3b4750 solid;
                background: linear-gradient(to top, #2151ab5c 15%, transparent);
            }
        /* } */

        .menu-element{
            /* border: 0!important; */
            cursor: pointer;
            position: unset;
        }

        .main-menu-categories .sub-categories{
            background: #032546;
            position: absolute;
            top: 0;

            <?php if(get_cookie("language") == "AR"): ?>
            right:100%;
            <?php else: ?>
            left:100%;
            <?php endif; ?>

            width: 100%;
            height: 100%;
            display: none;
            font-size: .8rem;
            transition: all 0s .5s ease;
        }

        .main-menu-categories .sub-categories-sub{
            background: #032546;
            /* position: absolute; */
            top: 0;
            /* left: 100%; */
            /* width: 100%; */
            height: 100%;
            /* display: none; */
            font-size: .8rem;
            transition: all 0s .5s ease;
        }
        .main-menu-categories .category-media{
            /* position: absolute; */
            top: 0;
            /* left: 300%;  */
            width: 100%;
            height: 100%;
            /* display: none; */
            /* transition: all 0s .5s ease; */
        }
        .main-menu-categories .sub-categories , .main-menu-categories .sub-categories-sub ul{
            /* overflow-y: scroll; */
            /* overflow-x: visible; */
            /* max-height: 100%; */
            <?php if(get_cookie("language") == "AR"): ?>
            direction: ltr;
            <?php else: ?>
            direction: rtl;
            <?php endif; ?>
        }
        .main-menu-categories .sub-categories{
            z-index: 4;
        }
        .main-menu-categories .sub-categories-sub{
            z-index: 5;
        }
        .main-menu-categories .sub-categories > ul, .main-menu-categories .sub-categories-sub > ul{
            height: inherit;
        }
        .sub-categories::-webkit-scrollbar , .sub-categories::-webkit-scrollbar{
            display: none;
        }

        .sub-categories ul::-webkit-scrollbar , .sub-categories-sub ul::-webkit-scrollbar , .main-menu-categories ul::-webkit-scrollbar{
            background: #021b32;
            width: 8px;
        }
        .sub-categories ul::-webkit-scrollbar-thumb , .sub-categories-sub ul::-webkit-scrollbar-thumb , .main-menu-categories ul::-webkit-scrollbar-thumb{
            background: #7996b1;
        }

        .main-menu .layer > div:first-child::after {
            content: "";
            width: 8px;
            height: 8px;
            background-color: white;
            position: absolute;
            <?php if(get_cookie("language") == "AR"): ?>
            left: 0;
            transform: rotate(135deg) translateY(-50%);
            <?php else: ?>
            right: 0;
            transform: rotate(-45deg) translateY(-50%);
            <?php endif; ?>
            top: 50%;
            transform-origin: center;
            clip-path: polygon(100% 0% , 100% 100% , 0% 100%);
        }

        .main-menu-categories .categories-side{
            background: #004e95;
            min-height: 400px;
            z-index: 1;
            
        }

        .categories-side > ul li.menu-element.layer:hover > .category-media{
            display: flex
        }


    /* Categories layer */

    /* Desktop Menu */
    /* @media screen and (min-width: 800px) { */
        .menu-element:hover > .sub-categories , .menu-element:hover > .sub-categories-sub {
            display: block;
        }
        .menu-element:hover > .ws-sm{
            display: flex;
        }
    /* } */
    /* Desktop Menu */

    /* Mobile Menu */
    @media screen and (max-width: 992px){
        
        .main-menu-categories{
            top: unset;
            position:unset;
        }

        ul li.ws-main-menu-element-1{
            border-bottom: #ffffff0d 1px solid!important;
        }
        ul > li.ws-main-menu-element-1{
            background: #007ef1;
        }

        .ws-sm{
            position: unset;
            left:0;
            top: 0;
            width: 100%;
        }

        .sub-menu-categories,.sub-menu-categories-sub{
            position: unset;
            top: unset;
            left: 0;
            width: 100%;
            background: #0e324d;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.863);
            z-index: 10;
            /* height: 100%; */
        }
        .main-menu-categories .sub-categories-sub , .main-menu-categories .sub-categories{
            background: none!important;
        }
        .main-menu-categories .sub-categories{
            position: unset;
            left: 0;
            width: 100%;
            height: 100%;
        }
        /* .main-menu-categories .sub-categories > ul, .main-menu-categories .sub-categories-sub > ul{
            
        } */
        .main-menu-categories ul{
            overflow-y: unset;
            height: auto!important;
            max-height: unset!important
        }

        .main-menu{
            overflow-y: scroll;
        }

        .main-menu .layer:hover > div:first-child::after{
            transform: rotate(45deg) translateY(-50%);
        }
    }
    /* Mobile Menu */

</style>

<div class="row justify-content-center menu col-md-8 col-lg-12 m-0 p-0">
    <div class="main-menu col-12 justify-content-center align-content-start py-0 p-0 m-0 <?php text_from_right() ?>" <?php content_from_right() ?>>
        
        <!-- Close button on mobile -->
        <div class="close-menu d-lg-none col-12 row m-0 m-0 py-3 justify-content-center" style="font-size:1.2rem; position: sticky; top:0px; background: #003b72; z-index: 100 ">
            <!-- <i class="fa-solid fa-arrow-left" style="color:white"></i> -->
            <i class="fa-solid fa-xmark col-auto p-0"  style="color:white"></i>
        </div>
        <!-- Close button on mobile -->

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
        
        <ul class=" col-12 row justify-content-between align-content-center m-0 px-0" style="position: relative;">

            <li class="ws-main-menu-element-1 align-items-center col-12 col-lg-3 my-0 px-0 py-1 text-center">
                <div class="col-12 d-flex align-items-center justifry-content-end toggler">
                    <span class="m-2"><i class="fa-solid fa-bars"></i></span>
                    <span><?php echo lg_get_text("lg_11") ?></span>
                </div>


                <!-- Category List -->
                <div class="main-menu-categories col-12 p-0 row m-0 p-0">
                    <div class="categories-side col-12 col-lg-3 p-0 pb-3">
                        <ul class="d-flex flex-column p-0 m-0">
                            <?php
                            foreach($parent_categories as $p_id => $p_category):

                                $parent_name =  lg_put_text($p_category["category_name"] , $p_category["category_name_arabic"] , false);
                                $show_cat_page = $p_category["show_category_page"];                        
                                $category_url = $categoryModel->menu_category_url($p_id , $categories_urls , $show_cat_page);
                                $cat_level_2 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p_id){ return $category["parent_id"] == $p_id; });
        
                                $banners = $categoryModel->get_category_menu_banners($p_id , 'Menu');
                                $brands = $categoryModel->get_category_brands($p_id);
                            ?>
                            <li class="menu-element <?php if(sizeof($cat_level_2)) echo "layer"; ?> col-12 p-3 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> m-0">
                                <div class="col-12 p-0">
                                    <span><a href="<?php echo $category_url ?>"><?php echo $parent_name ?></a></span>
                                </div>
                                <?php if(true): ?>
                                <div class="ws-sm flex-column flex-md-row justify-content-between flex-md-row-reverse p-0 m-0 align-items-center">
                                    <?php if(sizeof($cat_level_2) > 0): ?>
                                    <div class="sub-categories-sub px-0 py-3 col-12 col-lg-4" >
                                        <ul class="row align-content-start p-0 m-0">
                                            <?php foreach ($cat_level_2 as $p2_id => $p2_category): 
                                                $category_name = lg_put_text($p2_category["category_name"] , $p2_category["category_name_arabic"] , false);
                                                $category_url = $categoryModel->menu_category_url($p2_id , $categories_urls , $show_cat_page);
                                                $show_cat_page = $p_category["show_category_page"];
                                                $cat_level_3 = array_filter($GLOBALS["category_model"]->categories , function($category)use(&$p2_id){ return $category["parent_id"] == $p2_id; });
                                            ?>
                                            <li class="menu-element <?php if(sizeof($cat_level_3)) echo "layer"; ?> col-12 px-3 py-2 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> m-0">
                                                <div class="col-12 p-0 m-0">
                                                    <span><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span>
                                                </div>
                                                <?php if(sizeof($cat_level_3) > 0):?>
                                                <div class="sub-categories px-0 py-3" >
                                                    <ul class="row align-content-start p-0 m-0">
                                                        <?php foreach($cat_level_3 as $p3_id => $p3_category ):
                                                            $category_name = lg_put_text($p3_category["category_name"] , $p3_category["category_name_arabic"] , false);
                                                            $show_cat_page = $p3_category["show_category_page"];
                                                            $category_url = $categoryModel->menu_category_url($p3_id , $categories_urls , $show_cat_page);
                                                        ?>
                                                        <li class="menu-element col-12 px-3 py-2 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> m-0">
                                                            <div class="col-12 p-0 m-0">
                                                            <span><a href="<?php echo $category_url ?>"><?php echo $category_name ?></a></span>
                                                            </div>
                                                        </li>
                                                        <?php endforeach; ?>
                                                        
                                                    </ul>
                                                </div>
                                                <?php endif; ?>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                                        
                                    <div class="category-media p-0 row align-content-center justify-content-center col-12 col-lg-4">
                                    <div class="col-12 row align-content-center">
                                            <?php
                                            if(sizeof($banners) > 0):
                                            ?>
                                                <div class="owl-carousel owl-theme catpage_h_slider_two" dir="ltr">
                                                    <?php 
                                                    foreach($banners as $banner):
                                                    ?>
                                                    <div class="item col-12 p-0" style="height:auto">
                                                        <a href="<?php echo $banner->link ?>">
                                                            <img class="rounded col-12" alt="<?php echo $banner->title ?>" src="<?php echo base_url()?>/assets/others/category_banners_sa/<?php echo $banner->image ?>">
                                                        </a>
                                                    </div>
                                                    <?php 
                                                    endforeach;
                                                    ?>
                                                </div>
                                            <?php
                                            elseif(isset($brands) && sizeof($brands) > 0):
                                            ?>
                                                <div class="col-12 d-flex flex-row my-2 justify-content-center">
                                                    <h3 style="color: white; font-size: 1rem"><?php echo lg_get_text("lg_331") ?></h3>    
                                                </div>
                                                <?php
                                                foreach($brands as $brand):
                                                ?>
                                                <a href="<?php echo base_url() ?>/product-list?category=<?php echo $p_id ?>&brand=<?php echo $brand->id ?>" class="col-6 py-2 px-1">
                                                    <img class="border rounded" src="<?php echo base_url() ?>/assets/uploads/<?php echo $brand->image ?>" alt="<?php echo $brand->title ?>" style="width: 100%; max-height: 150px;">
                                                </a>
                                                <?php
                                                endforeach;
                                                ?>
                                            <?php 
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                          
                        </ul>
                    </div>
                </div>
                <!-- Category List -->


            </li>
            <div class="col-12 col-lg-9 p-0 m-0 row justify-content-end">
                <?php if($productModel->preorders_exist()): ?>
                <li class="ws-main-menu-element-1 col-12 col-lg-auto my-0 mx-0 mx-lg-1 p-3 p-md-1 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> text-lg-center">
                    <a href="<?php echo base_url() ?>/product-list/pre-orders" class="p-0 p-md-2 d-block"><?php echo lg_get_text("lg_34") ?></a>
                </li>
                <?php endif; ?>

                <?php if($productModel->offers_exist()): ?>
                <li class="ws-main-menu-element-1 col-12 col-lg-auto my-0 mx-0 mx-lg-1 p-3 p-md-1 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> text-lg-center">
                    <a href="<?php echo base_url() ?>/product-list/offers" class="p-0 p-md-2 d-block"><?php echo lg_get_text("lg_82") ?></a>
                </li>
                <?php endif; ?>
                <li class="ws-main-menu-element-1 col-12 col-lg-auto my-0 mx-0 mx-lg-1 p-3 p-md-1 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> text-lg-center">
                    <a href="<?php echo base_url() ?>/product-list?new_realesed=Yes" class="p-0 p-md-2 d-block"><?php echo lg_get_text("lg_134") ?></a>
                </li>
                <li class="ws-main-menu-element-1 col-12 col-lg-auto my-0 mx-0 mx-lg-1 p-3 p-md-1 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> text-lg-center">
                    <a href="<?php echo base_url() ?>/blogs" class="p-0 p-md-2 d-block"><?php echo lg_get_text("lg_335") ?></a>
                </li>
                <!-- <li class="ws-main-menu-element-1 col-12 col-lg-auto my-0 mx-0 mx-lg-1 p-3 p-md-1 <?php if(text_from_right(false) =="") echo "text-left "; else echo "text-right"; ?> text-lg-center">
                    <a href="" class="p-0 p-md-2 d-block">Best Sellers</a>
                </li> -->
            </div>

            <!-- Mobile Contact and social links -->
            <div class="col-12 row m-0 my-3 px-1 justify-content-between align-items-center mobile-contact-infos">
                

                <!-- Online Store location -->
                <div class="col-auto p-0 d-lg-none ws-online-locations">
                    <div class="dropdown">
                      <button class="dropdown-toggle text-white" style="border: none; background: transparent; outline: none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo lg_get_text("lg_373") ?>
                        <img src="<?php echo base_url() ?>/assets/others/stores/uae_flag.png" height="25px" width="auto" alt="">
                      </button>
                      <div class="dropdown-menu" style="background: #000d19" aria-labelledby="dropdownMenu2">
                        <a href="https://zgames.ae">
                            <div class="dropdown-item d-flex flex-row justify-content-between ">
                                <div class="col-5 p-0 ">
                                    <span class="text-white"><?php echo lg_get_text("lg_375") ?></span>
                                </div>
                                <div class="col-auto p-0">
                                    <img src="<?php echo base_url() ?>/assets/others/stores/uae_flag.png" height="25px" width="auto" alt="">
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