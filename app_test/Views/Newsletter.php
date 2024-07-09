<?php
    $productModel = model("App\Models\ProductModel");
    $offerModel = model("App\Models\OfferModel");
    $nl_model = model("App\Models/NewsletterModel");
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap');

body{
    padding: 5px
}
* {
    font-family: 'cairo', sans-serif;
    /* color: rgb(70, 70, 70); */
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
</style>

 <div style="height:auto; width:630px; background-color: #f7f7f757; margin:auto"> 
    <!-- <div class="content" style="width:650px; height:auto; background-color:white; padding:10px; margin:auto"> -->
    <table align="center" style="width:100%; max-width:650px; margin:auto">
        <tbody>
            <tr>
                <!-- Content starts here -->
                <td align="center">
                    <!-- Header -->
                    <table align="center" style="width:100%; max-width:650px; height:auto; text-align:center; background-color: #0055a3; color:white;padding-bottom: 10px;border-collapse: collapse;">
                        <thead>
                            <!-- Tabby Section announcement section -->
                            <tr style="background-color: #007ef1">
                                <td colspan="2" style="padding: 8px; text-align: left;">
                                    <p style="margin:0px; font-size: 11px;">
                                        NOW WE ACCEPT
                                        <img style="vertical-align: middle; margin: 0px 10px" src="<?php echo base_url() ?>/assets/others/tabby-badge.png" width="60px" alt="">
                                    </p>
                                </td>
                                <td colspan="2" style="padding: 8px; text-align: right;">
                                    <p style="margin:0px; font-size: 11px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.9em" viewBox="0 0 640 512" style="fill: white; vertical-align: middle; margin: 0px 10px">
                                            <path d="M112 0C85.5 0 64 21.5 64 48V96H16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 272c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 48c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 240c8.8 0 16 7.2 16 16s-7.2 16-16 16H64 16c-8.8 0-16 7.2-16 16s7.2 16 16 16H64 208c8.8 0 16 7.2 16 16s-7.2 16-16 16H64V416c0 53 43 96 96 96s96-43 96-96H384c0 53 43 96 96 96s96-43 96-96h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V288 256 237.3c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7H416V48c0-26.5-21.5-48-48-48H112zM544 237.3V256H416V160h50.7L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z"/>
                                        </svg>

                                        FREE SHIPPING ABOVE 100AED SPENT
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                <th colspan="4" style="padding: 20px 0">
                                    <a target="blank" href="https://zgames.ae">
                                        <img src="https://zgames.ae/assets/uploads/ZGames-logo-03-02.png" width="80px" alt="">
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody style="background-color: #007ef1;">
                            <tr>
                                <td style="padding: 15px 0px;text-align: center; width: 24%;font-size:12px;border-right: 1px solid #03223e"><a style="color:inherit; text-decoration: none" href="<?php echo site_url("/playstation") ?>">PLAYSTATION</a></td>
                                <td style="padding: 15px 0px;text-align: center; width: 24%;font-size:12px;border-right: 1px solid #03223e"><a style="color:inherit; text-decoration: none" href="<?php echo site_url("/xbox") ?>">XBOX</a></td>
                                <td style="padding: 15px 0px;text-align: center; width: 24%;font-size:12px;border-right: 1px solid #03223e"><a style="color:inherit; text-decoration: none" href="<?php echo site_url("/nintendo-switch") ?>">NINTENDO SWITCH</a></td>
                                <td style="padding: 15px 0px;text-align: center; width: 24%;font-size:12px;"><a style="color:inherit; text-decoration: none" href="<?php echo site_url("/gaming-desktops") ?>">GAMING DESKTOPS</a></td>
                            </tr>
                        </tbody>
                    </table>

                     <!-- Newsletter Sections -->
                    <?php 
                    if( isset($sections) && $sections && sizeof($sections) > 0):
                    foreach($sections as $section):
                       if($section->section_title !== "" && $nl_model->has_valid_images($section->id)):
                    ?>
                    <table align="center" style="background-color:#f7f7f7; width:100%; max-width:650px; height:auto; column-gap: 10px; border-collapse:separate; border-spacing:8px; border-radius:3px; margin-top: 20px;">
                        <thead style="text-align:center; color:#444444 ">
                            <?php 
                                $section_titles = explode(",",$section->section_title);
                            ?>
                            <?php  ?>
                            <tr>
                                <th style="padding: 8px 25px 0; font-size: 11px;" <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[0] ?></th>

                                <?php if($section->section_type == "MOSAIC" || $section->section_type == "SUNGLASSES"): ?>
                                <th style="padding: 8px 25px 0; font-size: 11px;" <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[1] ?></th>
                                <?php endif; ?>
    
                            </tr>
                            
                        </thead>
                        <tbody style="text-align:center">
                            <tr>
                                <td <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>>
                                    <a target="blank" href="<?php echo $section->link_1?>">
                                        <div class="image" style="width:100%; height:auto; background-color:#53667c;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_1?>" alt=""></div>
                                    </a>
                                </td>
                        
                                <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC"): ?>                
                                <td <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>>
                                    <a target="blank" href="<?php echo $section->link_2?>">
                                        <div class="image" style="width:100%; height:auto; background-color:#53667c;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_2?>" alt=""></div>
                                    </a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        </tbody>

                        <thead style="text-align:center; color:#444444 ">
                            
                            <?php if($section->section_type == "MOSAIC" ): ?>
                            <tr>
                                <th style="padding: 8px 25px 0; font-size: 11px;"<?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[2] ?></th>
                                <?php if($section->section_type == "MOSAIC" ): ?>
                                <th style="padding: 8px 25px 0; font-size: 11px;"<?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[3] ?></th>
                                <?php endif; ?>
                                
                            </tr>
                            <?php endif; ?>
                        
                        </thead>
                        <?php if($section->section_type == "MOSAIC"): ?>            
                            <tbody>
                                <tr>
                                    <td style="width:50%">
                                        <a target="blank" href="<?php echo $section->link_3?>">
                                            <div class="image" style="width:100%; height:auto; background-color:#53667c;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_3?>" alt=""></div>
                                        </a>
                                    </td>
                                
                                    <td style="width:50%">
                                        <a target="blank" href="<?php echo $section->link_4?>">
                                            <div class="image" style="width:100%; height:auto; background-color:#53667c;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_4?>" alt=""></div>
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                
                                
                                <?php if(isset($newsletter_info->promotion_text) && $newsletter_info->promotion_text): ?>
                                <tr style="height:15px; background-color:white; text">
                                    <td style="width:100%">SOME PROMOTION TEXT TO PUT HERE</td>
                                </tr>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php 
                    endif;
                    endforeach;
                    endif;
                    ?>
                            
                            
                    <!-- PROMOTED PRODUCTS -->
                    <?php if(isset($promoted_products) && sizeof($promoted_products) > 0):?>
                    <table align="center" style="background-color:#f7f7f7; width:100%; max-width:650px; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px">
                        <thead style="text-align:center; color:#444444 ">
                            <tr>
                                <th style="width:100%;padding: 8px 25px 0; font-size: 15px;" colspan="3">Best offers</th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center">
                            <?php 
                            // var_dump($promoted_products);die();
                                for($i=0 ; $i<sizeof($promoted_products) ; $i=$i+3):
                                
                            ?>
                                <!-- #00888f #67819f #c3c3c3-->
                                
                            <tr>
                                <?php if(key_exists(($i) , $promoted_products)):?>
                                    <td style="width:auto;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:135px; height:250px; background-color:#e5e5e5; border-radius:8px;margin:auto; overflow:hidden">
                                            <div style="height:70%; width:100%;">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i]->image?>" style="margin:auto;width:auto;max-width:100%;max-height:100%; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:70%; width:100%;background-color:none">
                                                    <?php $p_title=(strlen($promoted_products[$i]->name) > 42) ? substr($promoted_products[$i]->name ,0,42)."..." : $promoted_products[$i]->name; ?>
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i]->product_id); ?>"><p style="margin:0; line-height:14px; font-size:11px; text-align:left;padding:5px;"><?php echo($p_title); ?></p></a>
                                                </div>
                                                <div style="height:auto; width:100%; background-color:none;">

                                                    <?php
                                                        $discount = $productModel->get_discounted_percentage($offerModel->offers_list , $promoted_products[$i]->product_id);
                                                        if($discount["discount_amount"] > 0): ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($discount["new_price"]); ?> <?php echo CURRENCY ?></span>
                                                        <span style="text-decoration:line-through; margin:0px; color:#2c2c2c;font-size:.8rem;">
                                                        <?php echo($promoted_products[$i]->price); ?> <?php echo CURRENCY ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($promoted_products[$i]->price); ?> <?php echo CURRENCY ?></span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif;?>
                                                    
                                <?php if(key_exists(($i+1) , $promoted_products)):?>
                                    <td style="width:auto;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:135px; height:250px; background-color:#e5e5e5; border-radius:8px;margin:auto; overflow:hidden">
                                            <div style="height:70%; width:100%;">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i+1]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i+1]->image?>" style="margin:auto;width:auto;max-width:100%;max-height:100%; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:70%; width:100%;background-color:none">
                                                    <?php $p_title=(strlen($promoted_products[$i+1]->name) > 42) ? substr($promoted_products[$i+1]->name ,0,42)."..." : $promoted_products[$i+1]->name; ?>
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i+1]->product_id); ?>"><p style="margin:0; line-height:14px; font-size:11px; text-align:left;padding:5px;"><?php echo($p_title); ?></p></a>
                                                </div>
                                                <div style="height:auto; width:100%; background-color:none">

                                                    <?php 
                                                        $discount = $productModel->get_discounted_percentage($offerModel->offers_list , $promoted_products[$i+1]->product_id);
                                                        if($discount["discount_amount"] > 0): ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($discount["new_price"]); ?> <?php echo CURRENCY ?></span>
                                                        <span style="text-decoration:line-through; margin:0px; color:#2c2c2c;font-size:.8rem;">
                                                        <?php echo($promoted_products[$i+1]->price); ?> <?php echo CURRENCY ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($promoted_products[$i+1]->price); ?> <?php echo CURRENCY ?></span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif;?>
                                                    
                                <?php if(key_exists(($i+2) , $promoted_products)):?>
                                    <td style="width:auto;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:135px; height:250px; background-color:#e5e5e5; border-radius:8px;margin:auto; overflow:hidden">
                                            <div style="height:70%; width:100%; ">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i+2]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i+2]->image?>" style="margin:auto;width:auto;max-width:100%;max-height:100%; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:70%; width:100%;background-color:none">
                                                    <?php $p_title=(strlen($promoted_products[$i+2]->name) > 42) ? substr($promoted_products[$i+2]->name ,0,42)."..." : $promoted_products[$i+2]->name; ?>
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i+2]->product_id); ?>"><p style="margin:0; line-height:14px; font-size:11px; text-align:left;padding:5px;"><?php echo($p_title); ?></p></a>
                                                </div>
                                                <div style="height:auto; width:100%; background-color:none">

                                                    <?php
                                                        $discount = $productModel->get_discounted_percentage($offerModel->offers_list , $promoted_products[$i+2]->product_id); 
                                                        if($discount["discount_amount"] > 0): ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($discount["new_price"]); ?> <?php echo CURRENCY ?></span>
                                                        <span style="text-decoration:line-through; margin:0px; color:#2c2c2c;font-size:.8rem;">
                                                        <?php echo($promoted_products[$i+2]->price); ?> <?php echo CURRENCY ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:14px; font-weight:bold"><?php echo($promoted_products[$i+2]->price); ?> <?php echo CURRENCY ?></span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif;?>
                            </tr>
                            <?php endfor;?>
                                                    
                        </tbody>
                    </table>
                    <?php endif;?>
                                    
                    <!-- Footer -->
                    <table align="center" style="width:100%;max-width:650px; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px; color:#444444">
                        <tbody>
                            <tr></tr>
                            <tr>
                                <td style="text-align: center;">
                                    <p style="margin:0px; width: 100%; font-size: .8rem"> Accepted payment methods </p>
                                    <img style="vertical-align: middle; margin: 10px 5px" height="35px" src="https://zgames.ae/assets/others/Visa_card.png" style="width: 65%" alt="">
                                    <img style="vertical-align: middle; margin: 10px 5px" height="35px" src="https://zgames.ae/assets/others/master_card.png" style="width: 65%" alt="">
                                    <img style="vertical-align: middle; margin: 10px 5px" height="35px" src="https://zgames.ae/assets/others/american_express.png" style="width: 65%" alt="">
                                    <img style="vertical-align: middle; margin: 10px 5px" height="35px" src="https://zgames.ae/assets/others/union_pay.png" style="width: 65%" alt="">
                                    <img style="vertical-align: middle; margin: 10px 5px" height="35px" src="https://zgames.ae/assets/others/cash_on_delivery.png" style="width: 65%" alt="">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center">
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636; mix-blend-mode:difference" href="<?php echo $settings[0]->facebook; ?>">
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_facebook.png" alt="">
                                    </a>
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636; mix-blend-mode:difference" href="<?php echo $settings[0]->instagram; ?>">
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_instagram.png" alt="">
                                    </a>
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636; mix-blend-mode:difference" href="<?php echo $settings[0]->tiktok; ?>">
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_tiktok.png" alt="">
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td style="font-size:11px;height:auto; text-align:center; line-height:20px; padding:0;" colspan="4">
                                    <p>
                                        <!--You're receiving this newsletter because you suscribed on <a target="blank" href="<?php echo(base_url())?>">ZGames</a> newsletter. <br>-->
                                        Tel: <?php echo $settings[0]->phone; ?> <br>
                                        Email: <?php echo $settings[0]->email; ?> <br>
                                        © <?php echo $settings[0]->business_name; ?> | Business Bay, Opus by Omniat, Dubai.
                                        <!--<?php echo $settings[0]->address; ?>-->
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <!-- Content ends here -->
            </tr>
        </tbody>
    </table>
        
    <!-- </div> -->
 </div> 


        