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
$uri = service('uri'); 
$seo = pageseo($uri);
// var_dump($seo);die();
$session = session();
$userModel = model('App\Models\UserModel', false);
$cat_model=model('App\Models\Category');
$p_model=model('App\Models\ProductModel');
$systemModel=model('App\Models\SystemModel');
$request = \Config\Services::request();

$date = new \DateTime("now" , new \DateTimeZone(TIME_ZONE));
$filters = $data;
$category=$data["category"];
$ctaegory_list = [];

 $userDetails = ($session->get('userLoggedin')) ? $userModel->get_user($user_id) : null;
 $cid = $sql1 = $uri1 = $uri2 = $uri3 = "";
 

if ($cid = $category) {
    $sql1 = "  ";
    $sql1 = "select * from master_category where parent_id='$cid'";
    $cat2 = $userModel->customQuery($sql1);
}

// By category List
if(isset($filters["categoryList"]) && trim($filters["categoryList"]) !== ""){
    $cat_filter = explode("," , $filters["categoryList"]);
    $cat_filter = array_map(fn ($category) => "'$category'" ,  $cat_filter);
    $sql = "select category_id,category_name,category_name_arabic from master_category where category_id in (".implode("," , $cat_filter).")";
    $category_list = $userModel->customQuery($sql);
    // var_dump($category_list);die();

}

// By type
$sql = "select type_id,title,arabic_title,count(product_id) as c from type inner join products on type.type_id=products.type ";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by type.type_id order by title asc";
// echo($sql);
// die();

@$type = $userModel->customQuery($sql);

// By brand
$sql = "select id,title,arabic_title,count(product_id) as c from brand inner join products on brand.id=products.brand ";
$sql.= $p_model->filter($filters);
$sql = $sql . "  group by brand.id order by title asc";
// echo($sql);die();
@$brand = $userModel->customQuery($sql);

// By suitable for
$sql = " select id,title,arabic_title,count(product_id) as c  from suitable_for inner join products on suitable_for.id=products.suitable_for ";
$sql.=$p_model->filter($filters);
$sql = $sql . " group by suitable_for.id ";
@$suitable_for = $userModel->customQuery($sql);


// By genre
$sql = " select id,title,arabic_title,count(product_id) as c  from color inner join products on  FIND_IN_SET(color.id , products.color) ";
$sql.=$p_model->filter($filters);
if($data["genre"])
$sql.= " AND color.id='".$data["genre"]."'";
$sql = $sql . "  group by color.id order by title asc";
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
// var_dump($filters);
// die();

function search_title($filters){
	$brandModel = model('App\Models\BrandModel');
	$categoryModel = model('App\Models\Category');
	
	$title = "";
	if(isset($filters["keyword"]) && trim($filters["keyword"]) !== "" && !is_null($filters["keyword"])){
		$title = '"'.$filters["keyword"].'"';
	}

	else if(isset($filters["category"]) && trim($filters["category"]) !== "" && !is_null($filters["category"])){
		$title = lg_put_text($categoryModel->_getcatname($filters["category"]) , $categoryModel->_getcatname($filters["category"] , true) , false);
	}
	
	else if(isset($filters["brand"]) && trim($filters["brand"]) !== "" && !is_null($filters["brand"])){
		$brand_name = lg_put_text($brandModel->_getbrandname($filters["brand"]) , $brandModel->_getbrandname($filters["brand"] , true) , false);
		$title = ($brand_name) ? $brand_name : "";
	}

	return $title;
}

?>


