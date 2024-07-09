<?php 
     $sql="select * from cms";
     $cms=$userModel->customQuery($sql);
?>
<!-- avergreen freebie and exclusive banners -->
<!-- <div class="container-fluid bg-black pb-3">
    <div class="container p-0">
        <div class="row">
           
            <div class="col-lg-10 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[17]->heading;?></h3>
                </div>

                <div class="area_play_with_game ">
                    <div class="">
                        <div class="">
                            <a href="<?php echo $cms[17]->link;?>">
                                <div class="blog_boxx w-100">
                                    <img class="  w-100"
                                        src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[17]->image;?>" alt="">
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-lg-10 pt-3">
                <div class="heading">
                    <h3 class="text-white text-capitalize text-center"><?php echo $cms[18]->heading;?></h3>

                </div>
                <div class="area_play_with_game ">
                    <div class="">

                        <div class="">
                            <a href="<?php echo $cms[18]->link;?>">
                                <div class="blog_boxx w-100">
                                    <img class="  w-100"
                                        src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[18]->image;?>"
                                        alt="">
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
</div> -->

<div class="container-fluid d-flex-column home-sec">
    <!-- <div class="sec_title"><h2>hello world</h2></div> -->
    <div class="two-banners j-spacearound d-flex-row">
        <div class="banner d-flex-column">
            <div class="overlay_title"> 
                <h3><?php echo $cms[17]->heading;?></h3>
            </div>
            <!-- <a href="<?php echo $cms[17]->link;?>"><img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[17]->image;?>" alt=""></a> -->
                <a href="<?php echo $cms[17]->link;?>" style="height:100%;width:100%"><img src="<?php echo base_url();?>/assets/uploads/two_banners_b2.png" alt=""></a>
                <!-- <img src="<?php echo base_url();?>/assets/uploads/two_banners_b2.png" alt=""> -->

        </div>
        <div class="banner d-flex-column">
            <div class="overlay_title"><h3><?php echo $cms[18]->heading;?></h3></div>
            <!-- <a href="<?php echo $cms[18]->link;?>"><img src="<?php echo base_url();?>/assets/uploads/<?php echo $cms[18]->image;?>" alt=""></a> -->
                <a href="<?php echo $cms[18]->link;?>" style="height:100%;width:100%"><img src="<?php echo base_url();?>/assets/uploads/two_banners_b1.png" alt=""></a>
        </div>
        
        
    </div>
</div>