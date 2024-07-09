<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class AccessModules extends \App\Controllers\BaseController
{
    public function index()
    {
        $access = $this->userModel->grant_access(); 

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("access_modules");
        $crud->setSubject("Access modules", "Access modules");

        // Checking access user Start ################
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
        // Checking Access user END##############

        $crud->addFields([
            "access_modules_id",
            "section_name",
            "segment_1",
            "segment_2",
            "segment_3"
        ]);
        //   $crud->requiredFields(['access_modules_id', 'section_name','segment_1']);
        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->uniqueFields(["access_modules_id"]);
        $crud->columns([
            "section_name",
            "segment_1",
            "segment_2",
            "segment_3",
            "groups_assigned",
        ]);
        $crud->fieldType("access_modules_id", "hidden");
        $crud->requiredFields(["section_name", "segment_1"]);
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["access_modules_id"] =
                ucwords($stateParameters->data["segment_3"]) .
                "" .
                str_replace(
                    " ",
                    "",
                    ucwords($stateParameters->data["section_name"])
                );
            return $stateParameters;
        });
        $crud->setRelationNtoN(
            "groups_assigned",
            "groups_assigned",
            "admin_group",
            "access_modules_id",
            "group_id",
            "name"
        );
        $output = $crud->render();
        return $this->_example_output($output);
    }

    private function _example_output($output = null){
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header("Content-Type: application/json; charset=utf-8");
            echo $output->output;
            exit();
        }
        echo view("/Supercontrol/Common/Header", (array) $output);
        echo view("/Supercontrol/Crud.php", (array) $output);
        echo view("/Supercontrol/Common/Footer", (array) $output);
    }

    private function _getDbData(){
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
    ){
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
}
