<?php 
  $l=1;
  $uri = service('uri'); 
  var_dump($_GET);
?>
<style>
td{
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  text-align: left;
  background-color: #fff!important;
  white-space: nowrap !important;
  vertical-align: middle !important;
  padding: 10px!important;
  background: white!important;
  border: 1px solid #dee2e694!important;
}
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
    <?php include 'Common/Breadcrumb.php';?>
    <div class="content-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-content  ">
              <div class="card-body">

                <!-- Filter Form -->
                <form>
                  <div class="row mb-10" style="margin-bottom: 15px;">
                    <div class="col-md-4">
                      <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" required name="start" value="<?php echo @$_GET['start']?>">
                    </div>
                    <div class="col-md-4">
                      <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" required name="end" value="<?php echo @$_GET['end']?>">
                    </div>
                    <div class="col-md-4">
                      <input type="submit" class="btn btn-primary" value="Filter">
                    </div>
                  </div>
                </form>
                <!-- Filter Form -->

                <!-- Data Display -->
                <table id="dateWiseOrder" class=" " style="width:100%; ">
                  <thead>
                    <tr>
                      <th>Sl.No.</th>
                      <th>Date</th>
                      <th>Product title</th>
                      <th>No. of pieces sold</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    if($orders && sizeof($orders) > 0) {
                      foreach($orders as $k=>$v){
                       
                     ?>
                    <tr>
                      <td> <?php echo $k+1;?> </td>
                      <td> <?php echo $v->order_date;?> </td>
                      <td> <?php echo $v->product_name;?> </td>
                      <td> <?php echo $v->total_qty ;?> </td>
                      <td> <?php echo bcdiv($v->total_sale, 1, 2);?> </td>
                    </tr>
                    <?php
                          }
                        }
                    ?>
                  </tbody>
                </table>
                <!-- Data Display -->


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>