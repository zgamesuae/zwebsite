<?php 
    $lang = get_cookie("language"); 
?>

<!-- Top bare content -->
<div class="row top-bar py-2 " <?php content_from_right() ?>>

    <!-- Top Bare Left Side -->
    <div class="col-6 row m-0">
        <!-- Social Links -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center social-links me-2">
            <div class="col-auto <?php if($lang == "AR") echo "ml-3"; else echo "mr-3" ?> p-0">
                <a href="<?php echo $settings[0]->facebook ?>">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
            <div class="col-auto <?php if($lang == "AR") echo "ml-3"; else echo "mr-3" ?> p-0">
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

        <!-- Contact Number -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center contact-number me-2">
            <div class="col-auto p-0">
                <i class="fa-solid fa-phone"></i>
            </div>
            <div class="col-auto <?php if($lang == "AR") echo "mr-2"; else echo "ml-2" ?> p-0">
                <a href="tel:<?php echo trim($settings[0]->phone) ?>" dir="ltr">
                    <span ><?php echo $settings[0]->phone ?></span>
                </a>
            </div>
        </div>
        <!-- Contact Number -->

        <!-- Our Stores Location -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-stores-location me-2">
            <div class="col-auto p-0">
                <i class="fa-sharp fa-solid fa-location-dot"></i>
            </div>
            <div class="col-auto <?php if($lang == "AR") echo "mr-2"; else echo "ml-2" ?> p-0">
                <a href="<?php echo base_url() ?>/page/ourstores">
                    <span><?php echo lg_get_text("lg_10") ?></span>
                </a>
            </div>
        </div>
        <!-- Our Stores Location -->

    </div>
    <!-- Top Bare Left Side -->

    <!-- Top Bare Right Side -->
    <div class="col-6 row m-0 justify-content-end">
        <!-- Select Store -->
        <div class="col-auto d-none d-md-block ws-online-locations">
            <div class="dropdown">
              <button class="dropdown-toggle" style="border: none; background: transparent; outline: none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Online Location
              </button>
              <div class="dropdown-menu" style="background: #000d19" aria-labelledby="dropdownMenu2">
                <a href="https://zgames.ae">
                    <div class="dropdown-item d-flex flex-row justify-content-between ">
                        <div class="col-5 p-0 ">
                            <span>UAE</span>
                        </div>
                        <div class="col-auto p-0">
                            <img src="https://zgames.ae/assets/others/stores/uae_flag.png" height="25px" width="auto" alt="">
                        </div>
                    </div>
                </a>
              </div>
            </div>
        </div>
        <!-- Select Store -->

        <!-- Select Language -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-language ms-2">
            <div class="col-auto p-0">
                <i class="fa-sharp fa-solid fa-globe"></i>
            </div>
            <div class="col-auto ml-2 <?php if($lang == "AR") echo "mr-2"; else echo "ml-2" ?> p-0">
                <?php if(null !== get_cookie("language") && get_cookie("language") == "AR"):?>
                <a href="javascript:void()" onClick="change_language('EN')">
                    <span>English</span>
                </a>
                <?php else: ?>
                <a href="javascript:void()" onClick="change_language('AR')">
                    <span>عربية</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
        <!-- Select Language -->

        <?php if(!$user_loggedin): ?>
        <!-- Login to account -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-login ms-2">
            <div class="col-auto p-0">
                <i class="fa-solid fa-right-to-bracket"></i>
            </div>
            <div class="col-auto <?php if($lang == "AR") echo "mr-2"; else echo "ml-2"; ?> p-0">
                <a href="javascript:void()" data-toggle="modal" data-target="#login-modal" data-form="login" onClick="get_form(this.getAttribute('data-form'))">
                    <span><?php echo lg_get_text("lg_83") ?></span>
                </a>
            </div>
        </div>
        <!-- Login to account -->

        <!-- Create Account -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-register ms-2">
            <!-- <div class="col-auto">
                <i class="fa-sharp fa-solid fa-globe"></i>
            </div> -->
            <div class="col-auto <?php if($lang == "AR") echo "mr-2"; else echo "ml-2"; ?> p-0">
                <a href="javascript:void()" data-toggle="modal" data-target="#login-modal" data-form="register" onClick="get_form(this.getAttribute('data-form'))">
                    <span><?php echo lg_get_text("lg_146") ?></span>
                </a>
            </div>
        </div>
        <!-- Create Account -->
        <?php else: ?>
        <!-- User greating -->
        <div class="col-auto d-flex flex-row justify-content-between align-items-center ws-user-greating ms-2">
            <!-- <div class="col-auto">
                <i class="fa-sharp fa-solid fa-globe"></i>
            </div> -->
            <div class="col-auto ml-2 p-0">
                <span>Welcome <?php echo $user_details[0]->name ?></span>
            </div>
        </div>
        <!-- User greating -->

        <?php endif; ?>


    </div>
    <!-- Top Bare Right Side -->

</div>
<!-- Top bare content -->