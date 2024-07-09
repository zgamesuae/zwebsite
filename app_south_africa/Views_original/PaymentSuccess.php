 
 <?php
    global $userModel,$orderModel,$brandModel;

    $userModel = model('App\Models\UserModel', false);
    $orderModel = model("App\Models\OrderModel");
    $brandModel = model("App\Models\BrandModel");


    $sql="select * from cms";
    $cms=$userModel->customQuery($sql);

    // echo(base64_encode("16555613953"));die();
 ?>

<?php
//   var_dump($products);die();

?>
 
 <div class="container-fluid  bg-light pb-5" style="background-image:url('<?php echo base_url();?>/assets/uploads/<?php echo @$cms[15]->image;?>'); background-size:cover;">
<?php include 'Common/Breadcrumb.php';?>
 
    <div class="row justify-content-center">
        <div class="col-xl-5 col-md-6">
            <div class="payment_box bg-white shadow-m">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z"/></svg>
                </div>
                <h4><?php echo @$cms[15]->heading;?></h4>
                <ul>
                    <li><span>Order ID : </span><span><?php echo @$order[0]->order_id;?></span></li>
                    <li><span>Total Amount : </span><span><?php echo bcdiv(@$order[0]->total, 1, 2);?> AED </span></li>
                    <li><span>Payment method : </span><span><?php echo @$order[0]->payment_method;?></span></li>
                    <li><span>Payment status : </span><span><?php echo @$order[0]->payment_status;?></span></li>
                    <li><span>Order status : </span><span><?php echo @$order[0]->order_status;?></span></li>
                </ul>
                <a href="<?php echo base_url();?>/profile/myOrders" class="btn btn-primary w-100 rounded-pill">Go to my orders</a>  
            </div>
        </div>
    </div>
</div>



 