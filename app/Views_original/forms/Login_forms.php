<?php
    $i = ($destination == null || $destination == 'null') ? '' : '2'; 
    $guest = ($destination == null || $destination == 'null') ? '' : '<p class="col-auto text-center" style="color: #3e98fc; cursor: pointer" data-form="guest_checkout" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">checkout as Guest</p>'; 

    switch ($flag) {
        case 'login':
            # code...
            echo
            '<div class="block1 m-0 p-0 row col-12">
                <p class="text-center col-12 pb-3" style="font-size: 18px">
                    Login to your account <br>using your E-mail ID
                </p>
            </div>
                
            <div class="block2 m-0 p-0 row col-12">
                <form id="buyer_login_form'.$i.'" method="POST" class="col-12" action="'.base_url()."/auth/LoginValidation".'" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="buyer_login_form_message'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input name="email" required class="form-control py-4" type="email" placeholder="Email ID" autocomplete="0" >
                    </div>
                    <div class="col-12 my-4">
                        <div class="eye_password" data_val="text" style="top:13px; right:23px">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                            </svg>
                        </div>
                        <input name="password" required class="form-control py-4" type="password" placeholder="Password" autocomplete="0" >
                    </div>
                    
                    <!-- Buttons -->
                    <div class="row j-c-spacebetween  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-primary purple col-12" style="border: none!important">Login</button>
                            <div class="col-12 p-0 pt-3 pl-0">
                                <p href="" style="color:#3e98fc; font-size: 14px; cursor: pointer" data-form="reset_pwd" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Forgot your password?</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="btn btn-secondary col-12" style="border: none!important;" data-form="login_otp" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Login with OTP</div> 
                        </div>
                    </div>
                
                </form>
            </div>
                
            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <div class="row p-0 m-0 j-c-center text-center" style="font-size: 16px;">
                        <p class="col-auto text-center" style="color: #3e98fc; cursor: pointer" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Create new account</p>
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
                    Register
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12" id="buyer_signup_form'.$i.'" method="POST" action="'.base_url().'/auth/registration" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="buyer_signup_message'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input name="name" required class="form-control py-4" type="text" placeholder="Name" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <input name="email" required class="form-control py-4" type="text" placeholder="Email address" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <div class="row j-c-spacenbetween">
                            <div class="col-3 pr-0">
                                <input required name="country_code" class="form-control py-4" type="text" autocomplete="0" value="+971" disabled>
                            </div>
                            <div class="col-9">
                                <input required name="phone" class="form-control py-4" type="text" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" placeholder="Phone number without country code" autocomplete="0" >
                            </div>
                        </div>
                    </div>

                    <div class="col-12 my-4">
                        <div class="eye_password" data_val="text" style="top:13px; right:23px">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z"></path>
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path>
                            </svg>
                        </div>
                        <input name="password" class="form-control py-4" type="password" placeholder="Password" autocomplete="0" >
                    </div>

                    <div class="col-12 my-4">
                        <input name="confirm_pass" class="form-control py-4" type="password" placeholder="Confirm password" autocomplete="0" >
                    </div>

                    <div class="col-md-6 mt-2">
                        <input type="radio" hidden name="verify_method" checked value="email">
                    </div>

                    <div class="col-12 my-4">
                        <input class="py-4" type="checkbox" name="" required id="flexCheckDefault">
                        <label class="col-auto form-check-label" for="flexCheckDefault">I have read and agree to the <a href="'.base_url().'/privacy-and-policy" style="color: #3e98fc">Privacy policy</a></label>
                    </div>


                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-primary purple col-12" style="border: none!important">Register</button>
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;">
                        <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Login</p>
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
                    Login to your account <br>using your Phone number
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12" id="loginWithOTP'.$i.'" method="POST" action="'.base_url().'/auth/loginWithOTP" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="loginWithOTPMssage'.$i.'"></div>
                    </div>

                    <div class="row col-12 mx-0">
                        <div class="col-2 my-4 pr-0">
                            <input required name="country_code" class="form-control py-4" type="text" placeholder="" autocomplete="0" value="+971" readonly="readonly" >
                        </div>
                        <div class="col-10 my-4">
                            <input class="form-control py-4" type="text" id="pn" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required placeholder="Phone number without country code" autocomplete="0" >
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row j-c-spacebetween col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-secondary col-12" style="border: none!important;">Send OTP</button> 
                        </div>
                        <div class="row col-6">
                            <div class="btn btn-primary col-12" style="border: none!important;" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Login with Email</div> 
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;">
                        <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Create new account</p>
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
                    Login to your account <br>using your Phone number
                </p>
            </div>

            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12" id="verifyOTP'.$i.'" method="POST" action="'.base_url().'/auth/verifyOTP" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="loginWithOTPMssage'.$i.'"></div>
                    </div>
                    <input type="hidden" name="phone" id="vphone" required>
                    <div class="row j-c-center a-a-center">
                        <div class="col-7 my-4">
                            <input name="code" required class="form-control py-4" type="text" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" placeholder="Enter the digits" autocomplete="0" >
                        </div>
                        <div class="col-2 my-4 pr-0">
                            <a href="" style="color:#3e98fc">Resend</a>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-secondary col-12" style="border: none!important;">Confirm OTP</button> 
                        </div>

                    </div>

                </form>
            </div>

            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size: 16px;" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">
                        Create new account
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
                    Forgot your password?
                </p>
            </div>
            
            <div class="block2 m-0 p-0 row col-12">
                <form class="col-12" method="POST" id="ForgotForm" action="'.base_url().'/auth/forgotPassword" autocomplete="off">
                    <div class="col-md-12 mt-2">
                        <div id="ForgotMessage'.$i.'"></div>
                    </div>
                    <div class="col-12 my-4">
                        <input class="form-control py-4" name="email" required type="email" placeholder="Enter the registred E-mail ID" autocomplete="0" >
                    </div>
            
                    <!-- Buttons -->
                    <div class="row j-c-center  col-12 my-3 mx-0">
                        <div class="row col-6">
                            <button class="btn btn-primary purple col-12" style="border: none!important">Send the link</button>
                        </div>
                    </div>
            
                </form>
            </div>
            <div class="block3 m-0 p-0 row col-12">
                <div class="col-12 pt-3">
                    <p class="text-center" style="font-size:16px; cursor:pointer; color:#3e98fc;" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">
                        Back to login
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
                        Checkout as a Guest
                    </p>
                </div>
                
                <div class="block2 m-0 p-0 row col-12">
                    <form id="buyer_signup_formGuest" class="col-12" method="POST" action="'.base_url().'/auth/registrationGuest" autocomplete="off">
                        <div class="col-md-12 mt-2">
                            <div id="buyer_signup_messageGuest"></div>
                        </div>
                
                        <div class="col-12 my-4">
                            <input name="name" required type="text" class="form-control py-4" placeholder="Name">
                        </div>
                
                        <div class="col-12 my-4">
                            <input name="email" required class="form-control py-4" type="email" placeholder="Email ID" autocomplete="0" >
                        </div>
                
                        <div class="row col-12 mx-0 my-4 j-c-spacebetween">
                            <div class="col-2 pr-0">
                                <input required name="country_code" class="form-control py-4" type="text" placeholder="" autocomplete="0" value="+971" readonly="readonly" >
                            </div>
                            <div class="col-10">
                                <input class="form-control py-4" type="text" id="pn" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required placeholder="Phone number without country code" autocomplete="0" >
                            </div>
                        </div>
                
                
                        <!-- Buttons -->
                        <div class="row j-c-center col-12 my-3 mx-0">
                            <div class="row col-6">
                                <button class="btn btn-primary purple col-12" style="border: none!important">Continue</button>
                            </div>
                        </div>
                
                    </form>
                </div>
                
                <div class="block3 m-0 p-0 row col-12">
                    <div class="col-12 pt-3">
                        <p class="text-center" style="font-size: 16px;">
                            <p class="text-center" style="color: #3e98fc; cursor: pointer" data-form="login" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Login</p>
                        </p>
                    </div>
                </div>';
            break;
        default:
            # code...
            echo '<p> Form requested not found </p>';
            break;

    }

    if(false):
