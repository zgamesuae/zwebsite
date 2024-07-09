<?php $l=1;
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);

if(@$_GET['start'] !="" AND @$_GET['end']!=""){
    $s=@$_GET['start'];
    $e=@$_GET['end'];
   $sql="select  date(created_at) as date ,count(order_id) as total_order,sum(total) as total from orders where date(created_at) between '$s' and '$e' group by date(created_at) order by date desc"; 
}else{
   $sql="select  date(created_at) as date ,count(order_id) as total_order,sum(total) as total from orders group by date(created_at) order by date desc"; 
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
             <th>Date</th>
             <th>Total orders </th>
             <th>Total orders delivered</th>
             <th>Total orders canceled</th>  
           </tr>
         </thead>
         <tbody>
          <?php if($orders) {
            foreach($orders as $k=>$v){
             $dd=$v->date;
               $sql="select   count(order_id) as coid   from orders where order_status='Delivered' AND date(created_at)='$dd'  "; 
                    $deli=$userModel->customQuery($sql);
                    
                     $sql="select   count(order_id) as coid   from orders where order_status='Canceled' AND date(created_at)='$dd'  "; 
                    $cenceld=$userModel->customQuery($sql);
                     ?>
                     
                      <tr>
                <td><?php echo   $l++;?></td>
                <td><?php echo $v->date;?></td>
                <td><?php echo bcdiv($v->total_order, 1, 2);?></td>
             
                <td><?php if($deli[0]) echo bcdiv($deli[0]->coid, 1, 2);else echo 0;?></td>
               
               
                  <td><?php if($cenceld[0]) echo bcdiv($cenceld[0]->coid, 1, 2);else echo 0;?></td>
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