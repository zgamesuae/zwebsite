<?php
$session = session();

$uri = service('uri'); 
   if(count(@$uri->getSegments())>2){
       $uri1=@$uri->getSegment(3); 
   }

$userModel = model('App\Models\UserModel', false);
 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id!="" && $uri1!=""){
        $sql="select * from kids where user_id='$user_id' AND kids_id=$uri1";
$kids=$userModel->customQuery($sql);
 
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
               <h4><strong>Update Kids </strong></h4>
         
        </div>
                <section class="col-lg-12 pt-3">
                    <form method="post"  enctype="multipart/form-data">
                         <input class="form-control" name="kids_id"     type="hidden" required placeholder="Street" value="<?php echo @$kids[0]->kids_id;?>">
                    <div class="row">
                        
                       
                        
                      <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Name of your child</label>
                          <input class="form-control" name="name" required   type="text" required placeholder="Name" value="<?php echo @$kids[0]->name;?>"> 
                        </div>
                      </div>
                      
                   
                      
                      
             <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label">Birth Date</label>
                          <input class="form-control" type="date" required name="date_of_birth" value="<?php echo @$kids[0]->date_of_birth;?>">
                        </div>
                      </div>
                          <div class="col-sm-3">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn">Profile Image</label>
                          <input class="form-control" name="image"     type="file"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                        </div>
                      </div>
                       <div class="col-sm-3">
                        <div class="mb-3">
                         
                        <img id="blah" src="<?php echo base_url();?>/assets/uploads/<?php if($kids[0]->image) echo $kids[0]->image; else echo 'noimg.png';?>" alt="your image" width="70" height="70" />
                        </div>
                      </div>
                           <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label">Gender</label>
                          <div class="d-flex">
                            <div class="item_inner">
                              <input type="radio" value="Male" <?php if($kids[0]->gender=="Male") echo 'checked';?>  name="gender">
                              <span>Male</span>
                            </div>
                            <div class="ml-3 item_inner">
                              <input type="radio" value="Female" <?php if($kids[0]->gender=="Female") echo 'checked';?> name="gender">
                              <span>Female</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      
                         <div class="col-sm-6">
                        <div class="mb-3">
                          <label class="form-label" for="checkout-fn" >Status</label>
                           <select name="status" name="status" required class="form-control" >
                               <option value="">Select status</option>
                               
                               <option <?php  if(@$kids[0]->status=="Active") echo 'selected';?> value="Active">Active</option>
                               
                               <option  <?php  if(@$kids[0]->status=="Inactive") echo 'selected';?>  value="Inactive">Inactive</option>
                               
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








 