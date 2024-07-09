<?php
$userModel = model('App\Models\UserModel', false);
$systemModel = model('App\Models\SystemModel');
$settings = $systemModel->get_website_settings();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings->favicon;?>" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>ZAMZAM GAMES Maintenance page</title>

    

    <style>
        body{
            margin:0;
            padding:0;
            background-color: #ffffff;
        }
        body *{
            box-sizing:border-box
        }

        a{
            text-decoration: none;
            color: inherit
        }
        section{
            height: 100vh;
            width:100vw;
            position:relative;
            display:flex;
            flex-direction:column;
            align-items: center
        }

        .container{
            height: auto;
            width: 50%;
            background: #1c549c;
            margin:auto;
            display:flex;
            flex-direction:row;
            justify-content:center;
            flex-wrap:wrap;
            align-items:flex-start;
            border-radius: 15px;
            padding: 10px;
            color: white
        }

        
        img.logo {
            height: 175px;
            margin: 10px auto
        }

        h1{
            text-align:center;
            font-size: 3rem;
            width:100%;
        }

        .container > p{
            font-size: 1.4rem;
            width: 80%;
            text-align:center;
            line-height: 35px;
        }

        .social{
            /* background: lightgray; */
            display:flex;
            flex-direction: row;
            align-items:center;
            justify-content:center;
            flex-wrap:wrap;
            /* width:100%; */
            height: auto;
            padding: 8px;
            margin: 10px 0
        }

        .social i{
            font-size: 1.7rem;
            margin: 0 35px
        }

        .contact{
            width:100%;
            height:auto;
            display:flex;
            flex-direction: row;
            justify-content: center;
            align-items:center;
            flex-wrap:wrap;
            margin: 10px 0
        }

        .contact > div{
            width: 45%;
            display:flex;
            flex-direction: row;
            justify-content: center;
            align-items:center;
            min-width:350px; 


        }

        .contact *{
            margin: 0 10px;
            width:auto;
            display:inline
        }
        .contact i,.contact p{
            font-size: 20px;
        }


        @media screen and (max-width: 750px){
            .container{
                width: 100%!important
            }

            .container > p{
                width: 100%!important;
            }

        }



        
    </style>
</head>
<body>
        <section>
            
            <div class="container">
                <img class="logo" src="<?php echo base_url();?>/assets/uploads/<?php echo @$settings->logo;?>" alt="">
                <h1>COMING SOON!</h1>
                <!-- <p>Sorry for the inconvenience but we're performing some maintenance at the moment. If you need to you can always Contact us, otherwise we'll be back online shortly!</p> -->
                <div class="contact">
                    <div>
                        <i class="fa-solid fa-phone"></i>
                        <p><?php echo $settings->phone ?></p>
                    </div>
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <p><?php echo $settings->email ?></p>
                    </div>
                </div>

                <div class="social row justify-content-around">
                    <a href="<?php echo $settings->facebook ?>"><i class="fa-brands fa-facebook"></i></a>
                    <a href="<?php echo $settings->instagram ?>"><i class="fa-brands fa-instagram"></i></a>
                    <a href="<?php echo $settings->tiktok ?>"><i class="fa-brands fa-twitter"></i></a>
                </div>

                
            </div>
        </section>
</body>
</html>