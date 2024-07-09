<style>
.lab{
    display: unset;
}
 
   .mod-body{
     max-height: 435px;
   overflow-x: hidden;
     
   } 
 .card-body2 {
    
    max-height: 350px;
   overflow-x: hidden;
}
</style>

<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
$dc_value=0;

$dtotal=0;
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
  $sql="select * from cart where user_id='$user_id'";
  $cartCount=$userModel->customQuery($sql);
  $sql="select * from user_address where user_id='$user_id' And status='Active'";
  $user_address=$userModel->customQuery($sql);
}



$sql="select * from city where status='Active' AND city_id !='all'";
$city=$userModel->customQuery($sql);

$sql="select * from settings";
$settings=$userModel->customQuery($sql);
$uri = service('uri'); 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
  $sql="select * from users where user_id='$user_id'";
  $userDetails=$userModel->customQuery($sql);
  $sql="select *,cart.pre_order_enabled as pre_order_enabled, cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart 
  inner join products on cart.product_id=products.product_id
  where cart.user_id='$user_id'";
  $cart=$userModel->customQuery($sql);
}else{
    $sid=session_id(); 
    $sql="select * ,cart.pre_order_enabled as pre_order_enabled,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart
    inner join products on cart.product_id=products.product_id
    where cart.user_id='$sid'";
    $cart=$userModel->customQuery($sql);
}
$pre_order_enabled='No';
if($cart){
    foreach($cart as $ck=>$cv){
        if($cv->pre_order_enabled=="Yes"){
            $pre_order_enabled='Yes';break;
        }
    }
}else{
    ?>
    
    <div class="cart-layout-outer">
 <div class="container">
  <div class="row">
   <div class="col">
    <center style="height:300px;"><h4>Cart is empty!</h4></center>
  </div>
</div>  </div>
</div>
   
    
    <?php  
}


$sql="select * from gift_wrapping where     status='Active' ";
$gift_wrapping=$userModel->customQuery($sql);   


 if($cid=$user_address[0]->city){}
 else{
     $cid=$userDetails[0]->city;
 }
$sql="select * from charges where     status='Active' AND (city='all' || city='$cid')";
$charges=$userModel->customQuery($sql);   



?>
<style>input#installation-checkbox2{width:22px;height:22px}.loading{position:fixed;z-index:999;height:2em;width:2em;overflow:show;margin:auto;top:0;left:0;bottom:0;right:0}.loading:before{content:'';display:block;position:fixed;top:0;left:0;width:100%;height:100%;background-color:#000;opacity:.8;-moz-opacity:.8}.loading:not(:required){font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.loading:not(:required):after{content:'';display:block;font-size:10px;width:1em;height:1em;margin-top:-.5em;-webkit-animation:spinner 1.5s infinite linear;-moz-animation:spinner 1.5s infinite linear;-ms-animation:spinner 1.5s infinite linear;-o-animation:spinner 1.5s infinite linear;animation:spinner 1.5s infinite linear;border-radius:.5em;-webkit-box-shadow:#fff 1.5em 0 0 0,#fff 1.1em 1.1em 0 0,#fff 0 1.5em 0 0,#fff -1.1em 1.1em 0 0,rgba(0,0,0,.5) -1.5em 0 0 0,rgba(0,0,0,.5) -1.1em -1.1em 0 0,#fff 0 -1.5em 0 0,#fff 1.1em -1.1em 0 0;box-shadow:#fff 1.5em 0 0 0,#fff 1.1em 1.1em 0 0,#fff 0 1.5em 0 0,#fff -1.1em 1.1em 0 0,#fff -1.5em 0 0 0,#fff -1.1em -1.1em 0 0,#fff 0 -1.5em 0 0,#fff 1.1em -1.1em 0 0}@-webkit-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-moz-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@-o-keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spinner{0%{-webkit-transform:rotate(0);-moz-transform:rotate(0);-ms-transform:rotate(0);-o-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);-moz-transform:rotate(360deg);-ms-transform:rotate(360deg);-o-transform:rotate(360deg);transform:rotate(360deg)}}#loading{display:none}

#ForgotForm2,#verifyOTP2 {
    display: none;
}

.product_box_image img{max-height:200px;}
</style>




	<div class="loading" id="loading"  >
	Loading&#8230;</div>




