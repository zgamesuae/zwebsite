 
 <?php
 $userModel = model('App\Models\UserModel', false);
 $sql="select * from cms";
$cms=$userModel->customQuery($sql);
 
 ?>
 <div class="container-fluid  bg-light pb-5" style="background-image:url('<?php echo base_url();?>/assets/uploads/<?php echo @$cms[15]->image;?>'); background-size:cover;">
<?php include 'Common/Breadcrumb.php';?>
 
    <div class="row justify-content-center">
        <div class="col-xl-5 col-md-6">
            <div class="payment_box bg-white shadow-m">
                <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-8v6h2V7h-2z" fill="rgba(254,0,0,1)"/></svg>      </div>
                <h4>Payment failed</h4>
                <b>Transaction declined by the authorisation system.<br><br></b>
                <a href="<?php echo base_url();?>/contact-us" class="btn btn-primary w-100 rounded-pill mt-10">Contact us</a>
            </div>
        </div>
    </div>
</div>

 