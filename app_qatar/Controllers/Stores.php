<?php
namespace App\Controllers;
class Stores extends BaseController{
    
    
    public function index(){
        echo view("stores/review");
    }
    
    public function agent_review(){
        $storeCustomers = model("App\Model\Storecustomers");
        if($this->request->getMethod()=="post"){
            helper(["form", "url"]);
            $validation = \Config\Services::validation();
            $rules = [
                "cr-agentid" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Please select an agent"
                    ]
                ],

                "cr-name" => [
                    "rules" => "required",
                    "errors" => [
                        "required" => "Name field is required"
                    ]
                ],
                "cr-email" => [
                    "rules" => "required|valid_email",
                    "errors" => [
                        "required" => "E-mail field is required",
                        "valid_email" => "Please enter a valid email address"
                    ]
                ],
                "cr-phone" => [
                    "rules" => "required|numeric",
                    "errors" => [
                        "required" => "Phone field is required",
                        "numeric" => "Phone number must contain only numbers"
                    ]
                ],

                "cr-order_nbr" => [
                    "rules" => "required|alpha_numeric_punct",
                    "errors" => [
                        "required" => "Invoice number field is required",
                        "numeric" => "The invoice number is not correct"
                    ]
                ],

            ];

        
            $validation->setRules($rules);
            $form_validation = $this->validate($rules);
            // var_dump($this->request->getVar());die();

            if(!$form_validation){
                // var_dump($validation->getErrors());
                    echo view("stores/review" , ["errors" => $validation->getErrors() , "success" => false , "s_id" => $this->request->getVar("cr-storeid")]);
            }

            else if($storeCustomers->save_store_customer_review($this->request->getVar()) == true){
                echo view("stores/review" , ["success" => true , "s_id" => $this->request->getVar("cr-storeid")]);
                // var_dump($this->request->getVar() , $validation->getErrors() , $this->validate($rules));
            }

            else{
                var_dump($storeCustomers->save_store_customer_review($this->request->getVar()));
                echo view("stores/review" , ["success" => false , "internal" => "Something is wrong, please review again!"]);
            }

        
        }
    
    }

    public function get_store_info($store_id){
        $storeModel = model("App\Model\Storecustomers");
        $r = $storeModel->get_store($store_id);

        $store = [ 
            "store_detail" => "", 
            "store_title" => "", 
            "status" => false
        ];

        if($r && !is_null($r) && (!is_null($r->location) || !is_null($r->description) || !is_null($r->image_1))){
            $store["status"] = true;
            $store["store_detail"] = view("stores/storedetails" , ["store" => $r]);
            $store["store_title"] = lg_put_text($r->name , $r->arabic_name , false);

        }
        
        return json_encode($store);
    }

    public function ask_in_store($code){
        $countries = [
            "uae" => "United Arabe Emirates",
            "ksa" => "Saudi Arabia",
            "oma" => "Oman",
            "qat" => "Qatar",
        ];

        $cities = $this->storeModel->get_store_cities($countries[$code]);
        echo json_encode(["html"=>view("forms/Ask_in_store" , ["country"=> $code , "cities" => $cities])]);
        
    }

    public function store_info($id){
        $htlml="";
        $store = $this->storeModel->get_store($id);
        if(!is_null($store) && !empty($store))
        $html= '
            <div class="col-12 my-3">
                <h4>Call us:</h4>
                <p>
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:'.$store->phone.'">
                        <span>'.$store->phone.'</span>
                    </a>
                </p>
            </div>

            <div class="col-12">
                <h4>Store location:</h4>
                <div class="mt-2 col-12 px-0">
                    '.$store->location.'
                </div>
            </div>
        ';

        echo $html;

    }
}