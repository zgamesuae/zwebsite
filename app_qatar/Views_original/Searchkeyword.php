<?php
    $productModel = model("App\Models\ProductModel");
    $categoryModel = model("App\Models\Category");
    $brandModel = model("App\Models\BrandModel");
    // var_dump($brands , $products , $categories);die();
    $cat_urls = $categoryModel->categories_urls();
    // var_dump($categoryModel->categories_urls());
?>

        <div class="result-data col-12 m-0 p-2 d-flex-row j-c-spacearound " style="background-color:rgb(223, 223, 223); height: auto; min-height:150px">

            <div class="col-12 row mb-2 result-item j-c-spacebetween" style="background-color: white; min-height: 120px; box-shadow: rgba(0, 0, 0, 0.192) 1px 1px 5px;">
                
                <!-- Categories search result -->
                <div class="col-lg-5 col-md-6 col-sm-12 m-0" style="min-height: 100%; background-color: white">
                    <p class="col-12 px-0 pb-0 pt-3 " style="font-size: 14px; font-weight: bold; color: #686868">MATCHING CATEGORIES</p>

                    <?php
                    if(isset($categories) && sizeof($categories) > 0):
                        foreach($categories as $category):
                    ?>
                        <p class="col-12 px-0 " style="font-size: 14px">
                            <?php foreach(array_reverse($categoryModel->cat_hierarchy($category->category_id , true)) as $c_id): ?>
                                <a href="<?php echo base_url()."/".$cat_urls[$c_id]?>" style="text-decoration: underline"><span class="p-r1"><?php echo $categoryModel->_getcatname($c_id); ?></span></a><span><?php echo htmlspecialchars("   ")?></span>
                            <?php endforeach; ?>
                        </p>
                    <?php
                        endforeach;
                    else:
                    ?>
                    <p class="text-center"> No result found!</p>
                    <?php
                    endif;
                    ?>

                </div>
                <!-- Categories search result -->


                <div class="col-md-auto col-sm-12 row m-0 j-c-center py-3">
                    <hr class="m-0 p-0 d-md-block d-sm-none" style="height:100%; background: #8080803b; width: 1px">
                    <hr class="m-0 p-0 d-md-none d-sm-block" style="height:1px; background: #8080803b; width: 100%">
                </div>

                <!-- brands search result -->
                <div class="col-lg-5 col-md-6 col-sm-12 m-0 border-start" style="min-height: 100%; background-color: white">
                    <p class="col-12 px-0 pb-0 pt-3 " style="font-size: 14px; font-weight: bold; color: #686868">MATCHING BRANDS</p>
                    <?php
                    if(isset($brands) && sizeof($brands) > 0):
                        foreach($brands as $brand):
                    ?>
                    <a href="<?php echo $brandModel->get_brand_url($brand->id)?>">
                        <p class="col-auto p-2 m-0 result_row" style="font-size: 14px">
                            <span class="p-r1"><?php echo $brandModel->_getbrandname($brand->id); ?></span>
                        </p>
                    </a>
                    <?php
                        endforeach;
                    else:
                    ?>
                    <p class=""> No result found!</p>
                    <?php
                    endif;
                    ?>
                </div>
                <!-- brands search result -->


            </div>
                


            <!-- Products search result -->
            <?php foreach($products as $product): ?>
            <a class="col-12 p-0" href="<?php echo $productModel->getproduct_url($product->product_id)?>" style="height:auto; width:auto">
                <div class="result-item col-12 row my-2 mx-0 p-1 d-flex-row" style="background-color: white; height: 120px; box-shadow: rgba(0, 0, 0, 0.192) 1px 1px 5px; cursor:pointer" item-link="https://zamzamgames.com">
                    <div class="res_image col-4 d-flex a-a-center" style="height:100%;">
                        <img src="<?php echo base_url()?>/assets/uploads/<?php echo $product->image?>" style="max-height:100%;max-width:100%" alt="">
                    </div>
    
                    <div class="res_title col-5">
                        <p class="m-0" style="line-height: 18px; font-size: 14px"><?php $p_title=(strlen($product->name) > 40) ? substr($product->name,0,40)."..." : $product->name; echo $p_title;?></p>
                    </div>
    
                    <div class="res_price col-3">
                        <?php if(!$productModel->get_discounted_percentage($product->product_id)): ?>
                            <p style="font-size:18px; position:relative; font-weight:bold"><?php echo $product->price ?> <span style="position:absolute; top:0; font-size: 12px">AED</span> </p>
                        <?php else: ?>
                        <p class="m-0" style="font-size:18px; position:relative; font-weight:bold"><?php echo $productModel->_discounted_price($product->product_id) ?> <span style="position:absolute; top:0; font-size: 12px">AED</span></p>
                        <p style="text-decoration:line-through; color: rgb(143, 143, 143); position:relative"><?php echo $product->price ?> <span style="position:absolute; top:0; font-size: 12px">AED</span></p>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
            <!-- END Products search result -->


        </div>
    


