<?php 
namespace App\Controllers;
use App\Controllers\BaseController;
class Preorder_register_intrest extends \App\Controllers\BaseController{


    public function index(){
        echo view("Common/Header");
        echo view("Oculus_intrest");
        // echo view("Oculus_email_notification");
        echo view("Common/Footer");
    }

    public function checkrequest(){
        $errors=array();
        // $this->load->helper(array('form', 'url'));
        // $this->load->library('form_validation');

        // var_dump($this->request->getVar());
        $data=$this->request->getVar();
        // var_dump($data);die();
        $counter=$v=0;
        foreach($data as $key=>$value){
            switch ($key) {
                case 'email':
                    if($value !== ""){
                        // $pattern="/[\w\d\.-_]+@[\w]+\.com/";
                        $pattern="/[\w\d_\.-]+@[\w]+\.[\w]+/";
                        preg_match($pattern,$value,$res);
                        // var_dump($res);
                        if(sizeof($res) == 0)
                        $errors["email"]="Please enter a valid email";
                    }
                    else
                    $error["email"]="Email field is required";

                    # code...
                    
                break;

                case 'phone':
                    if($value !== ""){
                        $pattern="/[A-Za-z@\/&£$%\.?<>]+/";
                        preg_match($pattern,$value,$phone);
                        if(sizeof($phone) > 0)
                        $errors["phone"]="Please enter a valid phone number";
                        else{
                            $pattern = "/\+971\d{7}/";
                            preg_match($pattern,$value,$phone2);
                            if(sizeof($phone2) == 0)
                            $errors["phone"]="Please enter a valid UAE phone number";

                        }
                    }
                    else
                    $error["phone"]="Phone number field is required";
                break;

                case 'name':
                    if($value == "")
                    $errors["name"]="Name field is required";
                break;

                case 'order-type':
                    if($value == "")
                    $errors["order-type"]="please select your way of purchase";
                break;

                case 'store':
                    if($value == "")
                    $errors["store"]="please choose a pickup store";
                    $op_type==$value;

                break;


               
                
                default:
                    # code...
                    break;
            }
        }


        if(sizeof($errors) == 0){
            $email_sent = $this->email_preorder_query(array("infos"=>$data));

            if($email_sent)
                return redirect()->to(base_url()."/Preorder_register_intrest/request_sent/1/".$data["name"]);
            else
                return redirect()->to(base_url()."/Preorder_register_intrest/request_sent/0/".$data["name"]);
        }

        else{
            echo view("Common/Header");
            echo view("Oculus_intrest",array("data"=>$this->request->getVar(),"errors"=>$errors));
            echo view("Common/Footer");
        }


        // $this->form_validation->set_rules('name', 'Name', 'required');
        // $this->form_validation->set_rules('email', 'E-mail', 'required');
        // $this->form_validation->set_rules('phone', 'Phone number', 'required');
        // $this->form_validation->set_rules('motherboard', 'Motherboard', 'required');
        // $this->form_validation->set_rules('cpu', 'Processor', 'required');
        // $this->form_validation->set_rules('gpu', 'Graphic card', 'required');
        // $this->form_validation->set_rules('storage', 'Storage', 'required');
        // $this->form_validation->set_rules('ram', 'RAM', 'required');
        // $this->form_validation->set_rules('case', 'Case', 'required');
        // $this->form_validation->set_rules('os', 'Operating system', 'required');


    }

    public function request_sent($status,$name){
        echo view("Common/Header");
        echo view("Pc_getaquote_ak_receip",array("status"=>$status,"name"=>$name));
        echo view("Common/Footer");
    }

    public function request_send_error($status,$name){
        echo view("Common/Header");
        echo view("Pc_getaquote_ak_receip",array("status"=>$status,"name"=>$name));
        echo view("Common/Footer");
    }

    public function email_preorder_query($idata){
        if($to = "taha.ali@zamzamgames.com"){
            $subject = 'ASUS ROG Ally | Customer intrest '.$idata['infos']["name"];
            $message = view('register_intrest_email_notification', $idata);
            $email = \Config\Services::email();
            $email->setTo($to);
            $email->setCC(["waseem.sultani@zamzamgames.com","yahia@3gelectronics.biz","info@zamzamgames.com"]);
            $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
            $email->setSubject($subject);
            $email->setMessage($message);
            if ($email->send()) {
                // echo 'Email successfully sent';
                return true;
            } 
            else {
                $data = $email->printDebugger(['headers']);
                // print_r($data);
                return false;
            }
        }
    }


    public function load_config_form($flag){
        if($flag == 1)
        return null;
        else{
            return $string;
        }
    }

    public function email_test(){
        if($to = "yahia@3gelectronics.biz"){
            // if($to = "yahia@3gelectronics.biz"){
                $subject = 'ASUS ROG Ally | Customer intrest ';
                $message = "hello world";
                $email = \Config\Services::email();
                $email->setTo($to);
                // $email->setCC(["waseem.sultani@zamzamgames.com","yahia@3gelectronics.biz","info@zamzamgames.com"]);
                $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
                $email->setSubject($subject);
                $email->setMessage($message);
                if ($email->send()) {
                    // echo 'Email successfully sent';
                    return true;
                } 
                else {
                    $data = $email->printDebugger(['headers']);
                    print_r($data);
                    return false;
                }
            }
    }


}