<?php 
$uri = service('uri'); 
if(count(@$uri->getSegments())>1){
  $uri2=@$uri->getSegment(2); 
}else{
    
}
?>
<div class="container pt-5 pb-5">
  <div class="row  justify-content-center">
   
<div class="col-lg-6">
  <div class="heading">
    <h2>   Reset your password
    </h2>
    <p>   A strong password helps prevent unauthorized access to your account.
    </p> 
</div>
 <div id="resetPasswordMessage"></div>
    <button id="forgotLogin" data-toggle="modal" data-target="#login-modal" style="display:none;" class="btn btn-primary  p-3 w-100" data-form="login" onClick="get_form(this.getAttribute('data-form'))">Click here to login </button>
<form id="resetPasswordForm" class="contact_us_form" action="<?php echo base_url();?>/auth/resetPasswordSubmit" method="POST">
   
    <input type="hidden" name="token" value="<?php echo $uri2;?>">
    <div class="form-row">
    <div class="form-group col-lg-12">
        <label class="m-0 font-weight-bold">New Password</label>
     <div class="password_parent_field">
                  <div class="eye_password" data_val="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path></svg>
                  </div>
                  <input name="password" required="" type="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter New Password">
                  </div>
    </div>
    <div class="form-group col-lg-12">
        <label class="m-0 font-weight-bold">Confirm Password</label>
      <div class="password_parent_field">
                  <div class="eye_password" data_val="text">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 3c5.392 0 9.878 3.88 10.819 9-.94 5.12-5.427 9-10.819 9-5.392 0-9.878-3.88-10.819-9C2.121 6.88 6.608 3 12 3zm0 16a9.005 9.005 0 0 0 8.777-7 9.005 9.005 0 0 0-17.554 0A9.005 9.005 0 0 0 12 19zm0-2.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9zm0-2a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"></path></svg>
                  </div>
                  <input name="confirm_password" required="" type="password" class="w-100 border border-weight-2 rounded p-2" placeholder="Enter Confirm Password">
                  </div>
    </div>
    
    <div class="form-group col-lg-12">
        <button class="btn btn-primary w-100 p-3" type="submit">Submit</button>
    </div>
</div>
</form>
</div>
</div>
</div>