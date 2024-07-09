<?php include 'Common/Breadcrumb.php';?>

<div class="container pt-5 pb-5">

    <div class="title_heaeing">
        <h3><strong><?php echo @$cms[0]->heading;?></strong></h3>
    </div>
    <div class="body_desc">
        <?php if(@$cms[0]->image){ ?>
        <img src="<?php echo base_url();?>/assets/uploads/<?php echo @$cms[0]->image;?>">
        <?php } ?>
        <?php echo @$cms[0]->description;?>
          </div>
</div>