<?php
if($cart){?> 

<div class="cart-layout-outer">
 <div class="container">
  <div class="row">
   <div class="col">
    <h3 class="cart-title font-weight-bold">Checkout</h3>
  </div>
</div>
<div class="row">
 <div class="col-12 col-lg-8 mt-2">
  <div class="cart-products-outer">
   <div class="card border-0 mb-2">
    <?php 
    if($session->get('userLoggedin')){
     if($user_address){
         ?>
           <form action="<?php echo base_url();?>/order-submit" method="post">
         <?php
     }else{
       ?>
       <form action="<?php echo base_url();?>/order-submit" method="post">
         <?php
       }}
       ?>
       <div class="card-body">
         <?php 
         if($session->get('userLoggedin')){
           if($user_address){
             ?>
             <div class="title_heading d-flex justify-content-between">
              <h4 class="mb-3 font-weight-bold text-capitalize">  Delivery Address</h4>
              <a href="javascript:void();"  data-toggle="modal" data-target="#changeAddressModla" class="text-primary">Change</a>
            </div>
            <div class="row">
              <div class="col">
               <div class="row justify-content-between pl-3 pr-3">
                <div class="title_productrs">
                 <h6><?php echo $user_address[0]->name;?></h6>
                 <h6><?php echo $user_address[0]->street;?></h6>
                 <h6><?php echo $user_address[0]->apartment_house;?></h6>
                 <h6><?php echo $user_address[0]->address;?></h6>
                  <h6><?php
                  $cid=$user_address[0]->city;
                  $sql="select * from city where   city_id ='$cid'";
$cityDetail=$userModel->customQuery($sql);



                  
                  echo @$cityDetail[0]->title;?></h6>
               </div>
             </div>
           </div>
         </div>
         <?php
       }else{
        ?>
        <h5 class="pb-3 border-bottom text-capitalize"><strong>Delivery Address</strong></h5>
        <div class="row" >
          <div class="col-md-12 mt-2">
            <label class="m-0 font-weight-bold">Name </label>
            <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Name" name="name"  required value="<?php echo $userDetails[0]->name;?>">
          </div>
          <div class="col-md-12 mt-2">
            <label class="m-0 font-weight-bold">Street</label>
            <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Street" name="street"  required value="<?php echo $userDetails[0]->street;?>">
          </div>
          <div class="col-md-12 mt-2">
            <label class="m-0 font-weight-bold">Apartment/House No.</label>
            <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Apartment/House No." name="apartment_house"  required value="<?php echo $userDetails[0]->apartment_house;?>">
          </div>
          <div class="col-md-12 mt-2">
            <label class="m-0 font-weight-bold">Address</label>
            <input type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Address" name="address"  required value="<?php echo $userDetails[0]->address;?>">
          </div>
          
             <div class="col-md-12 mt-2">
            <label class="m-0 font-weight-bold">City</label>
            <select name="city" required class="form-control">
                              
                              <option value="">Select city</option>
                              
                              <?php if($city){
                              foreach($city as $k=>$v){
                                  ?>
                                  
                                   <option <?php if($v->city_id==$userDetails[0]->city) echo "selected";?>  value="<?php echo $v->city_id;?>"><?php echo $v->title;?></option>
                                  <?php
                              }
                              }?>
                              
                          </select>
          </div>
          
        </div>
        <?php   
      }
      ?>
      <?php
    }else{
     ?>
     <div class="  bg-white">
      <ul class="nav nav-tabs checkout_nav">
        <li class="nav-item">
          <a id="loginTab2" class="nav-link active" data-toggle="tab" href="#login_tab2">login </a>
        </li>
        <li class="nav-item">
          <a  id="signupTab2" class="nav-link " data-toggle="tab" href="#ergsiter_fisrt2">register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " data-toggle="tab" href="#guest_user2">guest</a>
        </li> 
      </ul>
      <div class="tab-content p-4">
        <div class="tab-pane active" id="login_tab2">
       
          <div class="mt-3 headding text-center text-capitalize">
            <h6 class="font-weight-bold"  id="LoginUsingEmial2">-- Login using email --</h6>
          </div>
          <form id="buyer_login_form2" class="row  " method="POST" action="<?php echo base_url();?>/auth/LoginValidation" autocomplete="off">
            <div class="col-md-12 mt-2">
              <div id="buyer_login_form_message2"> </div>
            </div>
            <div class="col-md-12 mt-2">
              <label class="m-0 font-weight-bold">Email</label>
              <div class="password_parent_field" >
                <input name="email" required type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Email">
              </div>
            </div>
            <div class="col-md-12 mt-2">
              <label class="m-0 font-weight-bold">Password</label>
              <div class="password_parent_field" >
                <div class="eye_password" data_val="text">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                </div>
                <input name="password"  required type="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Password">
              </div>
            </div>
            <div class="col-12 mt-2">
              <button class="btn btn-primary w-100 p-2 text-capitalize mt-2">Login</button>
            </div>
          </form>
          
          
          
          
          
          
                 <form id="ForgotForm2" class="row  " method="POST" action="<?php echo base_url();?>/auth/forgotPassword" autocomplete="off">
                  <div class="col-md-12 mt-2">
                
                  <div id="ForgotMessage2"></div>
     </div>
                
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Email</label>
                  <div class="password_parent_field" >
                 
                  <input name="email" required type="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Email">
                  </div>
                </div>
              
                <div class="col-12 mt-2">
                  <button class="btn btn-primary w-100 p-2 text-capitalize mt-2">Submit</button>
                </div>
              </form>
          
          
          
          
          
          
          
          
              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- or login with otp --</h6>
              </div>
            
             <div id="loginWithOTPMssage2"></div>
            
               <form id="verifyOTP2"  method="POST" action="<?php echo base_url();?>/auth/verifyOTP" autocomplete="off">
                 
                  <input type="hidden" name="phone" id="vphone2" required>
                 
                <div class="mt-3 d-flex justify-content-between border border-weight-2 rounded position-relative">
                 
                  <label class="label_top m-0" style="left: 10px;">Enter Verification code</label>
                <input style="padding-left:20px !important;" min="4" max="4" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));"  name="code" required type="text" class=" w-100 border-0  p-2" placeholder="XXXX">
                <button class=" w-100 btn btn-primary text-capitalize p-2">Submit</button>
                </div>
              </form>
              
              
              
              <form id="loginWithOTP" method="POST" action="<?php echo base_url();?>/auth/loginWithOTP" autocomplete="off">
                 
                 
                 
                <div class="mt-3 d-flex justify-content-between border border-weight-2 rounded position-relative">
                  <select required="" name="country_code" class=" border-0 w-100 p-2" style="width: 82px !important">
                    <option value="+971">+971</option>
                     <option value="+91">+91</option>
                  </select>
                  <label class="label_top m-0" style="left: 10%;">Enter phone number</label>
                <input id="pn" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));" name="phone" required="" type="text" class=" w-100 border-0  p-2" placeholder="50 XXX XXXX">
                <button class="w-100 btn btn-primary text-capitalize p-2">Submit</button>
                </div>
              </form>
              
            
          <hr>
          <div class="d-flex text-capitalize justify-content-between font-weight-bold">
               <a href="javascript:void(0);"  class="text-primary" onclick="forgotPassword2();">Forgot Password?</a>
            <a href="javascript:void(0);"  class="text-primary" onclick="document.getElementById('signupTab2').click()" >Create an Account</a>
          </div>
        </div>
        <div class="tab-pane" id="ergsiter_fisrt2">
      
          <div class="mt-3 headding text-center text-capitalize">
            <h6 class="font-weight-bold">-- Register using email --</h6>
          </div>
          <form id="buyer_signup_form2" class="row  " method="POST" action="<?php echo base_url();?>/auth/registration" autocomplete="off">
              <input type="hidden" name="user_type"  value="Normal">
            <div class="col-md-12 mt-2">
              <div id="buyer_signup_message2"></div>
            </div>
            <div class="col-md-12 mt-2">
              <label class="m-0 font-weight-bold">Name</label>
              <input name="name" required type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter name">
            </div>
            <div class="col-md-6 mt-2">
              <label class="m-0 font-weight-bold">Email</label>
              <input type="email" required name="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter email">
            </div>
            <div class="col-md-6 mt-2">
              <label class="font-weight-bold">Phone</label>
         <div class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                      <select required="" name="country_code" class=" border-0 w-100 p-2" style="width: 82px !important">
                        <option value="+971">+971</option>
                     <option value="+91">+91</option>
                      </select>
                      <input type="text" name="phone" required="" class=" w-100 border-0  p-2" placeholder="50 XXX XXX XXX" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));">
                    </div>
            </div>
            <div class="col-md-6 mt-2">
              <label class="m-0 font-weight-bold">Password</label>
              <div class="password_parent_field" >
                <div class="eye_password" data_val="text">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                </div>
                <input type="password" required name="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter password">
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <label class="m-0 font-weight-bold">Confirm Password</label>
              <div class="password_parent_field" >
                <div class="eye_password" data_val="text">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                </div>
                <input type="password" required name="confirm_pass" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter confirm password">
              </div>
            </div>
            
            
            
    <input type="hidden" name="verify_method"  value="email">
                
            
            
            
            <div class="col-12 mt-2">
              <label class="m-0 font-weight-bold text-gray">
                <input type="checkbox"  required >
                I have read and agree to the <a class="text-primary" href="<?php echo base_url();?>/privacy-and-policy">Privacy Policy</a></label>
              </div>
              <div class="col-12 mt-2">
                <button class="btn btn-primary w-100 p-2 text-capitalize">Register</button>
              </div>
            </form>
            <div class="mt-3 headding text-center text-capitalize">
              <h6 class="font-weight-bold"> - Already Registered User?   <a href="javascript:void(0);" class="text-primary" onclick="document.getElementById('loginTab2').click()"><b>Click here</b></a> to login   </h6>
            </div>
            
            </div>
            <div class="tab-pane" id="guest_user2">
              <div class="mt-3 headding text-center text-capitalize">
                <h5 class="font-weight-bold">checkout as a guest</h5>
              </div>
              <form id="buyer_signup_formGuest" class="row  " method="POST" action="<?php echo base_url();?>/auth/registrationGuest" autocomplete="off">
                   <input type="hidden" name="user_type"  value="Guest">
                <div class="col-md-12 mt-2">
                  <div id="buyer_signup_messageGuest"></div>
                </div>
                <div class="col-md-12 mt-2">
                  <label class="m-0 font-weight-bold">Name</label>
                  <input name="name" required type="text" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter name">
                </div>
                <div class="col-md-6 mt-2">
                  <label class="m-0 font-weight-bold">Email</label>
                  <input type="email" required name="email" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter email">
                </div>
                <div class="col-md-6 mt-2">
                  <label class="font-weight-bold">Phone</label>
                <div class="d-flex justify-content-between border border-weight-2 rounded position-relative">
                      <select required="" name="country_code" class=" border-0 w-100 p-2" style="width: 82px !important">
                        <option value="+971">+971</option>
                     <option value="+91">+91</option>
                      </select>
                      <input type="text" name="phone" required="" class=" w-100 border-0  p-2" placeholder="50 XXX XXX XXX" onkeypress="return /\d/.test(String.fromCharCode(((event||window.event).which||(event||window.event).which)));">
                    </div>
                </div>
                <div class="col-12 mt-2">
                  <button class="btn btn-primary w-100 p-2 text-capitalize">Continue</button>
                </div>
              </form>
              <div class="mt-3 headding text-center text-capitalize">
                <h6 class="font-weight-bold">-- already have a account --</h6>
              </div>
              <form class="row">
                <div class="col-12 mt-2">
                  <a onclick="document.getElementById('loginTab2').click()" href="javascript:Void(0);" class="btn btn-primary w-100 p-2 text-capitalize">login</a>
                </div>
              </form>
            </div>
          </div>
        </div>
        <?php
      } 
      ?>
      <div class="row">  
       <div class="col-12 mt-2">
        <h5 class="pb-3 border-bottom text-capitalize"><strong>Payment method </strong></h5>
      </div>
      <div class="col-12">
       <div class=" justify-content-between ">
        <div class=" title_productrs">
         <div class="product-option-message">
          <div class="m-0 product-option-message border-0">
            <label class="checkbox light-green d-flex " for="installation-checkbox">
              <input id="installation-checkbox" type="radio" name="payment_method" value="Online payment">
             <!-- <span class="checkmark" style="background-image:url(<?php echo base_url();?>/assets/img/credit_car.PNG)"></span>-->
              <span class="checklabel ml-3 option-installation">Pay by credit / debit card</span>
            </label>
          </div>
        </div>
      </div>
      
      <?php 
      if($pre_order_enabled=="No"){
      ?>
      <div class=" title_productrs">
       <div class="product-option-message">
        <div class="m-0 product-option-message border-0">
          <label class="checkbox light-green d-flex " for="installation-checkbox2">
            <input id="installation-checkbox2" type="radio" class="mr-2" name="payment_method" value="Cash on devlivery">
            <span class="checklabel option-installation">Cash on Delivery</span>
          </label>
        </div>
      </div>
    </div>
    <?php } ?>
    
    
    
    
 <?php 
