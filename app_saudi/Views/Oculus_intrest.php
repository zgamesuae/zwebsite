<style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap');
    @font-face {
        font-family: 'rogfont';
        src: url('assets/fonts/rogfont.ttf') format('truetype');
    }
    .oculus-bg{
        font-family: 'Raleway', sans-serif;
        background-image: url(<?php echo base_url()."/assets/img/asus_rog_ally_registerintrest_cover.png" ?>),linear-gradient(to bottom , #cfb3de 10%, #ced1e5 65%);
        background-size: 100%;
        background-position: top;
        background-repeat: no-repeat;
    }

    .oculus-header{
        height: 450px
    }

    form.oculus-preorder .form-group{
        position: relative;
    }

    form.oculus-preorder .form-group .err-msg{
        color: red;
        margin: 0;
        position: absolute;
        right: 0;
        font-size: .9rem;
    }

    @media screen and (max-width: 750px) {
        .oculus-bg{
            background-size: 150%!important
        }

        .oculus-header{
            max-height: 250px
        }
        .oculus-bg h1,.oculus-bg img{
            position:absolute;
            bottom:30px!important;
            left:50%;
            transform: translateX(-50%);
            width:100%!important;
            font-size: 2.5rem!important
        }
    }

    .oculus-bg h1,.oculus-bg img{
        position:absolute;
        bottom:0px;
        left:50%;
        transform: translateX(-50%);
        width:auto;
        font-family: 'rogfont' , sans-serif;
        color: white;
        font-size: 4rem;
    }

    form.oculus-preorder input[type='text'],form.oculus-preorder input[type='tel'],form.oculus-preorder select{
        min-height: 50px;
    }
    
    form.oculus-preorder .form-group.store{
        display:none
    }
</style>

<div class="container-fluid">
    <div class="container oculus-bg">
        <div class="row j-c-center a-a-center col-12 mx-0 px-0 oculus-header" >
            <h1 class="text-center product_intrest_title" style="">ROG ALLY</h1>
            <!-- <img style="" src="<?php echo base_url() ?>/assets/img/mqp_logo.png" alt=""> -->
        </div>
    </div>
    <div class="container" style="background-color:#ced1e5">
        <div class="col-12 row j-c-center col-12 mb-5 mx-0">
            <div class="col-12 col-md-10 my-3 p-0 ">
                <p class="text-center">
                    Asus ROG Ally will be relesed shortly, currently the pre-orders are only accepted on intrest registration, to do so please fill up the form below. Be informed that the quantity is limited (First come first served).
                </p>
            </div>
            
            <form action="<?php echo base_url() ?>/Preorder_register_intrest/checkrequest" class="row j-c-center p-0 m-0 col-12 col-md-8 px-0 oculus-preorder">

                <div class="row px-0 col-12 m-0 my-0 j-c-center">
                    
                    <!-- Name -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg" style="color:red"><?php if(isset($errors['name'])) echo $errors["name"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0" for="name">Full name:</label>
                        <input required class="form-control col-12" type="text" name="name" id="name" placeholder="<?php echo lg_get_text("lg_148") ?>" value="<?php if(isset($data["name"])) echo $data["name"]; else if(isset($result[0]->name)) echo $result[0]->name; ?>">
                    </div>
                    
                    <!-- Email -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg" style="color:red"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0" for="email">Email address:</label>
                        <input required class="form-control col-12" type="text" name="email" placeholder="<?php echo lg_get_text("lg_276") ?>" id="e-mail" value="<?php if(isset($data["email"])) echo $data["email"]; else if(isset($result[0]->email)) echo $result[0]->email; ?>">
                    </div>

                    <!-- Phone number -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg" style="color:red"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0" for="phone">Phone number</label>
                        <input required class="form-control col-12" type="tel" name="phone" placeholder="<?php echo lg_get_text("lg_274") ?>: +971520000000" id="Phone_number" value="<?php if(isset($data["phone"])) echo $data["phone"]; else if(isset($result[0]->phone)) echo $result[0]->phone; ?>">
                    </div>

                    <!-- Bying option -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                        <p class="err-msg" style="color:red"><?php if(isset($errors['order-type'])) echo $errors["order-type"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0" for="order-type">Preferred buying option:</label>
                        <select class="form-control col-12 o_t" name="order-type" id="order-type">
                            <option value="online">Place order online</option>
                            <option value="store">Pickup from the store</option>
                        </select>
                    </div>
                    
                    <!-- Stores list -->
                    <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12 store">
                        <p style="color:red"><?php if(isset($errors['store'])) echo $errors["store"]; ?></p>
                        <label class="form-label col-12 mb-3 px-0" for="country">Select a store</label>
                        <!-- <select class="form-control col-12" name="store" id="country">
                            <option selected value="none"></option>
                            <option value="Dubai Mall store">Dubai Mall store (Dubai)</option>
                            <option value="Dubai Hills Mall store">Dubai Hills Mall store (Dubai)</option>
                            <option value="Al Warqa store">Al Warqa store (Dubai)</option>
                            <option value="City Center Al Zahia store">City Center Al Zahia store (Sharjah)</option>
                        </select> -->
                    </div>
                    

                </div>

                <div class="form-group row my-3 mx-0 px-0 j-c-center col-12">
                    <button class="btn btn-primary py-2 col-lg-3 col-sm-12 mx-2" type="submit"><?php echo lg_get_text("lg_314") ?></button>
                </div>

            </form>
        </div>
    </div>
</div>