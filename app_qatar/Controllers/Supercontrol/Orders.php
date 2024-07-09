<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include APPPATH . "Libraries/GroceryCrudEnterprise/autoload.php";
use GroceryCrud\Core\GroceryCrud;
class Orders extends \App\Controllers\BaseController{

    public function dateWise(){
        // Access Check
          $access = $this->userModel->grant_access();
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

        echo $this->header();
        echo view("/Supercontrol/DateWiseOrder");
        echo $this->footer();
    }

    public function orderExport(){
        // Access Check
            $access = $this->userModel->grant_access();
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

        echo $this->header();
        echo view("/Supercontrol/OrderExport");
        echo $this->footer();
    }

    public function statusWiseOrder(){

        // Access Check
            $access = $this->userModel->grant_access();
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
        echo $this->header();
        echo view("/Supercontrol/StatusWiseOrder");
        echo $this->footer();
    }

    public function dayWise(){
        // Access Check
            $access = $this->userModel->grant_access();
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
        
        $data["orders"] = $this->orderModel->order_products_daywise($_GET["start"] , $_GET["end"]);
        
        echo $this->header();
        echo view("/Supercontrol/DayWise" , $data);
        echo $this->footer();
    }

    public function header(){
        return view("/Supercontrol/Common/Header");
    }

    public function footer(){
        return view("/Supercontrol/Common/Footer");
    }

