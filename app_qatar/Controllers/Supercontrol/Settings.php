<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Settings extends \App\Controllers\BaseController
{
    public function index()
    {
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
          
          $crud->unsetAdd();
          $crud->unsetDelete();
          $crud->unsetDeleteMultiple();

        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("settings");
        $crud->setSubject("Settings", "Settings");

        $crud->requiredFields([
            "business_name",
            "address",
            "phone",
            "logo",
            "favicon",
        ]);
        $crud->columns(["business_name", "phone", "email", "address"]);
        $crud->setFieldUpload(
            "logo",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->setFieldUpload(
            "favicon",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );

        $output = $crud->render();
        return $this->_example_output($output);
    }

    private function _example_output($output = null)
    {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header("Content-Type: application/json; charset=utf-8");
            echo $output->output;
            exit();
        }
        echo view("/Supercontrol/Common/Header", (array) $output);
        echo view("/Supercontrol/Crud.php", (array) $output);
        echo view("/Supercontrol/Common/Footer", (array) $output);
    }

    private function _getDbData()
    {
        $db = (new \Config\Database())->default;
        return [
            "adapter" => [
                "driver" => "Pdo_Mysql",
                "host" => $db["hostname"],
                "database" => $db["database"],
                "username" => $db["username"],
                "password" => $db["password"],
                "charset" => "utf8",
            ],
        ];
    }

    private function _getGroceryCrudEnterprise(
        $bootstrap = true,
        $jquery = true
    ) {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

}
