<style>
  .slidecontainer {
      width: 100%
  }

  .sliderr {
      -webkit-appearance: none;
      appearance: none;
      width: 100%;
      height: 25px;
      background: #d3d3d3;
      outline: 0;
      opacity: .7;
      -webkit-transition: .2s;
      transition: opacity .2s
  }

  .sliderr:hover {
      opacity: 1
  }

  .sliderr::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 25px;
      height: 25px;
      background: #04aa6d;
      cursor: pointer
  }

  .sliderr::-moz-range-thumb {
      width: 25px;
      height: 25px;
      background: #04aa6d;
      cursor: pointer
  }

  .filter_btns a {
      width: 100%;
      text-align: center
  }

  .filter_btns {
      padding: 15px 0
  }

  @media screen and (max-width:600px) {
      .bg-light {
          background-color: #efefef !important
      }

      p-10px {
          padding: 3px 6px !important;
          margin-bottom: 3px !important
      }

      .pricing-card .card-text {
          font-size: 21px
      }

      .product_box_content {
          /* padding: 4px 4px */
      }

      .product_qty {
          display: none
      }

      form.products_add_to_cart button {
          height: unset
      }

      form.products_add_to_cart a {
          width: unset;
          padding: 7px 3px
      }

      form.products_add_to_cart button {
          font-size: 12px !important
      }

      .product_box_image .product_label_offer {
          left: 7px
      }

      .outer_container_div {
          overflow-x: hidden
      }
  }

  .drop_down_sort_by_option {
      z-index: 9 !important
  }

  .drop_down_sort_by_option::after {
      left: 75%
  }

  @media only screen and (max-width:600px) {
      .drop_down_sort_by_option::after {
          left: 14px
      }
  }
</style>

<?php
$session = session();
$userModel = model('App\Models\UserModel', false);
$cat_model=model('App\Models\Category');
$p_model=model('App\Models\ProductModel');

// var_dump($cat_model->_getcategories()[3]["playstation-1634548926"]["level2"]);
// var_dump($cat_model->categories_urls());
// $filters = $data;
$filters = $data;
// var_dump($data);die();
// $category=$data["category"];
$category=$data["category"];

// $uri = service('uri');
@$user_id = $session->get('userLoggedin');
if (@$user_id) {
    $sql = "select * from users where user_id='$user_id'";
    $userDetails = $userModel->customQuery($sql);
}

// get settings
$cid = "";
$sql = "select * from settings";
$settings = $userModel->customQuery($sql);

// get cms
$sql = "select * from cms";
$cms = $userModel->customQuery($sql);

$sql1 = "";
$uri1 = $uri2 = $uri3 = "";
$request = \Config\Services::request();
// var_dump($data);
// die();
// if ($cid = @$category) {
if ($cid = $category) {
    $sql1 = "  ";
    $sql1 = "select * from master_category where parent_id='$cid'";
    $cat2 = $userModel->customQuery($sql1);
}


// By type
$sql = "select type_id,title,count(product_id) as c from type inner join products on type.type_id=products.type ";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by type.type_id";
// echo($sql);
// die();

@$type = $userModel->customQuery($sql);

// By brand
$sql = "select id,title,count(product_id) as c from brand inner join products on brand.id=products.brand ";
$sql.= $p_model->filter($filters);
$sql = $sql . "  group by brand.id";
// echo($sql);die();
@$brand = $userModel->customQuery($sql);

// By suitable for
$sql = " select id,title,count(product_id) as c  from suitable_for inner join products on suitable_for.id=products.suitable_for ";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by suitable_for.id ";
@$suitable_for = $userModel->customQuery($sql);


// By genre
$sql = " select id,title,count(product_id) as c  from color inner join products on  FIND_IN_SET(color.id , products.color) ";
$sql.=$p_model->filter($filters);
if($data["genre"])
$sql.= " AND color.id='".$data["genre"]."'";
$sql = $sql . "  group by color.id ";
@$color = $userModel->customQuery($sql);


// By Age
$sql = " select id,title,count(product_id) as c  from age inner join products on age.id=products.age ";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by age.id ";
@$age = $userModel->customQuery($sql);


