<?php
namespace App\Controllers\Supercontrol\Zgstores;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class Stores extends \App\Controllers\BaseController {


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
        $crud->setTable('stores');
        $crud->setSubject('Stores', 'Stores');
        // $crud->setRelation('stores', 'blog_categories', 'name');

        $crud->setFieldUpload('image_1', 'assets/others/stores/', base_url() . '/assets/others/stores/');
        $crud->setFieldUpload('image_2', 'assets/others/stores/', base_url() . '/assets/others/stores/');
        $crud->setFieldUpload('image_3', 'assets/others/stores/', base_url() . '/assets/others/stores/');
        $crud->setFieldUpload('image_4', 'assets/others/stores/', base_url() . '/assets/others/stores/');
        $crud->setFieldUpload('image_5', 'assets/others/stores/', base_url() . '/assets/others/stores/');
        $crud->setFieldUpload('image_6', 'assets/others/stores/', base_url() . '/assets/others/stores/');

        $crud->displayAs("name" , "Store name");
        $crud->displayAs("location" , "Store location");
        // $crud->requiredFields(['name', 'address', 'phone' , 'location' , 'description', 'image_1', 'image_2', 'image_3']);
        $crud->requiredFields(['name', 'address', 'phone']);
        // $crud->setTexteditor(['description' , 'arabic_description']);
        // $crud->callbackBeforeInsert(function ($stateParameters)
        // {
        //     $stateParameters->data['blog_id'] = url_title($stateParameters->data['title'], '-', true) . '-' . time();
        //     return $stateParameters;
        // });




        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function store_agents(){
        

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
        $crud->setTable('store_agents');
        $crud->setSubject('Agents', 'Agents');
        $crud->setRelation('store_id', 'stores', 'name');


        $crud->setFieldUpload('picture', 'assets/others/agents', base_url() . '/assets/others/agents');
        $crud->displayAs("first_name" , "First name");
        $crud->displayAs("last_name" , "Last name");
        $crud->displayAs("picture" , "Profile picture");
        $crud->unsetFields(["created_at" , "updated_at"]);
        $crud->requiredFields(['first_name' , 'store_id']);
        $crud->callbackColumn('picture', function ($value, $row) {
            return "
            <div class='d-flex-row j-c-center'>
                <img style='max-width:100px' src='".base_url()."/assets/others/agents/".$value."'></img>
            </div>
            ";
        });

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function store_customers(){

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
        $crud->setTable('store_customers');
        $crud->setSubject('Customers', 'Customers');

        $crud->unsetAdd();

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function store_reviews(){

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
        $crud->setTable('store_reviews');
        $crud->setRelation('customer_id', 'store_customers', 'full_name');
        $crud->setRelation('agent_id', 'store_agents', '{first_name} - {last_name}');
        $crud->setRelation('store_id', 'stores', 'name');
        $crud->displayAs('customer_id','Customer name');
        $crud->displayAs('agent_id','Agent name');

        $crud->setSubject('Store reviews', 'Store reviews');

        $crud->setRead();
        $crud->unsetAdd();

        $output = $crud->render();
        return $this->_example_output($output);
    }



    // CRUD RENDER METHODS
    private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse)
        {
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
    // CRUD RENDER METHODS

}