<?php
    // $timezone = new \DateTimeZone(TIME_ZONE);
    // $start = (new \dateTime("30-05-2022 15:30:00",$timezone))->setTimestamp(strtotime("30-05-2022 15:30:00"));
    // $end = (new \dateTime("now",$timezone))->setTimestamp(strtotime("10-06-2022 12:00:00"));

    // $date = new \dateTime("now",$timezone);

    // var_dump($start->format("Y-m-d H:i:s"),$date->format("Y-m-d H:i:s"),$end->format("Y-m-d H:i:s"));
    // var_dump(($date>$start && $date<$end));
    $storeCustomers = model("App\Model\Storecustomers");
    $store_cities = $storeCustomers->get_store_cities();
    $uae_cities = ["Dubai" , "Sharjah" , "Al Ain" , "Abu Dhabi"];
    $sa_cities = ["Jeddah" , "Al Riyadh" , "Dhahran" , "Tabuk" , "Jazan"];
    $qtr_cities = ["Doha"];
    $omn_cities = ["Muscat" , "Sohar" , "Sur"]
?>



    <style>
        @font-face {
            font-family: gobold;
            src: url("<?php echo base_url() ?>/assets/fonts/Gobold Bold.otf");
        }
        
        .stores-rail{
            overflow-x: scroll;
            height: auto;
            position: relative;
        }


        .stores_container{
            display: inline-flex;
            height:auto;
            width: auto;
            min-width: 100%;
            background-color: #edededfd;

            /* flex-wrap: nowrap; */
        }

        .store-city{
            /* position: absolute; */
            border-radius: 15px 15px 0 0;
            height: auto;
            background-color: #2a2a2afd;
            color:rgb(243, 243, 243);
            text-align: center;
            font-family: gobold;
        }
        
        /* .stores-rail .store-city:after{
            content:"";
            height: 50%;
            width: calc(100% / 4);
            width: 100%;
            background-color: #2a2a2afd;
            position: absolute;
            right: -11%;
            bottom: 0px; 
            clip-path: polygon(0% 0%, 25% 0%, 100% 100%, 0% 100% );
        } */

        .stores-location{
            cursor: pointer;
        }
        
        .stores-location i{
            position: absolute;
            top: 50%;
            <?php if(get_cookie("language") == "AR") echo "left: 35px;"; else echo "right: 35px;"?>
            transform: translateY(-50%);
            font-size: 1.5rem;
        }

        .store{
            position: relative;
            min-height: 350px; 
            max-height:450px;
            width: 300px;
            max-width: 100%;
            box-shadow: #00000040 1px 1px 15px;
            display: inline-block;
            /* background-color: rgb(36, 66, 150); */
        }

        .store:hover{
            transition: .8s cubic-bezier(0.075, 0.82, 0.165, 1);
            transform: scale(1.02)
        }

        .store .store-body{
            height:auto;
            width: 100%;
            /*background-color:rgb(243 243 243);*/
        }

        .store .store-body .store-coming{
            height: 100%;
        }

        .store .store-body.s-opening{
            height: 100%;
        }

        .store .store-body .store-header{
            position: relative;
            top: 0px;
            left: 0px;
            height: 65px;
            width: 110%;
            background-color:rgb(34 57 141);
            clip-path: polygon(4% 0%, 96% 0%, 102% 150%, 102% 175%, 0% 175%, 0% 102% ,-2% 150%);
            color:white
        }

        .store-header i{
            font-size: 30px;
        }
        .store-header a{
            color: white;
            text-decoration: underline;
        }

        .store .store-body .store-header.locked{
            background-color:rgb(54, 54, 54);
        }

        .store-header h3{
            /* transform: scale3d(0.5, 1, 1.7); */
            font-size: 20px;
            color : rgb(243, 243, 243)
        }

        .store .store-body .store-header:after{
            content:"";
            color: black;
            position: absolute;
            height:150px;
            width:100%;
            /* background-color:rgb(12 27 78); */
            top:99%;
            z-index: 1000;
            background-image: url("<?php echo base_url()?>/assets/store_dec.svg");
            background-size: 100%;
            background-repeat: no-repeat;
            /* clip-path:polygon(0% 0%,100% 0%,100% 100%,100% 100%,50% 35%,0% 100%); */
            

        }

        .store .store-body .store-header.locked:after{
            /* background-color:rgb(20, 20, 20); */
            background-image: url("<?php echo base_url()?>/assets/store_dec_dark.svg");
            background-size: 100%;
            background-repeat: no-repeat;
            
        }

        .store-body .store-detail{
            cursor: pointer;
        }

        .store .store-logo{
            width: 75%;
            height: 15%;
            background: rgb(0, 0, 0);
            border-top-left-radius: 100%;
            border-top-right-radius: 100%;

            position: relative;
            top: 10px

        }

        .store .store-logo img{
            height: 55%;
            width: auto;
        }

        .store-timing p,.store-info p{
            font-size: 14px
        }

        .store-timing ul{
            list-style: none;
            font-size: 14px

        }

        .store-timing h4,.store-info h4{
            font-size: 17px;
            color: #098f4b
        }

        .store-images img{
            float: left;
            max-width: 30%;
        }

        .preview-detail{
            max-height: calc(100vh - 250px);
            overflow-y: scroll;
        }

        div:is(.gallery,.about,.location) h4 {
            font-size: 22px;
            /* color: rgb(243, 243, 243); */
        }
        
        .about p{
            font-weight: 300;
        }

        .open-soon{
            font-size: 2.6rem;
            font-weight: bold;
            text-transform: capitalize;
            text-align: center;
            /*transform: rotate(-45deg);*/
            position: relative;
            top: 60px;
            opacity: .8;
            line-height: 40px;
        }
        
    </style>


    <div class="container-fluid my-5" <?php content_from_right() ?>>
        <div class="container px-0" style="height: auto">
                <!-- store container -->
                <div class="row col-12">
                    <h1 class="col-12" style="text-align: center;"><?php echo lg_get_text("lg_58") ?></h1>
                </div>
                <div class="row col-12 py-4 px-0 mx-0 my-4">
                    <?php foreach($store_cities as $k=> $city): ?>

                    <?php 
                        $stores = $storeCustomers->get_city_stores($city->city);
                        if($stores && sizeof($stores) > 0):
                    ?>
                    <div class="col-12 px-0 my-4">

                        <!-- City name -->
                        <div class="col-auto stores-location p-0" >
                            <div class="store-city d-flex col-auto align-content-center py-2">
                                <div class="col-auto">
                                    <h2 class="text-left p-2 m-0 <?php text_from_right() ?>"><?php echo strtoupper($city->city) ?></h2>
                                </div>
                                <div class="col-auto d-flex a-a-center">
                                    <?php if(in_array($city->city , $uae_cities)): ?>
                                    <img src="<?php echo base_url() ?>/assets/others/stores/uae_flag.png" alt="" style="max-height: 45px">
                                    <?php elseif(in_array($city->city , $sa_cities)): ?>
                                    <img src="<?php echo base_url() ?>/assets/others/stores/saudi_flag.png" alt="" style="max-height: 45px">
                                    <?php elseif(in_array($city->city , $qtr_cities)): ?>
                                    <img src="<?php echo base_url() ?>/assets/others/stores/qatar_flag.png" alt="" style="max-height: 45px">
                                    <?php elseif(in_array($city->city , $omn_cities)): ?>
                                    <img src="<?php echo base_url() ?>/assets/others/stores/oman_flag.png" alt="" style="max-height: 45px">
                                    <?php endif; ?>
                                </div>
                                <i class="fa-solid fa-caret-down"></i>
                            </div>
                        </div>

                        <div class="stores-rail">

                            <div class="stores_container j-c-center mx-0 <?php text_from_right() ?>">
                                <!-- Store in the city -->
                                <?php foreach($stores as $store): ?>
                                <div class="store p-0 flex-column m-4 a-a-center" data-id="<?php echo $store->id ?>">

                                    <div class="store-body d-flex flex-column a-a-center">

                                        <div class="store-header <?php if($store->status == 'Opening soon') echo 'locked' ?> d-flex j-c-center a-a-center" >
                                            <i class="fa-solid fa-location-dot"></i>
                                            <h3 class="my-0 mx-3"><?php lg_put_text($store->name , $store->arabic_name) ?></h3>
                                        </div>


                                        <div class="row pt-4 px-3 mt-4 store-detail">
                                            <?php if($store->status == 'Open'): ?>
                                            <div class="col-12 store-info">
                                                <h4><?php echo lg_get_text("lg_57")?>:</h4>
                                                <div class="mb-2">
                                                    <p class="m-0" dir="ltr">
                                                        <a href='Tel:+966126488850'><?php echo $store->phone ?></a>
                                                    </p>
                                                </div>
                                                <h4><?php echo lg_get_text("lg_13") ?>:</h4>
                                                <div class="mb-2">
                                                    <?php echo $store->address ?>
                                                </div>
                                            </div>
                                            <div class="col-12 store-timing">
                                                <h4><?php echo lg_get_text("lg_62")?>:</h4>
                                                <ul class="px-1">
                                                    <li><?php echo lg_get_text("lg_63").": ".(new \DateTime($store->weekdays_start , new \DateTimeZone(TIME_ZONE)))->format("h:i A")."-".(new \DateTime($store->weekdays_end , new \DateTimeZone(TIME_ZONE)))->format("h:i A") ?></li>
                                                    <li><?php echo lg_get_text("lg_64").": ".(new \DateTime($store->weekends_start , new \DateTimeZone(TIME_ZONE)))->format("h:i A")."-".(new \DateTime($store->weekends_end , new \DateTimeZone(TIME_ZONE)))->format("h:i A") ?></li>
                                                </ul>
                                            </div>
                                            <?php else: ?>
                                            
                                            <div class="col-12">
                                                <p class="open-soon"><?php echo lg_get_text("lg_325") ?></p>
                                            </div>
                                            
                                            <?php endif; ?>

                                        </div>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php endforeach; ?>

                </div>

                <!-- modal store preview -->
                <div class="modal fade" id="store-preview" tabindex="-1" aria-labelledby="store-preview" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered rounded">
                        <div class="modal-content" style="background-color: #262626;">

                            <div class="modal-header" style="border: none; color:white; background-color: #2e2e2e">
                                <h3 class="text-center"></h3>
                                <button type="button" class="close p-2" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">×</span></button>
                            </div>
                            <div class="modal-body" style="color: white" >
                            </div>
                        </div>
                    </div>
                </div>


        </div>
    </div>