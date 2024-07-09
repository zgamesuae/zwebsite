<?php 
namespace App\Controllers\pcgamer;
use App\Controllers\BaseController;
class Get_a_quote extends \App\Controllers\BaseController{


    public function index(){
        echo view("common/Header");
        echo view("Pc_getaquote");
        echo view("common/Footer");
    }

    public function check_request(){
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
                    }
                    else
                    $error["phone"]="Phone number field is required";
                break;

                case 'name':
                    if($value == "")
                    $errors["phone"]="Name field is required";
                break;

                case 'country':
                    if($value == "")
                    $errors["country"]="please select a country";
                break;

                case 'op_type':
                    if($value == "")
                    $errors["op_type"]="please choose an option";
                    $op_type==$value;

                break;


               
                
                default:
                    # code...

                    if($counter > 4 && $value !== "" && $data["op_type"] == 2){
                        $v++;
                    }
                    break;
            }
            $counter++;
        }

        if($v < 4 && $data["op_type"] == 2 )
        $errors["err_msg"]="Please enter more then 3 configuration element";



        if(sizeof($errors) == 0){
            $email_sent = $this->email_pcgamer_query(array("infos"=>$data));

            if($email_sent)
                return redirect()->to(base_url()."/pcgamer/get_a_quote/request_sent/1/".$data["name"]);
            else
                return redirect()->to(base_url()."/pcgamer/get_a_quote/request_sent/0/".$data["name"]);
        }

        else{
            echo view("common/Header");
            echo view("Pc_getaquote",array("data"=>$this->request->getVar(),"errors"=>$errors));
            echo view("common/Footer");
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

        echo view("common/Header");
        echo view("Pc_getaquote_ak_receip",array("status"=>$status,"name"=>$name));
        echo view("common/Footer");
    }

    public function request_send_error($status,$name){

        echo view("common/Header");
        echo view("Pc_getaquote_ak_receip",array("status"=>$status,"name"=>$name));
        echo view("common/Footer");
    }

    public function email_pcgamer_query($idata){
        if($to = "yahia@3gelectronics.biz"){
            $subject = 'PC GAMER | Quote request from '.$idata['infos']["name"];
            $message = view('Quoterequest_email', $idata);
            $email = \Config\Services::email();
            $email->setTo($to);
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


}