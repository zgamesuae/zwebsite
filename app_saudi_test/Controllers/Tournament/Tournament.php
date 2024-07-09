<?php 
namespace App\Controllers\Tournament;
use App\Controllers\BaseController;
use App\Controllers\Page;
class Tournament extends \App\Controllers\BaseController{

    public function index($return = []){
        echo view("Common/Header");
        echo view("forms/Esport_registration" , $return);
        echo view("Common/Footer");

    }

    public function register(){
        $settings = $this->systemModel->get_website_settings();

        if(strtolower($this->request->getMethod()) == 'post'){
            helper(["url" , "form"]);
            $validation = \Config\Services::validation();
            $rules = [
                "first_name" => [
                    "rules" => "required|alpha_space",
                    "errors" => [
                        "required" => "First name is required",
                        "alpha_space" => "Only alphabetic caracters allowed"
                    ]
                ],

                "last_name" => [
                    "rules" => "required|alpha_space",
                    "errors" => [
                        "required" => "Last name is required",
                        "alpha_space" => "Only alphabetic caracters allowed"

                    ]
                ],
                "date_birth" => [
                    "rules" => "required|valid_date[Y-m-d]",
                    "errors" => [
                        "required" => "Date of birth is required",
                        "valid_date" => "Enter a valid date"
                    ]
                ],
                // "street" => [
                //     "rules" => "alpha_numeric_punct",
                //     "errors" => [
                //         "required" => "Street address is required",
                //         "alpha_numeric_punct" => "Enter a valid street address"
                //     ]
                // ],
                // "apartment" => [
                //     "rules" => "alpha_numeric_punct",
                //     "errors" => [
                //         "required" => "Apartment is required",
                //         "alpha_numeric_punct" => "Enter a valid apartment address"
                //     ]
                // ],
                // "city" => [
                //     "rules" => "in_list[Dubai,Abu Dhabi,Sharjah,Ajman,Al Ain]",
                //     "errors" => [
                //         "required" => "City address is required",
                //         "in_list" => "City not recognized" 
                //     ]
                // ],

                "email" => [
                    "rules" => "required|valid_email",
                    "errors" => [
                        "required" => "E-mail address is required",
                        "valid_email" => "Enter a valid e-mail address"
                    ]
                ],

                "phone" => [
                    "rules" => "required|numeric",
                    "errors" => [
                        "required" => "E-mail address is required",
                        "numeric" => "Enter a valid phone number"
                    ]
                ],
                "term_cond" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "You have to agree to the Terms and Conditions",
                    ]
                ],
                

            ];

            $form = $this->request->getVar();
            $form["title"] = "SF6 - Steelbook Competition";

            $validation->setRules($rules);
            $form_validation = $this->validate($rules);
            $is_registred = $this->user_already_registred($form["email"] , $form["title"]);