@$user_id=$session->get('userLoggedin'); 
if(@$user_id){
    
    $sql="select sum(available_balance)  as total from wallet where user_id='$user_id'  And (status='Active' OR status='Used')  order by created_at desc";
$cbal=$userModel->customQuery($sql);
if($cbal[0]->total){
    ?>
    
     <div class="col-12 mt-2">
      <label class="m-0 font-weight-bold text-black">
        <input type="checkbox"  id="wallet_use" name="wallet_use" value="Yes" >
      Use my wallet (<b class="black">Available balance :  <?php echo bcdiv($cbal[0]->total,1,2);?> AED</b>)</label>
      </div>
    
    <input type="hidden" id="wallet_bal" value="<?php echo  bcdiv($cbal[0]->total , 1, 2);?> ">
    
    <?php 
    }
    }
    ?>
    
    
    
    
    
    
    
    
    
    
    
    <div class="col-12 mt-2">
      <label class="m-0 font-weight-bold text-gray">
        <input type="checkbox" name="" required>
        I have read and agree to the <a class="text-primary" href="<?php echo base_url();?>/privacy-and-policy">Privacy Policy</a></label>
      </div>
      <div class="col-12 mt-2">
        <button type="submit" class="btn btn-primary w-100 p-2 text-capitalize">continue</button>
      </div>
    </div>
  </div>
