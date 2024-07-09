<?php
namespace App\Controllers\Supercontrol;
use App\Controllers\BaseController;
include(APPPATH . 'Libraries/GroceryCrudEnterprise/autoload.php');
use GroceryCrud\Core\GroceryCrud;
class Coupon extends \App\Controllers\BaseController{
 public function sendCouponSubmit()
 {
      
     $data = [];
 helper(['form','url']);
 if ($this->request->getMethod() == "post") {
 
$pdata=$this->request->getVar();
if($pdata['user_id']){
    foreach($pdata['user_id'] as $k=>$v){
        $inst['customer']=$v;
        
     $sql="select * from users where user_id='$v'";
$udetail=$this->userModel->customQuery($sql); 

$cp=$pdata['coupon_code'];
  $sql="select * from coupon where coupon_code='$cp'";
$coupond=$this->userModel->customQuery($sql); 


 

        
         $inst['email']=@$udetail[0]->email;
         $inst['phone']=@$udetail[0]->phone;
          $inst['coupon_code']=$pdata['coupon_code'];
           $inst['coupon_type']=@$coupond[0]->coupon_type;
        
      $res=$this->userModel->do_action('coupon_sent','','','insert',$inst,'');
      
      if($to=@$udetail[0]->email){
      
        //#############   SEND EMAIL STRT
    $edata['post']=$inst;
      $edata['user']=@$udetail[0];
     $subject = "New coupon code received" ;
      $message =   view('CouponEmail',$edata); 
    
     $email = \Config\Services::email();
     $email->setTo($to);
     $email->setFrom('info@zamzamdistribution.com', 'Zamzam Games');
     $email->setSubject($subject);
     $email->setMessage($message);
     if ($email->send()) 
     {
        //   echo 'Email successfully sent';
     } 
     else 
     {
         /* $data = $email->printDebugger(['headers']);
         print_r($data);*/
       }
     
//############# SEND EMIAL END 
      }
      
      
      
      
      
      
      
      
      
      
      
      
      
       return redirect()->to(site_url('/supercontrol/Coupon/couponSent/'.($cp)));
  
    }
}
     
 }
 }    
  
    public function couponSent($cid)
 {
     
  $crud = $this->_getGroceryCrudEnterprise();
  $crud->setCsrfTokenName(csrf_token());
  $crud->setCsrfTokenValue(csrf_hash());
  $crud->setTable('coupon_sent');
  $crud->setSubject('Coupon Sent', 'Coupon Sent');
    $crud->where([
    'coupon_sent.coupon_code'    =>$cid
  ]);  
 
     //   Access Start
    // Checking access user Start ################
  $session = session();
  $uri = service('uri'); 
  @$admin_id=$session->get('adminLoggedin');  
  $addFlag=0; 
  $editFlag=0; 
  $deleteFlag=0;
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>1){
    $uri1=@$uri->getSegment(2); 
  } 
  if(count(@$uri->getSegments())>2){
    $uri2=@$uri->getSegment(3); 
  } 
  if(count(@$uri->getSegments())>3){
   $uri3=@$uri->getSegment(4);  
 } 
 if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$this->userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$this->userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$this->userModel->customQuery($sql); 
          if($access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
            if($access_modules[0]->segment_3=='add'){
             $addFlag=1;
           }
           if($access_modules[0]->segment_3=='edit'){
             $editFlag=1;
           }
           if($access_modules[0]->segment_3=='delete'){
            $deleteFlag=1;
          }
        }
      }
    }
  }
}
}else{
 return redirect()->to(base_url().'/supercontrol/Login'); 
}
$crud->unsetAdd();
 $crud->unsetEdit();
if($addFlag==0){
  
}
if($editFlag==0){

}
if($deleteFlag==0){
  
}
if($viewFlag==0){
 echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
}
// Checking Access user END##############
    // Access END
$crud->fieldType('id','hidden'); 
$crud->callbackBeforeInsert(function ($stateParameters) {
  $stateParameters->data['id'] =  time();
  return $stateParameters;
});
 
