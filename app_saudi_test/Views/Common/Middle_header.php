<?php 
    $lang = get_cookie("language"); 
?>      
    <style>
        header .site-identity .ws-Search-bar .search-icon{
            font-size: .85rem
        }
        .search-icon .ws-search-category-filter{
            /* font-size: 1rem; */
            height: 100%; 
            border: none; 
            outline: none;
            border: 0!important;
            background: none;
        }

        .search-category-filter-list{
            position: absolute;
            top: 100%;
            right: 0px;
            background-color: rgb(248, 248, 248);
            color: rgb(44, 44, 44);
            font-size: .85rem;
            list-style: none;
            z-index: 100;
            box-shadow: rgba(0, 0, 0, 0.082) 1px 0px 10px;
            display: none;
        }

        .search-category-filter-list li:hover{
            background-color: rgb(233, 233, 233);
        }

        .search-category-filter-list li.selected{
            background: #e4edff;
        }

        .search-category-filter-list .ws-sc-separator span{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50% ,-50%);
            background: #f8f8f8;
            color: #838383;
            font-size: .8rem;
        }

        .search-icon .ws-search-category-filter::after{
            content: "";
            width: 8px;
            height: 8px;
            background-color: white;
            position: absolute;
            <?php if(get_cookie("language") == "AR"): ?>
            left: 10px;
            <?php else: ?>
            right: 10px;
            <?php endif; ?>
            transform: translateY(-70%) rotate(45deg);
            top: 50%;
            transform-origin: center;
            clip-path: polygon(100% 0% , 100% 100% , 0% 100%);
        }

        header .site-identity .ws-Search-bar .search-icon{
            background: #007ef1;
            color: white;
            <?php if(get_cookie("language") == "AR"): ?>
            left: 0;
            <?php else: ?>
            right: 0
            <?php endif; ?>
        }

        .ws-search-button{
            <?php if(get_cookie("language") == "AR"): ?>
            border-right: 1px rgba(255, 255, 255, 0.281) solid ;
            <?php else: ?>
            border-left: 1px rgba(255, 255, 255, 0.281) solid ;
            <?php endif; ?>

        }

    </style>
            <!-- Middle bar -->
            <div class="row site-identity justify-content-center py-3" <?php content_from_right() ?>>
                
                <div class="row col-12 p-0 m-0 justify-content-between">
                    <!-- WebSite Logo & mobile menu trigger -->
                    <div class="col-6 col-md-3 col-lg-2 d-flex flex-row justify-content-start align-items-center">
                        <div class="menu-bars col-auto px-3 py-2">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                        <div class="col-auto col-lg-12 d-flex flex-row justify-content-center align-items-center ps-0 ps-md-3 ws-logo">
                            <a href="<?php echo base_url() ?>">
                                <img class="logo" alt="<?php echo $settings[0]->business_name ?>" src="<?php echo base_url() ?>/assets/uploads/ZGames_550px_W.png">
                            </a>
                        </div>
                    </div>
                    <!-- WebSite Logo & mobile menu trigger -->

                    <!-- WebSite desktop Search Bar -->
                    <div class="col-12 col-md-6 col-lg-8 d-flex flex-row justify-content-center align-items-center ws-Search-bar ws-Search-bar-desktop">
                        <form class="col-12 col-md-10 search_form px-0" action="<?php echo base_url()?>/product-list" style="position:relative">
                            <div class="row p-0 m-0" style="z-index:11; width: 100%; max-height:690px; min-width:350px; overflow-y: scroll; position: absolute; top:100%; background-color:gray">
                                <div class="result row col-12 j-c-center m-0 px-0">
                                </div>
                            </div>
                            <div class="search-icon col-6 col-lg-3 d-flex flex-row justify-content-between align-items-center p-0">
                                <select hidden name="ws-search-category" id="ws-search-category">
                                    <option value="all"></option>
                                    <option value="video-games"></option>
                                    <option value="accessories"></option>
                                    <option value="pc-and-consoles"></option>
                                    <option value="merchandize"></option>
                                    <option value="other"></option>
                                </select>
                                <div class="col-9 ws-search-category-filter d-flex flex-column justify-content-center pr-0">
                                    <p class="mr-3 m-0 p-0 <?php text_from_right(true) ?>">
                                        <?php switch ($_GET["ws-search-category"]) {
                                            case 'video-games':
                                                # code...
                                                $p = lg_get_text("lg_338");
                                                break;

                                            case 'accessories':
                                                # code...
                                                $p = lg_get_text("lg_100");
                                                
                                                break;
                                            case 'pc-and-consoles':
                                                # code...
                                                $p = lg_get_text("lg_381");
                                                break;

                                            case 'merchandize':
                                                # code...
                                                $p = lg_get_text("lg_338");
                                                break;

                                            case 'other':
                                                # code...
                                                $p = lg_get_text("lg_333");
                                                break;
                                            
                                            default:
                                                # code...
                                                $p = lg_get_text("lg_383");
                                                break;
                                        };
                                        
                                        echo ucfirst(strtolower($p));
                                        ?>

                                    </p>
                                </div>
                                <ul class="col-12 search-category-filter-list px-0 m-0 border">
                                    <li class="<?php if(!isset($_GET["ws-search-category"])) echo 'selected'?> py-2 ws-sc-filter pl-4 selected"><?php echo ucfirst(strtolower(lg_get_text("lg_383"))) ?></li>
                                    <li class="border-top ws-sc-separator my-3" style="position: relative;"><span><?php lg_put_text("Product type" , "نوع المنتج") ?></span></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "video-games") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_338"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "accessories") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_100"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "pc-and-consoles") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_381"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "merchandize") echo 'selected' ?> py-2 ws-sc-filter pl-4"><?php echo ucfirst(strtolower(lg_get_text("lg_382"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "other") echo 'selected' ?> py-2 ws-sc-filter pl-4"><?php echo ucfirst(strtolower(lg_get_text("lg_333"))) ?></li>
                                </ul>
                                <div class="col-2 p-0 d-flex flex-row justify-content-center ws-search-button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                            <input name="keyword" required type="text" class="form-control pr-2 col-6 col-lg-9" id="search_bar" placeholder="<?php echo lg_get_text("lg_118") ?>">
                            
                        </form>
                    </div>
                    <!-- WebSite desktop Search Bar -->

                    <!-- Cart & WishList & logged-in menu  -->
                    <div class="col-auto col-md-3 col-lg-2 d-flex flex-row justify-content-end pl-3 ws-cart-section">

                        <!-- <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-wishlist ml-3 p-0">
                            <div class="col-auto p-0">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                        </div> -->

                        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-cart ml-0 <?php if($lang == "AR") echo "pr-0"; else echo "pl-0" ?>">
                            <div class="col-auto p-0" style="position: relative">
                                <div class="ws-cart-count counter_cart col-auto d-flex flex-row justify-content-center align-items-center p-2 m-0">
                                    <?php 
                                        if(isset($cart_count))
                                        echo sizeof($cart_count);
                                        else 
                                        echo 0;
                                    ?>
                                </div>
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>  
                        </div>

                        <?php if($user_loggedin): ?>
                        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-user ml-0">
                            <div class="col-auto p-0">
                                <i class="fa-solid fa-user"></i>
                                <div class="user-menu row m-0 px-2 <?php if($lang == "EN") echo "user-menu-eng"; else echo "user-menu-ara"; ?>">
                                    <div class="col-12 p-0 py-2 px-1 <?php text_from_right() ?>"><a href="<?php echo base_url() ?>/profile"><span><?php echo lg_get_text("lg_88") ?></span></a></div>
                                    <div class="col-12 p-0 py-2 px-1 <?php text_from_right() ?>"><a href="<?php echo base_url() ?>/profile/wishlist"><span><?php echo lg_get_text("lg_253") ?></span></a></div>
                                    <div class="col-12 p-0 py-2 px-1 <?php text_from_right() ?>"><a href="<?php echo base_url() ?>/profile/changePassword"><span><?php echo lg_get_text("lg_89") ?></span></a></div>
                                    <div class="col-12 p-0 py-2 px-1 <?php text_from_right() ?>"><a href="<?php echo base_url() ?>/logout"><span><?php echo lg_get_text("lg_90") ?></span></a></div>
                                </div>
                            </div>  
                        </div>
                        <?php endif; ?>


                    </div>
                    <!-- Cart & WishList  -->

                </div>
                <!-- WebSite mobile Search Bar -->
                <div class="col-12 flex-row justify-content-center align-items-center ws-Search-bar ws-Search-bar-mobile mt-3">
                    
                    <form class="col-12 col-md-10 search_form px-0" action="<?php echo base_url()?>/product-list" style="position:relative">
                        <div class="p-0" style="z-index:11; width: 100%; max-height:690px; min-width:350px; overflow-y: scroll; position: absolute; top:100%; background-color:gray">
                            <div class="result row col-12 j-c-center m-0 px-0">
                            </div>
                        </div>
                        <div class="search-icon col-6 col-lg-3 d-flex flex-row justify-content-between align-items-center p-0">
                                <select hidden name="ws-search-category" id="ws-search-category">
                                    <option value="all"></option>
                                    <option value="video-games"></option>
                                    <option value="accessories"></option>
                                    <option value="pc-and-consoles"></option>
                                    <option value="merchandize"></option>
                                    <option value="other"></option>
                                </select>
                                <div class="col-auto ws-search-category-filter d-flex flex-column justify-content-center pr-4">
                                    <p class="mr-3 m-0 p-0 <?php text_from_right(true) ?>">
                                        <?php switch ($_GET["ws-search-category"]) {
                                            case 'video-games':
                                                # code...
                                                $p = lg_get_text("lg_338");
                                                break;

                                            case 'accessories':
                                                # code...
                                                $p = lg_get_text("lg_100");
                                                
                                                break;
                                            case 'pc-and-consoles':
                                                # code...
                                                $p = lg_get_text("lg_381");
                                                break;

                                            case 'merchandize':
                                                # code...
                                                $p = lg_get_text("lg_338");
                                                break;

                                            case 'other':
                                                # code...
                                                $p = lg_get_text("lg_333");
                                                break;
                                            
                                            default:
                                                # code...
                                                $p = lg_get_text("lg_383");
                                                break;
                                        };
                                        
                                        echo ucfirst(strtolower($p));
                                        ?>
                                    </p>
                                </div>
                                <ul class="col-12 search-category-filter-list px-0 m-0 border">
                                    <li class="<?php if(!isset($_GET["ws-search-category"])) echo 'selected'?> py-2 ws-sc-filter pl-4 selected"><?php echo ucfirst(strtolower(lg_get_text("lg_383"))) ?></li>
                                    <li class="border-top ws-sc-separator my-3" style="position: relative;"><span><?php lg_put_text("Product type" , "" , true) ?></span></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "video-games") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_338"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "accessories") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_100"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "pc-and-consoles") echo 'selected' ?> py-2 ws-sc-filter pl-4 border-bottom"><?php echo ucfirst(strtolower(lg_get_text("lg_381"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "merchandize") echo 'selected' ?> py-2 ws-sc-filter pl-4"><?php echo ucfirst(strtolower(lg_get_text("lg_381"))) ?></li>
                                    <li class="<?php if(isset($_GET["ws-search-category"]) && $_GET["ws-search-category"] == "other") echo 'selected' ?> py-2 ws-sc-filter pl-4"><?php echo ucfirst(strtolower(lg_get_text("lg_333"))) ?></li>
                                </ul>
                                <div class="col-2 p-0 d-flex flex-row justify-content-center ws-search-button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </div>
                            </div>
                        <input name="keyword" type="text" class="form-control pr-1 col-6 col-lg-9" id="search_bar_mobile" placeholder="<?php echo lg_get_text("lg_118") ?>">
                        
                    </form>
                </div>
                <!-- WebSite mobile Search Bar -->

            </div>
            <!-- Middle bar -->