<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);


if(@$_GET['start'] !="" AND @$_GET['end']!=""){
    $s=@$_GET['start'];
    $e=@$_GET['end'];
   $sql="select *  from orders where date(created_at) between '$s' and '$e'  order by created_at desc"; 
}else{
   $sql="select  * from  orders order by created_at desc"; 
}
    
$orders=$userModel->customQuery($sql);
 ?>
 
 <style>td{
     font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff!important;
    white-space: nowrap !important;
    vertical-align: middle !important;
    padding: 10px!important;
    background: white!important;
    border: 1px solid #dee2e694!important;
 }
    </style>
 

<!-- BEGIN: Content-->
<div class="app-content content">
 <div class="content-overlay"></div>
 <div class="content-wrapper">
  <?php include 'Common/Breadcrumb.php';?>
  <div class="content-body"><!-- Basic Tables start -->
   <div class="row">
    <div class="col-12">
     <div class="card">
      <div class="card-content  ">
       <div class="card-body">
           
         
         <form>
             <div class="row mb-10" style="margin-bottom: 15px;"> 
                 <div class="col-md-4">
                     <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" required name="start" value="<?php echo @$_GET['start']?>">
                 </div>
                 <div class="col-md-4">
                      <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" required name="end" value="<?php echo @$_GET['end']?>">
                 </div>
                 <div class="col-md-4">
                     
                      <input type="submit" class="btn btn-primary" value="Filter" >
                 </div>
             </div>
             </form>
         
         
         
             <table id="dateWiseOrder"  class=" " style="width:100%; " >
        <thead>
            <tr>
                 <th>Sl.No.</th>
                <th>order_id</th>
                <th>user_id</th>
                <th>name</th>
                 <th>email</th>
                  <th>phone</th>
                   <th>total</th> 
                   
                   
                    <th>payment_method</th>
                 <th>payment_status</th>
                  <th>order_status</th>
                   <th>created_at</th> 
               
            </tr>
        </thead>
        <tbody>
            <?php if($orders) {
            
            foreach($orders as $k=>$v){
                
                
            ?>
            <tr>
                   
                <td><?php echo $k+1;?></td>
    <td><?php echo $v->order_id;?></td>
   <td><?php echo $v->user_id;?></td>
   <td><?php echo $v->name;?></td>
   <td><?php echo $v->email;?></td>
   <td><?php echo $v->phone;?></td>
   <td><?php echo $v->total;?></td> 
   <td><?php echo $v->payment_method;?></td>
   <td><?php echo $v->payment_status;?></td>
   <td><?php echo $v->order_status;?></td>
   <td><?php echo $v->created_at;?></td> 
                  
                
            </tr>
           <?php }} ?>
        </tbody>
        
    </table>
         
         
         
         
         
         
         
         
         
         
         
         
         
         
           
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

 


 
    
     
 

 