</div>
<?php 
if($session->get('userLoggedin')){
 if($user_address){
     ?>
     
      </form>
      <?php
 }else{
   ?>
 </form>
 <?php
}
    
}
?>
</div>
</div>
</div>
</div>
<div class="col-12 col-lg-4 mt-2">
  <div class="order-summary-outer ">
    <?php if($cart){
      $ptotal=0;
     $coupon_code="";
       foreach($cart as $kk=>$vv){ 
           if($vv->coupon_code){
               $coupon_type=$vv->coupon_type;
                 $coupon_value=$vv->coupon_value;
               $coupon_code=$vv->coupon_code;break;
           }
       }
      
      
      ?>
      <div class="card">
        <div class="card-body ">
         <div class="promo-code-outer p-3">
          <div data-toggle="collapse" data-target="#demo"><div class="promo-code d-flex justify-content-between">
           <p class="m-0">
               <?php if($coupon_code) echo '<b style="color:green;">Coupon code applied!</b>';else{echo 'Use a coupon code';}?>
               </p>
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path></svg>
         </div></div>
         <div id="demo" class="collapse">
          <div class=" form-sm d-flex bg-white border rounded pb-0 border-weight-2 mt-3">
           <input  <?php if($coupon_code) echo 'readonly disabled';?> value="<?php if($coupon_code) echo $coupon_code;?>" id="coupon_code" label="Enter promo code" name="coupon_code" placeholder="Enter promo code" type="text" class="form-sm-input form-control m-0 border-0" aria-invalid="false" value="">
           <button <?php if($coupon_code) echo '  disabled';?> type="button" id="ApplyCoupon" class="form-sm-btn btn text-primary font-weight-bold" style="color:black !important;">Submit</button>
         </div>
       </div>
     </div>
       <div class="card-body2">
     <?php 
     foreach($cart as $k=>$v){ 
       $gw_price=0;
       if($gid=$v->gw){
        $sql="select * from gift_wrapping where     status='Active' AND id='$gid' ";
        $gd=$userModel->customQuery($sql);   
        if($gd){
          $gw_price=$gd[0]->price;
        }
      }
      ?>
    
      <div class="price-summary-outer">
        <div class="justify-content-between text-discount row">
          <div class="col-auto"><?php echo substr($v->name,0,24);?>..   </div>
          <div class="col-auto">
            <?php 
            if($v->dp > 0 ){
              echo bcdiv(round(($v->price - ($v->dp*$v->price)/100))*$v->quantity, 1, 2); 
            
            } else {
              echo bcdiv($v->price*$v->quantity, 1, 2);
           
            }
            ?>
          AED</div>
          <div class="col-auto"> ( 
          
          
          
          
          
           <?php 
            if($v->dp > 0 ){
              echo round(bcdiv(($v->price - ($v->dp*$v->price)/100), 1, 2)); 
            
            } else {
              echo bcdiv($v->price, 1, 2);
           
            }
            ?>  AED *<?php echo $v->quantity;?>  ) 
          </div>
        </div>
        <?php 
        if($v->app){
          ?>
          <div class="justify-content-between text-discount row">
           <div class="col-auto">Assemble Professionally
           </div>
           <div class="col-auto"><?php echo bcdiv($v->app*$v->quantity, 1, 2);?> AED</div>
         </div>
         <?php
       } 
       ?>
       <?php 
       if($gid=$v->gw){
        $sql="select * from gift_wrapping where     status='Active' AND id='$gid' ";
        $gk=$userModel->customQuery($sql);   
        if($gk){
          ?>
          <div class="justify-content-between text-discount row">
           <div class="col-auto">gift wrapping
           </div>
           <div class="col-auto"><?php echo bcdiv($gk[0]->price*$v->quantity, 1, 2);?> AED</div>
         </div>
         <?php
       } 
     }
     
    //  Coupon APply
    if($v->dp>0){
         $ptotal=$ptotal+(round(($v->price - ($v->dp*$v->price)/100))  + $v->app + $gw_price ) *$v->quantity; 
    }else{
        
        $tpro=($v->price + $v->app+$gw_price)*$v->quantity;
        
          if($v->coupon_code){
              if($v->coupon_type=="Percentage"){
                  $dtotal=$dtotal+($tpro- ($tpro*$v->coupon_value)/100);
                    $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                    
                    
                     $ptotal=$ptotal+(($tpro- ($tpro*$v->coupon_value)/100)) ;
                    
                  
              }else{
                  $dtotal=$dtotal+($tpro-$v->coupon_value); 
                  $dc_value=$dc_value+$v->coupon_value;
                  
                  
                   $ptotal=$ptotal+(($tpro-$v->coupon_value));
              }
          }else{
                 $ptotal=$ptotal+($v->price+$v->app+$gw_price)*$v->quantity;
          }
    }
    
     
     ?>
     </div>
     <hr class="my-3">
   <?php }  ?>
   <?php 
   $chrg=0;if($charges){
   foreach($charges as $k2=>$v2){ 
       if($ptotal>= $v2->applicable_minimum_amount && $ptotal<=$v2->applicable_maximum_amount){
    ?>
    <div class="price-summary-outer">
      <div class="justify-content-between text-discount row">
        <div class="col-auto"><?php echo  ($v2->title ); ?><?php  if($v2->type =="Percentage") echo   '('. $v2->value.'%)'?>   </div>
        <div class="col-auto">
          <?php 
         
          if($v2->type =="Percentage"){
            echo bcdiv(($ptotal*$v2->value)/100, 1, 2);
            $chrg=$chrg+($ptotal*$v2->value)/100;
          } else {
            echo bcdiv($v2->value, 1, 2);
            $chrg=$chrg+($v2->value);
          }?>
        AED</div>
      </div>
      </div>
      <hr class="my-3">
    <?php } } }?>
    
    <?php if($coupon_code){
    
    
    ?>
    
   
     <div class="justify-content-between text-discount row">
        <div class="col-auto">Coupon discount  
        <?php
         $coupon_type=$vv->coupon_type;
                 $coupon_value=$vv->coupon_value;
                 if($coupon_type=="Percentage"){
                     ?>
                       (<?php echo $coupon_value;?>%)<?php
                 }else{
                     ?>
                     (<?php echo $coupon_value;?> AED)
                     <?php
                 }
        
        ?>
        
        </div>
        <div class="col-auto">
          <?php echo @$dc_value;?>
        AED</div>
      </div>
      <hr class="my-3">
    <?php } ?>
    
     </div>
    
    <div class="justify-content-between order-total row">
      <div class="col-auto"> Total</div>
      <div class="col-auto"><?php
      
      
      echo bcdiv($ptotal+$chrg, 1, 2);?> AED</div>
    </div>
     <input  type="hidden" id="checkout_total" value="<?php echo bcdiv($ptotal+$chrg , 1, 2);?>">
        <div class="justify-content-between order-total row" id="wallet_section">
 
    </div>
     <div class="justify-content-between order-total row" id="payable_section">
 
    </div>
    <hr class="my-3">
  </div>
  <div class="cart-buttons">
    <div class="row">
      <div class="col">
          <?php if($coupon_code){}else{
          
          
$freeCount=0;
if($ptotal){
  if($settings[0]->freebie_applicable_amount){
      if($freeCount= (int)(($ptotal) /  ($settings[0]->freebie_applicable_amount))){
         
      }
      
  }  
}
if($freeCount>0 && false){
          
          ?>
          <input type="hidden" id="freebie_applicable_amount" value="<?php echo $freeCount;?>">
          
            <a href="javascript:void(0);" data-toggle="modal" data-target="#FreebieModal" class="btn p-2 btn-primary btn-block font-weight-bold p-3 ">Add Freebie Products</a>
            
            <?php }} ?>
            
        <a href="<?php echo base_url();?>/cart" class="btn p-2 btn-primary btn-block font-weight-bold p-3 ">Go to Cart</a>
        <a href="<?php echo base_url();?>/product-list" class="btn p-2 btn-primary btn-block font-weight-bold p-3 ">Continue shopping</a>
      </div>
    </div>
  </div>
  <div class="security-message mt-3 text-gray text-capitalize text-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M19 10h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 1 1 14 0v1zM5 12v8h14v-8H5zm6 2h2v4h-2v-4zm6-4V9A5 5 0 0 0 7 9v1h10z"></path></svg>
  Our website is 100% encrypted and your personal details are safe</div>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php } ?>
