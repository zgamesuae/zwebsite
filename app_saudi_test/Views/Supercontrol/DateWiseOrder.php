<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);


if(@$_GET['start'] !="" AND @$_GET['end']!=""){
    $s=@$_GET['start'];
    $e=@$_GET['end'];
//    $sql="select  date(created_at) as date ,count(order_id) as total_order,sum(total) as total from orders where date(created_at) between '$s' and '$e' AND payment_status='Paid' group by date(created_at) order by date desc"; 
//    $sql="select date(orders.created_at) as date ,count(orders.order_id) as nbr_orders,sum(order_products.quantity) as total_qty,sum(orders.total) as total_orders from orders inner join order_products on orders.order_id=order_products.order_id where payment_status='Paid' AND date between '$s' and '$e' group by date(created_at) order by date desc";

   $sql= "select date(orders.created_at) as date ,count(orders.order_id) as nbr_orders,sum(orders.total) as total_orders from orders where payment_status='Paid' AND date(orders.created_at) between '$s' and '$e' group by date order by date desc";
}else{
//    $sql="select date(orders.created_at) as date ,count(orders.order_id) as nbr_orders,sum(order_products.quantity) as total_qty,sum(orders.total) as total_orders from orders inner join order_products on orders.order_id=order_products.order_id where payment_status='Paid' group by date order by date desc"; 
   $sql="select date(orders.created_at) as date ,count(orders.order_id) as nbr_orders,sum(orders.total) as total_orders from orders where payment_status='Paid' group by date(orders.created_at) order by date(orders.created_at) desc"; 

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
                                                <th>Nbr of orders</th>
                                                <th>Nbr of paid orders</th>
                                                <th>No. Products sold</th>
                                                <th>Total online payment(PAID)</th>
                                                <th>Total COD payment(PAID)</th>
                                                <th>Total refund</th>
                                                <th>Total(PAID WO REFUND)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- <?php  ?> -->
                                            <?php if($orders) {
                                            
                                            foreach($orders as $k=>$v){
                                                $dd=$v->date;
                                                $sql="select count(id) as pro_no , date(created_at) as date from order_products where date(created_at)='$dd'  group by date(created_at) order by date(created_at) desc";
                                                $ord_pro=$userModel->customQuery($sql);

                                                // total online payment
                                                $sql="select sum(total) as total from orders where date(created_at)='$dd' AND payment_method='Online payment' AND payment_status='Paid' group by date(created_at) order by date(created_at) desc";
                                                $Onlinepayment=$userModel->customQuery($sql);

                                                // total COD 
                                                $sql="select sum(total) as total from orders where date(created_at)='$dd' AND payment_method='Cash on delivery' AND payment_status='Paid' group by date(created_at) order by date(created_at) desc";
                                                $cod=$userModel->customQuery($sql);

                                                // total refund
                                                $sql="select sum(total) as total from orders where date(created_at)='$dd' AND payment_status='Refunded' group by date(created_at) order by date(created_at) desc";
                                                $Refunded=$userModel->customQuery($sql);
                                                
                                                // getting the total number of orders
                                                $all_orders_sql="select count(orders.order_id) as nbr_orders from orders where date(orders.created_at)='$dd' group by date(orders.created_at)";
                                                $all_orders=$userModel->customQuery($all_orders_sql);

                                                $nbr_paid_products_sql = "select sum(order_products.quantity) as qty from orders inner join order_products on orders.order_id=order_products.order_id where orders.payment_status='Paid' and date(orders.created_at) = '$dd' group by date(orders.created_at) order by date(orders.created_at) desc";
                                                $nbr_paid_products=$userModel->customQuery($nbr_paid_products_sql);
                                                // var_dump($all_orders);die();
                                            ?>
                                            <tr> 
                                                <!-- row count -->
                                                <td><?php echo   $k+1;?></td>

                                                <!-- Date -->
                                                <td><?php echo $v->date;?></td>

                                                <!-- Number of orders -->
                                                <td><?php echo $all_orders[0]->nbr_orders;?></td>

                                                 <!-- Number of paid orders -->
                                                 <td><?php echo $v->nbr_orders;?></td>

                                                <!-- Number of products sold -->
                                                <td><?php echo $nbr_paid_products[0]->qty?></td>

                                                <!-- Total online payment -->
                                                <td><?php if($Onlinepayment) echo bcdiv(@$Onlinepayment[0]->total, 1, 2);else echo 0;?></td>

                                                <!-- Total COD payment -->
                                                <td> <?php if($cod) echo bcdiv(@$cod[0]->total, 1, 2);else echo 0;?> </td>

                                                <!-- Total refund -->
                                                <td> <?php if($Refunded) echo bcdiv(@$Refunded[0]->total, 1, 2);else echo 0;?> </td>

                                                <!-- Total -->
                                                <td><?php echo bcdiv($v->total_orders, 1, 2);?></td> 
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
</div>

 


 
    
     
 

 