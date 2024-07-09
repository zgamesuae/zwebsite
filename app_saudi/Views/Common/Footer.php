<?php  
$uri = service('uri'); 
$sql="select * from settings";
$settings=$GLOBALS["userModel"]->customQuery($sql);
$sql="select * from cms";
$cms=$GLOBALS["userModel"]->customQuery($sql);
 
$master_category =  array_filter($GLOBALS["category_model"]->categories , function($category){
                        return ($category["parent_id"] == "0" && $category["show_in_menu"] == "Yes"); 
                    });

?>

<div data-growl="container" class="alert alert-success growl-animated animated bounceInDown" role="alert" data-growl-position="top-right" style="position: fixed; margin: 0px; z-index: 1031; display: none; top: 20px; right: 20px;" id="toast">
</div>
<div data-growl="container" class="alert alert-danger growl-animated animated bounceInDown" role="alert" data-growl-position="top-right" style="position: fixed; margin: 0px; z-index: 1031; display: none; top: 20px; right: 20px;" id="toastfailure">
</div>


<div class="footer_fix_mobile_whatsapp">
    <a target="_blank"
        href="https://api.whatsapp.com/send?phone=<?php echo str_replace(' ', '', @$settings[0]->whatsapp_no);?>">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
            <path fill="none" d="M0 0h24v24H0z" />
            <path
                d="M7.253 18.494l.724.423A7.953 7.953 0 0 0 12 20a8 8 0 1 0-8-8c0 1.436.377 2.813 1.084 4.024l.422.724-.653 2.401 2.4-.655zM2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308c.134-.01.269-.01.403-.004.054.004.108.01.162.016.159.018.334.115.393.249.298.676.588 1.357.868 2.04.062.152.025.347-.093.537a4.38 4.38 0 0 1-.263.372c-.113.145-.356.411-.356.411s-.099.118-.061.265c.014.056.06.137.102.205l.059.095c.256.427.6.86 1.02 1.268.12.116.237.235.363.346.468.413.998.75 1.57 1l.005.002c.085.037.128.057.252.11.062.026.126.049.191.066a.35.35 0 0 0 .367-.13c.724-.877.79-.934.796-.934v.002a.482.482 0 0 1 .378-.127c.06.004.121.015.177.04.531.243 1.4.622 1.4.622l.582.261c.098.047.187.158.19.265.004.067.01.175-.013.373-.032.259-.11.57-.188.733a1.155 1.155 0 0 1-.21.302 2.378 2.378 0 0 1-.33.288 3.71 3.71 0 0 1-.125.09 5.024 5.024 0 0 1-.383.22 1.99 1.99 0 0 1-.833.23c-.185.01-.37.024-.556.014-.008 0-.568-.087-.568-.087a9.448 9.448 0 0 1-3.84-2.046c-.226-.199-.435-.413-.649-.626-.89-.885-1.562-1.84-1.97-2.742A3.47 3.47 0 0 1 6.9 9.62a2.729 2.729 0 0 1 .564-1.68c.073-.094.142-.192.261-.305.127-.12.207-.184.294-.228a.961.961 0 0 1 .371-.1z" />
        </svg>
    </a>
</div>



<footer class="container-fluid bg-light pt-3">
    <div class="container">
        <div class="row <?php if(get_cookie("language") == "AR") echo 'text-right'; ?>" <?php if(get_cookie("language") == "AR") echo 'dir="rtl"' ?>>

            <div class="col-md-4 col-sm-6 mt-4">
                <div class="footer_inner">
                    <div class="footer_logo">
                        <img alt="<?php echo $settings[0]->business_name ?>" src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
                    </div>
                    <h6 class="text-white footer_business_title" >
                        <strong><?php echo ucwords(@$settings[0]->business_name);?></strong></h6>

                    <ul class="m-0 header_contact_info p-0 footer_firts_column">
                        <li class="pb-3">
                            <a href="tel:<?php echo @$settings[0]->phone;?>">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z">
                                    </path>
                                </svg>
                                <span <?php if(get_cookie("language") == "AR") echo "class='m-0 mr-2'" ?> dir="ltr"><?php echo @$settings[0]->phone;?></span>
                            </a>
                        </li>
                        <li class="pb-3">
                            <a href="tel:<?php echo @$settings[0]->whatsapp_no;?>">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M7.253 18.494l.724.423A7.953 7.953 0 0 0 12 20a8 8 0 1 0-8-8c0 1.436.377 2.813 1.084 4.024l.422.724-.653 2.401 2.4-.655zM2.004 22l1.352-4.968A9.954 9.954 0 0 1 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.954 9.954 0 0 1-5.03-1.355L2.004 22zM8.391 7.308c.134-.01.269-.01.403-.004.054.004.108.01.162.016.159.018.334.115.393.249.298.676.588 1.357.868 2.04.062.152.025.347-.093.537a4.38 4.38 0 0 1-.263.372c-.113.145-.356.411-.356.411s-.099.118-.061.265c.014.056.06.137.102.205l.059.095c.256.427.6.86 1.02 1.268.12.116.237.235.363.346.468.413.998.75 1.57 1l.005.002c.085.037.128.057.252.11.062.026.126.049.191.066a.35.35 0 0 0 .367-.13c.724-.877.79-.934.796-.934v.002a.482.482 0 0 1 .378-.127c.06.004.121.015.177.04.531.243 1.4.622 1.4.622l.582.261c.098.047.187.158.19.265.004.067.01.175-.013.373-.032.259-.11.57-.188.733a1.155 1.155 0 0 1-.21.302 2.378 2.378 0 0 1-.33.288 3.71 3.71 0 0 1-.125.09 5.024 5.024 0 0 1-.383.22 1.99 1.99 0 0 1-.833.23c-.185.01-.37.024-.556.014-.008 0-.568-.087-.568-.087a9.448 9.448 0 0 1-3.84-2.046c-.226-.199-.435-.413-.649-.626-.89-.885-1.562-1.84-1.97-2.742A3.47 3.47 0 0 1 6.9 9.62a2.729 2.729 0 0 1 .564-1.68c.073-.094.142-.192.261-.305.127-.12.207-.184.294-.228a.961.961 0 0 1 .371-.1z">
                                    </path>
                                </svg>
                                <span <?php if(get_cookie("language") == "AR") echo "class='m-0 mr-2'" ?> dir="ltr"><?php echo @$settings[0]->whatsapp_no;?></span>
                            </a>
                        </li>
                        <li class="pb-3">
                            <a href="mailto:<?php echo @$settings[0]->email;?>">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z">
                                    </path>
                                </svg>
                                <span <?php if(get_cookie("language") == "AR") echo "class='m-0 mr-2'" ?>><?php echo @$settings[0]->email;?></span>
                            </a>
                        </li>
                        <li class="pb-3">
                            <a href="<?php echo base_url();?>">
                                <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-2.29-2.333A17.9 17.9 0 0 1 8.027 13H4.062a8.008 8.008 0 0 0 5.648 6.667zM10.03 13c.151 2.439.848 4.73 1.97 6.752A15.905 15.905 0 0 0 13.97 13h-3.94zm9.908 0h-3.965a17.9 17.9 0 0 1-1.683 6.667A8.008 8.008 0 0 0 19.938 13zM4.062 11h3.965A17.9 17.9 0 0 1 9.71 4.333 8.008 8.008 0 0 0 4.062 11zm5.969 0h3.938A15.905 15.905 0 0 0 12 4.248 15.905 15.905 0 0 0 10.03 11zm4.259-6.667A17.9 17.9 0 0 1 15.973 11h3.965a8.008 8.008 0 0 0-5.648-6.667z">
                                    </path>
                                </svg>
                                <span <?php if(get_cookie("language") == "AR") echo "class='m-0 mr-2'" ?>><?php echo str_replace("https://" , "" , base_url()) ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mt-4">
                <div class="footer_inner">
                    <h5 class="text-capitalize" >
                        <storng><?php echo lg_get_text("lg_02") ?></storng>
                    </h5>
                    <ul>
                        <li><a href="<?php echo base_url();?>/about-us"><?php echo lg_get_text("lg_03") ?></a></li>
                        <li><a href="<?php echo base_url();?>/contact-us"><?php echo lg_get_text("lg_04") ?></a></li>
                        <!-- <li><a href="<?php echo base_url();?>/blog">Blog</a></li> -->
                        <li><a href="<?php echo base_url();?>/terms-and-conditions"><?php echo lg_get_text("lg_05") ?></a></li>
                        <li><a href="<?php echo base_url();?>/privacy-and-policy"> <?php echo lg_get_text("lg_06") ?></a></li>
                        <li><a href="<?php echo base_url();?>/faq"> <?php echo lg_get_text("lg_07") ?></a></li>
                        <li><a href="<?php echo base_url();?>/delivery-information"> <?php echo lg_get_text("lg_08") ?></a></li>
                        <li><a href="<?php echo base_url();?>/refund-policy"> <?php echo lg_get_text("lg_09") ?></a></li>
                        <li><a href="<?php echo base_url();?>/page/ourstores"> <?php echo lg_get_text("lg_10") ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-2 col-sm-6 mt-4">
                <div class="footer_inner">
                    <h5 class="text-capitalize">
                        <storng><?php echo lg_get_text("lg_11") ?></storng>
                    </h5>
                    <ul>
                        <?php
                        if($master_category){
                          foreach ($master_category as $key => $value) {?>
                        <li <?php if(get_cookie("language") == "AR") echo 'class="text-right"'; ?>>
                            <a href="<?php echo $GLOBALS["category_model"]->menu_category_url($key,null,false);?>"><?php lg_put_text($value["category_name"] , $value["category_name_arabic"]); ?></a>
                        </li>
                        <?php }} ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mt-4">
                <div class="footer_inner footer_social_meids">
                    <h5 class="text-capitalize">
                        <storng><?php echo lg_get_text("lg_12") ?></storng>
                    </h5>
                    <ul class="p-0 mb-3 mt-0">
                        <div class="social_media mt-0">
                            <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->facebook;?>">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->instagram;?>">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-2a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6.5-.25a1.25 1.25 0 0 1-2.5 0 1.25 1.25 0 0 1 2.5 0zM12 4c-2.474 0-2.878.007-4.029.058-.784.037-1.31.142-1.798.332-.434.168-.747.369-1.08.703a2.89 2.89 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.006 9.075 4 9.461 4 12c0 2.474.007 2.878.058 4.029.037.783.142 1.31.331 1.797.17.435.37.748.702 1.08.337.336.65.537 1.08.703.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.474 0 2.878-.007 4.029-.058.782-.037 1.309-.142 1.797-.331.433-.169.748-.37 1.08-.702.337-.337.538-.65.704-1.08.19-.493.296-1.02.332-1.8.052-1.104.058-1.49.058-4.029 0-2.474-.007-2.878-.058-4.029-.037-.782-.142-1.31-.332-1.798a2.911 2.911 0 0 0-.703-1.08 2.884 2.884 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.925 4.006 14.539 4 12 4zm0-2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->tiktok;?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122. 18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
                                    </svg>
                                </a>
                            </div>
                            
                            
                            
                        </div>
                    </ul>
                </div>
                <div class="footer_inner">
                    <h5 class="text-capitalize mb-4">
                        <storng><?php echo lg_get_text("lg_13") ?></storng>
                    </h5>
                    <div class="shadow-sm rounded overflow-hidden bg-white">
                        <?php echo @$settings[0]->map;?>

                    </div>
                </div>
                <div class="footer_inner mobile footer_social_meids mt-3" style="display:none">
                    <h5 class="text-capitalize">
                        <storng><?php echo lg_get_text("lg_12") ?></storng>
                    </h5>
                    <ul class="p-0 mb-0 mt-0">
                        <div class="social_media mt-0">
                        <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->facebook;?>">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                            
                            <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->tiktok;?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122. 18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="icon p-0 m-2">
                                <a target="_blank" href="<?php echo @$settings[0]->instagram;?>">
                                    <svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                        <path
                                            d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-2a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6.5-.25a1.25 1.25 0 0 1-2.5 0 1.25 1.25 0 0 1 2.5 0zM12 4c-2.474 0-2.878.007-4.029.058-.784.037-1.31.142-1.798.332-.434.168-.747.369-1.08.703a2.89 2.89 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.006 9.075 4 9.461 4 12c0 2.474.007 2.878.058 4.029.037.783.142 1.31.331 1.797.17.435.37.748.702 1.08.337.336.65.537 1.08.703.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.474 0 2.878-.007 4.029-.058.782-.037 1.309-.142 1.797-.331.433-.169.748-.37 1.08-.702.337-.337.538-.65.704-1.08.19-.493.296-1.02.332-1.8.052-1.104.058-1.49.058-4.029 0-2.474-.007-2.878-.058-4.029-.037-.782-.142-1.31-.332-1.798a2.911 2.911 0 0 0-.703-1.08 2.884 2.884 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.925 4.006 14.539 4 12 4zm0-2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header_bottom">




        <div class="row">
            <!-- <div class="col-md-6">
                <h3><strong>Our payment gateway</strong></h3>

                <div class="footer_payment_logo">
                    <img src="<?php echo base_url();?>/assets/uploads/12b7477c-529e-4e57-98aa-ea3fb4285a2d1.png">
                </div>

            </div> -->

            <div class="col-md-12">
                <h3><strong><?php echo lg_get_text("lg_14") ?></strong></h3>
                <div class="footer_payment_logo row m-0 j-c-center">
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url();?>/assets/others/Visa_card.png" class="" alt="VISA">
                    </div>
                
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url();?>/assets/others/master_card.png" alt="Master Card">
                    </div>
                
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url() ?>/assets/others/american_express.png" alt="American Express">
                    </div>
                
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url() ?>/assets/others/union_pay.png" alt="Union Pay">
                    </div>
                    
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url() ?>/assets/others/mada_card.png" alt="Mada Card">
                    </div>
                
                    <div class="payment_logo col-auto m-0 my-1 p-0">
                        <img class="mx-3" src="<?php echo base_url() ?>/assets/others/cash_on_delivery.png" alt="Cash on delivery">
                    </div>
                    <!--<img src="<?php echo base_url();?>/assets/img/mastercard-icon-no-text.svg" class="" alt="VISA"> -->
                </div>
            </div>

        </div>

        <div class="footer_menu">
                <!-- <ul>
        <li><a href="#">Ireland</a></li>
        <li><a href="#">Germany</a></li>
        <li><a href="#">Austria</a></li>
        <li><a href="#">AustriaSwitzerland</a></li>
        </ul> -->
        </div>
        <div class="copyright_footer">
            Copyright © <?php echo date('Y');?> <?php echo @$settings[0]->business_name;?>. All rights reserved.
            <!--Website developed by <a>Quanta Software Solutions</a>-->
        </div>
    </div>
