<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$orderModel = model('App\Models\OrderModel', false);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 

if(@$user_id){
    $codes = $orderModel->user_digital_codes($user_id);
    // var_dump($codes);die();
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
        <?php 
            include 'Common/UserMenu.php';
        ?>
        </div>


        <section class="col-lg-8">
          <div class="row mt-3 mt-md-0">
            <div class="col-sm-12 bg-white rounded shadow-sm">
              <div class="table-responsive fs-md">
                <table class="table table-hover mb-0 w-auto">

                  <thead>
                    <tr>
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_244") ?>#</th> <!-- Order number -->
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_352") ?></th> <!-- Product title -->
                      <th></th> <!-- Product title -->
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_235") ?></th> <!-- Status -->
                      
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_279") ?></th> <!-- Quantity -->
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_351") ?></th> <!-- Code details -->
                      <!-- <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_198") ?></th> total -->
                      <th class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_245") ?></th> <!-- Date -->
                     
                    </tr>
                  </thead>

                  <tbody>
                   
                    <?php
                    if($codes){
                        foreach($codes as $code){
                    ?>

                        <tr>
                            <td rowspan="<?php echo (sizeof($codes)-1) ?>" style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>"><?php echo $code->order_id ?></td>
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>"><?php echo $code->name ?></td> 
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto"><img src="<?php echo base_url()."/assets/uploads/".$code->image ?>" alt="" width="80px"></td>
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>"><?php echo $code->status_text ?></td>
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>"><?php echo $code->quantity ?></td>
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>">
                                <?php if($code->status_text == "accept"): ?>
                                <div class="py-1 px-2 btn" style="background-color: #22398d">
                                    <a style="color: white; font-weight: 400; font-size: 12px" target="blank" href="<?php  echo $code->share_link ?>"><?php echo lg_get_text("lg_56") ?></a>
                                </div>
                                <?php endif; ?>

                            </td>
                            <td style="vertical-align:middle; min-width: 150px;" class="py-3 w-auto <?php text_from_right() ?>"><?php echo date("M d ,y h:i:s", strtotime($code->created_at));?></td>
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

      </div>
     
    </div>
</div>



