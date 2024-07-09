<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/uae/bootstrap.min.css">
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>KGaming Review</title>
</head>
<body>
    


<style>
    body{
        margin: 0px;
    }

    body *{
        box-sizing: border-box;
        color: rgb(0, 0, 0);
    }

    body h1{
        font-size: 35px;
    }
    body h1{
        font-size: 20px;
    }

    body :is(button){
        background: orange!important;
        border: none;
        color: white!important;
        border-radius: 5px;
    }
    body :is(button):hover{
        background: rgb(221, 144, 2)!important;
    }

    .main-content{
        min-height: 100vh;
        background-color: #27242b
    }

    .ws-review-card{
        max-height: 100%;
        background-color: white;
        /* max-width: 500px; */
        border-radius: 10px;
        position: relative;
    }

    .ws-review-card .ws-product-image img{
        width: 100%;
    }
    .ws-review-card .ws-product-image{
        width: 250px;
        overflow: hidden;
        border: solid rgba(0, 0, 0, 0.116) 2px;
    }


    .ws-review-card .ws-product-description .ws-product-infos{
        font-size: .8rem;
    }

    /* Error msg */
    .err-msg{
        font-size: .8rem;
        margin: 0 0px 5px
    }
    /* Error msg */
</style>

<!-- Review Star Style -->
 <style>
    .reviews{
        height: auto;
        max-height: 600px;
        background-color: rgb(250, 250, 250);
        overflow-y: scroll;
    }

    .reviews .review-element{
        background-color: rgb(236, 236, 236);
        height: auto;
        border-radius: 10px;

    }

    .reviews .review-element .review-header{
        min-height: 90px;
        height:auto;
    }

    .review-header .review-date{
        /* position : absolute; */
        /* top: 0px; */
        /* right: 0px; */
        color: rgb(94, 94, 94);
        font-size: 13px
    }
    .review-header .review-date span{
        margin-left: auto;

    }

    .reviews .review-element .review-content{
        border-radius: 10px;
        background:rgb(212, 212, 212);
        color: #404040;
    }

    .review-header .rating{
        min-height: 20px;
        height: auto;
        max-width: 250px;
        /* background-color: red; */
    }

    .rating .star{
        background: url("<?php echo base_url() ?>/assets/rating_stars.svg") no-repeat 0 0;
        background-size:contain;
        background-position: center;
        height:55px;
        width: 65px;
        cursor: pointer;
    }

    .rating .star-filled{
        background-image: url("<?php echo base_url() ?>/assets/rating_stars_filled.svg");
    }

    .rating .star-filled-fixed{
        background-image: url("<?php echo base_url() ?>/assets/rating_stars_filled.svg");
    }
 </style>
<!-- Review Star Style -->



