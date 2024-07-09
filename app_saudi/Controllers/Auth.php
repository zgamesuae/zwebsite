<?php
namespace App\Controllers;
use App\Libraries\SendSms;
use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;
use Hybridauth\HttpClient;
use Hybridauth\Storage\Session;
class Auth extends BaseController
{
    public $config = [
        'callback' => 'https://zgames.sa/auth/social_login',
        'providers' => [
    
            'google' => [
                'enabled' => true,
                'keys' => [
                    'id' => '152608888307-8rck4bosmk1b0hf7gmh9f2nvt0ssrilc.apps.googleusercontent.com',
                    'secret' => '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',
                ],
                // 'scope' => 'email',
            ],
    
            // 'Yahoo' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
            'Facebook' => ['enabled' => true, 'keys' => ['id' => '1474446669754626', 'secret' => '92c1bf6f423583fdd27e4fd4d209db61']],
            // 'Twitter' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
            // 'Instagram' => ['enabled' => true, 'keys' => ['id' => '...', 'secret' => '...']],
    
        ],
    ];

    public function verify()
    {
        $uri = service("uri");
        if (count(@$uri->getSegments()) > 0) {
            $id = @$uri->getSegment(1);
        }
        if (count(@$uri->getSegments()) > 1) {
            $token = @$uri->getSegment(2);
        }

        if ($token) {
            $sql = "select * from users where token='$token'    AND user_type='Normal'";
            $res = $this->userModel->customQuery($sql);
            if ($res) {
                $ud["status"] = "Active";
                $ud["email_verification"] = "Verified";
                $ud["token"] = "";
                $this->userModel->do_action(
                    "users",
                    $res[0]->user_id,
                    "user_id",
                    "update",
                    $ud,
                    ""
                );
                return redirect()->to(base_url() . "/account-verified");
            } else {
                return redirect()->to(base_url());
            }
        }
    }

