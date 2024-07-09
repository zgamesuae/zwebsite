<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);
$sql="select * from master_category where     parent_id='0'";
$master_category=$userModel->customQuery($sql);
$cid=$uri->getSegment(4);
$sql="select * from products where     product_id='$cid'";
@$editcat=$userModel->customQuery($sql);
$product_id=@$editcat[0]->product_id;


$sql="select * from product_image where     product='$product_id' ";
@$cat_image=$userModel->customQuery($sql);

$sql="select * from product_screenshot where     product='$product_id' ";
@$product_screenshot=$userModel->customQuery($sql);


$sql="select * from brand where     status='Active' ";
@$brand=$userModel->customQuery($sql);


$sql="select * from suitable_for where     status='Active' ";
@$suitable_for=$userModel->customQuery($sql);


$sql="select * from type where     status='Active' ";
@$type=$userModel->customQuery($sql);

$sql="select * from color where     status='Active' ";
@$color=$userModel->customQuery($sql);

$sql="select * from age where     status='Active' ";
@$age=$userModel->customQuery($sql);




  $sql="select * from attributes where     product_id='$product_id' and type='type' ";
@$ptype=$userModel->customQuery($sql);



  $sql="select * from attributes where     product_id='$product_id' and type='suitable_for' ";
@$stype=$userModel->customQuery($sql);


  $sql="select * from attributes where     product_id='$product_id' and type='age' ";
@$sage=$userModel->customQuery($sql);


  $sql="select * from attributes where     product_id='$product_id' and type='color' ";
@$scolor=$userModel->customQuery($sql);


 $sql="select * from products where     status='Active' ";
@$rel=$userModel->customQuery($sql);
?>   

<style>
 