$output = $crud->render();
return $this->_example_output($output);
}
    
    
      
    
    
    public function couponUses($cid)
 {
  $crud = $this->_getGroceryCrudEnterprise();
  $crud->setCsrfTokenName(csrf_token());
  $crud->setCsrfTokenValue(csrf_hash());
  $crud->setTable('coupon_uses');
  $crud->setSubject('Coupon Uses', 'Coupon Uses');
  $crud->where([
    'coupon_uses.coupon_code'    =>$cid
  ]); 
 
     //   Access Start
    // Checking access user Start ################
  $session = session();
  $uri = service('uri'); 
  @$admin_id=$session->get('adminLoggedin');  
  $addFlag=0; 
  $editFlag=0; 
  $deleteFlag=0;
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>1){
    $uri1=@$uri->getSegment(2); 
  } 
  if(count(@$uri->getSegments())>2){
    $uri2=@$uri->getSegment(3); 
  } 
  if(count(@$uri->getSegments())>3){
   $uri3=@$uri->getSegment(4);  
 } 
 if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$this->userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$this->userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$this->userModel->customQuery($sql); 
          if($access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
            if($access_modules[0]->segment_3=='add'){
             $addFlag=1;
           }
           if($access_modules[0]->segment_3=='edit'){
             $editFlag=1;
           }
           if($access_modules[0]->segment_3=='delete'){
            $deleteFlag=1;
          }
        }
      }
    }
  }
}
}else{
 return redirect()->to(base_url().'/supercontrol/Login'); 
}
$crud->unsetAdd();
 $crud->unsetEdit();
if($addFlag==0){
  
}
if($editFlag==0){

}
if($deleteFlag==0){
  
}
if($viewFlag==0){
 echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
}
// Checking Access user END##############
    // Access END
$crud->fieldType('id','hidden'); 
$crud->callbackBeforeInsert(function ($stateParameters) {
  $stateParameters->data['id'] =  time();
  return $stateParameters;
});
 
$output = $crud->render();
return $this->_example_output($output);
}
    
    
    
    
    
    
    
    
    
    
 public function generic()
 {
  $crud = $this->_getGroceryCrudEnterprise();
  $crud->setCsrfTokenName(csrf_token());
  $crud->setCsrfTokenValue(csrf_hash());
  $crud->setTable('coupon');
  $crud->setSubject('Generic Coupon', 'Generic Coupon');
  $crud->where([
    'coupon.coupon_type'    => 'generic'
  ]); 
  $crud->callbackAddField('coupon_type', function ($fieldType, $fieldName) {
    return '<input class="form-control" name="coupon_type" type="readonly" value="generic">';
  });
  $crud->unsetColumns(['coupon_type','description']);
  $crud->callbackColumn('coupon_uses', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponUses/' . $row->coupon_code) . "'>Coupon Uses</a>";
  });
  $crud->callbackColumn('coupon_sent', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponSent/' . $row->coupon_code) . "'>Coupon Sent</a>";
  });
     //   Access Start
    // Checking access user Start ################
  $session = session();
  $uri = service('uri'); 
  @$admin_id=$session->get('adminLoggedin');  
  $addFlag=0; 
  $editFlag=0; 
  $deleteFlag=0;
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>1){
    $uri1=@$uri->getSegment(2); 
  } 
  if(count(@$uri->getSegments())>2){
    $uri2=@$uri->getSegment(3); 
  } 
  if(count(@$uri->getSegments())>3){
   $uri3=@$uri->getSegment(4);  
 } 
 if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$this->userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$this->userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$this->userModel->customQuery($sql); 
          if($access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
            if($access_modules[0]->segment_3=='add'){
             $addFlag=1;
           }
           if($access_modules[0]->segment_3=='edit'){
             $editFlag=1;
           }
           if($access_modules[0]->segment_3=='delete'){
            $deleteFlag=1;
          }
        }
      }
    }
  }
}
}else{
 return redirect()->to(base_url().'/supercontrol/Login'); 
}
if($addFlag==0){
  $crud->unsetAdd();
}
if($editFlag==0){
 $crud->unsetEdit();
}
if($deleteFlag==0){
 $crud->unsetDelete();
 $crud->unsetDeleteMultiple();
}
if($viewFlag==0){
 echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
}
// Checking Access user END##############
    // Access END
