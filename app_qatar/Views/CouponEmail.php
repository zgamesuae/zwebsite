<?php   
$session = session();
$userModel = model('App\Models\UserModel', false);

$sql="select * from settings";
$settingss=$userModel->customQuery($sql);
$settings=$settingss[0];

 
?>
<table cellspacing="0" cellpadding="0" border-collapse="collapse" style="padding: 0px 10px;
background: #fff;
width: 100%;
font-family: arial;">
<tbody>
 <tr>
  <td >
   <table align="center" cellspacing="0px" cellpadding="0px" style="width: 650px;">
    <tbody>
     <tr>
      <td  style=" background:#fff">
      <img  src="<?php echo base_url(); ?>/assets/uploads/<?php echo $settings->logo; ?>" style=" width: 30%;  margin: auto auto;  display: block;">
    </td>
  </tr>
  <tr>
    <td align="center" style="
    background: #fff;
    padding: 22px 30px;
    font-family: arial;
    font-size: 16px;
    border: dashed 7px #243e97;
    border-radius: 5px; "
    <p style="font-size: 22px;
    margin-top:15px;
    font-weight:700;
    line-height:24px;">
    Hi,    <?php echo @$user->name; ?>  
  </p>
 
  <p style="margin-top:25px;">
   You have received new coupon . 
       
            </p>
               <table align="center" style="margin:40px 50px 25px 50px;">
              <tbody>
               <tr>
                <td style=" 
                text-align: center;">
          <h4> Coupon Code : <?php echo $post['coupon_code']; ?></h4>
            
              </td>
       </tr>
     </tbody>
   </table>
            <table align="center" style="margin:40px 50px 25px 50px;">
              <tbody>
               <tr>
                <td style="background-color: #243d97;
                border-radius: 8px;
                -webkit-border-radius: 8px;
                -moz-border-radius: 8px;
                text-align: center;">
                <a href="<?php echo base_url();?>" target="_blank"  style="background-color: #243d97;
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