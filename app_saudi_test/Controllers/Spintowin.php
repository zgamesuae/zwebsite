<?php 

namespace App\Controllers;
class Spintowin extends BaseController{
    
    
    
    public function index(){
        echo view("Common/Header");
        echo view("wheel/Wheel" , ["spin_wheel" => $this->spin_wheel("16634073579")]);
        echo view("Common/Footer");
    }
    
    public function wheel_spined($user_id,$order_id){
        
        $req="select count(user_id) as c from user_spined_wheel where user_id='".$user_id."' and order_id='".$order_id."'";
      
        $res = $this->userModel->customQuery($req);
        if($res && $res[0]->c == 0)
        return false;
        else return true;
    }

    public function spin_wheel($order_id){
        
        $session = session();
        $orderModel = model("App\Model\OrderModel");
        $user_id = ($session->get("userLoggedin") == null) ? false : $session->get("userLoggedin");

        // check if the user has the order with id 
        $has_order = $orderModel->user_has_order($user_id , $order_id);
        // ---------------------------------------------

        // check if the user is registed and confirmed and did not spin the wheel before and the order date is in the date range of the offer
        $is_registred =$this->userModel->is_registred($user_id);
        $spinned = $this->wheel_spined($user_id,$order_id);
        
        $order_date = ($orderModel->get_last_order_date($user_id)) ? new \DateTime($orderModel->get_last_order_date($user_id) , TIME_ZONE) : false;
        $start_d = new \DateTime("2022-11-1 00:00:01" , TIME_ZONE);
        $end_d = new \DateTime("2022-11-31 00:00:01" , TIME_ZONE);

        $valid_order_date = ($order_date > $start_d) && ($end_d > $order_date);
        // ---------------------------------------------

        // var_dump($user_id!==false , $has_order , $is_registred , !$spinned , $valid_order_date);die();
        return ($user_id!==false && $has_order && $is_registred && !$spinned && $valid_order_date);
    }

    public function spin_result($order_id){
        
        $prizes = array(
            1 => "Pink",
            2 => "Yellow",
            3 => "Purple",
            4 => "Blue",
            5 => "Pink",
            6 => "Yellow",
            7 => "Purple",
            8 => "Blue",
        );

        if($this->spin_wheel($order_id)){
            $random_angle = rand(0 , 80)*0.01;
            $_angle = ($random_angle * 450);
            // $_angle = 35 ;

            $item = (fmod($_angle , 45) > 0) ? intdiv($_angle , 45) + 1 : intdiv($_angle , 45);

            // echo($prizes[$item]);
            $session = session();
            $user_id = $session->get("userLoggedin");
            

            $res =$this->userModel->do_action("user_spined_wheel" , "" , "" , "insert" , ["user_id"=>$user_id,"order_id"=>$order_id,"prize"=>$prizes[$item]] , "");


            return json_encode(array("rotate" => $_angle));  
        }
        return json_encode(array("rotate" => false));

    }

