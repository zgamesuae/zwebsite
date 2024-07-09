<?php
    $productModel = model("App\Models\ProductModel");
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

<!-- <div class="container" style="height:auto; width:100%; background-color:white; padding:5px"> -->
    <!-- <div class="content" style="width:650px; height:auto; background-color:white; padding:10px; margin:auto"> -->
    <table align="center" width="100%">
        <tbody>
            <tr>
                <!-- Content starts here -->
                <td align="center">
                    <!-- Header -->
                    <table align="center" style="width:650px; height:auto; text-align:center">
                        <tr>
                            <td>
                                <a target="blank" href="<?php echo base_url()?>">
                                    <img src="<?php echo base_url()?>/assets/uploads/ZGames-logo-02.png" width="100px" alt="">
                                </a>
                            </td>
                        </tr>
                    </table>

                     <!-- Newsletter Sections -->
                     <?php foreach($sections as $section):
                        if($section->section_title !== "" && $nl_model->has_valid_images($section->id)):
                        ?>
                    <table align="center" style="background-color:#f1f1f1; width:650px; height:auto; column-gap: 10px; border-collapse:separate; border-spacing:8px; border-radius:3px; margin-top: 20px;">
                        <thead style="background-color:black; text-align:center; color:white ">
                            <?php 
                                $section_titles = explode(",",$section->section_title);
                            ?>
                            <?php  ?>
                            <tr>
                                <th style=" padding:12px 0" <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[0] ?></th>

                                <?php if($section->section_type == "MOSAIC" || $section->section_type == "SUNGLASSES"): ?>
                                <th style=" padding:12px 0" <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[1] ?></th>
                                <?php endif; ?>
    
                            </tr>
                            
                        </thead>
                        <tbody style="text-align:center">
                            <tr>
                                <td <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>>
                                    <a target="blank" href="<?php echo $section->link_1?>">
                                        <div class="image" style="width:100%; height:auto; background-color:#53667c*;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_1?>" alt=""></div>
                                    </a>
                                </td>
                        
                                <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC"): ?>                
                                <td <?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>>
                                    <a target="blank" href="<?php echo $section->link_2?>">
                                        <div class="image" style="width:100%; height:auto; background-color:#53667c*;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_2?>" alt=""></div>
                                    </a>
                                </td>
                                <?php endif; ?>
                            </tr>

                            
                                
                            
                            
                            
                        </tbody>

                        <thead style="background-color:black; text-align:center; color:white ">
                            
                            <?php if($section->section_type == "MOSAIC" ): ?>
                            <tr>
                                <th style=" padding:12px 0"<?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[2] ?></th>
                                <?php if($section->section_type == "MOSAIC" ): ?>
                                <th style=" padding:12px 0"<?php if($section->section_type == "SUNGLASSES" || $section->section_type == "MOSAIC") echo 'style="width:50%"'?>><?php echo $section_titles[3] ?></th>
                                <?php endif; ?>
                                
                            </tr>
                            <?php endif; ?>
                        
                        </thead>
                        <?php if($section->section_type == "MOSAIC"): ?>            
                            <tbody>
                                <tr>
                                    <td style="width:50%">
                                        <a target="blank" href="<?php echo $section->link_3?>">
                                            <div class="image" style="width:100%; height:auto; background-color:#53667c*;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_3?>" alt=""></div>
                                        </a>
                                    </td>
                                
                                    <td style="width:50%">
                                        <a target="blank" href="<?php echo $section->link_4?>">
                                            <div class="image" style="width:100%; height:auto; background-color:#53667c*;"><img style="width:100%" src="<?php echo base_url().'/assets/newsletter/'.$section->image_4?>" alt=""></div>
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
                    <?php endif; endforeach;?>
                            
                            
                    <!-- PROMOTED PRODUCTS -->
                    <?php if(isset($promoted_products) && sizeof($promoted_products) > 0):?>
                    <table align="center" style="background-color:#f1f1f1; width:650px; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px">
                        <thead style="background-color:black; text-align:center; color:white ">
                            <tr>
                                <th style="width:100%; padding:12px 0" colspan="3">Best offers</th>
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
                                <td style="width:23%;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:100%; height:250px; background-color:#e5e5e5; border-radius:8px;">
                                            <div style="height:70%; width:100%; ">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i]->image?>" style="margin:auto; width:120px; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:57%; width:100%;background-color:none">
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i]->product_id); ?>"><p style="margin:0; line-height:18px; font-size:14px; text-align:left;padding:5px;"><?php echo($promoted_products[$i]->name); ?></p></a>
                                                </div>
                                                <div style="height:42%; width:100%; background-color:none">

                                                    <?php if($productModel->get_discounted_percentage($promoted_products[$i]->product_id) > 0): ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($productModel->_discounted_price($promoted_products[$i]->product_id)); ?> AED</span>
                                                        <span style="text-decoration:line-through; margin:0 8px; color:#2c2c2c">
                                                        <?php echo($promoted_products[$i]->price); ?> AED
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($promoted_products[$i]->price); ?> AED</span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <?php endif;?>
                                                    
                                <?php if(key_exists(($i+1) , $promoted_products)):?>
                                <td style="width:23%;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:100%; height:250px; background-color:#e5e5e5; border-radius:8px">
                                            <div style="height:70%; width:100%; ">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i+1]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i+1]->image?>" style="margin:auto; width:120px; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:57%; width:100%;background-color:none">
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i+1]->product_id); ?>"><p style="margin:0; line-height:18px; font-size:14px; text-align:left;padding:5px;"><?php echo($promoted_products[$i+1]->name); ?></p></a>
                                                </div>
                                                <div style="height:42%; width:100%; background-color:none">

                                                    <?php if($productModel->get_discounted_percentage($promoted_products[$i+1]->product_id) > 0): ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($productModel->_discounted_price($promoted_products[$i+1]->product_id)); ?> AED</span>
                                                        <span style="text-decoration:line-through; margin:0 8px; color:#2c2c2c">
                                                        <?php echo($promoted_products[$i+1]->price); ?> AED
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($promoted_products[$i+1]->price); ?> AED</span>
                                                    <?php endif; ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                <?php endif;?>
                                                    
                                <?php if(key_exists(($i+2) , $promoted_products)):?>
                                <td style="width:23%;">
                                        <div class="image" style="border: solid #afafaf42 1px; width:100%; height:250px; background-color:#e5e5e5; border-radius:8px">
                                            <div style="height:70%; width:100%; ">
                                                <a target="blank" href="<?php echo(base_url()."/product/".$promoted_products[$i+2]->product_id); ?>"><img src="<?php echo base_url()?>/assets/uploads/<?php echo $promoted_products[$i+2]->image?>" style="margin:auto; width:120px; margin: auto"  alt=""></a>
                                            </div>
                                            <div style="padding:3px; height: 30%">
                                                <div style="height:57%; width:100%;background-color:none">
                                                    <a style="color:#343434" href="<?php echo(base_url()."/product/".$promoted_products[$i+2]->product_id); ?>"><p style="margin:0; line-height:18px; font-size:14px; text-align:left;padding:5px;"><?php echo($promoted_products[$i+2]->name); ?></p></a>
                                                </div>
                                                <div style="height:42%; width:100%; background-color:none">

                                                    <?php if($productModel->get_discounted_percentage($promoted_products[$i+2]->product_id) > 0): ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($productModel->_discounted_price($promoted_products[$i+2]->product_id)); ?> AED</span>
                                                        <span style="text-decoration:line-through; margin:0 8px; color:#2c2c2c">
                                                        <?php echo($promoted_products[$i+2]->price); ?> AED
                                                        </span>
                                                    <?php else: ?>
                                                        <span style="font-size:20px; font-weight:bold"><?php echo($promoted_products[$i+2]->price); ?> AED</span>
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
                    <table align="center" style="width:650px; height:auto; column-gap:10px; margin-top: 20px; border-collapse:separate; border-spacing:8px; border-radius:3px">
                        <tbody>
                            <tr></tr>
                            <tr>
                                <td style="height:auto; text-align:center; line-height:20px; padding:0; color:#363636" colspan="4">
                                    <p>
                                        <!--You're receiving this newsletter because you suscribed on <a target="blank" href="<?php echo(base_url())?>">ZGames</a> newsletter. <br>-->
                                        Tel: <?php echo $settings[0]->phone; ?> <br>
                                        Email: <?php echo $settings[0]->email; ?> <br>
                                        © <?php echo $settings[0]->business_name; ?> | Naif, Dubai.
                                        <!--<?php echo $settings[0]->address; ?>-->
                                    </p>
                                </td>
                            </tr>
                            <tr style=" background-color:#e5e5e5">
                                <td style="text-align: center">
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636" href="<?php echo $settings[0]->facebook; ?>">
                                        <!-- <svg style="vertical-align:top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                                           <path fill="none" d="M0 0h24v24H0z"></path>
                                           <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                                        </svg> -->
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_facebook.png" alt="">
                                    </a>
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636" href="<?php echo $settings[0]->instagram; ?>">
                                        <!-- <svg style="vertical-align:top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                                           <path fill="none" d="M0 0h24v24H0z"></path>
                                           <path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"></path>
                                        </svg> -->
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_instagram.png" alt="">
                                                    
                                    </a>
                                    <a style="text-decoration:none; margin:0 10px; fill:#363636" href="<?php echo $settings[0]->tiktok; ?>">
                                        <!-- <svg style="vertical-align:top" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="30" height="30">
                                            <path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122. 18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"></path>
                                        </svg> -->
                                        <img style="height:30px; vertical-align:middle; margin: 15px 0" src="<?php echo base_url() ?>/assets/uploads/ns_tiktok.png" alt="">
                                                    
                                    </a>
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
<!-- </div> -->


        