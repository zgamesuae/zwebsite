<?php 
namespace App\Controllers\Notifications;
use App\Controllers\BaseController;

class Tabby extends BaseController{

    public function listener(){

        $condition = (strtolower($this->request->getMethod()) == "post");

        if($condition || true){
            $data = $this->request->getJSON();
            if(!is_null($data)){
                switch ($data->status) {
                    case 'authorized':
                        # code...
                        
                        $transaction = $this->orderModel->get_transaction($data->order->reference_id);
                        
                        if(!is_null($transaction) && $transaction->transaction_message == "CREATED" ){
                            $user_id = $transaction->customer;
                            $res = $this->userModel->customQuery("select count(order_id) as nb from orders where order_id='".$data->order->reference_id."'");
                            $bool = (sizeof($res) > 0 && $res[0]->nb == 0) ? $this->orderModel->online_payment_order_process(base64_encode($data->order->reference_id) , $user_id) : false;
                            if($bool)
                            $this->orderModel->send_email("yahia@3gelectronics.biz" , "SAUDI TABBY WEBHOOK" , "order Created!!!!");

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

    public function webhook_register_url(){

        $url = base_url()."/notifications/Tabby/test";
        $webhook = $this->tabbyModel->register_webhook($url);
        var_dump($webhook);

    }

    public function webhook_update(){

        $url = base_url()."/notifications/tabby/test";
        $id = "1633d0b1-e375-4de3-b0ea-ad77fe5c0678";
        $webhook = $this->tabbyModel->update_webhook($id , $url);
        var_dump($webhook);

    }
    
    
    public function webhooks(){

        $webhooks = $this->tabbyModel->retreive_webhooks();
        var_dump($webhooks);

    }

}