<?php

namespace App\Controllers\Kgaming;
use App\Controllers\BaseController;


class Review extends BaseController{



    public function index($product_id=null , $errors = [] , $form = []){

        $product = (!is_null($product_id)) ? $this->productModel->get_product_infos($product_id) : null;
        if(!is_null($product)){
            $product_image = $this->productModel->get_product_image($product_id,false,false);
            $product->brand = $this->brandModel->_getbrandname($product->brand);
            $product->type = $this->productModel->get_product_types($product->type);
            $product->url = $this->productModel->getproduct_url($product_id);
        }

        // Stores
        $store_cities = $this->storeModel->get_store_cities();

        // var_dump($oth , $product);die();
        $data = [
            "product" => $product , 
            "image" => $product_image , 
            "cities" => $store_cities , 
            "storeModel" => $this->storeModel,
        ];

        if(sizeof($form) > 0)
        $data["data"] = $form;

        if(sizeof($errors) > 0)
        $data["errors"] = $errors;

        echo view("products/Product_review" , $data);

    }


    public function submit(){

        // var_dump($this->request->getVar());die();

        $validation = \Config\Services::validation();
        $rules = [

            "barcode" => [
                "rules" => "required|numeric",
                "errors" => [
                    "required" => "Please enter product barecode",
                    "numeric" => "Please enter a valid barcode",
                ]
            ],
            "product_name" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Please enter product barecode",
                ]
            ],
            "rating" => [
                "rules" => "required|in_list[1,2,3,4,5]",
                "errors" => [
                    "required" => "Please rate this product by selecting the stars",
                    "in_list" => "Rating out of range" 
                ]
            ],

            "order_number" => [
                "rules" => "required|alpha_numeric",
                "errors" => [
                    "required" => "Order Number is required",
                    "alpha_numeric" => "Enter valid order number" 
                ]
            ],

            // "store" => [
            //     "rules" => "in_list[United Arab Emirates,Qatar,Saudi Arabia,Oman]",
            //     "errors" => [
            //         "required" => "Store is required",
            //         "in_list" => "Store not recognized" 
            //     ]
            // ],

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

            "email" => [
                "rules" => "required|valid_email",
                "errors" => [
                    "required" => "E-mail address is required",
                    "valid_email" => "Enter a valid e-mail address"
                ]
            ],

            "phone" => [
                "rules" => "required|regex_match[/^\+\d{2,3}\d{9}/]",
                "errors" => [
                    "required" => "Phone Number is required",
                    "regex_match" => "Enter a valid phone number ex:+971520000000",
                ]
            ],

            "remark" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Please tell us more details",
                ]
            ],
            
        ];

        $validation->setRules($rules);
        $form_validation = $this->validate($rules);

        // var_dump($validation->geterrors() , $this->request->getVar());

        if($form_validation){
            $review = $this->request->getVar();
            // $product = $this->productModel->get_product_infos($review["product"]);
            // $review["product"] = $product->name;
            // var_dump($review , $product);

            /**
             * Save The review in DB
             * 
             * Code Here...
             * 
             * End Save The review in DB
             */

            
            /**
            * Send Review By Email
            */

            if(true){
                $subject = 'KGaming Product Review | ' . $review["product_name"];
                $message = view("emails/Review_notification" , ["review" => $review]);
                $email = \Config\Services::email();
                $email->setTo("yahia@3gelectronics.biz");
                $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
                $email->setSubject($subject);
                $email->setMessage($message);
                if ($email->send() || true) {
                    $data = array_merge($this->request->getVar() , ["success" => true]);
                    return $this->index($this->request->getVar("product") , [] , $data);
                } 
                else {
                    $data = $email->printDebugger(['headers']);
                    return false;
                }
            }
             
            /**
             * End Send Review By Email
             */
        }
        else{
            return $this->index(null , $validation->geterrors() , $data = $this->request->getVar());
        }
    }



}