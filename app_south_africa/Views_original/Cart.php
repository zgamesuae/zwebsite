<style>.lab{display:unset}.mod-body{max-height:435px;overflow-x:hidden}.card-body2{max-height:350px;overflow-x:hidden}div.products_add_to_cart .product_qty input{width:100px}div.products_add_to_cart .product_qty input{width:46px;margin-right:0;background:#f9f9f9;border:1px solid #d2d2d2;border-radius:4px;padding:8px 0;text-align:center;font-weight:700}div.products_add_to_cart .product_qty input{width:100px}div.products_add_to_cart button{width:120px;border-bottom:unset}.image_selected_checkbox input:checked+label:before{content:"✓"}.pack-img{height:100%!important}.owl-next{float:right}.product_box_image img{max-height:200px}

.blink_me {color:red;
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<?php
$inStock = 1;
$productModel = Model("App\Model\ProductModel");
$session = session();
$userModel = model('App\Models\UserModel', false);
$uri = service('uri');
@$user_id = $session->get('userLoggedin');
if (@$user_id)
{
    $sql = "select * from users where user_id='$user_id'";
    $userDetails = $userModel->customQuery($sql);
    $sql = "select *,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart 
    inner join products on cart.product_id=products.product_id
    where cart.user_id='$user_id'   ";
    $cart = $userModel->customQuery($sql);
}
else
{
    $sid = session_id();
    $sql = "select *,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart
    inner join products on cart.product_id=products.product_id
    where cart.user_id='$sid'   ";
    $cart = $userModel->customQuery($sql);
}
if (@$user_id)
{
    $sql = "select * from users where user_id='$user_id'";
    $userDetails = $userModel->customQuery($sql);
    $sql = "select package,package.title as title  from cart 
    inner join products on cart.product_id=products.product_id
    inner join package on package.package_id=cart.package
    where cart.user_id='$user_id' AND cart.package != '' group by cart.package ";
    $pcart = $userModel->customQuery($sql);
}
else
{
    $sid = session_id();
    $sql = "select package,package.title as title  from cart 
    inner join products on cart.product_id=products.product_id
    inner join package on package.package_id=cart.package
    where cart.user_id='$sid' AND cart.package != '' group by cart.package";
    $pcart = $userModel->customQuery($sql);
}
$sql = "select * from gift_wrapping where     status='Active' ";
$gift_wrapping = $userModel->customQuery($sql);
$sql = "select * from settings";
$settings = $userModel->customQuery($sql);

?>

<div class="cart-layout-outer">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php if ($max_qty_order): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Warning!</strong> <br> 
                            <?php 
                                foreach ($max_qty_order as $key => $value) {
                                    # code...
                                    if($value){
                                        // echo("You have already ordered '".$productModel->get_product_name($key)."' you can reorder after ".$productModel->get_order_restriction_periode($key)." day(s) from you last order </br>");
                                        echo("Orders on '".$productModel->get_product_name($key)."' are limited to ".$value." piece(s)");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($product_order_resctricted): ?>
                    <div class="m-0" data-class="btn-close">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Warning!</strong> <br> 
                            <?php 
                                foreach ($product_order_resctricted as $key => $value) {
                                    # code...
                                    if($value){
                                        echo("You have already ordered '".$productModel->get_product_name($key)."' you can reorder after ".$productModel->get_order_restriction_periode($key)." day(s) from you last order </br>");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <h3 class="cart-title font-weight-bold">Basket&nbsp;<span>(<?php if ($cart) echo count($cart);
else echo 0; ?>)</span></h3>
            </div>
        </div>  
        <form action="<?php echo base_url(); ?>/checkout" method="post">
            <div class="row">
                <div class="col-12 col-lg-8 mt-2">
                    <div class="cart-products-outer">
                        <?php
if ($pcart)
{
    foreach ($pcart as $pk => $pv)
    {
     

        $packid = $pv->package;

        if (@$user_id)
        {

            $sql = "select *,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart 
    inner join products on cart.product_id=products.product_id
    where cart.user_id='$user_id' AND cart.package= '$packid'  ";
            $pack_pro = $userModel->customQuery($sql);
        }
        else
        {
            $sid = session_id();
            $sql = "select *,cart.discount_percentage as dp,cart.gift_wrapping as gw,cart.assemble_professionally_price as app from cart
    inner join products on cart.product_id=products.product_id
    where cart.user_id='$sid'  AND cart.package= '$packid'  ";
            $pack_pro = $userModel->customQuery($sql);
        }

?>
                                <!--Package Start-->
                                <div class="card border-0 mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="product-image col">
                                                <div class="owl-carousel Package_products_list ">
                                                    
                                                    
                                                    <?php
        $pack_price = 0;

        $pack_discounted_pric = 0;
        if ($pack_pro)
        {
            foreach ($pack_pro as $ppk => $ppv)
            {
                $ppaid = $ppv->age;

                $sql = "select * from age where     id='$ppaid' and status='Active' ";
                $Pack_age = $userModel->customQuery($sql);

                $pack_price = $pack_price + $ppv->price;

                $pack_discounted_pric = $pack_discounted_pric + ($ppv->price - ($ppv->dp * $ppv->price) / 100);

                $pid = $ppv->product_id;
                $sql = "select * from product_image where     product='$pid' and status='Active' ";
                $pack_product_image = $userModel->customQuery($sql);
?>
                                                    
                                                 <div class="item">
                                                     <div class="product_box shadow-none bg-white rounded overflow-hidden">
                                                      <a  href="<?php echo base_url(); ?>/product/<?php echo $ppv->product_id; ?>">
                                                        <div class="product_box_image">
                                                            <img src="<?php echo base_url(); ?>/assets/uploads/<?php if ($pack_product_image[0]->image) echo $pack_product_image[0]->image;
                else echo 'noimg.png'; ?>" class="border-0 pack-img"  >
                                                        </div>
                                                    </a> 
                                                </div>
                                            </div>
                                           <?php
            }
        } ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row justify-content-between pl-3 pr-3">
                                    <div class="title_productrs">
                                        <a href="<?php echo base_url(); ?>/packages"><?php echo $pv->title; ?></a>
                                        <div class="item-price"><span class="price">
                                            <?php echo $pack_discounted_pric; ?>                                                                <span class="curreny">AED</span>
                                            <del class="text-gray"><?php echo $pack_price; ?> AED</del>
                                        </span><span class="price-each">  <?php echo count($pack_pro); ?> item </span></div>
                                    </div>
                                    <div class="closeicon"><a href="?pcid=<?php echo $packid; ?>" class="btn-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"></path></svg></a> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-3 item-data item-data d-flex justify-content-between pt-2 pb-2 border-top border-bottom mb-3 align-items-center">
                                            <div class="data-left item-data d-flex justify-content-between align-items-center">
                                                <div class="dropdown-custom">
                                                    <div class="btn-group">
                                                        <div class="quanitity_div_parent">
                                                            <div class="quantitynumber">
                                                                <span class="minuss"  >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                                                                </span><input class="form-control" type="text" id="q-213" name="quantity" value="1" required="" min="1" >
                                                                <span class="pluss"  >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                                                                </span>
                                                            </div>          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="total-price total-price font-weight-bold"> <?php echo $pack_discounted_pric; ?>  AED</div>
                                        </div>
                                        <?php if (@$Pack_age[0])
        { ?>
                                        <div class="specification d-flex justify-content-between">
                                            <div class="icon border-0">
                                                 <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo @$Pack_age[0]->image; ?>">
                                                                    <span>Suitable for age <?php echo @$Pack_age[0]->title; ?></span>
                                            </div>
                                        </div>
                                        
                                        <?php
        } ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Package END-->
                <?php
    }
}
?>
        <?php
$total = 0;
$stotal = 0;
if ($cart)
{
    foreach ($cart as $k => $v)
    {
        // var_dump($v);
        $options = $productModel->get_product_options($v->product_id,$v->bundle_opt);
        

        $ptotal = 0;
        $temp = 0;
        $pid = $v->product_id;
        $sql = "select * from product_image where     product='$pid' and status='Active' ";
        $product_image = $userModel->customQuery($sql);
        $aid = $v->age;
        $sql = "select * from age where     id='$aid' and status='Active' ";
        $age = $userModel->customQuery($sql);
        if ($v->package)
        {
        }
        else
        {
            $p_price=$v->price;
            if($options){
                $p_price += $options->additional_price;
            }
?>
                    <div class="card border-0 mb-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="product-image col">
                                    <a class="item-image" href="<?php echo base_url(); ?>/product/<?php echo $v->product_id; ?>">
                                        <img  src="<?php echo base_url(); ?>/assets/uploads/<?php if ($product_image[0]->image) echo $product_image[0]->image;
            else echo 'noimg.png'; ?>" alt="<?php echo $v->name; ?>">
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="row justify-content-between pl-3 pr-3">
                                        <div class="title_productrs">
                                            <a href="<?php echo base_url(); ?>/product/<?php echo $v->product_id; ?>">
                                                <?php 
                                                    echo substr($v->name, 0, 55); ?><?php if (strlen($v->name) > 55) echo '...'; 
                                                    if($options !== false){
                                                        echo(" (+ ".$options->option_title.")");
                                                    }
                                                ?> 
                                            </a>
                                            <div class="item-price"><span class="price">
                                                <?php
                                                    $gw_price = 0;
                                                    if ($gid = $v->gw)
                                                    {
                                                        $sql = "select * from gift_wrapping where status='Active' AND id='$gid' ";
                                                        $gd = $userModel->customQuery($sql);
                                                        if ($gd)
                                                        {
                                                            $gw_price = $gd[0]->price;
                                                        }
                                                    }
                                                    // $offer_date= $productModel->get_offer_date($v->product_id);
                                                    // $discount_cond1=$v->dp > 0 && !$productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]);
                                                    // $discount_cond2= $v->dp > 0 && $productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]) && $productModel->is_date_valide_discount($v->product_id);
                                                    // if ($v->dp > 0)
                                                    if ($productModel->get_discounted_percentage($v->product_id) > 0)

                                                    {
                                                        // $ptotal=(($v->price - ($v->dp*$v->price)/100)  +$v->app+$gw_price ) *$v->quantity;
                                                        $temp = (round(($p_price - ($v->dp * $p_price) / 100))) * $v->quantity;
                                                ?>
                                                <?php 
                                                    echo round(bcdiv($p_price - ($v->dp * $p_price) / 100, 1, 2));
                                                ?>
                                                <span class="curreny">AED</span>
                                                <del class="text-gray"><?php echo bcdiv($p_price, 1, 2); ?> AED</del>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        // $ptotal=($v->price+$v->app+$gw_price)*$v->quantity;
                                                ?>
                                                <?php 
                                                    $price_each= $p_price;
                                                    // if($options !== false)
                                                    $temp = $price_each * $v->quantity;

                                                    echo bcdiv($price_each, 1, 2);
                                                ?>
                                                <span class="curreny">AED</span>
                                                <?php  } // $total=$total+$ptotal; ?>

                                        </span><span class="price-each">  each</span></div>
                                    </div>
                                    <div class="closeicon"><a href="?rcid=<?php echo $v->id; ?>" class="btn-close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z"/></svg></a> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-3 item-data item-data d-flex justify-content-between pt-2 pb-2 border-top border-bottom mb-3 align-items-center">
                                            <div class="data-left item-data d-flex justify-content-between align-items-center">
                                                <div class="dropdown-custom">
                                                    <div class="btn-group">
                                                                           
                                                                         
                                                                               
                                                                                    <?php
                                                                                                if ($v->dp == 100)
                                                                                                {
                                                                                                    echo 'Freebie Product';
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                
                                                                                    ?> 
                                                                                       <div class="quanitity_div_parent">
                                                                                    <div class="quantitynumber">
                                                                                    <span class="minus" onClick=updatecart_less('<?php echo $v->id; ?>','<?php echo $v->available_stock; ?>'); >
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-5-9h10v2H7v-2z"></path></svg>
                                                                                    </span><input onchange=updatecart('<?php echo $v->id; ?>','<?php echo $v->available_stock; ?>'); class="form-control" type="text" id="q-<?php echo $v->id; ?>" name="quantity" value="<?php echo $v->quantity; ?>" required  min="1" max="<?php echo $v->available_stock; ?>">
                                                                                    <span class="plus" id="plus<?php echo $v->id; ?>" style="<?php if ($v->quantity >= $v->available_stock) echo 'pointer-events:none'; ?> ;" onClick=updatecart_plus('<?php echo $v->id; ?>','<?php echo $v->available_stock; ?>'); >
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M11 11V7h2v4h4v2h-4v4h-2v-4H7v-2h4zm1 11C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z"></path></svg>
                                                                                    </span> 
                                                                                    </div>   
                                                                                      </div>
                                                                                    <?php
            } ?>
                                                                                      
                                                                       
                                                                        </div>
                                                                        <?php if ($v->available_stock < $v->quantity)
            {
                $inStock = 0;
?>
                                                                         <b class="text-center p-10 blink_me">  Out of stock! </b>
                                                                        <?php
            } ?>
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="total-price total-price font-weight-bold">
                                                                    <?php 
                                                                        echo bcdiv($temp, 1, 2);
                                                                    ?> AED
                                                                </div>
                                                            </div>
                                                            <div class="specification d-flex justify-content-between">
                                                                 <?php
            if (@$age[0])
            { ?>
                                                               
                                                                <div class="icon border-0">
                                                                    <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo @$age[0]->image; ?>">
                                                                    <span>Suitable for age <?php echo @$age[0]->title; ?></span>
                                                                </div>
                                                                
                                                                 <?php
            }
?>
                                                                
                                                                <?php
            if ($v->app)
            { ?>
                                                                    <div class="icon">
                                                                        <img src="<?php echo base_url(); ?>/assets/img/icon2.PNG">
                                                                        <span>Assemble Professionally</span>
                                                                    </div>
                                                                    <?php
            }
?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
            if (!empty($gift_wrapping) && $v->gift_wrapping == "Yes")
            {
?>
                                             <div class="gift_parent">
                                                <div class="grif_header">
                                                    <h6>Gift Wrapping</h6>
                                                    <div class="gift_wrape_enable">
                                                        <div class="label">no</div>
                                                        <div class="checkbox_area" >
                                                            <label class="switch">
                                                                <input type="checkbox" onchange="gift_wrape('.gift_wapre_000000<?php echo $v->product_id ?><?php echo $k2; ?>')">
                                                                <span class="slider round"></span>
                                                            </label>
                                                        </div>
                                                        <div class="label">yes</div>
                                                    </div>
                                                </div>
                                                <div class="grif_body gift_wapre_000000<?php echo $v->product_id ?><?php echo $k2; ?>" style="display: none;">
                                                    <div class="owl-carousel owl-theme gift_wrape_slider mt-3">
                                                        <?php
                foreach ($gift_wrapping as $k2 => $v2)
                {
?>
                                                            <div class="item">
                                                                <div class="image_selected_checkbox gift_wapre_media">
                                                                    <input value="<?php echo $v2->id; ?>" type="radio" name="gift[<?php echo $v->id; ?>]" id="myCheckbox2<?php echo $v->product_id ?><?php echo $k2; ?>">
                                                                    <label for="myCheckbox2<?php echo $v->product_id ?><?php echo $k2; ?>" class="w-100 m-0">
                                                                        <img src="<?php echo base_url(); ?>/assets/uploads/<?php echo $v2->image; ?>" class="gift_ware_image">
                                                                        <p class="m-0 text-center mt-1 font-weight-bold text-small">AED <?php echo bcdiv($v2->price, 1, 2); ?></p>
                                                                    </label>
                                                                </div>
                                                            </div> 
                                                            <?php
                }
?>
                                                    </div>
                                                    <div class="gift_parent mt-2">
                                                        <div class="grif_header">
                                                            <h6>Gift Notes</h6>
                                                            <div class="gift_wrape_enable">
                                                                <div class="label">no</div>
                                                                <div class="checkbox_area" >
                                                                    <label class="switch">
                                                                        <input type="checkbox" onchange="gift_wrape('.gift_wapre_000000<?php echo $v->product_id ?><?php echo $k2; ?>0')">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="label">yes</div>
                                                            </div>
                                                        </div>
                                                        <div class="grif_body gift_wapre_000000<?php echo $v->product_id ?><?php echo $k2; ?>0" style="display: none;">
                                                            <div action="">
                                                                <textarea name="note[<?php echo $v->id; ?>]" class="mt-3 border-0 shadow-m w-100 p-2 h-100 rounded" placeholder="Add Notes.."></textarea>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
            } ?>
                                    </div>
                                </div>
                                <?php
        }
    }
}
else
{
?>
                        <h5>Cart is empty!</h5>
                        <?php
}
?>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-2">
                <div class="order-summary-outer ">
                   <?php if ($cart)
{ ?>
                    <div class="card">
                        <div class="card-body">
                            <?php
                                foreach ($cart as $k => $v)
                                {
                                    $options = $productModel->get_product_options($v->product_id,$v->bundle_opt);


                                    $product_price=$v->price;
                                    if($options !== false)
                                        $product_price += $options->additional_price;

                                    $gw_price = 0;
                                    if ($gid = $v->gw)
                                    {
                                        $sql = "select * from gift_wrapping where status='Active' AND id='$gid' ";
                                        $gd = $userModel->customQuery($sql);
                                        if ($gd)
                                        {
                                            $gw_price = $gd[0]->price;
                                        }
                                    }
                                    // $offer_date= $productModel->get_offer_date($v->product_id);
                                    // $discount_cond1=$v->dp > 0 && !$productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]);
                                    // $discount_cond2= $v->dp > 0 && $productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]) && $productModel->is_date_valide_discount($v->product_id);
                                    // var_dump($productModel->is_date_valide_discount($v->product_id));
                                    // if ($v->dp > 0)
                                    if ($productModel->get_discounted_percentage($v->product_id) > 0)
                                    {
                                        $ptotal = (round(($product_price - ($v->dp * $product_price) / 100)) + $v->app + $gw_price) * $v->quantity;
                                        $temp = (round(($product_price - ($v->dp * $product_price) / 100))) * $v->quantity;


                                    }
                                    else
                                    {
                                        $ptotal = ($product_price + $v->app + $gw_price) * $v->quantity;
                                        $temp = ($product_price) * $v->quantity;


                                    }
                                    $total = $total + $ptotal;
                            ?>
                            <div class="price-summary-outer">
                                <div class="justify-content-between text-discount row">
                                    <div class="col-auto">
                                        <?php 
                                        $p_name=$v->name;
                                        if($options !== false)
                                        $p_name.=" (+ ".$options->option_title.")";
                                            echo substr($p_name, 0, 24);
                                            // echo $p_name;

                                        ?>..
                                    </div>
                                    <div class="col-auto">
                                        <?php
                                        // $offer_date= $productModel->get_offer_date($v->product_id);
                                        // $discount_cond1=$v->dp > 0 && !$productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]);
                                        // $discount_cond2= $v->dp > 0 && $productModel->has_daterange_discount($offer_date["start"],$offer_date["end"]) && $productModel->is_date_valide_discount($v->product_id);

                                        
        if ($productModel->get_discounted_percentage($v->product_id) > 0)
        {
            echo round(bcdiv(($product_price - ($v->dp * $product_price) / 100) * $v->quantity, 1, 2));
        }
        else
        {
            echo bcdiv($product_price * $v->quantity, 1, 2);
        } ?>
                                    AED</div>
                                </div>
                                <?php
        if ($v->app)
        { ?>
                                    <div class="justify-content-between text-discount row">
                                     <div class="col-auto">Assemble Professionally
                                     </div>
                                     <div class="col-auto"><?php echo bcdiv($v->app * $v->quantity, 1, 2); ?> AED</div>
                                 </div>
                                 <?php
        }
?>
                             <?php
        if ($gid = $v->gw)
        {
            $sql = "select * from gift_wrapping where     status='Active' AND id='$gid' ";
            $gk = $userModel->customQuery($sql);
            if ($gk)
            {
?>
                                <div class="justify-content-between text-discount row">
                                 <div class="col-auto">gift wrapping
                                 </div>
                                 <div class="col-auto"><?php echo bcdiv($gk[0]->price * $v->quantity, 1, 2); ?> AED</div>
                             </div>
                             <?php
            }
        }
?>
                     <hr class="my-3">
                 <?php
    } ?>
                 <div class="justify-content-between order-total row">
                    <div class="col-auto"> Total</div>
                    <div class="col-auto"><?php echo bcdiv($total, 1, 2); ?> AED</div>
                </div>
                <hr class="my-3">
            </div>
            <div class="cart-buttons">
                <div class="row">
                    <div class="col">
                        <?php
    if ($inStock)
    {
?>
                          <button  class="btn p-2 btn-primary btn-block font-weight-bold p-3 ">
                            <svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M19 10h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 1 1 14 0v1zM5 12v8h14v-8H5zm6 2h2v4h-2v-4zm6-4V9A5 5 0 0 0 7 9v1h10z"></path></svg> 
                        Checkout now</button>
                         <?php
    }
    else
    {
?>
                            <a class="btn p-2 btn-primary btn-block font-weight-bold p-3 disabled">  Checkout now</a>
                            
                            <?php
    }
?>
                      
                        
                        
                         <?php

    $freeCount = 0;
    if ($total)
    {
        if ($settings[0]->freebie_applicable_amount)
        {
            if ($freeCount = (int)(($total) / ($settings[0]->freebie_applicable_amount)))
            {

            }

        }
    }
    if ($freeCount > 0 && false)
    {
        if ($inStock)
        {
?>
          <input type="hidden" id="freebie_applicable_amount" value="<?php echo $freeCount; ?>">
          
            <a href="javascript:void(0);" data-toggle="modal" data-target="#FreebieModal" class="btn p-2 mt-2 btn-primary btn-block font-weight-bold p-3 ">Add Freebie Products</a>
            
            <?php
        }
    }
?>
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        <a href="<?php echo base_url(); ?>/product-list" class="animated p-3 mt-2 btn btn-blue btn-block font-weight-bold active">Continue shopping</a>
                    </div>
                </div>
            </div>
            <div class="security-message mt-3 text-gray text-capitalize text-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path><path d="M19 10h1a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V11a1 1 0 0 1 1-1h1V9a7 7 0 1 1 14 0v1zM5 12v8h14v-8H5zm6 2h2v4h-2v-4zm6-4V9A5 5 0 0 0 7 9v1h10z"></path></svg>
            Our website is 100% encrypted and your personal details are safe</div>
        </div>
    </div>
<?php
} ?>
</div>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div> 
</div>
</div>
<script>
  function   updatecart(cid,as){
        
      var q=document.getElementById("q-"+cid).value;
     if(q<=parseInt(as)  && q > 0 )  window.location.href = "?cid="+cid+"&quantity="+q;
  }
  function   updatecart_plus(cid,as){
      
      var q=document.getElementById("q-"+cid).value;
      var c = parseInt(q) + parseInt(1);
      
       
      
      
      
      if(c<=parseInt(as)   && c > 0 )  
      {
      window.location.href = "?cid="+cid+"&quantity="+c;
      }else{
          document.getElementById('plus'+cid).style.pointerEvents = 'none';
      }
  }
  function   updatecart_less(cid,as){
      var q=document.getElementById("q-"+cid).value;
      if(parseInt(q)>1){
      var c = parseInt(q) - parseInt(1);
      if(c<=parseInt(as)   && c > 0 ) window.location.href = "?cid="+cid+"&quantity="+c;
      }
  }
</script>






<?php

if ($freeCount > 0)
{

?>
<!-- Modal -->
<div id="FreebieModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      
        <h4 class="modal-title">Add Freebie Products</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form method="post" >
      <div class="modal-body mod-body"> 
      
        <div class="row">
      <?php

    $sql = "select *     from products 
 where products.status='Active' AND  products.freebie='Yes'    ";

    $sql = $sql . "order by created_at desc limit 20";

    $product = $userModel->customQuery($sql);

    if ($product)
    {
        if ($session->get('userLoggedin'))
        {
            @$user_id = $session->get('userLoggedin');
        }
        else
        {
            @$user_id = session_id();
        }
        foreach ($product as $k => $v)
        {
            $pid = $v->product_id;
            $sql = "select * from product_image where     product='$pid' and status='Active' ";
            $product_image = $userModel->customQuery($sql);

            $pid = $v->product_id;

            $sql = "select * from cart where user_id='$user_id' AND product_id='$pid' ";
            $tcart = $userModel->customQuery($sql);

?>
		<div class="p-10px col-md-3  col-sm-6 col-6 mb-3">
		       <label  for="<?php echo $v->product_id; ?>" class="lab">
			<div class="product_box shadow-none bg-white rounded overflow-hidden chk">
			    
			 
			 
					<div class="product_box_image">
					 
						<img src="<?php echo base_url(); ?>/assets/uploads/<?php if ($product_image[0]->image) echo $product_image[0]->image;
            else echo 'noimg.png'; ?>" class="border-0">
					</div>
			
			 
				<div class="product_box_content">
					<h5><strong> 
					      <input <?php if ($tcart) echo 'checked'; ?> type="checkbox" name="freebie[]" value="<?php echo $v->product_id; ?>" id="<?php echo $v->product_id; ?>" >
					    
					    <?php echo $v->name; ?> </strong></h5>
				 <a target="_blank" class="btn btn-primary"  href="<?php echo base_url(); ?>/product/<?php echo $v->product_id; ?>">View Detail</a>
			
			</div>
		</div>
			</label>
	</div> 
	<?php
        } ?>
	
	
	

<?php
    } ?>
      </div>
       </div>
      <div class="modal-footer">
          
          <b class="text-left red text-red" >You are eligible to add only <span><?php echo @$freeCount; ?></span> freebie products</b>
             <button type="submit" class="btn btn-primary"  >Add selected Freebie to cart</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div><?php
} ?>
