<div class="container-fluid bg-dark newletter_subscription pt-4 pb-4 text-capitalize" id="ns_sub_bar" <?php content_from_right() ?>>
    <div class="container p-0">
        <div class="row">
            <div class="col-md-8 mt-2">
                <div class="heading">
                    <h3 class="text-white <?php text_from_right() ?> "><?php echo lg_get_text("lg_15")?></h3>
                </div>
            </div>
            <div class="col-md-4 mt-2">
                <?php if(@$flashData['ns-sub-success'] && true){?>
                    <p style="font-size:.9rem;margin-bottom: 0; padding-bottom: 10px; color: #fff; font-weight: 500;color:#66ff8b"><?php echo $flashData['ns-sub-success'];?></p>
                <?php } else if($flashData["ns-sub-failure"]):?>
                    <p style="font-size:.9rem;margin-bottom: 0; padding-bottom: 10px; color: #fff; font-weight: 500;color:#ff6666"><?php echo $flashData['ns-sub-failure'];?></p>
                <?php endif; ?>
                <form method="post" class="d-flex" action="<?php echo base_url();?>/page/newsletter">
                    <input type="email" placeholder="<?php echo lg_get_text("lg_17") ?>" required name="email">
                    <button type="submit" class="btn btn-primary"><?php echo lg_get_text("lg_16") ?></button>
                </form>
            </div>
        </div>
    </div>
</div>