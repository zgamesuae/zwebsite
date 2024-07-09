<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
    @$user_id=$session->get('userLoggedin'); 
  if(@$user_id){
      $sql="select * from users where user_id='$user_id'";
$userDetails=$userModel->customQuery($sql);
 
}

 $sql="select * from city where status='Active' AND city_id !='all'";
$city=$userModel->customQuery($sql);
?>
<div class="container-fluid p-0 bg-light pb-5">

    <?php include 'Common/Breadcrumb.php';?>

    <div class="container pb-5 mb-2 mb-md-4  pt-5" <?php content_from_right() ?>>
      <div class="row">

        <div class="col-lg-4">
          <?php include 'Common/UserMenu.php';?>
        </div>

        <section class="col-lg-8">
          <div class="row">
            <div class="col-sm-12 bg-white rounded shadow-sm">
              <div class="apply_procode border-weight-2 border-bottom font-weight-bold d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#promo_code">
                <h4>
                  <strong><?php echo lg_get_text("lg_224") ?> </strong>
                </h4>
         
              </div>
                <section class="col-lg-12 pt-3">
                    <form method="post"  enctype="multipart/form-data">
                      <div class="row">

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_148") ?></label>
                                <input class="form-control" name="name" required value="<?php echo $userDetails[0]->name;?>" type="text" >
                            </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="mb-3">
                              <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" ><?php echo lg_get_text("lg_17") ?></label>
                              <input disabled class="form-control" type="email" value="<?php echo $userDetails[0]->email;?>" name="email" >
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_225") ?></label>
                            <select required disbaled name="country_code" class="form-control">
                              <option <?php if($userDetails[0]->country_code=="+971") echo 'selected'; ?> value="<?php echo PHONE_CODE ?>"><?php echo PHONE_CODE ?></option>
                            </select>

                          </div>
                        </div>

                       <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_226") ?></label>
                            <input class="form-control" type="text" value="<?php echo $userDetails[0]->phone;?>" name="phone" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" >
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_222") ?></label>
                            <select name="city" required class="form-control">
                                <option value=""><?php echo lg_get_text("lg_223") ?></option>
                                <?php if($city){
                                foreach($city as $k=>$v){
                                    ?>

                                     <option <?php if($userDetails[0]->city==$v->city_id) echo 'selected';?> value="<?php echo $v->city_id;?>"><?php echo $v->title;?></option>
                                    <?php
                                }
                                }?>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-6">
                          <div class="mb-3">
                            <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_68") ?></label>
                            <input class="form-control" type="text" value="<?php echo $userDetails[0]->address;?>" name="address" >
                          </div>
                        </div>
                              
                              
                        <div class="col-sm-3">
                          <div class="mb-3">
                            <label class="form-label col-12 p-0 <?php echo text_from_right() ?>" for="checkout-fn"><?php echo lg_get_text("lg_227") ?></label>
                            <div class="file-input">
                              <input type="file" name="file"     id="file-input" class="file-input__input" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                              <label class="file-input__label" for="file-input">
                              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="upload" class="svg-inline--fa fa-upload fa-w-16 mx-1" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M296 384h-80c-13.3 0-24-10.7-24-24V192h-87.7c-17.8 0-26.7-21.5-14.1-34.1L242.3 5.7c7.5-7.5 19.8-7.5 27.3 0l152.2 152.2c12.6 12.6 3.7 34.1-14.1 34.1H320v168c0 13.3-10.7 24-24 24zm216-8v112c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V376c0-13.3 10.7-24 24-24h136v8c0 30.9 25.1 56 56 56h80c30.9 0 56-25.1 56-56v-8h136c13.3 0 24 10.7 24 24zm-124 88c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20zm64 0c0-11-9-20-20-20s-20 9-20 20 9 20 20 20 20-9 20-20z"></path></svg>
                              <span><?php echo lg_get_text("lg_228") ?></span></label>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="mb-3">
                            <?php 
                            preg_match("/http/" , $userDetails[0]->image , $matches);
                            if(sizeof($matches) > 0)
                            $photo_url = $userDetails[0]->image;
                            else if(!$userDetails[0]->image)
                            $photo_url = base_url()."/assets/uploads/noimg.png";
                            else
                            $photo_url = base_url()."/assets/uploads/".$userDetails[0]->image;

                            ?>
                            <!-- <img id="blah" src="<?php echo base_url();?>/assets/uploads/<?php if($userDetails[0]->image) echo $userDetails[0]->image; else echo 'noimg.png';?>" alt="your image" width="70" height="70" /> -->
                            <img id="blah" src="<?php echo $photo_url ?>" alt="your image" width="70" height="70" />
                          </div>
                        </div>
                      </div>
                    
                    
                    
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="mb-3">
                            <button type="submit" class="w-100 btn btn-primary"><?php echo lg_get_text("lg_229") ?></button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </section>
            </div>
          </div>
        </section>

      </div>
     
    </div>

</div>








 