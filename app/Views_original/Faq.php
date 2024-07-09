<?php include 'Common/Breadcrumb.php';?>


<section id="faq">

      <div class="container aos-init aos-animate" data-aos="fade-up">

       

        <div class="row justify-content-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-12">
            <ul id="faq-list">
                       
                       <?php if($faq){
                       foreach($faq as $k=>$v){
                           
                       ?>
                       
                          <li>
                <a data-toggle="collapse" class="collapsed" href="#faq<?php echo $k+1;?>"><?php echo $v->question;?> <i class="fa fa-minus-circle"></i></a>
                <div id="faq<?php echo $k+1;?>" class="collapse" data-parent="#faq-list">
                  <p>
                   <?php echo $v->answer;?>                 </p>
                </div>
              </li>
              <?php }} ?>
               
                        </ul>
          </div>
        </div>

      </div>

    </section>