<?php
    $uri = service('uri');
    $userModel = model('App\Models\UserModel', false);
    $productModel = model('App\Models\ProductModel');
    $attributeModel = model('App\Models\AttributeModel');
    
    
    
    $sql = "select * from master_category where parent_id='0'";
    $master_category = $userModel->customQuery($sql);
    $cid = urldecode($uri->getSegment(4));
    $sql = "select * from products where product_id='$cid'";
    @$editcat = $userModel->customQuery($sql);
    $product_id = @$editcat[0]->product_id;
    $sql = "select * from product_image where product='$product_id' ";
    @$cat_image = $userModel->customQuery($sql);
    $sql = "select * from product_screenshot where     product='$product_id' ";
    @$product_screenshot = $userModel->customQuery($sql);
    $sql = "select * from brand where     status='Active' ";
    @$brand = $userModel->customQuery($sql);
    $sql = "select * from suitable_for where     status='Active' ";
    @$suitable_for = $userModel->customQuery($sql);
    $sql = "select * from type where     status='Active' ";
    @$type = $userModel->customQuery($sql);
    $sql = "select * from color where     status='Active' ";
    @$color = $userModel->customQuery($sql);
    $sql = "select * from age where     status='Active' ";
    @$age = $userModel->customQuery($sql);
    $sql = "select * from attributes where     product_id='$product_id' and type='type' ";
    @$ptype = $userModel->customQuery($sql);
    $sql = "select * from attributes where     product_id='$product_id' and type='suitable_for' ";
    @$stype = $userModel->customQuery($sql);
    $sql = "select * from attributes where     product_id='$product_id' and type='age' ";
    @$sage = $userModel->customQuery($sql);
    $sql = "select * from attributes where     product_id='$product_id' and type='color' ";
    @$scolor = $userModel->customQuery($sql);
    $sql = "select * from products where status='Active' ";
    @$rel = $userModel->customQuery($sql);
    // var_dump($rel);die();
    $timezone = new \DateTimeZone(TIME_ZONE);

    if($editcat[0]->product_id){
        $product_attributes = ($editcat[0]->product_nature == "Variable") ? $productModel->get_attributes($editcat[0]->product_id) : $productModel->get_attributes($editcat[0]->parent);
        $product_variations = $productModel->get_variations($editcat[0]->product_id);
    }
    $attributes = $attributeModel->get_attribute_list();
    
    // var_dump($editcat[0]);die();
?>

<style>
    .multi {
        height: 200px !important;
    }

    #editor {
        border: 1px solid #cacfe7;
        color: #3b4781;
    }

    input[type=file] {
        display: block
    }

    .imageThumb {
        height: 122px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid #000;
        color: #fff;
        text-align: center;
        cursor: pointer
    }

    .remove:hover {
        background: #fff;
        color: #000
    }
</style>



