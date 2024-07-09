<?php
$session = session();

$uri = service('uri'); 
   if(count(@$uri->getSegments())>2){
       $uri1=@$uri->getSegment(3); 
   }

$userModel = model('App\Models\UserModel', false);
 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id!="" && $uri1!=""){
        $sql="select * from user_address where user_id='$user_id' AND address_id=$uri1";
$user_address=$userModel->customQuery($sql);
 
}


 $sql="select * from city where status='Active' AND city_id !='all'";
$city=$userModel->customQuery($sql);
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
               <h4><strong>Update Address </strong></h4>
         
        </div>
                <section class="col-lg-12 pt-3">
                    <form method="post"   >
                         <input class="form-control" name="address_id"     type="hidden" required placeholder="Street" value="<?php echo @$user_address[0]->address_id;?>">
                    <div class="row">
                        
                       
                        
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Name</label>
                          <input class="form-control" name="name" required   type="text" required placeholder="Name" value="<?php echo @$user_address[0]->name;?>"> 
                        </div>
                      </div>
                      
                      
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Street</label>
                          <input class="form-control" name="street" required   type="text" required placeholder="Street" value="<?php echo @$user_address[0]->street;?>">
                        </div>
                      </div>
                      
                      
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Apartment/House No.</label>
                          <input class="form-control" name="apartment_house" required  type="text" required placeholder="Apartment/House No." value="<?php echo @$user_address[0]->apartment_house;?>">
                        </div>
                      </div>
                      
                      
                      
                         <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">City</label>
                     <select name="city" required class="form-control">
                              
                              <option value="">Select city</option>
                              
                              <?php if($city){
                              foreach($city as $k=>$v){
                                  ?>
                                  
                                   <option <?php if($user_address[0]->city==$v->city_id) echo 'selected';?> value="<?php echo $v->city_id;?>"><?php echo $v->title;?></option>
                                  <?php
                              }
                              }?>
                              
                          </select>
                          
                          </div>
                      </div>
                      
                        
                        <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Address</label>
                          <input class="form-control" name="address" required  type="text" required placeholder="Address" value="<?php echo @$user_address[0]->address;?>">
                        </div>
                      </div>
                      
                         <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn" >Status</label>
                           <select name="status" name="status" required class="form-control" >
                               <option value="">Select status</option>
                               
                               <option <?php  if(@$user_address[0]->status=="Active") echo 'selected';?> value="Active">Active</option>
                               
                               <option  <?php  if(@$user_address[0]->status=="Inactive") echo 'selected';?>  value="Inactive">Inactive</option>
                               
                           </select>
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








 