.multi{
   height: 200px !important;
}
#editor{
    border: 1px solid #cacfe7;
    color: #3b4781;}
    input[type=file]{display:block}.imageThumb{height:122px;border:2px solid;padding:1px;cursor:pointer}.pip{display:inline-block;margin:10px 10px 0 0}.remove{display:block;background:#444;border:1px solid #000;color:#fff;text-align:center;cursor:pointer}.remove:hover{background:#fff;color:#000}
    </style>

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
           
            
         <?php if (@$editcat[0]->product_id) {
          ?>
          <input type="hidden" name="product_id" value="<?php echo @$editcat[0]->product_id ?>">
          <?php
        }
        ?>
        <h4 class="form-section"><i class="fa fa-<?php      if(count(@$uri->getSegments())>2){   if(@$uri->getSegment(3)=='add') echo 'plus';else echo 'edit';   } ?>"></i> 
         <?php      if(count(@$uri->getSegments())>2){   echo  ucwords(@$uri->getSegment(3));   } ?>
       Product Form</h4>
       <!-- Tab panes -->
       <?php 
       if(@$validation){
       ?>
         <div class="alert alert-danger" role="alert">
 <?php  
 print_r(@$validation);
 ?>
</div>
       <?php
       } 
       ?>
       
       
       <ul class="nav nav-tabs nav-justified">
        <li class="nav-item">
          <a class="nav-link  <?php      if(count(@$uri->getSegments())<5){   echo 'active';   } ?>" id="BasicInfo-tab" data-toggle="tab" href="#BasicInfo" aria-controls="active" aria-expanded="true">Basic Info</a>
        </li>
       <!-- <li class="nav-item">
          <a class="nav-link " id="Arabic-tab" data-toggle="tab" href="#Arabic" aria-controls="link" aria-expanded="false">Arabic</a>
        </li>-->
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
            <label for="input-1" class="col-sm-3 col-form-label">Category*</label>
            <div class="col-sm-9">
             <select multiple name="category[]" required id="" class="form-control multi"  <?php //if(@$editcat[0]->category!="") echo 'disabled'; ?>  >
              <option value="0" selected="selected">Choose Category</option>
              <?php 
              if ($master_category) {
               foreach ($master_category as $key => $value) {
                ?>
                <!-- ##########  level 1-->
                <option <?php if( strpos(@$editcat[0]->category, $value->category_id) !== false) echo 'selected'; ?> value="<?php echo $value->category_id; ?>"> <?php echo $value->category_name; ?></option>
                <!-- ##########  level 2-->
                <?php 
                $pid=$value->category_id;
                $sql="select * from master_category where  status='Active' and parent_id='$pid' ";
                $master_category2=$userModel->customQuery($sql);
                if ($master_category2) {
                 foreach ($master_category2 as $key2 => $value2) {
                  ?>
                  <option  <?php if( strpos(@$editcat[0]->category, $value2->category_id) !== false) echo 'selected'; ?> value="<?php echo $value2->category_id; ?>">&nbsp&nbsp&nbsp&nbsp<?php echo $value2->category_name; ?></option> 
                  <?php 
                  $pid2=$value2->category_id;
                  $sql="select * from master_category where  status='Active' and parent_id='$pid2' ";
                  $master_category3=$userModel->customQuery($sql);
                  if ($master_category3) {
                   foreach ($master_category3 as $key3 => $value3) {
                    ?>
                    <option  <?php if( strpos(@$editcat[0]->category, $value3->category_id) !== false) echo 'selected'; ?> value="<?php echo $value3->category_id; ?>">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value3->category_name; ?></option> 
                    <?php 
                    $pid3=$value3->category_id;
                    $sql="select * from master_category where  status='Active' and parent_id='$pid3' ";
                    $master_category4=$userModel->customQuery($sql);
                    if ($master_category4) {
                     foreach ($master_category4 as $key4 => $value4) {
                      ?>
                      <option  <?php if( strpos(@$editcat[0]->category, $value4->category_id) !== false) echo 'selected'; ?> value="<?php echo $value4->category_id; ?>">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value4->category_name; ?></option> 
                    <?php }
                  } ?>
                <?php }} ?>
                <?php 
              }
            }
          ?>  <!-- ##########  leve 2 END-->
          <?php }} ?> <!-- ##########  leve 1 END-->
        </select>
      </div>
    </div>
    <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Product Name*</label>
      <div class="col-sm-9">
       <input type="text" class="form-control"  name="name" required="" value="<?php echo @$editcat[0]->name ?>">
     </div>
   </div>
   
   
    <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Product brand*</label>
      <div class="col-sm-9">
           <select required class="form-control"  name="brand" required="" >
                        <option value="">Select brand</option>
          <?php
          
          if($brand){
              foreach($brand as $k=>$v){
                  ?>
                    <option <?php if($v->id== @$editcat[0]->brand) echo 'selected';?> value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                       
                  <?php
              }
          }
          ?>
           </select>
     
     </div>
   </div>
       <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Product Type*</label>
      <div class="col-sm-9">
    
       <select  class="type form-control" multiple="true"      name="type[]"   >
                       
          <?php
          
         
          
          
          if($type){
              foreach($type as $k=>$v){  
                  
                  
                  ?>
                    <option  <?php if(in_array($v->type_id,explode(",",@$editcat[0]->type))) echo 'selected'; ?> value="<?php echo $v->type_id;?>"><?php echo $v->title;?></option>
                       
                  <?php
              }
          }
          ?>
           </select>
    
    
     </div>
   </div>
   
   
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Suitable for*</label>
      <div class="col-sm-9">
    
       <select  class="suitable_for form-control" multiple="true"      name="suitable_for[]"   >
                        
          <?php
          
          if($suitable_for){
              foreach($suitable_for as $k=>$v){
                  
                 
                  ?>
                    <option  <?php if(in_array($v->id,explode(",",@$editcat[0]->suitable_for))) echo 'selected'; ?>  value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                       
                  <?php
              }
          }
          ?>
           </select>
    
    
     </div>
   </div>
   
   
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Age*</label>
      <div class="col-sm-9">
  <select class="age form-control" multiple="true"      name="age[]"   >
                        
          <?php
          
          if($age){
              foreach($age as $k=>$v){ 
                 
                  
                  
                  ?>
                    <option  <?php if(in_array($v->id,explode(",",@$editcat[0]->age))) echo 'selected'; ?>  value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                       
                  <?php
              }
          }
          ?>
           </select>
     </div>
   </div>
   
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Genre*</label>
      <div class="col-sm-9">
   
    <select class="color form-control" multiple="true"    name="color[]"   >
                        
          <?php
         
          if($color){
              foreach($color as $k=>$v){  
                  
                  
                  ?>
                    <option  <?php if(in_array($v->id,explode(",",@$editcat[0]->color))) echo 'selected'; ?>  value="<?php echo $v->id;?>"><?php echo $v->title;?></option>
                       
                  <?php
              }
          }
          ?>
           </select>
     </div>
   </div>
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Gift wrapping*</label>
      <div class="col-sm-9">
       <select class="form-control"  name="gift_wrapping" required=""  >
           <option value="">Select Gift wrapping</option>
            <option <?php if(@$editcat[0]) { if(@$editcat[0]->gift_wrapping=="No") echo 'selected';}else echo 'selected';?> value="No">No</option>
             <option <?php if(@$editcat[0]->gift_wrapping=="Yes") echo 'selected';?> value="Yes">Yes</option>
           </select>
     </div>
   </div>
   
   
   
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Pre-order enable*</label>
      <div class="col-sm-9">
       <select required class="form-control"  name="pre_order_enabled" required=""  onchange="showDiv('pre-order', this)">
           <option value="">Select Assemble Professionally</option>
            <option <?php if(@$editcat[0]) { if(@$editcat[0]->pre_order_enabled=="No") echo 'selected';}else echo 'selected';?> value="No">No</option>
             <option <?php if(@$editcat[0]->pre_order_enabled=="Yes") echo 'selected';?> value="Yes">Yes</option>
           </select>
     </div>
   </div>
   
   
     <div class="form-group row" id="pre-order" style="display:<?php if(@$editcat[0]->pre_order_enabled=='Yes') echo 'flex';else echo 'none';?>">
      <label for="input-1" class="col-sm-3 col-form-label">Pre order before payment percentage</label>
      <div class="col-sm-9">
       <input class="form-control" type="number" name="pre_order_before_payment_percentage" value="<?php if(@$editcat[0]->pre_order_before_payment_percentage) echo $editcat[0]->pre_order_before_payment_percentage;?>">
     </div>
   </div>
   
   
    <div class="form-group row" id="releaseDate" style="display:<?php if(@$editcat[0]->pre_order_enabled=='Yes') echo 'flex';else echo 'none';?>">
      <label for="input-1" class="col-sm-3 col-form-label">Release Date</label>
      <div class="col-sm-9">
       <input class="form-control" type="date" name="release_date" value="<?php if(@$editcat[0]->release_date) echo $editcat[0]->release_date;?>">
     </div>
   </div>
   
   
   
   
   
   <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Assemble Professionally</label>
      <div class="col-sm-9">
       <select class="form-control"  name="assemble_professionally" required=""  onchange="showDiv('aprof', this)">
           <option value="">Select Assemble Professionally</option>
            <option <?php if(@$editcat[0]) { if(@$editcat[0]->assemble_professionally=="No") echo 'selected';}else echo 'selected';?> value="No">No</option>
             <option <?php if(@$editcat[0]->assemble_professionally=="Yes") echo 'selected';?> value="Yes">Yes</option>
           </select>
     </div>
   </div>
   
   
   
   
   
   
   
   
   
   
   
   <div class="form-group row" id="aprof" style="display:<?php if(@$editcat[0]->assemble_professionally=='Yes') echo 'flex';else echo 'none';?>">
      <label for="input-1" class="col-sm-3 col-form-label">Assemble Professionally Price</label>
      <div class="col-sm-9">
       <input class="form-control" type="number" name="assemble_professionally_price" value="<?php if(@$editcat[0]->assemble_professionally_price) echo $editcat[0]->assemble_professionally_price;?>">
     </div>
   </div>
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Price*</label>
      <div class="col-sm-9">
       <input type="number" class="form-control"  name="price" required="" value="<?php echo @$editcat[0]->price ?>">
     </div>
   </div>
   
   
   
     <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Discount Percentage</label>
      <div class="col-sm-9">
       <input type="integer" class="form-control" name="discount_percentage"   value="<?php echo @$editcat[0]->discount_percentage ?>">
     </div>
   </div>
   
    <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Available Stock*</label>
      <div class="col-sm-9">
       <input type="number" required class="form-control"  name="available_stock"   value="<?php echo @$editcat[0]->available_stock ?>">
     </div>
   </div>
   
   
   
      <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Stock Keeping Unit (SKU)*</label>
      <div class="col-sm-9">
       <input   class="form-control"  name="sku" required="" value="<?php echo @$editcat[0]->sku ?>">
     </div>
   </div>
   
   
   <div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Product Description</label>
    <div class="col-sm-9"> 
    <!--<div id="toolbar-container"></div>-->

    <!-- This container will become the editable. -->
    <!--<div id="editor">-->
     <textarea name="description" id="editor" class="form-control  "><?php echo @$editcat[0]->description ?></textarea>
       <!--</div>-->
   </div>
 </div>
 
 
  <div class="form-group row">
    <label for="input-2" class="col-sm-3 col-form-label">Product Features</label>
    <div class="col-sm-9">
     <textarea name="features" class="form-control "><?php echo @$editcat[0]->features ?></textarea>
   </div>
 </div>
 
 
 
 
 
 
    <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Related Products*</label>
      <div class="col-sm-9">
    
       <select   class="suitable_for form-control" multiple="true"      name="related_products[]"   >
                        
          <?php
          
        if($rel){
       
         $sql="select * from related_products where     product_id='$product_id' "; 
@$savedRealted=$userModel->customQuery($sql);
       
   foreach($rel as $k=>$v){
       
                  
                 
                  ?>
                    <option <?php if($savedRealted) { if(array_search($v->product_id, array_column($savedRealted, 'related_product'))){echo 'selected';    } }?> value="<?php echo $v->product_id;?>"><?php echo $v->name;?></option>
   <?php
   }
   }
   
   ?>
           </select>
    
    
     </div>
   </div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
  
  
  
  
  
  
  
  
  
 
 
 
 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Show This product in Home Page</label>
  <div class="col-sm-9">
   <select name="show_this_product_in_home_page" required="" class="form-control">
    <option value="">Select status</option>
    <option <?php if(@$editcat[0]->status=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
    <option <?php if(@$editcat[0]->status=="No") echo 'selected'; ?> value="No">No</option>
  </select>
</div>
</div>



 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label"> Freebie </label>
  <div class="col-sm-9">
   <select name="freebie" required="" class="form-control">
    <option value="">Select freebie</option>
    <option <?php if(@$editcat[0]->freebie=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
    <option <?php if(@$editcat[0]->freebie=="No") echo 'selected'; ?> value="No">No</option>
  </select>
</div>
</div>


 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Evergreen </label>
  <div class="col-sm-9">
   <select name="evergreen" required="" class="form-control">
    <option value="">Select evergreen</option>
    <option <?php if(@$editcat[0]->evergreen=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
    <option <?php if(@$editcat[0]->evergreen=="No") echo 'selected'; ?> value="No">No</option>
  </select>
</div>
</div>


 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Exclusive </label>
  <div class="col-sm-9">
   <select name="exclusive" required="" class="form-control">
    <option value="">Select exclusive</option>
    <option <?php if(@$editcat[0]->exclusive=="Yes") echo 'selected'; ?>  selected="" value="Yes">Yes</option>
    <option <?php if(@$editcat[0]->exclusive=="No") echo 'selected'; ?> value="No">No</option>
  </select>
</div>
</div>
 
 
  <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Precedence</label>
  <div class="col-sm-9">
   <input type="number" name="precedence"  value="<?php echo(@$editcat[0]->precedence)?>" class="form-control"> 
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
  <label for="input-1" class="col-sm-3 col-form-label">Product Name Arabic </label>
  <div class="col-sm-9">
   <input type="text" class="form-control"  name="arabic_name"  value="<?php echo @$editcat[0]->arabic_name ?>">
 </div>
</div>
<div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Description Arabic </label>
  <div class="col-sm-9">
   <textarea name="arabic_description" class="form-control "><?php echo @$editcat[0]->arabic_description ?></textarea>
 </div>
</div>
</div>
<div class="tab-pane  <?php      if(count(@$uri->getSegments())>4){   echo 'active';   } ?>" id="Images" role="tabpanel" aria-labelledby="Images-tab" aria-expanded="false">
 
 
 
   <div class="form-group row">
      <label for="input-1" class="col-sm-3 col-form-label">Youtube Link</label>
      <div class="col-sm-7">
       <input type="text" class="form-control" placeholder="Youtube Link"  name="youtube_link"  value="<?php echo @$editcat[0]->youtube_link ?>">
     </div>
   </div>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Product image </label>
  <div class="col-sm-10 ">
   <input  id="files" type="file" multiple name="file[]" class="form-control"    >
   <?php 
   if($cat_image){
       foreach($cat_image as $k=>$v){
           
           $file_name = $v->image;
$extension = pathinfo($file_name, PATHINFO_EXTENSION);
 if(  $extension=="mp4"){
     ?>
      
     
     
     <span class="pip">
       <video width="150" height="150" controls>
  <source src="<?php echo base_url(); ?>/assets/uploads/<?php if($v->image) echo $v->image; ?>" type="video/mp4"> 
</video>
     <br><a href="<?php echo base_url();?>/supercontrol/Products/deleteImage/<?php echo $v->id;?>/<?php echo $product_id;?>" class="remove">Remove image</a>
     </span>
   
     
     
     
     
     
     
     
     <?php
 }else{
           
   ?>
   <span class="pip"><img class="imageThumb" src="<?php echo base_url(); ?>/assets/uploads/<?php if($v->image) echo $v->image; ?>" title="undefined"><br><a href="<?php echo base_url();?>/supercontrol/Products/deleteImage/<?php echo $v->id;?>/<?php echo $product_id;?>" class="remove">Remove image</a></span>
    
  
     <?php
 }
   }
   }
   ?>
   
 </div>
  </div> 
  
  
  
  
  
  
  
 
  <div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Screenshot image </label>
  <div class="col-sm-10 ">
   <input    type="file" multiple name="file2[]" class="form-control"    >
   <?php 
   if($product_screenshot){
       foreach($product_screenshot as $k3=>$v3){
           
 
           
   ?>
   <span class="pip"><img class="imageThumb" src="<?php echo base_url(); ?>/assets/uploads/<?php if($v3->image) echo $v3->image; ?>" title="undefined"><br><a href="<?php echo base_url();?>/supercontrol/Products/deleteScreenImage/<?php echo $v3->id;?>/<?php echo $product_id;?>" class="remove">Remove image</a></span>
    
  
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
   
    <textarea name="page_description" class="form-control "><?php echo @$editcat[0]->page_description ?></textarea>
 </div>
</div>
<div class="form-group row">
  <label for="input-2" class="col-sm-3 col-form-label">Other Meta tag </label>
  <div class="col-sm-9">
   <textarea name="other_meta_tag" class="form-control "><?php echo @$editcat[0]->other_meta_tag ?></textarea>
 </div>
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

<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 'Yes' ? 'flex' : 'none';
      document.getElementById("releaseDate").style.display = element.value == 'Yes' ? 'flex' : 'none';
}
</script>






<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
 
  <script>
CKEDITOR.replace('editor', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'links', items: [ 'Link', 'Unlink' ] },
             { name: 'insert', items: [ 'Image'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});

  </script>
 
    
     
 

 