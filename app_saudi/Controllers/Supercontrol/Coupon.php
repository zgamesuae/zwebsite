<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Coupon extends \App\Controllers\BaseController
{
    public function sendCouponSubmit() {
        $data = [];
        helper(["form", "url"]);
        if ($this->request->getMethod() == "post") {
            $pdata = $this->request->getVar();
            if ($pdata["user_id"]) {
                foreach ($pdata["user_id"] as $k => $v) {
                    $inst["customer"] = $v;

                    $sql = "select * from users where user_id='$v'";
                    $udetail = $this->userModel->customQuery($sql);

                    $cp = $pdata["coupon_code"];
                    $sql = "select * from coupon where coupon_code='$cp'";
                    $coupond = $this->userModel->customQuery($sql);

                    $inst["email"] = @$udetail[0]->email;
                    $inst["phone"] = @$udetail[0]->phone;
                    $inst["coupon_code"] = $pdata["coupon_code"];
                    $inst["coupon_type"] = @$coupond[0]->coupon_type;

                    $res = $this->userModel->do_action(
                        "coupon_sent",
                        "",
                        "",
                        "insert",
                        $inst,
                        ""
                    );

                    if ($to = @$udetail[0]->email) {
                        //#############   SEND EMAIL STRT
                        $edata["post"] = $inst;
                        $edata["user"] = @$udetail[0];
                        $subject = "New coupon code received";
                        $message = view("CouponEmail", $edata);

                        $email = \Config\Services::email();
                        $email->setTo($to);
                        $email->setFrom(
                            "info@zamzamdistribution.com",
                            "Zamzam Games"
                        );
                        $email->setSubject($subject);
                        $email->setMessage($message);
                        if ($email->send()) {
                            //   echo 'Email successfully sent';
                        } else {
                            /* $data = $email->printDebugger(['headers']);
         print_r($data);*/
                        }

                        //############# SEND EMIAL END
                    }

                    return redirect()->to(
                        site_url("/supercontrol/Coupon/couponSent/" . $cp)
                    );
                }
            }
        }
    }

    public function couponSent($cid) {
        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
        $access = $this->userModel->grant_access(false);
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
        $crud->setTable("coupon_sent");
        $crud->setSubject("Coupon Sent", "Coupon Sent");
        $crud->where([
            "coupon_sent.coupon_code" => $cid,
        ]);

        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function couponUses($cid) {
        $crud = $this->_getGroceryCrudEnterprise();

        // Access Check
          $access = $this->userModel->grant_access(false);
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
        $crud->setTable("coupon_uses");
        $crud->setSubject("Coupon Uses", "Coupon Uses");
        $crud->where([
            "coupon_uses.coupon_code" => $cid,
        ]);

        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });

        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function generic() {
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
        $crud->setTable("coupon");
        $crud->setSubject("Generic Coupon", "Generic Coupon");
        $crud->where([
            "coupon.coupon_type" => "generic",
        ]);
        $crud->callbackAddField("coupon_type", function (
            $fieldType,
            $fieldName
        ) {
            return '<input class="form-control" name="coupon_type" type="readonly" value="generic">';
        });
        $crud->unsetColumns(["coupon_type", "description"]);
        $crud->callbackColumn("coupon_uses", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponUses/" . $row->coupon_code
                ) .
                "'>Coupon Uses</a>";
        });
        $crud->callbackColumn("coupon_sent", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponSent/" . $row->coupon_code
                ) .
                "'>Coupon Sent</a>";
        });
        
        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields([
            "coupon_uses",
            "coupon_sent",
            "created_at",
            "updated_at",
        ]);
        $crud->requiredFields([
            "coupon_code",
            "status",
            "title",
            "start_date",
            "end_date",
            "type",
            "value",
        ]);
        $crud->uniqueFields(["coupon_code"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function specific() {
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
        $crud->setTable("coupon");
        $crud->where([
            "coupon.coupon_type" => "specific",
        ]);
        $crud->callbackAddField("coupon_type", function (
            $fieldType,
            $fieldName
        ) {
            return '<input class="form-control" name="coupon_type" type="readonly" value="specific">';
        });

        $crud->unsetColumns(["coupon_type", "description"]);
        $crud->callbackColumn("coupon_uses", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponUses/" . $row->coupon_code
                ) .
                "'>Coupon Uses</a>";
        });
        $crud->callbackColumn("coupon_sent", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponSent/" . $row->coupon_code
                ) .
                "'>Coupon Sent</a>";
        });

        $crud->setSubject("Specific Coupon", "Specific Coupon");
        
        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields([
            "coupon_uses",
            "coupon_sent",
            "created_at",
            "updated_at",
        ]);
        $crud->requiredFields([
            "coupon_code",
            "status",
            "title",
            "start_date",
            "end_date",
            "type",
            "value",
        ]);
        $crud->uniqueFields(["coupon_code"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function oneTimeCoupon() {
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
        $crud->setTable("coupon");
        $crud->where([
            "coupon.coupon_type" => "one_time_coupon",
        ]);
        $crud->callbackAddField("coupon_type", function (
            $fieldType,
            $fieldName
        ) {
            return '<input class="form-control" name="coupon_type" type="readonly" value="one_time_coupon">';
        });
        $crud->unsetColumns(["coupon_type", "description"]);
        $crud->callbackColumn("coupon_uses", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponUses/" . $row->coupon_code
                ) .
                "'>Coupon Uses</a>";
        });
        $crud->callbackColumn("coupon_sent", function ($value, $row) {
            return "<a href='" .
                site_url(
                    "supercontrol/Coupon/couponSent/" . $row->coupon_code
                ) .
                "'>Coupon Sent</a>";
        });

        $crud->callbackColumn("on_brand", function ($value, $row) {
            return $this->brandModel->_getbrandname($row->on_brand);
        });

        $crud->callbackColumn("on_category", function ($value, $row) {
          $cats= explode(",",$row->on_category);

          foreach($cats as $k=>$v){
            $parent="";
            if(!$this->category->is_mastercat($v))
            $parent="(".$this->category->_getcatname($this->category->get_master_parent_cat($v)).")";
            // var_dump($this->category->is_mastercat($v));die();
            $cats[$k]=$this->category->_getcatname($v).$parent;

          }

          $cats=implode(",",$cats);
          return $cats;

        });

        $crud->setSubject("one Time Coupon", "one Time Coupon");

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
        
        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });
        $crud->setFieldUpload(
            "image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->unsetFields([
            "coupon_uses",
            "coupon_sent",
            "created_at",
            "updated_at",
        ]);

        $crud->requiredFields([
            "coupon_code",
            "status",
            "title",
            "start_date",
            "end_date",
            "type",
            "value",
        ]);

        $crud->fieldType('on_category', 'multiselect_native', $categories);
        $crud->fieldType('on_brand', 'dropdown', $brands);


        // callback on 'on category' field for editing a coupon
            // var_dump($mastercategories);die();


        $crud->uniqueFields(["coupon_code"]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    private function _example_output($output = null) {
        if (isset($output->isJSONResponse) && $output->isJSONResponse) {
            header("Content-Type: application/json; charset=utf-8");
            echo $output->output;
            exit();
        }
        echo view("/Supercontrol/Common/Header", (array) $output);
        echo view("/Supercontrol/Crud.php", (array) $output);
        echo view("/Supercontrol/Common/Footer", (array) $output);
    }

    private function _getDbData() {
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

    private function _getGroceryCrudEnterprise(){
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
}
