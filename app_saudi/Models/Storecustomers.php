<?php

namespace App\Models;

use CodeIgniter\Model;

class Storecustomers extends Model {
    protected $userModel;
    public function __construct(){
        $this->userModel = model("App\Model\UserModel");
    }
   
    public function get_store_customer($email){
        $req = "select * from store_customers where email='".$email."'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res)>0 && isset($res[0]->id))
        return $res[0];

        return false;
    }

    public function save_store_customer($data){
        $res = $this->userModel->do_action("store_customers","","","insert",["full_name"=>$data["cr-name"],"email"=>$data["cr-email"],"phone"=>$data["cr-phone"]],"");
        // var_dump($res);die();

        return $res;
    }

    public function get_agent($id){
        $req = "select * from store_agents where id=".$id."";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res)>0 && isset($res[0]->id))
        return $res[0];

        return false;
    }

    public function receip_get_store_customer_review($receip){
        $req = "select * from store_reviews where receip_number='".$receip."'";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res)>0 && isset($res[0]->id))
        return $res[0];

        return null;
    }

    public function save_store_customer_review($data){

        $customer = $this->get_store_customer($data["cr-email"]);
        $agent = $this->get_agent($data["cr-agentid"]);

        if($customer !== false)
        $customer_id = $customer->id;
        else
        $customer_id = $this->save_store_customer($data);

        if($agent !== false){
            
            $agent_id = $agent->id;
            $review = [
                "customer_id"=> $customer_id,
                "agent_id"=> $agent_id,
                "store_id"=> "1",
                "rate"=> $data["cr-rating"],
                "description"=> $data["cr-more"],
                "receip_number"=> $data["cr-order_nbr"],

            ];
            $res = $this->userModel->do_action("store_reviews" ,"" ,"" ,"insert" ,$review ,"");
            // var_dump($review , $res);die();

            if($res && $res!==false)
            return true;

        }

        return false;
        


    }

    public function get_store_agents($store_id){
        $req = "select * from store_agents where status = 'Active' AND store_id=".$store_id;
        $res = $this->userModel->customQuery($req);

        if(isset($res) && !is_null($res) && sizeof($res) > 0){
            return $res;
        }
        return null;
    }
    
    public function get_store_cities(){
        $req = "select city from stores group by city order by country desc,city";
        $this->userModel->set_db_group("default_uae");
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            return $res;
        }

        return false;
    }


    public function get_city_stores($city){
        $req = "select * from stores where city='".$city."'";
        $this->userModel->set_db_group("default_uae");
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            return $res;
        }

        return false;
    }
    
    public function get_store($id){
        $req = "select * from stores where id=".$id;
        $this->userModel->set_db_group("default_uae");
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            return $res[0];
        }
        return false;
    }



    


}