<?php 
    $storeModel = model("App\Models\Storecustomers");
?>
<div class="container-fluid">

    <div class="container" <?php content_from_right() ?>>

        <!-- Self Call -->
        <div class="row justify-content-center">
            <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                <!-- <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['country'])) echo $errors["country"]; ?></p> -->
                <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="country"><?php echo lg_put_text("Select country" , "اختر البلد") ?></label>
                <select required class="form-control col-12 mb-2 <?php text_from_right(true) ?>" name="stores" id="ais-countries">
                    <option value="">Select country</option>
                        <option <?php if($country == "uae") echo "selected" ?> value="uae">United Arabe Emirates</option>
                        <option <?php if($country == "ksa") echo "selected" ?> value="ksa">Saudi Arabia</option>
                        <option <?php if($country == "qat") echo "selected" ?> value="qat">Qatar</option>
                        <option <?php if($country == "oma") echo "selected" ?> value="oma">Oman</option>
                </select>
            </div>

            <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="country"><?php echo lg_put_text("Select store" , "اختر متجرا") ?></label>
                <select required class="form-control col-12 mb-2 <?php text_from_right(true) ?>" name="stores" id="ais-stores">
                    <option value="">Select Store</option>
                    <?php 
                    foreach($cities as $city): 
                        $stores = $storeModel->get_city_stores($city->city);
                    ?>
                    <optgroup label="<?php echo $city->city ?>">
                        <?php foreach($stores as $store): ?>
                        <option value="<?php echo $store->id ?>">
                            <?php echo lg_put_text($store->name , $store->arabic_name) ?>
                        </option>
                        <?php endforeach; ?>
                    </optgroup>
                    <?php endforeach; ?>
                        
                </select>
            </div>

            <div class="col-12 ws-store-info-area row px-0">
                
            </div>
        </div>
        <!-- Self Call -->
                        
        <?php if(false): ?>
        <!-- Request Call -->
        <div class="row">
            <form action="" class="col-12">
                <!-- Email -->
                <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                    <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                    <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="email"><?php echo lg_get_text("lg_17") ?>*</label>
                    <input required class="form-control col-12 <?php text_from_right(true) ?>" type="text" name="email" placeholder="<?php echo lg_get_text("lg_276") ?>" id="e-mail" value="<?php if(isset($data["email"])) echo $data["email"]; else if(isset($result[0]->email)) echo $result[0]->email; ?>">
                </div>
                <!-- Email -->

                <!-- Phone number -->
                <div class="form-group row mt-0 mx-0 px-0 j-c-center col-12">
                    <p class="err-msg col-12 col-md-auto p-0" style="color:red"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                    <label class="form-label col-12 mb-3 px-0 <?php text_from_right(true) ?>" for="phone"><?php echo lg_get_text("lg_274") ?>*</label>
                    <input required class="form-control col-12 <?php text_from_right(true) ?>" type="tel" name="phone" placeholder="<?php echo lg_get_text("lg_274") ?>: <?php echo PHONE_CODE ?>520000000" id="Phone_number" value="<?php if(isset($data["phone"])) echo $data["phone"]; else if(isset($result[0]->phone)) echo $result[0]->phone; ?>">
                </div>
                <!-- Phone number -->
            </form>
        </div>
        <!-- Request Call -->
        <?php endif; ?>

    </div>
</div>