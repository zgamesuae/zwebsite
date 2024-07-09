

<?php 

  $session = session();
  $userModel = model('App\Models\UserModel', false);
  $orderModel =model("App\Models\OrderModel");

  $uri = service('uri'); 
  @$user_id=$session->get('userLoggedin'); 
  $sql="select * from settings";
  $settings=$userModel->customQuery($sql);
  $sql1="";
  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>0){
    $sql1="select * from seo  ";
    $uri1=@$uri->getSegment(1); 
    $sql1.= " where  segment_1= '$uri1'";
  } 

  if(count(@$uri->getSegments())>1){
    $uri2=@$uri->getSegment(2); 
    $sql1.= " where  segment_2= '$uri2'";
  } 

  if(count(@$uri->getSegments())>2){
   $uri3=@$uri->getSegment(3);  
   $sql1.= " where  segment_3= '$uri3'";
  } 

  if($sql1){
   $seo=$userModel->customQuery($sql1);  
  }

  $uri1=$uri2=$uri3="";
  if(count(@$uri->getSegments())>0){
    $sql1="select * from seo  ";
    $uri1=@$uri->getSegment(1);  
  } 

  if(count(@$uri->getSegments())>1){
    $uri2=@$uri->getSegment(2); 
  } 

  if($uri2){
    $sql="select * from orders where     order_id='$uri2'";
    $orders=$userModel->customQuery($sql);
  }

  $sql="select * from cms";
  $cms=$userModel->customQuery($sql);
  /*$sql="select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products 
  inner join products on order_products.product_id=products.product_id
  where order_products.order_id='$uri2'";*/
  $sql="select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app,products.brand,products.category from order_products inner join products on order_products.product_id=products.product_id where order_products.order_id='$uri2'";


  $cart=$userModel->customQuery($sql);
  $sql="select * from order_charges where order_id='$uri2'";
  $charges=$userModel->customQuery($sql);

?> 
<html>
    <head>
        <title><?php  if(@$seo[0]){ echo @$seo[0]->page_title;}else{ echo 'Invoice | '.ucwords($settings[0]->business_name);}?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url();?>/assets/uploads/<?php echo @$settings[0]->favicon;?>" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
    </head>
    <body>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,200;1,300;1,400&display=swap');

    *{
      font-family: 'Poppins', sans-serif;
    }
    .prod tr td:nth-child(odd){
        background: rgb(239 239 239);
    }
    .prod tr td , .prod tr th{
        border: solid rgba(0, 0, 0, 0.247) 1px
    }
    .prod tr th{
        background: rgb(230, 230, 230);
        /* color: white */
    }
    
    .co_info tr td:nth-child(3) , .co_info tr th:nth-child(2){
        border-left: solid rgba(0, 0, 0, 0.192) 1px;
    }

    .co_info{
        border-spacing: 0px;
    }

    .prod{
        border-spacing: 0px;
    }

    @media print{
      .printable_section{
        width: 100%!important;
      }

      .printable_section:last-child{
        position: absolute;
        bottom: 0px;
      }

      .invoice_content{
        height: 100vh;
      }
    
      .logo_n_printable{
        display: none;
      }

      .logo_printable{
        display: block!important;
      }
      
      .print_button{
         display: none;
      }
      
    }
</style>