// By category
$sql = "select category_id,category_name,count(product_id) as c from master_category inner join products on master_category.category_id=products.category";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by master_category.category_id";

@$LeftCat = $userModel->customQuery($sql);

// echo($sql);
// die();
// var_dump($this->uri);
?>


<div class="container-fluid bg-lightt p-0">
    <?php include 'Common/Breadcrumb.php';?>
    <div class="container outer_container_div pb-5 col-sm-12 col-md-12 col-lg-12">
        <div class="m-10px row">
                        <!--     <div class="p-10px col-md-12 mt-3">
            <div class="col-xs-12 ry-pg-title rounded overflow-hidden" style="background-image: url('img/notfound.jpg'); background-size: cover;">
            <div class="col-xs-12 ry-container" style="position: relative;"><div>
            <h1 class="ry-responsive-title"><strong>Super Savings!</strong></h1>
            </div>
            </div>
            </div>
              </div> -->
            <div class="p-10px col-lg-3 mb-2 ">
               
                <div class="product_filter rounded bg-white shadow-none ">
                    <form action="<?php echo base_url();?>/page/getSearchData" method="post" id="getsearchform">
                        <h4 class="pt-3 pb-0 d-block d-lg-none "><strong>Filter </strong>
                            <div class="close_serach_products">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path
                                        d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z">
                                    </path>
                                </svg>
                            </div>
                        </h4>
                        <div class="filter_btns">
                            <a href="<?php echo base_url();?>/product-list?category=<?php echo @@$category?>" class="JagatFilterInput">clear all filter</a>
                        </div>
                        <!--     <div class="filter_header border-bottom">search component
                          <div class="serach_fomr_input">
                          <input type="text" name="searchpro" id="seacrh_pro" placeholder="search..">
                          </div>
                          </div>-->
                        <input name="showOffer" id="showOffer" type="hidden" value="<?php echo @@$data['show-offer'];?>">
                        <input name="short" id="short" type="hidden" value="<?php echo @@$data['short'];?>">
                        <input name="keyword" id="keyword" type="hidden" value="<?php echo @@$data['keyword'];?>">
                        <input name="master_category" id="master_category" type="hidden" value="<?php echo @$cid;?>">
                        <?php if($cid){ ?>
                        <?php if(false){ ?>

                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Categories</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display: none;">
                                <div class="multilavel_drop_down">
                                    <ul>
                                        <?php 
                                              foreach($LeftCat as $k=>$v){
                                                 // categorylist start
                                                if ($cid2=$v->category_id) {
                                                               $sql2="select * from master_category where parent_id='$cid2'";
                                                               $mcat=$userModel->customQuery($sql2); 
                                                               if($mcat){
                                                                $sql="select category_id,category_name,count(product_id) as c from master_category  
                                                                inner join products on master_category.category_id=products.category
                                                                where";
                                                               /* foreach($mcat as $km=>$mv){
                                                                 $lcat=$mv->category_id;
                                                                 if($km==count($mcat)-1){
                                                                   $sql=$sql."       products.category='$lcat'   ";   
                                                                 }else{
                                                                   $sql=$sql."       products.category='$lcat' OR ";     
                                                                 }
                                                               }*/
                                                             
                                                             
                                                             
                                                             
                                                     $Fla=0;$brandFlag=0;
                                                    //  $sql=$sql." AND (";
                                                  $sql=$sql." FIND_IN_SET('$cid2', products.category) OR ( "; 
                                                  foreach($mcat as $km=>$mv){
                                                        $scats=$mv->category_id;
                                                  
                                                         if($brandFlag==1){
                                                              $sql=$sql."  OR  FIND_IN_SET('$mv->category_id', products.category)      ";$brandFlag=0;
                                                         }else{
                                                              $sql=$sql."    FIND_IN_SET('$mv->category_id', products.category)    OR ";
                                                         }
                                                       
                                                       
                                                        $sql2="select * from master_category where parent_id='$scats'";
                                                        $ssmcat=$userModel->customQuery($sql2); 
                                                        if($ssmcat){
                                                         $Fla=1;
                                                         foreach($ssmcat as $sbk=>$sbv){
                                                          $lcat2=$sbv->category_id;
                                                          if($sbk==count($ssmcat)-1){
                                                              $brandFlag=1;
                                                           $sql=$sql."    FIND_IN_SET('$lcat2', products.category)      ";   
                                                         }else{
                                                           $sql=$sql."    FIND_IN_SET('$lcat2', products.category)    OR ";     
                                                         }
                                                       }
                                                     }else{
                                                      $lcat=$mv->category_id;
                                                      if($km==count($mcat)-1){
                                                        $sql=$sql."  FIND_IN_SET('$lcat', products.category)         ";   
                                                      }else{
                                                        if($Fla==1){$Fla==0;
                                                         $sql=$sql." OR FIND_IN_SET('$lcat', products.category)      OR ";
                                                       }else{
                                                         $sql=$sql."  FIND_IN_SET('$lcat', products.category)      OR "; 
                                                       }
                                                     }
                                                    }
                                                  }
                                                  $sql=$sql." ) ";
                                                
                                                            $sql=$sql."group by master_category.category_id";
                                                          }
                                                          else{
                                                           $sql="select category_id,category_name,count(product_id) as c from master_category inner join products on master_category.category_id=products.category where FIND_IN_SET('$cid2', products.category) group  group by master_category.category_id";
                                                         }
                                                }
                                                else{
                                                   $sql="select category_id,category_name,count(product_id) as c from master_category inner join products on master_category.category_id=products.category";
                                                   if ($keyword=@$data['keyword']) {
                                                     $sql=$sql."   where  products.name like '%$keyword%'  ";
                                                   } 
                                                 
                                                    if ($t=@$data['type']) {
                                                      $sql=$sql." where FIND_IN_SET($t , products.type) ";
                                                    }
                                                  
                                                  
                                                  $sql=$sql." group by master_category.category_id";
                                                }
                                                @$LeftCat2=$userModel->customQuery($sql);
                                                  // categorylist end
                                                       ?>
                                        <li data_open_id="open_drop_down_32">
                                            <label class="checkbox_label"><?php echo $v->category_name;?>
                                                <!--(<?php echo $v->c;?>)-->
                                                <input <?php if(@@$category== $v->category_id) echo 'checked';?>
                                                    type="checkbox" class="JagatFilterInput" id="categoryList"
                                                    value="<?php echo $v->category_id;?>" name="categoryList">
                                                <span class="checkmark"></span>
                                            </label>
                                            <div class="drop_down_ion"></div>
                                        </li>
                                        <?php
                                                          if($LeftCat2){
                                                            foreach($LeftCat2 as $k2=>$v2){  
                                                        ?>
                                        <div id="open_drop_down_32">
                                            <ul>
                                                <li>
                                                    <label class="checkbox_label"><?php echo $v2->category_name;?>
                                                        <!--(<?php echo $v2->c;?>)-->
                                                        <input
                                                            <?php if(@@$category== $v2->category_id) echo 'checked';?>
                                                            type="checkbox" class="JagatFilterInput" id="categoryList"
                                                            value="<?php echo $v2->category_id;?>" name="categoryList">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                                               }
                                                           }
                                              }
                                         ?>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <?php } }?>
                        <?php  if($type){ ?>

                        <!-- Type -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Type</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['type']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php
                                      foreach($type as $k=>$v){
                                    ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->title;?>
                                            <!--(<?php echo $v->c;?>)-->
                                            <!-- <input <?php if(@@$data['type']== $v->type_id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="type" value="<?php echo $v->type_id;?>" name="type"> -->
                                            <input <?php if(in_array($v->type_id , explode("," , @@$data['type']))) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="type" value="<?php echo $v->type_id;?>" name="type">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>

                        <?php   if($brand){?>
                           <!-- Brands -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Brands</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['brand']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php
                                      foreach($brand as $k=>$v){
                                    ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->title;?>
                                            <!--(<?php echo $v->c;?>)-->
                                            <input <?php if(@@$data['brand']==$v->id) echo 'checked';?> type="checkbox"
                                                class="JagatFilterInput" id="brand" value="<?php echo $v->id;?>"
                                                name="brand">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>

                        <?php 
                          if($age){
                        ?>
                         <!-- Age -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Age</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['age']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php
                                      foreach($age as $k=>$v){
                                    ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->title;?>
                                            <!--(<?php echo $v->c;?>)-->
                                            <input type="checkbox" class="JagatFilterInput" id="age"
                                                value="<?php echo $v->id;?>" name="age">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <?php   if($suitable_for){?>

                        <!-- Suitable for -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Suitable for</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['suitable_for']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php
                                      foreach($suitable_for as $k=>$v){
                                    ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->title;?>
                                            <!--(<?php echo $v->c;?>) -->
                                            <input type="checkbox" <?php if($v->id == $data["suitable_for"]): echo "checked"; endif;?> class="JagatFilterInput" id="suitable_for" value="<?php echo $v->id;?>" name="suitable_for">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        
                        <?php 
                        } 
                        if($color){  
                        ?>
                         <!-- Genre -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Genre</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['genre']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php foreach($color as $k=>$v){ ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->title;?>
                                            <!--(<?php echo $v->c;?>) -->
                                            <input <?php if(@@$data['genre']==$v->id){ echo 'checked'; echo(" disabled");}?> type="checkbox" class="JagatFilterInput" id="color" value="<?php echo $v->id;?>" name="color">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>

                        <!-- offer filter -->
                        <?php

                          if ($cid) {
                            $sql2="select * from master_category where parent_id='$cid'";
                            $mcat=$userModel->customQuery($sql2); 
                            if($mcat){  
                               $sql="   select discount_percentage,count(product_id) as c from products where  discount_percentage>0 AND  status= 'Active' and (";
                               foreach($mcat as $km=>$mv){
                                $lcat=$mv->category_id;
                                if($km==count($mcat)-1){
                                  $sql=$sql." category='$lcat' ";   
                                }else{
                                  $sql=$sql." category='$lcat' OR ";     
                                }
                              }
                              $sql=$sql." ) group by discount_percentage";
                            } 
                          }

                          else{
                            $sql=" select discount_percentage,count(product_id) as c from products where";
                            if ($keyword=@$data['keyword']) {
                              $sql=$sql."     products.name like '%$keyword%'  AND  ";
                            }
                            if ($t=@$data['type']) {
                              $sql=$sql."      where    FIND_IN_SET($t , products.type)   ";
                            }
                            $sql=$sql."discount_percentage>0 AND  status= 'Active'  group by discount_percentage";
                          }
                          $dis=$userModel->customQuery($sql); 
                          if($dis){
                        ?>
                        <!-- Offer -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Offer</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['offer']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <?php
                                      foreach($dis as $k=>$v){
                                    ?>
                                    <li>
                                        <label class="checkbox_label"><?php echo $v->discount_percentage;?>
                                            <!--(<?php echo $v->c;?>) -->
                                            <input <?php if(@@$data['offer']!="" && @@$data['offer']==$v->discount_percentage) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="offer" value="<?php echo $v->discount_percentage;?>" name="offer">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <?php ?>

                         <!-- price -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Price</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['priceupto']) echo 'block';else echo 'none'?>;">
                                <div class="slidecontainer">
                                    <input type="range" min="25" max="45000" class="sliderr JagatFilterInput"
                                        id="myRange" name="priceupto"
                                        value="<?php if(@@$data['priceupto']) echo @@$data['priceupto'];?>">
                                    <p>Price: AED <span id="demo"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Pre-order -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>Pre Order</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['pre-order']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li>
                                        <label class="checkbox_label">Yes
                                            <input <?php if(@@$data['pre-order']=="enabled") echo 'checked';?> type="checkbox" class="JagatFilterInput" value="Yes" name="preOrder">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <!-- <li>
                                        <label class="checkbox_label">No
                                            <input <?php if(@@$data['pre-order']=="No") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="No" name="preOrder">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        
                        <!-- New realesed filter -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>New arrival</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['new_realesed']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li>
                                        <label class="checkbox_label">Yes
                                            <input <?php if(@@$data['new_realesed']=="Yes") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="Yes" name="new_realesed">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <!-- <li>
                                        <label class="checkbox_label">No
                                            <input <?php if(@@$data['new_realesed']=="No") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="No" name="new_realesed">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li> -->
                                </ul>
                            </div>
                        </div>

                         <!-- freebie -->
                        <?php if(@$freebiChecking[0]->c>0){?>
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>freebie</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['freebie']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li>
                                        <label class="checkbox_label">Yes
                                            <input <?php if(@@$data['freebie']=="Yes") echo 'checked';?> type="checkbox"
                                                class="JagatFilterInput" value="Yes" name="freebie">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <!-- <li>
                                        <label class="checkbox_label">No
                                            <input <?php if(@@$data['freebie']=="No") echo 'checked';?> type="checkbox"
                                                class="JagatFilterInput" value="No" name="freebie">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li> -->
                                </ul>
                            </div>
                        </div>

                           <!-- evergreen -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>evergreen</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>

                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['evergreen']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li>
                                        <label class="checkbox_label">Yes
                                            <input <?php if(@@$data['evergreen']=="Yes") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="Yes" name="evergreen">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <!-- <li>
                                        <label class="checkbox_label">No
                                            <input <?php if(@@$data['evergreen']=="No") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="No" name="evergreen">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li> -->
                                </ul>
                            </div>
                        </div>

                          <!-- exclusive -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3>exclusive</h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['exclusive']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li>
                                        <label class="checkbox_label">Yes
                                            <input <?php if(@@$data['exclusive']=="Yes") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="Yes" name="exclusive">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <!-- <li>
                                        <label class="checkbox_label">No
                                            <input <?php if(@@$data['exclusive']=="No") echo 'checked';?>
                                                type="checkbox" class="JagatFilterInput" value="No" name="exclusive">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li> -->
                                </ul>
                            </div>
                        </div>

                        <?php } ?>





                    </form>
                </div>
            </div>

            <!-- Products list area -->
            <div class="p-10px col-lg-9 ">
                <div class="row mb-3 mobile_product_list_box">
                    <?php 
                          if(@$cat2){?>
                                          <!--   <div class="col-md-12">
                      <h4 class="text-capitalize  h5 pb-1 "><strong>Shop by category</strong></h4>
                      <div class="owl-carousel owl-theme category_boxes">
                      <?php
                      foreach(@$cat2 as $k=>$v){ 
                        $sql="select * from category_image where category='$v->category_id' and status='Active'";
                        $category_image=$userModel->customQuery($sql);
                      ?>
                      <div class="item">
                      <a href="<?php echo base_url();?>/product-list?category=<?php echo $v->category_id; ?>" class="category_box_on_the_top shadow-none border p-0 pb-2 text-capitalize rounded overflow-hidden">
                      <div class="box box_cate_products_list_s" style=" background-image: url('<?php echo base_url();?>/assets/uploads/<?php if($category_image[0]->image) echo $category_image[0]->image;else echo 'noimg.png';?>');">
                      </div>
                      <h5><strong><?php echo $v->category_name;?></strong></h5>
                      </a>
                      </div>
                      <?php }  ?> 
                      </div>
                      </div>-->
                    <?php } ?>
                </div>
                <i id="loading" class="fa fa-spinner fa-spin" style="font-size:24px"></i>
                <div class="m-10px row" id="Jagat-datatable">
                </div>
                <div class="col-12 mt-3 text-center pag mb-5">
                    <p class="m-0 text-capitalize " id="pageingation"><span id="pgCount2"> </span> of <span id="ofPrduct"></span> Products showing</p>
                    <input type="hidden" name="currentPage" id="currentPage" value="1">
                    <!--<i id="loading2" class="fa fa-spinner fa-spin" style="font-size:24px"></i>-->
                    <button class="btn btn-primary rounded-pill " id="LoadMore">Load More</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
  var slider = document.getElementById("myRange");
  var output = document.getElementById("demo");
  output.innerHTML = slider.value;
  slider.oninput = function() {
      output.innerHTML = this.value;
  }

</script>