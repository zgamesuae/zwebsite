<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);
$cid=$uri->getSegment(4);
?>
<!-- BEGIN: Content-->
<div class="app-content content">
 <div class="content-overlay"></div>
 <div class="content-wrapper">
  <?php include 'Common/Breadcrumb.php';?>
  <div class="content-body"> 
   <div class="row">
    <div class="col-12">
     <div class="card">
      <div class="card-content  ">
       <div class="card-body">
        <form   method="post" enctype="multipart/form-data">
          <h4 class="form-section"><i class="fa fa-add"></i> Bulk upload product</i></h4>
          <div class="tab-content px-1 pt-1">
            <div class="form-group row">
              <label for="input-1" class="col-sm-3 col-form-label">Excel file (.csv)*<br><a download href="<?php echo base_url();?>/assets/uploads/sample.csv"> Download a sample format</a></label>
              <div class="col-sm-9">
               <input type="file" class="form-control"  name="file" required=""   accept=".csv">
             </div>
           </div> 
         </div>
       
       <div class="form-footer">
        <a   href="<?php echo base_url();?>/supercontrol/Products/"  class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</a>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
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
