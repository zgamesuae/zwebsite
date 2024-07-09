<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include (APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class Customer extends \App\Controllers\BaseController
{
    public function index(){
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
        $crud->setTable('users');
        $crud->setSubject('Customer', 'Customer');
        $crud->unsetFields(['created_at', 'updated_at' , 'token' , 'token_created_at' , 'verification_code' , 'amount_spent' , 'total_orders']);
        $crud->setRelation("city" , "city" , "title");
        
        $crud->defaultOrdering('created_at', 'desc');
        $crud->fieldType('user_id', 'hidden');

        $crud->callbackBeforeInsert(function ($stateParameters){
            $stateParameters->data['user_id'] = time();
            $stateParameters->data['password'] = base64_encode($stateParameters->data['password']);

            return $stateParameters;
        });

        $crud->callbackBeforeUpdate(function ($stateParameters){
            $stateParameters->data['password'] = base64_encode($stateParameters->data['password']);
            return $stateParameters;
        });

        // $crud->setRelation('city', 'city', 'title');
        $crud->callbackEditField('password', function ($fieldValue, $primaryKeyValue, $rowData)
        {
            return ' <input class="form-control" type="password" required name="password" value="' . base64_decode($fieldValue) . '"  />';
        });

        $crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
        $crud->requiredFields(['status' , 'name' , 'email' , 'phone' , 'city']);

        $crud->columns(['user_type', 'name', 'email', 'phone', 'social_inscription' , 'amount_spent', 'total_orders', 'status', 'created_at' , 'updated_at']);

        $crud->callbackColumn('amount_spent', function ($value, $row){

            $sql = "select sum(total) as total from orders  where user_id='$row->user_id' and payment_status = 'Paid'";
            $orders = $this
                ->userModel
                ->customQuery($sql);

            return "<a href='" . base_url() . "/supercontrol/Orders/user/" . $row->user_id . "' target='blank'>".CURRENCY." " . number_format($orders[0]->total) . "</a>";

        });

        $crud->callbackColumn('total_orders', function ($value, $row){

            $sql = "select count(order_id) as cnt from orders where user_id='$row->user_id' ";
            $orders = $this->userModel->customQuery($sql);
            return "<a href='" . base_url() . "/supercontrol/Orders/user/" . $row->user_id . "' target='blank'>" . number_format($orders[0]->cnt) . "</a>";

        });

        $output = $crud->render();
        return $this->_example_output($output);
    }

    private function _example_output($output = null){
        if (isset($output->isJSONResponse) && $output->isJSONResponse)
        {
            header('Content-Type: application/json; charset=utf-8');
            echo $output->output;
            exit;
        }
        echo view('/Supercontrol/Common/Header', (array)$output);
        echo view('/Supercontrol/Crud.php', (array)$output);
        echo view('/Supercontrol/Common/Footer', (array)$output);
    }

    private function _getDbData(){
        $db = (new \Config\Database())->default;
        return ['adapter' => ['driver' => 'Pdo_Mysql', 'host' => $db['hostname'], 'database' => $db['database'], 'username' => $db['username'], 'password' => $db['password'], 'charset' => 'utf8']];
    }

    private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true){
        $db = $this->_getDbData();
        $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
        $groceryCrud = new GroceryCrud($config, $db);
        return $groceryCrud;
    }

    public function contact_requests(){
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
        $crud->setTable('contact_us_form');
        $crud->setSubject('Contact request', 'Contact requests');

        $crud->defaultOrdering('created_at', 'desc');
        $crud->fieldType('id', 'hidden');
        $crud->fieldType('updated_at', 'hidden');
        $crud->setRead();

        // $crud->callbackBeforeUpdate(function ($stateParameters)
        // {
        //     $stateParameters->data['password'] = base64_encode($stateParameters->data['password']);

        //     return $stateParameters;
        // });

        $crud->callbackEditField('password', function ($fieldValue, $primaryKeyValue, $rowData)
        {
            return ' <input class="form-control" required name="password" value="' . base64_decode($fieldValue) . '"  />';
        });

        $crud->unsetFields(['created_at', 'updated_at']);
        // $crud->requiredFields(['status', 'name', 'email', 'password', 'phone', 'city']);

        $crud->columns(['name','email','phone','subject','message','created_at']);

        // $crud->callbackColumn('amount_spent', function ($value, $row)
        // {

        // });


        $output = $crud->render();
        return $this->_example_output($output);
    }
}

