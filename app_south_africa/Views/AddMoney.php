<div class="main-wrapper scrollspy-container">
  <div class="mt-40">
    <br><br><br>
    <div class="container mt-50 mb-50">
      <div class="row justify-content-center" style="    border: dotted #e8e8e8;
      padding: 60px 0px;">
      <div class="col-md-6 text-center">
       <img src="<?php echo base_url();?>/assets/uploads/291-2918799_stripe-payment-icon-png-transparent-png.png" width="300">
       <div class="stripecontainer"> 
         <form action="<?php echo base_url();?>/page/paymentSuccessWallet/<?php echo base64_encode($order_id);?>" method="POST">  
          <script
          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo PUBLICKEY;?>"
          data-amount="<?php echo @$total*100;?>"
          data-currency=<?php echo CURRENCY ?>
          data-name="<?php echo @$name;?>"
          data-email="<?php echo @$email;?>"
          data-allow-remember-me="false"
          data-description="Token ID: <?php echo $order_id;?>"
          data-image="<?php echo base_url(); ?>/assets/uploads/<?php echo @$settings->logo; ?>"
          data-locale="auto">
        </script>
      </form> 
    </div> 
  </div>
</div>
</div>
</div>
</div>
</div>
<br>
<br><br><br>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  
           <script>
              $(document).ready(function(){
                $(".stripe-button-el").click();
              });
            </script> 