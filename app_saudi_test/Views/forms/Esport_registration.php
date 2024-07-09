<?php
    $userModel = model("App\Model\UserModel");
    $req = "select * from city where title <> 'All' and status='Active'";
    $res = $userModel->customQuery($req);
    $cities = [];
    if($res && sizeof($res) > 0 ) 
    $cities = $res;
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap');
    .register-form-bg{
        font-family: 'Raleway', sans-serif;
        background-image: url(<?php echo base_url()."/assets/others/punching_ball_bow_tournament.jpg" ?>),linear-gradient(to bottom , #34bd3c 10%, #34bd3c 65%);
        background-size: 100%;
        background-position: top;
        background-repeat: no-repeat;
    }

    .register-form-header{
        height: 450px
    }

    .register-form-description :is(p,h1){
        color: white;
    }
    .register-form-description p{
        font-size: 1.1rem;
    }
    .register-form-description h1{
        font-size: 1.5rem;
        font-weight: bold
    }

    form.register-form-preorder .form-group{
        position: relative;
    }

    form.register-form-preorder .form-group label{
        color: white
    }

    form.register-form-preorder .form-group .err-msg{
        color: red;
        margin: 0;
        position: absolute;
        right: 0;
        font-size: .9rem;
    }

    @media screen and (max-width: 750px) {
        .register-form-bg{
            background-size: 100%!important;
            background-image: url(<?php echo base_url()."/assets/others/punching_ball_bow_tournament_mobile.jpg" ?>),linear-gradient(to bottom , #34bd3c 10%, #34bd3c 65%);

        }

        .register-form-header{
            height: auto!important;
            min-height: 300px
        }
        .register-form-bg h1,.register-form-bg img{
            position:absolute;
            bottom:30px!important;
            left:50%;
            transform: translateX(-50%);
            max-width:85%;
            font-size: 1.6rem
        }

        form.register-form-preorder .form-group .err-msg{
            position: relative;
            text-align:left
        }
    }

    .register-form-bg h1,.register-form-bg img{
        position:absolute;
        bottom:70px;
        left:50%;
        transform: translateX(-50%);
        width:400px;
    }

    form.register-form-preorder input[type='text'],form.register-form-preorder input[type='tel'],form.register-form-preorder select , form.register-form-preorder input[type='date']{
        min-height: 50px;
    }
    
    form.register-form-preorder .form-group.store{
        display:none
    }



</style>

<div class="container-fluid">

    <!-- Header of the page -->
    <div class="container register-form-bg">
        <div class="row j-c-center a-a-center col-12 mx-0 px-0 register-form-header" >
            <!--<h1 class="text-center" style="">Meta Quest PRO</h1>-->
            <!-- <img style="" src="<?php echo base_url() ?>/assets/img/mqp_logo.png" alt=""> -->
        </div>
    </div>

    <!-- form of the page -->
    <?php if(!isset($success)): ?>
    <div class="container" style="background-color:#34bd3c">
        <div class="col-12 row j-c-center col-12 mb-5 mx-0 p-0">
            <div class="col-12 col-md-8 my-5 p-3 register-form-description" style="background-color: #1e9626">
                <?php if(isset($message)): ?>
                    <p><?php echo $message ?></p>
                <?php endif; ?>
                <h1 class="text-center">
                    Welcome to the Street Fighter 6 Ultimate Punch
                </h1>
                <p class="text-center">
                    Sigh up now to participate.
                </p>
            </div>
            
            <form action="<?php echo base_url() ?>/tournament/register" method="post" class="row j-c-center p-0 m-0 col-12 col-md-8 px-0 register-form-preorder <?php content_from_right() ?>">

                <div class="row px-0 col-12 m-0 my-0 j-c-center">
                    
                    <!-- First name -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['first_name'])) echo $errors["first_name"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label>
                        <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="first_name" id="first_name" placeholder="<?php echo lg_get_text("lg_148-1") ?>" value="<?php if(isset($data["first_name"])) echo $data["first_name"]; else if(isset($result[0]->name)) echo $result[0]->name; ?>">
                    </div>

                    <!-- Last name -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['last_name'])) echo $errors["last_name"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="last_name"><?php echo lg_get_text("lg_148-2") ?>*</label>
                        <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="last_name" id="last_name" placeholder="<?php echo lg_get_text("lg_148-2") ?>" value="<?php if(isset($data["last_name"])) echo $data["last_name"]; else if(isset($result[0]->name)) echo $result[0]->name; ?>">
                    </div>

                    <!-- Date of birth -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['date_birth'])) echo $errors["date_birth"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="date_birth"><?php echo lg_get_text("lg_318")?>*</label>
                        <input required class="form-control col-12 <?php text_from_right(true) ?>" type="date" name="date_birth" placeholder="<?php echo lg_get_text("lg_276") ?>" id="date" value="<?php if(isset($data["date_birth"])) echo $data["date_birth"]; else if(isset($result[0]->email)) echo $result[0]->email; ?>">
                    </div>
                    
                    <?php if(false): ?>
                    <!-- Address -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['street'])) echo $errors["street"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="street"><?php echo lg_get_text("lg_68") ?>*</label>
                        <input required class="form-control col-12 mb-2 <?php text_from_right(true) ?>" type="text" name="street" placeholder="<?php echo lg_get_text("lg_221") ?>" id="street" value="<?php if(isset($data["street"])) echo $data["street"]; else if(isset($result[0]->street)) echo $result[0]->street; ?>">
                        <input required class="form-control col-12 mb-2 <?php text_from_right(true) ?>" type="text" name="apartment" placeholder="<?php echo lg_get_text("lg_234") ?>" id="apartment" value="<?php if(isset($data["apartment"])) echo $data["apartment"]; else if(isset($result[0]->apartment)) echo $result[0]->apartment; ?>">
                        <select required class="form-control col-12 mb-2 <?php text_from_right(true) ?>" name="city" id="city">
                            <option value=""><?php echo lg_get_text("lg_222") ?></option>
                            <?php foreach( $cities as $city): ?>
                                <option value="<?php echo $city->title ?>" <?php if(isset($data["city"]) && $data["city"] == $city->title) echo "selected" ?>><?php echo lg_put_text($city->title , $city->arabic_title) ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>
                    <?php endif; ?>
                            
                    <!-- Email -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="email"><?php echo lg_get_text("lg_17") ?>*</label>
                        <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="email" placeholder="<?php echo lg_get_text("lg_276") ?>" id="e-mail" value="<?php if(isset($data["email"])) echo $data["email"]; else if(isset($result[0]->email)) echo $result[0]->email; ?>">
                    </div>

                    <!-- Phone number -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="phone"><?php echo lg_get_text("lg_274") ?>*</label>
                        <input required class="form-control col-12 <?php text_from_right(true) ?>" type="tel" name="phone" placeholder="<?php echo lg_get_text("lg_274") ?>: <?php echo PHONE_CODE ?>520000000" id="Phone_number" value="<?php if(isset($data["phone"])) echo $data["phone"]; else if(isset($result[0]->phone)) echo $result[0]->phone; ?>">
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="form-group row mt-0 mx-0 px-0 col-12">
                        
                        <div class="col-12">
                            <input  class="form-check-input" type="checkbox" name="term_cond" id="term_cond">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['term_cond'])) echo $errors["term_cond"]; ?></p>
                            <label class="form-check-label mb-3 px-0 <?php text_from_right(true) ?>" for="term_cond">
                                <?php echo lg_get_text("lg_147")." <a href='#' style='color: blue'>".lg_get_text("lg_05")."</a>" ?>
                            </label>
                        </div>

                    </div>

                </div>

                <div class="form-group row my-3 mx-0 px-0 j-c-center col-12">
                    <button class="btn btn-primary py-2 col-lg-3 col-sm-12 mx-2" type="submit"><?php echo lg_get_text("lg_84") ?></button>
                </div>

            </form>
        </div>
    </div>
    <?php else: ?>
        <div class="container py-4" style="background-color:#fdd916">

            <div class="col-12 row j-c-center p-0 m-0">
                <div class="col-12 col-md-8" style=" color: #5b3b02; text-align:center">
                    <p class="col-12 py-4 m-0 px-0" style="font-size: 1.5rem; line-height: 2rem;">
                        <?php echo($message) ?>
                    </p>
                    
                    <?php if($success): ?>
                    <div class="col-auto my-3">
                        <i class="fa-regular fa-hand-back-fist" style="font-size: 10.5rem"></i>
                    </div>
                    <?php else:?>
                    <div class="col-auto my-3">
                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 10.5rem"></i>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    <?php endif; ?>



</div>