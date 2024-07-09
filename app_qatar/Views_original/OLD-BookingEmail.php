<?php   
$session = session();
$userModel = model('App\Models\UserModel', false);

$sql="select * from settings";
$settingss=$userModel->customQuery($sql);
$settings=$settingss[0];

 
?>
<table cellspacing="0" cellpadding="0" border-collapse="collapse" style="padding: 0px 10px;
background: #fcf1ff;
width: 100%;
font-family: arial;">
<tbody>
 <tr>
  <td >
   <table align="center" cellspacing="0px" cellpadding="0px" style="width: 650px;">
    <tbody>
     <tr>
      <td style=" border: 1px solid #72c7ce; background: #72c7ce;box-shadow: 0 7px 7px 0 rgba(0,0,0,0.2),0 4px 10px 0 rgba(0,0,0,0.19) !important; 
      ">
      <img  src="<?php echo base_url(); ?>/assets/uploads/<?php echo $settings->logo; ?>" style="margin-left: 32%;    padding: 20px;
      width: 200px;">
    </td>
  </tr>
  <tr>
    <td align="center" style="background: #fff;
    padding: 22px 30px;
    font-family: arial;
    font-size: 16px;box-shadow: 0 7px 7px 0 rgba(0,0,0,0.2),0 4px 10px 0 rgba(0,0,0,0.19) !important;border: dashed 7px #72c7ce;
    border-radius: 5px;">
    <p style="font-size: 22px;
    margin-top:15px;
    font-weight:700;
    line-height:24px;">
    Order information
  </p>
  <p style="line-height:22px;margin-top:10px;">
    Thank you for using   <?php echo $settings->business_name; ?> , Your Order information is as follows : 
  </p>
  <p style="margin-top:25px;">
    <table style=" width: 100%;">
      <?php 
      if ($orders) { 
        foreach ($orders as $key => $value) {
      
            ?>  
              <tr>
                <td style=" border: 1px solid black;"> <?php echo ucfirst(str_replace('_', ' ', $key)) ; ?></td>
                <td style=" border: 1px solid black;">   <?php
                
                  if($key=="created_at"){
            echo date("d F Y h:i:s A", strtotime($value) );
        }
         else if($key=="sub_total"){
            echo 'AED '.number_format($value);
        }
          else if($key=="charges"){
            echo 'AED '.number_format($value);
        }
        
          else if($key=="total"){
            echo 'AED '.number_format($value);
        }
        else{
        
                
                echo @$value; 
                }
                ?></td>      
                </tr>  
                
                <?php 
                }
                }
                ?>
           </table>
             <table style=" width: 100%;">
             
               
                <h3>Product Details</h3>
                <?php
                if ($order_products) {  
                    ?>
                    
                     <tr>
     <th  style="text-align:left; border: 1px solid black;"> Image </th>   
                    

                      <th  style="text-align:left; border: 1px solid black;"> Name </th>   
                    
                      <th style=" text-align:left;border: 1px solid black;"> QTY </th>
                   
                      <th style=" text-align:left;border: 1px solid black;"> Price </th> 
                          
                       
                      </tr>
                    <?php
                  foreach (@$order_products as $key => $value) { 
                    ?>
                  
                    <tr>  <td style=" text-align:left;border: 1px solid black;"><img src="<?php echo base_url();?>/assets/uploads/<?php echo $value->product_image; ?>" width="50" ></td>      
                     
                      <td style=" text-align:left;border: 1px solid black;"><?php echo $value->product_name; ?>
                    
                      <?php if($value->gift_wrapping_price){?>
                        <br>
                      <?php
                      echo 'gift wrapping price : AED'. $value->gift_wrapping_price;
                      }
                      ?>
                      
                      
                       <?php if($value->assemble_professionally_price){?>
                        <br>
                      <?php
                      echo 'assemble professionally price : AED'. $value->assemble_professionally_price;
                      }
                      ?>
                      
                      </td>      
                      
                      
                      
                      <td style="text-align:left; border: 1px solid black;"><?php echo $value->quantity; ?></td>      
                    
                      <td style=" text-align:left;border: 1px solid black;"> AED <?php echo $value->product_price+$value->gift_wrapping_price+$value->assemble_professionally_price; ?></td>      
                    </tr>  
                    <?php
                  }
                }
                ?>
                   
           
              </table>
                 
            </p>
            <table align="center" style="margin:40px 50px 25px 50px;">
              <tbody>
               <tr>
                <td style="background-color: #f5dcfd;
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                text-align: center;">
                <a href="<?php echo base_url();?>" target="_blank"  style="background-color: #72c7ce;
                border-radius: 8px;
                text-align: center;padding: 12px 23px;
                display: block;
                text-decoration: none;
                color: #fff;
                font-size: 20px;
                text-align: center;
                font-family: arial;">
                Visit us
              </a>
            </td>
          </tr>
          <tr>
            <td style="padding-top:20px;">
             <div style="padding-top: 10px;
             text-align: center;
             font-family: arial;">
             <img alt="Thanks" src="<?php echo base_url();?>/assets/uploads/th.png">
             <br>
             <?php echo $settings->business_name; ?>
           </div>
         </td>
       </tr>
     </tbody>
   </table>
 </td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
 <td >
  <table align="center" style="max-width: 650px;">
   <tbody><tr>
    <td style="color: #737373;
    font-size: 11px;
    padding-bottom: 40px;
    padding-top: 20px;
    line-height: 15px;
    font-family: arial;">
    ©   <?php echo strip_tags($settings->business_name); ?> |   <?php echo strip_tags($settings->address); ?>
  </td>
</tr>
</tbody></table>
</td>
</tr>
</tbody>
</table>         