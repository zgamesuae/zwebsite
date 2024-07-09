
<?php 
    $storeCustomers = model("App\Model\Storecustomers");
    $store_id = (isset($s_id)) ? $s_id : $_GET["store_id"];
    $store = $storeCustomers->get_store($store_id);
    $userModel = model("App\Model\UserModel");
    $sql="select * from settings";
    $settings=$userModel->customQuery($sql);

    // var_dump($storeCustomers->get_store_agents($store->id));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/yahia_custom_css.css">

    <!-- Bootstrat new version css -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <!-- Bootstrat new version css -->
    


    <!-- slide a bar  -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- slide a bar  -->

    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/responsive.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta name="p:domain_verify" content="a71ac49067cac8d86d6cde27b8dd70bc" />
 <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-221699796-1">
    </script>

    <!-- Bootstrat new version script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrat new version script -->


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        form.customer-review input,form.customer-review select{
           height: calc(2.5em + .75rem + 2px)
        }
        .emoji svg{
            /* mix-blend-mode: luminosity; */
        }
        .emoji:hover svg{
            /* display: none; */
            mix-blend-mode: normal;
        }
        #slider {
            margin: 10px;
            height: 1.8rem!important;

        }

        svg path.face-color{
            transition: all .1s 0s ease;
            fill:hsl(0deg 100% 50%)
        }

        svg path.smile{
            transition: all .5s 0s ease;
        }

        svg circle{
            transition: all .5s 0s ease;
        }

        div#agents{
            /* overflow-x: scroll; */
            /* background-color: rgb(241, 241, 241); */
        }

        #agents div{
            flex-wrap: nowrap;
        }

        #agents .item{
            background-color: white;
            cursor: pointer;
        }
        #agents img{
            /* max-width: 100%; */
            scale: 1;
            mix-blend-mode: luminosity;
        }

        #agents img.img-scale{
            scale : 1.1
        }

        .cr-error{
            color: red;
            position: absolute;
            bottom: -20px;
            right: 25px;
            font-size: .8rem
        }

        .cr-success h2{
            font-size: 20px;
            line-height: 35px;
            color: rgb(48, 48, 48)
        }

        /* @media screen and (max-width:900px){
            #agents::-webkit-scrollbar{
            display: none;
        }
        } */

        .store_name{
            background-color: #22398d;
            color: white;
        }

        .store_name > *{
            font-size: 1.5rem
        }


    

        /* CodePen */
            html input[type="range"] {
	            outline: 0;
	            border: 0;
	            border-radius: 500px;
	            width: 400px;
	            max-width: 100%;
	            margin: 24px 0 16px;
	            transition: box-shadow 0.2s ease-in-out;
            }
            @media screen and (-webkit-min-device-pixel-ratio: 0) {
        	html input[type="range"] {
        		overflow: hidden;
        		height: 40px;
        		-webkit-appearance: none;
        		background-color: #ddd;
        	}
        	html input[type="range"]::-webkit-slider-runnable-track {
        		height: 40px;
        		-webkit-appearance: none;
        		color: #444;
        		transition: box-shadow 0.2s ease-in-out;
        	}
        	html input[type="range"]::-webkit-slider-thumb {
        		width: 40px;
        		-webkit-appearance: none;
        		height: 40px;
        		cursor: ew-resize;
        		background: #fff;
        		box-shadow: -340px 0 0 320px #1597ff, inset 0 0 0 40px #1597ff;
        		border-radius: 50%;
        		transition: box-shadow 0.2s ease-in-out;
        		position: relative;
        	}
        	html input[type="range"]:active::-webkit-slider-thumb {
        		background: #fff;
        		box-shadow: -340px 0 0 320px #1597ff, inset 0 0 0 3px #1597ff;
        	}
            }

            html input[type="range"]::-moz-range-progress {
            	 background-color: #43e5f7;
            }
            html input[type="range"]::-moz-range-track {
    	        background-color: #9a905d;
            }
            html input[type="range"]::-ms-fill-lower {
    	        background-color: #43e5f7;
            }
            html input[type="range"]::-ms-fill-upper {
    	        background-color: #9a905d;
            }
            #h4-container {
    	        width: 400px;
    	        max-width: 100%;
    	        padding: 0 20px;
    	        box-sizing: border-box;
    	        position: relative;
            }
            #h4-container #h4-subcontainer {
    	        width: 100%;
    	        position: relative;
            }
            #h4-container #h4-subcontainer h4 {
    	        display: flex;
    	        align-items: center;
    	        justify-content: center;
    	        position: absolute;
    	        top: 0;
    	        width: 40px;
    	        height: 40px;
    	        color: #fff !important;
    	        font-size: 12px;
    	        transform-origin: center -10px;
    	        transform: translateX(-50%);
    	        transition: margin-top 0.15s ease-in-out, opacity 0.15s ease-in-out;
                z-index: 2;
            }
            #h4-container #h4-subcontainer h4 span {
    	        position: absolute;
    	        width: 100%;
    	        height: 100%;
    	        top: 0;
    	        left: 0;
    	        background-color: #1597ff;
    	        border-radius: 0 50% 50% 50%;
    	        transform: rotate(45deg);
    	        z-index: -1;
            }
            input:not(:active) + #h4-container h4 {
    	        opacity: 0;
    	        margin-top: -50px;
    	        pointer-events: none;
            }

        /* CodePen */


    </style>