</footer>




<script>
var uri1 = "<?php  if(count(@$uri->getSegments())>0) echo   $uri1=@$uri->getSegment(1);?>";
var base_url = "<?php echo base_url();?>/";
var currency = "<?php echo CURRENCY; ?>"

</script>
<!-- Google login API -->
<!-- <script src="https://accounts.google.com/gsi/client" async defer></script> -->
<!-- Google login API -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('[data-toggle="tooltip"]').tooltip();
</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://owlcarousel2.github.io/OwlCarousel2/assets/vendors/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/owl.carousel.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>/assets/gallery/lightgallery-all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/gallery/picturefill.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/gallery/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/custom.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>/assets/js/Y_custom.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/jagatjs.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/rating.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/variables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/assets/js/wheel/spin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>/assets/js/menu/index.js"></script>

<?php 
    if(isset($tabby_js))
    echo $tabby_js
?>

<!--<script type="text/javascript" src="<?php echo base_url();?>/assets/js/winter/snowstorm.js"></script>-->
<script type="text/javascript">
$('.header_serach').click(function() {
    $('.header_serach_parent').toggle();
});
$('.search_box').click(function() {
    $('.header_serach_parent').toggle();
});



// $(window).scroll(function() {
//     if ($(window).scrollTop() >= 300) {
//         $('header.header').addClass('fixed-header');
//         $('header.header').addClass('visible-title');
//     } else {
//         $('header.header').removeClass('fixed-header');
//         $('header.header').removeClass('visible-title');
//     }
// });
</script>

<script>
$(".rating_radio_parent input").change(function() {
    $('.radion_child').find('img').attr('src', '<?= base_url() ?>/assets/img/star-disable.png');
    $('.radion_child').removeClass('highlight');
    if ($(this).is(":checked")) {
        var num = $(this).parent().parent().attr('data_raview');
        for (var i = 1; i <= num; i++) {
            $('.rating_' + i).find('img').attr('src', '<?= base_url() ?>/assets/img/star.png');
        }

    }
});
</script>

