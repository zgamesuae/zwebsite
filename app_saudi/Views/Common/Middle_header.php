<?php 
    $lang = get_cookie("language"); 
?>      
            <!-- Middle bar -->
            <div class="row site-identity justify-content-center py-3" <?php content_from_right() ?>>
                
                <div class="row col-12 col-md-10 col-lg-12 p-0 m-0 justify-content-between">
                    <!-- WebSite Logo & mobile menu trigger -->
                    <div class="col-6 col-md-3 col-lg-2 d-flex flex-row justify-content-start align-items-center">
                        <div class="menu-bars col-auto px-3 py-2">
                            <i class="fa-solid fa-bars"></i>
                        </div>
                        <div class="col-auto col-lg-12 d-flex flex-row justify-content-center align-items-center ps-0 ps-md-3 ws-logo">
                            <a href="<?php echo base_url() ?>">
                                <img class="logo" alt="<?php echo $settings[0]->business_name ?>" src="https://zgames.ae/assets/uploads/ZGames_550px_W.png">
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
                            <div class="search-icon d-flex flex-row justify-content-center align-items-center px-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <input name="keyword" required type="text" class="form-control pr-5" id="search_bar" placeholder="<?php echo lg_get_text("lg_118") ?>">
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
                        <div class="search-icon d-flex flex-row justify-content-center align-items-center px-3">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <input name="keyword" type="text" class="form-control pr-5" id="search_bar_mobile" placeholder="<?php echo lg_get_text("lg_118") ?>">
                    </form>
                </div>
                <!-- WebSite mobile Search Bar -->

            </div>
            <!-- Middle bar -->