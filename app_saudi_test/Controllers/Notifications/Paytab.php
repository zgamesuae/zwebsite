<?php 
namespace App\Controllers\Notifications;
use App\Controllers\BaseController;

class Paytab extends BaseController{

    public function listener(){

        $condition = (strtolower($this->request->getMethod()) == "post");

        if($condition || true){
            $data = $this->request->getJSON();
            if(!is_null($data) && $this->paytabModel->paytab_verify_request(filter_input_array(INPUT_POST))){
                switch ($data->respMessage) {
                    case 'Authorised':
                        # code...
                        
                        $transaction = $this->orderModel->get_transaction($data->cartId);
                        
                        if(!is_null($transaction) && $transaction->transaction_message == "CREATED" ){
                            $user_id = $transaction->customer;
                            $res = $this->userModel->customQuery("select count(order_id) as nb from orders where order_id='".$data->order->reference_id."'");
                            $bool = (sizeof($res) > 0 && $res[0]->nb == 0) ? $this->orderModel->online_payment_order_process(base64_encode($data->order->reference_id) , $user_id) : false;
                            if($bool)
                            $this->orderModel->send_email("yahia@3gelectronics.biz" , "SAUDI PAYTAB WEBHOOK" , "order Created!!!!");

                        }

                        else if(!is_null($transaction) && $transaction->transaction_message == "AUTHORIZED"){
                            if(!is_set($data->captures) || sizeof($data->capture) == 0)
                            $this->tabbyModel->tabby_capture_request($transaction->ref , $data->amount);
                        }
                        break;
                    
                    default:
                        # code...

                        break;
                }
                    
            }
            
        }


    }

}