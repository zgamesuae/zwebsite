<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
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
$sql="select *,order_products.gift_wrapping as gw,order_products.assemble_professionally_price as app from order_products 
 
where order_products.order_id='$uri2'";


$cart=$userModel->customQuery($sql);
$sql="select * from order_charges where order_id='$uri2'";
$charges=$userModel->customQuery($sql);
?> 
<!DOCTYPE html>
<html lang="en">
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
<body class="bg-light">
  <style>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,200;1,300;1,400&display=swap');
   body{font-family: 'Poppins', sans-serif;}.billing_info_inner h5{text-transform:capitalize;font-size:18px}.billing_info_inner ul{padding-left:0;margin:11px 0 0 0}.billing_info_inner li{display:block;padding:5px 0}.billing_info_inner li a{color:#8e8e8e;font-size:14px;display:flex;align-items:center}.billing_info_inner li a svg{margin-right:4px;fill:#1f96f4}.invoice_logo img{width:100%;border-radius:11px}.text-small{font-size:15px}.text-gray{color:#a08e8e}.invoice_send ul{padding:0;margin:0}.invoice_send ul li{padding:7px 0;color:gray;font-size:15px;display:flex;justify-content:space-between}.invoice_table th{background:#000;color:#fff;text-transform:uppercase;font-weight:100}.invoice_send ul li span:first-child{color:#000}.invoice_table th{border-bottom:unset!important}table.table.invoice_table::after{content:"";position:absolute;left:-9px;width:101.7%;height:4px;background:#007bff;top:51px}.invoice_table .active{background:#007bff!important;text-transform:uppercase;font-weight:500;letter-spacing:1px}.image_product img{border-radius:4px;width:65px;height:47px;border:1px solid #f4f5f6;object-fit:cover}.products_content h5{font-size:16px;margin:0;width:201px}.products_item{display:flex}.products_content{max-width:108px;width:100%}.invoice_table td,.invoice_table th{vertical-align:middle}ul.subtotal_calclution li span{color:#007bff}ul.subtotal_calclution li{display:flex;padding:5px 0;text-transform:capitalize;justify-content:space-between;color:gray}ul.subtotal_calclution{padding:0;margin:0}.subtotal_last *{padding:0;margin:0;font-size:15px}.subtotal_last{color:#fff;background:#007bff;display:flex;justify-content:space-between;padding:8px 13px;margin-top:9px}.invoice_table td,.invoice_table th{vertical-align:middle;text-align:center}.products_content p{width:200px;font-size:13px;color:gray;font-weight:100}ul.footer_social_media li{display:inline-block;padding:0 9px}ul.footer_social_media{padding:0;margin:0;width:fit-content;margin:auto}ul.footer_social_media a{color:#000;width:fit-content}@media print{body *{visibility:hidden}#section-to-print,#section-to-print *{visibility:visible}#section-to-print{position:absolute;left:0;top:0}}
 .table td, .table th {
    padding: 0.75rem 0;
 }
 </style>
 <div class="container pt-5 pb-4">
  <div class="row justify-content-center">
    <div class="col-md-12 ">
      <div class="box_invoice bg-white shadow-sm rounded p-4 " id="section-to-print">
        <div class="row border-bottom pb-3">
          <div class="col-md-3">
            <div class="invoice_logo">
              <a href="#">
                <!--<img src="<?php echo base_url();?>/assets/uploads/<?php echo $settings[0]->logo;?>" alt="">-->
                <img src="<?php echo base_url();?>/assets/uploads/ZGames-logo-02.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-md-9">
            <div class="row">
              <div class="col-12">
                <div class="billing_info pb-3 mb-3 border-bottom">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="billing_info_inner">
                        <h5>phone</h5>
                        <ul>
                          <li>
                            <a href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"/></svg>
                              <span><?php echo $settings[0]->phone;?></span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 4a8 8 0 0 0-8 8h3a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-7C2 6.477 6.477 2 12 2s10 4.477 10 10v7a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h3a8 8 0 0 0-8-8zM4 14v5h3v-5H4zm13 0v5h3v-5h-3z"/></svg>
                              <span><?php echo $settings[0]->whatsapp_no;?></span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="billing_info_inner">
                        <h5>email</h5>
                        <ul>
                          <li>
                            <a href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"/></svg>
                              <span><?php echo $settings[0]->email;?></span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"/></svg>
                              <span><?php echo $settings[0]->email_2;?></span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="billing_info_inner">
                        <h5>address</h5>
                        <ul>
                          <li>
                            <a href="#">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 20.9l4.95-4.95a7 7 0 1 0-9.9 0L12 20.9zm0 2.828l-6.364-6.364a9 9 0 1 1 12.728 0L12 23.728zM12 13a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
                              <span><?php echo $settings[0]->address;?></span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <h2 class="m-0 text-primary">Invoice</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-5">
            <div class="invoice_to text-capitalize">
              <h4>Invoice To</h4>
              <h6 class="text-primary author_name"><?php echo $orders[0]->name;?></h6>
              <div class="adress_to text-gray text-small">
                Address: <?php echo $orders[0]->street;?>, <?php echo $orders[0]->apartment_house;?>, <?php echo $orders[0]->address;?>, <?php
                $cityid=$orders[0]->city;
                $sql="select * from city where city_id='$cityid'";
                $city=$userModel->customQuery($sql);
                echo @$city[0]->title;?><br>
                Phone: <?php echo $orders[0]->phone;?> <br>
                E-mail: <?php echo $orders[0]->email;?>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="invoice_send text-capitalize">
              <ul>
                <li><span>Invoice date </span> <span><?php echo date("d M Y");?></span></li>
                <li><span>issue date </span> <span><?php echo date("d M Y", strtotime($orders[0]->created_at));?>
              </span></li>
              <li><span>order ID. </span> <span><?php echo $orders[0]->order_id;?> </span></li>
              <li><span>order status </span> <span><?php echo $orders[0]->order_status;?> </span></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-md-12">
          <table class="table invoice_table">
            <thead>
              <tr>
                <th class="active">item description</th>
                <th >SKU</th>
                <th >price</th>
                <th >quantity</th>
                   <th >Price excluding VAT</th>
                      <th >VAT</th>
                <th >total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <?php   $total=0;
                $stotal=0;
                if($cart){
                  foreach($cart as $k=>$v){ 
                    $ptotal=0;$temp=0;
                    $pid=$v->product_id;
                    
                    
                    $sql="select * from products where product_id='$pid'";


$productDetails=$userModel->customQuery($sql);
                    
                    
                    ?>
                    <td >
                      <div class="products_item">
                        <div class="image_product">
                          <img src="<?php echo base_url();?>/assets/uploads/<?php if($v->product_image) echo $v->product_image;else echo 'noimg.png';?>">
                        </div>
                        <div class="products_content">
                          <h5><?php echo  ($v->product_name);?>
                          <?php if($v->app>0){
                            ?>
                            <br>( assemble professionally - <?php echo  $v->app;?> AED))
                          <?php } ?>
                          <?php if($v->gift_wrapping_price>0){
                            ?>
                            <br>( Gift Wrapping - <?php echo  $v->gift_wrapping_price;?> AED)
                          <?php } ?>
                        </h5>
                      </div>
                    </div>
                  </td>
                  <td> <?php if(@$productDetails[0]->sku){
                    echo @$productDetails[0]->sku ;
                  }else{
                 echo  @$v->sku;
                  }?></td>
                  <td> <?php echo   bcdiv($v->product_price, 1, 2);?> AED</td>
                  <td><?php echo    $v->quantity ;?></td>
                  
                  
                  
                  
                  
                  
                  
                   <td> <?php 
                   $tprice=$v->product_price+$v->gift_wrapping_price+$v->app;
                   echo     round(($tprice / 1.05) * $v->quantity,2) ;?> AED</td>
                    <td> <?php
                    $vat=  ($tprice - ($tprice/1.05))* $v->quantity;
                    echo     round($vat,2) ;?> AED</td>
                  
                  
                  
                  
                  
                  
                  
                  <td> <?php     $ptotal+=($v->product_price+$v->gift_wrapping_price+$v->app) * $v->quantity ;
                  echo bcdiv($ptotal, 1, 2);
                //   $stotal+=($v->product_price+$v->gift_wrapping_price+$v->app) * $v->quantity ;
                  $tpro=($v->product_price + $v->app+$v->gift_wrapping_price)*$v->quantity;
                  if($v->coupon_code){
                    if($v->coupon_type=="Percentage"){
                      $dtotal=$dtotal+($tpro- ($tpro*$v->coupon_value)/100);
                      $dc_value=$dc_value+ (($tpro*$v->coupon_value)/100);
                      $stotal=$stotal+(($tpro- ($tpro*$v->coupon_value)/100)) ;
                    }else{
                      $dtotal=$dtotal+($tpro-$v->coupon_value); 
                      $dc_value=$dc_value+$v->coupon_value;
                      $stotal=$stotal+(($tpro-$v->coupon_value));
                    }
                  }else{
                   $stotal=$stotal+($v->product_price+$v->app+$v->gift_wrapping_price)*$v->quantity;
                 }
               ?> AED</td>
             </tr>
             <?php
           }
         }
         ?>
       </tbody>
     </table>
   </div>
 </div>
 <div class="row justify-content-end">
  <div class="col-md-4">
    <ul class="subtotal_calclution">
      <li><span>subtotal:</span>  <?php echo bcdiv($stotal, 1, 2);?> AED</li>
      <?php 
      $chrg=0;
      if($charges){
       foreach($charges as $k2=>$v2){ 
        ?>
        <li><span> 
          <?php echo  ($v2->title );  if($v2->type =="Percentage"){ echo '('.$v2->value.'%)'; }?> : </span> 
          <div class="">
            <?php 
            if($v2->type =="Percentage"){
              echo bcdiv(($stotal*$v2->value)/100, 1, 2); 
              $chrg=$chrg+($stotal*$v2->value)/100;
            } else {
              echo bcdiv($v2->value, 1, 2);
              $chrg=$chrg+($v2->value);
            }?>
            AED 
          </li>
        <?php } } ?>
        <?php if($dc_value){?>
          <li><span>Coupon discount:</span>  <?php echo bcdiv($dc_value, 1, 2);?> AED</li>
        <?php } ?>
      </ul>
      <div class="subtotal_last">
        <h5>Total</h5>
        <h5> <?php echo bcdiv($stotal+$chrg, 1, 2);?> AED</h5>
      </div>
      <?php 
      if(@$orders[0]->wallet_use=="Yes"){
        ?>
        <div class="subtotal_last">
          <h5>Wallet used:</h5>
          <h5><?php echo bcdiv(@$orders[0]->wallet_used_amount, 1, 2);?> AED</h5>
        </div>
        <?php
      } 
      ?>
      <?php 
      if(@$orders[0]->wallet_use=="Yes"){
        ?>
        <div class="subtotal_last">
          <h5>Payable Amount</h5>
          <h5> <?php echo bcdiv($stotal+$chrg, 1, 2)-bcdiv(@$orders[0]->wallet_used_amount, 1, 2);?> AED</h5>
        </div>
        <?php
      }  
      ?>
    </div>
  </div>
  <div class="row justify-content-between mt-4 align-items-center">
    <div class="col-md-5">
      <h4 class="text-primary">Payment Detail</h4>
      <ul class="subtotal_calclution">
        <li><span>payment method:</span> <?php echo $orders[0]->payment_method;?></li>
        <li><span>payment status:</span> <?php echo $orders[0]->payment_status;?> </li>
      </ul>
    </div>
    <div class="col-md-4">
      <h5 class="text-dark">Director Signature</h5>
    </div>
  </div>
  <div class="row justify-content-between mt-4 align-items-center">
    <div class="col-md-12 border-bottom">
      <h5 class="text-dark"><?php echo  ($cms[6]->heading);?></h5>
      <p class="text-small text-gray"> <?php echo strip_tags($cms[6]->description);?></p>
    </div>
  </div>
  <div class="row  mt-4 align-items-center">
    <div class="col-md-12">
      <ul class="footer_social_media">
              <!--  <li>
                  <a href="tel:<?php echo $settings[0]->phone;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M9.366 10.682a10.556 10.556 0 0 0 3.952 3.952l.884-1.238a1 1 0 0 1 1.294-.296 11.422 11.422 0 0 0 4.583 1.364 1 1 0 0 1 .921.997v4.462a1 1 0 0 1-.898.995c-.53.055-1.064.082-1.602.082C9.94 21 3 14.06 3 5.5c0-.538.027-1.072.082-1.602A1 1 0 0 1 4.077 3h4.462a1 1 0 0 1 .997.921A11.422 11.422 0 0 0 10.9 8.504a1 1 0 0 1-.296 1.294l-1.238.884zm-2.522-.657l1.9-1.357A13.41 13.41 0 0 1 7.647 5H5.01c-.006.166-.009.333-.009.5C5 12.956 11.044 19 18.5 19c.167 0 .334-.003.5-.01v-2.637a13.41 13.41 0 0 1-3.668-1.097l-1.357 1.9a12.442 12.442 0 0 1-1.588-.75l-.058-.033a12.556 12.556 0 0 1-4.702-4.702l-.033-.058a12.442 12.442 0 0 1-.75-1.588z"></path></svg>
                    <span><?php //echo $settings[0]->phone;?></span>
                  </a>
                </li>-->
                <li>
                  <a href="mailto:<?php echo $settings[0]->email;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M3 3h18a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm17 4.238l-7.928 7.1L4 7.216V19h16V7.238zM4.511 5l7.55 6.662L19.502 5H4.511z"></path></svg>
                    <span><?php echo $settings[0]->email;?></span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo $settings[0]->facebook;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"/></svg>
                    <span><?php echo $settings[0]->facebook;?></span>
                  </a>
                </li>
                <li>
                  <a href="<?php echo $settings[0]->instagram;?>">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6zm0-2a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm6.5-.25a1.25 1.25 0 0 1-2.5 0 1.25 1.25 0 0 1 2.5 0zM12 4c-2.474 0-2.878.007-4.029.058-.784.037-1.31.142-1.798.332-.434.168-.747.369-1.08.703a2.89 2.89 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.006 9.075 4 9.461 4 12c0 2.474.007 2.878.058 4.029.037.783.142 1.31.331 1.797.17.435.37.748.702 1.08.337.336.65.537 1.08.703.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.474 0 2.878-.007 4.029-.058.782-.037 1.309-.142 1.797-.331.433-.169.748-.37 1.08-.702.337-.337.538-.65.704-1.08.19-.493.296-1.02.332-1.8.052-1.104.058-1.49.058-4.029 0-2.474-.007-2.878-.058-4.029-.037-.782-.142-1.31-.332-1.798a2.911 2.911 0 0 0-.703-1.08 2.884 2.884 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.925 4.006 14.539 4 12 4zm0-2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2z"/></svg>
                    <span><?php echo $settings[0]->instagram;?></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="text-center mt-3">
          <button class="btn btn-danger" onclick="window.print()" >Print</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