    public function user(){
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("orders");
        $crud->setSubject("Orders", "Orders");
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
        } 
        else {
            return redirect()->to(base_url() . "/supercontrol/Login");
        }
        if ($addFlag == 0) {
            $crud->unsetAdd();
        }
        if ($editFlag == 0) {
            $crud->unsetEdit();
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit();
        }
        // Checking Access user END##############
        // Access END
        $crud->fieldType("id", "hidden");
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });
        /*$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
          $crud->unsetFields(['created_at','updated_at']);
          $crud->requiredFields(['coupon_code','status','title','start_date','end_date','type','value']);
          $crud->uniqueFields(['coupon_code']);*/
        $crud->requiredFields([
            "payment_method",
            "payment_status",
            "order_status",
        ]);
        $crud->defaultOrdering("orders.created_at", "desc");
        $crud->columns([
            "order_id",
            "user_id",
            "name",
            "total",
            "invoice",
            "payment_method",
            "payment_status",
            "order_status",
            "created_at",
        ]);
        $crud->editFields([
            "name",
            "email",
            "phone",
            "street",
            "apartment_house",
            "address",
            "payment_method",
            "payment_status",
            "refund_type",
            "order_status",
        ]);
        $crud->callbackColumn("invoice", function ($value, $row) {
            return "<a href='" . base_url() . "/invoice/" . $row->order_id . "' target='blank'>Invoice</a>";
        });
        $crud->where([
            "user_id" => $uri3,
        ]);
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function products(){
        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("order_products");
        $crud->setSubject("order products", "order products");
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
                            $access_modules = $this->userModel->customQuery($sql);
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
            $crud->unsetAdd();
        }
        if ($editFlag == 0) {
            $crud->unsetEdit();
        }
        if ($deleteFlag == 0) {
            $crud->unsetDelete();
            $crud->unsetDeleteMultiple();
        }
        if ($viewFlag == 0) {
            echo "You do not have sufficient privileges to access this page . please contact admin for more information.";
            exit();
        }
        // Checking Access user END##############
        // Access END
        // $crud->fieldType('id','hidden');
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });
        /*$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
          $crud->unsetFields(['created_at','updated_at']);
          $crud->requiredFields(['coupon_code','status','title','start_date','end_date','type','value']);
          $crud->uniqueFields(['coupon_code']);*/
        $crud->where([
            "order_id" => $uri3,
        ]);
        $crud->setFieldUpload(
            "product_image",
            "assets/uploads",
            base_url() . "/assets/uploads"
        );
        $crud->columns([
            "order_id",
            "pre_order_enabled",
            "product_name",
            "product_image",
            "product_price",
            "quantity",
        ]);
        $crud->editFields([
            "order_id",
            "product_name",
            "product_image",
            "product_price",
            "quantity",
        ]);
        $crud->addFields(["order_id", "product_id", "quantity"]);
        $crud->requiredFields(["quantity"]);
        $crud->setRelation("product_id", "products", "name");
        $crud->readOnlyEditFields([
            "product_name",
            "product_image",
            "product_price",
        ]);
        $crud->fieldType("order_id", "hidden");
        // ####################CALLBACK UPDATWE########################
        // #######################################################
        $crud->callbackAfterUpdate(function ($stateParameters) use ($callbackAfterUpdateModel) {
            // Start Calcualtion
            $oid = $stateParameters->data["order_id"];
            $sql = "select * from orders where     order_id='$oid'";
            $orders = $this->userModel->customQuery($sql);
            $sql = "select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products inner join products on order_products.product_id=products.product_id where order_products.order_id='$oid'";
            $cart = $this->userModel->customQuery($sql);
            $sql = "select * from order_charges where order_id='$oid'";
            $charges = $this->userModel->customQuery($sql);
            $total = 0;
            $stotal = 0;
            if ($cart) {
                foreach ($cart as $k => $v) {
                    $ptotal = 0;
                    $temp = 0;
                    $pid = $v->product_id;
                    $ptotal += ($v->product_price + $v->gift_wrapping_price + $v->app) * $v->quantity;
                    $tpro = ($v->product_price + $v->app + $v->gift_wrapping_price) * $v->quantity;
                    if ($v->coupon_code) {
                        if ($v->coupon_type == "Percentage") {
                            $dtotal = $dtotal + ($tpro - ($tpro * $v->coupon_value) / 100);
                            $dc_value = $dc_value + ($tpro * $v->coupon_value) / 100;
                            $stotal = $stotal + ($tpro - ($tpro * $v->coupon_value) / 100);
                        } else {
                            $dtotal = $dtotal + ($tpro - $v->coupon_value);
                            $dc_value = $dc_value + $v->coupon_value;
                            $stotal = $stotal + ($tpro - $v->coupon_value);
                        }
                    } else {
                        $stotal = $stotal + ($v->product_price + $v->app + $v->gift_wrapping_price) * $v->quantity;
                    }
                }
            }
            $chrg = 0;
            foreach ($charges as $k2 => $v2) {
                if ($v2->type == "Percentage") {
                    $chrg = $chrg + ($stotal * $v2->value) / 100;
                } else {
                    $chrg = $chrg + $v2->value;
                }
            }
            $updata["total"] = $stotal + $chrg;
            $updata["charges"] = $chrg;
            $updata["sub_total"] = $stotal;
            $res = $this->userModel->do_action(
                "orders",
                $oid,
                "order_id",
                "update",
                $updata,
                ""
            );
            // END Recalcuation
            return $stateParameters;
        });
        // ###############Update callback END
        // ################################################
        // ####################CALLBACK UPDATWE########################
        // #######################################################
        $crud->callbackAfterInsert(function ($stateParameters) use ($callbackAfterUpdateModel) {
            $tpid = $stateParameters->data["product_id"];
            $sql = "select  * from products  where product_id ='$tpid'";
            $proDetail = $this->userModel->customQuery($sql);
            $sql = "select * from product_image where     product='$tpid' and status='Active' ";
            $product_image = $this->userModel->customQuery($sql);
            if ($product_image) {
                $ins["product_image"] = $product_image[0]->image;
            }
            $ins["product_name"] = $proDetail[0]->name;
            if ($proDetail[0]->discount_percentage > 0) {
                $ins["product_price"] = $proDetail[0]->price - ($proDetail[0]->discount_percentage * $proDetail[0]->price) / 100;
            } else {
                $ins["product_price"] = $proDetail[0]->price;
            }
            $res = $this->userModel->do_action(
                "order_products",
                $stateParameters->insertId,
                "id",
                "update",
                $ins,
                ""
            );
            // Start Calcualtion
            $oid = $stateParameters->data["order_id"];
            $sql = "select * from orders where     order_id='$oid'";
            $orders = $this->userModel->customQuery($sql);
            $sql = "select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products inner join products on order_products.product_id=products.product_id where order_products.order_id='$oid'";
            $cart = $this->userModel->customQuery($sql);
            $sql = "select * from order_charges where order_id='$oid'";
            $charges = $this->userModel->customQuery($sql);
            $total = 0;
            $stotal = 0;
            if ($cart) {
                foreach ($cart as $k => $v) {
                    $ptotal = 0;
                    $temp = 0;
                    $pid = $v->product_id;
                    $ptotal += ($v->product_price + $v->gift_wrapping_price + $v->app) * $v->quantity;
                    $tpro = ($v->product_price + $v->app + $v->gift_wrapping_price) * $v->quantity;
                    if ($v->coupon_code) {
                        if ($v->coupon_type == "Percentage") {
                            $dtotal = $dtotal + ($tpro - ($tpro * $v->coupon_value) / 100);
                            $dc_value = $dc_value + ($tpro * $v->coupon_value) / 100;
                            $stotal = $stotal + ($tpro - ($tpro * $v->coupon_value) / 100);
                        } else {
                            $dtotal = $dtotal + ($tpro - $v->coupon_value);
                            $dc_value = $dc_value + $v->coupon_value;
                            $stotal = $stotal + ($tpro - $v->coupon_value);
                        }
                    } else {
                        $stotal = $stotal + ($v->product_price + $v->app + $v->gift_wrapping_price) * $v->quantity;
                    }
                }
            }
            $chrg = 0;
            foreach ($charges as $k2 => $v2) {
                if ($v2->type == "Percentage") {
                    $chrg = $chrg + ($stotal * $v2->value) / 100;
                } else {
                    $chrg = $chrg + $v2->value;
                }
            }
            $updata["total"] = $stotal + $chrg;
            $updata["charges"] = $chrg;
            $updata["sub_total"] = $stotal;
            $res = $this->userModel->do_action(
                "orders",
                $oid,
                "order_id",
                "update",
                $updata,
                ""
            );
            // END Recalcuation
            return $stateParameters;
        });
        // ###############Update callback END
        // ################################################
        $output = $crud->render();
        return $this->_example_output($output);
    }

    public function index(){
        $orderModel = model("App\Models\OrderModel");
        $productModel = model("App\Models\ProductModel");

        $crud = $this->_getGroceryCrudEnterprise();
        $crud->setCsrfTokenName(csrf_token());
        $crud->setCsrfTokenValue(csrf_hash());
        $crud->setTable("orders");
        $crud->setSubject("Orders", "Orders");

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
        
        $crud->fieldType("id", "hidden");
        $crud->setRelation("transaction_ref" , "payment_txn", "{paymethod}");

        $crud->unsetAdd();
        $crud->callbackBeforeInsert(function ($stateParameters) {
            $stateParameters->data["id"] = time();
            return $stateParameters;
        });

        $crud->requiredFields([
            "payment_method",
            "payment_status",
            "order_status",
        ]);
        $crud->defaultOrdering("orders.created_at", "desc");
        $crud->unsetSearchColumns(["transaction_ref"]);
        $crud->columns([
            "order_id",
            "user_id",
            "name",
            "products",
            "total",
            "invoice",
            "payment_method",
            "payment_status",
            "transaction_ref",
            "order_status",
            "created_at",
        ]);
        $crud->editFields([
            "order_id",
            "name",
            "email",
            "phone",
            "street",
            "apartment_house",
            "address",
            "payment_status",
            "payment_method",
            "refund_type",
            "order_status",
            "tracking",
            "remarks",
        ]);
        $crud->displayAs("remarks", "Remark");
        $crud->displayAs("transaction_ref", "Payment used");

        // $crud->editFields(["order_id", "name", "email", "phone", "street", "apartment_house", "address", "payment_method",  "refund_type", "order_status", "tracking", ]);

        $crud->fieldType("order_id", "hidden");

        $crud->callbackColumn("invoice", function ($value, $row) {
            return "<a href='" .
                base_url() .
                "/invoice/" .
                $row->order_id .
                "' target='blank'>Invoice</a>";
        });

        $crud->callbackColumn("order_status", function ($value, $row) {
            switch ($value) {
                case "Submited":
                    return "<div class='p-2' style='color:white; background-color: #2a349b'>" .
                        $value .
                        "</div>";
                    break;

                case "Confirmed":
                    return "<div class='p-2' style='color:white; background-color: purple'>" .
                        $value .
                        "</div>";
                    break;

                case "Out for delivery":
                    return "<div class='p-2' style='color:white; background-color: orange'>" .
                        $value .
                        "</div>";
                    break;

                case "Delivered":
                    return "<div class='p-2' style='color:white; background-color: green'>" .
                        $value .
                        "</div>";
                    break;

                case "Canceled":
                    return "<div class='p-2' style='color:white; background-color: red'>" .
                        $value .
                        "</div>";
                    break;

                case "Pre-order":
                    return "<div class='p-2' style='color:white; background-color: #515151'>" .
                        $value .
                        "</div>";
                    break;

                default:
                    break;
            }

            // return "<a href='" . site_url('menu/' . $row->id) . "'>$value</a>";
        });

        $crud->callbackColumn("products", function ($value, $row) {
            return "<a href='" .
                base_url() .
                "/supercontrol/Orders/products/" .
                $row->order_id .
                "' target='blank'>products</a>";
        });

        // $crud->callbackColumn("created_at", function ($value, $row)
        // {
        //     $date = new \dateTime($value,new \dateTimeZone(TIME_ZONE));

        //     return $date->format("Y-m-d");
        //     // return $value;
        // });

        $crud->callbackBeforeUpdate(function ($stateParameters) {
            $current_order_status = $this->orderModel->order_status($stateParameters->data["order_id"])->order_status;
            // get the order information
            $products_ordered = $this->orderModel->_getproducts_ordered(
                $stateParameters->data["order_id"]
            );
            // var_dump($current_order_status);die();
            if ($oid =$stateParameters->data["order_id"] && $stateParameters->data["order_status"] == "Canceled" && $current_order_status !== "Canceled") {
                // increment the products stock of the products order by the qty ordered
                if ($products_ordered) {
                    foreach ($products_ordered as $value) {
                        $q = (int) $value->available_stock + (int) $value->quantity;
                        $res = $this->productModel->increment_stock($value->product_id,$q);
                    }
                }

                if ($stateParameters->data["order_status"] == "Canceled" && $stateParameters->data["payment_status"] == "Refunded") {
                    $sql = "select * from  orders where order_id='$oid'";
                    $ord = $this->userModel->customQuery($sql);
                    // refund wallet
                    if ($ord[0]->payment_method == "Online payment" && $ord[0]->payment_status == "Paid" && $ord[0]->transaction_ref != "" && $stateParameters->data["refund_type"] == "Wallet"
                    ) {
                        $winsert["user_id"] = $ord[0]->user_id;
                        $winsert["order_id"] = $ord[0]->order_id;
                        $winsert["total"] = $ord[0]->total;
                        $winsert["available_balance"] = $ord[0]->total;
                        $winsert["type"] = "credited_from_order_cancel";
                        $res = $this->userModel->do_action(
                            "wallet",
                            "",
                            "",
                            "insert",
                            $winsert,
                            ""
                        );
                    }

                    // Refund online
                    else if ($ord[0]->payment_method == "Online payment" && $ord[0]->payment_status == "Paid" && $ord[0]->transaction_ref != "" && $stateParameters->data["refund_type"] == "Online") {
                        /* $winsert['user_id']=$ord[0]->user_id;
                           $winsert['order_id']=$ord[0]->order_id;
                           $winsert['total']=$ord[0]->total;
                           $winsert['available_balance']=$ord[0]->total;
                           $winsert['type']='credited_from_order_cancel';
                           $res=$this->userModel->do_action('wallet','','','insert',$winsert,'');*/

                        if ($ord) {
                            //   PG START
                            // $params = [
                            //     "ivp_store" => STOREID,
                            //     "ivp_authkey" => AUTHKEYREMOTE,
                            //     "ivp_trantype" => "refund",
                            //     "ivp_tranclass" => "ecom",
                            //     "ivp_desc" =>
                            //         "Payment for order id : " .
                            //         $ord[0]->order_id,
                            //     "ivp_cart" => $ord[0]->order_id,
                            //     "ivp_currency" => CURRENCY,
                            //     "ivp_amount" => $ord[0]->total,
                            //     "tran_ref" => $ord[0]->transaction_ref,
                            //     "ivp_test" => PGTEST,
                            // ];
                            // //  print_r($params);exit;
                            // $ch = curl_init();
                            // curl_setopt(
                            //     $ch,
                            //     CURLOPT_URL,
                            //     "https://secure.telr.com/gateway/remote.html"
                            // );
                            // curl_setopt($ch, CURLOPT_POST, count($params));
                            // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            // curl_setopt($ch, CURLOPT_HTTPHEADER, ["Expect:"]);
                            // $results = curl_exec($ch);
                            // curl_close($ch);
                            // END PG END
                        }
                    }

                    // refund wallet when COD
                    elseif ($stateParameters->data["payment_method"] == "Cash on devlivery" && $ord[0]->payment_status == "Paid" && $stateParameters->data["refund_type"] == "Wallet") {
                        $winsert["user_id"] = $ord[0]->user_id;
                        $winsert["order_id"] = $ord[0]->order_id;
                        $winsert["total"] = $ord[0]->total;
                        $winsert["available_balance"] = $ord[0]->total;
                        $winsert["type"] = "credited_from_order_cancel";
                        $res = $this->userModel->do_action(
                            "wallet",
                            "",
                            "",
                            "insert",
                            $winsert,
                            ""
                        );
                    }
                }
                //
            } elseif (
                $stateParameters->data["order_id"] &&
                $stateParameters->data["order_status"] == "Submited" &&
                $current_order_status == "Canceled"
            ) {
                // increment the products stock of the products order by the qty ordered
                if ($products_ordered) {
                    foreach ($products_ordered as $value) {
                        $q = (int) $value->available_stock - (int) $value->quantity;
                        $res = $this->productModel->increment_stock($value->product_id,$q);
                        // var_dump($res);die();
                    }
                }
            }
            return $stateParameters;
        });
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

    public function ezpin_orders(){   

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
    
      $crud->setSubject('EZPIN order', 'EZPIN orders');
      $crud->setTable('ezpin_codes_order');
      $crud->setRelation("product_id" , "products", "{name}" , ['type' => '6']);
      $crud->setRelation("order_id" , "orders", "{order_id} ({email})");
      $crud->displayAs('share_link','Code details');
      $crud->displayAs('status_text','Status');
      $crud->displayAs('order_id','Order ID');
      $crud->displayAs('product_id','Name');
      // $crud->where(["type" => "6" ]);
      $crud->columns(["order_id" , "product_id" , "reference_code" , "share_link" , "price" , "status_text" , "created_at" , "updated_at"]);

      // Stylize the digital code order status
      $crud->callbackColumn('status_text', function ($value, $row) {
          $bg_color = "";
          $status_text = "";

          switch ($value) {
            case 'pending':
              # code...
              $bg_color = "orange";
              $status_text = "Pending";
              $html = "
              <div style='background-color: $bg_color; color:white' class='p-3 text-center'>
                <span>$status_text</span>
              </div>
              ";

              break;

            case 'reject':
              # code...
              $bg_color = "red";
              $status_text = "Rejected";
              $html = "
              <div class='p-3 text-center'>
                <a href='".base_url()."/supercontrol/orders/ezpincode_resend/$row->order_id/$row->id' class='ezpin-resend-btn' onclick='event.preventDefault();ws_confirm_operation($(this))'>
                  <button class='btn' style='color:white;background-color: $bg_color'>$status_text (Resend?)</button>
                </a>
              </div>
              ";
              break;
            
            default:
              # code...
              $bg_color = "green";
              $status_text = "Accepted";
              $html = "
              <div style='background-color: $bg_color; color:white' class='p-3 text-center'>
                <span>$status_text</span>
              </div>
              ";
              break;
          }

          
          return $html;
      });
      
      // Return the Digital code infos
      $crud->callbackColumn('share_link', function ($value, $row) {
        if(!is_null($value))
        $html = "
        <a href='$value' target='blank' style='text-decoration: none;'>
          <span class='p-3'>View code</span>
        </a>
        ";
        else
        $html="";
          return $html;
      });    


      $crud->unsetAdd();
      $crud->unsetEdit();

      // $crud->editFields(["price" , "available_stock" , "pre_order_enabled" , ]);

      $crud->defaultOrdering('ezpin_codes_order.created_at', 'desc');
      $output = $crud->render();
      return $this->_example_output($output);
    }

    public function ezpincode_resend($order_id,$order_code_id){
        $access = $this->userModel->grant_access();
        if($access["ViewFlag"] == 1){
            $code = $this->ezpinModel->get_failed_ordered_code($order_code_id);
            $order = $this->orderModel->get_order_details($order_id);
            $this->ezpinModel->ezpin_create_order($order , $code);
            return redirect()->to(site_url("supercontrol/orders/ezpin_orders"));
        }
        else
        return view("errors/html/permission_denied");
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

    private function _getGroceryCrudEnterprise($bootstrap = true,$jquery = true) {
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }
}