$crud->fieldType('id','hidden'); 
$crud->callbackBeforeInsert(function ($stateParameters) {
  $stateParameters->data['id'] =  time();
  return $stateParameters;
});
$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
$crud->unsetFields(['coupon_uses','coupon_sent','created_at','updated_at']);
$crud->requiredFields(['coupon_code','status','title','start_date','end_date','type','value']);
$crud->uniqueFields(['coupon_code']);
$output = $crud->render();
return $this->_example_output($output);
}
public function specific()
{
  $crud = $this->_getGroceryCrudEnterprise();
  $crud->setCsrfTokenName(csrf_token());
  $crud->setCsrfTokenValue(csrf_hash());
  $crud->setTable('coupon');
  $crud->where([
    'coupon.coupon_type'    => 'specific'
  ]);
  $crud->callbackAddField('coupon_type', function ($fieldType, $fieldName) {
    return '<input class="form-control" name="coupon_type" type="readonly" value="specific">';
  });
  
   $crud->unsetColumns(['coupon_type','description']);
  $crud->callbackColumn('coupon_uses', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponUses/' . $row->coupon_code) . "'>Coupon Uses</a>";
  });
  $crud->callbackColumn('coupon_sent', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponSent/' . $row->coupon_code) . "'>Coupon Sent</a>";
  });
  
  $crud->setSubject('Specific Coupon', 'Specific Coupon');
     //   Access Start
    // Checking access user Start ################
  $session = session();
  $uri = service('uri'); 
  @$admin_id=$session->get('adminLoggedin');  
  $addFlag=0; 
  $editFlag=0; 
  $deleteFlag=0;
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>1){
    $uri1=@$uri->getSegment(2); 
  } 
  if(count(@$uri->getSegments())>2){
    $uri2=@$uri->getSegment(3); 
  } 
  if(count(@$uri->getSegments())>3){
   $uri3=@$uri->getSegment(4);  
 } 
 if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$this->userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$this->userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$this->userModel->customQuery($sql); 
          if($access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
            if($access_modules[0]->segment_3=='add'){
             $addFlag=1;
           }
           if($access_modules[0]->segment_3=='edit'){
             $editFlag=1;
           }
           if($access_modules[0]->segment_3=='delete'){
            $deleteFlag=1;
          }
        }
      }
    }
  }
}
}else{
 return redirect()->to(base_url().'/supercontrol/Login'); 
}
if($addFlag==0){
  $crud->unsetAdd();
}
if($editFlag==0){
 $crud->unsetEdit();
}
if($deleteFlag==0){
 $crud->unsetDelete();
 $crud->unsetDeleteMultiple();
}
if($viewFlag==0){
 echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
}
// Checking Access user END##############
    // Access END
