<?php 
namespace App\Controllers\Notifications;
use App\Controllers\BaseController;

class Ezpin extends BaseController{

    public function listener(){

        $condition = (strtolower($this->request->getMethod()) == "post");

        if($condition || true){
            $data = $this->request->getJSON();
            if(!is_null($data) && !is_null($data->confidential_key) && $data->confidential_key == $this->ezpinModel->confidential_key){
                // Do Action Here...
                $this->ezpinModel->ezpin_update_order_status(["ez_order_id" => $data->order_id , "status_text" => ($data->status == 1) ? "accept" : "reject"]);
            }
            
        }


    }
    
}