<div class="container-fluid main-content align-content-center">
    <div class="row justify-content-center p-2 p-xl-5">
        <div class="col-xl-6 ws-review-card px-2 py-4 row justify-content-center text-center">

            <?php if(isset($product) && !empty($product)): ?>
            <!-- Product Information -->
            <div class="col-xl-10 my-4 d-flex flex-row flex-wrap align-items-start justify-content-between ws-product-description text-left">
                <div class="ws-product-image col-12 col-xl-5">
                    <img src="<?php echo "https://zgames.ae/assets/uploads/" . $image ?>" alt="">
                </div>
                <div class="ws-product-title py-2 col-xl-6 mx-0 mx-xl-2">
                    <h1 class="pb-4"><?php echo $product->name ?></h1>
                    <div class="row text-left ws-product-infos mb-3">
                        <div class="col-auto">
                            <span>Price:</span><br>
                            <span>Barcode:</span><br>
                            <span>Brand:</span><br>
                            <span>Type:</span><br>
                            <span>Page Link:</span><br>
                        </div>
                        <div class="col-6">
                            <span><b><?php echo $product->price ?> AED</b></span><br>
                            <span><b><?php echo $product->sku ?></b></span><br>
                            <span><b><?php echo $product->brand ?></b></span><br>
                            <span><b><?php echo $product->type ?></b></span><br>
                            <span><b><a href="<?php echo $product->url ?>">Click Here</a></b></span><br>
                        </div>
                    </div>
                    <div class="col-12 row justify-content-start align-content-center mb-3">
                        <div class="rating <?php if(!isset($data["success"])) echo 'rate-action' ?> d-flex flex-row col-xl-10 m-0 align-items-center justify-content-start p-0">
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 1)  echo "star-filled" ?> p-0 col-2" data-score="1"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 2)  echo "star-filled" ?> p-0 col-2" data-score="2"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 3)  echo "star-filled" ?> p-0 col-2" data-score="3"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 4)  echo "star-filled" ?> p-0 col-2" data-score="4"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 5)  echo "star-filled" ?> p-0 col-2" data-score="5"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>

            <div class="col-xl-10 my-4 d-flex flex-row flex-wrap align-items-start justify-content-center ws-product-description text-left">
                <div class="ws-product-image col-12 col-xl-5">
                    <img src="https://zgames.ae/assets/others/kgaming-logo.svg" alt="">
                </div>
                
            </div>
                
            <?php endif; ?>


            <?php if(!isset($data["success"])): ?>
            <!-- Decription -->
            <div class="col-xl-10 my-4 text-left">
               
                <span>We Value Your Feedback!</span>
                <p>Thank you for choosing us. Your opinion matters to us and helps other customers make informed decisions. Please take a moment to share your experience with our product. Whether you loved it or think there's room for improvement, we want to hear from you!</p>
                <b>Your review could cover:</b>
                <ul>
                    <li>What you liked or disliked about the product</li>
                    <li>How the product met or exceeded your expectations</li>
                    <li>Any tips or suggestions for other users</li>
                    <li>Overall satisfaction with your purchase</li>                    
                </ul>
                <p>We appreciate your time and insights. Your feedback helps us continuously improve our products and services.</p>
                <p>Leave your review below:</p>

            </div>

            <form action="<?php echo base_url() ?>/kgaming/review/submit" method="post" class="col-xl-10 px-0">
                <!-- <input hidden type="text" name="product" value="<?php echo $product->product_id ?>"> -->
                <input hidden type="number" name="rating" value="">

                <!-- Order Information -->
                <div class="col-12 mb-4 text-left px-0">
                    <div class="col-12">
                        <div class="col-auto p-0 mb-3">
                            <h2 style="font-size: 20px;">Order Information</h2>
                        </div>
                        <!-- Order Number -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['order_number'])) echo $errors["order_number"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="order_number"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="order_number" id="order_number" placeholder="Order Number" value="<?php if(isset($data["order_number"])) echo $data["order_number"];?>">
                        </div>
                        <!-- Store -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['store'])) echo $errors["store"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <select required class="form-control col-12" name="store" id="store">
                                <option value="Online Store">Online Store</option>
                                <?php foreach($cities as $city): ?>
                                    <optgroup label="<?php echo $city->city ?>">
                                    <?php 
                                    $stores = $storeModel->get_city_stores($city->city);
                                    foreach($stores as $store): 
                                    ?>
                                        <option value="<?php echo $store->name ?>"><?php echo $store->name ?></option>
                                    <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Product Barcode -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['barcode'])) echo $errors["barcode"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="barcode"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="barcode" id="barcode" placeholder="Product Barcode" value="<?php if(isset($data["barcode"])) echo $data["barcode"];?>">
                        </div>
                        <!-- Product Name -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['product_name'])) echo $errors["product_name"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="product_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="product_name" id="product_name" placeholder="Product Name" value="<?php if(isset($data["product_name"])) echo $data["product_name"]; ?>">
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="col-12 mb-4 text-left px-0">
                    <div class="col-12">
                        <div class="col-auto p-0 mb-3">
                            <h2 style="font-size: 20px;">Personal Information</h2>
                        </div>
                        <!-- First name -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['first_name'])) echo $errors["first_name"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="first_name" id="first_name" placeholder="First Name" value="<?php if(isset($data["first_name"])) echo $data["first_name"];?>">
                        </div>
                        <!-- Last name -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['last_name'])) echo $errors["last_name"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="last_name" id="last_name" placeholder="Last Name" value="<?php if(isset($data["last_name"])) echo $data["last_name"];?>">
                        </div>
                        <!-- Email ID -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="email" id="email" placeholder="Email ID" value="<?php if(isset($data["email"])) echo $data["email"];?>">
                        </div>
                        <!-- Phone Number -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="first_name"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="phone" id="phone" placeholder="Phone Number: +971 525269188" value="<?php if(isset($data["phone"])) echo $data["phone"];?>">
                        </div>
                    </div>

                </div>

                <!-- Remarks & rating -->
                <div class="col-12 mb-4 text-left px-0">
                    <div class="col-12 d-flex flex-row flex-wrap justify-content-start align-content-center mb-4">
                        <div class="col-12 p-0">
                            <h2 style="font-size: 20px;">Rating</h2>
                        </div>
                        <div class="rating <?php if(!isset($data["success"])) echo 'rate-action' ?> d-flex flex-row col-9 col-xl-4 m-0 align-items-center justify-content-start p-0">
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 1)  echo "star-filled" ?> p-0 col-2" data-score="1"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 2)  echo "star-filled" ?> p-0 col-2" data-score="2"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 3)  echo "star-filled" ?> p-0 col-2" data-score="3"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 4)  echo "star-filled" ?> p-0 col-2" data-score="4"></div>
                            <div class="star <?php if(isset($data["rating"]) && $data["rating"] >= 5)  echo "star-filled" ?> p-0 col-2" data-score="5"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="col-auto p-0 mb-3">
                            <h2 style="font-size: 20px;">Details</h2>
                        </div>
                        <!-- Remarks -->
                        <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                            <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['remark'])) echo $errors["remark"]; ?></p>
                            <!-- <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="order_number"><?php echo lg_get_text("lg_148-1") ?>*</label> -->
                            <textarea required class="col-12 p-3" name="remark" id="remark" rows="10" placeholder="Tell us More about your experience.." ><?php if(isset($data['remark'])) echo $data['remark'];?></textarea>
                        </div>


                    </div>

                </div>

                <div class="col-12 my-4">
                    <button class="p-3">Submit</button>
                </div>

            </form>
            <?php elseif($data["success"]): ?>
            <!-- Thank you Message -->
            <div class="col-xl-10 my-4">
                <p class="text-center">
                    <b>Thank You for Your Feedback!</b> <br><br>
                    We appreciate you taking the time to share your thoughts about <b><?php echo $product->name ?></b>. Your review has been successfully submitted and will be reviewed by our team shortly.
                </p>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>/assets/js/rating.js"></script>
<script>
    $(".rating.rate-action .star").click(function(){

        rating= $("form input[name='rating']")
        rating.val(($(".star").index($(this))+1))

    })
</script>

</body>
</html>

