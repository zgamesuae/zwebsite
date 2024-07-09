<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
  
  
   $sql="select * from wallet where user_id='$user_id' and status!='Inactive' order by created_at desc";
$wallet=$userModel->customQuery($sql);


//  $sql="select sum(available_balance)  as total from wallet where user_id='$user_id'  and status!='Inactive'  order by created_at desc";
$sql="select sum(available_balance)  as total from wallet where user_id='$user_id'  and type='credit_used_for_order'  order by created_at desc";

$total=$userModel->customQuery($sql);

//  $sql="select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used') order by created_at desc";
$sql="select sum(available_balance)  as total from wallet where user_id='$user_id' order by created_at desc";

$cbal=$userModel->customQuery($sql);


 $sql="select ABS(sum(available_balance)) as total from wallet where user_id='$user_id'  And type='credit_used_for_order' order by created_at desc";
$usedbal=$userModel->customQuery($sql);

 $sql="select sum(available_balance) as total from wallet where user_id='$user_id'  And status='Refunded' order by created_at desc";
$refundbal=$userModel->customQuery($sql);
}


 
?>
<style>
  /*wallet */
  .cust-btn {
      padding: 5px 8px !important;
      font-size: 12px !important;
  } 

  .disable {
      background: #c1c1c18c !important;
  } 

  .pull-up {
      transition: all .25s ease;
  } 

  .card {
      margin-bottom: 1.875rem;
      border: none;
      box-shadow: 0 2px 18px 1px rgb(49 53 72 / 10%);
      border-radius: .45rem;
  } 

  .card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-clip: border-box;
      border: 1px solid rgba(0, 0, 0, .06);
      border-radius: .35rem;
  } 

  .card-body {
      box-shadow: 0 6px 20px 0 rgb(97 50 35 / 50%) !important;
  } 

  .card-body {
      flex: 1 1 auto;
      padding: 1.5rem;
  } 

  .progress.progress-sm {
      height: .5rem !important;
  } 

  .bg-gradient-x-info {
      background-image: linear-gradient(to right, #0c84d1 0, #4eb4f5 100%);
      background-repeat: repeat-x;
  } 

  .bg-gradient-x-info {
      background-image: linear-gradient(to right, #0c84d1 0, #4eb4f5 100%);
      background-repeat: repeat-x;
  } 

  .progress-bar {
      display: flex;
      flex-direction: column;
      justify-content: center;
      color: #fff;
      text-align: center;
      background-color: #666ee8;
      transition: width .6s ease;
  } 

  /*END wallet*/
  .bg-light {
      background-color: #eeeeee !important;
  } 

  text-muted {
      color: #6c757d !important;
  } 

  img.products_cart_image {
      width: 133px;
      max-height: 130px;
      object-fit: contain;
      margin-right: 26px;
      border: 1px solid #e8e8e8;
  } 

  .quanitity_div_parent {
      height: fit-content;
  } 

  .add_to_card_wishlist_button {
      white-space: pre;
  } 

  .pull-up:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 14px 24px rgb(62 57 107 / 20%);
      z-index: 30;
  } 

  .pull-up {
      transition: all .25s ease;
  }
</style>

<div class="container-fluid p-0 bg-light pb-5">
    <?php include 'Common/Breadcrumb.php';?>
    <div class="container pb-5 mb-2 mb-md-4  pt-5">
        <div class="row">
            <div class="col-lg-4">
                <?php include 'Common/UserMenu.php';?>
            </div>
            <section class="col-lg-8 bg-white">
                <div class="d-flex justify-content-between align-items-center pt-3 pb-4 pb-sm-5 mt-1">
                    <h1 class="h3 mb-0">My Wallet </h1><a class="btn btn-primary text-white ps-2" data-toggle="modal"
                        data-target="#addmoney" href="javascript:void(0);"><i class="ci-arrow-left me-2"></i>Add
                        Money</a>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h4 class="info">AED
                                                <?php if($cbal[0]->total) echo    bcdiv($cbal[0]->total , 1, 2);else echo 0;?>
                                            </h4>
                                            <h6>Current Balance </h6>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-3.5-8v2H11v2h2v-2h1a2.5 2.5 0 1 0 0-5h-4a.5.5 0 1 1 0-1h5.5V8H13V6h-2v2h-1a2.5 2.5 0 0 0 0 5h4a.5.5 0 1 1 0 1H8.5z"
                                                    fill="rgba(0,135,242,1)" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar"
                                            style="width: <?php if($total[0]->total) echo ($cbal[0]->total*100)/($total[0]->total);?>%"
                                            aria-valuenow="<?php if($total[0]->total) echo ($cbal[0]->total*100)/($total[0]->total);?>"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h4 class="info">AED
                                                <?php if ($usedbal[0]->total) echo bcdiv($usedbal[0]->total , 1, 2); else echo 0;?>
                                            </h4>
                                            <h6>Total Used </h6>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path
                                                    d="M11.602 13.76l1.412 1.412 8.466-8.466 1.414 1.414-9.88 9.88-6.364-6.364 1.414-1.414 2.125 2.125 1.413 1.412zm.002-2.828l4.952-4.953 1.41 1.41-4.952 4.953-1.41-1.41zm-2.827 5.655L7.364 18 1 11.636l1.414-1.414 1.413 1.413-.001.001 4.951 4.951z"
                                                    fill="rgba(0,135,242,1)"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar"
                                            style="width: <?php if($total[0]->total)  echo ($usedbal[0]->total*100)/($total[0]->total);?>%"
                                            aria-valuenow="<?php if($total[0]->total)  echo ($usedbal[0]->total*100)/($total[0]->total);?>"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h4 class="info">AED
                                                <?php if($refundbal[0]->total) echo    bcdiv($refundbal[0]->total , 1, 2);  else echo 0;?>
                                            </h4>
                                            <h6>Refuned to card</h6>
                                        </div>
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z" />
                                                <path
                                                    d="M5.671 4.257c3.928-3.219 9.733-2.995 13.4.672 3.905 3.905 3.905 10.237 0 14.142-3.905 3.905-10.237 3.905-14.142 0A9.993 9.993 0 0 1 2.25 9.767l.077-.313 1.934.51a8 8 0 1 0 3.053-4.45l-.221.166 1.017 1.017-4.596 1.06 1.06-4.596 1.096 1.096zM13 6v2h2.5v2H10a.5.5 0 0 0-.09.992L10 11h4a2.5 2.5 0 1 1 0 5h-1v2h-2v-2H8.5v-2H14a.5.5 0 0 0 .09-.992L14 13h-4a2.5 2.5 0 1 1 0-5h1V6h2z"
                                                    fill="rgba(0,135,242,1)" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar"
                                            style="width: <?php if($total[0]->total)  echo ($refundbal[0]->total*100)/($total[0]->total);?>%"
                                            aria-valuenow="<?php if($total[0]->total)  echo ($refundbal[0]->total*100)/($total[0]->total);?>"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 bg-white rounded shadow-sm">
                        <div class="table-responsive fs-md">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Order Date</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Available Bal</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($wallet){
                   foreach($wallet as $k=>$v){
                   ?>
                                    <tr>
                                        <td class="py-3"><a class="nav-link-style fw-medium fs-sm" href="#order-details"
                                                data-bs-toggle="modal"><?php echo $v->order_id?></a></td>
                                        <td class="py-3"><?php echo date("M d ,y", strtotime($v->created_at));?>
                                        </td>

                                        <td class="py-3">
                                            <?php
                      if($v->type=="credited_from_card"){
                      ?>

                                            <span class="text-white badge bg-danger m-0">card</span>
                                            <?php
                     
                        }else  if($v->type=="credited_from_order_cancel"){?>

                                            <span class="text-white badge bg-success m-0">order cancel</span>
                                            <?php
                        } 
                            
                        
                      ?>

                                        </td>

                                        <td class="py-3">
                                            <?php
                      if($v->status=="Used"){
                      ?>
                                            <span
                                                class="text-white badge bg-warning m-0"><?php echo $v->status;?></span>
                                            <?php
                        }else  if($v->status=="Active"){?>

                                            <span class="text-white badge bg-info m-0"><?php echo $v->status;?></span>
                                            <?php
                        }else  if($v->status=="Inactive"){?>

                                            <span
                                                class="text-white badge bg-success m-0"><?php echo $v->status;?></span>
                                            <?php
                        }else  if($v->status=="Refunded"){?>

                                            <span class="text-white badge bg-secondary  m-0">Refunded</span>
                                            <?php
                            
                        }
                      ?>

                                        </td>

                                        <td class="py-3">AED <?php echo ($v->total);?></td>
                                        <td class="py-3">AED <?php echo ($v->available_balance);?></td>

                                        <?php 
                   
                   $date1 = date("Y-m-d H:m:i");
$date2 =$v->created_at;
$timestamp1 = strtotime($date1);
$timestamp2 = strtotime($date2);
   $diff =round( abs($timestamp2 - $timestamp1)/(60*60) );
 
                   
                  
                   
                   if($v->status=="Active" && $v->type=="credited_from_order_cancel" && $diff <= 24){
                       ?>
                                        <td class="py-3"><a class="btn btn-primary cust-btn"
                                                href="<?php echo base_url();?>/profile/refundWallet/<?php echo $v->order_id;?>">Refund
                                        </td>
                                    </tr>
                                    <?php
                   }else{?>
                                    <td class="py-3"><a class="btn btn-secondary disable cust-btn" disabled>Refund</td>
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
        </div>
    </div>
</div>

<div class="modal fade " id="addmoney" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">
            <div class="model_eader " style="    z-index: 1;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="  bg-white">
                    <div class="tab-content p-4">
                        <div class="mt-3 headding text-center text-capitalize">
                            <h6 class="font-weight-bold">-- Add money to wallet --</h6>
                        </div>
                        <form method="post" action="<?php echo base_url();?>/profile/AddMoney">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="checkout-fn">Enter Amount</label>
                                        <input class="form-control" name="amount" required="" type="number"
                                            placeholder="Enter amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <button type="submit" class="w-100 btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>