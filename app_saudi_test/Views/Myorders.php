<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id){
      $sql="select * from orders where user_id='$user_id' order by created_at desc";
$orders=$userModel->customQuery($sql);
 
}
?>
<style>
.cust-btn{
    padding: 5px 8px!important;
    font-size: 12px!important;
}

.disablebtn{
    background: #2424241a !important;
}
</style>


<div class="container-fluid p-0 bg-light pb-5" <?php content_from_right() ?>>
<?php include 'Common/Breadcrumb.php';?>
  <div class="container pb-5 mb-2 mb-md-4  pt-5">
      <div class="row">
   <!--     <div class="col-12 mb-2">
          <div class="heading text-capitalize " >
            <h4 class="font-weight-bold">Profile</h4>
          </div>
        </div>-->
        
        
        <!-- Display errors -->
        <?php if(isset($errors) && sizeof($errors) > 0): ?>
          <div class="col-lg-12 p-0">
            <div class="m-0" data-class="btn-close">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo lg_get_text("lg_206") ?></strong> <br> 
                    <?php 
                        foreach ($errors as $key => $value) {
                            # code...
                            if(trim($value) !== ""){
                                echo $value;
                            }
                        }
                    ?>
                </div>
            </div>
          </div>
        <?php endif; ?>


        <div class="col-lg-4">
        <?php include 'Common/UserMenu.php';?>
        </div>
        <section class="col-lg-8">
          <div class="row mt-3 mt-md-0">
            <div class="col-sm-12 bg-white rounded shadow-sm">
              <div class="table-responsive fs-md">
                <table class="table table-hover mb-0" style="min-width: 800px">

                  <thead>
                    <tr>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_244") ?>#</th>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_245") ?></th>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_246") ?></th>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_235") ?></th>
  
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_198") ?></th> 
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_247") ?></th>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_248") ?></th>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_249") ?></th>
                    </tr>
                  </thead>

                  <tbody>
                   
                    <?php 
                    if($orders)
                    {
                      foreach($orders as $k=>$v)
                      {
                    ?>

                    <tr>
                      <td class="py-3 <?php text_from_right() ?>"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal"><?php echo $v->order_id?></a></td>
                      <td class="py-3 <?php text_from_right() ?>"><?php echo date("M d ,y", strtotime($v->created_at));?></td>
                      <td class="py-3 <?php text_from_right() ?>">
                        <?php
                        if($v->payment_status=="Not Paid")
                        {
                        ?>

                        <span class="text-white badge bg-danger m-0"><?php echo $v->payment_status;?></span>
                        <?php

                        }
                        else  if($v->payment_status=="Paid")
                        {
                        ?>

                        <span class="text-white badge bg-success m-0"><?php echo $v->payment_status;?></span>
                        <?php
                        }
                        else  if($v->payment_status=="Refunded")
                        {
                        ?>

                        <span class="text-white badge bg-secondary  m-0"><?php echo $v->payment_status;?></span>
                        <?php
                        }
                        ?>
                      
                      </td> 
                      <td class="py-3 <?php text_from_right() ?>">
                        <?php
                        if($v->order_status=="Submited"){
                        ?>

                        <span class="text-white badge bg-danger m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }else  if($v->order_status=="Confirmed"){
                        ?>
                        <span class="text-white badge bg-warning m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }
                        else  if($v->order_status=="Out for delivery")
                        {
                        ?>

                        <span class="text-white badge bg-info m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }
                        else  if($v->order_status=="Delivered")
                        {
                        ?>

                        <span class="text-white badge bg-success m-0"><?php echo $v->order_status;?></span>

                        <?php
                        }
                        else  if($v->order_status=="Canceled")
                        {
                        ?>

                        <span class="text-white badge bg-secondary  m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }
                        ?>
                      
                      </td>
                      <td class="py-3 <?php text_from_right() ?>"><?php echo lg_get_text("lg_102") ?> <?php echo bcdiv($v->total, 1, 2);?></td>
                      <td class="py-3 <?php text_from_right() ?>">
                        <?php 
                        if($v->tracking)
                        {
                        ?>

                        <a target="_blank" href="<?php echo $v->tracking;?>" class="btn btn-primary cust-btn" ><?php echo lg_get_text("lg_247") ?></a>

                        <?php 
                        } 
                        else
                        {
                        ?>

                        <a  class="btn btn-secondary cust-btn disablebtn" disabled ><?php echo lg_get_text("lg_247") ?></a>
                        
                        <?php
                        }
                        ?>
                      </td>
                      <td class="py-3 <?php text_from_right() ?>"><a  class="btn btn-primary cust-btn" target="_blank" href="<?php echo base_url();?>/invoice/<?php echo $v->order_id;?>"><?php echo lg_get_text("lg_248") ?></a></td>
                      <?php   
                   
                      $date1 = date("Y-m-d H:m:i");
                      $date2 =$v->created_at;
                      $timestamp1 = strtotime($date1);
                      $timestamp2 = strtotime($date2);
                      $diff =round( abs($timestamp2 - $timestamp1)/(60*60) );
   
   
                      if($v->order_status=="Submited" && $diff <= 24)
                      {
                      ?>
                      <td class="py-3 <?php text_from_right() ?>"><a  class="btn btn-primary cust-btn" href="<?php echo base_url();?>/profile/cancelOrder/<?php echo $v->order_id;?>"><?php echo lg_get_text("lg_250") ?></a></td>
                          <!-- </tr> -->

                      <?php
                      }
                      else
                      {
                      ?>
                      <td class="py-3 <?php text_from_right() ?>"></td>
                      <?php } ?>
                    </tr>

                    
                       
                       
                    
                    <?php
                    }
                    }
                    ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </section>
        <!-- Sidebar-->
       
      </div>
     
    </div>
</div>