<div class="clearfix"></div>


<?php if($coupon_code){}else{


if($freeCount>0){

?>
<!-- Modal -->
<div id="FreebieModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      
        <h4 class="modal-title">Add Freebie Products</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" >
      <div class="modal-body mod-body"> 
      
        <div class="row">
      <?php 
      
      
      
 $sql="select *     from products 
 where products.status='Active' AND  products.freebie='Yes'    ";
 
 $sql=$sql."order by created_at desc limit 20";
  
  $product=$userModel->customQuery($sql); 
 
 
if($product){
     if($session->get('userLoggedin')){
    @$user_id=$session->get('userLoggedin'); 
  }else{
    @$user_id=session_id(); 
  }
	foreach($product as $k=>$v){
		$pid=$v->product_id;
		$sql="select * from product_image where     product='$pid' and status='Active' ";
		$product_image=$userModel->customQuery($sql);      
		
		$pid=$v->product_id;
		
		
			$sql="select * from cart where user_id='$user_id' AND product_id='$pid' ";
		$tcart=$userModel->customQuery($sql);      
		
		
		?>
		<div class="p-10px col-md-3  col-sm-6 col-6 mb-3">
		       <label  for="<?php echo $v->product_id;?>" class="lab">
			<div class="product_box shadow-none bg-white rounded overflow-hidden chk">
			    
			 
			 
					<div class="product_box_image">
					 
						<img src="<?php echo base_url(); ?>/assets/uploads/<?php if($product_image[0]->image) echo $product_image[0]->image;else echo 'noimg.png'; ?>" class="border-0">
					</div>
			
			 
				<div class="product_box_content">
					<h5><strong> 
					      <input <?php if($tcart) echo 'checked'; ?> type="checkbox" name="freebie[]" value="<?php echo $v->product_id;?>" id="<?php echo $v->product_id;?>" >
					    
					    <?php echo $v->name;?> </strong></h5>
				 <a target="_blank" class="btn btn-primary"  href="<?php echo base_url();?>/product/<?php echo $v->product_id;?>">View Detail</a>
			
			</div>
		</div>
			</label>
	</div> 
	<?php } ?>
	
	
	

<?php } ?>
      </div>
       </div>
      <div class="modal-footer">
          
          <b class="text-left red text-red" >You are eligible to add only <span><?php echo @$freeCount;?></span> freebie products</b>
             <button type="submit" class="btn btn-primary"  >Add selected Freebie to cart</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div><?php }} ?>
 