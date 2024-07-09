<?php   
$session = session();
$userModel = model('App\Models\UserModel', false);
$orderModel = model('App\Models\OrderModel');

$sql="select * from settings";
$settingss=$userModel->customQuery($sql);
$settings=$settingss[0];
// var_dump($orders["offers"][0]["prizes"]);
// echo date("Y-m-d H:i:s" , strtotime($orders["created_at"]));
// die();
 $dc_value=0;
?>
    <table cellspacing="0" cellpadding="0" border-collapse="collapse" style="padding: 0px 10px 10px;background: linear-gradient(70deg,#00215e 50%,#0239a0 50%);width:100%;max-width:750px;font-family: arial;margin:auto;">
        <!-- ZGAMES LOGO -->
        <tr>
            <td>
                <table class="logo" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 100%;text-align: center; padding: 10px;">
                                <img src="<?php echo base_url() ?>/assets/uploads/<?php echo $settings->logo; ?>" style="margin: auto;" height="100px" alt="">
                            </th>
                        </tr>
                    </thead>
                </table>
            </td>
        </tr>
        <!-- ZGAMES LOGO -->


        <tr>
            <td>
                <table style="margin:auto;width: 100%;padding: 10px;">
                    <tbody>

                        <tr>
                            <td style="padding: 10px;font-size: 30px; color:white">Your order <b>#<?php echo $orders["order"]["order_id"];?></b></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="width: 100%;text-align: justify; padding: 10px 20px;background-color: rgb(255, 255, 255);line-height: 1.3rem">
                                <h3 style="color: rgb(175, 58, 3);">Hi <?php echo $orders["name"];?>,</h3>
                                <p style="font-size: 13px">
                                    Thank you for your order from ZamZamgames. Once your package ships we will send you a tracking number. You can check the status of your order by logging into <a href="">your account</a>. <br>
                                    If you have questions about your order, you can email us at <?php echo  ($settings->email); ?> or call us at <?php echo  ($settings->phone); ?>.
                                </p>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <!-- SUMMARY && SHIPPING ADDRESS -->
                        <tr>
                            <td>
                                <table style="width: 100%; margin: auto;background: rgb(255, 255, 255);">
                                    <thead>
                                        <tr>
                                            <td style="width:50%;text-align:center;padding: 15px;background: rgb(15, 15, 15);color: white;">Summary</td>
                                            <td style="width:50%;text-align:center;padding: 15px;background: rgb(15, 15, 15);color: white;">Shipping Address</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order ID:</h4> <?php echo $orders["order"]["order_id"];?></td>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Street:</h4> <?php echo $orders["order"]["street"];?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order date:</h4> <?php echo date("Y-m-d H:i:s" , strtotime("now"));?></td>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Appartement:</h4> <?php echo $orders["order"]["apartment_house"];?></td>
                                        </tr>
                                        <tr>                                
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Full name:</h4> <?php echo $orders["order"]["name"];?></td>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Address:</h4> <?php echo $orders["order"]["address"];?> , <?php echo $orderModel->get_city_name($orders["order"]["city"])->title; ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Payment method:</h4> <?php echo $orders["order"]["payment_method"];?></td>
                                        <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Phone:</h4> <?php echo $orders["order"]["phone"];?></td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Order Amount:</h4> <?php echo $orders["order"]["total"];?> <?php echo CURRENCY ?></td>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Email:</h4> <?php echo $orders["order"]["email"];?></td>
                                        </tr> 

                                        <?php if($orders["wallet_use"]=="Yes" && false){ ?>
                                        <tr>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Wallet Used:</h4> <?php echo $orders["wallet_used_amount"];?> <?php echo CURRENCY ?></td>
                                            <td style="padding: 0px 30px 5px;"><h4 style="width: 100%;margin: 5px auto">Total :</h4> <?php echo $orders->total-$orders["wallet_used_amount"];?></td>
                                        </tr>
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <!-- SUMMARY && SHIPPING ADDRESS -->
                                        
                        <!-- Order Details -->
                        <tr>
                            <td>
                                <?php if ($order_products) { ?>
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
                                    <!-- ORDER PRODUCTS -->
                                        <?php
                                        foreach ($order_products as $key => $value) { 
                                            $value = (array)($value);
                                        ?>
                                        <tr style="font-size:.8rem">
                                            <td style="width: 25%;padding: 5px 20px 0px;">
                                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $value["product_image"]; ?>" style="max-height: 80px;max-width:80px;margin: auto;" alt="">
                                            </td>
                                            <td style="width: 35%;padding: 5px 20px 0px;">
                                                <?php echo  ($value["product_name"]);?>  
                                        
                                                <?php 
                                                if($value["assemble_professionally_price"]>0){
                                                ?>
                                                <br>( assemble professionally - <?php echo  $value["assemble_professionally_price"];?> <?php echo CURRENCY ?>)
                                                <?php } ?>
                                                
                                                <?php 
                                                if($value["gift_wrapping_price"]>0){
                                                ?>
                                                <br>( Gift Wrapping - <?php echo  $value["gift_wrapping_price"];?> <?php echo CURRENCY ?>)
                                                <?php 
                                                }
                                                ?>

                                            </td>
                                            <?php 
                                              $ft = (intval($value["free_quantity"]) > 0) ? "(+{$value['free_quantity']} free)" : "";
                                            ?>
                                            <td style="width: auto;padding: 5px 20px 0px;"><?php echo (intval($value["quantity"]) - intval($value["free_quantity"]) . $ft) ?></td>
                                            <td style="width: 25%;padding: 5px 20px 0px;">
                                                <?php 
                                                    echo $value["product_price"] * (($value["quantity"]) - ($value["free_quantity"]))." ".CURRENCY;
                                            
                                                    if($value["pre_order_enabled"] == 'Yes' && $value["pre_order_before_payment_percentage"] > 0)
                                                    echo " (".$value["pre_order_before_payment_percentage"]."% of original price)";
                                            
                                                ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 15px;" colspan="4"><hr style="margin: 0px;border-color: rgba(41, 41, 41, 0.116);"></td>
                                        </tr>
                                        <?php } ?>
                                    <!-- ORDER PRODUCTS -->
                                            
                                    <!-- ORDER OFFER PRIZES -->
                                        <?php
                                        if(false):
                                        ?>
                                        <tr>
                                            <th colspan="4" style="color:white;padding: 15px;background-color: rgb(1, 145, 78);">Prizes</th>
                                        </tr>
                                        
                                        <!-- Loop on The prize products -->
                                        <?php 
                                            foreach ($orders["offers"] as $key => $offer): 
                                                if(isset($offer["prizes"])):
                                        ?>
                                        <tr style="font-size:.8rem">
                                            <td style="width: 25%;padding: 5px 20px 0px;">
                                                <img src="<?php echo base_url();?>/assets/uploads/<?php echo $value->image; ?>" style="max-height: 80px;max-width:80px;margin: auto;" alt="">
                                            </td>
                                            <td style="width: 35%;padding: 5px 20px 0px;"> <?php echo  $value->name;?></td>
                                            <td style="width: auto;padding: 5px 20px 0px;">1</td>
                                            <td style="width: 25%;padding: 5px 20px 0px;"> <?php echo "0  ".CURRENCY; ?> </td>
                                        </tr>
                                        <tr>
                                            <td style="padding: 5px 15px;" colspan="4"><hr style="margin: 0px;border-color: rgba(41, 41, 41, 0.116);"></td>
                                        </tr>
                                        <?php 

                                                endif; 
                                            endforeach;
                                        endif;
                                        ?>
                                        <!-- Loop on The prize products -->
                                    
                                    <!-- ORDER PRODUCTS -->
                                    
                                    <!-- TOTAL ORDER -->
                               
                                        <tr>
                                            <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                Subtotal:
                                            </td>
                                            <td style="width: 25%;padding: 5px;">
                                                <?php echo $orders["order"]["sub_total"];?> <?php echo CURRENCY ?>
                                            </td>
                                        </tr>

                                        <?php 
                                        if($order_charges["total_charges"] > 0 && sizeof($order_charges["charges"]) > 0){
                                            foreach($order_charges["charges"] as $charge){ 
                                        ?>
                                        <tr>
                                            <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                <?php echo  $charge["title"];?> :
                                            </td>
                                            
                                            <td style="width: 25%;padding: 5px;">
                                            <?php  echo $charge["price"]; ?> <?php echo CURRENCY ?> 
                                            </td>
                                        </tr>
                                            
                                        <?php
                                            } 
                                        } 
                                        ?>
                                        <!-- Coupon Discount -->
                                        <?php if($orders["order"]["coupon_discount"] > 0){?>
                                        <tr>
                                            <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                Coupon Discount:
                                            </td>
                                            <td style="width: 25%;padding: 5px;background-color: rgb(1, 145, 78);color:white"> 
                                                <?php echo $orders["coupon_discount"]?> <?php echo CURRENCY ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <!-- Coupon Discount -->
                                        
                                        <!-- Order Offer Discount -->
                                        <?php 
                                        foreach($orders["offers"] as $offer):
                                        if((int)$offer["amount"] > 0){
                                        ?>
                                        <tr>
                                            <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                Offer discount: <br> <span style="font-size: .6rem; line-height: .65rem"><?php echo $offer["offer_title"] ?></span>
                                            </td>
                                            <td style="width: 25%;padding: 5px;background-color: rgb(1, 145, 78);color:white"> 
                                                <?php echo "-".$offer["amount"]?> <?php echo CURRENCY ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        } 
                                        endforeach;
                                        ?>
                                        <!-- Order Offer Discount -->
                                        
                                        <!-- Total invoice -->
                                        <tr>
                                            <td style="font-weight: bold;text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                <h4 style="margin: 5px 0;font-size: 20px;">Total:</h4>
                                            </td>
                                            <td style="color:rgb(255, 255, 255);width: 25%;padding: 5px;font-weight: bold;background-color: rgb(0, 0, 0);">
                                                <?php echo $orders["order"]["total"];?> <?php echo CURRENCY ?>
                                            </td>
                                        </tr>
                                        <!-- Total invoice -->
                                        
                                        
                                        <?php if($orders["wallet_use"]=="Yes" && false){ ?>
                                        <tr>
                                            <td style="text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">Wallet Used:</td>
                                            <td style="width: 25%;padding: 5px;"><?php echo $orders["wallet_used_amount"];?>  <?php echo CURRENCY ?></td>
                                        </tr>
                                        <?php } ?>
                                        
                                        
                                        <?php if($orders["wallet_use"]=="Yes" && false):?>
                                        <tr>
                                            <td style="font-weight: bold;text-align:right;width: 25%;padding: 5px 20px 0px;" colspan="3">
                                                <h4 style="margin: 5px 0;font-size: 20px;">Payable Amount:</h4>
                                            </td>
                                            <td style="color:rgb(255, 255, 255);width: 25%;padding: 5px;font-weight: bold;background-color: rgb(0, 0, 0);">
                                                <?php  echo $orders["total"] - $orders["wallet_used_amount"]; ?> <?php echo CURRENCY ?>
                                            </td>
                                        </tr>
                                        <?php endif;?>
                                    <!-- TOTAL ORDER -->
                                    </tbody>
                                </table>
                                <?php } ?>
                            </td>
                        </tr>
                        <!-- Order Details -->
                    </tbody>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td>
                <table style="text-align:center;color:rgb(219, 219, 219);width:100%;margin:auto;font-size: 15px;">
                    <tbody>
                        <tr>
                            <td style="padding: 10px;width: auto;text-align: center;" rowspan="4"><img src="<?php echo base_url() ?>/assets/uploads/<?php echo $settings->logo; ?>" style="margin: auto;" height="70px" alt=""></td>
                        </tr>
                        
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
            </td>
        </tr>
        <!-- Footer -->

        <!-- Social Media links -->
        <tr>
            <td>
                <table style="width:30%;margin:5px auto;text-align: center;">
                    <tbody>
                        <tr>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->facebook); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/fbb.png" alt=""></a></td>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->instagram); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/inta.png" alt=""> </a></td>
                            <td style="padding: 10px;"><a href="<?php echo  ($settings->twitter); ?>"><img height="30px" width="auto" src="<?php echo base_url();?>/assets/uploads/tw.png" alt=""> </a></td> 
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <!-- Social Media links -->

        <!-- Thank you -->
        <tr>
            <td style="text-align:center;padding: 15px;font-size: 30px;font-weight: bold;color: rgb(255, 255, 255);" colspan="4">Thank you!</td>
        </tr>
        <!-- Thank you -->
    </table>
    <!-- background: linear-gradient(45deg,rgb(17, 17, 17) 50%,rgb(31, 31, 31) 50%); -->
    