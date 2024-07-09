<?php
  $session = session();
  $uri = service('uri'); 
  if(count(@$uri->getSegments())>2){
      $uri1=@$uri->getSegment(3); 
  }

  $userModel = model('App\Models\UserModel', false);
  
  @$user_id=$session->get('userLoggedin'); 

  if(@$user_id !=="" && $uri1 !==""){
    $sql="select * from user_address where user_id='$user_id' AND address_id=$uri1";
    $user_address=$userModel->customQuery($sql);
  }

  $sql="select * from city where status='Active' AND city_id !='all'";
  $cities=$userModel->customQuery($sql);
?>

<div class="container-fluid p-0 bg-light pb-5" <?php content_from_right() ?>>
  <?php include 'Common/Breadcrumb.php';?>
  <div class="container pb-5 mb-2 mb-md-4  pt-5">
    <div class="row">

      <div class="col-lg-4">
        <?php include 'Common/UserMenu.php';?>
      </div>

      <section class="col-lg-8">
        <div class="row">
          <div class="col-sm-12 bg-white rounded shadow-sm">

            <div class="apply_procode border-weight-2 border-bottom font-weight-bold d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#promo_code">
              <h4>
                <strong>
                  <?php echo lg_get_text("lg_233") ?>
                </strong>
              </h4>
            </div>

            <section class="col-lg-12 pt-3">
              <form method="post">
                <input class="form-control" name="address_id" type="hidden" required placeholder="Street" value="<?php echo @$user_address[0]->address_id;?>">
                <div class="row">

                  <!-- Name -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn">
                        <?php echo lg_get_text("lg_148") ?> <?php if(isset($name)): echo "<span style='color:red; font-size:.8rem'> $name </span>"; endif; ?>
                      </label>
                      <input class="form-control" name="name" required type="text" placeholder="<?php echo lg_get_text(" lg_148") ?>" value="<?php echo @$user_address[0]->name;?>">
                    </div>
                  </div>
                  <!-- Name -->

                  <!-- Street -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn"> 
                        <?php echo lg_get_text("lg_221") ?> <?php if(isset($street)): echo "<span style='color:red; font-size:.8rem'> $street </span>"; endif; ?>
                      </label>
                      <input class="form-control" name="street" required type="text" placeholder="<?php echo lg_get_text(" lg_221") ?>" value="<?php echo @$user_address[0]->street;?>">
                    </div>
                  </div>
                  <!-- Street -->

                  <!-- Apartement House -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn">
                        <?php echo lg_get_text("lg_234") ?> <?php if(isset($apartment_house)): echo "<span style='color:red; font-size:.8rem'> $apartment_house </span>"; endif; ?>
                      </label>
                      <input class="form-control" name="apartment_house" required type="text" required placeholder="<?php echo lg_get_text(" lg_234") ?>" value="<?php echo @$user_address[0]->apartment_house;?>">
                    </div>
                  </div>
                  <!-- Apartement House -->


                  <!-- City -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn">
                        <?php echo lg_get_text("lg_222") ?> <?php if(isset($city)): echo "<span style='color:red; font-size:.8rem'> $city </span>"; endif; ?>
                      </label>

                      <select name="city" required class="form-control">
                        <option value=""><?php echo lg_get_text("lg_223") ?></option>
                        <?php 
                        if($cities){
                          foreach($cities as $k=>$v){
                        ?>
                        <option <?php if($user_address[0]->city==$v->city_id) echo 'selected';?> value="<?php echo $v->city_id;?>">
                          <?php echo $v->title;?>
                        </option>
                        <?php
                          }
                        }
                        ?>

                      </select>

                    </div>
                  </div>
                  <!-- City -->

                  <!-- address -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn">
                        <?php echo lg_get_text("lg_68") ?> <?php if(isset($address)): echo "<span style='color:red; font-size:.8rem'> $address </span>"; endif; ?>
                      </label>
                      <input class="form-control" name="address" required type="text" required placeholder="Address" value="<?php echo @$user_address[0]->address;?>">
                    </div>
                  </div>
                  <!-- address -->

                  <!-- Status -->
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="form-label col-12 p-0 <?php text_from_right() ?>" for="checkout-fn">
                        <?php echo lg_get_text("lg_235") ?>
                      </label>
                      <select name="status" name="status" required class="form-control">
                        <option value="">
                          <?php echo lg_get_text("lg_236") ?>
                        </option>
                        <option <?php if(@$user_address[0]->status=="Active") echo 'selected';?> value="Active">
                          <?php echo lg_get_text("lg_237") ?>
                        </option>
                        <option <?php if(@$user_address[0]->status=="Inactive") echo 'selected';?> value="Inactive">
                          <?php echo lg_get_text("lg_238") ?>
                        </option>

                      </select>
                    </div>
                  </div>
                  <!-- Status -->

                </div>
                
                <!-- Submit Button -->
                <div class="row justify-content-center">
                  <div class="col-12 col-md-5">
                    <div class="mb-3">
                      <button type="submit" class="w-100 btn btn-primary">
                        <?php echo lg_get_text("lg_229") ?>
                      </button>
                    </div>
                  </div>
                </div>
                <!-- Submit Button -->

              </form>
            </section>

          </div>
        </div>
      </section>
      <!-- Sidebar-->

    </div>

  </div>
</div>