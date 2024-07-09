<div class="ws-bundle-prop-element p-2 col-4 col-xl-3" style="position: relative;" data-price="<?php echo $product->price ?>" data-product="<?php echo $product->sku ?>">
    
    <?php if($product->available_stock > 0): ?>
    <input name="bndl_product[]" type="checkbox" hidden="true" id="bndle_product_id_<?php echo $pr_index ?>" <?php if($default): echo "checked"; endif; ?> value="<?php echo $product->product_id;?>">    
    <!-- <input name="assemble_professionally_price" type="hidden" id="bndle_assemble_professionally_price"> -->

    <div class="<?php if($default): echo "default-checked"; else: echo "check"; endif;?> border rounded"></div>
    <?php endif; ?>

    <div class="ws-prop-img d-flex justify-content-center mb-3 col-12 p-0" <?php if($product->available_stock <= 0) echo "style='mix-blend-mode: luminosity;'"; ?>>
        <img src="https://zgames.ae/assets/uploads/<?php echo $GLOBALS["productModel"]->get_product_image($product->product_id , false , false) ?>" width="auto" alt="" style="max-height: 100px">
    </div>
    <div class="ws-bundle-infos d-flex flex-column justify-content-center text-center">
        <b><span class="currency"><?php echo CURRENCY ?></span> <span><?php echo $product->price ?></span></b>
        <span style="font-size: .8rem;"><?php echo $product->name ?></span>
    </div>
</div>