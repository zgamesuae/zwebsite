<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
    <div class="row breadcrumbs-top d-inline-block">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo base_url();?>/<?php echo $uri->getSegment(1);?>">Home</a></li>
          <?php  if ($uri->getSegment(2)){?>
          <li class="breadcrumb-item"><a  href="<?php echo base_url();?>/<?php echo $uri->getSegment(1);?>/<?php echo $uri->getSegment(2);?>">
              <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', $uri->getSegment(2));?>
            </a></li>
          <?php } ?>

          <?php  if ($uri->getSegment(3)=="index"  && $uri->getSegment(4)!=""){?>
          <li class="breadcrumb-item"><a>
              <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', $uri->getSegment(4));?>
            </a></li>
          <?php } ?>
          <?php  ?>




          <?php  if (count($uri->getSegments())>2){ ?>
          <li class="breadcrumb-item"><a>
              <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', ucwords($uri->getSegment(3)));?>
              <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', ucwords($uri->getSegment(2)));?>
            </a></li>
          <?php } ?>
        </ol>
      </div>
    </div>
  </div>
</div>