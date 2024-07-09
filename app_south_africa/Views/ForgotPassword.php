<?php   
    $session = session();
    $userModel = model('App\Models\UserModel', false);

    $sql="select * from settings";
    $settingss=$userModel->customQuery($sql);
    $settings=$settingss[0];
?>

<table style="background-color: #0e0e0e; max-width: 650px; width: 100%; margin: auto; border-radius: 30px;">
    <tr>
        <td style="">
            <table style="height: auto; width: 100%; margin: auto;">
                <!-- logo -->
                <thead style="">
                    <tr>
                        <td style="text-align: center; padding: 20px 0px;">
                            <img src="https://zamzamgames.com/assets/uploads/ZGames_550px_W.png" alt="" style="max-width: 120px;">
                        </td>
                    </tr>
                </thead>
                <!-- end logo -->

                <tbody style="color: white;">
                    <tr>
                        <td style="height: 35px"></td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 30px;  text-align: center;" >
                            <h3 style="">
                                Hello <?php echo @$user->name; ?>
                            </h3>
                            <P>
                                To reset your <?php echo $settings->business_name; ?> password, please simply follow the link below.
                            </P>
                            
                        </td>
                        
                    </tr>
                    <tr>
                        <td style="padding: 30px 20px; text-align: center;" >
                            <a href="<?php echo base_url();?>/reset-password/<?php echo @$token;?>" style="text-decoration: none; color: white;"><button style="cursor:pointer; border: none; color: white; background-color: #228d37; font-size: 15px; padding: 20px 20px; border-radius: 5px;">Reset password</button></a>
                        </td>
                    </tr>            

                    <tr>
                        <td style="padding: 10px 0px 10px 0px; text-align:center">
                            <a href="<?php echo $settings->facebook;?>">
                                <img src="http://192.168.2.177/cizgames/assets/uploads/ns_facebook.png" alt="" style="height: 25px; margin: 0px 10px;">
                            </a>
                            <a href="<?php echo $settings->instagram;?>">
                                <img src="http://192.168.2.177/cizgames/assets/uploads/ns_instagram.png" alt="" style="height: 25px; margin: 0px 10px;">
                            </a>
                            <a href="<?php echo $settings->tiktok;?>">
                                <img src="http://192.168.2.177/cizgames/assets/uploads/ns_tiktok.png" alt="" style="height: 25px; margin: 0px 10px;">
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 5px 0px; text-align:center">
                            <a href="<?php echo base_url()?>/contact-us" style="color: white; margin: 0px 15px;">Contact us</a>
                            <a href="<?php echo base_url()?>/faq" style="color: white; margin: 0px 15px;">FAQ</a>
                        </td>
                    </tr>

                    <tr>
                        <td style="color: #9b9b9b; font-size: 11px; padding-bottom: 40px; padding: 10px 0px; line-height: 15px; font-family: arial; text-align: center;">
                            © <a href="<?php echo base_url()?>" style="color: inherit"><?php echo strip_tags($settings->business_name); ?> </a>| <?php echo strip_tags($settings->address); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>