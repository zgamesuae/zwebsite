<?php namespace App\Models;
 
use CodeIgniter\Model;
 
class AttributeModel extends Model{

    protected $userModel,$productModel;


    public function __construct(){
        parent::__construct();

        $this->userModel = model("App\Models\UserModel");
        $this->productModel = model("App\Models\ProductModel");

    }


    public function get_attribute_list(){
        $req="select * from product_attributes where status='Active'";
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res;
        }

        return array();
    }



    public function attributes_exist($array){
        $req="select count(attribute_id) as nbr from product_attributes where attribute_id in (".implode(",",$array).")";
        $res = $this->userModel->customQuery($req);

        if($res){
            if($res[0]->nbr == sizeof($array))
            return true;
        }

        return false;
    }


    public function get_attribute($id){
        $req = "select * from product_attributes where attribute_id=".$id;
        $res = $this->userModel->customQuery($req);

        if($res){
            return $res[0];
        }

        return null;
    }

    public function get_attribute_options($id){
        $req = "select * from attribute_options where attribute_id=".$id;
        $res = $this->userModel->customQuery($req);

        if($res && sizeof($res) > 0){
            return $res;
        }

        return null;
    }

    public function option_parent_attribute($option_id){
        $req = "select attribute_id from attribute_options where id=".$option_id;
        $res = $this->userModel->customQuery($req);

        if($res && $res !== null){
            return $res[0]->attribute_id;
        }

        return null;
    }

    public function is_valid_variation($variations , $parent){
        $b=true;
        if($this->productModel->product_exist($parent)){
            $parent_attributes = $this->productModel->get_attributes($parent);
            if(sizeof($parent_attributes) > 0){
                foreach($variations as $variation){
                    $tab = explode(":" , $variation);
                    // var_dump($tab , $parent_attributes);
                    if(!in_array($tab[0] , $parent_attributes) || $this->option_parent_attribute($tab[1]) !== $tab[0])
                    $b=false;
                }   
            }
            else 
            $b=false;

        }   

        else 
            $b = false;
        
        return $b;
    }

    public function variation_to_json($variations){
        $table = array();
        if(sizeof($variations) > 0 ){
            foreach($variations as $key=>  $variation){
                $tab = explode(":" , $variation);
                $table[$tab[0]] = $tab[1];
            }

        }

        return json_encode(array($table));
    }

    public function get_attribute_name($attribute_id , $arabic = false){
        $req = "select name,arabic_name from product_attributes where attribute_id=".$attribute_id;
        $res = $this->userModel->customQuery($req);
        if($res){
            if(!$arabic)
            return $res[0]->name;
            else
            return $res[0]->arabic_name;
        }

        return null;
    }

    public function get_attribute_id($name){
        $req = "select attribute_id from product_attributes where name ='".$name."'";
        $res = $this->userModel->customQuery($req);
        if($res){
            return $res[0]->attribute_id;
        }

        return null;
    }

    public function get_option_id($name){
        $req = "select id from attribute_options where name ='".$name."'";
        $res = $this->userModel->customQuery($req);
        if($res){
            return $res[0]->id;
        }

        return null;
    }

    public function get_option_name($id){
        $req = "select name from attribute_options where id ='".$id."'";
        $res = $this->userModel->customQuery($req);
        if($res){
            return $res[0]->name;
        }

        return null;
    }

    public function get_option($id){
        $req = 'select * from attribute_options where id ='.$id;
        // echo($req);
        $res = $this->userModel->customQuery($req);
        if($res){
            return $res[0];
        }

        return null;
    }












}