<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <?php include 'Common/Breadcrumb.php'; ?>
        <div class="content-body">
            <!-- Basic Tables start -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content  ">
                            <div class="card-body">
                                
                                <form method="post" enctype="multipart/form-data">


                                    <?php if (@$editcat[0]->product_id) { ?>
                                    <input type="hidden" name="product_id" value="<?php echo @$editcat[0]->product_id ?>">
                                    <?php } ?>
                                    <h4 class="form-section">
                                        <i class="fa fa-<?php if (count(@$uri->getSegments()) > 2) { if (@$uri->getSegment(3) == 'add') echo 'plus'; else echo 'edit'; } ?>"></i>
                                        <?php
                                        if (count(@$uri->getSegments()) > 2)
                                        {
                                            echo ucwords(@$uri->getSegment(3));
                                        }
                                        ?>
                                        Product Form
                                    </h4>
                                    <!-- Tab panes -->
                                    <?php
                                    if (@$validation) {
                                    ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php
                                            print_r(@$validation);
                                        ?>
                                    </div>
                                    <?php } ?>

                                    <!-- Navigation links -->
                                    <ul class="nav nav-tabs nav-justified">
                                        <li class="nav-item">
                                            <a class="nav-link  <?php if (count(@$uri->getSegments()) < 5) { echo 'active'; } ?>" id="BasicInfo-tab" data-toggle="tab" href="#BasicInfo" aria-controls="active" aria-expanded="true">Basic Info</a>
                                        </li>
                                        <!-- <li class="nav-item">
                                                  <a class="nav-link " id="Arabic-tab" data-toggle="tab" href="#Arabic" aria-controls="link" aria-expanded="false">Arabic</a>
                                         </li> -->
                                        <li class="nav-item">
                                            <a class="nav-link    <?php if (count(@$uri->getSegments()) > 4) { echo 'active'; } ?>" id="Images-tab" data-toggle="tab" href="#Images" aria-controls="Images">Image</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="SEO-tab" data-toggle="tab" href="#SEO" aria-controls="SEO">SEO</a>
                                        </li>
                                    </ul>
                                    
                                    <!-- Create product tabls -->
                                    <div class="tab-content px-1 pt-1">
                                        <!-- products infos -->
                                        <div role="tabpanel" class="tab-pane   <?php if (count(@$uri->getSegments()) < 5) { echo 'active'; } ?>" role="tabpanel" aria-labelledby="link-tab" aria-expanded="false" id="BasicInfo">

                                            <!-- Category of the product -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Category*</label>
                                                <div class="col-sm-9">
                                                    <select multiple name="category[]" required id="" class="form-control multi" <?php //if(@$editcat[0]->category!="") echo 'disabled'; ?>>
                                                        <option value="0" selected="selected">Choose Category</option>
                                                        <?php
                                                        if ($master_category)
                                                        {
                                                            foreach ($master_category as $key => $value)
                                                            {
                                                        ?>
                                                        <!-- ##########  level 1-->
                                                        <option
                                                            <?php if (strpos(@$editcat[0]->category, $value->category_id) !== false) echo 'selected'; ?>
                                                            value="<?php echo $value->category_id; ?>">
                                                            <?php echo $value->category_name; ?></option>
                                                        <!-- ##########  level 2-->
                                                        <?php
                                                            $pid = $value->category_id;
                                                            $sql = "select * from master_category where  status='Active' and parent_id='$pid' ";
                                                            $master_category2 = $userModel->customQuery($sql);
                                                            if ($master_category2)
                                                            {
                                                                foreach ($master_category2 as $key2 => $value2)
                                                                {
                                                        ?>
                                                        <option
                                                            <?php if (strpos(@$editcat[0]->category, $value2->category_id) !== false) echo 'selected'; ?>
                                                            value="<?php echo $value2->category_id; ?>">
                                                            &nbsp&nbsp&nbsp&nbsp<?php echo $value2->category_name; ?>
                                                        </option>
                                                        <?php
                                                            $pid2 = $value2->category_id;
                                                            $sql = "select * from master_category where  status='Active' and parent_id='$pid2' ";
                                                            $master_category3 = $userModel->customQuery($sql);
                                                            if ($master_category3)
                                                            {
                                                                foreach ($master_category3 as $key3 => $value3)
                                                                {
                                                        ?>
                                                        <option
                                                            <?php if (strpos(@$editcat[0]->category, $value3->category_id) !== false) echo 'selected'; ?>
                                                            value="<?php echo $value3->category_id; ?>">
                                                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value3->category_name; ?>
                                                        </option>
                                                        <?php
                                                            $pid3 = $value3->category_id;
                                                            $sql = "select * from master_category where  status='Active' and parent_id='$pid3' ";
                                                            $master_category4 = $userModel->customQuery($sql);
                                                            if ($master_category4)
                                                            {
                                                                foreach ($master_category4 as $key4 => $value4)
                                                                {
                                                        ?>
                                                        <option
                                                            <?php if (strpos(@$editcat[0]->category, $value4->category_id) !== false) echo 'selected'; ?>
                                                            value="<?php echo $value4->category_id; ?>">
                                                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<?php echo $value4->category_name; ?>
                                                        </option>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <!-- ##########  leve 2 END-->
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <!-- ##########  leve 1 END-->
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Google product category -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Google product category</label>
                                                <div class="col-sm-9">
                                                    <select class="type form-control" name="google_category">
                                                        <?php  if ($gp) {
                                                            foreach ($gp as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if ($v->id == $editcat[0]->google_category) echo 'selected'; ?>
                                                            value="<?php echo $v->id; ?>"><?php echo $v->category; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Product Name -->
                                            <div class="form-group row">
                                                <label for="name" class="col-sm-3 col-form-label">Product Name*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="name" required="" value="<?php echo @$editcat[0]->name ?>">
                                                </div>
                                            </div>

                                            <!-- Product arabic Name -->
                                            <div class="form-group row">
                                                <label for="arabic_name" class="col-sm-3 col-form-label">Product Arabic name*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="arabic_name" value="<?php echo @$editcat[0]->arabic_name ?>">
                                                </div>
                                            </div>
                                            
                                             <?php if(true){ ?>           
                                            <!-- Product nature -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product Nature:</label>
                                                <div class="col-sm-9">
                                                    <select name="product_nature" required="" class="form-control" id="product_nature">
                                                        <option value="" selected>Select an option</option><option
                                                            <?php if (@$editcat[0]->product_nature == "Simple") echo 'selected'; ?>  value="Simple">Simple
                                                        </option>
                                                        <option
                                                            <?php if (@$editcat[0]->product_nature == "Variable") echo 'selected'; ?> value="Variable">Variable
                                                        </option>
                                                        <option
                                                            <?php if (@$editcat[0]->product_nature == "Variation") echo 'selected'; ?> value="Variation">Variation
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Parent product -->
                                            <?php 
                                            $var_cond = $editcat[0]->product_nature == "Variation"
                                            ?>
                                            
                                            <div class="form-group row" id="variable_parent" style=" <?php if (!$var_cond) echo  "display:none"?>">
                                                <label for="input-1" class="col-sm-3 col-form-label">Parent product*</label>
                                                <div class="col-sm-9">
                                                    <select class="suitable_for form-control col-12 parent_variable" name="parent" >
                                                    <option <?php if($rel && (empty($editcat[0]->parent) || is_null($editcat[0]->parent))) echo "selected" ?> value="">Select Parent</option>
                                                        <?php
                                                        if ($rel) {
                                                            @$parent = $editcat[0]->parent;
                                                            foreach ($rel as $k => $v) {
                                                        ?>
                                                        <option <?php if ($parent) { if ($v->product_id == $parent) { echo 'selected'; } } ?> value="<?php echo $v->product_id; ?>">
                                                            <?php echo $v->name; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Variation base -->
                                            <?php 
                                            $var_cond= is_array($attributes) && sizeof($attributes) > 0 && $editcat[0]->product_nature == "Variable"; 
                                            // var_dump($product_attributes);die();
                                            ?>
                                            
                                            <div class="form-group row " id="p-attributes" style="<?php if (!$var_cond) echo "display:none" ?>">
                                                <label for="variation_base" class="col-sm-3 col-form-label">Variation based on:</label>
                                                <div class="col-9 attributes_container" style="">
                                                    <?php if($var_cond): ?>
                                                    <select class="form-control" name="attributes[]" id="" multiple size="5">
                                                        <?php 
                                                            foreach($attributes as $value):
                                                        ?>
                                                        <option value="<?php echo $value->attribute_id ?>" <?php if(in_array($value->attribute_id , $product_attributes)) echo "selected" ?>><?php echo $value->name ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                            <?php endif;?>

                                                </div>
                                            </div>

                                            <!-- Variations -->
                                            <?php 
                                            $var_cond= $editcat[0]->product_nature == "Variation" && ($editcat[0]->parent !== "" || $editcat[0]->parent !== null);?>
                                            
                                            <div class="form-group row " id="p-variations" style="<?php if (!$var_cond) echo "display:none" ?>">
                                                <label for="variations" class="col-sm-3 col-form-label">Variations:</label>
                                                <div class="col-9 row variations_container">
                                                    <?php if($var_cond):?>

                                                    <?php 
                                                    if(sizeof($product_variations) > 0 && false):
                                                    foreach($product_variations as $key => $value):
                                                    ?>

                                                    <div class="row col-12">
                                                        <?php foreach($value as $attribute => $variation): $i=1;?>
                                                        <div class="col-3" style="">
                                                            <label for="attribute_validation" class="col-auto form-label"><?php echo($attributeModel->get_attribute_name($attribute)) ?></label>
                                                            <select class="form-control" name="attribute_variation[]" id="">

                                                                <?php foreach($attributeModel->get_attribute_options($attribute) as $option): ?>
                                                                <option value="<?php echo $attribute.":".$option->id ?>" <?php if($variation == $option->id) echo "selected" ?>><?php echo $option->name ?></option>
                                                                <?php endforeach; $i++;?>

                                                            </select>
                                                        </div>
                                                        <?php endforeach; ?>

                                                    </div>
                                                    

                                                    <?php 
                                                    endforeach;
                                                    elseif(sizeof($product_attributes) > 0):
                                                    ?>
                                                    
                                                    

                                                    <div class="row col-12">
                                                        <?php 
                                                        foreach($product_attributes as $key => $value):
                                                        ?>
                                                        <div class="col-3" style="">

                                                            <select class="form-control" name="attribute_variation[]" id="" required>
                                                                <option value="">Select a variation</option>
                                                                <?php foreach($attributeModel->get_attribute_options($value) as $option):?>
                                                                <option value="<?php echo $value.":".$option->id ?>"  <?php if($productModel->product_has_atribute_option($value , $option->id , $editcat[0]->product_id)) echo "selected"; ?>><?php echo $option->name ?></option>
                                                                <?php endforeach;?>
                                                            </select>

                                                        </div>

                                                        <?php endforeach;?>
                                                    </div>

                                                    <?php else:?>
                                                        <div class="row col-12">
                                                            <p>Select a parent variable product</p>
                                                        </div>
                                                    

                                                    <?php endif;?>

                                                    <?php endif; ?>

                                                </div>

                                            </div>

                                            <?php } ?>  
                                            
                                            <!-- Product SLUG -->
                                            <div class="form-group row">
                                                <label for="slug" class="col-sm-3 col-form-label">Slug (URL alternative):</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="slug" value="<?php echo @$editcat[0]->slug ?>">
                                                </div>
                                            </div>

                                            <!-- Product Brand -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Product brand*</label>
                                                <div class="col-sm-9">
                                                    <select required class="form-control" name="brand" required="">
                                                        <option value="">Select brand</option>
                                                        <?php
                                                        if ($brand)
                                                        {
                                                            foreach ($brand as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if ($v->id == @$editcat[0]->brand) echo 'selected'; ?>
                                                            value="<?php echo $v->id; ?>"><?php echo $v->title; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>

                                            <!-- Product Type -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Product Type*</label>
                                                <div class="col-sm-9">
                                                    <select class="type form-control" multiple="true" name="type[]" required>
                                                        <?php  if ($type) {
                                                            foreach ($type as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if (in_array($v->type_id, explode(",", @$editcat[0]->type))) echo 'selected'; ?>
                                                            value="<?php echo $v->type_id; ?>"><?php echo $v->title; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <!-- Make it bundle with options -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Bundle with options ?</label>
                                                <div class="col-sm-9">
                                                    <select required class="form-control" name="bundle_opt_enabled" required="" onchange="showDiv(['bundle_opt_sec'], this)">
                                                    <!-- <select required class="form-control" name="bundle_opt_enabled" required="" > -->

                                                        <option value=""></option>
                                                        <option
                                                            <?php 
                                                            if (@$editcat[0]) {
                                                                if (@$editcat[0]->bundle_opt_enabled == "No") echo 'selected';
                                                            }
                                                            else echo 'selected'; ?>
                                                            value="No">No</option>
                                                        <option
                                                            <?php if (@$editcat[0]->bundle_opt_enabled == "Yes") echo 'selected'; ?>
                                                            value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Add options to the bundle -->
                                            <div class="form-group j-c-end row " id="bundle_opt_sec" style="display:<?php if($editcat[0]->bundle_opt_enabled == "Yes") echo("flex"); else echo("none"); ?>">
                                                <?php 
                                                    $req = "select opt_group.id as group_id from opt_group where product_id='".$editcat[0]->product_id."'";
                                                    $option_groups = $userModel->customQuery($req); 
                                                    if($option_groups != null ):
                                                ?>
                                                    <label for="input-1" class="col-sm-3 col-form-label">Bundle options*</label>
                                                    <?php 
                                                        $group_count = 0;
                                                        foreach($option_groups as $opt_group):
                                                            $req="select bundle_opt.* from opt_group inner join bundle_opt on opt_group.id = bundle_opt.option_group_id where opt_group.product_id='".$editcat[0]->product_id."' and opt_group.id=".$opt_group->group_id;
                                                            $options= $userModel->customQuery($req);
                                                            if($options != null):
                                                    ?>
                                                    <div class="col-sm-9 row m-0 a-a-start opt_group_container">
                                                        <div class="col-sm-9 row m-0 j-c-start a-c-center border py-2 opt_group">     

                                                            <?php for($i=0 ; $i<sizeof($options) ; $i++): ?>
                                                            
                                                            <div class="col-sm-12 d-flex j-c-start a-c-center add_opt_container mb-1">

                                                                <!-- name of additional opt -->
                                                                <input class="col-6" type="text" required class="form-control" placeholder="Option name" name="bundle_opt[<?php echo $group_count ?>][]" value="<?php echo $options[$i]->option_title;?>">

                                                                <!-- put price -->
                                                                <div class="col-lg-3 col-sm-12  mx-2 p-0">
                                                                    <input type="number" placeholder="Additional Price" name="additional_price[<?php echo $group_count ?>][]" class="form-control" value="<?php echo $options[$i]->additional_price; ?>">
                                                                </div>

                                                                <?php if($i > 0): ?>
                                                                <!-- Delete option -->
                                                                <div class="row col-auto j-c-center a-a-center p-0 remove_opt rounded"> 
                                                                    <p class="m-0 p-1">Remove option</p>
                                                                </div>

                                                                <?php else:?>
                                                                <!-- Add option -->
                                                                <div class="row col-auto j-c-center a-a-center p-0 add_opt rounded"> 
                                                                    <p class="m-0 p-1">Add option</p>
                                                                    <!-- <i style="font-size: 32px; height;auto;" class="fa-solid fa-plus"></i> -->
                                                                </div>
                                                                <?php endif; ?>

                                                            </div>

                                                            <?php 
                                                            endfor;
                                                            ?>


                                                        </div>

                                                        <?php if($group_count == 0): ?>
                                                        <div class="col-sm-3 row m-0 j-c-center a-a-center">
                                                            <div class="row col-auto j-c-center a-a-center add_opt_group"> 
                                                                <p class="m-0 p-1">Add group</p>
                                                                <!-- <i style="font-size: 32px; height;auto;" class="fa-solid fa-plus"></i> -->
                                                            </div>
                                                        </div>

                                                        <?php else: ?>

                                                        <div class="col-sm-4 row m-0 j-c-center a-a-center">
                                                            <div class="row col-auto j-c-center a-a-center remove_opt_group"> 
                                                                <p class="m-0 p-1">Remove group</p>
                                                                <!-- <i style="font-size: 32px; height;auto;" class="fa-solid fa-plus"></i> -->
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>

                                                    </div>

                                                    <?php 
                                                            $group_count++;
                                                            endif;
                                                        endforeach;
                                                    else: 
                                                    ?>

                                                    <label for="input-1" class="col-sm-3 col-form-label">Bundle options*</label>
                                                    
                                                    <div class="col-sm-9 row m-0 a-a-start opt_group_container">
                                                        <div class="col-sm-9 row m-0 j-c-start a-c-center border py-2 opt_group">

                                                            <div class="col-sm-12 d-flex j-c-start a-c-center add_opt_container mb-1">

                                                                <!-- name of additional opt -->
                                                                <input class="col-6 form-control" type="text" placeholder="Option name" name="bundle_opt[0][]" value="">
                                                    
                                                                <!-- put price -->
                                                                <div class="col-lg-3 col-sm-12  mx-2 p-0">
                                                                    <input type="number" placeholder="Additional Price" name="additional_price[0][]" class="form-control" value="">
                                                                </div>

                                                                <div class="row col-auto j-c-center a-a-center p-0 add_opt"> 
                                                                    <p class="m-0 p-1">Add option</p>
                                                                    <!-- <i style="font-size: 32px; height;auto;" class="fa-solid fa-plus"></i> -->
                                                                </div>
                                                    
                                                            </div>
                                                    
                                                            <div class="col-sm-12 d-flex j-c-start a-c-center add_opt_container">

                                                                <!-- name of additional opt -->
                                                                <input class="col-6 form-control" type="text" placeholder="Option name" name="bundle_opt[0][]" value="">

                                                                <!-- put price -->
                                                                <div class="col-lg-3 col-sm-12  mx-2 p-0">
                                                                    <input type="number" placeholder="Additional Price" name="additional_price[0][]" class="form-control" value="">
                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-sm-3 row m-0 j-c-center a-a-center">
                                                            <div class="row col-auto j-c-center a-a-center add_opt_group"> 
                                                                <p class="m-0 p-1">Add group</p>
                                                                <!-- <i style="font-size: 32px; height;auto;" class="fa-solid fa-plus"></i> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php 
                                                        endif;
                                                    ?>
                                               
                                            </div>

                                            <!-- Suitable for -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Suitable for*</label>
                                                <div class="col-sm-9">
                                                    <select class="suitable_for form-control" multiple="true"
                                                        name="suitable_for[]">

                                                        <?php
                                                        if ($suitable_for)
                                                        {
                                                            foreach ($suitable_for as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if (in_array($v->id, explode(",", @$editcat[0]->suitable_for))) echo 'selected'; ?>
                                                            value="<?php echo $v->id; ?>"><?php echo $v->title; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>


                                                </div>
                                            </div>

                                            <!-- Age rating -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Age*</label>
                                                <div class="col-sm-9">
                                                    <select class="age form-control" multiple="true" name="age[]">

                                                        <?php
                                                        if ($age)
                                                        {
                                                            foreach ($age as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if (in_array($v->id, explode(",", @$editcat[0]->age))) echo 'selected'; ?>
                                                            value="<?php echo $v->id; ?>"><?php echo $v->title; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Genre  -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Genre*</label>
                                                <div class="col-sm-9">

                                                    <select class="color form-control" multiple="true" name="color[]">

                                                        <?php
                                                        if ($color)
                                                        {
                                                            foreach ($color as $k => $v)
                                                            {
                                                        ?>
                                                        <option
                                                            <?php if (in_array($v->id, explode(",", @$editcat[0]->color))) echo 'selected'; ?>
                                                            value="<?php echo $v->id; ?>"><?php echo $v->title; ?>
                                                        </option>

                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Guft wrapping -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Gift wrapping*</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="gift_wrapping" required="">
                                                        <option value="">Select Gift wrapping</option>
                                                        <option
                                                            <?php if (@$editcat[0])
                                                            {
                                                                if (@$editcat[0]->gift_wrapping == "No") echo 'selected';
                                                            }
                                                            else echo 'selected'; ?>
                                                            value="No">No</option>
                                                        <option
                                                            <?php if (@$editcat[0]->gift_wrapping == "Yes") echo 'selected'; ?>
                                                            value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Pre-order enabled ? -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Pre-order enable*</label>
                                                <div class="col-sm-9">
                                                    <select required class="form-control" name="pre_order_enabled" required="" onchange="showDiv(['pre-order','releaseDate'], this)">
                                                        <option value=""></option>
                                                        <option
                                                            <?php if (@$editcat[0])
                                                            {
                                                                if (@$editcat[0]->pre_order_enabled == "No") echo 'selected';
                                                            }
                                                            else echo 'selected'; ?>
                                                            value="No">No</option>
                                                        <option
                                                            <?php if (@$editcat[0]->pre_order_enabled == "Yes") echo 'selected'; ?>
                                                            value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Pre-order before payment percentage -->
                                            <div class="form-group row" id="pre-order" style="display:<?php if (@$editcat[0]->pre_order_enabled == 'Yes') echo 'flex'; else echo 'none'; ?>">
                                                <label for="input-1" class="col-sm-3 col-form-label">Pre order before payment percentage</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="number"
                                                        name="pre_order_before_payment_percentage"
                                                        value="<?php if (@$editcat[0]->pre_order_before_payment_percentage) echo $editcat[0]->pre_order_before_payment_percentage; ?>">
                                                </div>
                                            </div>

                                            <!-- Release Date -->
                                            <div class="form-group row" id="releaseDate" style="display:<?php if (@$editcat[0]->pre_order_enabled == 'Yes') echo 'flex'; else echo 'none'; ?>">
                                                <label for="input-1" class="col-sm-3 col-form-label">Release Date</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="date" name="release_date"
                                                        value="<?php if (@$editcat[0]->release_date) echo $editcat[0]->release_date; ?>">
                                                </div>
                                            </div>

                                            <!-- Assemble professionally -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Assemble Professionally</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="assemble_professionally"
                                                        required="" onchange="showDiv(['aprof'], this)">
                                                        <option value="">Select Assemble Professionally</option>
                                                        <option
                                                            <?php if (@$editcat[0])
                                                            {
                                                                if (@$editcat[0]->assemble_professionally == "No") echo 'selected';
                                                            }
                                                            else echo 'selected'; 
                                                            ?>
                                                            value="No">No</option>
                                                        <option
                                                            <?php if (@$editcat[0]->assemble_professionally == "Yes") echo 'selected'; ?>
                                                            value="Yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Assemble Professionally Price -->
                                            <div class="form-group row" id="aprof" style="display:<?php if (@$editcat[0]->assemble_professionally == 'Yes') echo 'flex'; else echo 'none'; ?>">
                                                <label for="input-1" class="col-sm-3 col-form-label">Assemble Professionally Price</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="number"
                                                        name="assemble_professionally_price"
                                                        value="<?php if (@$editcat[0]->assemble_professionally_price) echo $editcat[0]->assemble_professionally_price; ?>">
                                                </div>
                                            </div>

                                            <!-- Product price -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Price*</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="price" required=""
                                                        value="<?php echo @$editcat[0]->price ?>">
                                                </div>
                                            </div>

                                            <!-- Discount Percentage -->
                                            <div class="form-group row border align-items-start py-3">
                                                <label for="input-1" class="col-sm-3 col-form-label">Discount Percentage</label>
                                                <div class="col-lg-9 row ml-0">
                                                    <div class="col-lg-12 row m-0 p-0">
                                                        <div class="form-group row col-lg-6 m-0 mb-2">
                                                            <label for="discount_type" class="col-lg-4 col-form-label">Type</label>
                                                            <select name="discount_type" id="discount_type" class="form-control col-lg-7">
                                                                <option value="" selected >Select discount Type</option>
                                                                <option <?php if(@$editcat[0]->discount_type == "percentage") echo "selected" ?> value="percentage">Percentage</option>
                                                                <option <?php if(@$editcat[0]->discount_type == "amount") echo "selected" ?> value="amount">Amount</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group row col-lg-6 m-0">
                                                            <label for="discount_value" class="col-lg-4 col-form-label">Discount_value</label>
                                                            <input type="number" class="form-control col-lg-7 m-0" name="discount_percentage" value="<?php echo @$editcat[0]->discount_percentage ?>" step=".00000001">
                                                        </div>
                                                    </div>
                                                    <!-- <input type="number" class="form-control col-lg-3 m-0" name="discount_percentage" value="<?php echo @$editcat[0]->discount_percentage ?>" step=".00000001"> -->
                                                    
                                                    <div class="col-lg-12 row m-0 p-0">
                                                        <div class="form-group row col-lg-6 m-0">
                                                            <label for="offer_start_date" class="col-lg-4 col-form-label">Start Date</label>
                                                            <input type="text" autocomplete="off" class="form-control col-lg-7" id="offer_start_date" name="offer_start_date" value="<?php echo @$editcat[0]->offer_start_date ?>">
                                                        </div>
                                                        <div class="form-group row col-lg-6 m-0">
                                                            <label for="offer_end_date" class="col-lg-4 col-form-label">End Date</label>
                                                            <input type="text" autocomplete="off" class="form-control col-lg-7" id="offer_end_date" name="offer_end_date" value="<?php echo @$editcat[0]->offer_end_date ?>">
                                                        </div>
                                                        <?php if(false): ?>
                                                        <div class="form-group row col-lg-12 m-0">
                                                            <label for="discount_rounded" class="col-lg-4 col-form-label">Rounded</label>
                                                            <select name="discount_rounded" required="" class="form-control" id="product_nature">
                                                                <option value="" selected>Select an option</option>
                                                                <option <?php if (@$editcat[0]->discount_rounded == "Yes") echo 'selected'; ?>  value="Yes">Yes</option>
                                                                <option <?php if (@$editcat[0]->discount_rounded == "No") echo 'selected'; ?> value="No">No</option>
                                                            </select>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Available Stock -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Available Stock*</label>
                                                <div class="col-sm-9">
                                                    <input type="number" required class="form-control"
                                                        name="available_stock"
                                                        value="<?php echo @$editcat[0]->available_stock ?>">
                                                </div>
                                            </div>

                                            <!-- Max order quantity -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Maximum order quantity</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control"
                                                        name="max_qty_order"
                                                        value="<?php echo @$editcat[0]->max_qty_order ?>">
                                                </div>
                                            </div>

                                            <!-- Max Order interval -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Order authorized:</label>
                                                <div class="col-sm-9">
                                                    <select name="order_interval" id="" class="form-control">
                                                        <option <?php if(@$editcat[0]->order_interval == "Unlimited"): echo "selected"; endif; ?> value="Unlimited">Unlimited</option>
                                                        <option <?php if(@$editcat[0]->order_interval == "Daily"): echo "selected"; endif; ?> value="Daily">Daily</option>
                                                        <option <?php if(@$editcat[0]->order_interval == "Weekly"): echo "selected"; endif; ?> value="Weekly">Weekly</option>
                                                        <option <?php if(@$editcat[0]->order_interval == "Monthly"): echo "selected"; endif; ?> value="Monthly">Monthly</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Stock Keeping Unit (SKU) -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Stock Keeping Unit (SKU)*</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="sku" required=""
                                                        value="<?php echo @$editcat[0]->sku ?>">
                                                </div>
                                            </div>

                                            <!-- Product Description -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product Description</label>
                                                <div class="col-sm-9">
                                                    <!--<div id="toolbar-container"></div>-->

                                                    <!-- This container will become the editable. -->
                                                    <!--<div id="editor">-->
                                                    <textarea name="description" id="wysiwyg" class="form-control"><?php echo @$editcat[0]->description ?></textarea>
                                                    <script>
                                                            CKEDITOR.replace( 'wysiwyg' );
                                                    </script>
                                                    <!--</div>-->
                                                </div>
                                            </div>

                                            <!-- Product Arabic Description -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product Arabic Description</label>
                                                <div class="col-sm-9">
                                                    <!--<div id="toolbar-container"></div>-->

                                                    <!-- This container will become the editable. -->
                                                    <!--<div id="editor">-->
                                                    <textarea name="arabic_description" id="ara_wysiwyg" class="form-control"><?php echo @$editcat[0]->arabic_description ?></textarea>
                                                    <script>
                                                            CKEDITOR.replace( 'ara_wysiwyg' );
                                                    </script>
                                                    <!--</div>-->
                                                </div>
                                            </div>

                                            <!-- Product Features -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product Features</label>
                                                <div class="col-sm-9">
                                                    <textarea name="features" class="form-control "><?php echo @$editcat[0]->features ?></textarea>
                                                </div>
                                            </div>

                                            <!-- Product Features -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product Arabic Features</label>
                                                <div class="col-sm-9">
                                                    <textarea name="arabic_features" class="form-control "><?php echo @$editcat[0]->arabic_features ?></textarea>
                                                </div>
                                            </div>

                                            <!-- Related Products -->
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Related Products*</label>
                                                <div class="col-sm-9">
                                                    <select class="suitable_for form-control" multiple="true" name="related_products[]">
                                                        <?php
                                                        if ($rel) {
                                                            $sql = "select * from related_products where     product_id='$product_id' ";
                                                            @$savedRealted = $userModel->customQuery($sql);
                                                            foreach ($rel as $k => $v) {
                                                        ?>
                                                        <option <?php if ($savedRealted) { if (array_search($v->product_id, array_column($savedRealted, 'related_product'))) { echo 'selected'; } } ?> value="<?php echo $v->product_id; ?>">
                                                            <?php echo $v->name; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Show This product in Home Page -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Show This product in Home Page</label>
                                                <div class="col-sm-9">
                                                    <select name="show_this_product_in_home_page" required=""
                                                        class="form-control">
                                                        <option value="">Select status</option>
                                                        <option
                                                            <?php if (@$editcat[0]->show_this_product_in_home_page == "Yes") echo 'selected'; ?>
                                                            selected="" value="Yes">Yes</option>
                                                        <option
                                                            <?php if (@$editcat[0]->show_this_product_in_home_page == "No") echo 'selected'; ?>
                                                            value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Enable reviews for this product -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Enable reviews:</label>
                                                <div class="col-sm-9">
                                                    <select name="review_enabled" required=""
                                                        class="form-control">
                                                        <option value="">Select option</option>
                                                        <option
                                                            <?php if (@$editcat[0]->review_enabled == "Yes") echo 'selected'; ?>
                                                            selected="" value="Yes">Yes</option>
                                                        <option
                                                            <?php if (@$editcat[0]->review_enabled == "No") echo 'selected'; ?>
                                                            value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Freebie -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label"> Freebie </label>
                                                <div class="col-sm-9">
                                                    <select name="freebie" required="" class="form-control">
                                                        <option value="">Select freebie</option>
                                                        <option
                                                            <?php if (@$editcat[0]->freebie == "Yes") echo 'selected'; ?>  value="Yes">Yes</option>
                                                        <option
                                                            <?php if (@$editcat[0]->freebie == "No") echo 'selected'; ?> selected value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Evergreen -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Evergreen </label>
                                                <div class="col-sm-9">
                                                    <select name="evergreen" required="" class="form-control">
                                                        <option value="">Select evergreen</option>
                                                        <option
                                                            <?php if (@$editcat[0]->evergreen == "Yes") echo 'selected'; ?>  value="Yes">Yes</option>
                                                        <option
                                                            <?php if (@$editcat[0]->evergreen == "No") echo 'selected'; ?> selected value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Exclusive -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Exclusive </label>
                                                <div class="col-sm-9">
                                                    <select name="exclusive" required="" class="form-control">
                                                        <option value="">Select exclusive</option>
                                                        <option
                                                            <?php if (@$editcat[0]->exclusive == "Yes") echo 'selected'; ?> value="Yes">Yes</option>
                                                        <option
                                                            <?php if (@$editcat[0]->exclusive == "No") echo 'selected'; ?> selected value="No">No</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Precedence -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Precedence</label>
                                                <div class="col-sm-9">
                                                    <input type="number" name="precedence" value="<?php echo (@$editcat[0]->precedence) ?>" class="form-control">
                                                </div>
                                            </div>

                                            <!-- Product validity date range -->
                                            <div class="form-group row">
                                                <label for="valid_from" class="col-sm-3 col-form-label">Valid From</label>
                                                <div class="col-sm-12 col-md-3 p-0">
                                                    <div class="col-sm-12">
                                                        <input type="text" autocomplete="off" class="form-control" id="valid_from" name="valid_from" value="<?php echo @$editcat[0]->valid_from ?>">
                                                    </div>
                                                </div>
    
                                                <label for="valid_until" class="col-sm-auto col-form-label">Until</label>
                                                <div class="col-sm-12 col-md-3 p-0">
                                                    <div class="col-sm-12">
                                                        <input type="text" autocomplete="off" class="form-control" id="valid_until" name="valid_until" value="<?php echo @$editcat[0]->valid_until ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Product validity date range -->


                                            <!-- Set as new -->
                                            <div class="form-group row">
                                                <label for="set_as_new" class="col-sm-3 col-form-label">Set as new</label>

                                                <div class="row m-0 col-sm-12 col-md-2 p-0">
                                                    <div class="col-sm-12">
                                                        <select name="set_as_new" class="form-control">
                                                            <option <?php if (@$editcat[0]->set_as_new == "Yes") echo 'selected'; ?> value="Yes">Yes</option>
                                                            <option <?php if (@$editcat[0]->set_as_new == "No") echo 'selected'; ?> value="No">No</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                
                                                <!-- new date range -->
                                                <div class="row m-0 col-sm-6 col-md-6 set_as_new_date_range" <?php if(isset($editcat[0]->set_as_new) && @$editcat[0]->set_as_new == "No") echo "style='display:none'"?>>
                                                    <label for="new_from" class="col-sm-auto col-form-label">From</label>
                                                    <div class="col-sm-12 col-md-4 p-0">
                                                        <div class="col-sm-12">
                                                            <input type="text" autocomplete="off" class="form-control" id="new_from" name="new_from" value="<?php echo @$editcat[0]->new_from ?>">
                                                        </div>
                                                    </div>
                                                        
                                                    <label for="new_until" class="col-sm-auto col-form-label">Until</label>
                                                    <div class="col-sm-12 col-md-4 p-0">
                                                        <div class="col-sm-12">
                                                            <input type="text" autocomplete="off" class="form-control" id="new_until" name="new_until" value="<?php echo @$editcat[0]->new_until ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- New status date range -->

                                            <!-- Status -->
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Status*</label>
                                                <div class="col-sm-9">
                                                    <select name="status" required="" class="form-control">
                                                        <option value="">Select status</option>
                                                        <option
                                                            <?php if (@$editcat[0]->status == "Active") echo 'selected'; ?>
                                                            selected="" value="Active">Active</option>
                                                        <option
                                                            <?php if (@$editcat[0]->status == "Inactive") echo 'selected'; ?>
                                                            value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        
                                        <!-- <div class="tab-pane" id="Arabic" role="tabpanel" aria-labelledby="Arabic-tab" aria-expanded="false">
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Product Name Arabic
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="arabic_name"
                                                        value="<?php echo @$editcat[0]->arabic_name ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Description Arabic
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea name="arabic_description"
                                                        class="form-control "><?php echo @$editcat[0]->arabic_description ?></textarea>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- products images -->
                                        <div class="tab-pane  <?php if (count(@$uri->getSegments()) > 4) { echo 'active'; } ?>" id="Images" role="tabpanel" aria-labelledby="Images-tab" aria-expanded="false">
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Youtube Link</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" placeholder="Youtube Link" name="youtube_link" value="<?php echo @$editcat[0]->youtube_link ?>">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Product image </label>
                                                <div class="col-sm-10 ">
                                                    <input id="files" type="file" multiple name="file[]"
                                                        class="form-control">
                                                    <?php
                                                    if ($cat_image)
                                                    {
                                                        foreach ($cat_image as $k => $v)
                                                        {
                                                            $file_name = $v->image;
                                                            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                                                            if ($extension == "mp4")
                                                            {
                                                    ?>

                                                    <span class="pip">
                                                        <video width="150" height="150" controls>
                                                            <source
                                                                src="<?php echo base_url(); ?>/assets/uploads/<?php if ($v->image) echo $v->image; ?>"
                                                                type="video/mp4">
                                                        </video>
                                                        <br><a
                                                            href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>"
                                                            class="remove">Remove image</a>
                                                    </span>








                                                    <?php
                                                            }
                                                            else
                                                            {
                                                    ?>
                                                    <span class="pip">
                                                        <img class="imageThumb" src="<?php echo base_url(); ?>/assets/uploads/<?php if ($v->image) echo $v->image; ?>" title="undefined"><br>
                                                        <a href="<?php echo base_url(); ?>/supercontrol/Products/deleteImage/<?php echo $v->id; ?>/<?php echo $product_id; ?>" class="remove">Remove image</a>
                                                    </span>


                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Screenshot image
                                                </label>
                                                <div class="col-sm-10 ">
                                                    <input type="file" multiple name="file2[]" class="form-control">
                                                    <?php
                                                    if ($product_screenshot)
                                                    {
                                                        foreach ($product_screenshot as $k3 => $v3)
                                                        {
                                                    ?>
                                                    <span class="pip"><img class="imageThumb"
                                                            src="<?php echo base_url(); ?>/assets/uploads/<?php if ($v3->image) echo $v3->image; ?>"
                                                            title="undefined"><br><a
                                                            href="<?php echo base_url(); ?>/supercontrol/Products/deleteScreenImage/<?php echo $v3->id; ?>/<?php echo $product_id; ?>"
                                                            class="remove">Remove image</a></span>


                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                </div>
                                            </div>

                                        </div>

                                        <!-- product SEO -->
                                        <div class="tab-pane" id="SEO" role="tabpanel" aria-labelledby="SEO-tab"
                                            aria-expanded="false">
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Page Title </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="page_title"
                                                        value="<?php echo @$editcat[0]->page_title ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Page Keywords
                                                </label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="page_keywords"
                                                        value="<?php echo @$editcat[0]->page_keywords ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input-1" class="col-sm-3 col-form-label">Page Description
                                                </label>
                                                <div class="col-sm-9">

                                                    <textarea name="page_description"
                                                        class="form-control "><?php echo @$editcat[0]->page_description ?></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="input-2" class="col-sm-3 col-form-label">Other Meta tag
                                                </label>
                                                <div class="col-sm-9">
                                                    <textarea name="other_meta_tag"
                                                        class="form-control "><?php echo @$editcat[0]->other_meta_tag ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <!-- Submit button -->
                                    <div class="form-footer">
                                        <a href="<?php echo base_url(); ?>/supercontrol/Products/" class="btn btn-danger"><i class="fa fa-times"></i> CANCEL</a>
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> SAVE</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // function showDiv(divId, element) {
    //     document.getElementById(divId).style.display = element.value == 'Yes' ? 'flex' : 'none';
    //     document.getElementById("releaseDate").style.display = element.value == 'Yes' ? 'flex' : 'none';
    // }

    function showDiv(array, el) {

        array.forEach(element => {
            document.getElementById(element).style.display = el.value == 'Yes' ? 'flex' : 'none';
            $("#"+element+" .chosen-container").css({"width":"100%"})
        });
        // document.getElementById("releaseDate").style.display = element.value == 'Yes' ? 'flex' : 'none';
    }
       

</script>

<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>

<script>
    // CKEDITOR.replace('editor', {
    //     skin: 'moono',
    //     enterMode: CKEDITOR.ENTER_BR,
    //     shiftEnterMode: CKEDITOR.ENTER_P,
    //     toolbar: [{
    //             name: 'basicstyles',
    //             groups: ['basicstyles'],
    //             items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor']
    //         },
    //         {
    //             name: 'styles',
    //             items: ['Format', 'Font', 'FontSize']
    //         },
    //         {
    //             name: 'scripts',
    //             items: ['Subscript', 'Superscript']
    //         },
    //         {
    //             name: 'justify',
    //             groups: ['blocks', 'align'],
    //             items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
    //         },
    //         {
    //             name: 'paragraph',
    //             groups: ['list', 'indent'],
    //             items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
    //         },
    //         {
    //             name: 'links',
    //             items: ['Link', 'Unlink']
    //         },
    //         {
    //             name: 'insert',
    //             items: ['Image']
    //         },
    //         {
    //             name: 'spell',
    //             items: ['jQuerySpellChecker']
    //         },
    //         {
    //             name: 'table',
    //             items: ['Table']
    //         }
    //     ],
    // });
</script>

