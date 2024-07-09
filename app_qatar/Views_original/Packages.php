<?php include 'Common/Breadcrumb.php'; 
$userModel = model('App\Models\UserModel', false);
$session = session();
@$user_id=$session->get('userLoggedin'); 
$cdate=date("Y-m-d");
$sql="select * from package where          '$cdate' between package.start_date  AND package.end_date  AND package.status='Active' ";
$pack=$userModel->customQuery($sql);
if($pack){
 foreach($pack as $kk=>$vv){
     $opric=0;
     $dis=0;
     $total=0;
    ?>
    <div class="container packages_box_parent package_items_design_products mb-3">
        <div class="row">
            <div class="col-md-12">
              <h4 class="text-capitalize"><strong><?php echo  $vv->title;?></strong></h4>
          </div>
          <div class="col-md-8">
              <div class="owl-carousel products_list">
               <?php
               $pid=$vv->package_id;
               $sql="select *, package_products.discount_percentage as dp from package_products 
               inner join products on products.product_id=package_products.product  where  package_products.package='$pid'     ";
               $products=$userModel->customQuery($sql);  
               if($products){
                foreach ($products as $k => $v) {
                  $pid=$v->product_id;
                  $sql="select * from product_image where     product='$pid' and status='Active' ";
                  $product_image=$userModel->customQuery($sql);  
                  
                  
                  $opric=$opric+$v->price;
                  
             $dis=    $dis+  ($v->dp*$v->price)/100;
             $total=$total+($v->price-($v->dp*$v->price)/100);
                  
                  ?> 
                  <div class="item">
                   <div class="product_box shadow-none bg-white rounded overflow-hidden">
                      <a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">
                        <div class="product_box_image">
                           <?php 
                           if($v->dp > 0 && $v->dp < 100){
                               ?>
                               <div class="product_label_offer"><?php echo $v->dp; ?>% off</div>
                           <?php }  else if($v->dp == 100 ){
                            ?>
                            <div class="product_label_offer">Free</div>
                            <?php
                        }?>
                        <?php 
                        $file_name = $product_image[0]->image;
                        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                        if($extension=="mp4"){
                            ?>
                            <video   controls>
                              <source src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" type="video/mp4"> 
                              </video>         
                              <?php 
                          }else{
                            ?>
                            <img src="<?php echo base_url();?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png';?>" class="border-0"  >
                            <?php 
                        }
                        ?>
                    </div>
                </a>
                <div class="product_box_content">
                    <h5 ><strong><a href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>"><?php echo substr($v->name,0,40);?></a></strong></h5>
                    <div class="pricing-card">
                       <?php 
                       
                       
                       
                       if($v->dp > 0 ){
                           ?>
                           <div class="card-subtitle">
                              <span><?php echo number_format($v->price) ;?>AED</span>
                          </div>
                          <p class="offer-price card-text"><?php echo number_format($v->price - ($v->dp*$v->price)/100);?><span>AED</span></p>
                      <?php } else {
                      ?> <div class="card-subtitle">
                      </div>
                      <p class="offer-price card-text"><?php echo number_format($v->price);?><span>AED</span></p>
                      <?php
                  }?>
              </div>
              <div class="d-none products_price text-small text-primary font-weight-bold">
               <?php 
               if($v->dp > 0 ){
                   ?>
                   <?php echo number_format($v->price - ($v->dp*$v->price)/100);?>
                   <span class="curreny">AED</span>
                   <del class="text-gray"><?php echo number_format($v->price);?> AED</del>
               <?php } else {
                  ?>
                  <?php echo number_format($v->price) ;?>
                  <span class="curreny">AED</span>
                  <?php
              }?>
          </div>
          <form class="packageForm<?php echo $vv->package_id;?> products_add_to_cart each_products_add_card_list buy-now-form" method="post" action="<?php echo base_url();?>/page/buyNowSubmitForm">
            <input name="product_name" type="hidden" value="<?php echo $v->name;?>" required  >
            <input name="product_image" type="hidden" value="<?php if($product_image[0]->image) echo $product_image[0]->image; ?>" required  >
            <input name="product_id" type="hidden" value="<?php echo $v->product_id;?>" required  >
            <div class="product_qty">
                <input name="quantity" type="hidden" value="1" required min="1" >
                <input name="discount_percentage" type="hidden" value="<?php echo $v->dp;?>" required  >
                <input name="package" type="hidden" value="<?php echo $vv->package_id;?>" required  >
            </div>
        </form>
    </div>
</div>
</div>

<?php } }else echo "<p>Products not available for this package!</p>"; ?>
</div>
</div>


 

<div class="col-md-4">
    <div class="bg-white shadow-sm products_package_left_s">
        <h4 class="text-capitalize"><strong><?php echo  $vv->title;?></strong></h4>
        <ul>
            <li>Original Price <span> <?php echo $opric;?> AED</span></li>
            <li>Discount <span>- <?php echo $dis;?> AED</span></li>
            <li>Total <span> <?php echo $total;?> AED</span></li>
        </ul>
        <h2>Total : AED <?php echo $total;?> </h2>
        <form class="d-flex mt-3">
           <!-- <div class="quanitity_div_parent mr-2">
                <div class="quantitynumber">
                    <span class="minus">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                    </span><input class="form-control" type="number" name="qty" value="1">
                    <span class="plus">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                    </span>
                </div>          
            </div>-->
            <?php
                    if($user_id){
                        ?>
            <a href="javascript:void(0);"    class="btn btn-primary w-100 " onclick="submitPackageForm('<?php echo $vv->package_id;?>');">Add To Cart</a>
              <?php
                    }else{
                        ?>
                           <a class="btn btn-primary w-100 "   href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">Add To Cart</a>
                         <?php
                    }
                ?>      
        </form>
                <!--<?php
                    if($user_id){
                        ?>
                        <a  class="btn btn-black text-small"  style="margin:0 auto" href="javascript:void(0);"  onclick="submitPackageForm('<?php echo $vv->package_id;?>');" >
                            Add to cart all products
                            </a>
                        <?php
                    }else{
                        ?>
                        <a  class="btn btn-black text-small" style="margin:0 auto"  href="javascript:void(0);"   data-toggle="modal" data-target="#jagat-login-modal">
                             Add to cart all products</a>
                        <?php
                    }
                ?>        --> 
            </div>
        </div>
    </div>
</div>
<?php } } ?>