</head>

<body>

    <div class="container-fluid" style="background-color: #fcfbf3;">
            
        <div class="container px-0 px-md-0 d-flex-row j-c-center " style="background-color:transparent">

            <?php if(isset($internal)): ?>
            <div class="alert alert-danger col-auto m-auto"  role="alert" >
                <?php echo $internal ?>
            </div>
            <?php endif; ?>


            <div class="row m-0 col-12 col-lg-8 j-c-center store_name">
                <h1 class="my-4 text-center"><?php echo $store->name ?> STORE</h1>
            </div>

            <div class="col-12 col-md-12 col-lg-8 p-3 border mb-5" style="background-color: white;">
                <?php if(!isset($success) || (isset($success) && !$success) && $store): ?>
                <form action="<?php echo base_url() ?>/stores/agent_review" method="post" class="customer-review p-0 p-md-2 col-12 m-0 row mx-0 j-c-center form-floating">

                    <div class="col-12 col-md-12 my-3 row j-c-center">
                        <div class="col-12">
                            <h2 class="m-0 my-4 text-center col-12">Express your emotion</h1>
                        </div>

                        <div class="col-auto emoji"> 
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 332 332" height="150px" width="150px">
                                <g id="Layer_2" data-name="Layer 2">
                                    <g id="Layer_1-2" data-name="Layer 1">
                                        <path class="face-color" d="M166,327C77.22,327,5,254.78,5,166S77.22,5,166,5,327,77.22,327,166,254.78,327,166,327Z"  />
                                        <path d="M166,10A156,156,0,1,1,10,166,156,156,0,0,1,166,10m0-10A166,166,0,0,0,48.62,283.38,166,166,0,1,0,283.38,48.62,164.91,164.91,0,  0,0,166,0Z" />
                                        <circle cx="110" cy="125.5" r="29.5" />
                                        <circle class="eye-left" cx="101.04" cy="144.8" r="4.5" style="fill:#404040" />
                                        <circle cx="222" cy="125.5" r="29.5" />
                                        <path class="smile" d="M110,254.94s15.79-31.69,55.92-31.69S222.25,255,222.25,255" style="fill:none;stroke:#000;stroke-linecap:round;stroke-miterlimit:10;stroke-width:10px" />
                                        <circle class="eye-right" cx="209.29" cy="144.8" r="4.5" style="fill:#404040" />
                                    </g>
                                </g>
                            </svg> 
                        </div>
                    </div>    

                    <div class="col-12 row j-c-center my-3">
                        <input id="slider" name="cr-rating" type="range" value=0>
                        <input type="text" name="cr-storeid" id="" hidden value="<?php echo $store->id ?>">
                        <div id="h4-container">
                            <div id="h4-subcontainer">
                                <h4>0<span></span></h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 my-3" id="agents">
                        <!-- <label for="name" class="form-label">Full name</label> -->
                        <!-- <input type="text" name="cr-agentid" id="" value="" hidden> -->
                         <?php 
                            $agents = $storeCustomers->get_store_agents($store->id);
                            if(!is_null($agents)):
                        ?>
                        <select name="cr-agentid" id="" class="form-control col-12" required>
                            <option value="">Select agent</option>
                            <?php 
                                $agents = $storeCustomers->get_store_agents($store->id);
                                foreach($agents as $value):
                            ?>
                                <option value="<?php echo $value->id ?>"><?php echo $value->first_name." ".$value->last_name ?></option>
                            <?php
                                endforeach; 
                            ?>
                        </select>
                            <?php
                                endif;
                            ?>

                        <!-- <div class="owl-carousel owl-theme agent-carousel">
                            <div class="item my-2 d-flex-row j-c-center" data-id="1"><img class="col-12 col-lg-9"  src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                            <div class="item my-2 d-flex-row j-c-center" data-id="11"><img class="col-12 col-lg-9" src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                            <div class="item my-2 d-flex-row j-c-center" data-id="12"><img class="col-12 col-lg-9" src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                            <div class="item my-2 d-flex-row j-c-center" data-id="13"><img class="col-12 col-lg-9" src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                            <div class="item my-2 d-flex-row j-c-center" data-id="14"><img class="col-12 col-lg-9" src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                            <div class="item my-2 d-flex-row j-c-center" data-id="15"><img class="col-12 col-lg-9" src="<?php echo base_url() ?>/assets/others/agent_c.png" alt=""></div>
                        </div> -->

                    </div>

                    <div class="col-12 col-md-12 my-3">
                        <!-- <label for="name" class="form-label">Full name</label> -->
                        <?php if(isset($errors) && isset($errors["cr-order_nbr"])):?> <span class="cr-error"><?php echo $errors["cr-order_nbr"] ?></span> <?php endif; ?>
                        <input type="text" name="cr-order_nbr" id="" class="form-control p-3" placeholder="Your receip number - Ex: 15485458" required>
                    </div>

                    <div class="col-12 col-md-12 my-3">
                        <!-- <label for="name" class="form-label">Full name</label> -->
                        <?php if(isset($errors) && isset($errors["cr-name"])):?> <span class="cr-error"><?php echo $errors["cr-name"] ?></span> <?php endif; ?>
                        <input type="text" name="cr-name" id="" class="form-control p-3" placeholder="Your full name"  required>
                    </div>

                    <div class="col-12 col-md-12 my-3">
                        <!-- <label for="email" class="form-label">E-mail</label> -->
                        <?php if(isset($errors) && isset($errors["cr-email"])):?> <span class="cr-error"><?php echo $errors["cr-email"] ?></span> <?php endif; ?>
                        <input type="text" name="cr-email" id="" class="form-control p-3" placeholder="Your E-mail" required>
                    </div>

                    <div class="col-12 col-md-12 my-3">
                        <!-- <label for="phone" class="form-label">Phone number</label> -->
                        <?php if(isset($errors) && isset($errors["cr-phone"])):?> <span class="cr-error"><?php echo $errors["cr-phone"] ?></span> <?php endif; ?>
                        <input type="text" name="cr-phone" id="" class="form-control p-3" placeholder="Your Phone number -Ex : (<?php echo PHONE_CODE ?>)526845532" required>
                    </div>

                    <div class="col-12 col-md-12 my-3">
                        <label for="expdesc" style="font-weight: 600;">Tell us more about your experience</label>
                        <textarea rows="10" name="cr-more" type="email" class="p-4 form-control" id="expdesc" placeholder="Describe your shopping experience with us, remember to be honest, helpful, and constructive!"></textarea>
                    </div>

                    <div class="col-12 d-flex j-c-center">
                        <button class="btn btn-primary m-0 col-6 col-md-3">Submit</button>
                    </div>

                </form>
                <?php elseif(isset($success) && $success):?>
                <div class="col-12 m-0 row j-c-center cr-success">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"  width="200" height="200"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 64v80L256 320l78.4-53.9c26.1-60.2 84.9-103 154.1-105.9L512 144V64H0zM274.1 346.4L256 358.8l-18.1-12.5L0 182.8V448H360.2C335.1 417.6 320 378.5 320 336c0-7.5 .5-14.9 1.4-22.1l-47.2 32.5zM640 336c0-79.5-64.5-144-144-144s-144 64.5-144 144s64.5 144 144 144s144-64.5 144-144zm-65.4-32l-11.3 11.3-72 72L480 398.6l-11.3-11.3-40-40L417.4 336 440 313.4l11.3 11.3L480 353.4l60.7-60.7L552 281.4 574.6 304z" style="fill: #228d2a"/></svg>
                </div>
                <div class="col-12 m-0 row j-c-center cr-success">
                    <h2 class="m-3 text-center">Thank you for shoping with ZGames, your review has been transfered successfully, we will concider it.</h2>
                </div>

                <?php 
                    else: 
                        echo "error";
                    endif 
                 ?>



            </div>
        </div>
    </div>

    <?php 
        if(isset($success) && $success && isset($store_id)):
    ?>

        <script>
        var base_url = "<?php echo base_url();?>/";
            setTimeout(() => {
          location.href=base_url+"stores?store_id="+<?php echo $store_id ?>
        }, "3000")
        </script>

    <?php 
        endif; 
    ?>




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
    
    <script>
        
        // CodePen
        $(function() {
        	var rangePercent = $('[type="range"]').val();
        	$('[type="range"]').on('change input', function() {
        		rangePercent = $('[type="range"]').val();
        		$('h4').html(rangePercent+'<span></span>');
        		$('[type="range"], h4>span').css('filter', 'hue-rotate(-' + rangePercent + 'deg)');
        		// $('h4').css({'transform': 'translateX(calc(-50% - 20px)) scale(' + (1+(rangePercent/100)) + ')', 'left': rangePercent+'%'});
        		$('h4').css({'transform': 'translateX(-50%) scale(' + (1+(rangePercent/100)) + ')', 'left': rangePercent+'%'});

               $("path.face-color").css({'fill' : 'hsl('+rangePercent+'deg 100% 50%)'})
               if(rangePercent < 20){
               $("path.smile").attr("d" ,"M110,254.94s15.79-31.69,55.92-31.69S222.25,255,222.25,255")
            
               $("circle.eye-left").attr("cy" , "144.8")
               $("circle.eye-left").attr("cx" , "101.04")
               $("circle.eye-left").attr("r" , "4.5")
               $("circle.eye-right").attr("cy" , "144.8")
               $("circle.eye-right").attr("cx" , "209.29")
               $("circle.eye-right").attr("r" , "4.5")
               }
           
               else if(rangePercent > 20 && rangePercent < 40){
               $("path.smile").attr("d" ,"M109.88,238.93s15.79-15.68,55.92-15.68S222.13,239,222.13,239")
            
               $("circle.eye-left").attr("cy" , "137.8")
               $("circle.eye-left").attr("cx" , "101.04")
               $("circle.eye-left").attr("r" , "5.83")
               $("circle.eye-right").attr("cy" , "137.8")
               $("circle.eye-right").attr("cx" , "209.29")
               $("circle.eye-right").attr("r" , "5.83")
               }
           
               else if(rangePercent > 40 && rangePercent < 60){
               $("path.smile").attr("d" ,"M109.75,239.31s15.79-.05,55.92-.05,56.33.11,56.33.11")
            
               $("circle.eye-left").attr("cy" , "132.79")
               $("circle.eye-left").attr("cx" , "104.04")
               $("circle.eye-left").attr("r" , "5.83")
               $("circle.eye-right").attr("cy" , "132.79")
               $("circle.eye-right").attr("cx" , "212.29")
               $("circle.eye-right").attr("r" , "5.83")
               }
           
               else if(rangePercent > 60 && rangePercent < 80){
               $("path.smile").attr("d" ,"M109.63,223.3S125.42,239,165.54,239s56.33-15.64,56.33-15.64")
            
               $("circle.eye-left").attr("cy" , "129.79")
               $("circle.eye-left").attr("cx" , "106.04")
               $("circle.eye-left").attr("r" , "7.5")
               $("circle.eye-right").attr("cy" , "129.79")
               $("circle.eye-right").attr("cx" , "218.3")
               $("circle.eye-right").attr("r" , "7.5")
               }
           
               else if(rangePercent > 80 && rangePercent <= 100){
               $("path.smile").attr("d" ,"M110,223.31s15.33,31.63,55.46,31.63,56.79-31.56,56.79-31.56")
            
               $("circle.eye-left").attr("cy" , "125.5")
               $("circle.eye-left").attr("cx" , "109.96")
               $("circle.eye-left").attr("r" , "10.17")
               $("circle.eye-right").attr("cy" , "125.5")
               $("circle.eye-right").attr("cx" , "221.75")
               $("circle.eye-right").attr("r" , "10.17")
               }
           
            //    console.log($("path.smile").attr("d"))
        	});
        });
        // CodePen

    </script>

</body>
</html>



