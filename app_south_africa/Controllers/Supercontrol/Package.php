<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Package extends \App\Controllers\BaseController
{
    
    public function products()
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
        $crud->setTable("package_products");
        $crud->setSubject("package_products", "package_products");

        helper(["form", "url"]);
        $uri = service("uri");
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(4);
        }

        $crud->setRelation("product", "products", "name");

        $username = $uri1;
        $crud->callbackAddField("package", function () use ($username) {
            // You have access now at the extra custom variable $username
            return '  <input name="package" value="' .
                $username .
                '"  readonly  class="form-control" /> ';
        });
        $crud->fieldType("discount_percentage", "int");

        $crud->where([
            "package_products.package" => $uri1,
        ]);

        
        $crud->unsetFields(["created_at", "updated_at"]);

        $crud->requiredFields(["product", "discount_percentage", "status"]);

        $output = $crud->render();
        return $this->_example_output($output);
    }

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
        $crud->setTable("package");
        $crud->setSubject("Package", "Package");
        
        $crud->unsetFields(["created_at", "updated_at", "products"]);
        /*$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads'); */
        $crud->columns([
            "title",
            "products",
            "status",
            "start_date",
            "end_date",
        ]);
        $crud->callbackColumn("products", function ($value, $row) {
            return "<a href='/supercontrol/Package/products/" .
                $row->package_id .
                "' >Products</a>";
        });

        $crud->fieldType("package_id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["package_id"] =
                url_title($stateParameters->data["title"], "-", true) .
                "-" .
                time();

            return $stateParameters;
        });

        $crud->requiredFields(["title", "status", "start_date", "end_date"]);
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
