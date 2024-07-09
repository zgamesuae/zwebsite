<?php
$uri = service('uri'); 
$userModel = model('App\Models\UserModel', false);
$sql="select * from master_category where     parent_id='0' order by precedence asc";
$master_category=$userModel->customQuery($sql);
?>   
<style>
.accordion-group .fa-image{margin-right:10px}.menu .accordion-heading{position:relative}.menu .accordion-heading .edit{position:absolute;top:8px;right:30px}.menu .area{border-left:4px solid #f38787}.menu .equipamento{border-left:4px solid #65c465}.menu .ponto{border-left:4px solid #98b3fa}.menu .collapse.in{overflow:visible}.accordion-inner{padding:9px 15px;border-top:1px solid #e5e5e5}.accordion-heading .accordion-toggle{display:block;padding:8px 15px}.accordion-toggle{cursor:pointer}.accordion-heading .accordion-toggle{display:block;padding:8px 15px}.menu .ponto{border-left:4px solid #98b3fa}.menu .accordion-heading{position:relative}.accordion-heading{border-bottom:0}.accordion-group{margin-bottom:2px;border:1px solid #e5e5e5;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px}.accordion{margin-bottom:20px}.menu .collapse.in{overflow:visible}
.form-section{
  margin-bottom: 20px;
  padding-bottom: 10px;
  letter-spacing: 1px;
  border-bottom: 1px solid #E4E5EC;
}
</style>
<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper">
   <?php include 'Common/Breadcrumb.php';?>
   <div class="content-body"><!-- Basic Tables start -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-content collapse show">
            <div class="card-body">
              <div class="card-header form-section row">
                <h4 class="col-md-10" style="margin: auto;">  Category List </h4>
                <a class="btn btn-primary mb-0 col-md-2" href="<?php echo base_url();?>/supercontrol/Category/add">Add Category</a>
              </div>
              <?php
              if(@$flashData['error']){
                ?>
                <div class="alert alert-danger alert-dismissible mb-2" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <strong>Oh snap!</strong>  <?php echo @$flashData['error'];?>
                </div>
                <?php  
              }
              ?>
              <?php
              if(@$flashData['success']){
                ?>
                <div class="alert alert-success alert-dismissible mb-2" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <strong>Success - </strong> <?php echo @$flashData['success'];?>
                </div>
                <?php  
              }
              ?>
              <!--Jagat H node start-->
              <div class="card-bodyy">
                <!-- <div id="treeview2" class=""></div> -->
                <!-- #####Accrodian Start######## -->
                <div class="span12">
                  <div class="menu">
                    <div class="accordion">
                      <!-- Áreas -->
                      <!-- ######loop Start -->
                      <?php 
                      if ($master_category) {
                        foreach ($master_category as $key => $value) {
                          ?>
                          <div class="accordion-group">
                            <!-- Área -->
                            <div class="accordion-heading area">
                              <a class="accordion-toggle" data-toggle="collapse" href=
                              "#area<?php echo $value->category_id;?>"><?php echo $value->category_name; ?></a>
                              <div class="dropdown edit">
                                <a class="dropdownn-toggle  " data-toggle=
                                "dropdown" href="#" style="font-style: italic"></a>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <a href="<?php echo base_url(); ?>/supercontrol/Category/edit/<?php echo $value->category_id; ?>"><i class=
                                  "la la-edit"></i> </a>
                                  <?php 
                                  $sql="select * from master_category where     parent_id='$value->category_id' order by precedence asc";
                                  $ex=$userModel->customQuery($sql);
                                  if ($ex) {
                                  }else{                                                          
                                    ?>
                                    <a style="color:red;" href="<?php echo base_url(); ?>/supercontrol/Category/delete/<?php echo $value->category_id; ?>"><i class=
                                      "la la-trash"></i> </a>
                                    <?php } ?>
                                  </div>
                                </div><!-- /Área -->
                                <div class="accordion-body collapse" id="area<?php echo $value->category_id;?>">
                                  <div class="accordion-inner">
                                    <!-- 2nd looop start -->
                                    <?php 
                                    $pid=$value->category_id;
                                    $sql="select * from master_category where  status='Active' and parent_id='$pid' order by precedence asc ";
                                    $master_category2=$userModel->customQuery($sql);
                                    if ($master_category2) {
                                      foreach ($master_category2 as $key2 => $value2) {
                                        ?>
                                        <div class="accordion" id="equipamento<?php echo $value2->category_id;?>">
                                          <!-- Equipamentos -->
                                          <div class="accordion-group">
                                            <div class="accordion-heading equipamento">
                                              <a class="accordion-toggle" data-parent=
                                              "#equipamento<?php echo $value2->category_id;?>" data-toggle="collapse" href=
                                              "#ponto<?php echo $value2->category_id; ?>"><?php echo $value2->category_name; ?></a>
                                              <div class="dropdown edit">
                                                <a class="dropdownn-toggle  " data-toggle=
                                                "dropdown" href="#" style="font-style: italic"></a>
                                                <a href="<?php echo base_url(); ?>/supercontrol/Category/edit/<?php echo $value2->category_id; ?>"><i class=
                                                  "la la-edit"></i> </a>
                                                  <?php 
                                                  $sql="select * from master_category where     parent_id='$value2->category_id' order by precedence asc";
                                                  $ex=$userModel->customQuery($sql);
                                                  if ($ex) {
                                                  }else{                                                          
                                                    ?>
                                                    <a style="color:red;" href="<?php echo base_url(); ?>/supercontrol/Category/delete/<?php echo $value2->category_id; ?>"><i class=
                                                      "la la-trash"></i> </a>
                                                    <?php } ?>
                                                  </div>
                                                </div><!-- Pontos -->
                                                <!-- ########Loop 3 Start  #######-->
                                                <?php 
                                                $pid2=$value2->category_id;
                                                $sql="select * from master_category where  status='Active' and parent_id='$pid2' order by precedence asc ";
                                                $master_category3=$userModel->customQuery($sql);
                                                if ($master_category3) {
                                                  ?>
                                                  <div class="accordion-body collapse" id="ponto<?php echo $value2->category_id; ?>">
                                                    <div class="accordion-inner">
                                                      <?php
                                                      foreach ($master_category3 as $key3 => $value3) {
                                                        ?>
                                                        <div class="accordion" id="servico<?php echo $value3->category_id;?>">
                                                          <div class="accordion-group">
                                                            <div class=
                                                            "accordion-heading ponto">
                                                            <a class="accordion-toggle" data-parent=
                                                            "#servico<?php echo $value3->category_id;?>" data-toggle="collapse" href="#servicoc<?php echo $value3->category_id;?>"> <?php echo $value3->category_name; ?></a>
                                                            <div class="dropdown edit">
                                                              <a class="dropdownn-toggle  " data-toggle=
                                                              "dropdown" href="#" style="font-style: italic"></a>
                                                              <a href="<?php echo base_url(); ?>/supercontrol/Category/edit/<?php echo $value3->category_id; ?>"><i class=
                                                                "la la-edit"></i> </a>
                                                                <?php 
                                                               $pid44= $value3->category_id;
                                                                $sql="select * from master_category where     parent_id='$pid44' order by precedence asc";
                                                                $ex=$userModel->customQuery($sql);
                                                                if ($ex) {
                                                                }else{                                                          
                                                                  ?>
                                                                  <a style="color:red;" href="<?php echo base_url(); ?>/supercontrol/Category/delete/<?php echo $value3->category_id; ?>"><i class=
                                                                    "la la-trash"></i> </a>
                                                                  <?php } ?>
                                                                </div>
                                                              </div>
                                                              <!-- Serviços -->
                                                              <!-- ########Loop 4 Start  #######-->
                                                              <?php 
                                                              $pid3=$value3->category_id;
                                                              $sql="select * from master_category where  status='Active' and parent_id='$pid3' order by precedence asc";
                                                              $master_category4=$userModel->customQuery($sql);
                                                              if ($master_category4) {
                                                                foreach ($master_category4 as $key4 => $value4) {
                                                                  ?>
                                                                  <div class=
                                                                  "accordion-body collapse" id="servicoc<?php echo $value3->category_id;?>">
                                                                  <div class="accordion-inner">
                                                                    <ul class="nav nav-list">
                                                                      <li>
                                                                        <a href=
                                                                        "#"><i class=
                                                                        "icon-chevron-right">
                                                                      </i> <?php echo $value4->category_name; ?></a>
                                                                    </li>
                                                                  </ul>
                                                                </div>
                                                              </div><!-- /Serviços -->
                                                            <?php }} ?>
                                                            <!-- END LOOP 4 -->
                                                          </div>
                                                        </div>
                                                        <!-- /Pontos -->
                                                      <?php }
                                                      ?>
                                                    </div>
                                                  </div>
                                                <?php } ?>
                                                <!-- END LOOP 3 -->
                                              </div><!-- /Equipamentos -->
                                            </div>
                                            <?php 
                                          }
                                        }
                                        ?>
                                        <!-- 2nd loop end -->
                                      </div>
                                    </div>
                                  </div>
                                  <?php 
                                }
                              }
                              ?>
                              <!-- #####LOOP END######## -->
                            </div><!-- /accordion -->
                          </div> 
                        </div>
                        <!-- #########Accrodian END############ -->
                      </div>
                      <!--jagat H NODE END-->
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