?>


<!-- TAB BEGIN -->
<div class="bg-white y_card">

    <!-- Tab titles (LOGIN, REGISTER, GUEST) -->
    <ul class="nav nav-tabs checkout_nav">
        <li class="nav-item">
            <a id="loginTab2" class="nav-link active" data-toggle="tab"
                href="#login_tab2">login </a>
        </li>
        <li class="nav-item">
            <a id="signupTab2" class="nav-link " data-toggle="tab"
                href="#ergsiter_fisrt2">register</a>
        </li>

        <?php if(!$order_restricted_to_logedin):?>
        <li class="nav-item">
            <a class="nav-link " data-toggle="tab" href="#guest_user2">guest</a>
        </li>
        <?php endif;?>
    </ul>
    <!-- Tab titles (LOGIN, REGISTER, GUEST) END -->


    <!-- Login | Login with OTP | Forgot password | Verify OTP | Register | Guest ------ FORMS  -->
    <div class="tab-content p-4">
        <div class="tab-pane active" id="login_tab2">

            <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold" id="LoginUsingEmial2">-- Login using email --</h6>
            </div>

            <form id="buyer_login_form2" class="row  " method="POST" action="<?php echo base_url(); ?>/auth/LoginValidation" autocomplete="off">
                <div class="col-md-12 mt-2">
                    <div id="buyer_login_form_message2"> </div>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="m-0 font-weight-bold">Email</label>
                    <div class="password_parent_field">
                        <input name="email" required type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Email">
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="m-0 font-weight-bold">Password</label>
                    <div class="password_parent_field">
                        <div class="eye_password" data_val="text">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                        </div>
                        <input name="password" required type="password"
                            class="w-100 border border-weight-2 rounded p-2"
                            placeholder="Enter Password">
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <button
                        class="btn btn-primary w-100 p-2 text-capitalize mt-2">Login</button>
                </div>
            </form>

            <form id="ForgotForm2" class="row  " method="POST" action="<?php echo base_url(); ?>/auth/forgotPassword" autocomplete="off">
                <div class="col-md-12 mt-2">
                    <div id="ForgotMessage2"></div>
                </div>

                <div class="col-md-12 mt-2">
                    <label class="m-0 font-weight-bold">Email</label>
                    <div class="password_parent_field">
                        <input name="email" required type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Email">
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <button
                        class="btn btn-primary w-100 p-2 text-capitalize mt-2">Submit</button>
                </div>
            </form>

            <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- or login with otp --</h6>
            </div>

            <div id="loginWithOTPMssage2"></div>

            <form id="verifyOTP2" method="POST" action="<?php echo base_url(); ?>/auth/verifyOTP" autocomplete="off">

                <input type="hidden" name="phone" id="vphone2" required>

                <div class="mt-3 d-flex justify-content-between border border-weight-2 rounded position-relative">
                    <label class="label_top m-0" style="left: 10px;">Enter Verification code</label>
                    <input style="padding-left:20px !important;" min="4" max="4" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="code" required type="text" class=" w-100 border-0  p-2" placeholder="XXXX">
                    <button class=" w-100 btn btn-primary text-capitalize p-2">Submit</button>
                </div>
            </form>


            <form id="loginWithOTP2" method="POST" action="<?php echo base_url(); ?>/auth/loginWithOTP" autocomplete="off">
                <div class="mt-3 d-flex justify-content-between border border-weight-2 rounded position-relative">
                    <select required="" name="country_code" class=" border-0 w-100 p-2" style="width: 82px !important">
                        <option value="+971">+971</option>
                        <option value="+91">+91</option>
                    </select>
                    <label class="label_top m-0" style="left: 10%;">Enter phone
                        number</label>
                    <input id="pn2" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required="" type="text" class=" w-100 border-0  p-2" placeholder="50 XXX XXXX">
                    <button class="w-100 btn btn-primary text-capitalize p-2">Submit</button>
                </div>
            </form>

            <hr>
            <div class="d-flex text-capitalize justify-content-between font-weight-bold">
                <a href="javascript:void(0);" class="text-primary" onclick="forgotPassword2();">Forgot Password?</a>
                <a href="javascript:void(0);" class="text-primary" onclick="document.getElementById('signupTab2').click()">Create an Account</a>
            </div>
        </div>

        <div class="tab-pane" id="ergsiter_fisrt2">

            <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- Register using email --</h6>
            </div>

            <form id="buyer_signup_form2" class="row  " method="POST" action="<?php echo base_url(); ?>/auth/registration" autocomplete="off">
                <input type="hidden" name="user_type" value="Normal">
                <div class="col-md-12 mt-2">
                    <div id="buyer_signup_message2"></div>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="m-0 font-weight-bold">Name</label>
                    <input name="name" required type="text"
                        class="w-100 border border-weight-2 rounded p-2"
                        placeholder="Enter name">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="m-0 font-weight-bold">Email</label>
                    <input type="email" required name="email"
                        class="w-100 border border-weight-2 rounded p-2"
                        placeholder="Enter email">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="font-weight-bold">Phone</label>
                    <div
                        class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                        <select required="" name="country_code"
                            class=" border-0 w-100 p-2"
                            style="width: 82px !important">
                            <option value="+971">+971</option>
                            <option value="+91">+91</option>
                        </select>
                        <input type="text" name="phone" required=""
                            class=" w-100 border-0  p-2"
                            placeholder="50 XXX XXX XXX"
                            onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));">
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label class="m-0 font-weight-bold">Password</label>
                    <div class="password_parent_field">
                        <div class="eye_password" data_val="text">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                        </div>
                        <input type="password" required name="password"
                            class="w-100 border border-weight-2 rounded p-2"
                            placeholder="Enter password">
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <label class="m-0 font-weight-bold">Confirm Password</label>
                    <div class="password_parent_field">
                        <div class="eye_password" data_val="text">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" width="24" height="24">
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path
                                    d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                        </div>
                        <input type="password" required name="confirm_pass"
                            class="w-100 border border-weight-2 rounded p-2"
                            placeholder="Enter confirm password">
                    </div>
                </div>



                <input type="hidden" name="verify_method" value="email">




                <div class="col-12 mt-2">
                    <label class="m-0 font-weight-bold text-gray">
                        <input type="checkbox" required>
                        I have read and agree to the <a class="text-primary"
                            href="<?php echo base_url(); ?>/privacy-and-policy">Privacy
                            Policy</a></label>
                </div>
                <div class="col-12 mt-2">
                    <button
                        class="btn btn-primary w-100 p-2 text-capitalize">Register</button>
                </div>
            </form>

            <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold"> - Already Registered User? <a href="javascript:void(0);" class="text-primary" onclick="document.getElementById('loginTab2').click()"><b>Click here</b></a> to login </h6>
            </div>

        </div>

        <?php if(!$order_restricted_to_logedin):?>
        <div class="tab-pane" id="guest_user2">
            <div class="mt-3 headding text-center text-capitalize">
                <h5 class="font-weight-bold">checkout as a guest</h5>
            </div>
            <form id="buyer_signup_formGuest" class="row  " method="POST" action="<?php echo base_url(); ?>/auth/registrationGuest" autocomplete="off">
                <input type="hidden" name="user_type" value="Guest">
                <div class="col-md-12 mt-2">
                    <div id="buyer_signup_messageGuest"></div>
                </div>
                <div class="col-md-12 mt-2">
                    <label class="m-0 font-weight-bold">Name</label>
                    <input name="name" required type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter name">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="m-0 font-weight-bold">Email</label>
                    <input type="email" required name="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter email">
                </div>
                <div class="col-md-6 mt-2">
                    <label class="font-weight-bold">Phone</label>
                    <div
                        class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                        <select required="" name="country_code" class=" border-0 w-100 p-2" style="width: 82px !important">
                            <option value="+971">+971</option>
                            <option value="+91">+91</option>
                        </select>
                        <input type="text" name="phone" required="" class=" w-100 border-0  p-2" placeholder="50 XXX XXX XXX" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));">
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <button
                        class="btn btn-primary w-100 p-2 text-capitalize">Continue</button>
                </div>
            </form>
            <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- already have a account --</h6>
            </div>
            <form class="row">
                <div class="col-12 mt-2">
                    <a onclick="document.getElementById('loginTab2').click()" href="javascript:Void(0);" class="btn btn-primary w-100 p-2 text-capitalize">login</a>
                </div>
            </form>
        </div>
        <?php endif;?>
    </div>
    <!-- Login | Login with OTP | Forgot password | Verify OTP | Register | Guest ------ FORMS END -->

</div>
<!-- TAB END -->

<?php
endif;
?>