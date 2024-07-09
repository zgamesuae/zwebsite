<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table;
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
        // OR $this->db = db_connect();
    }

    public function insert_data($data = [], $table)
    {
        $this->db->table($table)->insert($data);
        return $this->db->insertID();
    }

    public function do_action(
        $table_name,
        $id,
        $fieldname,
        $action,
        $data,
        $limit
    ) 
    {
        if ($action == "get") {
            if ($id != "" && $fieldname != "" && $data == "" && $limit == "") {
                $this->db->select("*");
                $this->db->from($table_name);
                $this->db->where($fieldname, $id);
                $this->db->limit($limit);
            } else {
                $this->db->select("*");
                $this->db->from($table_name);
                $this->db->limit($limit);
            }
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
        if ($action == "insert") {
            $return = $this->db->table($table_name)->insert($data);

            if ((bool) $return === true) {
                return $this->db->insertID();
            } else {
                return $return;
            }
        }
        if ($action == "update") {
            $return = $this->db
                ->table($table_name)
                ->where($fieldname, $id)
                ->update($data);

            return $return;
        }
        if ($action == "delete") {
            $return = $this->db
                ->table($table_name)
                ->where($fieldname, $id)
                ->delete();

            return $return;
        }
    }

    public function update_data($id, $v, $data = [], $table)
    {
        $this->db->table($table)->update($data, [
            "admin_id" => 2106122357055,
        ]);
        return $this->db->affectedRows();
    }

    public function delete_data($id, $table)
    {
        return $this->db->table($table)->delete([
            "id" => $id,
        ]);
    }

    public function get_all_data($table)
    {
        $query = $this->db->query("select * from " . $table);
        return $query->getResult();
    }

    public function customQuery($sql)
    {
        $query = $this->db->query($sql);
        // if ($query) {
        //     return $query->getNumRows() > 0 ? $query->getResult() : null;
        // } else {
        //     return null;
        // }
        
        if($query){
            if(!is_bool($query))
            return $query->getNumRows() > 0 ? $query->getResult() : null;
            else 
            return $query;

        }
        else{
            return null;
        }
    }

    public function customQueryy($sql)
    {
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_user_email($user_id){

        $req="select email from users where user_id='".$user_id."'";
        $res=$this->customQuery($req);

        if($res)
        return $res[0]->email;
        else return false;
    }

    public function get_user($id){
        $user = $this->customQuery("select * from users where user_id='".$id."' and status='Active'");
        if($user){
            return $user[0];
        }

        return false;
    }

    public function get_user_image($userid){
        $req = "select image from users where user_id='".$userid."'";
        $image = $this->customQuery($req);

        if($image){
            
            if(trim($image[0]->image) !== "")
            return "assets/uploads/".$image[0]->image;

        }
        return "assets/img/user_avatar.jpg";

        // return false;
    }
    
    public function is_registred($user_id){
        $bool = false;
        $req="select user_type,email_verification from users where user_id='".$user_id."'";
        $res = $this->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0){
            if($res[0]->user_type == "Normal" && $res[0]->email_verification == "Verified")
            $bool = true;
        }

        return $bool;
    }
    
    public function grant_access($seg_3 = true , $uris = []){
        
        //   Access Start
        // Checking access user Start ################
        $session = session();
        $uri = service('uri');
        @$admin_id = $session->get('adminLoggedin');

        $access = array(
          "addFlag" => 0,
          "editFlag" => 0,
          "deleteFlag" => 0,
          "accessFlag" => 0,
          "viewFlag" => 0,
        );

        // Setting the Segments values
        $uri1 = $uri2 = $uri3 = Null;
        if(sizeof($uris) == 0){
            if (count(@$uri->getSegments()) > 1)
            {
                $uri1 = @$uri->getSegment(2);
            }
            if (count(@$uri->getSegments()) > 2)
            {
                $uri2 = @$uri->getSegment(3);
            }
            if (count(@$uri->getSegments()) > 3)
            {   
                $uri3 = @$uri->getSegment(4);
            }
        }
        else{
            $uri1 = (isset($uris[0]) && !is_null($uris[0])) ? $uris[0] : null;
            $uri2 = (isset($uris[1]) && !is_null($uris[1])) ? $uris[1] : null;
            $uri3 = (isset($uris[2]) && !is_null($uris[2])) ? $uris[2] : null;
        }

        if (@$admin_id && false){
            $sql = "select * from access_group_master where  admin_id='$admin_id' "; // Get the user groups
            $access_group_master = $this->customQuery($sql);
            if ($access_group_master)
            {
                foreach ($access_group_master as $k1 => $v1)
                {
                    $group_id = $v1->group_id;
                    $sql = "select * from groups_assigned where  group_id='$group_id' "; // Get The groups modules
                    $groups_assigned = $this->customQuery($sql);

                    if ($groups_assigned)
                    {
                        foreach ($groups_assigned as $k2 => $v2)
                        {
                            $access_modules_id = $v2->access_modules_id;
                            $sql = "select * from access_modules where  access_modules_id='$access_modules_id' "; // Get The Modules Segments (URL)
                            $access_modules = $this->customQuery($sql);
                            if ($access_modules[0]->segment_1 == $uri1)
                            {
                                $access["viewFlag"] = 1;
                                if ($access_modules[0]->segment_3 == 'add')
                                {
                                    $access["addFlag"] = 1;
                                }
                                if ($access_modules[0]->segment_3 == 'edit')
                                {
                                    $access["editFlag"] = 1;
                                }
                                if ($access_modules[0]->segment_3 == 'delete')
                                {
                                    $access["deleteFlag"] = 1;
                                }
                            }
                        }
                    }
                }
            }
        }

        if($admin_id){
            // var_dump($this->is_admin_in_groups($admin_id , $this->get_module_groups($this->get_module_id_from_uri([$uri1 , $uri2 , "delete"]))));die();
            // get admin groups
            $module_id = $this->get_module_id_from_uri([$uri1 , $uri2 , $uri3] , $seg_3);

            // get module's affected groups
            $groups = $this->get_module_groups($module_id); 

            // Check if Admin belongs the One of the Module's Groups
            $permission = $this->is_admin_in_groups($admin_id , $groups);

            $access = array(
                "addFlag" => ($this->is_admin_in_groups($admin_id , $this->get_module_groups($this->get_module_id_from_uri([$uri1 , $uri2 , "add"] , $seg_3)))) ? 1 : 0,
                "editFlag" => ($this->is_admin_in_groups($admin_id , $this->get_module_groups($this->get_module_id_from_uri([$uri1 , $uri2 , "edit"] , $seg_3)))) ? 1 : 0,
                "deleteFlag" => ($this->is_admin_in_groups($admin_id , $this->get_module_groups($this->get_module_id_from_uri([$uri1 , $uri2 , "delete"] , $seg_3)))) ? 1 : 0,
                "accessFlag" => ($permission) ? 1 : 0,
                "viewFlag" => ($permission) ? 1 : 0,
            );

            //   var_dump($access);die();
        }

        return $access;
        
    }

    // Get an Admin Module ID 
    public function get_module_id_from_uri(array $uri , $seg_3){
        if(sizeof($uri) > 0){
            $i = 1;
            $req = "select access_modules_id from access_modules where ";
            foreach ($uri as $segment) {
                # code...
                
                $req .= (is_null($segment)) ? "(segment_$i is NULL OR segment_$i = 'index') " : "segment_$i = '$segment' ";

                if($i==2 && !$seg_3){
                    $req .= "AND (segment_3 is NULL OR segment_3 = 'index')";
                    break;
                }
                $req .= ($i < sizeof($uri)) ? "AND " : "";
                $i++;
            }
            $res = $this->customQuery($req);

            if(!is_null($res) && sizeof($res) > 0)
            return $res[0]->access_modules_id;
        }

        return null;

    }

    // Get Module's affected groups
    public function get_module_groups($module_id){
        $groups = [];
        if(!is_null($module_id)){
            $req = "select group_id from groups_assigned where access_modules_id ='$module_id' group by group_id";
            $res = $this->customQuery($req);

            if(!is_null($res) && sizeof($res) > 0){
                foreach ($res as $group) {
                    # code...
                    array_push($groups , $group->group_id);
                }
            }
        }

        return $groups;

    }

    // Check if admin belongs to a module's Groups
    public function is_admin_in_groups($admin_id , $groups){
        $status = false;
        $req = "select group_id from access_group_master where admin_id = '$admin_id' group by group_id";
        $res = $this->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0){
            foreach ($res as $group) {
                # code...
                if(in_array($group->group_id , $groups))
                $status = true;
            }
        }

        return $status;

    } 

    public function get_user_phone($user_id){

        $req="select phone from users where user_id='".$user_id."'";
        $res=$this->customQuery($req);

        if($res)
        return $res[0]->phone;
        else return false;
    }

    public function get_user_address($user_id){
        $req = "select * from user_address where user_id='".$user_id."' AND status='Active'";
        $res = $this->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res[0];
        }

        return false;
    }
    
    public function get_user_addresses($user_id){
        $req = "select * from user_address where user_id='".$user_id."' order by created_at desc";
        $res = $this->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res;
        }

        return [];
    }

    public function save_user_address($user_id , $data){
        $validation = \Config\Services::validation();
        $validation->setRules([
            'street' => ['label' => 'street', 'rules' => 'required'],
            'apartment_house' => ['label' => 'Appartement', 'rules' => 'required'],
            'address' => ['label' => 'address', 'rules' => 'required'],
            'city' => ['label' => 'city', 'rules' => 'required'],
        ]);

        if($validation->run($data)){
            $uaddress["user_id"] = $user_id;
            $uaddress["name"] = $data["name"];
            $uaddress["street"] = $data["street"];
            $uaddress["apartment_house"] = $data["apartment_house"];
            $uaddress["city"] = $data["city"];
            $uaddress["address"] = $data["address"];
            $uaddress["status"] = "Active";
            $res = $this->do_action(
                "user_address",
                "",
                "",
                "insert",
                $uaddress,
                ""
            );
            return $this->get_user_address($user_id);
        }
        else 
        return false;
    }

    public function save_user_phone($user_id , $phone){
        $validation = \Config\Services::validation();
        $validation->setRules([
            'order_phone' => ['label' => 'Phone', 'rules' => 'required|regex_match[/\d+/]'],
        ]);

        if($validation->run(["order_phone" => $phone])){
            $res = $this->do_action("users", $user_id, "user_id" , "update", ["phone" => $phone], "");
            if($res)
            return $phone;
        }

        return false;
    }
    public function user_has_address($id){
        $b = false;
        $session = session();
        $user_id = $session->get("userLoggedin");
        if($user_id){
            $res = $this->customQuery("select count(*) as nbr from user_address where user_id='".$user_id."' AND address_id=".$id."");
            if($res && $res[0]->nbr > 0)
            $b = true;
        }

        return $b;
    }

    public function user_social_signup($email , $name , $image , $provider){

        if(trim($email) !== "" ){
            $p["email"] = $email;
            $p["name"] = $name;
            $p["image"] = $image;
            $p["user_id"] = time();
            $p["status"] = "Active";
            $p["email_verification"] = "Verified";
            $p["social_inscription"] = $provider;
            $p["token"] = md5($p["user_id"]);
            $p["token_created_at"] = date("Y-m-d H:i:s");

            $this->do_action("users" , "" , "" , "insert" , $p , "");

            return $this->get_user_infos_by_email($email , true);
        }

        return false; 
    }

    public function is_user_active($user_id){
        $req = "select status from user where user_id = '$user_id'";
        $res = $this->customQuery($req);
        if($res[0]->status == "Active")
        return true;

        return false;
    }

    public function get_user_infos($user_id){
        $req = "select * from users where user_id='$user_id'";
        $res = $this->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res[0];

        return null;
    }

    public function get_user_infos_by_email($email , $active = true , $guest = false){

        $req = "select * from users where email='$email'";
        $req .= ($active) ? " and status = 'Active'" : " and status = 'Inactive'";
        $req .= ($guest) ? " and user_type = 'Guest'" : " and user_type = 'Normal'";

        $res = $this->customQuery($req);
        if($res && !is_null($res))
        return $res[0];

        return null;
    }

    public function user_has_password($user_id){
        $sql = "select password from users where user_id='$user_id'";
        $res = $this->customQuery($sql);

        if($res && !is_null($res))
        return (trim($res[0]->password) !== "") ? true : false;

        return false;
    }

    // Customer Loyalty Level
    public function get_customer_loyalty_level($user_id , $scale = false){
        $loyalty_level = 0;
        $loyalty_scale = 200;
        $req = "select count(order_id) as nbr_orders,sum(total) as purchases from orders where user_id ='$user_id' and payment_status='Paid'";
        $res = $this->customQuery($req);
        if(!is_null($res) && $res[0]->nbr_orders > 0){
            $loyalty_level = ($scale) ? ($res[0]->purchases / $loyalty_scale) / $res[0]->nbr_orders : $res[0]->nbr_orders;
        }

        return (float) $loyalty_level;

    }
}