<div class="invoice_content" style="width: 100%; min-width: 1280px">

    <!-- HEADING -->
    <div class="printable_section" style="margin: 55px auto; width: 65%; background-color: rgb(255, 255, 255);">
        <table style="height: auto;  width: 100%; background-color: #243d97; color: white; " >
            <tbody>
                <tr style="">
                    <td style="width: 20%; text-align: center; padding: 25px">
                        <img class="logo_n_printable" src="<?php echo base_url();?>/assets/uploads/ZGames_550px_W.png" alt="" style="max-height: 120px">
                        <img class="logo_printable" src="<?php echo base_url();?>/assets/uploads/ZGames-logo-02.png" alt="" style="max-height: 120px; display:none">
                    </td>
                    <td style="padding: 25px; width: 45%; text-align: left;">
                        <div>
                            <h1 style="">INVOICE</h1>
                        </div>
                    </td>
                    <td style="width: 30%; background-color: #243d97; padding: 25px; text-align: left; font-size: 1.4em;">
                        <p style="width: auto;">
                            <p style="margin: 4px 5px;"><?php echo $settings[0]->business_name;?></p>
                            <p style="margin: 4px 5px;"><?php echo $settings[0]->address;?></p>
                            <p style="margin: 4px 5px;"><?php echo $settings[0]->phone;?></p>
                            <p style="margin: 4px 5px;"><?php echo $settings[0]->email;?></p>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- HEADING -->

    <!-- Invoice to & order information -->
    <div class="printable_section" style="margin: 55px auto; width: 65%; background-color: rgb(245, 245, 245); padding: 15px 5px">

        <table style="width:100%; padding: 20px 0px" class="co_info">

            <thead>
                <th colspan="2" style="text-align: left; padding: 10px 15px">
                     <h2>Customer information</h2>
                </th>
                <th colspan="2" style="text-align: left; padding: 10px 15px">
                    <h2>Order information</h2>
                </th>
            </thead>

            <tbody>
                <tr>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Full name:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo $orders[0]->name;?></span>
                    </td>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Invoice date:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo date("d M Y");?></span>
                    </td>
                </tr>
                
                <tr>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Address:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span>
                            <?php echo $orders[0]->street;?>, <?php echo $orders[0]->apartment_house;?>, <?php echo $orders[0]->address;?>, <?php
                            $cityid=$orders[0]->city;
                            $sql="select * from city where city_id='$cityid'";
                            $city=$userModel->customQuery($sql);
                            echo @$city[0]->title;?>
                        </span>
                    </td>
                    <td style="padding-left:25px; width: 12%; text-align:left">
                        <span>Issue date:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo date("d M Y", strtotime($orders[0]->created_at));?></span></span>
                    </td>
                </tr>

                <tr>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Phone number:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo $orders[0]->phone;?></span>
                    </td>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Order ID:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo $orders[0]->order_id;?></span>
                    </td>
                </tr>
                
                <tr>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>E-mail:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo $orders[0]->email;?></span>
                    </td>
                    <td style="padding-left: 25px; width: 12%; text-align:left">
                        <span>Order status:</span>
                    </td>
                    <td style="padding: 1px 25px; width: 25%; text-align:left">
                        <span><?php echo $orders[0]->order_status;?></span>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <!-- Invoice to & order information -->


    <!-- Products table -->
    <div class="printable_section" style="margin: 55px auto; width: 65%; background-color: rgb(243, 243, 243);">

        <!-- Products -->
        <table class="prod" style="width: 100%">
            
            <thead>
                <tr>
                    <th style="padding: 18px"> Description </th>
                    <th style="padding: 18px"> SKU </th>
                    <th style="padding: 18px"> Price </th>
                    <th style="padding: 18px"> Quantity </th>
                    <th style="padding: 18px"> Price excl VAT </th>
                    <th style="padding: 18px"> VAT </th>
                    <th style="padding: 18px"> Total </th>
                </tr>
            </thead>

            <tbody style="text-align:center; ">
                <?php   
                $total=0;
                $stotal=0;
                $tot=0;
                $ttobe_discounted=0;
                $dc_value=0;

                if($cart){
                  foreach($cart as $k=>$v){ 
                    $ptotal=0;$temp=0;
                    $pid=$v->product_id;
                    $sql="select * from products where product_id='$pid'";
                    $productDetails=$userModel->customQuery($sql);
                    $coupon_id=$orderModel->get_coupon_id($v->coupon_code);
                          
                ?>
                <tr>
                    <td style="padding: 8px 2px; width: 30%">

                    <?php 
                    echo  ($v->product_name);
                    if($v->app>0){
                    ?>
                    <br>( assemble professionally - <?php echo  $v->app;?> AED))
                    <?php 
                    } 
                    if($v->gift_wrapping_price>0)
                    {
                    ?>
                    <br>( Gift Wrapping - <?php echo  $v->gift_wrapping_price;?> AED)
                    <?php 
                    } 
                    ?>
                    
                    </td>
                    <td style="padding: 8px 2px">

                    <?php 
                    if(@$productDetails[0]->sku)
                    {
                    echo @$productDetails[0]->sku ;
                    }
                    else
                    {
                    echo  @$v->sku;
                    }
                    ?>

                    </td>
                    <td style="padding: 8px 2px"><?php echo bcdiv($v->product_price, 1, 2);?> AED </td>
                    <td style="padding: 8px 2px"><?php   echo $v->quantity ; ?> </td>
                    <td style="padding: 8px 2px">
                        <?php 
                        $tprice=$v->product_price+$v->gift_wrapping_price+$v->app;
                        $pq_price = round(($tprice / 1.05) * $v->quantity,2);
                        echo $pq_price ;
                        ?> AED
                    </td>
                    <td style="padding: 8px 2px">
                        <?php
                        $vat= ($tprice - ($tprice/1.05))* $v->quantity;
                        echo round($vat,2) ;
                        ?> AED
                    </td>
                    <td style="padding: 8px 2px">
                    
                        <?php     

                        $ptotal+=($v->product_price+$v->gift_wrapping_price+$v->app) * $v->quantity ;
                        echo bcdiv($ptotal, 1, 2);
                        // $stotal+=($v->product_price+$v->gift_wrapping_price+$v->app) * $v->quantity ;
                        $tpro=($v->product_price + $v->app+$v->gift_wrapping_price)*$v->quantity;
                        // if($v->coupon_code){
                        if($v->coupon_code ){
                            $coupon_entity = $orderModel->get_promo_coupon_code($coupon_id);
                            $coupon_has_brand = $coupon_entity[0]->on_brand > 0 && $coupon_entity[0]->on_brand !== null;
                            $coupon_has_category = $coupon_entity[0]->on_brand !== null;
                            $_brand_condition= $v->brand == $coupon_entity[0]->on_brand;
                            // $_category_condition= $v->brand == $coupon_entity[0]->on_category;
                            $_category_condition= false;
                            foreach(explode(",",$coupon_entity[0]->on_category) as $value){
                              if(in_array($value,explode(",",$v->category))){
                                $_category_condition=true;
                              }
                            }
                            if($v->coupon_type=="Percentage"){
                                $stotal=$stotal+$tpro;
                                switch ($coupon_has_brand && $coupon_has_category) {
                                  case 'true':
                                    # code...
                                        if($_brand_condition && $_category_condition){
                                            $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                                        }
                                    break;
                                    
                                  default:
                                    # code...
                                        if($coupon_has_brand){
                                          if($_brand_condition){
                                            $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                                          }
                                      
                                        }
                                        else if($coupon_has_category){
                                          if($_category_condition){
                                            $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                                          }
                                      
                                        }
                                        else{
                                          $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                                        }
                                    break;
                                }
                            
                            }
                        
                            else{
                                $dc_value=$v->coupon_value;
                                switch ($coupon_has_brand && $coupon_has_category) {
                                  case 'true':
                                    # code...
                                        if($_brand_condition && $_category_condition){
                                          $ttobe_discounted += $tpro;
                                        }
                                        else{
                                          $stotal=$stotal+$tpro;
                                        }
                                    break;
                                    
                                  default:
                                    # code...
                                        if($coupon_has_brand){
                                          if($_brand_condition){
                                            $ttobe_discounted += $tpro;
                                          }
                                          else{
                                            $stotal=$stotal+$tpro;
                                          }
                                        }
                                        else if($coupon_has_category){
                                          if($_category_condition){
                                            $ttobe_discounted += $tpro;
                                          }
                                          else{
                                            $stotal=$stotal+$tpro;
                                          }
                                        }
                                        else{
                                          $ttobe_discounted += $tpro;
                                        }
                                    break;
                                }
                            }
                        
                        }

                        else{
                        $stotal=$stotal+($v->product_price+$v->app+$v->gift_wrapping_price)*$v->quantity;
                        }

                        ?> AED
                    
                    </td>
                </tr>
                <?php
                        $total_excl_vat += $pq_price;
                        $totalvat += $vat;
                    }

                if(isset($coupon_entity)){
                  if($coupon_entity[0]->type == "Amount")
                  $stotal += $ttobe_discounted - $dc_value;
                  else
                  $stotal = $stotal - $dc_value;
                }
                }

                ?>
                
            </tbody>

        </table>
        <!-- Products -->

        <!-- TOTAL SUMMARY -->
        <table style="margin:10px 0; width: 100%; ">
            <tbody>
                <tr>
                    <!-- PAYMENT METHOD -->
                    <td>
                        <table>
                            <tbody>
                                <tr>
                                    <td style="text-align: left; padding: 8px 10px" Ccolspan="2">
                                        <h2>Payment details</h2>
                                    </td>
                                </tr>
                
                                <tr>
                                    <td style="text-align: left; padding: 2px 25px">Payment method:</td>
                                    <td style="text-align: left; padding: 2px 25px"><?php echo $orders[0]->payment_method;?></td>
                                </tr>
                
                                <tr>
                                    <td style="text-align: left; padding: 2px 25px">Payment status:</td>
                                    <td style="text-align: left; padding: 2px 25px"><?php echo $orders[0]->payment_status;?></td>
                                </tr>
                
                               
                            </tbody>
                        </table>
                    </td>
                    <!-- PAYMENT METHOD -->

                    <!-- TOTAL -->
                    <td>
                        <table style="margin:15px 0; padding: 10px 0; width: 100%; background-color: rgb(27, 27, 27); color: white; ">
                            <tbody>
                                <tr>
                                    <td style="text-align: right; padding: 2px 10px">Subtotal (excl VAT):</td>
                                    <td style="text-align: left; padding: 2px 25px"><?php echo bcdiv($total_excl_vat, 1, 2);?> AED</td>
                                </tr>
                            
                                <tr>
                                    <td style="text-align: right; padding: 2px 10px">Total VAT:</td>
                                    <td style="text-align: left; padding: 2px 25px"><?php echo round($totalvat , 2) ?> AED</td>
                                </tr>

                                <?php 
                                if($charges): 
                                    foreach($charges as $k2=>$v2):
                                ?>
                                <tr>
                                    <td style="text-align: right; padding: 2px 10px"><?php echo  ($v2->title );  if($v2->type =="Percentage"){ echo '('.$v2->value.'%)'; }?> : </td>
                                    <td style="text-align: left; padding: 2px 25px">
                                    <?php 
                                    if($v2->type =="Percentage")
                                    {
                                      echo bcdiv(($stotal*$v2->value)/100, 1, 2); 
                                      $chrg=$chrg+($stotal*$v2->value)/100;
                                    } 
                                    else 
                                    {
                                      echo bcdiv($v2->value, 1, 2);
                                      $chrg=$chrg+($v2->value);
                                    }
                                    ?>
                                    AED 
                                    </td>
                                </tr>
                                <?php
                                    endforeach;
                                endif; 
                                ?>


                                <?php if($dc_value): ?>
                                <tr>
                                    <td style="text-align: right; padding: 2px 10px">Discount:</td>
                                    <td style="text-align: left; padding: 2px 25px"><?php echo bcdiv($dc_value, 1, 2);?> AED</td>
                                </tr>
                                <?php endif; ?>

                            
                                <tr>
                                    <td style="text-align: right; padding: 8px 10px"><span style="font-weight: bold; font-size: 1.5rem">Total:</span></td>
                                    <td style="text-align: left; padding: 8px 25px"><span style="font-weight: bold; font-size: 1.5rem"><?php echo bcdiv($stotal+$chrg, 1, 2);?> AED</span></td>
                                </tr>

                                <?php if(@$orders[0]->wallet_use=="Yes"): ?>
                                <tr>
                                    <td style="text-align: right; padding: 8px 10px"><span style="font-weight: bold; font-size: 1.5rem">Payable amount:</span></td>
                                    <td style="text-align: left; padding: 8px 25px"><span style="font-weight: bold; font-size: 1.5rem"><?php echo bcdiv($stotal+$chrg, 1, 2)-bcdiv(@$orders[0]->wallet_used_amount, 1, 2);?> AED</td>
                                </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </td>
                    <!-- TOTAL -->
                </tr>
    
                    
            </tbody>
        </table>
        <!-- TOTAL SUMMARY -->

    </div>
    <!-- Products table -->
    
    <!-- PRINT BUTTON -->
    <div class="text-center mt-3 print_button" style="padding: 15px 0px">
      <button class="btn btn-danger" onclick="window.print()" >Print</button>
    </div>

    <!-- INVOICE FOOTER  -->
    <div class="printable_section" style="padding:25px 0px; margin: auto auto 0px auto; width: 65%; background-color: rgb(243, 243, 243);">
        <p style="text-align: center; font-size: 1.2rem; font-weight: bold">
            THANK YOU FOR SHOPPING WITH ZGAMES!
        </p>

        <p style="text-align:center; font-size: .8rem">
            <?php echo strip_tags($cms[6]->description);?>
        </p>
    </div>
    <!-- INVOICE FOOTER  -->

</div>
</body>
</html>

