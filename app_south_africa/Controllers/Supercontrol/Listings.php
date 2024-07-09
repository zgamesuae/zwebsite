<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Listings extends \App\Controllers\BaseController
{
    public function submitExclusiveSelection()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "get") {
            $validation = \Config\Services::validation();
            $rules = [
                "val" => [
                    "label" => "val",
                    "rules" => "required",
                ],
            ];
            $pdata = $this->request->getVar();
            if ($pdata["val"]) {
                foreach ($pdata["val"] as $k => $v) {
                    $status["exclusive"] = "Yes";
                    $res = $this->userModel->do_action(
                        "products",
                        $v,
                        "product_id",
                        "update",
                        $status,
                        ""
                    );
                }
            }
        }
        return redirect()->to(site_url("/supercontrol/Listings/exclusive"));
    }

    public function addExclusive()
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
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->where("products.exclusive != 'Yes'");
        $crud->setSubject("Add Exclusive", "Add Exclusive");
        $crud->columns([
            "exclusive",
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);
        $crud->callbackColumn("exclusive", function ($value, $row) {
            $html =
                '<input  class="form-control ck-jagat" type="checkbox" name="exclusive[]"  value="' .
                $row->product_id .
                '">';
            return " $html ";
        });
        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });
        
        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function exclusive()
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
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->editFields(["exclusive"]);
        $crud->where("products.exclusive = 'Yes'");
        $crud->setSubject("Exclusive", "Exclusive");
        $crud->columns([
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);
        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });
        
        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function submitEvergreenSelection()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "get") {
            $validation = \Config\Services::validation();
            $rules = [
                "val" => [
                    "label" => "val",
                    "rules" => "required",
                ],
            ];
            $pdata = $this->request->getVar();
            if ($pdata["val"]) {
                foreach ($pdata["val"] as $k => $v) {
                    $status["evergreen"] = "Yes";
                    $res = $this->userModel->do_action(
                        "products",
                        $v,
                        "product_id",
                        "update",
                        $status,
                        ""
                    );
                }
            }
        }
        return redirect()->to(site_url("/supercontrol/Listings/evergreen"));
    }
    public function addEvergreen()
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
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->where("products.evergreen != 'Yes'");
        $crud->setSubject("Add Evergreen", "Add Evergreen");
        $crud->columns([
            "evergreen",
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);
        $crud->callbackColumn("evergreen", function ($value, $row) {
            $html =
                '<input  class="form-control ck-jagat" type="checkbox" name="evergreen[]"  value="' .
                $row->product_id .
                '">';
            return " $html ";
        });
        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });

        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function evergreen()
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
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->editFields(["evergreen"]);
        $crud->where("products.evergreen = 'Yes'");
        $crud->setSubject("Evergreen", "Evergreen");
        $crud->columns([
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);
        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });
        
        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function freebie()
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
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->editFields(["freebie"]);
        $crud->where("products.freebie = 'Yes'");
        $crud->setSubject("Freebie", "Freebie");
        $crud->columns([
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);
        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });

        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function submitFreebieSelection()
    {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "get") {
            $validation = \Config\Services::validation();
            $rules = [
                "val" => [
                    "label" => "val",
                    "rules" => "required",
                ],
            ];
            $pdata = $this->request->getVar();
            if ($pdata["val"]) {
                foreach ($pdata["val"] as $k => $v) {
                    $status["freebie"] = "Yes";
                    $res = $this->userModel->do_action(
                        "products",
                        $v,
                        "product_id",
                        "update",
                        $status,
                        ""
                    );
                }
            }
        }
        return redirect()->to(site_url("/supercontrol/Listings/freebie"));
    }

    public function addFreebie()
    {
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("products");
        $crud->unsetAdd();
        $crud->unsetEdit();
        $crud->where("products.freebie != 'Yes'");
        $crud->setSubject("Add Freebie", "Add Freebie");
        $crud->columns([
            "freebie",
            "category",
            "name",
            "images",
            "price",
            "sku",
            "status",
        ]);

        $crud->callbackColumn("freebie", function ($value, $row) {
            $html =
                '<input  class="form-control ck-jagat" type="checkbox" name="freebie[]"  value="' .
                $row->product_id .
                '">';

            return " $html ";
        });

        $crud->callbackColumn("images", function ($value, $row) {
            $sql = "select * from product_image where  product='$row->product_id' ";
            $pimg = $this->userModel->customQuery($sql);
            if ($pimg) {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    "/assets/uploads/" .
                    $pimg[0]->image .
                    '">';
            } else {
                $html =
                    '<img class="brand-logo" width="50" src="' .
                    base_url() .
                    '/assets/uploads/noimg.png">';
            }
            //   return "<a href='/supercontrol/Products/productImage/" . $row->product_id."' >$html</a>";
            return "<a   >$html</a>";
        });
        //   Access Start
        // Checking access user Start ################
        $session = session();
        $uri = service("uri");
        @$admin_id = $session->get("adminLoggedin");
        $addFlag = 0;
        $editFlag = 0;
        $deleteFlag = 0;
        $uri1 = $uri2 = $uri3 = "";
        if (count(@$uri->getSegments()) > 1) {
            $uri1 = @$uri->getSegment(2);
        }
        if (count(@$uri->getSegments()) > 2) {
            $uri2 = @$uri->getSegment(3);
        }
        if (count(@$uri->getSegments()) > 3) {
            $uri3 = @$uri->getSegment(4);
        }
        if (@$admin_id) {
            $accessFlag = 0;
            $viewFlag = 0;
            $sql = "select * from access_group_master where  admin_id='$admin_id' ";
            $access_group_master = $this->userModel->customQuery($sql);
            if ($access_group_master) {
                foreach ($access_group_master as $k1 => $v1) {
                    $group_id = $v1->group_id;
                    $sql = "select * from groups_assigned where  group_id='$group_id' ";
                    $groups_assigned = $this->userModel->customQuery($sql);
                    if ($groups_assigned) {
                        foreach ($groups_assigned as $k2 => $v2) {
                            $access_modules_id = $v2->access_modules_id;
                            $sql = "select * from access_modules where  access_modules_id='$access_modules_id' ";
                            $access_modules = $this->userModel->customQuery(
                                $sql
                            );
                            if ($access_modules[0]->segment_1 == $uri1) {
                                $viewFlag = 1;
                                if ($access_modules[0]->segment_3 == "add") {
                                    $addFlag = 1;
                                }
                                if ($access_modules[0]->segment_3 == "edit") {
                                    $editFlag = 1;
                                }
                                if ($access_modules[0]->segment_3 == "delete") {
                                    $deleteFlag = 1;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            return redirect()->to(base_url() . "/supercontrol/Login");
        }
        if ($addFlag == 0) {
        }
        if ($editFlag == 0) {
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit();
        }

        /*$crud->setActionButton('Edit', 'fa fa-edit', function ($row) {
            return '/supercontrol/Products/edit/' . $row->product_id;
          }, false);*/
                  // Checking Access user END##############
                  // Access END
                  /*$crud->addFields(['access_modules_id', 'section_name','segment_1','segment_2','segment_3']);
          //   $crud->requiredFields(['access_modules_id', 'section_name','segment_1']);
          $crud->unsetFields(['created_at','updated_at']);
          $crud->uniqueFields(['access_modules_id']);
          $crud->columns(['section_name','segment_1','segment_2','segment_3','groups_assigned']);
          $crud->fieldType('access_modules_id','hidden');
          $crud->requiredFields(['section_name','segment_1']);
          $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data['access_modules_id'] =  ucwords($stateParameters->data['segment_3']).''.   str_replace(' ', '', ucwords($stateParameters->data['section_name']));
            return $stateParameters;
          });
          $crud->setRelationNtoN('groups_assigned', 'groups_assigned', 'admin_group', 'access_modules_id', 'group_id', 'name');*/
                  /*$crud->setRelation('color', 'color', 'title');
          $crud->setRelation('brand', 'brand', 'title');
          $crud->setRelation('age', 'age', 'title');
          $crud->setRelation('suitable_for', 'suitable_for', 'title');*/
        // $crud->setRelation('category', 'master_category', 'category_name');
        $crud->defaultOrdering("products.created_at", "desc");
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function header()
    {
        return view("/Supercontrol/Common/Header");
    }

    public function footer()
    {
        return view("/Supercontrol/Common/Footer");
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