            if($form_validation && !$is_registred){
                unset($form["term_cond"]);
                // $form["title"] = "Al Warqa E-Sport";
                // $form["title"] = "Ultimate Punch";
                
                $form["c_code"] = base64_encode($form["email"].rand(10 , 150000));
                $player_id = $this->userModel->do_action("tournament_register", "", "", "insert", $form, "");

                if($player_id){
                    $content= '
                        <style>
                            *{
                                font-family: \'Poppins\', sans-serif;
                            }
                        </style>
                        <div style="height: auto; width:650px; background-color: rgb(232, 234, 238); border: solid 1px rgba(0, 0, 0, 0.171); margin: 15px auto">
                        
                            <!-- Header -->
                            <div style="padding: 0px 50px 20px; background-color: rgb(232, 234, 238);">
                                <table style="width:100%; height:auto; text-align:center">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: center; width: auto;" colspan="2">
                                                <div style="height: 100%; width: 100%; margin: auto; padding: 25px 0px">
                                                    <a target="blank" href="<?php echo base_url() ?>">
                                                        <img src="<?php echo base_url() ?>/assets/uploads/ZGames-logo-02.png" width="100px" alt="">
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                        
                                    </tbody>
                                </table>
                            </div>
                            <!-- Header -->
                        
                            <!-- Call to action message -->
                            <div style="width: 90%; padding: 25px 25px; text-align: justify; margin: auto; box-sizing: border-box;">
                                <p>Hi '.$form["first_name"].' '.$form["last_name"].', </p>
                                    To confirm your registration for <b>'.$form["title"].'</b>, please click the button below.
                                <p>Thank you!</p>
                                <div style="margin:30px auto; width: 200px; height: auto; background-color: #22398d; text-align: center;">
                                    <a href="https://zamzamgames.com/tournament/tournament/cr/'.$form["c_code"].'" style="color:white;">
                                        <p style="padding:10px 0px; margin: 0px;">Confirm registration</p>
                                    </a>
                                </div>
                            </div>
                            <!-- Call to action message -->
                        
                            <!-- footer -->
                            <table align="center" style="width:100%; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px">
                                <tbody>
                                    <tr></tr>
                                    <tr>
                                        <td style="height:auto; text-align:center; line-height:20px; padding:0; color:#363636" colspan="4">
                                            <p style="font-size: .8rem; margin:0">
                                                Tel: '.$settings->phone.' <br>
                                                Email: '.$settings->email.' <br>
                                                © '.$settings->business_name.' | '.$settings->address.'.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center">
                                            <a style="text-decoration:none; margin:0 10px; fill:#363636" href="'.$settings->facebook.'">
                                                <img style="height:30px; vertical-align:middle; margin: 15px 0" src="https://zamzamgames.com/assets/uploads/ns_facebook.png" alt="">
                                            </a>
                                            <a style="text-decoration:none; margin:0 10px; fill:#363636" href="'.$settings->instagram.'">
                                                <img style="height:30px; vertical-align:middle; margin: 15px 0" src="https://zamzamgames.com/assets/uploads/ns_instagram.png" alt="">
                                            </a>
                                            <a style="text-decoration:none; margin:0 10px; fill:#363636" href="'.$settings->tiktok.'">
                                                <img style="height:30px; vertical-align:middle; margin: 15px 0" src="https://zamzamgames.com/assets/uploads/ns_tiktok.png" alt="">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- footer -->
                        
                        </div>
                    ';

                    if($this->email_confirmation( $form["email"] , $content , $form["title"]." | Confirm registration") || true)
                    $this->index([ "success" => true , "message" => "Thank you <b>".$form["first_name"]." ".$form["last_name"]."</b> for your intrest, an email was sent to <b>".$form["email"]."</b> to confirm your registration." ]);
                }
                else{
                    $this->index([ "errors" => ["Ops" => "Operation failed!"] ]);
                }
            }

            else{

                if($form_validation)
                $this->index(["errors" =>  $validation->getErrors() , "data" => $form]);
                else
                $this->index(["message" =>  "You have already registred" , "data" => $form]);
            }

        }

        else{
            echo "
                <div style='width: 100%; height:100%; box-sizing: border-box; margin: auto'>
                    <div style='width: 80%; box-sizing: border-box; margin: auto; '>
                        <h2 style='margin:auto; text-align:center;'>You do not have the right to access this page</h2>
                    </div>
                </div>
            ";
        }
    }

    public function email_confirmation($address , $content , $subject){
        if($to = $address){
            // $subject = 'Zgames Al Warqa E-Sport tournament | Registration';
            $message = $content;
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send()) {
                return true;
            } 
            else {
                $data = $email->printDebugger(['headers']);
                return false;
            }
        }
    }

    public function cr($code){
        $req = "select email,first_name,last_name from tournament_register where c_code='".$code."' and status='Pending'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            $this->userModel->do_action("tournament_register", $code, "c_code" , "update", ["status"=>"Confirmed"], "");
            $this->newsletterModel->_subscribe(["email" => $res[0]->email]);
            $this->index([ "success" => true , "message" => "Thank you <b>".$res[0]->first_name." ".$res[0]->last_name."</b> your registration has been confirmed successfully! You will be contacted soon. </br> Stay Tuned" ]);
        }

        else
        $this->index([ "success" => false , "message" => "Email address not found or confirmation link has expired."]);

    }

    public function user_already_registred($email , $title){
        $req = "
        select count(email) as cn 
        from tournament_register 
        where email='".$email."' 
        AND title='".$title."'
        ";
        $res = $this->userModel->customQuery($req);
        if($res && $res[0]->cn > 0)
        return true;

        return false;
    }

}