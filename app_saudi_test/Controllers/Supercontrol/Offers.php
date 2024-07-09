<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Offers extends \App\Controllers\BaseController{


    public function index()
    {
        // Acces Check
            $access = $this->userModel->grant_access();
            $crud = $this->_getGroceryCrudEnterprise();
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
        // Acces Check
                
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("offers");
        $crud->setSubject("Offer", "Offers");

        // Conditions relation
        $crud->setRelationNtoN(
            "conditions",
            "offer_condition_relation",
            "offer_conditions",
            "offer_id",
            "condition_id",
            "description"
        );

        // Prizes relation
        $crud->setRelationNtoN(
            "prizes",
            "offer_prizes",
            "prizes",
            "offer_id",
            "prize_id",
            "description"
        );
        
        $crud->unsetFields(["created_at", "updated_at"]);

        // Required Fields
        $crud->requiredFields(["offer_title", "offer_arabic_title" , "level" , "_relation" , "conditions"]);

        // Displays
        $crud->displayAs("_relation" , "Conditions Apply");
        $crud->displayAs("level" , "Offer apply on");
        $crud->displayAs("get_qty" , "Get Quantity");

        // Validations
        \Valitron\Validator::addRule('requiredIf', function($field, $value, array $params, array $fields) {

            switch (true) {
                case ($field == 'get_qty'):
                    # code...

                    if($fields["level"] == "Product" && empty(trim($fields["discount_value"])) && empty(trim($fields["discount_type"]))){
                        return ((trim($value) !== ""));
                    }
        
                    else
                    return true;

                break;

                case ($field == 'discount_type' || $field == 'discount_value'):
                    # code...

                    if($fields["level"] == "Cart" && sizeof($fields["prizes"]) > 0 ){
                        return ((trim($value) !== ""));
                    }
        
                    else
                    return true;

                break;

                case ($field == 'prizes'):
                    # code...

                    if($fields["level"] == "Cart" && trim($fields["discount_value"]) == "" && trim($fields["discount_type"]) == ""){
                        return ((trim($value) !== ""));
                    }
        
                    else
                    return true;

                break;

                default:
                    # code...
                    break;
            }
        
        }, 'must be set');
        
        $crud->setRule('end_date', 'requiredWith' , ['start_date']);
        $crud->setRule('discount_type', 'requiredWith' , ['discount_value']);
        $crud->setRule('discount_value', 'requiredWith' , ['discount_type']);
        $crud->setRule('prize_aggregation', 'requiredWith' , ['prizes']);
        $crud->setRule('get_qty', 'requiredIf' , ['level']);
        // $crud->setRule('discount_type', 'requiredIf' , ['level']);
        // $crud->setRule('discount_value', 'requiredIf' , ['level']);
        // $crud->setRule('prizes', 'requiredIf' , ['level']);

        // Add fields order
        $crud->addFields([
            "offer_title",
            "offer_arabic_title",
            "level",
            "priority",
            "conditions",
            "_relation",
            "get_qty",
            "discount_type",
            "discount_value",
            "prizes",
            "prize_aggregation",
            "prize_title",
            "start_date",
            "end_date",
            "status",
        ]);

        // Edit fields order
        $crud->editFields([
            "offer_title",
            "offer_arabic_title",
            "level",
            "priority",
            "conditions",
            "_relation",
            "get_qty",
            "discount_type",
            "discount_value",
            "prizes",
            "prize_aggregation",
            "prize_title",
            "start_date",
            "end_date",
            "status",
        ]);


        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function prizes(){
        // Acces Check
            $access = $this->userModel->grant_access();
            $crud = $this->_getGroceryCrudEnterprise();
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
        // Acces Check
        
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("prizes");
        $crud->setSubject("Prize", "Prizes");
        $crud->setRelationNtoN(
            "skus",
            "product_prizes",
            "products",
            "prize_id",
            "product_sku",
            "name"
        );


        $crud->unsetFields(["updated_at"]);

        // $crud->unsetFields(["created_at", "updated_at"]);

        // Required Fields
        $crud->requiredFields(["description"]);

        // Displays
        $crud->displayAs("skus" , "Prize combination");
        
        // Required Fields
        

        $output = $crud->render();
        return $this->_example_output($output);
        
    }

    public function conditions(){
        // Acces Check
            $access = $this->userModel->grant_access();
            $crud = $this->_getGroceryCrudEnterprise();
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
        // Acces Check
        
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("offer_conditions");
        $crud->setSubject("Condition", "Conditions");

        // Categories relation
        $categories=array();
        $cats = $this->category->_getcategories();
        $level1 = array_filter($cats , function($category){ return $category["parent_id"] == "0"; });
        foreach ($level1 as $p1_id => $cat1) {
            # code...
            $categories[$p1_id] = $cat1["category_name"];
            $level2 = array_filter($cats , function($category)use(&$p1_id){ return $category["parent_id"] == $p1_id; });
            if(sizeof($level2) > 0){
                foreach ($level2 as $p2_id => $cat2) {
                    $categories[$p2_id] = "-----".$cat2["category_name"];
                    $level3 = array_filter($cats , function($category)use(&$p2_id){ return $category["parent_id"] == $p2_id; });
                    # code...
                    if(sizeof($level3) > 0){
                        foreach ($level3 as $p3_id => $cat3) {
                            $categories[$p3_id] = "----------".$cat3["category_name"];
                        }
                    }

                }
            }
        }

        $crud->fieldType('on_product_categories', 'multiselect_native', $categories);

        // brands relation
        $crud->setRelationNtoN(
            "on_product_brands",
            "offer_condition_brands",
            "brand",
            "condition_id",
            "brand_id",
            "title"
        );

        // types relation
        $crud->setRelationNtoN(
            "on_product_types",
            "offer_condition_types",
            "type",
            "condition_id",
            "type_id",
            "title"
        );

        // Products relation
        $crud->setRelationNtoN(
            "product_list",
            "offer_condition_products",
            "products",
            "condition_id",
            "product_id",
            "{name} - {sku}"
        );  
        
        // Offer relation
        $crud->setRelationNtoN(
            'offers',
            'offer_condition_relation',
            'offers',
            'condition_id',
            'offer_id',
            '{offer_title}',
        ); 

        $crud->unsetFields(["created_at", "updated_at"]);

        // Required Fields
        $crud->requiredFields(["description" , "_relation"]);

        // Displays
        $crud->displayAs("_relation" , "Conditions Applies");
        $crud->displayAs("on_product_aggregation" , "Product Aggregation");
        
        // Validations
        \Valitron\Validator::addRule('requiredIf', function($field, $value, array $params, array $fields) {
            var_dump("yahia");die();
            switch (true) {
                case ($field == 'on_product_brands'):
                    # code...
                    if($fields["on_product_qty"] > 0 && empty(trim($fields["product_list"])) ){
                        return ((trim($value) !== ""));
                    }
        
                break;

                default:
                    # code...
                    break;
            }
        
        }, 'must be set');
        // $crud->setRule('on_product_categories', 'requiredWith' , ['on_product_qty']);
        // $crud->setRule('on_product_brands', 'requiredWith' , ['on_product_qty']);
        // $crud->setRule('on_product_brands', 'requiredWithout' , ['product_list']);
        // $crud->setRule('on_product_types', 'requiredWith' , ['on_product_qty']);
        $crud->setRule('on_product_aggregation', 'requiredWith' , ['product_list']);
        
        // columns
        // $crud->columns([
        //     "id",
        //     "description",
        //     "on_cart_spend_amount",
        //     "on_product_types",
        //     "on_product_brands",
        //     "on_product_categories",
        //     "on_product_qty",
        //     "_relation",
        //     "on_product_aggregation",
        // ]);
        
        // Fields order
        $crud->editFields([
            "description",
            "product_list",
            "on_product_aggregation",
            "on_cart_spend_amount",
            "on_product_types",
            "on_product_brands",
            "on_product_categories",
            "on_product_qty",
            "_relation",
        ]);

        $crud->addFields([
            "description",
            "product_list",
            "on_product_aggregation",
            "on_cart_spend_amount",
            "on_product_types",
            "on_product_brands",
            "on_product_categories",
            "on_product_qty",
            "_relation",
        ]);


        
        

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