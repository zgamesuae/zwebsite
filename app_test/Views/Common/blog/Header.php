<?php 

$uri = service('uri'); 
$session = session();
global $userModel,$productModel,$category_model,$brandModel,$reviewModel,$blogModel,$orderModel;
global $uri1,$uri2,$uri3;
if(is_null(get_cookie("language")))
set_cookie("language" , "EN" , 3600);

$userModel = model('App\Models\UserModel', false);
$productModel = model('App\Models\ProductModel');
$category_model = model('App\Models\Category');
$brandModel = model("App\Models\BrandModel");
$reviewModel = model("App\Models\ReviewModel");
$blogModel = model("App\Models\BlogModel");
$orderModel = model("App\Models\OrderModer");


$user_loggedin = $session->get('userLoggedin'); 
$user_id = ($user_loggedin) ? $user_loggedin : session_id();

if($user_loggedin){
    $user_details_req = "select * from users where user_id='".$user_id."'";
    $user_details = $userModel->customQuery($user_details_req);
}

$setting_req = "select * from settings";
$settings = $userModel->customQuery($setting_req);

$cart_count_req = "select * from cart where user_id='".$user_id."'";
$cart_count = $userModel->customQuery($cart_count_req);
$cart_count = (is_null($cart_count)) ? [] : $cart_count; 
include __DIR__.'/../Google_seo.php';
$seo = pageseo($uri);

$sql="select * from master_category where parent_id='0' AND status='Active' order by precedence asc limit 6";
$master_category=$userModel->customQuery($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="google-site-verification" content="Fmp4DyHQmvzmHdFom6khSMpOqdZB7DnT-86VmzT_1xQ" />

    <title><?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?></title>
    
    <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
    <link rel="canonical" href="<?php echo base_url().$_SERVER["REQUEST_URI"];?>">
    <meta name="description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_description);}?>">
    <?php if($seo[0]): ?>
    <meta name="keywords" content="<?php echo @$seo[0]->page_keywords;?>">
    <?php endif; ?>
    <meta property="og:title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
    <meta property="og:description" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_description;}else{ echo ucwords($settings[0]->business_description);}?>">
    <meta property="og:image" content="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->logo;?>">
    <meta property="og:url" content="<?php echo base_url().$_SERVER["REQUEST_URI"] ?>">
    <meta name="twitter:card" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">

    <!--  Non-Essential, But Recommended -->
    <meta property="og:site_name" content="<?php  echo ucwords($settings[0]->business_name);?>">
    <meta name="title" content="<?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo ucwords($settings[0]->business_name);}?>">
    <meta name="robots" content="index,follow">
    
    <?php breadcrumb($uri); ?>

    
    <!--<meta name="facebook-domain-verification" content="qd7k6t5w0jkfkjr06anbcz2qye8zxk" />-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/yahia_custom_css.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/menu/index.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/css/blog/blog.css">
    <!-- Bootstrat new version css -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <!-- Bootstrat new version css -->
    
    <!-- Spin wheel css -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/wheel/spin.scss">
    <!-- Spin wheel css -->

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/responsive_css/mobile.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrat new version script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrat new version script -->
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-221699796-1"></script>-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10869345900"></script>
    <meta name="p:domain_verify" content="a71ac49067cac8d86d6cde27b8dd70bc" />
    
    <!-- Meta Pixel Code -->
    <?php if(true): ?>
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '560177771810180');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=560177771810180&ev=PageView&noscript=1"/></noscript>
    <?php endif; ?>
    <!-- End Meta Pixel Code -->

    
    <?php if(true): ?>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        // gtag('config', 'UA-221699796-1');
        gtag('config', 'AW-10869345900');
    </script>
    <?php endif; ?>
 
    <!-- Event snippet for Order Placed conversion page --> 
    
    
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6362536adaff0e1306d54c2d/1ggs1bmkt';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    
    <!-- TIKTOK PIXEL -->
	<script>
		!function (w, d, t) {
		  w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++ )ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=i,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script");n.type="text/javascript",n.async=!0,n.src=i+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
		  ttq.load('CG8QE0JC77U082QFBFSG');
		}(window, document, 'ttq');
	</script>
    <!-- TIKTOK PIXEL -->
    
    <!-- Tiktok Events -->
    <?php 
        if(true)
        include __DIR__.'/../Tiktok_events.php'; 
    ?>
    <!-- Tiktok Events -->

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-W4FSM8K');
    </script>
    <!-- End Google Tag Manager -->

    <!-- Social Login -->
    <script>
        function auth_popup(provider) {
            // replace 'path/to/hybridauth' with the real path to this script
            sw = screen.width/2 - 300
            sh = screen.height/2 - 200
            var authWindow = window.open('<?php echo base_url()?>/auth/social_login/?provider=' + provider, 'authWindow', 'width=600,height=400,scrollbars=yes,top='+sh+'px,left='+sw+'px');
            window.closeAuthWindow = function () {
              authWindow.close();
            }

            return false;
        }
    </script>
    <!-- Social Login -->
    

    <style>
        #verifyOTP {
            /*display: none*/
        }

        .search_box {
            margin-right: 10px
        }

        .search_box {
            fill: #fff
        }

        .header_serach_parent {
            display: none;
            padding: 0 10px 9px 13px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
            background: #fff
        }

        .header_serach_parent .header_serach {
            width: fit-content;
            margin-left: auto;
            margin-right: 7px;
            margin-top: 4px;
            margin-bottom: 9px
        }

        form.search_box {
            display: flex;
            border: 1px solid #eae8e8;
            border-radius: 4px
        }

        form.search_box input {
            width: 100%;
            border: unset
        }

        <?php if(get_cookie("language") == "AR"): ?>

        /* Arabic style */
            /* GENERAL FONT STYLE */
            @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@200;400&display=swap');
            body *{
                font-family: 'Cairo', sans-serif;
            }

            /* END GENERAL FONT STYLE */

        
            /* footer style */
                .footer_inner h5::after{
                right: 0
            }

            .footer_inner ul{
                padding-right:0px
            }
            /* end footer style */

            /* MENU STYLE  */

            .open_menu_mobile_s{
                right:100%
            }

            .cart.color-white{
                margin: 0px 11px 0px;
            }
            .cart.color-white span{
                position: relative
            }
            
            .account_wishlist{
                margin-right:auto;
                margin-left:0px;
            }

            @media only screen and (max-width: 767px){
                div#acount_menu_open_dic{
                    left: 15px;
                    right: auto
                }
            }

            .header_top_right{
                margin-right: auto;
                margin-left: 0
            }

            ul.main_menu .dropdown_icon{
                transform: rotateY(180deg)
            }

            /* END MENU STYLE */

            /* CATEGORY PAGE SHOP BY CATEGORY */

            .container-fluid .categories .category .overlay_title{
                clip-path: polygon(100% 50%,0% 100%,100% 100%)
            }

            .container-fluid .categories .category .overlay_title h3{
                right: 10px;
                left: auto
            }

            /* CATEGORY PAGE SHOP BY CATEGORY */

            /* LOGIN FORM ARABIC STYLING */
            .eye_password{
                right:auto;
                left: 25px
            }
            /* END LOGIN FORM ARABIC STYLING */


            /* FILTERS PRODUCT LIST */

            .titie_heasder svg{
                right: auto;
                left: 13px
            }

            /* END FILTERS PRODUCT LIST */

            /* MODAL STYLING */
            .modal-header .close{
                margin-right: auto;
                margin-left: -1rem
            }




        /* END Arabic style */
        <?php endif; ?>


    </style>

