<style type="text/css">
  .myaddress_card .icon svg
  {
    width:19px;
    height:19px
  }
  .myaddress_card
  {
    border-bottom:1px solid #eee
  }
  .myaddress_card
  {
    display:flex;
    /* justify-content:flex-start; */
    align-items:center
  }
  .myaddress_card .icon
  {
    background:#eee;
    width:40px;
    height:40px;
    border-radius:100%;
    text-align:center;
    padding-top:6px
  }
  .edit_addreess.icon
  {
    margin-left:20px
  }
  .card_icon.icon
  {
    margin-right:18px
  }
  .myaddress_card h5
  {
    margin:0;
    text-transform:capitalize;
    font-weight:600;
    font-size:16px
  }
  .myaddress_card p
  {
    font-size:14px;
    color:gray;
    margin:0
  }
  .myaddress_card
  {
    padding:10px 0
  }

</style>


<?php
  $session = session();
  $userModel = model('App\Models\UserModel', false);
  $uri = service('uri'); 
  @$user_id=$session->get('userLoggedin'); 
  if(@$user_id){
    $sql="select * from user_address where user_id='$user_id' order by created_at desc";
    $user_address=$userModel->customQuery($sql);
  }
?>


<div class="container-fluid p-0 bg-light pb-5" <?php content_from_right() ?>>
  <?php include 'Common/Breadcrumb.php';?>
  <div class="container pb-5 mb-2 mb-md-4  pt-5">
    <div class="row">
      <div class="col-12 mb-2">
        <div class="heading text-capitalize " >
          <h4 class="font-weight-bold"><?php echo lg_get_text("lg_239") ?></h4>
        </div>
      </div>


      <div class="col-lg-4">
        <?php include 'Common/UserMenu.php';?>
      </div>


      <section class="col-lg-8">
        <div class="row m-0">
          <div class="col-sm-12 bg-white rounded shadow-sm">
            
            <?php
            if(@$flashData['error']){
              ?>   
              <div class="alert alert-danger alert-dismissible mb-2" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?php echo @$flashData['error'];?>
            </div> 
            <?php  
            }
            ?>
            
          <?php
          if(@$flashData['success']){
            ?>

            <div class="alert alert-success alert-dismissible mb-2" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?php echo @$flashData['success'];?>
            </div>

          <?php  
          }
          ?>


        <div class="My Address_parent table-responsive">
          <?php
          if($user_address){
            foreach($user_address as $k=>$v ){
          ?>

            <div class="myaddress_card j-c-spacebetween">

              <div class="row col-auto">
                <div class="icon card_icon mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M19 21H5a1 1 0 0 1-1-1v-9H1l10.327-9.388a1 1 0 0 1 1.346 0L23 11h-3v9a1 1 0 0 1-1 1zM6 19h12V9.157l-6-5.454-6 5.454V19z"/></svg>
                </div>

                <div class="address_message mx-2">
                  <h5>
                    <?php
                     echo $v->name;
                    ?> 

                    <?php

                    if( $v->status=="Active")
                    {

                    ?> 
                    <span class="text-white badge bg-primary  m-0">
                      <?php
                       echo $v->status;
                      ?>
                    </span>
                    <?php 
                    }
                    else 
                    {
                    ?>

                    <span class="text-white badge bg-secondary  m-0">
                      <?php echo $v->status;?>
                    </span>

                    <?php
                    }
                    ?>

                  </h5>

                  <p>
                    <?php echo $v->street;?> <?php echo $v->apartment_house;?>, <?php echo $v->address;?>  
                  </p>

                </div>
              </div>


              <div class="col-auto row m-0 p-0">
                <a href="<?php echo base_url();?>/profile/editAddress/<?php echo $v->address_id;?>" class="icon edit_addreess mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M15.728 9.686l-1.414-1.414L5 17.586V19h1.414l9.314-9.314zm1.414-1.414l1.414-1.414-1.414-1.414-1.414 1.414 1.414 1.414zM7.242 21H3v-4.243L16.435 3.322a1 1 0 0 1 1.414 0l2.829 2.829a1 1 0 0 1 0 1.414L7.243 21z"/></svg>
                </a>


                <a href="<?php echo base_url();?>/profile/deleteAddress/<?php echo $v->address_id;?>" class="icon edit_addreess mx-2">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 6h5v2h-2v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V8H2V6h5V3a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v3zm1 2H6v12h12V8zm-9 3h2v6H9v-6zm4 0h2v6h-2v-6zM9 4v2h6V4H9z"/></svg>
                </a>
              </div>


            </div> 

          <?php
            }
          }

          else
          {
          ?>
          
          <h6>
            <?php echo lg_get_text("lg_240") ?>
          </h6>
          <?php
          }
          ?>

        </div>


    </div>
  </div>
</section>
<!-- Sidebar-->
</div>
</div>
</div>
