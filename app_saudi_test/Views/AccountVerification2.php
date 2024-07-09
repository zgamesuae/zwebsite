
<?php   
$session = session();
$userModel = model('App\Models\UserModel', false);

$sql="select * from settings";
$settingss=$userModel->customQuery($sql);
$settings=$settingss[0];

// var_dump($settings);die();
 
?>
<!-- website main color #22398d -->
<div class="container" style="background-color: #f5f4f4;color:white;margin:auto;width: 100%;">
        <div class="content" style="width:650px;min-height:550px; margin: auto;padding: 25px">
            <table style="text-align:center; width:100%; height:100%; margin:auto">

                <!-- Header of the email -->
                <tr>
                    <td style="width: 100%;padding:15px">
                        <img src="<?php echo base_url() ?>/assets/uploads/ZGames-logo-02.png" alt="" style="height:100px;margin:auto;">
                    </td>
                </tr>

                <!-- Content of the email -->
                <tr>
                    <td style="padding: 15px">
                        <div style="background-color: #252525; border-radius: 30px; height: auto;">
                            <table style="margin:auto">
                                <tr>
                                    <td>
                                        <p style="font-size: 25px; font-weight: 700; padding-top: 28px;">
                                            Thank you <?php echo @$user->name; ?> for joining <?php echo $settings->business_name; ?>
                                        </p>
                                        <p style="font-size: 20px; padding: 5px 55px;text-align: left;">
                                            To complete your registration, please verify your email. 
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 50px 0">
                                            <div style="background-color:#243d97; padding:15px 20px; border-radius:10px; width:150px; margin: auto;">
                                                <a href="<?php echo base_url();?>/verify/<?php echo @$user->token;?>" style="text-decoration: none; color: inherit;">
                                                    <span>VERIFY ACCOUNT</span>
                                                </a>
                                            </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 25px 0;">
                                        <div style="width:200PX; background-color: none; height:35px; margin: auto;">
                                            <table style="width:100%; height:100%; margin:auto">
                                                <tr>
                                                    <td>
                                                        <a href="<?php echo $settings->facebook?>"><img src="<?php echo base_url() ?>/assets/uploads/FACEBOOK-02.png" style="height:22px; vertical-align:middle;" alt=""></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo $settings->instagram?>"><img src="<?php echo base_url() ?>/assets/uploads/Instagram-02.png" style="height:22px; vertical-align:middle;" alt=""></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo $settings->tiktok?>"><img src="<?php echo base_url() ?>/assets/uploads/tiktok-02.png" style="height:22px; vertical-align:middle;" alt=""></a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo $settings->youtube?>"><img src="<?php echo base_url() ?>/assets/uploads/Youtube-02.png" style="height:22px; vertical-align:middle;" alt=""></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>

                <!-- The footer of the email -->
                <tr>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: center;">
                                    <p style="color:#3e3e3e;text-align: center;">
                                        © <a href="<?php echo base_url();?>"><?php echo $settings->business_name; ?></a> LLC.</br>
                                        <?php echo strip_tags($settings->address); ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr style="color: red; width:65%">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">
                                    <p style="color:#3e3e3e;text-align: center;">
                                        <a href="<?php echo base_url();?>/contact-us"><span>Contact us</span></a> | <a href="<?php echo base_url();?>/about-us"><span>About us</span></a>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
        </div>
    </div>