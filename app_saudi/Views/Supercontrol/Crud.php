<?php
  $session = session();
   $uri = service('uri'); 
   ?>
<style>
  .ck-jagat {
    width: 20px !important;
    height: 20px !important
  }

  .gc-caption-title {
    width: 102%;
    margin-left: -10px;
    top: 0;
    margin-top: -10px
  }

  .card-body {
    padding: 10px
  }

  .gc-container .panel-default {
    border: unset
  }

  .gc-theme-bootstrap-v4 .gc-pagination .page-number-input {
    height: 33px
  }

  .gc-data-container-text {
    color: #212529
  }

  .gc-container .table td,
  .table th {
    padding: .7rem
  }

  .breadcrumb .breadcrumb-item+.breadcrumb-item::before {
    content: "/"
  }

  @media (min-width:768px) {

    .gc-error-modal-dialog,
    .gc-modal-dialog {
      width: 60% !important;
      min-width: 400px !important
    }
  }

  .modal-open .modal {
    background: #0000007a
  }

  .gc-modal-body {
    overflow-x: hidden;
    overflow-y: scroll
  }
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">

    <!-- Dissmissable alerts -->
    <?php if(sizeof($session->getFlashdata()) > 0): 
    ?>
      <?php foreach($session->getFlashdata() as $key => $msg): ?>
      <div class="alert <?php if($key == "Error") echo 'alert-warning'; else echo 'alert-success' ?> alert-dismissible fade show" role="alert">
        <strong><?php echo $key ?></strong> <?php echo $msg ?>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
    <!-- Dissmissable alerts -->

    <div class="content-header row align-content-center">
      <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
        <div class="row breadcrumbs-top d-inline-block">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>/<?php echo $uri->getSegment(1);?>">Home</a>
              </li>
              <?php  if ($uri->getSegment(2)){?>
              <li class="breadcrumb-item"><a
                  href="<?php echo base_url();?>/<?php echo $uri->getSegment(1);?>/<?php echo $uri->getSegment(2);?>">
                  <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', $uri->getSegment(2));?>
                </a></li>
              <?php } ?>
              <?php  if ($uri->getSegment(3)=="index"  && $uri->getSegment(4)!=""){?>
              <li class="breadcrumb-item"><a>
                  <?php echo  preg_replace('/(?<!\ )[A-Z]/', ' $0', $uri->getSegment(4));?>
                </a></li>
              <?php } ?>
              <?php  ?>
            </ol>
          </div>
        </div>
      </div>
      <?php if($uri->getSegment(3) == "ezpin"): ?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <a class="btn btn-outline-dark r20" href="<?php echo base_url();?>/supercontrol/products/update_codes" role="button" target="" onclick="event.preventDefault();ws_confirm_operation($(this))">
            <i class="fa-solid fa-arrows-rotate"></i><span>&nbsp;Update EZPIN List</span>
          </a>
        </div>
      </div>
      <?php endif; ?>
      <?php  if ($uri->getSegment(3)=="freebie" ){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <a class="btn btn-outline-dark r20" href="<?php echo base_url();?>/supercontrol/Listings/addFreebie"
            role="button" target=""><i class="fa fa-plus"></i><span>&nbsp;Add freebie</span></a>
        </div>
      </div>
      <?php } ?>

      <?php  if ($uri->getSegment(3)=="couponSent"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <a class="btn btn-outline-dark r20" data-toggle="modal" data-target="#sendCoupon"
            href="javascript:void(0);"><i class="fa fa-plus"></i><span>&nbsp;Send Coupon</span></a>
        </div>
      </div>
      <?php } ?>

      <?php  if ($uri->getSegment(3)=="addFreebie"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <button onClick="submitFreebieSelection();" class="btn btn-outline-dark r20" role="button" target=""><i
              class="fa  fa-paper-plane"></i><span>&nbsp;Submit Freebie Selection</span></button>
        </div>
      </div>
      <?php } ?>
      <?php  if ($uri->getSegment(3)=="exclusive"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <a class="btn btn-outline-dark r20" href="<?php echo base_url();?>/supercontrol/Listings/addExclusive"
            role="button" target=""><i class="fa fa-plus"></i><span>&nbsp;Add exclusive</span></a>
        </div>
      </div>
      <?php } ?>
      <?php  if ($uri->getSegment(3)=="addExclusive"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <button onClick="submitExclusiveSelection();" class="btn btn-outline-dark r20" role="button" target=""><i
              class="fa  fa-paper-plane"></i><span>&nbsp;Submit Exclusive Selection</span></button>
        </div>
      </div>
      <?php } ?>
      <?php  if ($uri->getSegment(3)=="evergreen"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <a class="btn btn-outline-dark r20" href="<?php echo base_url();?>/supercontrol/Listings/addEvergreen"
            role="button" target=""><i class="fa fa-plus"></i><span>&nbsp;Add evergreen</span></a>
        </div>
      </div>
      <?php } ?>
      <?php  if ($uri->getSegment(3)=="addEvergreen"){?>
      <div class="content-header-right col-md-6 col-12">
        <div class="btn-group float-md-right">
          <button onClick="submitEvergreenSelection();" class="btn btn-outline-dark r20" role="button" target=""><i
              class="fa  fa-paper-plane"></i><span>&nbsp;Submit Evergreen Selection</span></button>
        </div>
      </div>
      <?php } ?>
    </div>
    <div class="content-body"><!-- Basic Tables start -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-content collapse show">
              <div class="card-body" id="pr_list">
                <?php echo $output; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Basic Tables end -->
    </div>
  </div>
</div>
<!-- END: Content-->