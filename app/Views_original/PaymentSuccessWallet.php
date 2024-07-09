 
 <div class="container-fluid p-0 bg-light pb-5">
<?php include 'Common/Breadcrumb.php';?>
 
    <div class="row justify-content-center">
        <div class="col-xl-5 col-md-6">
            <div class="payment_box bg-white shadow-m">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z"/></svg>
                </div>
                <h4>Thank you! Your transaction completed successfully!</h4>
                <ul>
                    <li><span>Order ID : </span><span><?php echo @$data[0]->order_id;?></span></li>
                    <li><span>Total Amount : </span><span><?php echo  (@$data[0]->total);?> AED </span></li>
                    <li><span>Payment method : </span><span>Online Payment</span></li>
                    <li><span>Payment status : </span><span>Paid</span></li>
                    
                </ul>
                <a href="<?php echo base_url();?>/profile/Wallet" class="btn btn-primary w-100 rounded-pill">Go to my wallet</a>
            </div>
        </div>
    </div>
</div>

 