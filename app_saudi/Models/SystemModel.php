<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemModel extends Model{

    private $userModel;

    public function __construct(){
        parent::__construct();
        $this->userModel = model("App\Models\UserModel");
    }

    public function get_website_settings(){
        
        $req = "select * from settings";
        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res[0];
        }

        return null;
    }

    public function get_modul_menu($module_id , $user_id){
        
        
    }

    // Get Main parent menu elements
    function get_admin_parent_menu(){

        $req = "select * from menu where status='Active' AND parent_id = 0 order by title asc";
        $res = $this->userModel->customQuery($req);
        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];

    }

    // Get Main submenu
    public function get_admin_submenu($parent_id){

        $req= "select * from menu where parent_id=$parent_id and status='Active' order by title asc";
        $res = $this->userModel->customQuery($req);

        if(!is_null($res) && sizeof($res) > 0)
        return $res;

        return [];

    }




}