$crud->fieldType('id','hidden'); 
$crud->callbackBeforeInsert(function ($stateParameters) {
  $stateParameters->data['id'] =  time();
  return $stateParameters;
});
$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
$crud->unsetFields(['coupon_uses','coupon_sent','created_at','updated_at']);
$crud->requiredFields(['coupon_code','status','title','start_date','end_date','type','value']);
$crud->uniqueFields(['coupon_code']);
$output = $crud->render();
return $this->_example_output($output);
}
public function oneTimeCoupon()
{
  $crud = $this->_getGroceryCrudEnterprise();
  $crud->setCsrfTokenName(csrf_token());
  $crud->setCsrfTokenValue(csrf_hash());
  $crud->setTable('coupon');
  $crud->where([
    'coupon.coupon_type'    => 'one_time_coupon'
  ]);
  $crud->callbackAddField('coupon_type', function ($fieldType, $fieldName) {
    return '<input class="form-control" name="coupon_type" type="readonly" value="one_time_coupon">';
  });
   $crud->unsetColumns(['coupon_type','description']);
  $crud->callbackColumn('coupon_uses', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponUses/' . $row->coupon_code) . "'>Coupon Uses</a>";
  });
  $crud->callbackColumn('coupon_sent', function ($value, $row) {
    return "<a href='" . site_url('supercontrol/Coupon/couponSent/' . $row->coupon_code) . "'>Coupon Sent</a>";
  });
  $crud->setSubject('one Time Coupon', 'one Time Coupon');
     //   Access Start
    // Checking access user Start ################
  $session = session();
  $uri = service('uri'); 
  @$admin_id=$session->get('adminLoggedin');  
  $addFlag=0; 
  $editFlag=0; 
  $deleteFlag=0;
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>1){
    $uri1=@$uri->getSegment(2); 
  } 
  if(count(@$uri->getSegments())>2){
    $uri2=@$uri->getSegment(3); 
  } 
  if(count(@$uri->getSegments())>3){
   $uri3=@$uri->getSegment(4);  
 } 
 if(@$admin_id){
  $accessFlag=0;
  $viewFlag=0;
  $sql="select * from access_group_master where  admin_id='$admin_id' ";
  $access_group_master=$this->userModel->customQuery($sql); 
  if($access_group_master){
    foreach($access_group_master as $k1=>$v1) {
      $group_id=$v1->group_id;
      $sql="select * from groups_assigned where  group_id='$group_id' ";
      $groups_assigned=$this->userModel->customQuery($sql); 
      if($groups_assigned){
        foreach($groups_assigned as $k2=>$v2){ 
          $access_modules_id=$v2->access_modules_id;
          $sql="select * from access_modules where  access_modules_id='$access_modules_id' ";
          $access_modules=$this->userModel->customQuery($sql); 
          if($access_modules[0]->segment_1==$uri1) {
            $viewFlag=1;
            if($access_modules[0]->segment_3=='add'){
             $addFlag=1;
           }
           if($access_modules[0]->segment_3=='edit'){
             $editFlag=1;
           }
           if($access_modules[0]->segment_3=='delete'){
            $deleteFlag=1;
          }
        }
      }
    }
  }
}
}else{
 return redirect()->to(base_url().'/supercontrol/Login'); 
}
if($addFlag==0){
  $crud->unsetAdd();
}
if($editFlag==0){
 $crud->unsetEdit();
}
if($deleteFlag==0){
 $crud->unsetDelete();
 $crud->unsetDeleteMultiple();
}
if($viewFlag==0){
 echo "You do not have sufficient privileges to access this page . please contact admin for more information.";exit;
}
// Checking Access user END##############
    // Access END
$crud->fieldType('id','hidden'); 
$crud->callbackBeforeInsert(function ($stateParameters) {
  $stateParameters->data['id'] =  time();
  return $stateParameters;
});
$crud->setFieldUpload('image', 'assets/uploads', base_url() . '/assets/uploads');
$crud->unsetFields(['coupon_uses','coupon_sent','created_at','updated_at']);
$crud->requiredFields(['coupon_code','status','title','start_date','end_date','type','value']);
$crud->uniqueFields(['coupon_code']);
$output = $crud->render();
return $this->_example_output($output);
}
private function _example_output($output = null) {
  if (isset($output->isJSONResponse) && $output->isJSONResponse) {
   header('Content-Type: application/json; charset=utf-8');
   echo $output->output;
   exit;
 }
 echo  view('/Supercontrol/Common/Header', (array)$output);
 echo  view('/Supercontrol/Crud.php', (array)$output);
 echo  view('/Supercontrol/Common/Footer', (array)$output);
}
private function _getDbData() {
  $db = (new \Config\Database())->default;
  return [
   'adapter' => [
    'driver' => 'Pdo_Mysql',
    'host'     => $db['hostname'],
    'database' => $db['database'],
    'username' => $db['username'],
    'password' => $db['password'],
    'charset' => 'utf8'
  ]
];
}
private function _getGroceryCrudEnterprise($bootstrap = true, $jquery = true) {
  $db = $this->_getDbData();
  $config = (new \Config\GroceryCrudEnterprise())->getDefaultConfig();
  $groceryCrud = new GroceryCrud($config, $db);
  return $groceryCrud;
}
}