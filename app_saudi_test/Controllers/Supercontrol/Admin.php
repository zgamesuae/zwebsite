<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Admin extends \App\Controllers\BaseController
{

    function encrypt_password_callback($post_array, $primary_key = null){
        $post_array["password"] = base64_encode($post_array["password"]);
        return $post_array;
    }

    function decrypt_password_callback($value){
        $decrypted_password = base64_decode($value);
        return "<input type='text' name='password' value='$decrypted_password' />";
    }

    public function index(){

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("admin");
        $crud->setSubject("Admin", "Admin");

        // Access Check Start
        $access = $this->userModel->grant_access(); 
        if(is_array($access)){
            if ($access["addFlag"] == 0){
                $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                $crud->unsetEdit();
            }
            if ($access["deleteFlag"] == 0){
                // $crud->unsetDelete();
                // $crud->unsetDeleteMultiple();
            }
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
        }
        // Access Check End

        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["admin_id"] = date("ymdHis") . rand(0, 9);

            $stateParameters->data["password"] = base64_encode(
                $stateParameters->data["password"]
            );

            return $stateParameters;
        });

        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $stateParameters->data["password"] = base64_encode(
                $stateParameters->data["password"]
            );

            return $stateParameters;
        });

        $crud->callbackEditField("password", function (
            $fieldValue,
            $primaryKeyValue,
            $rowData
        ) {
            return '<input class="form-control" required name="password" value="' .
                base64_decode($fieldValue) .
                '"  />';
        });
        $crud->unsetFields(["created_at", "updated_at", "last_login"]);
        $crud->unsetColumns([
            "password",
            "created_at",
            "updated_at",
            "last_login",
        ]);
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );

        $crud->requiredFields(["password", "email", "status", "name"]);

        $crud->setRelationNtoN(
            "groups",
            "access_group_master",
            "admin_group",
            "admin_id",
            "group_id",
            "name"
        );
        $crud->unsetBootstrap();
        $crud->unsetJquery();
        $crud->unsetJqueryUi();

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

    private function _getGroceryCrudEnterprise($bootstrap = true,$jquery = true){
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

}
