<?php
    $session=session();
    $user_id = $session->get('userLoggedin');
    $userModel =  model("App\Models\UserModel");
    if($user_id){
        $sql="select * from users where user_id='".$user_id."'";
        $result=$userModel->customQuery($sql);
    }

?>


<style>
    .pc_gamer_query .pc_wallpaper{

        <?php if(true): ?>
        background: url("<?php echo base_url() ?>/assets/uploads/get_a_quote_page_banner.jpg");
        /* background: linear-gradient(to bottom,rgba(0, 0, 0, 0.678) 10%,#03468578 35%),url("<?php echo base_url() ?>/assets/uploads/get_a_quote_page_banner.jpg"); */
        <?php endif; ?>
        background-repeat: no-repeat;
        background-repeat: no-repeat;
        background-size: cover;
        background-position:center;
        background-blend-mode: multiply;    
        
    }

</style>

<div class="container-fluid col-12 my-5 pc_gamer_query justify-content-center d-flex" <?php content_from_right() ?>>
    <!-- <div class="container p-0"> -->
    <div class="container col-xl-11 row col-12 p-0 m-0 justify-content-center">

        <?php if(isset($errors["err_msg"]) && isset($errors["err_msg"])!=="") : ?>
        <div class="alert alert-warning m-0" role="alert">
            <strong>Warning!</strong> <?php  echo $errors["err_msg"];?>
        </div>
        <?php endif;?>

        <div class="row col-12 m-0 p-0 justify-content-center" style="position:relative">
            
            <div class="row px-sm-0 col-12 my-3 justify-content-center">
                <div class="row col-sm-12 col-lg-10 justify-content-center">
                    <h1 class="col-lg-10" style="text-align:center;font-size:1.8rem"><?php echo lg_get_text("lg_315") ?></h1>
                </div>
            </div>

            <div class="row col-12 justify-content-between align-content-center p-0 m-0">
                
                <div class="pc_wallpaper d-lg-flex d-none col-12 col-lg-6 j-c-end a-a-center" >
                </div>

                <?php if(!isset($status)){ ?>
                <div class="row rounded px-0 px-md-3 col-sm-12 col-lg-6 m-0 pc_gamer_query_form_card">
                    <form action="<?php echo base_url() ?>/get_a_quote/checkrequest" class="row p-0 m-0 col-12 px-0">
                        <!-- <div class="col-12">
                            <h2 class="text-center pt-3 m-0"><?php echo lg_put_text("Get a Quote" , "الحصول على عرض") ?></h2>
                        </div> -->

                        <div class="row col-12 m-0 mt-4 justify-content-center">
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-lg-8 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors['op_type'])) echo $errors["op_type"]; ?></p>
                                <select class="col-12 mx-2" name="op_type" id="op_type">
                                    <option selected value="2"><?php echo lg_get_text("lg_298") ?></option>
                                    <option value="1"><?php echo lg_get_text("lg_299") ?></option>
                                </select>
                            </div>

                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors['name'])) echo $errors["name"]; ?></p>
                                <input required class="col-12 mx-2" type="text" name="name" id="name" placeholder="<?php echo lg_get_text("lg_148") ?>" value="<?php if(isset($data["name"])) echo $data["name"]; else if(isset($result[0]->name)) echo $result[0]->name; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                                <input required class="col-12 mx-2" type="text" name="email" placeholder="<?php echo lg_get_text("lg_276") ?>" id="e-mail" value="<?php if(isset($data["email"])) echo $data["email"]; else if(isset($result[0]->name)) echo $result[0]->email; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                                <input required class="col-12 mx-2" type="tel" name="phone" placeholder="<?php echo lg_get_text("lg_274") ?>" id="Phone_number" value="<?php if(isset($data["phone"])) echo $data["phone"]; else if(isset($result[0]->name)) echo $result[0]->phone; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <select class="col-12 mx-2" name="country" id="country">
                                    <option value="UAE"><?php echo lg_get_text("lg_293") ?></option>
                                    <option value="SAOUDI ARABIA"><?php echo lg_get_text("lg_294") ?></option>
                                    <option value="QUATAR"><?php echo lg_get_text("lg_295") ?></option>
                                    <option value="BAHRAIN"><?php echo lg_get_text("lg_296") ?></option>
                                    <option value="OMAN"><?php echo lg_get_text("lg_297") ?></option>
                                </select>
                            </div>
                            

                        </div>

                        <hr class="col-10" style="background: rgba(255, 255, 255, 0.253); height: .5px">

                        <div class="row config_infos col-12 m-0">
                            <!-- Motherboard -->
                            <div class="form-group row my-3 mx-0 px-2 j-c-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <!-- <input  value="<?php if(isset($data["motherboard"])) echo $data["motherboard"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_300") ?>" name="motherboard" id="motherboard"> -->
                                <select class="col-12 mx-2" name="motherboard" id="motherboard">
                                    <option value="">Select Motherboard</option>
                                    <?php 
                                    $filter=[
                                        // motherboard-1673694842
                                        "categoryList" => ["motherboard-1673694842"],
                                        "sort" => "Newest", // Newest, Oldest, Highest, Lowest
                                    ];
                                    
                                    $motherboards = $GLOBALS["productModel"]->product_filter_query($filter);
                                    $motherboards = (!is_null($motherboards["product"])) ? $motherboards["product"] : [];
                                    foreach($motherboards as $motherboard):
                                    ?>
                                    <option value="<?php echo $motherboard->name ?>"><?php echo $motherboard->name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Processor -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["cpu"])) echo $data["cpu"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_301") ?>" name="cpu" id="cpu">
                            </div>

                            <!-- Graphic Card -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["gpu"])) echo $data["gpu"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_302") ?>" name="gpu" id="gpu">
                            </div> 

                            <!-- Storage Hard drive - SSD -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["ssd"])) echo $data["ssd"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_303") ?>" name="ssd" id="ssd">
                            </div>

                            <!-- Storage Hard drive - SATA -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["sata"])) echo $data["sata"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_304") ?>" name="sata" id="sata">
                            </div>

                            <!-- RAM -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["ram"])) echo $data["ram"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_305") ?>" name="ram" id="ram">
                            </div>

                            <!-- Chasis / Tower -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["chasis"])) echo $data["chasis"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_306") ?>" name="chasis" id="chasis">
                            </div>

                            <!-- Power supply -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["power"])) echo $data["power"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_307") ?>" name="power" id="power">
                            </div>

                            <!-- Case fans -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["case"])) echo $data["case"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_308") ?>" name="case" id="case">
                            </div>

                            <!-- Cooling system -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["cooling"])) echo $data["cooling"]; ?>" class="col-12 mx-2" type="text" placeholder="<?php echo lg_get_text("lg_309") ?>" name="cooling" id="cooling">
                            </div>

                            <!-- Operating System -->
                            <div class="form-group row my-3 mx-0 px-2 justify-content-center col-12 col-lg-6">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <select class="col-12 mx-2" type="text" name="os" id="os">
                                    <option value=""><?php echo lg_get_text("lg_310") ?></option>
                                    <option <?php if(isset($data["os"]) && $data["os"] == "Windows 10") echo "selected"; ?> value="Windows 10"><?php echo lg_get_text("lg_311") ?></option>
                                    <option <?php if(isset($data["os"]) && $data["os"] == "Windows 11") echo "selected"; ?> value="Windows 10"><?php echo lg_get_text("lg_312") ?></option>
                                </select>
                            </div>

                            <!-- Addistional accessories -->
                            <div class="form-group row my-4 mx-0 px-2 m-t-0 justify-content-center col-12">  
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <div class="col-lg-11 col-sm 8 mx-2 "></div>
                                <textarea  class="mx-2 mb-3 col-12 p-3" placeholder="<?php echo lg_get_text("lg_313") ?>" name="note" id="" cols="30" rows="10" ><?php if(isset($data["note"])) echo $data["note"]; ?></textarea>
                            </div>

                        </div>

                    </form>
                    <div class="form-group row my-3 mx-0 p-3 justify-content-center col-12">
                        <button class="btn-sm py-2 col-lg-3 col-sm-12 mx-2" type="submit"><?php echo lg_get_text("lg_314") ?></button>
                    </div>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
    </div>
</div>  