    public function get_prize($order_id){
        
        $session = session();
        $orderModel = model("App\Model\OrderModel");
        $settings = $this->systemModel->get_website_settings();

        $response = array("prize"=>"");

        $prizes = array(
            "Pink" => array("title"=>"Messi figurine" , "link"=>"https://zamzamgames.com/assets/uploads/suynvy.png"),
            "Blue" => array("title"=>"RAZER BlackShark V2" , "link"=>"https://zamzamgames.com/assets/uploads/razer_blackshark.png"),
            "Yellow" => array("title"=>"GamerTek PS5 Carrying Case" , "link"=>"https://zamzamgames.com/assets/uploads/gamertek_ps5_carrying_case_1.png"),
            "Purple" => array("title"=>"Porodo Gaming True Wireless Earbuds-Silver" , "link"=>"https://zamzamgames.com/assets/uploads/earpods-gaming.png"),
        );

        $user_id = ($session->get("userLoggedin") == null) ? false : $session->get("userLoggedin");

        if($this->request->getMethod() == "get"){
            // var_dump($this->request->getVar("orderid"));die();
            if($user_id !== false && $this->wheel_spined($user_id,$order_id) && $orderModel->user_has_order($user_id , $order_id)){
                $customer =$this->userModel->get_user($user_id);
                $req = "select * from user_spined_wheel where user_id='".$user_id."' and order_id='".$order_id."'";
                $res =$this->userModel->customQuery($req);
                // var_dump($res);die();

                if(!is_null($res) && sizeof($res)>0 && (trim($res[0]->prize) !== "")){
                    $response["prize"] = '
                        <div class="prize-title col-12 row p-0 j-c-center m-0 py-3" style="background: #22398d; height: auto">
                            <h3 class="col-9 text-center" style="color:rgb(245, 245, 245); font-size: 20px">Congratulation you won a prize!</h3>
                        </div>
                        <div class="prize-content row col-12 m-0 px-2 j-c-center a-a-center" style="min-height: 250px">
                            <div class="col-12 col-md-6 d-flex j-c-center my-3">
                                <img src="'.$prizes[$res[0]->prize]["link"].'" style="max-height:180px " alt="">
                            </div>
                            <div class="col-12 col-md-6 d-flex j-c-center">
                                <h2 class="p-3" style="font-size: 25px; color: rgb(255, 255, 255); background-color: rgb(0, 102, 5);">'.$prizes[$res[0]->prize]["title"].'!!</h2> 
                            </div>

                            <div class="col-10 d-flex j-c-center mt-2">
                                <p style="text-align: center; font-size: .7rem; color: rgb(143, 143, 143); line-height: 15px">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sed soluta corporis modi labore nihil ad quaerat, 
                                </p>
                            </div>
                        </div>
                    ';

                    // email the customer
                    $to = $customer->email;
                    $subject = "Spining wheel prize!!";
                    $message = '
                        <div style="width: 550px; background-color: white; margin: 15px auto">
                            <p style="font-size: 16px; font-weight: 500;">
                                Thank you <b>'.$customer->name.'</b> for shoping with ZGames, you will get the folowing item as a prize with your last order <b><i>N° '.$order_id.'</i></b>.
                            </p>
                            <table style="width:100%; height:auto; margin: 55px 0; border: solid rgba(0, 0, 0, 0.356) 1px">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="background: #22398d;">
                                            <h3 style="color:rgb(245, 245, 245); font-size: 20px; padding: 15px 10px; text-align:center; margin:0px">Congratulation you won a prize!</h3>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 50%; text-align:center">
                                            <img src="'.$prizes[$res[0]->prize]["link"].'" style="max-height:180px " alt="">
                                        </td>
                                        <td style="width: 50%; text-align:center; padding: 5px">
                                            <div style="color: rgb(255, 255, 255); background-color: rgb(0, 102, 5);padding: 15px 10px">
                                                <p style="font-size: 18px;">'.$prizes[$res[0]->prize]["title"].'</p>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="padding: 10px 5px">
                                            <p style="text-align: center; font-size: 12px; color: rgb(143, 143, 143); line-height: 15px; padding: 0px 15px">
                                                Terms & Conditions: The above item is not replaceable or refundable. 
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="width: 100%; ">
                                <tr>
                                    <td>
                                        <p style="font-size: 12px; padding: 5px 20px; text-align:center">
                                            Tel: '.$settings->phone.' <br>
                                            Email: '.$settings->email.' <br>
                                            © '.$settings->business_name.' | '.$settings->address.'.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center">
                                        <a href="'.$settings->facebook.'" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                            <img alt="" src="https://zamzamgames.com/assets/uploads/ns_facebook.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                                        </a> 
                                        <a href="'.$settings->instagram.'" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                            <img alt="" src="https://zamzamgames.com/assets/uploads/ns_instagram.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                                        </a> 
                                        <a href="'.$settings->tiktok.'" style="text-decoration:none; margin:0 10px; fill:#363636"> 
                                            <img alt="" src="https://zamzamgames.com/assets/uploads/ns_tiktok.png" style="height:30px; vertical-align:middle; margin: 15px 0"> 
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </div>
                    ';
                    $email = \Config\Services::email();
                    $email->setTo($to);
                    $email->setFrom(
                        "info@zamzamdistribution.com",
                        "Zamzam Games"
                    );
                    $email->setSubject($subject);
                    $email->setMessage($message);
                    $email->send();
                }
            }
        }
        return json_encode($response);
    }
    
}

?>