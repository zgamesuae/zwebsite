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
   
</style>

<div class="container-fluid col-12 my-5 pc_gamer_query">
    <!-- <div class="container p-0"> -->
    <div class="row col-12 p-0 m-0">
        <div class="row col-12 m-0 p-0 j-c-center" style="position:relative">
            
            <div class="row px-sm-0 col-sm-12 col-md-12 col-lg-10 my-3 j-c-center">
                <div class="row col-sm-12 col-lg-10 j-c-center">
                    <h1 class="col-lg-10" style="text-align:center;font-size:1.8rem">Customize your PC Gamer</h1>
                </div>
            </div>

            <div class="row col-lg-11 col-sm-12 j-c-spacebetween p-0 m-0 bg-black">

                <div class="pc_wallpaper d-lg-flex d-none col-5 j-c-end a-a-center" >
                    <h3>GET <br> A QUOTE <br> NOW!</h3>
                </div>

                <?php if(!isset($status)){ ?>
                <div class="row rounded px-sm-0 col-sm-12 col-md-6 col-lg-6 m-0 pc_gamer_query_form_card">

                    <form action="<?php echo base_url() ?>/pcgamer/get_a_quote/check_request" class="row p-0 m-0 col-12 px-0">

                        <div class="row col-12 m-0 my-4 j-c-spacebetween">

                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors['name'])) echo $errors["name"]; ?></p>
                                <input required class="col-lg-11 col-sm-12 mx-2" type="text" name="name" id="name" placeholder="Name" value="<?php if(isset($data["name"])) echo $data["name"]; else if(isset($result[0]->name)) echo $result[0]->name; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors['email'])) echo $errors["email"]; ?></p>
                                <input required class="col-lg-11 col-sm-12 mx-2" type="text" name="email" placeholder="E-mail" id="e-mail" value="<?php if(isset($data["email"])) echo $data["email"]; else if(isset($result[0]->name)) echo $result[0]->email; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors['phone'])) echo $errors["phone"]; ?></p>
                                <input required class="col-lg-11 col-sm-12 mx-2" type="tel" name="phone" placeholder="Phone number" id="Phone_number" value="<?php if(isset($data["phone"])) echo $data["phone"]; else if(isset($result[0]->name)) echo $result[0]->phone; ?>">
                            </div>

                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <select class="col-lg-11 col-sm-12 mx-2" name="country" id="country">
                                    <option value="UAE">United Arabe Emirates</option>
                                    <option value="SAOUDI ARABIA">Saoudi Arabia</option>
                                    <option value="QUATAR">Qatar</option>
                                    <option value="BAHRAIN">Bahrain</option>
                                    <option value="OMAN">Oman</option>
                                </select>
                            </div>
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors['op_type'])) echo $errors["op_type"]; ?></p>
                                <select class="col-lg-11 col-sm-12 mx-2" name="op_type" id="op_type">
                                    <option value="2">Send customized configuration details</option>
                                    <option value="1">Get called by our specialist within 24h</option>
                                </select>
                            </div>

                        </div>

                        <div class="row config_infos col-12 m-0">
                            <!-- Motherboard -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["motherboard"])) echo $data["motherboard"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Motherboard" name="motherboard" id="motherboard">
                            </div>

                            <!-- Processor -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["cpu"])) echo $data["cpu"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Processor" name="cpu" id="cpu">
                            </div>

                            <!-- Graphic Card -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["gpu"])) echo $data["gpu"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Graphic card" name="gpu" id="gpu">
                            </div> 

                            <!-- Storage Hard drive - SSD -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["ssd"])) echo $data["ssd"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="HardDrive - SSD" name="ssd" id="ssd">
                            </div>

                            <!-- Storage Hard drive - SATA -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["sata"])) echo $data["sata"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="HardDrive - SATA" name="sata" id="sata">
                            </div>

                            <!-- RAM -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["ram"])) echo $data["ram"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Memory module - RAM" name="ram" id="ram">
                            </div>

                            <!-- Chasis / Tower -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["chasis"])) echo $data["chasis"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Chasis / Tower" name="chasis" id="chasis">
                            </div>

                            <!-- Power supply -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["power"])) echo $data["power"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Power supply" name="power" id="power">
                            </div>

                            <!-- Case fans -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["case"])) echo $data["case"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Case fans" name="case" id="case">
                            </div>

                            <!-- Cooling system -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["cooling"])) echo $data["cooling"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Cooling system" name="cooling" id="cooling">
                            </div>

                            <!-- Operating System -->
                            <div class="form-group row my-3 mx-0 px-0 j-c-center col-lg-6 col-sm-12">
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <input  value="<?php if(isset($data["os"])) echo $data["os"]; ?>" class="col-lg-11 col-sm-12 mx-2" type="text" placeholder="Operating system" name="os" id="os">
                            </div>

                            <!-- Addistional accessories -->
                            <div class="form-group row my-3 mx-0 px-0 m-t-0 j-c-center col-12">  
                                <p class="form_error_msg"><?php if(isset($errors[''])) echo $errors[""]; ?></p>
                                <div class="col-lg-11 col-sm 8 mx-2 "></div>
                                <textarea  class="col-lg-11 mx-2 col-sm-12 col-sm-12" placeholder="Additional accessories" name="note" id="" cols="30" rows="10" ><?php if(isset($data["note"])) echo $data["note"]; ?></textarea>
                            </div>

                        </div>
                        
                        <div class="form-group row my-3 mx-0 px-0 j-c-center col-12">
                            <button class="btn-sm py-2 col-lg-3 col-sm-12 mx-2" type="submit">Send</button>
                        </div>




                    </form>
                </div>
                <?php 
                }
                ?>
            </div>
        </div>
    </div>
</div>  