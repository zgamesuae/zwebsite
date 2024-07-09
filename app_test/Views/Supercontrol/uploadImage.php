<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);
$sql="select * from master_category where parent_id='0'";
$master_category=$userModel->customQuery($sql);
$cid=$uri->getSegment(4);
?>

<script src="<?php echo base_url();?>/assets/dropzone.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>/assets/dropzone.min.css">
 

<script>
	import Dropzone from "dropzone";
// Make sure Dropzone doesn't try to attach itself to the
// element automatically.
// This behaviour will change in future versions.
Dropzone.autoDiscover = false;
let myDropzone = new Dropzone("#my-form");
myDropzone.on("addedfile", file => {
	console.log(`File added: ${file.name}`);
});
</script>


<!-- BEGIN: Content-->
<div class="app-content content">
 <div class="content-overlay"></div>
 <div class="content-wrapper">
  <?php include 'Common/Breadcrumb.php';?>
  <div class="content-body"> 
   <div class="row">
    <div class="col-12">
     <div class="card">
      <div class="card-content">
       <div class="card-body">
            <div class="row col-12 my-5">
              <h3>Product main images</h3>
              <form  action="<?php echo base_url();?>/supercontrol/Products/upload" class="dropzone col-12" enctype="multipart/form-data">
              </form>
            </div>
           
            <div class="row col-12 my-5">
              <h3>Product screenshots</h3>
              <form  action="<?php echo base_url();?>/supercontrol/Products/upload_screenshots" class="dropzone col-12" enctype="multipart/form-data">
              </form>
            </div>
            
            <div class="row col-12 my-5">
              <h3>Other images</h3>
              <form  action="<?php echo base_url();?>/supercontrol/Products/upload_other" class="dropzone col-12" enctype="multipart/form-data">
              </form>
            </div>
               
               
           </form>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
</div>
</div>
