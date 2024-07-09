<?php
    $i = ($destination == null || $destination == 'null') ? '' : '2'; 
    $guest = ($destination == null || $destination == 'null') ? '' : '<p class="col-auto text-center" style="color: #3e98fc; cursor: pointer" data-form="guest_checkout" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_218").'</p>'; 

    switch ($flag) {
        case 'login':
            # code...
            echo
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    '.lg_get_text("lg_144").' <br>'.lg_get_text("lg_145").'
                </p>
            </div>
                
            <div class="block2 m-0 p-0 row col-12">
                <form id="buyer_login_form'.$i.'" method="POST" class="col-12 px-0 px-lg-3" action="'.base_url()."/auth/LoginValidation".'" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="buyer_login_form_message'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input name="email" required class="form-control py-4" type="email" placeholder="'.lg_get_text("lg_17").'" autocomplete="0" >
                    </div>
                    <div class="col-12 my-4">
                        <div class="eye_password " data_val="text" style="top:13px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                            </svg>
                        </div>
                        <input name="password" required class="form-control py-4" type="password" placeholder="'.lg_get_text("lg_150").'" autocomplete="0" >
                    </div>
                    
                    <!-- Buttons -->
                    <div class="row j-c-center px-0 col-12 my-3 mx-0">
                        <div class="col-6">
                            <button class="btn purple col-12" style="border: none!important; background-color: #2259b3">'.lg_get_text("lg_83").'</button>
                            <div class="col-12 p-0 pt-3 pl-0">
                                <p href="" style="color:#3e98fc; font-size: 14px; cursor: pointer" data-form="reset_pwd" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_152").'</p>
                            </div>
                        </div>
                        
                    </div>
                
                </form>
                <div class="row p-0 col-12 justify-content-center align-items-center m-0">
                    <div class="row m-0 justify-content-center col-12">
                        <p class="m-0 mb-3"> '. lg_get_text("lg_334") .' </p>
                    </div>
                    <a href="#" class="mx-2 my-2 col-5 col-md-5 p-0" onclick="javascript:auth_popup(\'google\');">
                        <img src="'.base_url().'/assets/others/icons/btn_google_signin_dark_pressed_web@2x.png" class="col-12 p-0">
                    </a>
                    <a href="#" class="mx-2 my-2 col-5 col-md-5 p-0" onclick="javascript:auth_popup(\'Facebook\');">
                        <img src="'.base_url().'/assets/others/icons/btn_signin_facebook_blue.png" class="col-12 p-0">
                    </a>
                </div>
            </div>

                
            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <div class="row p-0 m-0 j-c-center text-center" style="font-size: 16px;">
                        <p class="col-auto text-center" style="color: #3e98fc; cursor: pointer" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_146").'</p>
                        '.$guest.'
                    </div>
                </div>
            </div>
            ';

           
            break;

        case 'register':
            # code...
            echo 
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    '.lg_get_text("lg_84").'
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12 px-0 px-lg-3" id="buyer_signup_form'.$i.'" method="POST" action="'.base_url().'/auth/registration" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="buyer_signup_message'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input name="name" required class="form-control py-4" type="text" placeholder="'.lg_get_text("lg_148").'" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <input name="email" required class="form-control py-4" type="text" placeholder="'.lg_get_text("lg_17").'" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <div class="row j-c-spacenbetween">
                            <div class="col-3 pr-0">
                                <input required name="country_code" class="form-control py-4" type="text" autocomplete="0" value="'.PHONE_CODE.'" disabled>
                            </div>
                            <div class="col-9">
                                <input required name="phone" class="form-control py-4" type="text" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" placeholder="'.lg_get_text("lg_149").'" autocomplete="0" >
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-4">
                        <div class="eye_password " data_val="text" style="top:13px;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                            </svg>
                        </div>
                        <input name="password" class="form-control py-4" type="password" placeholder="'.lg_get_text("lg_150").'" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <input name="confirm_pass" class="form-control py-4" type="password" placeholder="'.lg_get_text("lg_151").'" autocomplete="0" >
                    </div>

                    <div class="col-md-6 mt-2">
                        <input type="radio" hidden name="verify_method" checked value="email">
                    </div>

                    <div class="col-12 my-4 '.text_from_right(false).'">
                        <input class="py-4" type="checkbox" name="" required id="flexCheckDefault">
                        <label class="col-auto form-check-label" for="flexCheckDefault">'.lg_get_text("lg_147").' <a href="'.base_url().'/privacy-and-policy" style="color: #3e98fc">'.lg_get_text("lg_06").'</a></label>
                    </div>


                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn purple col-12" style="border: none!important; background-color: #2259b3">'.lg_get_text("lg_84").'</button>
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;">
                        <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_83").'</p>
                    </p>
                </div>
            </div>
            ';
            break;

        case 'login_otp':
            # code...
            echo 
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    '.lg_get_text("lg_144").' <br>'.lg_get_text("lg_154").'
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12 px-0 px-lg-3" id="loginWithOTP'.$i.'" method="POST" action="'.base_url().'/auth/loginWithOTP" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="loginWithOTPMssage'.$i.'"></div>
                    </div>

                    <div class="row col-12 mx-0 px-0">
                        <div class="col-3 my-4 pr-0">
                            <input required name="country_code" class="form-control py-4" type="text" placeholder="" autocomplete="0" value="'.PHONE_CODE.'" readonly="readonly" >
                        </div>
                        <div class="col-9 my-4">
                            <input class="form-control py-4" type="text" id="pn" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required placeholder="'.lg_get_text("lg_149").'" autocomplete="0" >
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row j-c-spacebetween col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-secondary col-12" style="border: none!important;">'.lg_get_text("lg_155").'</button> 
                        </div>
                        <div class="row col-6">
                            <div class="btn col-12" style="border: none!important; background-color: #2259b3" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_156").'</div> 
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;">
                        <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_146").'</p>
                    </p>
                </div>
            </div>
            ';
            break;

        case 'c_otp':
            # code...
            echo
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    '.lg_get_text("lg_144").' <br>'.lg_get_text("lg_154").'
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12 px-0 px-lg-0" id="verifyOTP'.$i.'" method="POST" action="'.base_url().'/auth/verifyOTP" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="loginWithOTPMssage'.$i.'"></div>
                    </div>
                    <input type="hidden" name="phone" id="vphone" required>
                    <div class="row j-c-center a-a-center">
                        <div class="col-7 my-4">
                            <input name="code" required class="form-control py-4" type="text" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" placeholder="'.lg_get_text("lg_157").'" autocomplete="0" >
                        </div>
                        <div class="col-2 my-4 pr-0">
                            <a href="" style="color:#3e98fc">'.lg_get_text("lg_158").'</a>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-secondary col-12" style="border: none!important;">'.lg_get_text("lg_159").'</button> 
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">
                        '.lg_get_text("lg_146").'
                    </p>
                </div>
            </div>
            ';
            break;

        case 'reset_pwd':
            # code...
            echo
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    '.lg_get_text("lg_152").'
                </p>
            </div>
            
            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12 px-0 px-lg-3" method="POST" id="ForgotForm" action="'.base_url().'/auth/forgotPassword" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="ForgotMessage'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input class="form-control py-4" name="email" required type="email" placeholder="'.lg_get_text("lg_160").'" autocomplete="0" >
                    </div>
            
                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn purple col-12" style="border: none!important; background-color: #2259b3">'.lg_get_text("lg_161").'</button>
                        </div>
                    </div>
            
                </form>
            </div>
            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size:16px; cursor:pointer; color:#3e98fc;" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">
                        '.lg_get_text("lg_162").'
                    </p>
                </div>
            </div>
            ';
            break;

        case 'guest_checkout':
            # code...
                echo
                '<div class="block1 m-0 p-0 row col-12">
                    <p class="text-center col-12 pb-3" style="font-size: 18px">
                        '.lg_get_text("lg_163").'
                    </p>
                </div>
                
                <div class="block2 m-0 p-0 row col-12">
                    <form id="buyer_signup_formGuest" class="col-12 px-0 px-lg-3" method="POST" action="'.base_url().'/auth/registrationGuest" autocomplete="off">
                        <div class="col-md-12 mt-2">
                            <div id="buyer_signup_messageGuest"></div>
                        </div>
                
                        <div class="col-12 my-4">
                            <input name="name" required type="text" class="form-control py-4" placeholder="'.lg_get_text("lg_148").'">
                        </div>
                
                        <div class="col-12 my-4">
                            <input name="email" required class="form-control py-4" type="email" placeholder="'.lg_get_text("lg_17").'" autocomplete="0" >
                        </div>
                
                        <div class="row col-12 mx-0 my-4 j-c-spacebetween">
                            <div class="col-2 pr-0">
                                <input required name="country_code" class="form-control py-4" type="text" placeholder="" autocomplete="0" value="'.PHONE_CODE.'" readonly="readonly" >
                            </div>
                            <div class="col-10">
                                <input class="form-control py-4" type="text" id="pn" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required placeholder="'.lg_get_text("lg_149").'" autocomplete="0" >
                            </div>
                        </div>
                
                
                        <!-- Buttons -->
                        <div class="row j-c-center col-12 my-3 mx-0">
                            <div class="row col-6">
                                <button class="btn purple col-12" style="border: none!important; background-color: #2259b3">'.lg_get_text("lg_164").'</button>
                            </div>
                        </div>
                
                    </form>
                </div>
                
                <div class="block3 m-0 p-0 row col-12">
                    <div class="col-12 pt-3">
                        <p class="text-center" style="font-size: 16px;">
                            <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">'.lg_get_text("lg_83").'</p>
                        </p>
                    </div>
                </div>';
            break;
        default:
            # code...
            echo '<p> '.lg_get_text("lg_165").' </p>';
            break;

    }

?>