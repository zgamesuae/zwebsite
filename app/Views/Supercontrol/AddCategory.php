<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);
$sql="select * from master_category where     parent_id='0'";
$master_category=$userModel->customQuery($sql);
$cid=$uri->getSegment(4);
$sql="select * from master_category where     category_id='$cid'";
@$editcat=$userModel->customQuery($sql);
$category_id=$editcat[0]->category_id;


$sql="select * from category_image where     category='$category_id' ";
@$cat_image=$userModel->customQuery($sql);
?>   

<style>input[type=file]{display:block}.imageThumb{max-height:75px;border:2px solid;padding:1px;cursor:pointer}.pip{display:inline-block;margin:10px 10px 0 0}.remove{display:block;background:#444;border:1px solid #000;color:#fff;text-align:center;cursor:pointer}.remove:hover{background:#fff;color:#000}</style>

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
        <form   method="post" enctype="multipart/form-data">
         <?php if (@$editcat[0]->category_id) {
          ?>
          <input type="hidden" name="category_id" value="<?php echo @$editcat[0]->category_id ?>">
          <?php
        }
        ?>
        <h4 class="form-section"><i class="fa fa-<?php      if(count(@$uri->getSegments())>2){   if(@$uri->getSegment(3)=='add') echo 'plus';else echo 'edit';   } ?>"></i> 
         <?php      if(count(@$uri->getSegments())>2){   echo  ucwords(@$uri->getSegment(3));   } ?>
       Category Form</h4>
       <!-- Tab panes -->
       <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a class="nav-link  <?php      if(count(@$uri->getSegments())<5){   echo 'active';   } ?>" id="BasicInfo-tab" data-toggle="tab" href="#BasicInfo" aria-controls="active" aria-expanded="true">Basic Info</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " id="Arabic-tab" data-toggle="tab" href="#Arabic" aria-controls="link" aria-expanded="false">Arabic</a>
        </li>
        <li class="nav-item">
          <a class="nav-link    <?php      if(count(@$uri->getSegments())>4){   echo 'active';   } ?>" id="Images-tab" data-toggle="tab" href="#Images" aria-controls="Images">Image</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="SEO-tab" data-toggle="tab" href="#SEO" aria-controls="SEO">SEO</a>
        </li>
      </ul>
      <div class="tab-content px-1 pt-1">
        <div role="tabpanel"   class="tab-pane   <?php      if(count(@$uri->getSegments())<5){   echo 'active';   } ?>"   role="tabpanel" aria-labelledby="link-tab" aria-expanded="false" id="BasicInfo"  >
          <div class="form-group row">
            <label for="input-1" class="col-sm-3 col-form-label">Parent Category</label>
            <div class="col-sm-9">
             <select name="parent_id" id="" class="form-control"  <?php //if(@$editcat[0]->parent_id!="") echo 'disabled'; ?>  >
              <option value="0" selected="selected">Choose Parent Category</option>
              <?php 
              if ($master_category) {
               foreach ($master_category as $key => $value) {
                ?>
                <!-- ##########  level 1-->
                <option <?php if(@$editcat[0]->parent_id==$value->category_id) echo 'selected'; ?> value="<?php echo $value->category_id; ?>"> <?php echo $value->category_name; ?></option>
                <!-- ##########  level 2-->
                <?php 
                $pid=$value->category_id;
                $sql="select * from master_category where  status='Active' and parent_id='$pid' ";
                $master_category2=$userModel->customQuery($sql);
                if ($master_category2) {
                 foreach ($master_category2 as $key2 => $value2) {
                  ?>
                  <option <?php if(@$editcat[0]->parent_id==$value2->category_id) echo 'selected'; ?> value="<?php echo $value2->category_id; ?>">&nbsp&nbsp&nbsp&nbsp<?php echo $value2->category_name; ?></option> 
                  <?php 
                  $pid2=$value2->category_id;
                  $sql="select * from master_category where  status='Active' and parent_id='$pid2' ";
                  $master_category3=$userModel->customQuery($sql);
                  /*if ($master_category3) {
                   foreach ($master_category3 as $key3 => $value3) {
                    ?>
                    <option <?php if(@$editcat[0]->parent_id==$value3->category_name) echo 'selected'; ?> value="<?php echo $value3->category_id; ?>">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value3->category_name; ?></option> 
                    <?php 
                    $pid3=$value3->category_id;
                    $sql="select * from master_category where  status='Active' and parent_id='$pid3' ";
                    $master_category4=$userModel->customQuery($sql);
                    if ($master_category4) {
                     foreach ($master_category4 as $key4 => $value4) {
                      ?>
                      <option <?php if(@$editcat[0]->parent_id==$value4->category_id) echo 'selected'; ?> value="<?php echo $value4->category_id; ?>">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value4->category_name; ?></option> 
                    <?php }
                  } ?>
                <?php 
                       
                   }
                      
                  } */
                ?>
                <?php 
              }
            }
          ?>  <!-- ##########  leve 2 END-->
          <?php }} ?> <!-- ##########  leve 1 END-->
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Category Name*</label>
      <div class="col-sm-9">
       <input type="text" class="form-control"  name="category_name" required="" value="<?php echo @$editcat[0]->category_name ?>">
     </div>
   </div>
   
   
   
   
   
   
   
   
   
   
   <div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Category Description</label>
    <div class="col-sm-9">
     <textarea name="category_description" class="form-control texteditor"><?php echo @$editcat[0]->category_description ?></textarea>
   </div>
 </div>
 
 
   <div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Color Name</label>
    <div class="col-sm-9">
    <input type="text" class="form-control"  name="color_name"   value="<?php echo @$editcat[0]->color_name ?>">
   </div>
 </div>
 
 
   <div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Precedence*</label>
    <div class="col-sm-9">
    <input type="number" class="form-control"  name="precedence" required="" value="<?php echo @$editcat[0]->precedence ?>">
   </div>
 </div>
 
 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Show category page*</label>
  <div class="col-sm-9">
   <select name="show_category_page" required="" class="form-control">
    <option value="">Select option</option>
    <option <?php if(@$editcat[0]->show_category_page=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
    <option <?php if(@$editcat[0]->show_category_page=="No") echo 'selected'; ?> value="No">No</option>
  </select>
</div>
</div>

<div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Show in menu*</label>
    <div class="col-sm-9">
        <select name="show_in_menu" required="" class="form-control">
            <option value="">Select option</option>
            <option <?php if(@$editcat[0]->show_in_menu=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
            <option <?php if(@$editcat[0]->show_in_menu=="No") echo 'selected'; ?> value="No">No</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="slug" class="col-sm-3 col-form-label">Slug (URL alternative)*</label>
    <div class="col-sm-9">
    <input type="text" class="form-control"  name="slug" required="" value="<?php echo @$editcat[0]->slug ?>">
   </div>
 </div>

 
 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Status*</label>
  <div class="col-sm-9">
   <select name="status" required="" class="form-control">
    <option value="">Select status</option>
    <option <?php if(@$editcat[0]->status=="Active") echo 'selected'; ?>  selected="" value="Active">Active</option>
    <option <?php if(@$editcat[0]->status=="Inactive") echo 'selected'; ?> value="Inactive">Inactive</option>
  </select>
</div>
</div>
</div>
<div class="tab-pane  " id="Arabic" role="tabpanel" aria-labelledby="Arabic-tab" aria-expanded="false">
 <div class="form-group row">
  <label for="input-1" class="col-sm-3 col-form-label">Category Name Arabic </label>
  <div class="col-sm-9">
   <input type="text" class="form-control"  name="category_name_arabic"  value="<?php echo @$editcat[0]->category_name_arabic ?>">
 </div>
</div>
<div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Category Description Arabic </label>
  <div class="col-sm-9">
   <textarea name="category_description_arabic" class="form-control texteditor"><?php echo @$editcat[0]->category_description_arabic ?></textarea>
 </div>
</div>
</div>
<div class="tab-pane  <?php      if(count(@$uri->getSegments())>4){   echo 'active';   } ?>" id="Images" role="tabpanel" aria-labelledby="Images-tab" aria-expanded="false">
 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Category image </label>
  <div class="col-sm-10 ">
   <input  id="files" type="file" multiple name="file[]" class="form-control"    >
   <?php 
   if($cat_image){
       foreach($cat_image as $k=>$v){ 
   ?>
   <span class="pip"><img class="imageThumb" src="<?php echo base_url(); ?>/assets/uploads/<?php if($v->image) echo $v->image; ?>" title="undefined"><br><a href="<?php echo base_url();?>/supercontrol/Category/deleteImage/<?php echo $v->id;?>/<?php echo $category_id;?>" class="remove">Remove image</a></span>
    
  
     <?php
   }
   }
   ?>
   
 </div>
  </div> 
</div>
<div class="tab-pane" id="SEO" role="tabpanel" aria-labelledby="SEO-tab" aria-expanded="false">
  <div class="form-group row">
    <label for="input-1" class="col-sm-3 col-form-label">Page Title </label>
    <div class="col-sm-9">
     <input type="text" class="form-control"  name="page_title"  value="<?php echo @$editcat[0]->page_title ?>">
   </div>
 </div>
 <div class="form-group row">
  <label for="input-1" class="col-sm-3 col-form-label">Page Keywords </label>
  <div class="col-sm-9">
   <input type="text" class="form-control"  name="page_keywords"  value="<?php echo @$editcat[0]->page_keywords ?>">
 </div>
</div>
<div class="form-group row">
  <label for="input-1" class="col-sm-3 col-form-label">Page Description </label>
  <div class="col-sm-9">
   
    <textarea name="page_description" class="form-control texteditor"><?php echo @$editcat[0]->page_description ?></textarea>
 </div>
</div>
<div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Other Meta tag </label>
  <div class="col-sm-9">
   <textarea name="other_meta_tag" class="form-control texteditor"><?php echo @$editcat[0]->other_meta_tag ?></textarea>
 </div>
</div>
</div>
</div>
<div class="form-footer">
  <a   href="<?php echo base_url();?>/supercontrol/Category/"  class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</a>
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