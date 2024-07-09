<?php
    // $timezone = new \DateTimeZone("Asia/Dubai");
    // $start = (new \dateTime("30-05-2022 15:30:00",$timezone))->setTimestamp(strtotime("30-05-2022 15:30:00"));
    // $end = (new \dateTime("now",$timezone))->setTimestamp(strtotime("10-06-2022 12:00:00"));

    // $date = new \dateTime("now",$timezone);

    // var_dump($start->format("Y-m-d H:i:s"),$date->format("Y-m-d H:i:s"),$end->format("Y-m-d H:i:s"));
    // var_dump(($date>$start && $date<$end));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our locations</title>

    <style>
        .stores_container{
            background-color: #edededfd;
            height:auto;
        }

        .stores_container .store-city{
            position: absolute;
            height: auto;
            width: 250px;
            background-color: #2a2a2afd;
            color:rgb(243, 243, 243);
            top: -30px;
            left: 0;
            text-align: center;
        }

        .stores_container .store-city:after{
            content:"";
            height: 50%;
            width: calc(100% / 4);
            background-color: #2a2a2afd;
            position: absolute;
            right: -11%;
            bottom: 0px; 
            clip-path: polygon(0% 0%, 25% 0%, 100% 100%, 0% 100% );
        }

        .stores_container .stores-location{
            height:40px;
        }

        .store{
            position: relative;
            
            height: 350px; 
            max-height:400px;
            box-shadow: #00000040 1px 1px 15px;
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

        

    </style>
</head>
<body>
    <div class="container-fluid my-5">
        <div class="container px-0" style="height: auto">
                <!-- store container -->
                <div class="row col-12">
                    <h1 class="col-12" style="text-align: center;">Our store locations</h1>
                </div>
                <div class="row col-12 py-4 mx-0 my-4">
                    <div class="stores_container my-4 mx-0 p-0 row j-c-center col-12 ">
                        <div class="col-12 stores-location" style="position:relative">
                            <div class="store-city col-lg-2 col-sm-6">
                                <h2 class=" p-2">DUBAI</h2>
                            </div>
                        </div>
    
                        <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body d-flex flex-column a-a-center">
                                <div class="store-header d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <h3 class="my-0 mx-3">DUBAI MALL</h3>
                                </div>
                                <div class="row pt-4 px-3 mt-4">
                                    <div class="col-12 store-info">
                                        <h4>Tel:</h4>
                                        <p class="mb-2"><a href='Tel:+97144919968'>+971 44 919 968</a></p>
                                        <h4>Location:</h4>
                                        <p>2nd Floor</p>
                                    </div>
                                    <div class="col-12 store-timing">
                                        <h4>Timing:</h4>
                                        <ul class="pl-2">
                                            <li>Week days: 10 am to 11 pm</li>
                                            <li>Weekends: 10 am to 12 am</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body d-flex flex-column a-a-center">
                                <div class="store-header d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <h3 class="my-0 mx-3">DUBAI HILLS MALL</h3>
                                </div>
                                <div class="row pt-4 px-3 mt-4">
                                    <div class="col-12 store-info">
                                        <h4>Tel:</h4>
                                        <p class="mb-2"><a href='Tel:+97142571099'>+971 42 571 099</a></p>
                                        <h4>Address:</h4>
                                        <p>1st Floor</p>
                                    </div>
                                    <div class="col-12 store-timing">
                                        <h4>Timing:</h4>
                                        <ul class="pl-2">
                                            <li>Weekdays: 10 am to 10 pm</li>
                                            <li>Weekends: 10 am to 12 am</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body d-flex flex-column a-a-center">
                                <div class="store-header d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <h3 class="my-0 mx-3">AL WARQA</h3>
                                </div>
                                <div class="row pt-4 px-3 mt-4">
                                    <div class="col-12 store-info">
                                        <h4>Tel:</h4>
                                        <p class="mb-2"><a href='Tel:+97143282123'>+971 43 282 123</a></p>
                                        <h4>Address:</h4>
                                        <p>Al Warqa - Al Warqa 1</p>
                                    </div>
                                    <div class="col-12 store-timing">
                                        <h4>Timing:</h4>
                                        <ul class="pl-2">
                                            <li>Weekdays: 10 am to 10 pm</li>
                                            <li>Weekends: 10 am to 12 am</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <!-- <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body s-opening d-flex flex-column a-a-center">
                                <div class="store-header locked d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <h3 class="my-0 mx-3">AL WARQA</h3>
                                </div>
                                <div class="row pt-4 px-3 m-auto">
                                    <div class="row col-12 p-0 m-0">
                                        <p style="font-size: 25px; color: gray"><b>OPENING SOON</b></p>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>

                    <div class="stores_container my-4 mx-0 p-0 row j-c-center col-12 ">
                        <div class="col-12 stores-location" style="position:relative">
                            <div class="store-city col-lg-2 col-sm-6">
                                <h2 class=" p-2">SHARJAH</h2>
                            </div>
                        </div>
    
                        <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body d-flex flex-column a-a-center">
                                <div class="store-header d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <a href="https://goo.gl/maps/wfmfyetjjcfXgwWS9">
                                        <h3 class="my-0 mx-3">CITY CENTER AL ZAHIA</h3>
                                    </a>
                                </div>
                                <div class="row pt-4 px-3 mt-4">
                                    <div class="col-12 store-info">
                                        <h4>Tel:</h4>
                                        <p class="mb-2"><a href='Tel:+97165355527'>+971 65 355 527</a></p>
                                        <h4>Location:</h4>
                                        <p class="m-0"> Shop N° B093</p>
                                        <p> 2nd floor, Nearest Parking Gate A L2es</p>
                                    </div>
                                    <div class="col-12 store-timing">
                                        <h4>Timing:</h4>
                                        <ul class="pl-2">
                                            <li>Week days: 10 am to 11 pm</li>
                                            <li>Weekends: 10 am to 12 am</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="stores_container my-4 mx-0 p-0 row j-c-center col-12 ">
                        <div class="col-12 stores-location" style="position:relative">
                            <div class="store-city col-lg-2 col-sm-6">
                                <h2 class=" p-2">JEDDAH</h2>
                            </div>
                        </div>
    
                        <div class="store p-0 flex-column col-lg-3 col-sm-12 col-md-4  m-4 d-flex a-a-center">
                            
                            <div class="store-body d-flex flex-column a-a-center">
                                <div class="store-header d-flex j-c-center a-a-center" >
                                    <i class="fa-solid fa-location-dot"></i>
                                    <h3 class="my-0 mx-3">SOUK AL SHATIE</h3>
                                </div>
                                <div class="row pt-4 px-3 mt-4">
                                    <div class="col-12 store-info">
                                        <h4>Tel:</h4>
                                        <p class="mb-2"><a href='Tel:+966126488850'>+966 126 488 850</a></p>
                                        <h4>Location:</h4>
                                        <p>Al Zahra Street, Ahmad al Attas near Shelves, Jeddah 23425</p>
                                    </div>
                                    <div class="col-12 store-timing">
                                        <h4>Timing:</h4>
                                        <ul class="pl-2">
                                            <li>Week days: 10 am to 11 pm</li>
                                            <li>Weekends: 10 am to 12 am</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
    </div>
</body>
</html>