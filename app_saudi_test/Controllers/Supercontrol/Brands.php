<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Brands extends \App\Controllers\BaseController
{
    protected $brandModel;

    public function __construct()
    {
        $this->brandModel = model("\App\Models\BrandModel");
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
        $crud->setTable("brand");
        $crud->setSubject("Brands", "Brands");
        

        // Set the slug for the brand
        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $stateParameters->data["slug"] = $this->brandModel->createurl(
                $stateParameters->data["slug"]
            );
            return $stateParameters;
        });

        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["slug"] = $this->brandModel->createurl(
                $stateParameters->data["slug"]
            );
            return $stateParameters;
        });

        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["title", "status"]);
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

    public function export()
    {
        // $category_model=model("App\Models\Category","false");

        // $products= $category_model->customQuery("select sku,name,price,available_stock,brand,color,age,discount_percentage,category from products where status='Active'");
        // $products= $category_model->customQuery("select * from brand");

        // Access Check
          $access = $this->userModel->grant_access();
          if(is_array($access)){
            if ($access["viewFlag"] == 0){
                return view("errors/html/permission_denied");
                exit;
            }
          }
        // Access Check

        $brandModel = model("App\Models\BrandModel");
        $userModel = model("App\Models\UserModel");
        $products = $userModel->customQuery(
            "select * from brand where status='Active'"
        );

        // echo(ROOTPATH."assets\exports\products.csv");die();
        $path = ROOTPATH . "assets/exports";
        if (!file_exists($path)) {
            $b = mkdir($path);
        }

        $csv = [["TITLE", "SLUG", "IMAGE", "URL"]];
        foreach ($products as $key => $value) {
            # code...

            $ligne = [
                /* TITLE */ $value->title,
                /* SLUG */ $value->slug,
                /* IMAGE */ base_url() . "/assets/uploads/" . $value->image,
                /* URL */ $brandModel->get_brand_url($value->id),
            ];

            array_push($csv, $ligne);
        }

        $file_name = "brands_export" . rand(555, 105000) . ".csv";
        $fp = fopen($path . "/" . $file_name, "a");

        foreach ($csv as $fields) {
            fputcsv($fp, $fields, ",");
        }

        fclose($fp);

        // return redirect()->to(site_url('/supercontrol/Products'));
        return redirect()->to(base_url() . "/assets/exports/" . $file_name);
    }
}
