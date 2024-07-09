<?php   
$session = session();
$userModel = model('App\Models\UserModel', false);
$orderModel = model('App\Models\OrderModel');

$sql="select * from settings";
$settingss=$userModel->customQuery($sql);
$settings=$settingss[0];

 $dc_value=0;
?>
 <table cellspacing="0" cellpadding="0" border-collapse="collapse" style="padding: 0px 10px;
background: #fcf1ff;
max-width:750px;
font-family: arial;">
    <table class="logo" style="width: 100%;background: linear-gradient(45deg,rgb(17, 17, 17) 50%,rgb(31, 31, 31) 50%);">
        <thead>
            <tr>
                <th style="width: 100%;text-align: center; padding: 10px;">
                    <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo $settings->logo; ?>" style="margin: auto;" height="100px" alt="">
                </th>
            </tr>
        </thead>
    </table>
    <table style="margin:auto;width: 100%;padding: 10px;">
        <tbody>
            <tr>
                <td style="padding: 10px;font-size: 30px;">Your order <b>#<?php echo $orders->order_id;?></b></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;text-align: left; padding: 10px 20px;background-color: rgb(255, 255, 255);">
                    <p>
                        <h3 style="  color: rgb(175, 58, 3);"><?php echo $orders->name;?>,</h3>
                        Thank you for your order from ZamZamgames. Once your package ships we will send you a tracking number. You can check the status of your order by logging into <a href="">your account</a>. <br>
                        If you have questions about your order, you can email us at <?php echo  ($settings->email); ?> or call us at <?php echo  ($settings->phone); ?>.
                    </p>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <table style="width: 100%; margin: auto;background: rgb(255, 255, 255);">
                <thead>
                    <tr>
                        <td style="width:50%;text-align:center;padding: 15px;background: rgb(15, 15, 15);color: white;">Summary</td>
                        <td style="width:50%;text-align:center;padding: 15px;background: rgb(15, 15, 15);color: white;">Shipping Address</td>
                    </tr>
                </thead>
                <tbody>
                    <tr >
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order ID:</h4> <?php echo $orders->order_id;?></td>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Street:</h4> <?php echo $orders->street;?></td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order date:</h4> <?php echo date("d F Y h:i:s A", strtotime( $orders->created_at) );?></td>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Appartement:</h4> <?php echo $orders->apartment_house;?></td>
                    </tr>
                    <tr>                                
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Full name:</h4> <?php echo $orders->name;?></td>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Address:</h4> <?php echo $orders->address;?> , 
                        
                         <?php
                $cityid=$orders->city;
                $sql="select * from city where city_id='$cityid'";
    $city=$userModel->customQuery($sql);
                echo @$city[0]->title;?>
                        
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Payment method:</h4> <?php echo $orders->payment_method;?></td>
                       <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Phone:</h4> <?php echo $orders->phone;?></td>
                    </tr>
                    
                    
                  
                    
                    
                    
                    <tr>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order Amount:</h4> <?php echo $orders->total;?> AED</td>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Email:</h4> <?php echo $orders->email;?></td>
                    </tr> 
                    
                    <?php 
                    if($orders->wallet_use=="Yes"){
                    ?>
                    
                       <tr>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Wallet Used:</h4> <?php echo $orders->wallet_used_amount;?> AED</td>
                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Total :</h4> <?php echo $orders->total-$orders->wallet_used_amount;?></td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
              <?php
                if ($order_products) {  
                    ?>
            <table style="width: 100%;background-color: rgb(255, 255, 255);margin: 25px auto;text-align: center;">
                <thead>
                    <tr>
                        <th colspan="4" style="color:white;padding: 15px;background-color: rgb(46, 46, 46);">Items Ordered</th>
                    </tr>
                    <tr>
                        <td style="text-align: center;padding:10px;"></td>
                        <td style="text-align: center;padding:10px;">Name</td>
                        <td style="text-align: center;padding:10px;">Qty</td>
                        <td style="text-align: center;padding:10px;">Price</td>
                    </tr>
                </thead>
                <tbody>
                    
                     <?php

                  foreach (@$order_products as $key => $value) { 

                    
                      
                    $ptotal=0;
                    $temp=0;
                    $pid=$value->product_id;
                    $ptotal+=($value->product_price+$value->gift_wrapping_price+$value->app) * $value->quantity ;
                    $tpro=($value->product_price + $value->app+$value->gift_wrapping_price)*$value->quantity;
                                  
                    if($value->coupon_code){
                            // Coupon related conditions
                        $coupon_id=$orderModel->get_coupon_id($v->coupon_code);
                        $coupon_entity = $orderModel->get_promo_coupon_code($coupon_id);
                        $coupon_has_brand = $coupon_entity[0]->on_brand > 0 && $coupon_entity[0]->on_brand !== null;
                        $coupon_has_category = $coupon_entity[0]->on_brand !== null;
                        
                        $_brand_condition= $value->brand == $coupon_entity[0]->on_brand;

                        $_category_condition= false;
                        foreach(explode(",",$coupon_entity[0]->on_category) as $v){
                            if(in_array($v,explode(",",$value->category))){
                                $_category_condition=true;
                            }
                        }

                        
                        if($value->coupon_type=="Percentage"){

                            switch ($coupon_has_brand && $coupon_has_category) {
                                case 'true':
                                  # code...
                                      if($_brand_condition && $_category_condition){
                                        $dtotal=$dtotal+($tpro- ($tpro*$value->coupon_value)/100);
                                        $dc_value=$dc_value+ (($tpro*$value->coupon_value)/100);
                                        $stotal=$stotal+(($tpro- ($tpro*$value->coupon_value)/100));
                                      }
                                      else{
                                        $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                      }
                                  break;
                                
                                default:
                                  # code...
                                    //   if($_brand_condition || $_category_condition){
                                    //     $dtotal=$dtotal+($tpro- ($tpro*$value->coupon_value)/100);
                                    //     $dc_value=$dc_value+ (($tpro*$value->coupon_value)/100);
                                    //     $stotal=$stotal+(($tpro- ($tpro*$value->coupon_value)/100));
                                    //   }
                                    //   else{
                                    //     $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                    //   }

                                      if($coupon_has_brand){
                                          if($_brand_condition){
                                            $dtotal=$dtotal+($tpro- ($tpro*$value->coupon_value)/100);
                                            $dc_value=$dc_value+ (($tpro*$value->coupon_value)/100);
                                            $stotal=$stotal+(($tpro- ($tpro*$value->coupon_value)/100));
                                          }
                                          else{
                                            $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                          }
                                      }
                                      
                                      else if($coupon_has_category){
                                          if($_category_condition){
                                            $dtotal=$dtotal+($tpro- ($tpro*$value->coupon_value)/100);
                                            $dc_value=$dc_value+ (($tpro*$value->coupon_value)/100);
                                            $stotal=$stotal+(($tpro- ($tpro*$value->coupon_value)/100));
                                          }
                                          else{
                                            $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                          }
                                      }

                                      else{
                                        $dtotal=$dtotal+($tpro- ($tpro*$value->coupon_value)/100);
                                        $dc_value=$dc_value+ (($tpro*$value->coupon_value)/100);
                                        $stotal=$stotal+(($tpro- ($tpro*$value->coupon_value)/100));
                                      }

                                  break;
                              }

                        }

                        else{
                            switch ($coupon_has_brand && $coupon_has_category) {
                                case 'true':
                                  # code...
                                      if($_brand_condition && $_category_condition){
                                        $dtotal=$dtotal+($tpro-$value->coupon_value); 
                                        $dc_value=$dc_value+$value->coupon_value;
                                        $stotal=$stotal+(($tpro-$value->coupon_value));         
                                      }
                                      else{
                                        $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                      }
                                  break;
                                
                                default:
                                  # code...
                                    //   if($_brand_condition || $_category_condition){
                                    //     $dtotal=$dtotal+($tpro-$value->coupon_value); 
                                    //     $dc_value=$dc_value+$value->coupon_value;
                                    //     $stotal=$stotal+(($tpro-$value->coupon_value));
                                    //   }
                                    //   else{
                                    //     $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                    //   }


                                      if($coupon_has_brand){
                                        if($_brand_condition){
                                          $dtotal=$dtotal+($tpro-$value->coupon_value); 
                                            $dc_value=$dc_value+$value->coupon_value;
                                            $stotal=$stotal+(($tpro-$value->coupon_value));
                                        }
                                        else{
                                          $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                        }
                                    }
                                    
                                    else if($coupon_has_category){
                                        if($_category_condition){
                                          $dtotal=$dtotal+($tpro-$value->coupon_value); 
                                            $dc_value=$dc_value+$value->coupon_value;
                                            $stotal=$stotal+(($tpro-$value->coupon_value));
                                        }
                                        else{
                                          $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                                        }
                                    }

                                    else{
                                        $dtotal=$dtotal+($tpro-$value->coupon_value); 
                                        $dc_value=$dc_value+$value->coupon_value;
                                        $stotal=$stotal+(($tpro-$value->coupon_value));
                                    }

                                  break;
                              }
                        }
                    }
                    else{
                           $stotal=$stotal+($value->product_price+$value->app+$value->gift_wrapping_price)*$value->quantity;
                    }
                   
                
                      
                    ?>
                    
                    <tr>
                        <td style="width: 25%;padding: 5px 20px 0px;"><img src="<?php echo base_url();?>/assets/uploads/<?php echo $value->product_image; ?>" style="max-height: 70px;margin: auto;" alt=""></td>
                        <td style="width: 25%;padding: 5px 20px 0px;">
                        
                        <?php echo  ($value->product_name);?>  
                        <?php if($value->app>0){
                        ?>
                         <br>( assemble professionally - <?php echo  $value->app;?> AED))
                        <?php } ?>
                       
                       
                        <?php if($value->gift_wrapping_price>0){
                        ?>
                         <br>( Gift Wrapping - <?php echo  $value->gift_wrapping_price;?> AED)
                        <?php } ?>
                        
                        
                        </td>
                        <td style="width: 25%;padding: 5px 20px 0px;"><?php echo $value->quantity; ?></td>
                        <td style="width: 25%;padding: 5px 20px 0px;"><?php echo   bcdiv($value->product_price, 1, 2);?> AED</td>
                    </tr>
                    <tr><td style="padding: 5px 15px;" colspan="4"><hr style="margin: 0px;border-color: rgba(41, 41, 41, 0.116);"></td></tr>
                 
                 
                 <?php
                  }
                
                ?>
                 
                   
                    <!-- Total & Subtotal -->
                    <tr><td style="padding: 5px 15px;" colspan="4"><hr style="margin: 0px;border-color: rgba(41, 41, 41, 0.116);"></td></tr>
                    <tr>
                        <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">Subtotal:</td>
                        <td style="width: 25%;padding: 5px;"><?php echo bcdiv($stotal, 1, 2);?> AED</td>
                    </tr>
                    
                    
                      <?php 
   $chrg=0;
   if($order_charges){
   foreach($order_charges as $k2=>$v2){ 
    ?>
     <tr>
                        <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
        <?php echo  ($v2->title );?> :</td>
       <td style="width: 25%;padding: 5px;">
          <?php 
          if($v2->type =="Percentage"){
            echo bcdiv(($stotal*$v2->value)/100, 1, 2); 
            $chrg=$chrg+($stotal*$v2->value)/100;
          } else {
            echo bcdiv($v2->value, 1, 2); 
            $chrg=$chrg+($v2->value);
          }?>
        AED 
         </td>
      </tr>
    <?php } } ?>
                <?php if(@$dc_value){?>
                
                
                
                
                
                 <tr>
                        <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
       Coupon Discount: :</td>
       <td style="width: 25%;padding: 5px;">
         <?php echo bcdiv(@$dc_value, 1, 2);?> AED
         </td>
      </tr>
                
                
                
                
                
                
                
                
                
                
                 
                    
                     <?php } ?>
                     
                
                
                   <tr>
                        <td style="font-weight: bold;text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                            <h4 style="margin: 5px 0;font-size: 20px;">Total:</h4>
                        </td>
                        <td style="color:rgb(255, 255, 255);width: 25%;padding: 5px;font-weight: bold;background-color: rgb(0, 0, 0);">
                            
                             <?php 
                  
                    echo bcdiv($stotal+$chrg, 1, 2);
                  
                    ?> AED</td>
                    </tr>
                
                
                
                  <?php 
                    if($orders->wallet_use=="Yes"){
                    ?>
                    
                     <tr>
                        <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">Wallet Used:</td>
                        <td style="width: 25%;padding: 5px;"><?php echo $orders->wallet_used_amount;?>  AED</td>
                    </tr>
                    
                
                <?php } ?>
                
                
                    <?php if($orders->wallet_use=="Yes"):?>
                    <tr>
                        <td style="font-weight: bold;text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                            <h4 style="margin: 5px 0;font-size: 20px;">Payable Amount:</h4>
                        </td>
                        <td style="color:rgb(255, 255, 255);width: 25%;padding: 5px;font-weight: bold;background-color: rgb(0, 0, 0);">
                             <?php  echo bcdiv($stotal+$chrg, 1, 2) - $orders->wallet_used_amount; ?> AED
                        </td>
                    </tr>
                    <?php endif;?>
                    
                    
                    
                    
                    <tr>
                        <td style="padding: 15px; background: linear-gradient(60deg,lightslategray 50%,rgb(124, 143, 161) 50%);font-size: 30px;font-weight: bold;color: rgb(255, 255, 255);" colspan="4">Thank you!</td>
                    </tr>
                </tbody>
            </table>
            <table style="text-align:center;color:rgb(219, 219, 219);width:100%;margin:auto;background: linear-gradient(45deg,rgb(17, 17, 17) 50%,rgb(31, 31, 31) 50%);font-size: 15px;">
                <tbody>
                    <tr>
                        <td style="padding: 10px;width: auto;" rowspan="5"><img src="<?php echo base_url(); ?>/assets/uploads/<?php echo $settings->logo; ?>" style="margin: auto;" height="70px" alt=""></td>
                        <!-- <td style="padding: 5px 10px" colspan="4">Information</td> -->
                    </tr>
                        <!-- <tr>
                            <td  colspan="4" style="text-align:left;padding: 5px 10px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus optio autem nisi minus iusto quos fugiat ad laudantium quasi ipsa aut dolor molestias velit reiciendis provident, assumenda corrupti. Aut, consequatur.</td>
                        </tr> -->
                        <tr>
                            <td style="padding:5px;width: 25%;text-align: right;">Address:</td>
                            <td style="padding:5px;width: 25%;text-align: left;"><?php echo  ($settings->address); ?></td>
                        </tr>
                        <tr>
                            <td style="padding:5px;width: 25%;text-align: right;">Phone:</td>
                            <td style="padding:5px;width: 25%;text-align: left;"><?php echo  ($settings->phone); ?></td>
                        </tr>
                        <tr>
                            <td style="padding:5px;width: 25%;text-align: right;">Support:</td>
                            <td style="padding:5px;width: 25%;text-align: left;"><?php echo  ($settings->email); ?></td>
                        </tr>
                    </tbody>
                </table>
               
               <?php } ?>
               
                <table style="width:30%;margin:5px auto;text-align: center;">
                    <tbody>
                        <tr>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->facebook); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/fbb.png" alt=""></a></td>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->instagram); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/inta.png" alt=""> </a></td>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->twitter); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/tw.png" alt=""> </a></td> 
                        </tr>
                    </tbody>
                </table>
            </tbody>
        </table>
    </table>
    