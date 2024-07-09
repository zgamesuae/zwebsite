<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;


class Variations extends \App\Controllers\BaseController {


    // protected $userModel,$productModel,$attributeModel;


    public function __construct(){
        // $this->userModel = model("App\Models\UserModel");
        // $this->productModel = model("App\Models\ProductModel");
        // $this->attributeModel = model("App\Models\AttributeModel");
    }

    public function index(){

        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                $crud->unsetDelete();
                $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check
        
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('attribute_options');
        $crud->setRelation("attribute_id","product_attributes","name");
        $crud->setSubject('Atributes', 'Product');
        // $crud->columns(['category', 'name', 'images', 'price', 'sku', 'status']);
        // $crud->columns(['category', 'name', 'images', 'price', 'sku', 'precedence' , 'status' , 'available_stock' , 'created_at']);
        $crud->defaultOrdering('attribute_options.name', 'asc');
        $output = $crud->render();
        return $this->_example_output($output);

    }

    public function retrieve_product_attributes($id){
        $attributes = $this->attributeModel->get_attribute_list();
        $product_attributes = $this->productModel->get_attributes($id);
        foreach($attributes as $key => $value){
            if(in_array($value->attribute_id , $product_attributes))
            $value->product = true;
            else
            $value->product = false;

        }

        return json_encode($attributes);
    }

    public function retrieve_p_attribute_variations($id){
        $html='<div class="row col-12">';
        $attributes = $this->productModel->get_attributes($id);
        // var_dump($attributes);
        if(sizeof($attributes) == 0)
        return json_encode(array("error"=>true , "message" => "Select variables for the parent product" , "content" => "" ));

        else{
            $i=1;
            foreach($attributes as $attribute){
                $attribute_options = $this->attributeModel->get_attribute_options($attribute);
                $html .= '<div class="col-3" style="">';

                if($attribute_options !== null){
                    $html .='
                    <label for="attribute_validation" class="col-auto form-label">'.$this->attributeModel->get_attribute_name($attribute).'</label>
                    <select class="form-control" name="attribute_variation[]" id="">';
                    foreach($attribute_options as $option){
                        $html .= '<option value="'.$attribute.":".$option->id.'">'.$option->name.'</option>';
                    }
                    $html .= '</select>';

                    $i++;
                }
                else{
                    $html .= "<p>Options missing for the parent attribute (".$this->attributeModel->get_attribute_name($attribute).") </p>";
                }
                $html .= '</div>';

            }

            return json_encode(array("error"=>false , "message" => "" , "content" => $html ));
        }
        
    }


    private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;

        }
        echo view('/Supercontrol/Common/Header', (array)$output);
        echo view('/Supercontrol/Crud.php', (array)$output);
        echo view('/Supercontrol/Common/Footer', (array)$output);
    }

    private function _getDbData() {
        $db = (new \Config\Database())->default;
        return ['adapter' => ['driver' => 'Pdo_Mysql', 'host' => $db['hostname'], 'database' => $db['database'], 'username' => $db['username'], 'password' => $db['password'], 'charset' => 'utf8']];
    }

    private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

    private function update_attrbite_sections(){
        var_dump($_GET);
    }
}