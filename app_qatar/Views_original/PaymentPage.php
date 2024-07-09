
<style>
  #telr {
    width: 100%;
    min-width: 600px;
    height: 600px;
    frameborder: 0;
  }

  .payment-frame{
    min-height: 600px;
    height:auto;
    border: none!important
  }
</style>

<div class="container-fluid">
  <div class="container col-sm-12 col-md-12 col-lg-10 d-flex-row j-c-center">
    <?php if(isset($url)):?>
    <iframe class="col-12 payment-frame my-5 p-0" id= " telr " src= "<?php  echo $url;?>" sandbox="allow-forms allow-modals allow-popups-to-escape-sandbox allow-popups allow-scripts allow-top-navigation allow-same-origin"></iframe>
    <?php 
    else:
    ?>
    <div class="col-sm-12 col-md-12 col-lg-10 my-5 ">
      <p class="col-12" style="text-align:center; font-size: 26px">
        Please proceed to <a style="text-decoration:underline" href="<?php echo base_url() ?>/checkout">checkout</a> first.
      </p>
      <p style="font-size:28px; text-align:center; font-weight:bold" class="col-12">Thank you!</p>
    </div>
    <?php
    endif;
    ?>

  </div>
</div>