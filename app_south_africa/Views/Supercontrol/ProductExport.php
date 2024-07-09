<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);


if(@$_GET['start'] !="" AND @$_GET['end']!=""){
    $s=@$_GET['start'];
    $e=@$_GET['end'];
   $sql="select *  from products where date(created_at) between '$s' and '$e'  order by created_at desc"; 
}else{
   $sql="select  * from  products order by created_at desc"; 
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
                <th>SKU</th>
                <th>Product Name</th>
                <th>Price</th>
                 <th>Stock Quantity</th>
                  <th>Brand</th>
                   <th>Parent Category</th> 
               
            </tr>
        </thead>
        <tbody>
            <?php if($orders) {
            
            foreach($orders as $k=>$v){
                
                
            ?>
            <tr>
                  <td><?php echo   $k+1;?></td>
               <td><?php echo $v->sku;?></td>
               <td><?php echo $v->name;?></td>
               <td><?php echo $v->price;?></td>
               <td><?php echo $v->available_stock;?></td>
               <td><?php 
               $sql=" select * from brand where id='$v->brand'";
               $brand=$userModel->customQuery($sql);
               echo @$brand[0]->title;
               ?></td>
               <td><?php $cid=$v->category;
               $array=explode(",",$cid);
               if($array){$l=0;
                   foreach($array as $k=>$v){
                          $sql=" select * from master_category where category_id='$v'";
               $master_category=$userModel->customQuery($sql); 
               if($master_category){
                   
                   if($l==0){
                       echo @$master_category[0]->category_name;
                   }else{
                       echo " , ".@$master_category[0]->category_name;
                   }
                   $l++;
               }
                   }
               }
               
               ?></td>
                
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

 


 
    
     
 

 