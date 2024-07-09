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
              <div class="table-responsive fs-md">
                <table class="table table-hover mb-0">
                  <thead>
                    <tr>
                      <th>Order #</th>
                      <th> Date</th>
                    <th>Payment</th>
                       <th>Status</th>
  
                      <th>Total</th> 
                      <th>Track</th>
                       <th>Invoice</th>
                          <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                   <?php if($orders){
                   foreach($orders as $k=>$v){
                   ?>
                    <tr>
                      <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details" data-bs-toggle="modal"><?php echo $v->order_id?></a></td>
                      <td class="py-3"><?php echo date("M d ,y", strtotime($v->created_at));?>
</td>
        
                      <td class="py-3">
                      <?php
                      if($v->payment_status=="Not Paid"){
                      ?>
                      
                      <span class="text-white badge bg-danger m-0"><?php echo $v->payment_status;?></span>
                      <?php
                     
                        }else  if($v->payment_status=="Paid"){?>
                        
                        <span class="text-white badge bg-success m-0"><?php echo $v->payment_status;?></span>
                        <?php
                        }else  if($v->payment_status=="Refunded"){?>
                        
                        <span class="text-white badge bg-secondary  m-0"><?php echo $v->payment_status;?></span>
                        <?php
                            
                        }
                      ?>
                      
              </td> 
                      
                       <td class="py-3">
                      <?php
                      if($v->order_status=="Submited"){
                      ?>
                      
                      <span class="text-white badge bg-danger m-0"><?php echo $v->order_status;?></span>
                      <?php
                      }else  if($v->order_status=="Confirmed"){
                      ?>
                      <span class="text-white badge bg-warning m-0"><?php echo $v->order_status;?></span>
                      <?php
                        }else  if($v->order_status=="Out for delivery"){?>
                        
                         <span class="text-white badge bg-info m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }else  if($v->order_status=="Delivered"){?>
                        
                        <span class="text-white badge bg-success m-0"><?php echo $v->order_status;?></span>
                        <?php
                        }else  if($v->order_status=="Canceled"){?>
                        
                        <span class="text-white badge bg-secondary  m-0"><?php echo $v->order_status;?></span>
                        <?php
                            
                        }
                      ?>
                      
              </td>
                      
                      <td class="py-3">AED <?php echo bcdiv($v->total, 1, 2);?></td>
                       <td class="py-3">
                           <?php if($v->tracking){ ?>
                           
                           <a target="_blank" href="<?php echo $v->tracking;?>" class="btn btn-primary cust-btn" >Track</a>
                           
                           <?php } else{
                           ?>
                           <a  class="btn btn-secondary cust-btn disablebtn" disabled >Track</a>
                           
                           <?php
                           }?>
                           </td>
                       <td class="py-3"><a  class="btn btn-primary cust-btn" target="_blank" href="<?php echo base_url();?>/invoice/<?php echo $v->order_id;?>">Invoice</a></td>
                   <?php   
                   
                      $date1 = date("Y-m-d H:m:i");
$date2 =$v->created_at;
$timestamp1 = strtotime($date1);
$timestamp2 = strtotime($date2);
   $diff =round( abs($timestamp2 - $timestamp1)/(60*60) );
   
   
                   if($v->order_status=="Submited" && $diff <= 24){
                       ?>
                        <td class="py-3"><a  class="btn btn-primary cust-btn" href="<?php echo base_url();?>/profile/cancelOrder/<?php echo $v->order_id;?>">Cancel</a></td>
                    </tr>
                       <?php
                   }else{?>
                    <td class="py-3"><a  class="btn btn-secondary cust-btn disablebtn" disabled >Cancel</a></td>
                    </tr>
                   <?php
                   }?>
                       
                       
                    
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



