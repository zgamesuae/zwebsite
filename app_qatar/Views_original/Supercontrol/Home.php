<?php 
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri'); 
@$admin_id=$session->get('adminLoggedin');  
$sql="select * from admin where admin_id='$admin_id' ";
$adminDetail=$userModel->customQuery($sql);
$sql="select * from users where status='Active'";
$users=$userModel->customQuery($sql);


$sql="select * from users where status='Active'";
$users=$userModel->customQuery($sql);


$sql="select count(order_id) as od from orders where  order_status='Delivered' ";
$order=$userModel->customQuery($sql);


$sql="select sum(total) as total from orders where order_status='Delivered' AND payment_status='Paid'";
$sales=$userModel->customQuery($sql);


$sql="select count(product_id) as pro from products  where status='Active'";
$pro=$userModel->customQuery($sql);


$sql="select count(user_id) as users from users  where status='Active'";
$users=$userModel->customQuery($sql);

$sql="select * from orders order by created_at desc limit 10";
$roders=$userModel->customQuery($sql);


 
$sql="select count(order_id) as od from orders where  order_status='Submited' ";
$s=$userModel->customQuery($sql);

 


$sql="select count(order_id) as od from orders where  order_status='Confirmed' ";
$c=$userModel->customQuery($sql);

$sql="select count(order_id) as od from orders where  order_status='Out for delivery' ";
$o=$userModel->customQuery($sql);

