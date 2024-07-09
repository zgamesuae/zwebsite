<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Banner extends \App\Controllers\BaseController
{

    public function category()
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
        $crud->setTable("category_banner");
        $crud->setSubject("Category banner", "Category banner");
        $crud->setRelation("category_id", "master_category", "category_name", [
            "parent_id" => 0,
        ]);
        
        $crud->setFieldUpload(
            "image",
            "assets/others/category_banners_sa",
            base_url() . "/assets/others/category_banners_sa"
        );
        $crud->setFieldUpload(
            "mobile_image",
            "assets/others/category_banners_sa",
            base_url() . "/assets/others/category_banners_sa"
        );

        // Display Desktop banner image
        $crud->callbackColumn('image', function ($value, $row) {
            if (!is_null($value) || trim($value) !== "") {
                $html = '<img class="brand-logo" width="65px" src="' . base_url() . '/assets/others/category_banners_sa/' . $value . '">';
            } else {
                $html = '<img class="brand-logo" width="65px" src="' . base_url() . '/assets/uploads/noimg.png">';
            }
            return "<a href='".base_url()."/assets/others/category_banners/".$value."' target='blank'>$html</a>";
        });

        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["image", "status"]);
        $crud->addFields(['category_id', 'title', 'description' , 'link', 'location' , 'image' , 'start_date' , 'end_date' , 'status' , 'precedence']);
        $crud->editFields(['category_id', 'title', 'description' , 'link', 'location' , 'image' , 'start_date' , 'end_date' , 'status' , 'precedence']);

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function slider()
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
        $crud->setTable("home_slider");
        $crud->setSubject("home slider", "home slider");

        // Access END
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        // $crud->setFieldUpload('mobile_image', 'assets/uploads', base_url() . '/assets/uploads');
        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["image", "status"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function mobile()
    {
        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
        
        if(is_array($access)){
            if ($access["addFlag"] == 0){
                // $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                // $crud->unsetEdit();
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
        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("mobile_banner");
        $crud->setSubject("Mobile Banner", "Mobile Banner");
        
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->setFieldUpload(
            "mobile_image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["image", "status"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function index()
    {
        $access = $this->userModel->grant_access();

        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          if(is_array($access)){
            if ($access["addFlag"] == 0){
                // $crud->unsetAdd();
            }
            if ($access["editFlag"] == 0){
                // $crud->unsetEdit();
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
        // Access Check

        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("banner");
        $crud->setSubject("Banner", "Banner");
        
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->setFieldUpload(
            "mobile_image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );

        // Show Desktop banner image 
        $crud->callbackColumn('image', function ($value, $row) {
            if (!is_null($value) || trim($value) !== "") {
                $html = '<img class="brand-logo" width="95px" src="' . base_url() . '/assets/uploads/' . $value . '">';
            } else {
                $html = '<img class="brand-logo" width="95px" src="' . base_url() . '/assets/uploads/noimg.png">';
            }
            return "<a href='".base_url()."/assets/uploads/".$value."' target='blank'>$html</a>";
        });
        
        // Show Mobile banner image 
        $crud->callbackColumn('mobile_image', function ($value, $row) {
            if (!is_null($value) || trim($value) !== "") {
                $html = '<img class="brand-logo" width="95px" src="' . base_url() . '/assets/uploads/' . $value . '">';
            } else {
                $html = '<img class="brand-logo" width="95px" src="' . base_url() . '/assets/uploads/noimg.png">';
            }
            return "<a href='".base_url()."/assets/uploads/".$value."' target='blank'>$html</a>";
        });


        $crud->unsetFields(["created_at", "updated_at"]);
        $crud->requiredFields(["image", "status"]);
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
