<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id){
      $sql="select * from users where user_id='$user_id'";
$userDetails=$userModel->customQuery($sql);
 
}
?>

<div class="container-fluid p-0 bg-light pb-5">
<?php include 'Common/Breadcrumb.php';?>
  <div class="container pb-5 mb-2 mb-md-4  pt-5">
      <div class="row">
   <!--     <div class="col-12 mb-2">
          <div class="heading text-capitalize " >
            <h4 class="font-weight-bold">Profile</h4>
          </div>
        </div>-->
        <div class="col-lg-4">
      <?php include 'Common/UserMenu.php';?>
        </div>
        <section class="col-lg-8">
          <div class="row">
            <div class="col-sm-12 bg-white rounded shadow-sm">
           <div class="apply_procode border-weight-2 border-bottom font-weight-bold d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#promo_code">
               <h4><strong>Change Password Form </strong></h4>
         
        </div>
                <section class="col-lg-12 pt-3">
                    <form method="post"   >
                    <div class="row">
                        
                        <?php
            if(@$flashData['error']){
              ?>   <div class="col-sm-12">
                   <div class="alert alert-danger alert-dismissible mb-2" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						   <?php echo @$flashData['error'];?>
						</div>	</div>
              <?php  
            }
            ?>
             <?php
            if(@$flashData['success']){
              ?>
               <div class="col-sm-12">
            <div class="alert alert-success alert-dismissible mb-2" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
							 <?php echo @$flashData['success'];?>
						</div>
            
            		  </div>
              <?php  
            }
            ?>
                        
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Old Password</label>
                          <input class="form-control" name="old_password" required   type="password" >
                        </div>
                      </div>
                      
                      
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">New Password</label>
                          <input class="form-control" name="new_password" required   type="password" >
                        </div>
                      </div>
                      
                      
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Confirm Password</label>
                          <input class="form-control" name="confirm_password" required  type="password" >
                        </div>
                      </div>
                        
                     
                   
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <button type="submit" class="w-100 btn btn-primary">Save</button>
                        </div>
                      </div>
                    </div>
                    </form>
                  </section>
            </div>
          </div>
        </section>
        <!-- Sidebar-->
       
      </div>
     
    </div>
</div>








 