$sql="select count(order_id) as od from orders where  order_status='Canceled' ";
$cc=$userModel->customQuery($sql);

 
?>


                                                    <!-- BEGIN: Content-->
                                                    <div class="app-content content">
                                                      <div class="content-overlay"></div>
                                                      <div class="content-wrapper">
                                                        <div class="content-header row">
                                                        </div>
                                                        <div class="content-body"><!-- eCommerce statistic -->
                                                          <div class="row">
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="info"><?php if(@$sales[0]->total) echo round(@$sales[0]->total);else echo 0;?></h3>
                                                                        <h6>Total Sales</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="la la-money-bill warning font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="warning"><?php if(@$order) echo @$order[0]->od;else echo 0;?></h3>
                                                                        <h6>Orders Delivered</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="la la-check-circle-o warning font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="success"><?php if(@$pro) echo @$pro[0]->pro;?></h3>
                                                                        <h6>Total Products</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="  la la-product-hunt  success font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="danger"><?php if(@$users) echo @$users[0]->users;?></h3>
                                                                        <h6>Total Customers</h6>
                                                                      </div>
                                                                      <div>
                                                                        <!--<i class="icon-heart danger font-large-2 float-right"></i>-->
                                                                         <i class=" la la-user danger font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          
                                                          
                                                            <div class="row">
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                          <h3 class="warning"><?php if(@$s[0]->od) echo @$s[0]->od;else echo 0;?></h3>
                                                                        <h6>Orders Submited</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="la la-check-circle  warning font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="warning"><?php if(@$c[0]->od) echo @$c[0]->od;else echo 0;?></h3>
                                                                        <h6>Orders Confirmed</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="la la-check-double warning font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="warning"><?php if(@$o[0]->od) echo @$o[0]->od;else echo 0;?></h3>
                                                                        <h6>Orders Shiped</h6>
                                                                      </div>
                                                                      <div>
                                                                        <i class="icon-basket-loaded  success font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-3 col-lg-6 col-12">
                                                              <div class="card pull-up">
                                                                <div class="card-content">
                                                                  <div class="card-body">
                                                                    <div class="media d-flex">
                                                                      <div class="media-body text-left">
                                                                        <h3 class="warning"><?php if(@$cc[0]->od) echo @$cc[0]->od;else echo 0;?></h3>
                                                                        <h6>Orders Canceled</h6>
                                                                      </div>
                                                                      <div>
                                                                        <!--<i class="icon-heart danger font-large-2 float-right"></i>-->
                                                                         <i class="la la-window-close  danger font-large-2 float-right"></i>
                                                                      </div>
                                                                    </div>
                                                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                      <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          
                                                          <!--/ eCommerce statistic -->
                                                          <!-- Products sell and New Orders -->
                                                        <!--  <div class="row match-height">
                                                            <div class="col-xl-8 col-12" id="ecommerceChartView">
                                                              <div class="card card-shadow">
                                                                <div class="card-header card-header-transparent py-20">
                                                                  <div class="btn-group dropdown">
                                                                    <a href="#" class="text-body dropdown-toggle blue-grey-700" data-toggle="dropdown">PRODUCTS SALES</a>
                                                                    <div class="dropdown-menu animate" role="menu">
                                                                      <a class="dropdown-item" href="#" role="menuitem">Sales</a>
                                                                      <a class="dropdown-item" href="#" role="menuitem">Total sales</a>
                                                                      <a class="dropdown-item" href="#" role="menuitem">profit</a>
                                                                    </div>
                                                                  </div>
                                                                  <ul class="nav nav-pills nav-pills-rounded chart-action float-right btn-group" role="group">
                                                                    <li class="nav-item"><a class="active nav-link" data-toggle="tab" href="#scoreLineToDay">Day</a></li>
                                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToWeek">Week</a></li>
                                                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#scoreLineToMonth">Month</a></li>
                                                                  </ul>
                                                                </div>
                                                                <div class="widget-content tab-content bg-white p-20">
                                                                  <div class="ct-chart tab-pane active scoreLineShadow" id="scoreLineToDay"></div>
                                                                  <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToWeek"></div>
                                                                  <div class="ct-chart tab-pane scoreLineShadow" id="scoreLineToMonth"></div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-12">
                                                              <div class="card">
                                                                <div class="card-header">
                                                                  <h4 class="card-title">New Orders</h4>
                                                                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                                  <div class="heading-elements">
                                                                    <ul class="list-inline mb-0">
                                                                      <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                                    </ul>
                                                                  </div>
                                                                </div>
                                                                <div class="card-content">
                                                                  <div id="new-orders" class="media-list position-relative">
                                                                    <div class="table-responsive">
                                                                      <table id="new-orders-table" class="table table-hover table-xl mb-0">
                                                                        <thead>
                                                                          <tr>
                                                                            <th class="border-top-0">Product</th>
                                                                            <th class="border-top-0">Customers</th>
                                                                            <th class="border-top-0">Total</th>                                
                                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                          <tr>
                                                                            <td class="text-truncate">iPhone X</td>
                                                                            <td class="text-truncate p-1">
                                                                              <ul class="list-unstyled users-list m-0">                                               
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-19.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-18.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-17.png" alt="Avatar">
                                                                                </li>
                                                                                <li class="avatar avatar-sm">                                            
                                                                                  <span class="badge badge-info">+4 more</span>
                                                                                </li>
                                                                              </ul>
                                                                            </td>
                                                                            <td class="text-truncate">$8999</td>                                
                                                                          </tr>
                                                                          <tr>
                                                                            <td class="text-truncate">Pixel 2</td>
                                                                            <td class="text-truncate p-1">
                                                                              <ul class="list-unstyled users-list m-0">                                               
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Alice Scott" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-16.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Charles Miller" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-15.png" alt="Avatar">
                                                                                </li>
                                                                              </ul>
                                                                            </td>
                                                                            <td class="text-truncate">$5550</td>                                
                                                                          </tr>
                                                                          <tr>
                                                                            <td class="text-truncate">OnePlus</td>
                                                                            <td class="text-truncate p-1">
                                                                              <ul class="list-unstyled users-list m-0">                                               
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Christine Ramos" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-11.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Thomas Brewer" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-10.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Alice Chapman" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-9.png" alt="Avatar">
                                                                                </li>
                                                                                <li class="avatar avatar-sm">                                            
                                                                                  <span class="badge badge-info">+3 more</span>
                                                                                </li>
                                                                              </ul>
                                                                            </td>
                                                                            <td class="text-truncate">$9000</td>                                
                                                                          </tr>
                                                                          <tr>
                                                                            <td class="text-truncate">Galaxy</td>
                                                                            <td class="text-truncate p-1">
                                                                              <ul class="list-unstyled users-list m-0">                                               
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Ryan Schneider" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-14.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Tiffany Oliver" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-13.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joan Reid" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-12.png" alt="Avatar">
                                                                                </li>
                                                                              </ul>
                                                                            </td>
                                                                            <td class="text-truncate">$7500</td>                                
                                                                          </tr>                            
                                                                          <tr>
                                                                            <td class="text-truncate">Moto Z2</td>
                                                                            <td class="text-truncate p-1">
                                                                              <ul class="list-unstyled users-list m-0">                                               
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Kimberly Simmons" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-8.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Willie Torres" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-7.png" alt="Avatar">
                                                                                </li>
                                                                                <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Rebecca Jones" class="avatar avatar-sm pull-up">
                                                                                  <img class="media-object rounded-circle" src="<?php echo base_url();?>/admin-assets/images/portrait/small/avatar-s-6.png" alt="Avatar">
                                                                                </li>
                                                                                <li class="avatar avatar-sm">                                            
                                                                                  <span class="badge badge-info">+1 more</span>
                                                                                </li>
                                                                              </ul>
                                                                            </td>
                                                                            <td class="text-truncate">$8500</td>                                
                                                                          </tr>                                                    
                                                                        </tbody>
                                                                      </table>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>-->
                                                          <!--/ Products sell and New Orders -->
                                                          <!-- Recent Transactions -->
                                                          <div class="row">
                                                            <div id="recent-transactions" class="col-12">
                                                              <div class="card">
                                                                <div class="card-header">
                                                                  <h4 class="card-title">Recent Orders</h4>
                                                                  <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                                                  
                                                                </div>            
                                                                <div class="card-content">                
                                                                  <div class="table-responsive">
                                                                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                                                                      <thead>
                                                                        <tr>
                                                                                                         
                                                                          <th class="border-top-0">Order ID</th>
                                                                          <th class="border-top-0">Customer Name</th>
                                                                          <th class="border-top-0">phone</th>
                                                                         
                                                                          <th class="border-top-0">payment_method</th>
                                                                           <th class="border-top-0">payment_status</th>
                                                                            <th class="border-top-0">order_status</th>
                                                                          <th class="border-top-0">Total</th>
                                                                        </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                          
                                                                          <?php if($roders){
                                                                          foreach($roders as $k=>$v){
                                                                          ?>
                                                                          
                                                                        <tr>
                                                                         
                                                                          <td class="text-truncate"><a target="_blank" href="<?php echo base_url();?>/invoice/<?php echo  ($v->order_id);?>"><?php echo  ($v->order_id);?></a></td>
                                                                          <td class="text-truncate">
                                                                            
                                                                            <span><?php echo  ($v->name);?></span>
                                                                          </td>  <td class="text-truncate">
                                                                            
                                                                            <span><?php echo  ($v->phone);?></span>
                                                                          </td>
                                                                          
                                                                          
                                                                           <td class="text-truncate"><?php echo  ($v->payment_method);?></td>
                                                                            <td class="text-truncate"><?php echo  ($v->payment_status);?></td>
                                                                          
                                                                          
                                                                          <td>
                                                                            <a type="button" href="<?php echo base_url();?>/supercontrol/Orders#/edit/<?php echo  ($v->order_id);?>" class="btn btn-sm
                                                                            
                                                                            <?php if($v->order_status=="Submited") echo 'btn-outline-danger';?>
                                                                            <?php if($v->order_status=="Confirmed") echo 'btn-outline-warning ';?>
                                                                            <?php if($v->order_status=="Out for delivery") echo 'btn-outline-info';?>
                                                                             <?php if($v->order_status=="Canceled") echo 'btn-outline-secondary';?>
                                                                            <?php if($v->order_status=="Delivered") echo 'btn-outline-success';?> round">
                                                                                <?php echo  ($v->order_status);?></a>
                                                                          </td>
                                                                         
                                                                          <td class="text-truncate"><?php echo number_format($v->total);?> AED </td>
                                                                        </tr>
                                                                        <?php }} ?>
                                                                       
                                                                      </tbody>
                                                                    </table>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                                                          <!--/ Recent Transactions -->
                                                          <!--Recent Orders & Monthly Sales -->
                                                     <!--     <div class="row match-height">
                                                            <div class="col-xl-8 col-lg-12">
                                                              <div class="card">
                                                                <div class="card-content ">
                                                                  <div id="cost-revenue" class="height-250 position-relative"></div>
                                                                </div>
                                                                <div class="card-footer">
                                                                  <div class="row mt-1">
                                                                    <div class="col-3 text-center">
                                                                      <h6 class="text-muted">Total Products</h6>
                                                                      <h2 class="block font-weight-normal">18.6 k</h2>
                                                                      <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-3 text-center">
                                                                      <h6 class="text-muted">Total Sales</h6>
                                                                      <h2 class="block font-weight-normal">64.54 M</h2>
                                                                      <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-3 text-center">
                                                                      <h6 class="text-muted">Total Cost</h6>
                                                                      <h2 class="block font-weight-normal">24.38 B</h2>
                                                                      <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-3 text-center">
                                                                      <h6 class="text-muted">Total Revenue</h6>
                                                                      <h2 class="block font-weight-normal">36.72 M</h2>
                                                                      <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <div class="col-xl-4 col-lg-12">
                                                              <div class="card">
                                                                <div class="card-content">
                                                                  <div class="card-body sales-growth-chart">
                                                                    <div id="monthly-sales" class="height-250"></div>
                                                                  </div>
                                                                </div>
                                                                <div class="card-footer">
                                                                  <div class="chart-title mb-1 text-center">
                                                                    <h6>Total monthly Sales.</h6>
                                                                  </div>
                                                                  <div class="chart-stats text-center">
                                                                    <a href="#" class="btn btn-sm btn-danger box-shadow-2 mr-1">Statistics <i class="ft-bar-chart"></i></a> <span class="text-muted">for the last year.</span>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>-->
                                                          <!--/Recent Orders & Monthly Sales -->
                                                         
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- END: Content-->
                                                    
                     
                    <div class="sidenav-overlay"></div>
                    <div class="drag-target"></div>
                