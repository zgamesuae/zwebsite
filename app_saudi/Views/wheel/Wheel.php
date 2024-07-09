
<?php if(isset($spin_wheel) && $spin_wheel == true): ?>
<div class="prize-title col-12 row p-0 j-c-center m-0 py-3" style="background: #22398d; height: auto">
    <h3 class="col-9 text-center" style="color:rgb(245, 245, 245); font-size: 20px">GIVE IT A CHANCE!</h3>
</div>
<div class="col-12">
    <div class="container wheel-container">
        <div class="row col-12 j-c-center m-0">
            <!--<div class="copy col-12">-->
            <!--  <h1 class="py-2">Spin to Win!</h1>-->
            <!--</div>-->
    
            <div class="wrapper col-12 row p-0 j-c-center">
              <div class="pointer-wrapper">
                <img src="<?php echo base_url() ?>/assets/others/wheel-pointer-v2.png" alt="pointer" > 
              </div>
              <img src="<?php echo base_url() ?>/assets/others/wheel2.png" alt="spping wheel" class="wheel" style="max-width: 100%">
            </div>
    
            <div class="button col-12">
              <button class="btn" data-order="<?php echo $orderid ?>">Spin</button>
            </div>
        </div>
    </div>
</div>

 
 <?php endif; ?>