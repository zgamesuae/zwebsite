<?php
namespace App\Controllers\Supercontrol\tournaments;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class Tournaments extends \App\Controllers\BaseController {

    public function registrations(){
        $access = $this->userModel->grant_access();

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable('tournament_register');
        $crud->setSubject('Registrations', 'Registrations');
        // $crud->setRelation('store_id', 'stores', 'name');

        if ($access["addFlag"] == 0)
        {
            $crud->unsetAdd();
        }
        if ($access["editFlag"] == 0)
        {
            $crud->unsetEdit();
        }
        if ($access["deleteFlag"] == 0)
        {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($access["viewFlag"] == 0)
        {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit;
        }

        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->unsetDelete();
        $crud->unsetDeleteMultiple();


        $crud->displayAs("first_name" , "First name");
        $crud->displayAs("last_name" , "Last name");
        $crud->displayAs("date_birth" , "Date of birth");
        $crud->displayAs("title" , "Tournament title");

        $crud->unsetColumns(["c_code"]);
        // $crud->requiredFields(['first_name', 'last_name', 'picture' , 'store_id']);

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