</head>


<body class="blog-page">

    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W4FSM8K" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    
    <?php if(false): ?>
    <div class="header_serach_parent">
        <div class="header_serach">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                <path fill="none" d="M0 0h24v24H0z" />
                <path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
            </svg>
        </div>
        <form class="search_box" action="<?php echo base_url();?>/product-list">
            <input name="keyword" required type="text" value="<?php echo @$_GET['keyword']?>">
            <button class="btn btn-primary"><?php echo lg_get_text("lg_85") ?></button>
        </form>
    </div>
    <?php endif; ?>
    
    <!-- Website Overlay on loading -->
    <div class="ws-overlay"></div>
    <!-- Website Overlay on loading -->

    <header class="container-fluid header justify-content-center p-0" id="nav_bar" >
        <div class="row justify-content-center m-0 p-0">
            <div class="col-lg-11 col-sm-12 col-md-12">
                <?php echo view("Common/Top_bar" , ["user_loggedin"=> $user_loggedin, "user_details"=> (isset($user_details)) ? $user_details : null , "settings" => $settings]) ?>
                <?php 
                    if(false)
                    echo view("Common/Middle_header" , ["user_loggedin" => $user_loggedin , "cart_count" => $cart_count , "settings" => $settings])
                ?>

                <?php 
                    if(false)
                    
                    echo view("Common/Main_menu" , ["settings" => $settings]);
                ?>
            </div>
        </div>
        <div class="alert alert-warning alert-dismissible fade show errors-back" role="alert" style="position: absolute; top: 100%; z-index: 15; width: 100%; display: none">
            <strong>Alert:</strong> <span class="error-content"></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </header>
    
    <!-- login modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md rounded">
            <div class="modal-content" style="background-color: #092E49;">
                <div class="model_eader " style="z-index: 1; top: 10px; right: 10px; background: none">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">×</span></button>
                </div>
                <div class="modal-body" style="color: white" >

                    <!-- Conent start -->

                    <!-- Content end -->

                </div>
            </div>
        </div>
    </div>
    <!-- login modal -->
