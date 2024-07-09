 <style>
 .toys_box img{
     width:100%;
 }.toys_box {
    padding: 33px 16px 4px 16px;
    margin-bottom: 32px;
}
.toys_box h5 {
    font-weight: bold;
    text-transform: capitalize;
    font-size: 17px;
    text-align: center;
    margin-top: 18px;
}
 </style>
<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from user_address where user_id='$user_id' order by created_at desc";
  $user_address=$userModel->customQuery($sql);
}
 $sql="select * from cms ";
  $cms=$userModel->customQuery($sql);
?>
<div class="container-fluid p-0 bg-light pb-5">
  <?php include 'Common/Breadcrumb.php';?>
  <div class="container pb-5 mb-2 mb-md-4  pt-5">
    <div class="row">
      <div class="col-12 mb-2">
        <div class="heading text-capitalize " >
          <h4 class="font-weight-bold">My Address</h4>
        </div>
      </div>
      <div class="col-lg-4">
        <?php include 'Common/UserMenu.php';?>
      </div>
      <section class="col-lg-8">
       <div class="row">
            <div class="col-sm-12 bg-white rounded shadow-sm">
              <h5 class="mt-3"><strong><?php echo @$cms[7]->heading;?></strong></h5>
             
              
              <p class="text-gray"><?php echo strip_tags(@$cms[7]->description);?></p>
              <div class="row">
                  
                 <?php
$session = session();

 

$userModel = model('App\Models\UserModel', false);
 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id!=""  ){
        $sql="select * from kids where user_id='$user_id'  ";
$kids=$userModel->customQuery($sql);
 
}

if($kids){
    foreach($kids as $k=> $v){ 
?>
                <div class="col-md-4 col-sm-6">
                  <div class="toys_box shadow-sm bg-white rounded">
                    <a><img src="<?php echo base_url();?>/assets/uploads/<?php if($v->image) echo $v->image;else echo 'noimg.png';?>" alt=""></a>
                    <h5 class="text-center"><?php echo $v->name;?> <br> <a href="<?php echo base_url();?>/profile/editKids/<?php echo $v->kids_id;?>">Edit</a> | <a href="<?php echo base_url();?>/profile/deleteKids/<?php echo $v->kids_id;?>">Delete</a></h5>
                  </div>
                </div>
                
                 <?php
                 }
                 }
                 
                 ?>
                
                
              </div>
            </div>
          </div>
</section>
<!-- Sidebar-->
</div>
</div>
</div>
