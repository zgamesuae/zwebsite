  
<?php include 'Common/Breadcrumb.php';?>

<div class="container pt-5 pb-5">
  <div class="row">
    <div class="col-lg-3">
      <div class="row">
          <div class="col-xl-12 col-sm-6">
              <div class="iconbox iconbox-style-7">
                  <div class="iconbox-inner d-flex">
                      <div class="iconbox-icon skincolor">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"></path></svg>
                    </div>
                    <div class="iconbox-inner">
                      <div class="iconbox-contents">
                          <div class="iconbox-title">
                              <h2><strong>Phone Number</strong></h2>
                          </div>
                          <div class="iconbox-desc">
                              <?php echo $settings->phone; ?>                                           </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-xl-12 col-sm-6 mt-sm-30">
              <div class="iconbox iconbox-style-7">
                  <div class="iconbox-inner d-flex">
                      <div class="iconbox-icon skincolor">
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 20.9l4.95-4.95a7 7 0 1 0-9.9 0L12 20.9zm0 2.828l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zM12 13a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"></path></svg>
                   </div>
                   <div class="iconbox-inner">
                      <div class="iconbox-contents">
                          <div class="iconbox-title">
                              <h2><strong>Our Address</strong></h2>
                          </div>
                          <div class="iconbox-desc">
                            <?php echo $settings->address; ?>                                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-sm-6 mt-sm-30">
          <div class="iconbox iconbox-style-7">
              <div class="iconbox-inner d-flex">
                  <div class="iconbox-icon skincolor">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"></path></svg>
               </div>
               <div class="iconbox-inner">
                  <div class="iconbox-contents">
                      <div class="iconbox-title">
                          <h2><strong>Email Address</strong></h2>
                      </div>
                      <div class="iconbox-desc">
                         <?php echo $settings->email; ?>                                    </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
<div class="col-lg-9">
  <div class="heading">
    <h2> <?php
    echo $cms[5]->heading;
    ?>
    </h2>
    <p><?php 
    echo $cms[5]->description;
    ?>
 
    </p> 
</div>
<form   class="contact_us_form" action="<?php echo base_url(); ?>/Home/ContactSubmit" method="POST">
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
  <div class="form-row">
    <div class="form-group col-lg-6">
        <input type="text" class="form-control" placeholder="Your Name" name="name" required="">
    </div>
    <div class="form-group col-lg-6">
        <input class="form-control" placeholder="Your Email" name="email" type="email" aria-required="true" required="">
    </div>
    <div class="form-group col-lg-6">
        <input class="form-control" placeholder="Your Phone" name="phone" type="text" aria-required="true" required="">
    </div>
    <div class="form-group col-lg-6">
        <input type="text" class="form-control" placeholder="subject" name="subject">
    </div>
    <div class="form-group col-lg-12">
        <textarea class="form-control" placeholder="Message" name="message" cols="45" rows="3" aria-required="true"></textarea>
    </div>
    <div class="form-group col-lg-12">
        <button   class="btn btn-primary w-100 p-3" type="submit">Send Message</button>
    </div>
</div>
</form>
</div>
</div>
</div>
  <!--<div class="container-fluid p-0 w-100">-->
  <!--    <div class="row j-c-center j-c-center col-lg-12 col-xl-10 col-sm-12 p-0 m-auto">-->
  <!--      <?php echo $settings->map; ?>-->
  <!--    </div>-->
  <!--</div>-->