<div class="container-fluid bg-lightt p-0" <?php echo content_from_right() ?>>
    <?php include 'Common/Breadcrumb.php';?>
    <div class="container outer_container_div pb-5 col-sm-12 col-md-12 col-lg-12">
        <div class="m-10px row">
            
            <!-- Filter box -->
            <div class="px-2 col-lg-3 mb-2 ws-pf-container">
                <div class="product_filter col-12 px-3 px-md-0 rounded bg-white shadow-none ">
                    <form action="<?php echo base_url();?>/page/getSearchData" method="post" id="getsearchform">
                        <h4 class="pt-3 pb-0 d-block d-lg-none "><strong><?php echo lg_get_text("lg_126") ?></strong>
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
                            <a href="<?php echo base_url();?>/product-list?category=<?php echo @@$category?>" class="JagatFilterInput"><?php echo lg_get_text("lg_127") ?></a>
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

                        <!-- Category List Filter -->
                        <?php 
                            if(isset($category_list) && sizeof($category_list) > 0):
                                foreach ($category_list as $v):
                        ?>
                                <input <?php if(in_array($v->category_id , explode("," , $filters["categoryList"]))) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="category_list" value="<?php echo $v->category_id;?>" name="categoryList" hidden>
                        <?php 
                                endforeach;
                            endif; 
                        ?>
                        <!-- Category List Filter -->

                        <!-- Filter by category -->
                        <?php if($cid && false){ ?>
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3><?php echo lg_get_text("lg_11") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display: none;">
                                <div class="multilavel_drop_down">
                                    <ul class="f-el-l">
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
                        <?php  }?>
                        <!-- Filter by category -->
                        
                        
                        <!-- Filter by Category -->
                        <?php if(isset($category_list) && sizeof($category_list) > 0 && false){ ?>
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3><?php echo lg_get_text("lg_11") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" >
                                <ul class="f-el-l">
                                    <?php
                                      foreach($category_list as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label">
                                            <?php (lg_put_text($v->category_name , $v->category_name_arabic))?>
                                            <input <?php if(in_array($v->category_id , explode("," , $filters["categoryList"]))) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="category_list" value="<?php echo $v->category_id;?>" name="categoryList">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Filter by Category -->


                        <?php  if($type){ ?>

                        <!-- Type -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3><?php echo lg_get_text("lg_128") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['type']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php
                                      foreach($type as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php (lg_put_text($v->title , $v->arabic_title))?>
                                            <!--(<?php echo $v->c;?>)-->
                                            <!-- <input <?php if(in_array($v->type_id , explode("," , $data['type']))) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="type" value="<?php echo $v->type_id;?>" name="type"> -->
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
                                <h3><?php echo lg_get_text("lg_129") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['brand']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php
                                      foreach($brand as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label">
                                            <?php if(get_cookie("language") == "AR") echo $v->arabic_title; else echo $v->title; ?>
                                            <input <?php if(@@$data['brand']==$v->id) echo 'checked';?> type="checkbox" class="JagatFilterInput" id="brand" value="<?php echo $v->id;?>" name="brand">
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
                                <h3><?php echo lg_get_text("lg_130") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['age']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php
                                      foreach($age as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
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
                                <h3><?php echo lg_get_text("lg_131") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['suitable_for']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php
                                      foreach($suitable_for as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label">
                                            <?php if(get_cookie("language") == "AR") echo $v->arabic_title; else echo $v->title; ?>
                                            <!--(<?php echo $v->c;?>) -->
                                            <input type="checkbox" <?php if( in_array($v->id , explode("," , $data["suitable_for"]))): echo "checked"; endif;?> class="JagatFilterInput" id="suitable_for" value="<?php echo $v->id;?>" name="suitable_for">
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
                                <h3><?php echo lg_get_text("lg_132") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['genre']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php foreach($color as $k=>$v){ ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label">
                                            <?php if(get_cookie("language") == "AR") echo $v->arabic_title; else echo $v->title;?>
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
                        $sql="select discount_percentage,round(discount_percentage) as discount_round,count(product_id) as c from products ";
                        $sql .= $p_model->filter($filters);
                        $sql .= " AND (( '".$date->format("Y-m-d H:i:s")."' BETWEEN offer_start_date AND offer_end_date ) OR (offer_start_date='' OR offer_end_date='') OR (offer_start_date='0000-00-00 00:00:00' OR offer_end_date='0000-00-00 00:00:00') OR (offer_start_date IS NULL OR offer_end_date IS NULL)) ";
                        $sql .= " AND discount_percentage > 0 AND status= 'Active' AND product_nature <> 'Variation' group by discount_round";
                        $dis=$userModel->customQuery($sql); 
                        // echo $sql;die();
                        if($dis && sizeof($dis) > 0){
                        ?>
                        <!-- Offer -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3><?php echo lg_get_text("lg_82") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['offer']) echo 'block';else echo 'none'?>;">
                                <ul class="f-el-l">
                                    <?php
                                      foreach($dis as $k=>$v){
                                    ?>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label">
                                            <?php echo -$v->discount_round."%";?>
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
                                <h3><?php echo lg_get_text("lg_133") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['priceupto']) echo 'block';else echo 'none'?>;">
                                <div class="slidecontainer">
                                    <input type="range" min="25" max="45000" class="sliderr JagatFilterInput" id="myRange" name="priceupto" value="<?php if(@@$data['priceupto']) echo @@$data['priceupto'];?>">
                                    <p class="<?php text_from_right() ?>"><?php echo lg_get_text("lg_133") ?>: <?php echo lg_get_text("lg_102") ?> <span id="demo"></span></p>
                                </div>
                            </div>
                        </div>

                        <!-- Pre-order -->
                        <div class="filter_category">
                            <div class="titie_heasder">
                                <h3><?php echo lg_get_text("lg_54") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['pre-order']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php echo lg_get_text("lg_138") ?>
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
                                <h3><?php echo lg_get_text("lg_134") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['new_realesed']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php echo lg_get_text("lg_138") ?>
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
                                <h3><?php echo lg_get_text("lg_135") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body" style="display:<?php if(@@$data['freebie']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php echo lg_get_text("lg_138") ?>
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
                                <h3><?php echo lg_get_text("lg_136") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>

                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['evergreen']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php echo lg_get_text("lg_138") ?>
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
                                <h3><?php echo lg_get_text("lg_137") ?></h3>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="none" d="M0 0h24v24H0z"></path>
                                    <path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"></path>
                                </svg>
                            </div>
                            <div class="cate_data_body"
                                style="display:<?php if(@@$data['exclusive']) echo 'block';else echo 'none'?>;">
                                <ul>
                                    <li class="<?php text_from_right() ?>">
                                        <label class="checkbox_label"><?php echo lg_get_text("lg_138") ?>
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
            <!-- Filter box -->
            
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
                <!-- Product List -->
                <?php if(true): ?>
                <!-- Result information -->
                <div class="p-10px m-10px col-12 row">
                	<div class="row px-0 pb-3 align-items-center product_sorting_mobile_fixed_on_scrooll col-sm-12 m-0 j-c-spacebetween a-a-flexstart">
                		<div class="m-0 text-capitalize col-md-12 col-lg-auto mb-2 mb-md-0">
                			<?php 
                				$search_title = search_title($filters);
                			?>
                			<?php 
                			if(true):
                				if($search_title): 
                				echo lg_get_text("lg_336") ?> <h1 style="font-size: 18px" class="d-inline-block m-0"> <?php echo $search_title ?></h1>
                			<?php 
                				endif;
                			endif; 
                			?>
                		</div>
                		<div class="mobile_search_products d-block d-lg-none col-6 px-0">
                            <div class="icon_filter_m border" id="filter_open_mobile">
                                <span><?php echo lg_get_text("lg_124") ?></span>
                                <svg viewBox="0 0 16 13" id="icon-filter" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M.3 2.395h9.458c.177.888.977 1.618 1.955 1.618.978 0 1.778-.73 1.956-1.618h2.026c.16 0 .302-.107.302-.267 0-.16-.142-.267-.301-.267h-2.01c-.124-1.066-.959-1.76-1.973-1.76-1.013 0-1.867.694-1.974 1.76H.3c-.16 0-.302.107-.302.267 0 .16.142.267.302.267zM11.713.652c.765 0 1.387.622 1.387 1.387s-.622 1.387-1.387 1.387a1.388 1.388 0 0 1-1.387-1.387A1.39 1.39 0 0 1 11.713.652zm3.983 5.654c.16 0 .302.107.302.266 0 .16-.142.267-.302.267H7.589c-.178.889-.978 1.618-1.955 1.618-.978 0-1.778-.73-1.956-1.618H.3c-.16 0-.302-.107-.302-.267 0-.16.143-.266.302-.266h3.36c.125-1.067.96-1.76 1.974-1.76 1.013 0 1.849.693 1.973 1.76h8.089zM5.634 7.87c.764 0 1.386-.622 1.386-1.387 0-.764-.622-1.386-1.386-1.386-.765 0-1.387.622-1.387 1.386 0 .765.622 1.387 1.387 1.387zm10.062 2.88c.16 0 .302.107.302.267 0 .16-.142.266-.302.266h-4.054c-.177 1.067-.977 1.618-1.955 1.618-.978 0-1.778-.551-1.956-1.618H.301c-.16 0-.303-.107-.303-.266 0-.16.143-.267.302-.267h7.413c.107-1.067.96-1.76 1.974-1.76s1.85.693 1.974 1.76h4.035zm-6.01 1.582c.765 0 1.388-.622 1.388-1.387s-.623-1.387-1.387-1.387c-.765 0-1.387.622-1.387 1.387s.622 1.387 1.387 1.387z" fill-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                		<div class="sort_by border bg-white rounded d-flex col-6 col-lg-4 px-0 ">
                		<div class="sort_by_option_news">
                			<span><?php echo lg_get_text("lg_125") ?></span>
                			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0H24V24H0z"/><path d="M19 3l4 5h-3v12h-2V8h-3l4-5zm-5 15v2H3v-2h11zm0-7v2H3v-2h11zm-2-7v2H3V4h9z"/></svg>
                		</div>
                		<div class="drop_down_sort_by_option">
                			<a class=" <?php text_from_right() ?>" href="javascript:void(0);" onClick="sortby('Newest');"><?php echo lg_get_text("lg_120") ?></a>
                			<a class=" <?php text_from_right() ?>" href="javascript:void(0);" onClick="sortby('Oldest');"> <?php echo lg_get_text("lg_121") ?></a>
                			<a class=" <?php text_from_right() ?>" href="javascript:void(0);" onClick="sortby('Highest');"><?php echo lg_get_text("lg_122") ?></a>
                			<a class=" <?php text_from_right() ?>" href="javascript:void(0);" onClick="sortby('Lowest');"><?php echo lg_get_text("lg_123") ?></a>
                		</div>
                		</div>
                	</div>
                </div>
                <!-- Result information -->
                <?php endif; ?>
                <div class="m-10px row" id="Jagat-datatable">
                    

                </div>
                <!-- Product List -->
                
                <!-- pagination -->
                <div class="col-12 mt-3 text-center pag mb-5">
                    <p class="m-0 text-capitalize " id="pageingation"><span id="pgCount2"> </span> <?php echo lg_get_text("lg_139") ?> <span id="ofPrduct"></span> <?php echo lg_get_text("lg_140") ?></p>
                    <input type="hidden" name="currentPage" id="currentPage" value="1">
                    <!--<i id="loading2" class="fa fa-spinner fa-spin" style="font-size:24px"></i>-->
                    <button class="btn btn-primary rounded-pill " id="LoadMore"><?php echo lg_get_text("lg_141") ?></button>
                </div>
                <!-- pagination -->

                <?php if(isset($seo) && trim($seo[0]->seo_text) !== ""): ?>
                <!-- PAGE SEO TEXT -->
                <div class="col-12 mt-3">
                    <?php echo $seo[0]->seo_text ?>
                </div>
                <!-- PAGE SEO TEXT -->
                <?php endif; ?>
                
            </div>
            <!-- Products list area -->
            
        </div>
    </div>
</div>



<script type="text/javascript">
  var slider = document.getElementById("myRange");
  var output = document.getElementById("demo");
  var is_product_list_page = true;
  output.innerHTML = slider.value;
  slider.oninput = function() {
      output.innerHTML = this.value;
  }



</script>