<?php  if(count(@$uri->getSegments())>0 && @$uri->getSegment(1)=="product"){?>
<!--product detail -->
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>-->
<script src='https://icodefy.com/Tools/iZoom/js/Vendor/jquery/jquery-ui.min.js'></script>
<script src='https://icodefy.com/Tools/iZoom/js/Vendor/ui-carousel/ui-carousel.js'></script>
<script>
! function(t, o, e, i) {
    var n = e("html"),
        s = e(t),
        a = e(o),
        h = e.fancybox = function() {
            h.open.apply(this, arguments)
        },
        r = navigator.userAgent.match(/msie/i),
        l = null,
        d = o.createTouch !== i,
        p = function(t) {
            return t && t.hasOwnProperty && t instanceof e
        },
        c = function(t) {
            return t && "string" === e.type(t)
        },
        g = function(t) {
            return c(t) && 0 < t.indexOf("%")
        },
        m = function(t, o) {
            var e = parseInt(t, 10) || 0;
            return o && g(t) && (e *= h.getViewport()[o] / 100), Math.ceil(e)
        },
        w = function(t, o) {
            return m(t, o) + "px"
        };
    e.extend(h, {
        version: "2.1.7",
        defaults: {
            padding: 15,
            margin: 20,
            width: 800,
            height: 600,
            minWidth: 100,
            minHeight: 100,
            maxWidth: 9999,
            maxHeight: 9999,
            pixelRatio: 1,
            autoSize: !0,
            autoHeight: !1,
            autoWidth: !1,
            autoResize: !0,
            autoCenter: !d,
            fitToView: !0,
            aspectRatio: !1,
            topRatio: .5,
            leftRatio: .5,
            scrolling: "auto",
            wrapCSS: "",
            arrows: !0,
            closeBtn: !0,
            closeClick: !1,
            nextClick: !1,
            mouseWheel: !0,
            autoPlay: !1,
            playSpeed: 3e3,
            preload: 3,
            modal: !1,
            loop: !0,
            ajax: {
                dataType: "html",
                headers: {
                    "X-fancyBox": !0
                }
            },
            iframe: {
                scrolling: "auto",
                preload: !0
            },
            swf: {
                wmode: "transparent",
                allowfullscreen: "true",
                allowscriptaccess: "always"
            },
            keys: {
                next: {
                    13: "left",
                    34: "up",
                    39: "left",
                    40: "up"
                },
                prev: {
                    8: "right",
                    33: "down",
                    37: "right",
                    38: "down"
                },
                close: [27],
                play: [32],
                toggle: [70]
            },
            direction: {
                next: "left",
                prev: "right"
            },
            scrollOutside: !0,
            index: 0,
            type: null,
            href: null,
            content: null,
            title: null,
            tpl: {
                wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
                image: '<img class="fancybox-image" src="{href}" alt="" />',
                iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' +
                    (r ? ' allowtransparency="true"' : "") + "></iframe>",
                error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
                closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
                next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
                prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>',
                loading: '<div id="fancybox-loading"><div></div></div>'
            },
            openEffect: "fade",
            openSpeed: 250,
            openEasing: "swing",
            openOpacity: !0,
            openMethod: "zoomIn",
            closeEffect: "fade",
            closeSpeed: 250,
            closeEasing: "swing",
            closeOpacity: !0,
            closeMethod: "zoomOut",
            nextEffect: "elastic",
            nextSpeed: 250,
            nextEasing: "swing",
            nextMethod: "changeIn",
            prevEffect: "elastic",
            prevSpeed: 250,
            prevEasing: "swing",
            prevMethod: "changeOut",
            helpers: {
                overlay: !0,
                title: !0
            },
            onCancel: e.noop,
            beforeLoad: e.noop,
            afterLoad: e.noop,
            beforeShow: e.noop,
            afterShow: e.noop,
            beforeChange: e.noop,
            beforeClose: e.noop,
            afterClose: e.noop
        },
        group: {},
        opts: {},
        previous: null,
        coming: null,
        current: null,
        isActive: !1,
        isOpen: !1,
        isOpened: !1,
        wrap: null,
        skin: null,
        outer: null,
        inner: null,
        player: {
            timer: null,
            isActive: !1
        },
        ajaxLoad: null,
        imgPreload: null,
        transitions: {},
        helpers: {},
        open: function(t, o) {
            if (t && (e.isPlainObject(o) || (o = {}), !1 !== h.close(!0))) return e.isArray(t) || (t = p(
                t) ? e(t).get() : [t]), e.each(t, function(n, s) {
                var a, r, l, d, g, m = {};
                "object" === e.type(s) && (s.nodeType && (s = e(s)), p(s) ? (m = {
                        href: s.data("fancybox-href") || s.attr("href"),
                        title: e("<div/>").text(s.data("fancybox-title") || s.attr(
                            "title") || "").html(),
                        isDom: !0,
                        element: s
                    }, e.metadata && e.extend(!0, m, s.metadata())) : m = s), a = o.href || m
                    .href || (c(s) ? s : null), r = o.title !== i ? o.title : m.title || "", !(
                        d = (l = o.content || m.content) ? "html" : o.type || m.type) && m
                    .isDom && ((d = s.data("fancybox-type")) || (d = (d = s.prop("class").match(
                        /fancybox\.(\w+)/)) ? d[1] : null)), c(a) && (d || (h.isImage(a) ? d =
                        "image" : h.isSWF(a) ? d = "swf" : "#" === a.charAt(0) ? d =
                        "inline" : c(s) && (d = "html", l = s)), "ajax" === d && (g = a
                        .split(/\s+/, 2), a = g.shift(), g = g.shift())), l || ("inline" === d ?
                        a ? l = e(c(a) ? a.replace(/.*(?=#[^\s]+$)/, "") : a) : m.isDom && (l =
                            s) : "html" === d ? l = a : d || a || !m.isDom || (d = "inline", l =
                            s)), e.extend(m, {
                        href: a,
                        type: d,
                        content: l,
                        title: r,
                        selector: g
                    }), t[n] = m
            }), h.opts = e.extend(!0, {}, h.defaults, o), o.keys !== i && (h.opts.keys = !!o.keys &&
                e.extend({}, h.defaults.keys, o.keys)), h.group = t, h._start(h.opts.index)
        },
        cancel: function() {
            var t = h.coming;
            t && !1 === h.trigger("onCancel") || (h.hideLoading(), t && (h.ajaxLoad && h.ajaxLoad.abort(), h
                .ajaxLoad = null, h.imgPreload && (h.imgPreload.onload = h.imgPreload.onerror =
                    null), t.wrap && t.wrap.stop(!0, !0).trigger("onReset").remove(), h.coming =
                null, h.current || h._afterZoomOut(t)))
        },
        close: function(t) {
            h.cancel(), !1 !== h.trigger("beforeClose") && (h.unbindEvents(), h.isActive && (h.isOpen && !
                0 !== t ? (h.isOpen = h.isOpened = !1, h.isClosing = !0, e(
                    ".fancybox-item, .fancybox-nav").remove(), h.wrap.stop(!0, !0).removeClass(
                    "fancybox-opened"), h.transitions[h.current.closeMethod]()) : (e(
                    ".fancybox-wrap").stop(!0).trigger("onReset").remove(), h._afterZoomOut())))
        },
        play: function(t) {
            var o = function() {
                    clearTimeout(h.player.timer)
                },
                e = function() {
                    o(), h.current && h.player.isActive && (h.player.timer = setTimeout(h.next, h.current
                        .playSpeed))
                },
                i = function() {
                    o(), a.unbind(".player"), h.player.isActive = !1, h.trigger("onPlayEnd")
                };
            !0 === t || !h.player.isActive && !1 !== t ? h.current && (h.current.loop || h.current.index < h
                .group.length - 1) && (h.player.isActive = !0, a.bind({
                "onCancel.player beforeClose.player": i,
                "onUpdate.player": e,
                "beforeLoad.player": o
            }), e(), h.trigger("onPlayStart")) : i()
        },
        next: function(t) {
            var o = h.current;
            o && (c(t) || (t = o.direction.next), h.jumpto(o.index + 1, t, "next"))
        },
        prev: function(t) {
            var o = h.current;
            o && (c(t) || (t = o.direction.prev), h.jumpto(o.index - 1, t, "prev"))
        },
        jumpto: function(t, o, e) {
            var n = h.current;
            n && (t = m(t), h.direction = o || n.direction[t >= n.index ? "next" : "prev"], h.router = e ||
                "jumpto", n.loop && (0 > t && (t = n.group.length + t % n.group.length), t %= n.group
                    .length), n.group[t] !== i && (h.cancel(), h._start(t)))
        },
        reposition: function(t, o) {
            var i, n = h.current,
                s = n ? n.wrap : null;
            s && (i = h._getPosition(o), t && "scroll" === t.type ? (delete i.position, s.stop(!0, !0)
                .animate(i, 200)) : (s.css(i), n.pos = e.extend({}, n.dim, i)))
        },
        update: function(t) {
            var o = t && t.originalEvent && t.originalEvent.type,
                e = !o || "orientationchange" === o;
            e && (clearTimeout(l), l = null), h.isOpen && !l && (l = setTimeout(function() {
                var i = h.current;
                i && !h.isClosing && (h.wrap.removeClass("fancybox-tmp"), (e || "load" === o ||
                        "resize" === o && i.autoResize) && h._setDimension(), "scroll" ===
                    o && i.canShrink || h.reposition(t), h.trigger("onUpdate"), l = null)
            }, e && !d ? 0 : 300))
        },
        toggle: function(t) {
            h.isOpen && (h.current.fitToView = "boolean" === e.type(t) ? t : !h.current.fitToView, d && (h
                    .wrap.removeAttr("style").addClass("fancybox-tmp"), h.trigger("onUpdate")), h
                .update())
        },
        hideLoading: function() {
            a.unbind(".loading"), e("#fancybox-loading").remove()
        },
        showLoading: function() {
            var t, o;
            h.hideLoading(), t = e(h.opts.tpl.loading).click(h.cancel).appendTo("body"), a.bind(
                "keydown.loading",
                function(t) {
                    27 === (t.which || t.keyCode) && (t.preventDefault(), h.cancel())
                }), h.defaults.fixed || (o = h.getViewport(), t.css({
                position: "absolute",
                top: .5 * o.h + o.y,
                left: .5 * o.w + o.x
            })), h.trigger("onLoading")
        },
        getViewport: function() {
            var o = h.current && h.current.locked || !1,
                e = {
                    x: s.scrollLeft(),
                    y: s.scrollTop()
                };
            return o && o.length ? (e.w = o[0].clientWidth, e.h = o[0].clientHeight) : (e.w = d && t
                .innerWidth ? t.innerWidth : s.width(), e.h = d && t.innerHeight ? t.innerHeight : s
                .height()), e
        },
        unbindEvents: function() {
            h.wrap && p(h.wrap) && h.wrap.unbind(".fb"), a.unbind(".fb"), s.unbind(".fb")
        },
        bindEvents: function() {
            var t, o = h.current;
            o && (s.bind("orientationchange.fb" + (d ? "" : " resize.fb") + (o.autoCenter && !o.locked ?
                " scroll.fb" : ""), h.update), (t = o.keys) && a.bind("keydown.fb", function(n) {
                var s = n.which || n.keyCode,
                    a = n.target || n.srcElement;
                if (27 === s && h.coming) return !1;
                n.ctrlKey || n.altKey || n.shiftKey || n.metaKey || a && (a.type || e(a).is(
                    "[contenteditable]")) || e.each(t, function(t, a) {
                    return 1 < o.group.length && a[s] !== i ? (h[t](a[s]), n
                        .preventDefault(), !1) : -1 < e.inArray(s, a) ? (h[t](), n
                        .preventDefault(), !1) : void 0
                })
            }), e.fn.mousewheel && o.mouseWheel && h.wrap.bind("mousewheel.fb", function(t, i, n,
            s) {
                for (var a = e(t.target || null), r = !1; a.length && !(r || a.is(
                        ".fancybox-skin") || a.is(".fancybox-wrap"));) r = (r = a[0]) && !(r
                    .style.overflow && "hidden" === r.style.overflow) && (r.clientWidth && r
                    .scrollWidth > r.clientWidth || r.clientHeight && r.scrollHeight > r
                    .clientHeight), a = e(a).parent();
                0 !== i && !r && 1 < h.group.length && !o.canShrink && (0 < s || 0 < n ? h.prev(
                    0 < s ? "down" : "left") : (0 > s || 0 > n) && h.next(0 > s ? "up" :
                    "right"), t.preventDefault())
            }))
        },
        trigger: function(t, o) {
            var i, n = o || h.coming || h.current;
            if (n) {
                if (e.isFunction(n[t]) && (i = n[t].apply(n, Array.prototype.slice.call(arguments, 1))), !
                    1 === i) return !1;
                n.helpers && e.each(n.helpers, function(o, i) {
                    i && h.helpers[o] && e.isFunction(h.helpers[o][t]) && h.helpers[o][t](e.extend(!
                        0, {}, h.helpers[o].defaults, i), n)
                })
            }
            a.trigger(t)
        },
        isImage: function(t) {
            return c(t) && t.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i)
        },
        isSWF: function(t) {
            return c(t) && t.match(/\.(swf)((\?|#).*)?$/i)
        },
        _start: function(t) {
            var o, i, n = {};
            if (t = m(t), !(o = h.group[t] || null)) return !1;
            if (o = (n = e.extend(!0, {}, h.opts, o)).margin, i = n.padding, "number" === e.type(o) && (n
                    .margin = [o, o, o, o]), "number" === e.type(i) && (n.padding = [i, i, i, i]), n
                .modal && e.extend(!0, n, {
                    closeBtn: !1,
                    closeClick: !1,
                    nextClick: !1,
                    arrows: !1,
                    mouseWheel: !1,
                    keys: null,
                    helpers: {
                        overlay: {
                            closeClick: !1
                        }
                    }
                }), n.autoSize && (n.autoWidth = n.autoHeight = !0), "auto" === n.width && (n.autoWidth = !
                    0), "auto" === n.height && (n.autoHeight = !0), n.group = h.group, n.index = t, h
                .coming = n, !1 === h.trigger("beforeLoad")) h.coming = null;
            else {
                if (i = n.type, o = n.href, !i) return h.coming = null, !(!h.current || !h.router ||
                    "jumpto" === h.router) && (h.current.index = t, h[h.router](h.direction));
                if (h.isActive = !0, "image" !== i && "swf" !== i || (n.autoHeight = n.autoWidth = !1, n
                        .scrolling = "visible"), "image" === i && (n.aspectRatio = !0), "iframe" === i &&
                    d && (n.scrolling = "scroll"), n.wrap = e(n.tpl.wrap).addClass("fancybox-" + (d ?
                        "mobile" : "desktop") + " fancybox-type-" + i + " fancybox-tmp " + n.wrapCSS)
                    .appendTo(n.parent || "body"), e.extend(n, {
                        skin: e(".fancybox-skin", n.wrap),
                        outer: e(".fancybox-outer", n.wrap),
                        inner: e(".fancybox-inner", n.wrap)
                    }), e.each(["Top", "Right", "Bottom", "Left"], function(t, o) {
                        n.skin.css("padding" + o, w(n.padding[t]))
                    }), h.trigger("onReady"), "inline" === i || "html" === i) {
                    if (!n.content || !n.content.length) return h._error("content")
                } else if (!o) return h._error("href");
                "image" === i ? h._loadImage() : "ajax" === i ? h._loadAjax() : "iframe" === i ? h
                    ._loadIframe() : h._afterLoad()
            }
        },
        _error: function(t) {
            e.extend(h.coming, {
                type: "html",
                autoWidth: !0,
                autoHeight: !0,
                minWidth: 0,
                minHeight: 0,
                scrolling: "no",
                hasError: t,
                content: h.coming.tpl.error
            }), h._afterLoad()
        },
        _loadImage: function() {
            var t = h.imgPreload = new Image;
            t.onload = function() {
                this.onload = this.onerror = null, h.coming.width = this.width / h.opts.pixelRatio, h
                    .coming.height = this.height / h.opts.pixelRatio, h._afterLoad()
            }, t.onerror = function() {
                this.onload = this.onerror = null, h._error("image")
            }, t.src = h.coming.href, !0 !== t.complete && h.showLoading()
        },
        _loadAjax: function() {
            var t = h.coming;
            h.showLoading(), h.ajaxLoad = e.ajax(e.extend({}, t.ajax, {
                url: t.href,
                error: function(t, o) {
                    h.coming && "abort" !== o ? h._error("ajax", t) : h.hideLoading()
                },
                success: function(o, e) {
                    "success" === e && (t.content = o, h._afterLoad())
                }
            }))
        },
        _loadIframe: function() {
            var t = h.coming,
                o = e(t.tpl.iframe.replace(/\{rnd\}/g, (new Date).getTime())).attr("scrolling", d ? "auto" :
                    t.iframe.scrolling).attr("src", t.href);
            e(t.wrap).bind("onReset", function() {
                try {
                    e(this).find("iframe").hide().attr("src", "//about:blank").end().empty()
                } catch (t) {}
            }), t.iframe.preload && (h.showLoading(), o.one("load", function() {
                e(this).data("ready", 1), d || e(this).bind("load.fb", h.update), e(this)
                    .parents(".fancybox-wrap").width("100%").removeClass("fancybox-tmp").show(),
                    h._afterLoad()
            })), t.content = o.appendTo(t.inner), t.iframe.preload || h._afterLoad()
        },
        _preloadImages: function() {
            var t, o, e = h.group,
                i = h.current,
                n = e.length,
                s = i.preload ? Math.min(i.preload, n - 1) : 0;
            for (o = 1; o <= s; o += 1) "image" === (t = e[(i.index + o) % n]).type && t.href && ((
                new Image).src = t.href)
        },
        _afterLoad: function() {
            var t, o, i, n, s, a = h.coming,
                r = h.current;
            if (h.hideLoading(), a && !1 !== h.isActive)
                if (!1 === h.trigger("afterLoad", a, r)) a.wrap.stop(!0).trigger("onReset").remove(), h
                    .coming = null;
                else {
                    switch (r && (h.trigger("beforeChange", r), r.wrap.stop(!0).removeClass(
                            "fancybox-opened").find(".fancybox-item, .fancybox-nav").remove()), h
                        .unbindEvents(), t = a.content, o = a.type, i = a.scrolling, e.extend(h, {
                            wrap: a.wrap,
                            skin: a.skin,
                            outer: a.outer,
                            inner: a.inner,
                            current: a,
                            previous: r
                        }), n = a.href, o) {
                        case "inline":
                        case "ajax":
                        case "html":
                            a.selector ? t = e("<div>").html(t).find(a.selector) : p(t) && (t.data(
                                "fancybox-placeholder") || t.data("fancybox-placeholder", e(
                                '<div class="fancybox-placeholder"></div>').insertAfter(t)
                            .hide()), t = t.show().detach(), a.wrap.bind("onReset", function() {
                                e(this).find(t).length && t.hide().replaceAll(t.data(
                                    "fancybox-placeholder")).data("fancybox-placeholder", !
                                    1)
                            }));
                            break;
                        case "image":
                            t = a.tpl.image.replace(/\{href\}/g, n);
                            break;
                        case "swf":
                            t = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' +
                                n + '"></param>', s = "", e.each(a.swf, function(o, e) {
                                    t += '<param name="' + o + '" value="' + e + '"></param>', s +=
                                        " " + o + '="' + e + '"'
                                }), t += '<embed src="' + n +
                                '" type="application/x-shockwave-flash" width="100%" height="100%"' + s +
                                "></embed></object>"
                    }
                    p(t) && t.parent().is(a.inner) || a.inner.append(t), h.trigger("beforeShow"), a.inner
                        .css("overflow", "yes" === i ? "scroll" : "no" === i ? "hidden" : i), h
                        ._setDimension(), h.reposition(), h.isOpen = !1, h.coming = null, h.bindEvents(), h
                        .isOpened ? r.prevMethod && h.transitions[r.prevMethod]() : e(".fancybox-wrap").not(
                            a.wrap).stop(!0).trigger("onReset").remove(), h.transitions[h.isOpened ? a
                            .nextMethod : a.openMethod](), h._preloadImages()
                }
        },
        _setDimension: function() {
            var t, o = h.getViewport(),
                i = 0,
                n = h.wrap,
                s = h.skin,
                a = h.inner,
                r = h.current;
            t = r.width;
            var l, d, p, c, f, u, z, v, y, x = r.height,
                W = r.minWidth,
                b = r.minHeight,
                T = r.maxWidth,
                L = r.maxHeight,
                H = r.scrolling,
                S = r.scrollOutside ? r.scrollbarWidth : 0,
                k = r.margin,
                O = m(k[1] + k[3]),
                C = m(k[0] + k[2]);
            if (n.add(s).add(a).width("auto").height("auto").removeClass("fancybox-tmp"), d = O + (k = m(s
                    .outerWidth(!0) - s.width())), p = C + (l = m(s.outerHeight(!0) - s.height())), c = g(
                t) ? (o.w - d) * m(t) / 100 : t, f = g(x) ? (o.h - p) * m(x) / 100 : x, "iframe" === r.type
                ) {
                if (y = r.content, r.autoHeight && y && 1 === y.data("ready")) try {
                    y[0].contentWindow.document.location && (a.width(c).height(9999), u = y.contents()
                        .find("body"), S && u.css("overflow-x", "hidden"), f = u.outerHeight(!0))
                } catch (t) {}
            } else(r.autoWidth || r.autoHeight) && (a.addClass("fancybox-tmp"), r.autoWidth || a.width(c), r
                .autoHeight || a.height(f), r.autoWidth && (c = a.width()), r.autoHeight && (f = a
                    .height()), a.removeClass("fancybox-tmp"));
            if (t = m(c), x = m(f), v = c / f, W = m(g(W) ? m(W, "w") - d : W), T = m(g(T) ? m(T, "w") - d :
                    T), b = m(g(b) ? m(b, "h") - p : b), u = T, z = L = m(g(L) ? m(L, "h") - p : L), r
                .fitToView && (T = Math.min(o.w - d, T), L = Math.min(o.h - p, L)), d = o.w - O, C = o.h -
                C, r.aspectRatio ? (t > T && (x = m((t = T) / v)), x > L && (t = m((x = L) * v)), t < W && (
                    x = m((t = W) / v)), x < b && (t = m((x = b) * v))) : (t = Math.max(W, Math.min(t, T)),
                    r.autoHeight && "iframe" !== r.type && (a.width(t), x = a.height()), x = Math.max(b,
                        Math.min(x, L))), r.fitToView)
                if (a.width(t).height(x), n.width(t + k), o = n.width(), O = n.height(), r.aspectRatio)
                    for (;
                        (o > d || O > C) && t > W && x > b && !(19 < i++);) x = Math.max(b, Math.min(L, x -
                            10)), (t = m(x * v)) < W && (x = m((t = W) / v)), t > T && (x = m((t = T) / v)),
                        a.width(t).height(x), n.width(t + k), o = n.width(), O = n.height();
                else t = Math.max(W, Math.min(t, t - (o - d))), x = Math.max(b, Math.min(x, x - (O - C)));
            S && "auto" === H && x < f && t + k + S < d && (t += S), a.width(t).height(x), n.width(t + k),
                o = n.width(), O = n.height(), i = (o > d || O > C) && t > W && x > b, t = r.aspectRatio ?
                t < u && x < z && t < c && x < f : (t < u || x < z) && (t < c || x < f), e.extend(r, {
                    dim: {
                        width: w(o),
                        height: w(O)
                    },
                    origWidth: c,
                    origHeight: f,
                    canShrink: i,
                    canExpand: t,
                    wPadding: k,
                    hPadding: l,
                    wrapSpace: O - s.outerHeight(!0),
                    skinSpace: s.height() - x
                }), !y && r.autoHeight && x > b && x < L && !t && a.height("auto")
        },
        _getPosition: function(t) {
            var o = h.current,
                e = h.getViewport(),
                i = o.margin,
                n = h.wrap.width() + i[1] + i[3],
                s = h.wrap.height() + i[0] + i[2];
            i = {
                position: "absolute",
                top: i[0],
                left: i[3]
            };
            return o.autoCenter && o.fixed && !t && s <= e.h && n <= e.w ? i.position = "fixed" : o
                .locked || (i.top += e.y, i.left += e.x), i.top = w(Math.max(i.top, i.top + (e.h - s) * o
                    .topRatio)), i.left = w(Math.max(i.left, i.left + (e.w - n) * o.leftRatio)), i
        },
        _afterZoomIn: function() {
            var t = h.current;
            t && (h.isOpen = h.isOpened = !0, h.wrap.css("overflow", "visible").addClass("fancybox-opened")
                .hide().show(0), h.update(), (t.closeClick || t.nextClick && 1 < h.group.length) && h
                .inner.css("cursor", "pointer").bind("click.fb", function(o) {
                    e(o.target).is("a") || e(o.target).parent().is("a") || (o.preventDefault(), h[t
                        .closeClick ? "close" : "next"]())
                }), t.closeBtn && e(t.tpl.closeBtn).appendTo(h.skin).bind("click.fb", function(t) {
                    t.preventDefault(), h.close()
                }), t.arrows && 1 < h.group.length && ((t.loop || 0 < t.index) && e(t.tpl.prev)
                    .appendTo(h.outer).bind("click.fb", h.prev), (t.loop || t.index < h.group.length -
                        1) && e(t.tpl.next).appendTo(h.outer).bind("click.fb", h.next)), h.trigger(
                    "afterShow"), t.loop || t.index !== t.group.length - 1 ? h.opts.autoPlay && !h
                .player.isActive && (h.opts.autoPlay = !1, h.play(!0)) : h.play(!1))
        },
        _afterZoomOut: function(t) {
            t = t || h.current, e(".fancybox-wrap").trigger("onReset").remove(), e.extend(h, {
                group: {},
                opts: {},
                router: !1,
                current: null,
                isActive: !1,
                isOpened: !1,
                isOpen: !1,
                isClosing: !1,
                wrap: null,
                skin: null,
                outer: null,
                inner: null
            }), h.trigger("afterClose", t)
        }
    }), h.transitions = {
        getOrigPosition: function() {
            var t = h.current,
                o = t.element,
                e = t.orig,
                i = {},
                n = 50,
                s = 50,
                a = t.hPadding,
                r = t.wPadding,
                l = h.getViewport();
            return !e && t.isDom && o.is(":visible") && ((e = o.find("img:first")).length || (e = o)), p(e) ? (
                i = e.offset(), e.is("img") && (n = e.outerWidth(), s = e.outerHeight())) : (i.top = l.y + (
                l.h - s) * t.topRatio, i.left = l.x + (l.w - n) * t.leftRatio), ("fixed" === h.wrap.css(
                "position") || t.locked) && (i.top -= l.y, i.left -= l.x), {
                top: w(i.top - a * t.topRatio),
                left: w(i.left - r * t.leftRatio),
                width: w(n + r),
                height: w(s + a)
            }
        },
        step: function(t, o) {
            var e, i, n = o.prop,
                s = (i = h.current).wrapSpace,
                a = i.skinSpace;
            "width" !== n && "height" !== n || (e = o.end === o.start ? 1 : (t - o.start) / (o.end - o.start), h
                .isClosing && (e = 1 - e), i = t - (i = "width" === n ? i.wPadding : i.hPadding), h.skin[n](
                    m("width" === n ? i : i - s * e)), h.inner[n](m("width" === n ? i : i - s * e - a * e)))
        },
        zoomIn: function() {
            var t = h.current,
                o = t.pos,
                i = t.openEffect,
                n = "elastic" === i,
                s = e.extend({
                    opacity: 1
                }, o);
            delete s.position, n ? (o = this.getOrigPosition(), t.openOpacity && (o.opacity = .1)) : "fade" ===
                i && (o.opacity = .1), h.wrap.css(o).animate(s, {
                    duration: "none" === i ? 0 : t.openSpeed,
                    easing: t.openEasing,
                    step: n ? this.step : null,
                    complete: h._afterZoomIn
                })
        },
        zoomOut: function() {
            var t = h.current,
                o = t.closeEffect,
                e = "elastic" === o,
                i = {
                    opacity: .1
                };
            e && (i = this.getOrigPosition(), t.closeOpacity && (i.opacity = .1)), h.wrap.animate(i, {
                duration: "none" === o ? 0 : t.closeSpeed,
                easing: t.closeEasing,
                step: e ? this.step : null,
                complete: h._afterZoomOut
            })
        },
        changeIn: function() {
            var t, o = h.current,
                e = o.nextEffect,
                i = o.pos,
                n = {
                    opacity: 1
                },
                s = h.direction;
            i.opacity = .1, "elastic" === e && (t = "down" === s || "up" === s ? "top" : "left", "down" === s ||
                "right" === s ? (i[t] = w(m(i[t]) - 200), n[t] = "+=200px") : (i[t] = w(m(i[t]) + 200), n[
                    t] = "-=200px")), "none" === e ? h._afterZoomIn() : h.wrap.css(i).animate(n, {
                duration: o.nextSpeed,
                easing: o.nextEasing,
                complete: h._afterZoomIn
            })
        },
        changeOut: function() {
            var t = h.previous,
                o = t.prevEffect,
                i = {
                    opacity: .1
                },
                n = h.direction;
            "elastic" === o && (i["down" === n || "up" === n ? "top" : "left"] = ("up" === n || "left" === n ?
                "-" : "+") + "=200px"), t.wrap.animate(i, {
                duration: "none" === o ? 0 : t.prevSpeed,
                easing: t.prevEasing,
                complete: function() {
                    e(this).trigger("onReset").remove()
                }
            })
        }
    }, h.helpers.overlay = {
        defaults: {
            closeClick: !0,
            speedOut: 200,
            showEarly: !0,
            css: {},
            locked: !d,
            fixed: !0
        },
        overlay: null,
        fixed: !1,
        el: e("html"),
        create: function(t) {
            var o;
            t = e.extend({}, this.defaults, t), this.overlay && this.close(), o = h.coming ? h.coming.parent : t
                .parent, this.overlay = e('<div class="fancybox-overlay"></div>').appendTo(o && o.length ? o :
                    "body"), this.fixed = !1, t.fixed && h.defaults.fixed && (this.overlay.addClass(
                    "fancybox-overlay-fixed"), this.fixed = !0)
        },
        open: function(t) {
            var o = this;
            t = e.extend({}, this.defaults, t), this.overlay ? this.overlay.unbind(".overlay").width("auto")
                .height("auto") : this.create(t), this.fixed || (s.bind("resize.overlay", e.proxy(this.update,
                    this)), this.update()), t.closeClick && this.overlay.bind("click.overlay", function(t) {
                    if (e(t.target).hasClass("fancybox-overlay")) return h.isActive ? h.close() : o.close(),
                        !1
                }), this.overlay.css(t.css).show()
        },
        close: function() {
            s.unbind("resize.overlay"), this.el.hasClass("fancybox-lock") && (e(".fancybox-margin").removeClass(
                    "fancybox-margin"), this.el.removeClass("fancybox-lock"), s.scrollTop(this.scrollV)
                .scrollLeft(this.scrollH)), e(".fancybox-overlay").remove().hide(), e.extend(this, {
                overlay: null,
                fixed: !1
            })
        },
        update: function() {
            var t, e = "100%";
            this.overlay.width(e).height("100%"), r ? (t = Math.max(o.documentElement.offsetWidth, o.body
                    .offsetWidth), a.width() > t && (e = a.width())) : a.width() > s.width() && (e = a.width()),
                this.overlay.width(e).height(a.height())
        },
        onReady: function(t, o) {
            var i = this.overlay;
            e(".fancybox-overlay").stop(!0, !0), i || this.create(t), t.locked && this.fixed && o.fixed && (o
                    .locked = this.overlay.append(o.wrap), o.fixed = !1), !0 === t.showEarly && this.beforeShow
                .apply(this, arguments)
        },
        beforeShow: function(t, o) {
            o.locked && !this.el.hasClass("fancybox-lock") && (!1 !== this.fixPosition && e("*:not(object)")
                .filter(function() {
                    return "fixed" === e(this).css("position") && !e(this).hasClass(
                        "fancybox-overlay") && !e(this).hasClass("fancybox-wrap")
                }).addClass("fancybox-margin"), this.el.addClass("fancybox-margin"), this.scrollV = s
                .scrollTop(), this.scrollH = s.scrollLeft(), this.el.addClass("fancybox-lock"), s.scrollTop(
                    this.scrollV).scrollLeft(this.scrollH)), this.open(t)
        },
        onUpdate: function() {
            this.fixed || this.update()
        },
        afterClose: function(t) {
            this.overlay && !h.coming && this.overlay.fadeOut(t.speedOut, e.proxy(this.close, this))
        }
    }, h.helpers.title = {
        defaults: {
            type: "float",
            position: "bottom"
        },
        beforeShow: function(t) {
            var o = h.current,
                i = o.title,
                n = t.type;
            if (e.isFunction(i) && (i = i.call(o.element, o)), c(i) && "" !== e.trim(i)) {
                switch (o = e('<div class="fancybox-title fancybox-title-' + n + '-wrap">' + i + "</div>"), n) {
                    case "inside":
                        n = h.skin;
                        break;
                    case "outside":
                        n = h.wrap;
                        break;
                    case "over":
                        n = h.inner;
                        break;
                    default:
                        n = h.skin, o.appendTo("body"), r && o.width(o.width()), o.wrapInner(
                            '<span class="child"></span>'), h.current.margin[2] += Math.abs(m(o.css(
                            "margin-bottom")))
                }
                o["top" === t.position ? "prependTo" : "appendTo"](n)
            }
        }
    }, e.fn.fancybox = function(t) {
        var o, i = e(this),
            n = this.selector || "",
            s = function(s) {
                var a, r, l = e(this).blur(),
                    d = o;
                s.ctrlKey || s.altKey || s.shiftKey || s.metaKey || l.is(".fancybox-wrap") || (a = t.groupAttr ||
                    "data-fancybox-group", (r = l.attr(a)) || (a = "rel", r = l.get(0)[a]), r && "" !== r &&
                    "nofollow" !== r && (d = (l = (l = n.length ? e(n) : i).filter("[" + a + '="' + r + '"]'))
                        .index(this)), t.index = d, !1 !== h.open(l, t) && s.preventDefault())
            };
        return o = (t = t || {}).index || 0, n && !1 !== t.live ? a.undelegate(n, "click.fb-start").delegate(n +
            ":not('.fancybox-item, .fancybox-nav')", "click.fb-start", s) : i.unbind("click.fb-start").bind(
            "click.fb-start", s), this.filter("[data-fancybox-start=1]").trigger("click"), this
    }, a.ready(function() {
        var o, s;
        e.scrollbarWidth === i && (e.scrollbarWidth = function() {
            var t = e('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo(
                "body"),
                o = (o = t.children()).innerWidth() - o.height(99).innerWidth();
            return t.remove(), o
        }), e.support.fixedPosition === i && (e.support.fixedPosition = function() {
            var t = e('<div style="position:fixed;top:20px;"></div>').appendTo("body"),
                o = 20 === t[0].offsetTop || 15 === t[0].offsetTop;
            return t.remove(), o
        }()), e.extend(h.defaults, {
            scrollbarWidth: e.scrollbarWidth(),
            fixed: e.support.fixedPosition,
            parent: e("body")
        }), o = e(t).width(), n.addClass("fancybox-lock-test"), s = e(t).width(), n.removeClass(
            "fancybox-lock-test"), e("<style type='text/css'>.fancybox-margin{margin-right:" + (s - o) +
            "px;}</style>").appendTo("head")
    })
}(window, document, jQuery), "function" != typeof Object.create && (Object.create = function(t) {
        function o() {}
        return o.prototype = t, new o
    }),
    function(t, o, e, i) {
        var n = {
            init: function(o, e) {
                var i = this;
                i.elem = e, i.$elem = t(e), i.imageSrc = i.$elem.data("zoom-image") ? i.$elem.data(
                    "zoom-image") : i.$elem.attr("src"), i.options = t.extend({}, t.fn.elevateZoom.options, o),
                    i.options.tint && (i.options.lensColour = "none", i.options.lensOpacity = "1"), "inner" == i
                    .options.zoomType && (i.options.showLens = !1), i.$elem.parent().removeAttr("title")
                    .removeAttr("alt"), i.zoomImage = i.imageSrc, i.refresh(1), t("#" + i.options.gallery +
                        " a").click(function(o) {
                        return i.options.galleryActiveClass && (t("#" + i.options.gallery + " a")
                                .removeClass(i.options.galleryActiveClass), t(this).addClass(i.options
                                    .galleryActiveClass)), o.preventDefault(), t(this).data("zoom-image") ?
                            i.zoomImagePre = t(this).data("zoom-image") : i.zoomImagePre = t(this).data(
                                "image"), i.swaptheimage(t(this).data("image"), i.zoomImagePre), t(
                                "#zoom_10").attr("href", i.zoomImagePre), !1
                    })
            },
            refresh: function(t) {
                var o = this;
                setTimeout(function() {
                    o.fetch(o.imageSrc)
                }, t || o.options.refresh)
            },
            fetch: function(t) {
                var o = this,
                    e = new Image;
                e.onload = function() {
                    o.largeWidth = e.width, o.largeHeight = e.height, o.startZoom(), o.currentImage = o
                        .imageSrc, o.options.onZoomedImageLoaded(o.$elem)
                }, e.src = t
            },
            startZoom: function() {
                var o = this;
                if (o.nzWidth = o.$elem.width(), o.nzHeight = o.$elem.height(), o.isWindowActive = !1, o
                    .isLensActive = !1, o.isTintActive = !1, o.overWindow = !1, o.options.imageCrossfade && (o
                        .zoomWrap = o.$elem.wrap('<div style="height:' + o.nzHeight + "px;width:" + o.nzWidth +
                            'px;" class="zoomWrapper" />'), o.$elem.css("position", "absolute")), o.zoomLock =
                    1, o.scrollingLock = !1, o.changeBgSize = !1, o.currentZoomLevel = o.options.zoomLevel, o
                    .nzOffset = o.$elem.offset(), o.widthRatio = o.largeWidth / o.currentZoomLevel / o.nzWidth,
                    o.heightRatio = o.largeHeight / o.currentZoomLevel / o.nzHeight, "window" == o.options
                    .zoomType && (o.zoomWindowStyle =
                        "overflow: hidden;background-position: 0px 0px;text-align:center;background-color: " +
                        String(o.options.zoomWindowBgColour) + ";width: " + String(o.options.zoomWindowWidth) +
                        "px;height: " + String(o.options.zoomWindowHeight) +
                        "px;float: left;background-size: " + o.largeWidth / o.currentZoomLevel + "px " + o
                        .largeHeight / o.currentZoomLevel + "px;display: none;z-index:100;border: " + String(o
                            .options.borderSize) + "px solid " + o.options.borderColour +
                        ";background-repeat: no-repeat;position: absolute;"), "inner" == o.options.zoomType) {
                    var e = o.$elem.css("border-left-width");
                    o.zoomWindowStyle = "overflow: hidden;margin-left: " + String(e) + ";margin-top: " + String(
                            e) + ";background-position: 0px 0px;width: " + String(o.nzWidth) + "px;height: " +
                        String(o.nzHeight) + "px;px;float: left;display: none;cursor:" + o.options.cursor +
                        ";px solid " + o.options.borderColour +
                        ";background-repeat: no-repeat;position: absolute;"
                }
                "window" == o.options.zoomType && (o.nzHeight < o.options.zoomWindowWidth / o.widthRatio ?
                        lensHeight = o.nzHeight : lensHeight = String(o.options.zoomWindowHeight / o
                            .heightRatio), o.largeWidth < o.options.zoomWindowWidth ? lensWidth = o.nzWidth :
                        lensWidth = o.options.zoomWindowWidth / o.widthRatio, o.lensStyle =
                        "background-position: 0px 0px;width: " + String(o.options.zoomWindowWidth / o
                            .widthRatio) + "px;height: " + String(o.options.zoomWindowHeight / o.heightRatio) +
                        "px;float: right;display: none;overflow: hidden;z-index: 999;-webkit-transform: translateZ(0);opacity:" +
                        o.options.lensOpacity + ";filter: alpha(opacity = " + 100 * o.options.lensOpacity +
                        "); zoom:1;width:" + lensWidth + "px;height:" + lensHeight + "px;background-color:" + o
                        .options.lensColour + ";cursor:" + o.options.cursor + ";border: " + o.options
                        .lensBorderSize + "px solid " + o.options.lensBorderColour +
                        ";background-repeat: no-repeat;position: absolute;"), o.tintStyle =
                    "display: block;position: absolute;background-color: " + o.options.tintColour +
                    ";filter:alpha(opacity=0);opacity: 0;width: " + o.nzWidth + "px;height: " + o.nzHeight +
                    "px;", o.lensRound = "", "lens" == o.options.zoomType && (o.lensStyle =
                        "background-position: 0px 0px;float: left;display: none;border: " + String(o.options
                            .borderSize) + "px solid " + o.options.borderColour + ";width:" + String(o.options
                            .lensSize) + "px;height:" + String(o.options.lensSize) +
                        "px;background-repeat: no-repeat;position: absolute;"), "round" == o.options
                    .lensShape && (o.lensRound = "border-top-left-radius: " + String(o.options.lensSize / 2 + o
                        .options.borderSize) + "px;border-top-right-radius: " + String(o.options.lensSize /
                        2 + o.options.borderSize) + "px;border-bottom-left-radius: " + String(o.options
                        .lensSize / 2 + o.options.borderSize) + "px;border-bottom-right-radius: " + String(o
                        .options.lensSize / 2 + o.options.borderSize) + "px;"), o.zoomContainer = t(
                        '<div class="zoomContainer" style="-webkit-transform: translateZ(0);position:absolute;left:' +
                        o.nzOffset.left + "px;top:" + o.nzOffset.top + "px;height:" + o.nzHeight + "px;width:" +
                        o.nzWidth + 'px;"></div>'), t("body").append(o.zoomContainer), o.options
                    .containLensZoom && "lens" == o.options.zoomType && o.zoomContainer.css("overflow",
                        "hidden"), "inner" != o.options.zoomType && (o.zoomLens = t(
                            "<div class='zoomLens' style='" + o.lensStyle + o.lensRound + "'>&nbsp;</div>")
                        .appendTo(o.zoomContainer).click(function() {
                            o.$elem.trigger("click")
                        }), o.options.tint && (o.tintContainer = t("<div/>").addClass("tintContainer"), o
                            .zoomTint = t("<div class='zoomTint' style='" + o.tintStyle + "'></div>"), o
                            .zoomLens.wrap(o.tintContainer), o.zoomTintcss = o.zoomLens.after(o.zoomTint), o
                            .zoomTintImage = t(
                                '<img style="position: absolute; left: 0px; top: 0px; max-width: none; width: ' +
                                o.nzWidth + "px; height: " + o.nzHeight + 'px;" src="' + o.imageSrc + '">')
                            .appendTo(o.zoomLens).click(function() {
                                o.$elem.trigger("click")
                            }))), isNaN(o.options.zoomWindowPosition) ? o.zoomWindow = t(
                        "<div style='z-index:999;left:" + o.windowOffsetLeft + "px;top:" + o.windowOffsetTop +
                        "px;" + o.zoomWindowStyle + "' class='zoomWindow'>&nbsp;</div>").appendTo("body").click(
                        function() {
                            o.$elem.trigger("click")
                        }) : o.zoomWindow = t("<div style='z-index:999;left:" + o.windowOffsetLeft + "px;top:" +
                        o.windowOffsetTop + "px;" + o.zoomWindowStyle + "' class='zoomWindow'>&nbsp;</div>")
                    .appendTo(o.zoomContainer).click(function() {
                        o.$elem.trigger("click")
                    }), o.zoomWindowContainer = t("<div/>").addClass("zoomWindowContainer").css("width", o
                        .options.zoomWindowWidth), o.zoomWindow.wrap(o.zoomWindowContainer), "lens" == o.options
                    .zoomType && o.zoomLens.css({
                        backgroundImage: "url('" + o.imageSrc + "')"
                    }), "window" == o.options.zoomType && o.zoomWindow.css({
                        backgroundImage: "url('" + o.imageSrc + "')"
                    }), "inner" == o.options.zoomType && o.zoomWindow.css({
                        backgroundImage: "url('" + o.imageSrc + "')"
                    }), o.$elem.bind("touchmove", function(t) {
                        t.preventDefault();
                        var e = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        o.setPosition(e)
                    }), o.zoomContainer.bind("touchmove", function(t) {
                        "inner" == o.options.zoomType && o.showHideWindow("show"), t.preventDefault();
                        var e = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        o.setPosition(e)
                    }), o.zoomContainer.bind("touchend", function(t) {
                        o.showHideWindow("hide"), o.options.showLens && o.showHideLens("hide"), o.options
                            .tint && "inner" != o.options.zoomType && o.showHideTint("hide")
                    }), o.$elem.bind("touchend", function(t) {
                        o.showHideWindow("hide"), o.options.showLens && o.showHideLens("hide"), o.options
                            .tint && "inner" != o.options.zoomType && o.showHideTint("hide")
                    }), o.options.showLens && (o.zoomLens.bind("touchmove", function(t) {
                        t.preventDefault();
                        var e = t.originalEvent.touches[0] || t.originalEvent.changedTouches[0];
                        o.setPosition(e)
                    }), o.zoomLens.bind("touchend", function(t) {
                        o.showHideWindow("hide"), o.options.showLens && o.showHideLens("hide"), o
                            .options.tint && "inner" != o.options.zoomType && o.showHideTint("hide")
                    })), o.$elem.bind("mousemove", function(t) {
                        0 == o.overWindow && o.setElements("show"), o.lastX === t.clientX && o.lastY === t
                            .clientY || (o.setPosition(t), o.currentLoc = t), o.lastX = t.clientX, o.lastY =
                            t.clientY
                    }), o.zoomContainer.bind("mousemove", function(t) {
                        0 == o.overWindow && o.setElements("show"), o.lastX === t.clientX && o.lastY === t
                            .clientY || (o.setPosition(t), o.currentLoc = t), o.lastX = t.clientX, o.lastY =
                            t.clientY
                    }), "inner" != o.options.zoomType && o.zoomLens.bind("mousemove", function(t) {
                        o.lastX === t.clientX && o.lastY === t.clientY || (o.setPosition(t), o.currentLoc =
                            t), o.lastX = t.clientX, o.lastY = t.clientY
                    }), o.options.tint && "inner" != o.options.zoomType && o.zoomTint.bind("mousemove",
                        function(t) {
                            o.lastX === t.clientX && o.lastY === t.clientY || (o.setPosition(t), o.currentLoc =
                                t), o.lastX = t.clientX, o.lastY = t.clientY
                        }), "inner" == o.options.zoomType && o.zoomWindow.bind("mousemove", function(t) {
                        o.lastX === t.clientX && o.lastY === t.clientY || (o.setPosition(t), o.currentLoc =
                            t), o.lastX = t.clientX, o.lastY = t.clientY
                    }), o.zoomContainer.add(o.$elem).mouseenter(function() {
                        0 == o.overWindow && o.setElements("show")
                    }).mouseleave(function() {
                        o.scrollLock || (o.setElements("hide"), o.options.onDestroy(o.$elem))
                    }), "inner" != o.options.zoomType && o.zoomWindow.mouseenter(function() {
                        o.overWindow = !0, o.setElements("hide")
                    }).mouseleave(function() {
                        o.overWindow = !1
                    }), o.options.zoomLevel, o.options.minZoomLevel ? o.minZoomLevel = o.options.minZoomLevel :
                    o.minZoomLevel = 3 * o.options.scrollZoomIncrement, o.options.scrollZoom && o.zoomContainer
                    .add(o.$elem).bind("mousewheel DOMMouseScroll MozMousePixelScroll", function(e) {
                        o.scrollLock = !0, clearTimeout(t.data(this, "timer")), t.data(this, "timer",
                            setTimeout(function() {
                                o.scrollLock = !1
                            }, 250));
                        var i = e.originalEvent.wheelDelta || -1 * e.originalEvent.detail;
                        return e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault(), i /
                            1120 > 0 ? o.currentZoomLevel >= o.minZoomLevel && o.changeZoomLevel(o
                                .currentZoomLevel - o.options.scrollZoomIncrement) : o.options
                            .maxZoomLevel ? o.currentZoomLevel <= o.options.maxZoomLevel && o
                            .changeZoomLevel(parseFloat(o.currentZoomLevel) + o.options
                            .scrollZoomIncrement) : o.changeZoomLevel(parseFloat(o.currentZoomLevel) + o
                                .options.scrollZoomIncrement), !1
                    })
            },
            setElements: function(t) {
                if (!this.options.zoomEnabled) return !1;
                "show" == t && this.isWindowSet && ("inner" == this.options.zoomType && this.showHideWindow(
                        "show"), "window" == this.options.zoomType && this.showHideWindow("show"), this
                    .options.showLens && this.showHideLens("show"), this.options.tint && "inner" != this
                    .options.zoomType && this.showHideTint("show")), "hide" == t && ("window" == this
                    .options.zoomType && this.showHideWindow("hide"), this.options.tint || this
                    .showHideWindow("hide"), this.options.showLens && this.showHideLens("hide"), this
                    .options.tint && this.showHideTint("hide"))
            },
            setPosition: function(t) {
                if (!this.options.zoomEnabled) return !1;
                this.nzHeight = this.$elem.height(), this.nzWidth = this.$elem.width(), this.nzOffset = this
                    .$elem.offset(), this.options.tint && "inner" != this.options.zoomType && (this.zoomTint
                        .css({
                            top: 0
                        }), this.zoomTint.css({
                            left: 0
                        })), this.options.responsive && !this.options.scrollZoom && this.options.showLens && (
                        this.nzHeight < this.options.zoomWindowWidth / this.widthRatio ? lensHeight = this
                        .nzHeight : lensHeight = String(this.options.zoomWindowHeight / this.heightRatio), this
                        .largeWidth < this.options.zoomWindowWidth ? lensWidth = this.nzWidth : lensWidth = this
                        .options.zoomWindowWidth / this.widthRatio, this.widthRatio = this.largeWidth / this
                        .nzWidth, this.heightRatio = this.largeHeight / this.nzHeight, "lens" != this.options
                        .zoomType && (this.nzHeight < this.options.zoomWindowWidth / this.widthRatio ?
                            lensHeight = this.nzHeight : lensHeight = String(this.options.zoomWindowHeight /
                                this.heightRatio), this.nzWidth < this.options.zoomWindowHeight / this
                            .heightRatio ? lensWidth = this.nzWidth : lensWidth = String(this.options
                                .zoomWindowWidth / this.widthRatio), this.zoomLens.css("width", lensWidth), this
                            .zoomLens.css("height", lensHeight), this.options.tint && (this.zoomTintImage.css(
                                "width", this.nzWidth), this.zoomTintImage.css("height", this.nzHeight))),
                        "lens" == this.options.zoomType && this.zoomLens.css({
                            width: String(this.options.lensSize) + "px",
                            height: String(this.options.lensSize) + "px"
                        })), this.zoomContainer.css({
                        top: this.nzOffset.top
                    }), this.zoomContainer.css({
                        left: this.nzOffset.left
                    }), this.mouseLeft = parseInt(t.pageX - this.nzOffset.left), this.mouseTop = parseInt(t
                        .pageY - this.nzOffset.top), "window" == this.options.zoomType && (this.Etoppos = this
                        .mouseTop < this.zoomLens.height() / 2, this.Eboppos = this.mouseTop > this.nzHeight -
                        this.zoomLens.height() / 2 - 2 * this.options.lensBorderSize, this.Eloppos = this
                        .mouseLeft < 0 + this.zoomLens.width() / 2, this.Eroppos = this.mouseLeft > this
                        .nzWidth - this.zoomLens.width() / 2 - 2 * this.options.lensBorderSize), "inner" == this
                    .options.zoomType && (this.Etoppos = this.mouseTop < this.nzHeight / 2 / this.heightRatio,
                        this.Eboppos = this.mouseTop > this.nzHeight - this.nzHeight / 2 / this.heightRatio,
                        this.Eloppos = this.mouseLeft < 0 + this.nzWidth / 2 / this.widthRatio, this.Eroppos =
                        this.mouseLeft > this.nzWidth - this.nzWidth / 2 / this.widthRatio - 2 * this.options
                        .lensBorderSize), this.mouseLeft < 0 || this.mouseTop < 0 || this.mouseLeft > this
                    .nzWidth || this.mouseTop > this.nzHeight ? this.setElements("hide") : (this.options
                        .showLens && (this.lensLeftPos = String(Math.floor(this.mouseLeft - this.zoomLens
                        .width() / 2)), this.lensTopPos = String(Math.floor(this.mouseTop - this.zoomLens
                            .height() / 2))), this.Etoppos && (this.lensTopPos = 0), this.Eloppos && (this
                            .windowLeftPos = 0, this.lensLeftPos = 0, this.tintpos = 0), "window" == this
                        .options.zoomType && (this.Eboppos && (this.lensTopPos = Math.max(this.nzHeight - this
                            .zoomLens.height() - 2 * this.options.lensBorderSize, 0)), this.Eroppos && (this
                            .lensLeftPos = this.nzWidth - this.zoomLens.width() - 2 * this.options
                            .lensBorderSize)), "inner" == this.options.zoomType && (this.Eboppos && (this
                                .lensTopPos = Math.max(this.nzHeight - 2 * this.options.lensBorderSize, 0)),
                            this.Eroppos && (this.lensLeftPos = this.nzWidth - this.nzWidth - 2 * this.options
                                .lensBorderSize)), "lens" == this.options.zoomType && (this.windowLeftPos =
                            String(-1 * ((t.pageX - this.nzOffset.left) * this.widthRatio - this.zoomLens
                            .width() / 2)), this.windowTopPos = String(-1 * ((t.pageY - this.nzOffset.top) *
                                this.heightRatio - this.zoomLens.height() / 2)), this.zoomLens.css({
                                backgroundPosition: this.windowLeftPos + "px " + this.windowTopPos + "px"
                            }), this.changeBgSize && (this.nzHeight > this.nzWidth ? ("lens" == this.options
                                .zoomType && this.zoomLens.css({
                                    "background-size": this.largeWidth / this.newvalueheight + "px " +
                                        this.largeHeight / this.newvalueheight + "px"
                                }), this.zoomWindow.css({
                                    "background-size": this.largeWidth / this.newvalueheight + "px " +
                                        this.largeHeight / this.newvalueheight + "px"
                                })) : ("lens" == this.options.zoomType && this.zoomLens.css({
                                "background-size": this.largeWidth / this.newvaluewidth + "px " +
                                    this.largeHeight / this.newvaluewidth + "px"
                            }), this.zoomWindow.css({
                                "background-size": this.largeWidth / this.newvaluewidth + "px " +
                                    this.largeHeight / this.newvaluewidth + "px"
                            })), this.changeBgSize = !1), this.setWindowPostition(t)), this.options.tint &&
                        "inner" != this.options.zoomType && this.setTintPosition(t), "window" == this.options
                        .zoomType && this.setWindowPostition(t), "inner" == this.options.zoomType && this
                        .setWindowPostition(t), this.options.showLens && (this.fullwidth && "lens" != this
                            .options.zoomType && (this.lensLeftPos = 0), this.zoomLens.css({
                                left: this.lensLeftPos + "px",
                                top: this.lensTopPos + "px"
                            })))
            },
            showHideWindow: function(t) {
                var o = this;
                "show" == t && (o.isWindowActive || (o.options.zoomWindowFadeIn ? o.zoomWindow.stop(!0, !0, !1)
                        .fadeIn(o.options.zoomWindowFadeIn) : o.zoomWindow.show(), o.isWindowActive = !0)),
                    "hide" == t && o.isWindowActive && (o.options.zoomWindowFadeOut ? o.zoomWindow.stop(!0, !0)
                        .fadeOut(o.options.zoomWindowFadeOut, function() {
                            o.loop && (clearInterval(o.loop), o.loop = !1)
                        }) : o.zoomWindow.hide(), o.isWindowActive = !1)
            },
            showHideLens: function(t) {
                "show" == t && (this.isLensActive || (this.options.lensFadeIn ? this.zoomLens.stop(!0, !0, !1)
                        .fadeIn(this.options.lensFadeIn) : this.zoomLens.show(), this.isLensActive = !0)),
                    "hide" == t && this.isLensActive && (this.options.lensFadeOut ? this.zoomLens.stop(!0, !0)
                        .fadeOut(this.options.lensFadeOut) : this.zoomLens.hide(), this.isLensActive = !1)
            },
            showHideTint: function(t) {
                "show" == t && (this.isTintActive || (this.options.zoomTintFadeIn ? this.zoomTint.css({
                        opacity: this.options.tintOpacity
                    }).animate().stop(!0, !0).fadeIn("slow") : (this.zoomTint.css({
                        opacity: this.options.tintOpacity
                    }).animate(), this.zoomTint.show()), this.isTintActive = !0)), "hide" == t && this
                    .isTintActive && (this.options.zoomTintFadeOut ? this.zoomTint.stop(!0, !0).fadeOut(this
                        .options.zoomTintFadeOut) : this.zoomTint.hide(), this.isTintActive = !1)
            },
            setLensPostition: function(t) {},
            setWindowPostition: function(o) {
                var e = this;
                if (isNaN(e.options.zoomWindowPosition)) e.externalContainer = t("#" + e.options
                        .zoomWindowPosition), e.externalContainerWidth = e.externalContainer.width(), e
                    .externalContainerHeight = e.externalContainer.height(), e.externalContainerOffset = e
                    .externalContainer.offset(), e.windowOffsetTop = e.externalContainerOffset.top, e
                    .windowOffsetLeft = e.externalContainerOffset.left;
                else switch (e.options.zoomWindowPosition) {
                    case 1:
                        e.windowOffsetTop = e.options.zoomWindowOffety, e.windowOffsetLeft = +e.nzWidth;
                        break;
                    case 2:
                        e.options.zoomWindowHeight > e.nzHeight && (e.windowOffsetTop = -1 * (e.options
                            .zoomWindowHeight / 2 - e.nzHeight / 2), e.windowOffsetLeft = e.nzWidth);
                        break;
                    case 3:
                        e.windowOffsetTop = e.nzHeight - e.zoomWindow.height() - 2 * e.options.borderSize, e
                            .windowOffsetLeft = e.nzWidth;
                        break;
                    case 4:
                        e.windowOffsetTop = e.nzHeight, e.windowOffsetLeft = e.nzWidth;
                        break;
                    case 5:
                        e.windowOffsetTop = e.nzHeight, e.windowOffsetLeft = e.nzWidth - e.zoomWindow
                        .width() - 2 * e.options.borderSize;
                        break;
                    case 6:
                        e.options.zoomWindowHeight > e.nzHeight && (e.windowOffsetTop = e.nzHeight, e
                            .windowOffsetLeft = -1 * (e.options.zoomWindowWidth / 2 - e.nzWidth / 2 +
                                2 * e.options.borderSize));
                        break;
                    case 7:
                        e.windowOffsetTop = e.nzHeight, e.windowOffsetLeft = 0;
                        break;
                    case 8:
                        e.windowOffsetTop = e.nzHeight, e.windowOffsetLeft = -1 * (e.zoomWindow.width() +
                            2 * e.options.borderSize);
                        break;
                    case 9:
                        e.windowOffsetTop = e.nzHeight - e.zoomWindow.height() - 2 * e.options.borderSize, e
                            .windowOffsetLeft = -1 * (e.zoomWindow.width() + 2 * e.options.borderSize);
                        break;
                    case 10:
                        e.options.zoomWindowHeight > e.nzHeight && (e.windowOffsetTop = -1 * (e.options
                            .zoomWindowHeight / 2 - e.nzHeight / 2), e.windowOffsetLeft = -1 * (e
                            .zoomWindow.width() + 2 * e.options.borderSize));
                        break;
                    case 11:
                        e.windowOffsetTop = e.options.zoomWindowOffety, e.windowOffsetLeft = -1 * (e
                            .zoomWindow.width() + 2 * e.options.borderSize);
                        break;
                    case 12:
                        e.windowOffsetTop = -1 * (e.zoomWindow.height() + 2 * e.options.borderSize), e
                            .windowOffsetLeft = -1 * (e.zoomWindow.width() + 2 * e.options.borderSize);
                        break;
                    case 13:
                        e.windowOffsetTop = -1 * (e.zoomWindow.height() + 2 * e.options.borderSize), e
                            .windowOffsetLeft = 0;
                        break;
                    case 14:
                        e.options.zoomWindowHeight > e.nzHeight && (e.windowOffsetTop = -1 * (e.zoomWindow
                                .height() + 2 * e.options.borderSize), e.windowOffsetLeft = -1 * (e
                                .options.zoomWindowWidth / 2 - e.nzWidth / 2 + 2 * e.options.borderSize
                                ));
                        break;
                    case 15:
                        e.windowOffsetTop = -1 * (e.zoomWindow.height() + 2 * e.options.borderSize), e
                            .windowOffsetLeft = e.nzWidth - e.zoomWindow.width() - 2 * e.options.borderSize;
                        break;
                    case 16:
                        e.windowOffsetTop = -1 * (e.zoomWindow.height() + 2 * e.options.borderSize), e
                            .windowOffsetLeft = e.nzWidth;
                        break;
                    default:
                        e.windowOffsetTop = e.options.zoomWindowOffety, e.windowOffsetLeft = e.nzWidth
                }
                e.isWindowSet = !0, e.windowOffsetTop = e.windowOffsetTop + e.options.zoomWindowOffety, e
                    .windowOffsetLeft = e.windowOffsetLeft + e.options.zoomWindowOffetx, e.zoomWindow.css({
                        top: e.windowOffsetTop
                    }), e.zoomWindow.css({
                        left: e.windowOffsetLeft
                    }), "inner" == e.options.zoomType && (e.zoomWindow.css({
                        top: 0
                    }), e.zoomWindow.css({
                        left: 0
                    })), e.windowLeftPos = String(-1 * ((o.pageX - e.nzOffset.left) * e.widthRatio - e
                        .zoomWindow.width() / 2)), e.windowTopPos = String(-1 * ((o.pageY - e.nzOffset.top) * e
                        .heightRatio - e.zoomWindow.height() / 2)), e.Etoppos && (e.windowTopPos = 0), e
                    .Eloppos && (e.windowLeftPos = 0), e.Eboppos && (e.windowTopPos = -1 * (e.largeHeight / e
                        .currentZoomLevel - e.zoomWindow.height())), e.Eroppos && (e.windowLeftPos = -1 * (e
                        .largeWidth / e.currentZoomLevel - e.zoomWindow.width())), e.fullheight && (e
                        .windowTopPos = 0), e.fullwidth && (e.windowLeftPos = 0), "window" != e.options
                    .zoomType && "inner" != e.options.zoomType || (1 == e.zoomLock && (e.widthRatio <= 1 && (e
                            .windowLeftPos = 0), e.heightRatio <= 1 && (e.windowTopPos = 0)), "window" == e
                        .options.zoomType && (e.largeHeight < e.options.zoomWindowHeight && (e.windowTopPos =
                            0), e.largeWidth < e.options.zoomWindowWidth && (e.windowLeftPos = 0)), e.options
                        .easing ? (e.xp || (e.xp = 0), e.yp || (e.yp = 0), e.loop || (e.loop = setInterval(
                            function() {
                                e.xp += (e.windowLeftPos - e.xp) / e.options.easingAmount, e.yp += (e
                                        .windowTopPos - e.yp) / e.options.easingAmount, e
                                    .scrollingLock ? (clearInterval(e.loop), e.xp = e.windowLeftPos, e
                                        .yp = e.windowTopPos, e.xp = -1 * ((o.pageX - e.nzOffset.left) *
                                            e.widthRatio - e.zoomWindow.width() / 2), e.yp = -1 * ((o
                                                .pageY - e.nzOffset.top) * e.heightRatio - e.zoomWindow
                                            .height() / 2), e.changeBgSize && (e.nzHeight > e.nzWidth ?
                                            ("lens" == e.options.zoomType && e.zoomLens.css({
                                                "background-size": e.largeWidth / e
                                                    .newvalueheight + "px " + e.largeHeight / e
                                                    .newvalueheight + "px"
                                            }), e.zoomWindow.css({
                                                "background-size": e.largeWidth / e
                                                    .newvalueheight + "px " + e.largeHeight / e
                                                    .newvalueheight + "px"
                                            })) : ("lens" != e.options.zoomType && e.zoomLens.css({
                                                "background-size": e.largeWidth / e
                                                    .newvaluewidth + "px " + e.largeHeight / e
                                                    .newvalueheight + "px"
                                            }), e.zoomWindow.css({
                                                "background-size": e.largeWidth / e
                                                    .newvaluewidth + "px " + e.largeHeight / e
                                                    .newvaluewidth + "px"
                                            })), e.changeBgSize = !1), e.zoomWindow.css({
                                            backgroundPosition: e.windowLeftPos + "px " + e
                                                .windowTopPos + "px"
                                        }), e.scrollingLock = !1, e.loop = !1) : Math.round(Math.abs(e
                                        .xp - e.windowLeftPos) + Math.abs(e.yp - e.windowTopPos)) < 1 ?
                                    (clearInterval(e.loop), e.zoomWindow.css({
                                        backgroundPosition: e.windowLeftPos + "px " + e
                                            .windowTopPos + "px"
                                    }), e.loop = !1) : (e.changeBgSize && (e.nzHeight > e.nzWidth ? (
                                        "lens" == e.options.zoomType && e.zoomLens.css({
                                            "background-size": e.largeWidth / e
                                                .newvalueheight + "px " + e.largeHeight / e
                                                .newvalueheight + "px"
                                        }), e.zoomWindow.css({
                                            "background-size": e.largeWidth / e
                                                .newvalueheight + "px " + e.largeHeight / e
                                                .newvalueheight + "px"
                                        })) : ("lens" != e.options.zoomType && e.zoomLens.css({
                                        "background-size": e.largeWidth / e
                                            .newvaluewidth + "px " + e.largeHeight / e
                                            .newvaluewidth + "px"
                                    }), e.zoomWindow.css({
                                        "background-size": e.largeWidth / e
                                            .newvaluewidth + "px " + e.largeHeight / e
                                            .newvaluewidth + "px"
                                    })), e.changeBgSize = !1), e.zoomWindow.css({
                                        backgroundPosition: e.xp + "px " + e.yp + "px"
                                    }))
                            }, 16))) : (e.changeBgSize && (e.nzHeight > e.nzWidth ? ("lens" == e.options
                            .zoomType && e.zoomLens.css({
                                "background-size": e.largeWidth / e.newvalueheight + "px " + e
                                    .largeHeight / e.newvalueheight + "px"
                            }), e.zoomWindow.css({
                                "background-size": e.largeWidth / e.newvalueheight + "px " + e
                                    .largeHeight / e.newvalueheight + "px"
                            })) : ("lens" == e.options.zoomType && e.zoomLens.css({
                                "background-size": e.largeWidth / e.newvaluewidth + "px " + e
                                    .largeHeight / e.newvaluewidth + "px"
                            }), e.largeHeight / e.newvaluewidth < e.options.zoomWindowHeight ? e
                            .zoomWindow.css({
                                "background-size": e.largeWidth / e.newvaluewidth + "px " + e
                                    .largeHeight / e.newvaluewidth + "px"
                            }) : e.zoomWindow.css({
                                "background-size": e.largeWidth / e.newvalueheight + "px " + e
                                    .largeHeight / e.newvalueheight + "px"
                            })), e.changeBgSize = !1), e.zoomWindow.css({
                            backgroundPosition: e.windowLeftPos + "px " + e.windowTopPos + "px"
                        })))
            },
            setTintPosition: function(t) {
                this.nzOffset = this.$elem.offset(), this.tintpos = String(-1 * (t.pageX - this.nzOffset.left -
                        this.zoomLens.width() / 2)), this.tintposy = String(-1 * (t.pageY - this.nzOffset.top -
                        this.zoomLens.height() / 2)), this.Etoppos && (this.tintposy = 0), this.Eloppos && (this
                        .tintpos = 0), this.Eboppos && (this.tintposy = -1 * (this.nzHeight - this.zoomLens
                        .height() - 2 * this.options.lensBorderSize)), this.Eroppos && (this.tintpos = -1 * (
                        this.nzWidth - this.zoomLens.width() - 2 * this.options.lensBorderSize)), this.options
                    .tint && (this.fullheight && (this.tintposy = 0), this.fullwidth && (this.tintpos = 0), this
                        .zoomTintImage.css({
                            left: this.tintpos + "px"
                        }), this.zoomTintImage.css({
                            top: this.tintposy + "px"
                        }))
            },
            swaptheimage: function(o, e) {
                var i = this,
                    n = new Image;
                i.options.loadingIcon && (i.spinner = t("<div style=\"background: url('" + i.options
                        .loadingIcon + "') no-repeat center;height:" + i.nzHeight + "px;width:" + i
                        .nzWidth +
                        'px;z-index: 2000;position: absolute; background-position: center center;"></div>'),
                    i.$elem.after(i.spinner)), i.options.onImageSwap(i.$elem), n.onload = function() {
                    i.largeWidth = n.width, i.largeHeight = n.height, i.zoomImage = e, i.zoomWindow.css({
                        "background-size": i.largeWidth + "px " + i.largeHeight + "px"
                    }), i.swapAction(o, e)
                }, n.src = e
            },
            swapAction: function(o, e) {
                var i = this,
                    n = new Image;
                if (n.onload = function() {
                        i.nzHeight = n.height, i.nzWidth = n.width, i.options.onImageSwapComplete(i.$elem), i
                            .doneCallback()
                    }, n.src = o, i.currentZoomLevel = i.options.zoomLevel, i.options.maxZoomLevel = !1,
                    "lens" == i.options.zoomType && i.zoomLens.css({
                        backgroundImage: "url('" + e + "')"
                    }), "window" == i.options.zoomType && i.zoomWindow.css({
                        backgroundImage: "url('" + e + "')"
                    }), "inner" == i.options.zoomType && i.zoomWindow.css({
                        backgroundImage: "url('" + e + "')"
                    }), i.currentImage = e, i.options.imageCrossfade) {
                    var s = i.$elem,
                        a = s.clone();
                    if (i.$elem.attr("src", o), i.$elem.after(a), a.stop(!0).fadeOut(i.options.imageCrossfade,
                            function() {
                                t(this).remove()
                            }), i.$elem.width("auto").removeAttr("width"), i.$elem.height("auto").removeAttr(
                            "height"), s.fadeIn(i.options.imageCrossfade), i.options.tint && "inner" != i
                        .options.zoomType) {
                        var h = i.zoomTintImage,
                            r = h.clone();
                        i.zoomTintImage.attr("src", e), i.zoomTintImage.after(r), r.stop(!0).fadeOut(i.options
                            .imageCrossfade,
                            function() {
                                t(this).remove()
                            }), h.fadeIn(i.options.imageCrossfade), i.zoomTint.css({
                            height: i.$elem.height()
                        }), i.zoomTint.css({
                            width: i.$elem.width()
                        })
                    }
                    i.zoomContainer.css("height", i.$elem.height()), i.zoomContainer.css("width", i.$elem
                    .width()), "inner" == i.options.zoomType && (i.options.constrainType || (i.zoomWrap
                        .parent().css("height", i.$elem.height()), i.zoomWrap.parent().css("width", i
                            .$elem.width()), i.zoomWindow.css("height", i.$elem.height()), i.zoomWindow
                        .css("width", i.$elem.width()))), i.options.imageCrossfade && (i.zoomWrap.css(
                        "height", i.$elem.height()), i.zoomWrap.css("width", i.$elem.width()))
                } else i.$elem.attr("src", o), i.options.tint && (i.zoomTintImage.attr("src", e), i
                    .zoomTintImage.attr("height", i.$elem.height()), i.zoomTintImage.css({
                        height: i.$elem.height()
                    }), i.zoomTint.css({
                        height: i.$elem.height()
                    })), i.zoomContainer.css("height", i.$elem.height()), i.zoomContainer.css("width", i
                    .$elem.width()), i.options.imageCrossfade && (i.zoomWrap.css("height", i.$elem
                .height()), i.zoomWrap.css("width", i.$elem.width()));
                i.options.constrainType && ("height" == i.options.constrainType && (i.zoomContainer.css(
                            "height", i.options.constrainSize), i.zoomContainer.css("width", "auto"), i
                        .options.imageCrossfade ? (i.zoomWrap.css("height", i.options.constrainSize), i
                            .zoomWrap.css("width", "auto"), i.constwidth = i.zoomWrap.width()) : (i.$elem
                            .css("height", i.options.constrainSize), i.$elem.css("width", "auto"), i
                            .constwidth = i.$elem.width()), "inner" == i.options.zoomType && (i.zoomWrap
                            .parent().css("height", i.options.constrainSize), i.zoomWrap.parent().css(
                                "width", i.constwidth), i.zoomWindow.css("height", i.options.constrainSize),
                            i.zoomWindow.css("width", i.constwidth)), i.options.tint && (i.tintContainer
                            .css("height", i.options.constrainSize), i.tintContainer.css("width", i
                                .constwidth), i.zoomTint.css("height", i.options.constrainSize), i.zoomTint
                            .css("width", i.constwidth), i.zoomTintImage.css("height", i.options
                                .constrainSize), i.zoomTintImage.css("width", i.constwidth))), "width" == i
                    .options.constrainType && (i.zoomContainer.css("height", "auto"), i.zoomContainer.css(
                            "width", i.options.constrainSize), i.options.imageCrossfade ? (i.zoomWrap.css(
                                "height", "auto"), i.zoomWrap.css("width", i.options.constrainSize), i
                            .constheight = i.zoomWrap.height()) : (i.$elem.css("height", "auto"), i.$elem
                            .css("width", i.options.constrainSize), i.constheight = i.$elem.height()),
                        "inner" == i.options.zoomType && (i.zoomWrap.parent().css("height", i.constheight),
                            i.zoomWrap.parent().css("width", i.options.constrainSize), i.zoomWindow.css(
                                "height", i.constheight), i.zoomWindow.css("width", i.options.constrainSize)
                            ), i.options.tint && (i.tintContainer.css("height", i.constheight), i
                            .tintContainer.css("width", i.options.constrainSize), i.zoomTint.css("height", i
                                .constheight), i.zoomTint.css("width", i.options.constrainSize), i
                            .zoomTintImage.css("height", i.constheight), i.zoomTintImage.css("width", i
                                .options.constrainSize))))
            },
            doneCallback: function() {
                this.options.loadingIcon && this.spinner.hide(), this.nzOffset = this.$elem.offset(), this
                    .nzWidth = this.$elem.width(), this.nzHeight = this.$elem.height(), this.currentZoomLevel =
                    this.options.zoomLevel, this.widthRatio = this.largeWidth / this.nzWidth, this.heightRatio =
                    this.largeHeight / this.nzHeight, "window" == this.options.zoomType && (this.nzHeight < this
                        .options.zoomWindowWidth / this.widthRatio ? lensHeight = this.nzHeight : lensHeight =
                        String(this.options.zoomWindowHeight / this.heightRatio), this.options.zoomWindowWidth <
                        this.options.zoomWindowWidth ? lensWidth = this.nzWidth : lensWidth = this.options
                        .zoomWindowWidth / this.widthRatio, this.zoomLens && (this.zoomLens.css("width",
                            lensWidth), this.zoomLens.css("height", lensHeight)))
            },
            getCurrentImage: function() {
                return this.zoomImage
            },
            getGalleryList: function() {
                var o = this;
                return o.gallerylist = [], o.options.gallery ? t("#" + o.options.gallery + " a").each(
            function() {
                    var e = "";
                    t(this).data("zoom-image") ? e = t(this).data("zoom-image") : t(this).data(
                        "image") && (e = t(this).data("image")), e == o.zoomImage ? o.gallerylist
                        .unshift({
                            href: "" + e,
                            title: t(this).find("img").attr("title")
                        }) : o.gallerylist.push({
                            href: "" + e,
                            title: t(this).find("img").attr("title")
                        })
                }) : o.gallerylist.push({
                    href: "" + o.zoomImage,
                    title: t(this).find("img").attr("title")
                }), o.gallerylist
            },
            changeZoomLevel: function(t) {
                this.scrollingLock = !0, this.newvalue = parseFloat(t).toFixed(2), newvalue = parseFloat(t)
                    .toFixed(2), maxheightnewvalue = this.largeHeight / (this.options.zoomWindowHeight / this
                        .nzHeight * this.nzHeight), maxwidthtnewvalue = this.largeWidth / (this.options
                        .zoomWindowWidth / this.nzWidth * this.nzWidth), "inner" != this.options.zoomType && (
                        maxheightnewvalue <= newvalue ? (this.heightRatio = this.largeHeight /
                            maxheightnewvalue / this.nzHeight, this.newvalueheight = maxheightnewvalue, this
                            .fullheight = !0) : (this.heightRatio = this.largeHeight / newvalue / this.nzHeight,
                            this.newvalueheight = newvalue, this.fullheight = !1), maxwidthtnewvalue <=
                        newvalue ? (this.widthRatio = this.largeWidth / maxwidthtnewvalue / this.nzWidth, this
                            .newvaluewidth = maxwidthtnewvalue, this.fullwidth = !0) : (this.widthRatio = this
                            .largeWidth / newvalue / this.nzWidth, this.newvaluewidth = newvalue, this
                            .fullwidth = !1), "lens" == this.options.zoomType && (maxheightnewvalue <=
                            newvalue ? (this.fullwidth = !0, this.newvaluewidth = maxheightnewvalue) : (this
                                .widthRatio = this.largeWidth / newvalue / this.nzWidth, this.newvaluewidth =
                                newvalue, this.fullwidth = !1))), "inner" == this.options.zoomType && (
                        maxheightnewvalue = parseFloat(this.largeHeight / this.nzHeight).toFixed(2),
                        maxwidthtnewvalue = parseFloat(this.largeWidth / this.nzWidth).toFixed(2), newvalue >
                        maxheightnewvalue && (newvalue = maxheightnewvalue), newvalue > maxwidthtnewvalue && (
                            newvalue = maxwidthtnewvalue), maxheightnewvalue <= newvalue ? (this.heightRatio =
                            this.largeHeight / newvalue / this.nzHeight, newvalue > maxheightnewvalue ? this
                            .newvalueheight = maxheightnewvalue : this.newvalueheight = newvalue, this
                            .fullheight = !0) : (this.heightRatio = this.largeHeight / newvalue / this.nzHeight,
                            newvalue > maxheightnewvalue ? this.newvalueheight = maxheightnewvalue : this
                            .newvalueheight = newvalue, this.fullheight = !1), maxwidthtnewvalue <= newvalue ? (
                            this.widthRatio = this.largeWidth / newvalue / this.nzWidth, newvalue >
                            maxwidthtnewvalue ? this.newvaluewidth = maxwidthtnewvalue : this.newvaluewidth =
                            newvalue, this.fullwidth = !0) : (this.widthRatio = this.largeWidth / newvalue /
                            this.nzWidth, this.newvaluewidth = newvalue, this.fullwidth = !1)), scrcontinue = !
                    1, "inner" == this.options.zoomType && (this.nzWidth >= this.nzHeight && (this
                        .newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, this
                            .fullheight = !0, this.fullwidth = !0)), this.nzHeight > this.nzWidth && (this
                        .newvaluewidth <= maxwidthtnewvalue ? scrcontinue = !0 : (scrcontinue = !1, this
                            .fullheight = !0, this.fullwidth = !0))), "inner" != this.options.zoomType && (
                        scrcontinue = !0), scrcontinue && (this.zoomLock = 0, this.changeZoom = !0, this.options
                        .zoomWindowHeight / this.heightRatio <= this.nzHeight && (this.currentZoomLevel = this
                            .newvalueheight, "lens" != this.options.zoomType && "inner" != this.options
                            .zoomType && (this.changeBgSize = !0, this.zoomLens.css({
                                height: String(this.options.zoomWindowHeight / this.heightRatio) + "px"
                            })), "lens" != this.options.zoomType && "inner" != this.options.zoomType || (this
                                .changeBgSize = !0)), this.options.zoomWindowWidth / this.widthRatio <= this
                        .nzWidth && ("inner" != this.options.zoomType && this.newvaluewidth > this
                            .newvalueheight && (this.currentZoomLevel = this.newvaluewidth), "lens" != this
                            .options.zoomType && "inner" != this.options.zoomType && (this.changeBgSize = !0,
                                this.zoomLens.css({
                                    width: String(this.options.zoomWindowWidth / this.widthRatio) + "px"
                                })), "lens" != this.options.zoomType && "inner" != this.options.zoomType || (
                                this.changeBgSize = !0)), "inner" == this.options.zoomType && (this
                            .changeBgSize = !0, this.nzWidth > this.nzHeight && (this.currentZoomLevel = this
                                .newvaluewidth), this.nzHeight > this.nzWidth && (this.currentZoomLevel = this
                                .newvaluewidth))), this.setPosition(this.currentLoc)
            },
            closeAll: function() {
                self.zoomWindow && self.zoomWindow.hide(), self.zoomLens && self.zoomLens.hide(), self
                    .zoomTint && self.zoomTint.hide()
            },
            changeState: function(t) {
                "enable" == t && (this.options.zoomEnabled = !0), "disable" == t && (this.options
                    .zoomEnabled = !1)
            }
        };
        t.fn.elevateZoom = function(o) {
            return this.each(function() {
                var e = Object.create(n);
                e.init(o, this), t.data(this, "elevateZoom", e)
            })
        }, t.fn.elevateZoom.options = {
            zoomActivation: "hover",
            zoomEnabled: !0,
            preloading: 1,
            zoomLevel: 1,
            scrollZoom: !1,
            scrollZoomIncrement: .1,
            minZoomLevel: !1,
            maxZoomLevel: !1,
            easing: !1,
            easingAmount: 12,
            lensSize: 200,
            zoomWindowWidth: 400,
            zoomWindowHeight: 400,
            zoomWindowOffetx: 0,
            zoomWindowOffety: 0,
            zoomWindowPosition: 1,
            zoomWindowBgColour: "#fff",
            lensFadeIn: !1,
            lensFadeOut: !1,
            debug: !1,
            zoomWindowFadeIn: !1,
            zoomWindowFadeOut: !1,
            zoomWindowAlwaysShow: !1,
            zoomTintFadeIn: !1,
            zoomTintFadeOut: !1,
            borderSize: 4,
            showLens: !0,
            borderColour: "#888",
            lensBorderSize: 1,
            lensBorderColour: "#000",
            lensShape: "square",
            zoomType: "window",
            containLensZoom: !1,
            lensColour: "white",
            lensOpacity: .4,
            lenszoom: !1,
            tint: !1,
            tintColour: "#333",
            tintOpacity: .4,
            gallery: !1,
            galleryActiveClass: "zoomGalleryActive",
            imageCrossfade: !1,
            constrainType: !1,
            constrainSize: !1,
            loadingIcon: !1,
            cursor: "default",
            responsive: !0,
            onComplete: t.noop,
            onDestroy: function() {},
            onZoomedImageLoaded: function() {},
            onImageSwap: t.noop,
            onImageSwapComplete: t.noop
        }
    }(jQuery, window, document);
</script>

<script>
function isDevice() {
    return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase())
}

function initZoom(o, e) {
    ($.removeData("#zoom_10", "elevateZoom"), $(".zoomContainer").remove(), $(".zoomWindowContainer").remove(), $(
        "#zoom_10").elevateZoom({
        responsive: !0,
        tint: !1,
        tintColour: "#3c3c3c",
        tintOpacity: .5,
        easing: !0,
        borderSize: 0,
        loadingIcon: "https://icodefy.com/Tools/iZoom/images/loading.GIF",
        zoomWindowPosition: "productInfoContainer",
        zoomWindowWidth: 330,
        gallery: "gallery_pdp",
        galleryActiveClass: "active",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        cursor: ""
    }));
}
$(document).ready(function() {
    $("#gallery_pdp a").length > 4 && ($("#gallery_pdp a").css("margin", "0"), $("#gallery_pdp").rcarousel({
        orientation: "vertical",
        visible: 5,
        width: 105,
        height: 70,
        margin: 5,
        step: 1,
        speed: 500
    }), $("#ui-carousel-prev").show(), $("#ui-carousel-next").show()), initZoom(500, 475), $(
        "#ui-carousel-prev").click(function() {
        initZoom(500, 475)
    }), $("#ui-carousel-next").click(function() {
        initZoom(500, 475)
    })
}), $(window).resize(function() {
    $(document).width() > 769 ? initZoom(500, 475) : ($.removeData("#zoom_10", "elevateZoom"), $(
        ".zoomContainer").remove(), $(".zoomWindowContainer").remove(), $("#zoom_10").elevateZoom({
        responsive: !0,
        tint: !1,
        tintColour: "#3c3c3c",
        tintOpacity: .5,
        easing: !0,
        borderSize: 0,
        loadingIcon: "https://icodefy.com/Tools/iZoom/images/loading.GIF",
        zoomWindowPosition: "productInfoContainer",
        zoomWindowWidth: 330,
        gallery: "gallery_pdp",
        galleryActiveClass: "active",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500,
        cursor: ""
    }))
}), $(document).ready(function() {
    $("#zoom_10").fancybox();

    ($.removeData("#zoom_10", "elevateZoom"), $(".zoomContainer").remove(), $(".zoomWindowContainer").remove(),
        $("#zoom_10").elevateZoom({
            responsive: !0,
            tint: !1,
            tintColour: "#3c3c3c",
            tintOpacity: .5,
            easing: !0,
            borderSize: 0,
            loadingIcon: "https://icodefy.com/Tools/iZoom/images/loading.GIF",
            zoomWindowPosition: "productInfoContainer",
            zoomWindowWidth: 330,
            gallery: "gallery_pdp",
            galleryActiveClass: "active",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 500,
            lensFadeIn: 500,
            lensFadeOut: 500,
            cursor: ""
        }));


});


function hideYoutube() {

    $(document).ready(function() {
        $(".galleryDIv").show();


        $(".youtubeDiv").hide();

    });

}

function ShowYoutube() {

    $(document).ready(function() {
        $(".galleryDIv").hide();

        $(".zoomContainer").remove();
        $(".youtubeDiv").show();

    });

}
</script>
<!--pd-->
<?php } ?>

<script>
// $(window).scroll(function() {
//     if ($(window).scrollTop() >= 150) {
//         $('header.header').addClass('fixed-header');
//         $('header.header').addClass('visible-title');
//         $('body').addClass('enable_products_filters_list');
//     } else {
//         $('header.header').removeClass('fixed-header');
//         $('header.header').removeClass('visible-title');
//         $('body').removeClass('enable_products_filters_list');
//     }
// });
</script>



<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Initialize Swiper -->
<script>
var swiper = new Swiper(".owl_slider_services_slider", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: false,
    slidesPerView: "auto",
    coverflowEffect: {
        rotate: 20,
        stretch: 0,
        depth: 30,
        modifier: 1,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
    },
});
</script>


<script>
var freebieApplicableAmount = $("#freebie_applicable_amount").val();
$('input[name="freebie[]"]').click(function() {

    var checkCount = $("input[name='freebie[]']:checked").length;
    if (checkCount > freebieApplicableAmount) {
        alert("You can select maximum " + freebieApplicableAmount + " Freebie products.");
        return false;
    }


});




$('input[name="freebie"]').on('change', function() {
    $('input[name="freebie"]').not(this).prop('checked', false);
});

$('input[name="exclusive"]').on('change', function() {
    $('input[name="exclusive"]').not(this).prop('checked', false);
});

$('input[name="evergreen"]').on('change', function() {
    $('input[name="evergreen"]').not(this).prop('checked', false);
});
</script>



</body>

</html>