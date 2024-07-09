<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Blog extends \App\Controllers\BaseController
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
        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("blog");
        $crud->setSubject("blog", "blog");
        $crud->setRelation("category", "blog_categories", "name");

        

        $crud->fieldType("blog_id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["slug"] = url_title(
                $stateParameters->data["title"],
                "-",
                true
            );
            return $stateParameters;
        });

        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["status", "title", "image"]);
        $crud->setTexteditor(["description", "arabic_description"]);

        // $crud->callbackEditField('description', function ($fieldValue, $primaryKeyValue, $rowData) {
        //   // Warning: Do NOT use this code
        //   return "<textarea class='form-control' id='blogwysiwyg' name='description'>".$fieldValue."</textarea>";
        // });

        // $crud->callbackEditField('arabic_description', function ($fieldValue, $primaryKeyValue, $rowData) {
        //   // Warning: Do NOT use this code
        //   return "<textarea class='form-control' id='arablogwysiwyg' name='arabic_description'>".$fieldValue."</textarea>";
        // });

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function categories()
    {
        $userModel = model("App\Model\UserModel");
        $parents = ["0" => "Root"];
        $req = "select * from blog_categories";
        $res = $userModel->customQuery($req);

        if (!is_null($res) && sizeof($res) > 0) {
            foreach ($res as $parent) {
                if ($parent->cat_parent == 0) {
                    $parents[$parent->id] = $parent->name;
                }
            };
        }
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
        $crud->setTable("blog_categories");
        $crud->setSubject("Blog categories", "Blog categories");
        $crud->fieldType("blog_id", "hidden");
        $crud->fieldType("cat_parent", "dropdown_search", $parents);

        $crud->unsetFields(["created_at"]);
        $crud->requiredFields(["name", "cat_parent"]);

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
