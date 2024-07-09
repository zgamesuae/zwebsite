<?php include 'Common/Breadcrumb.php';?>

<div class="container pt-5 pb-5 <?php text_from_right() ?>" <?php content_from_right() ?>>

    <div class="title_heaeing">
        <h3><strong><?php lg_put_text(@$cms[0]->heading , @$cms[0]->arabic_heading) ?></strong></h3>
    </div>
    <div class="body_desc">
        <?php if(@$cms[0]->image){ ?>
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$cms[0]->image;?>">
        <?php } ?>
        <?php lg_put_text(@$cms[0]->description , @$cms[0]->arabic_description);?>
          </div>
</div>