    public function resetPasswordSubmit()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "password" => [
                    "label" => "Password",
                    "rules" => "required",
                ],
                "confirm_password" => [
                    "label" => "Confirm Password",
                    "rules" => "required|matches[password]",
                ],
            ];
            if ($this->validate($rules)) {
                if ($token = $this->request->getVar("token")) {
                    $sql = "select * from users where token='$token'  AND status='Active' AND user_type='Normal'";
                    $res = $this->userModel->customQuery($sql);
                    if ($res) {
                        $ud["password"] = base64_encode(
                            $this->request->getVar("password")
                        );
                        $ud["token"] = "";
                        $this->userModel->do_action(
                            "users",
                            $res[0]->user_id,
                            "user_id",
                            "update",
                            $ud,
                            ""
                        );
                        $msgd[0] = "success";
                        $msgd[1] =
                            '<div class="alert alert-success" role="alert"> Your password has been changed successfully. please log in to continue</div>';
                        print_r(json_encode($msgd));
                        exit();
                    } else {
                        $msg[0] = "error";
                        $ht = "Invailid token.";
                        $html =
                            '<div class="alert alert alert-danger" role="alert"> ' .
                            $ht .
                            " </div>";
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                        exit();
                    }
                }
            } else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function forgotPassword()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email",
                ],
            ];
            if ($this->validate($rules)) {
                $email = $this->request->getVar("email");
                $sql = "select * from users where email='$email'  AND status='Active' AND user_type='Normal'";
                $res = $this->userModel->customQuery($sql);
                if ($res) {
                    $uid = $res[0]->user_id;
                    $ud["token"] = md5($res[0]->user_id);
                    $ud["token_created_at"] = date("Y-m-d H:i:s");
                    $this->userModel->do_action(
                        "users",
                        $res[0]->user_id,
                        "user_id",
                        "update",
                        $ud,
                        ""
                    );
                    if ($to = $res[0]->email) {
                        $subject = "Reset your password";
                        $ud["user"] = $res[0];
                        $message = view("ForgotPassword", $ud);
                        $email = \Config\Services::email();
                        $email->setTo($to);
                        $email->setFrom(
                            "info@zamzamdistribution.com",
                            "Zamzam Games"
                        );
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        if ($email->send()) {
                        }
                    }
                    $msgd[0] = "success";
                    $msgd[1] =
                        '<div class="alert alert-success" role="alert">  Reset password email sent to your registered email! </div>';
                    print_r(json_encode($msgd));
                    exit();
                } else {
                    $msg[0] = "error";
                    $ht = "Invalid Email!!!!";
                    $html =
                        '<div class="alert alert alert-danger" role="alert"> ' .
                        $ht .
                        " </div>";
                    $msg[1] = $html;
                    print_r(json_encode($msg));
                    exit();
                }
            } else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function verifyOTP()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "phone" => [
                    "label" => "phone",
                    "rules" => "required",
                ],
                "code" => [
                    "label" => "code",
                    "rules" => "required",
                ],
            ];
            // var_dump($_POST);die();
            if ($this->validate($rules)) {
                $code = $this->request->getVar("code");
                $phone = $this->request->getVar("phone");
                

                $user=$this->userModel->customQuery("select * from users where phone='".$phone."' AND status='Active' AND user_type='Normal'");
                if($user){
                    $mine = new SendSms();
                    $otp_check=$mine->verifyotp($user[0]->verification_code, $code);
                    // var_dump($otp_check);
                    if($otp_check["status"] == "Verified"){
                        $session = session();
                        $sid = session_id();
                        $session->set("userLoggedin", $user[0]->user_id);
                        $this->update_cart_after_login($sid , $user[0]->user_id);
                        // $ud["user_id"] = $user[0]->user_id;
                        
                        // $this->userModel->do_action(
                        //     "cart",
                        //     $sid,
                        //     "user_id",
                        //     "update",
                        //     $ud,
                        //     ""
                        // );
                        //   print_r($session->get('adminLoggedin'));exit;
                        $msgd[0] = "success";
                        $msgd[1] =
                            '<div class="alert alert-success" role="alert">  You Have Logged in Successfully. </div>';
                        print_r(json_encode($msgd));
                        exit();
                    }
                    else{
                        $msg[0] = "error";
                        $ht = "Invalid verification code!!!!";
                        $html =
                            '<div class="alert alert alert-danger" role="alert"> ' .
                            $ht .
                            " </div>";
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                        exit();
                    }
                }

                else{
                    $msg[0] = "error";
                        $ht = "You are not registred. Please signin first";
                        $html =
                            '<div class="alert alert alert-danger" role="alert"> ' .
                            $ht .
                            " </div>";
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                        exit();
                }
                

                // $sql = "select * from users where phone='$phone' AND verification_code =$code AND status='Active' AND user_type='Normal'";
                
            } else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function loginWithOTP()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "country_code" => [
                    "label" => "country_code",
                    "rules" => "required",
                ],
                "phone" => [
                    "label" => "phone",
                    "rules" => "required",
                ],
            ];
            // var_dump($_POST);die();
            if ($this->validate($rules)) {
                $phone = $this->request->getVar("phone");
                $country_code = $this->request->getVar("country_code");
                $is_pop = $this->request->getVar("pop");
                $sql = "select * from users where phone='$phone' AND country_code='$country_code' AND status='Active' AND user_type='Normal'";
                $res = $this->userModel->customQuery($sql);
                if ($res) {

                    if(true){
                    // #############SEND OTP START########
                    $mine = new SendSms(); // loads and creates instance
                    // $m = "Your verification code is {*" . $ud["verification_code"] . "*} Zamzam Games";
                    $m = "Your verification code is {*code*} Zamzam Games";

                    $opt_res=$mine->sendMessage($country_code . "" . $phone, $m ,"Zgames");
                    // var_dump($opt_res);
                    // ##########SEND OTP END##########
                    }

                    if($opt_res["status"] = "Sent" && true){
                        // $ud["verification_code"] = rand(999, 9999);
                        $ud["verification_code"] = $opt_res["requestId"];

                        $this->userModel->do_action(
                            "users",
                            $res[0]->user_id,
                            "user_id",
                            "update",
                            $ud,
                            ""
                        );

                        $msg[0] = "success";
                        
                        if((boolean)$is_pop)
                        $html = '
                            <div class="block1 col-12 m-0 p-0 row">
                                <p class="text-center col-12 pb-3" style="font-size: 18px">
                                    Login to your account <br>using your Phone number
                                </p>
                            </div>
                            
                            <div class="block2 col-12 m-0 p-0 row">
                                <form class="col-12" id="verifyOTP" method="POST" action="'.base_url().'/auth/verifyOTP" autocomplete="off">
                                    <div id="loginWithOTPMssage" class="col-md-12 pt-2">
                                        <div class="alert alert alert-success" role="alert">A verification code has been sent to your registered phone number.</div>
                                    </div>
                                    <input type="text" hidden name="phone" id="vphone" value="'.$phone.'">
                                    <div class="row j-c-center a-a-center">
                                        <div class="col-7 my-4">
                                            <input name="code" required class="form-control py-4" type="text" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" placeholder="Enter the digits" autocomplete="0" >
                                        </div>
                                        <div class="col-2 my-4 pr-0">
                                            <p style="color:#3e98fc; cursor: pointer;" class="m-0" id="resend_otp" onClick="resend_otp(\''.$country_code.'\',\''.$phone.'\' , \''.$destination.'\')">Resend</p>
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

                            <div class="block3 col-12 m-0 p-0 row">
                                <div class="col-12 pt-3">
                                    <p class="text-center" style="font-size: 16px;">
                                        <p class="text-center" style="color: #3e98fc; cursor:pointer" data-form="register" onClick="get_form(this.getAttribute(\'data-form\') , \''.$destination.'\')">Create new account</p>
                                    </p>
                                </div>
                            </div>
                        ';
                        else
                        $html = '<div class="alert alert alert-success" role="alert"> A verification code has been sent to your registered phone number. </div>';
                        
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                    }
                    else{
                        $msg[0] = "error";
                        $ht =
                            "Something went wrong please try again.";
                        $html =
                            '<div class="alert alert alert-danger" role="alert"> ' .
                            $ht .
                            " </div>";
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                    }

                    
                    //   print_r($session->get('adminLoggedin'));exit;


                    
                    exit();


                } else {
                    $msg[0] = "error";
                    $ht = "Phone number not registered!";
                    $html =
                        '<div class="alert alert alert-danger" role="alert"> ' .
                        $ht .
                        " </div>";
                    $msg[1] = $html;
                    print_r(json_encode($msg));
                    exit();
                }
            }  
            
            else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function sendsms()
    {
        $mine = new SendSms(); // loads and creates instance
        $res = $mine->sendMessage("+78685656", "test");
        print_r($res);
    }
    public function logout()
    {
        $session = session();
        $session->remove("userLoggedin");
        $this->social_login(false);
        return redirect()->to(site_url());
    }
    public function LoginValidation()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email",
                ],
                "password" => [
                    "label" => "Password",
                    "rules" => "required",
                ],
            ];
            if ($this->validate($rules)) {
                $email = $this->request->getVar("email");
                $pass = base64_encode($this->request->getVar("password"));
                // $sql = "select * from users where email='$email' AND password ='$pass' AND status='Active' AND user_type='Normal'";
                $sql = "select * from users where email='$email' AND password ='$pass' AND user_type='Normal'";

                $res = $this->userModel->customQuery($sql);
                if ($res) {
                    if(!is_null($res) && $res[0]->status == "Inactive"){
                        $msg[0] = "error";
                        $ht = "Please check your email to validate your account, or <a id='resend-verification' href='".base_url()."/login/resend-verification-code/".$res[0]->user_id."'>Click here</a> to resend verification Email";
                        $html = '<div class="alert alert alert-danger" role="alert"> ' . $ht . " </div>";
                        $msg[1] = $html;
                        print_r(json_encode($msg));
                        exit();
                    }
                    else{
                        $session = session();
                        $sid = session_id();
                   
                        $this->update_cart_after_login($sid , $res[0]->user_id);
                        
                        $session->set("userLoggedin", $res[0]->user_id);
                        // $ud["user_id"] = $res[0]->user_id;
                        // $this->userModel->do_action(
                        // "cart",
                        // $sid,   
                        // "user_id",
                        // "update",
                        // $ud,
                        // ""
                        // );
                    //   print_r($session->get('adminLoggedin'));exit;
                    $msgd[0] = "success";
                    $msgd[1] =
                        '<div class="alert alert-success" role="alert">  You Have Logged in Successfully. </div>';
                    print_r(json_encode($msgd));
                    exit();
                    }
                    
                }
                else {
                    $msg[0] = "error";
                    $ht = "Invalid Username or Password!!!!";
                    $html =
                        '<div class="alert alert alert-danger" role="alert"> ' .
                        $ht .
                        " </div>";
                    $msg[1] = $html;
                    print_r(json_encode($msg));
                    exit();
                }
            } else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function registrationGuest()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email",
                ],
                "name" => [
                    "label" => "Name",
                    "rules" => "required",
                ],
                "phone" => [
                    "label" => "Phone number",
                    "rules" => "required|numeric|exact_length[9]",
                    "errors" => [
                        "exact_length" => "Please enter 9 digits Phone number."
                    ]
                ],
            ];
            if ($this->validate($rules)) {
                $email = $this->request->getVar("email");
                $p = $this->request->getVar();
                $p["user_type"] = "Guest";
                $p["user_id"] = time();
                $res = $this->userModel->do_action(
                    "users",
                    "",
                    "",
                    "insert",
                    $p,
                    ""
                );
                $msgd[0] = "success";
                $msgd[1] = '<div class="alert alert-success" role="alert">Information saved successfully!</div>';

                $sid = session_id();

                $res = $this->userModel->do_action(
                    "cart",
                    $sid,
                    "user_id",
                    "update",
                    ["user_id" => strval($p["user_id"])],
                    ""
                );

                $session = session();
                $session->set("userLoggedin", $p["user_id"]);

                print_r(json_encode($msgd));
                exit();

            } 
            else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function registration()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $validation = \Config\Services::validation();
            $rules = [
                "email" => [
                    "label" => "Email",
                    "rules" => "required|valid_email",
                ],
                "name" => [
                    "label" => "Name",
                    "rules" => "required",
                ],
                "phone" => [
                    "label" => "phone",
                    "rules" => "required|numeric|exact_length[9]",
                    "errors" => [
                        "exact_length" => "Enter 9 digits phone number"
                    ]
                ],
                "password" => [
                    "label" => "Password",
                    "rules" => "required",
                ],
                "confirm_pass" => [
                    "label" => "Confirm Password",
                    "rules" => "required|matches[password]",
                ],
            ];
            if ($this->validate($rules)) {
                $email = $this->request->getVar("email");
                $sql = "select * from users where email='$email' AND user_type='Normal'";
                $echk = $this->userModel->customQuery($sql);
                if ($echk) {
                    $msg[0] = "error";
                    $html_content = "";
                    if($echk[0]->status == "Inactive"){
                        $user = $this->userModel->get_user_infos_by_email($email , false);
                        $html_content = "Your Email is registred but not active. <br> <a id='resend_confirmation' href='".base_url()."/login/resend-verification-code/".$user->user_id."'>Click here</a> to resend the activation email";
                    }
                    else{
                        $html_content = "Email Address is Already Registered.";
                    }
                    $html = "<div class='alert alert alert-danger' role='alert'>$html_content</div>";
                    $msg[1] = $html;
                    print_r(json_encode($msg));
                    exit();
                } 
                else {
                    $pass = base64_encode($this->request->getVar("password"));
                    $p = $this->request->getVar();
                    unset($p["confirm_pass"]);
                    $p["user_id"] = time();
                    $p["password"] = $pass;

                    if ($this->request->getVar("verify_method") == "email") {
                        $p["token"] = md5($p["user_id"]);
                        $p["token_created_at"] = date("Y-m-d H:i:s");
                    }

                    $this->userModel->do_action(
                        "users",
                        "",
                        "",
                        "insert",
                        $p,
                        ""
                    );

                    // Send verificaiton Start
                    if ($this->request->getVar("verify_method") == "email") {

                        if (!$this->send_verification_email($p["user_id"])) {
                            $msg[0] = "error";
                            $msg[1] = "Something went Wrong, Please try again later!";
                            print_r(json_encode($msg));
                            exit();
                        }

                    } 
                    elseif ($this->request->getVar("verify_method") == "phone") {}
                    // send Verification END
                    $msgd[0] = "success";
                    $msgd[1] = '<div class="alert alert-success" role="alert" style="text-align:center">You Have Registered Successfully. </br> Please check your email to validate your account </div>';
                    print_r(json_encode($msgd));
                    exit();
                }
            } else {
                $msg[0] = "error";
                $ht = "";
                foreach ($validation->getErrors() as $v) {
                    $ht = $ht . " " . $v . "<br>";
                }
                $html =
                    '<div class="alert alert alert-danger" role="alert"> ' .
                    $ht .
                    " </div>";
                $msg[1] = $html;
                print_r(json_encode($msg));
                exit();
            }
        }
    }
    public function header()
    {
        return view("Common/Header");
    }
    public function footer()
    {
        return view("Common/Footer");
    }
    
    public function get_form($key , $destination = null){

        $form = view("forms/Login_forms" , array("flag" => $key , "destination" => $destination));
        return $form;

    }
    
    public function update_cart_after_login($session_id , $user_id){
       
        $req2 = "select id,user_id,product_id,quantity from cart where user_id='".$session_id."'";
        $guest_cart = $this->userModel->customQuery($req2);

        // update the guest cart after loged in 
        // Loop over the Guest cart and check if the guest has the product in his user cart
        if($guest_cart && sizeof($guest_cart) > 0)
        foreach($guest_cart as $guest_product_cart){
            $cart_req = "select id,product_id,quantity from cart where user_id='".$user_id."' and product_id='".$guest_product_cart->product_id."'";
            $user_cart = $this->userModel->customQuery($cart_req);

            if($user_cart && sizeof($user_cart) > 0){

                $qty_update = $this->userModel->do_action(
                    "cart",
                    $user_cart[0]->id,   
                    "id",
                    "update",
                    array("quantity" => $guest_product_cart->quantity + $user_cart[0]->quantity),"");

                if($qty_update)
                $this->userModel->do_action(
                    "cart",
                    $guest_product_cart->id,   
                    "id",
                    "delete",
                    "",
                    ""
                );
            }
            else{
                $this->userModel->do_action(
                    "cart",
                    $guest_product_cart->id,   
                    "id",
                    "update",
                    array("user_id" => $user_id),
                    ""
                );
                
            }
        }
        
        
        
      
    } 

    public function social_login($logout = true){
    
        try {
    
            $hybridauth = new Hybridauth($this->config);
            $storage = new Session();
            $error = false;
        
            //
            // Event 1: User clicked SIGN-IN link
            //
            if (isset($_GET['provider'])) {
                // Validate provider exists in the $config
                if (in_array($_GET['provider'], $hybridauth->getProviders())) {
                    // Store the provider for the callback event
                    $storage->set('provider', $_GET['provider']);
                } else {
                    $error = $_GET['provider'];
                }
            }
        
            //
            // Event 2: User clicked LOGOUT link
            //

            // if (isset($_GET['logout'])) {
            if (!$logout) {
                $adapter = $hybridauth->disconnectAllAdapters();

                // if (in_array($_GET['logout'], $hybridauth->getProviders())) {
                    // Disconnect the adapter
                    // $adapter = $hybridauth->getAdapter($_GET['logout']);
                    // $adapter->disconnect();
    
                // } else {
                //     $error = $_GET['logout'];
                // }
            }
        
            //
            // Handle invalid provider errors
            //
            if ($error) {
                error_log('Hybridauth Error: Provider ' . json_encode($error) . ' not found or not enabled in $config');
                // Close the pop-up window
                echo "
                    <script>
                        if (window.opener.closeAuthWindow) {
                            window.opener.closeAuthWindow();
                        }
                    </script>";
                exit;
            }
        
            //
            // Event 3: Provider returns via CALLBACK
            //
            if ($provider = $storage->get('provider')) {
                
                $hybridauth->authenticate($provider);
                $storage->set('provider', null);
        
                // Retrieve the provider record
                $adapter = $hybridauth->getAdapter($provider);
                $userProfile = $adapter->getUserProfile();
                $accessToken = $adapter->getAccessToken();
        
                // add your custom AUTH functions (if any) here
                // ...
                $data = [
                    'token' => $accessToken,
                    'identifier' => $userProfile->identifier,
                    'email' => $userProfile->email,
                    'first_name' => $userProfile->firstName,
                    'last_name' => $userProfile->lastName,
                    'photoURL' => strtok($userProfile->photoURL, '?'),
                ];
                // ...

                // var_dump($userProfile);
                
                if(trim($data["email"]) !== ""){
                    $user = $this->userModel->get_user_infos_by_email($data["email"]);
                    if(is_null($user)){
                        $inactive = $this->userModel->get_user_infos_by_email($data["email"] , false);
                        if(!is_null($inactive)){
                            $this->userModel->do_action("users" , $inactive->user_id , "user_id" , "update" , ["status" => "Active"] , "");
                            $user = $inactive;
                        }
                        else
                        $user = $this->userModel->user_social_signup($data["email"] , $data["first_name"]." ".$data["last_name"] , $data["photoURL"] , $provider);
                    }
                    $session = session();
                    $sid = session_id();
                    $this->update_cart_after_login($sid , $user->user_id);
                    $session->set("userLoggedin", $user->user_id);
                    echo "
                    <script>
                        if (window.opener.closeAuthWindow) {
                            window.opener.location.reload()
                            window.opener.closeAuthWindow();
                        }
                    </script>";
                    
                }

                else
                echo "
                    <script>
                        if (window.opener.closeAuthWindow) {
                            window.opener.location.reload()
                            window.opener.closeAuthWindow();
                        }
                    </script>";
        
                // Close pop-up window
                

                
        
            }
        
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo $e->getMessage();
        }
        
    }

    public function send_verification_email($user_id){
        
        $user = $this->userModel->get_user_infos($user_id);

        if ($to = $user->email) {
            $subject = "Account verification email";
            $ud["user"] = $user;
            $message = view("AccountVerification2", $ud);
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setFrom(
                "info@zamzamdistribution.com",
                "Zamzam Games"
            );
            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send()) {
                return true;
            }
        }

        return false;
    }
    
    public function resend_verification_email($user_id){

        $result = ["status" => 0 , "msg" => "<div class='alert alert alert-danger' role='alert'>Something went wrong! try again later.</div>"];
        if(strtolower($this->request->getMethod()) == "post"){
            
            $result = ($this->send_verification_email($user_id)) ? (["status" => 1 , "msg" => "<div class='alert alert alert-success' role='alert'>Verification email was sent seccessfuly!</div>"]) : $result;
            
        }

        return json_encode($result);
    }
}
