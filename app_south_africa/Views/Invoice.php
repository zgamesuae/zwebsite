
<?php 
  $session = session();
  $userModel = model('App\Models\UserModel', false);
  $orderModel =model("App\Models\OrderModel");

  $uri = service('uri'); 
  @$user_id=$session->get('userLoggedin'); 

  $sql="select * from settings";
  $settings=$userModel->customQuery($sql);

  $uri2="";

  if(count(@$uri->getSegments())>1){
    $uri2=@$uri->getSegment(2); 
  } 

    // Collect order information
    $order_details = $orderModel->get_order_details($uri2);
    $order_products = $orderModel->get_order_products($uri2);
    $order_charges = $orderModel->order_total_charges($uri2);
    $total = 0;

    // var_dump($order_details);die();

?> 
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="style.css">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>

        <style>
            /* reset */

            *
            {
            	border: 0;
            	box-sizing: content-box;
            	color: inherit;
            	font-family: inherit;
            	font-size: inherit;
            	font-style: inherit;
            	font-weight: inherit;
            	line-height: inherit;
            	list-style: none;
            	margin: 0;
            	padding: 0;
            	text-decoration: none;
            	vertical-align: top;
            }

            /* content editable */

            *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

            *[contenteditable] { cursor: pointer; }

            *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

            span[contenteditable] { display: inline-block; }

            /* heading */

            h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

            /* table */

            table { font-size: 75%; table-layout: fixed; width: 100%; }
            table { border-collapse: separate; border-spacing: 2px; }
            th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
            th, td { border-radius: 0.25em; border-style: solid; }
            th { background: #EEE; border-color: #BBB; }
            td { border-color: #DDD; }

            /* page */

            html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
            html { background: #999; cursor: default; }

            body { box-sizing: border-box; min-height: 11in; margin: 0 auto; overflow: visible; padding: 0.5in; width: 8.5in; }
            body { background: #FFF; border-radius: 15px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

            /* header */

            header { margin: 0 0 3em; }
            header:after { clear: both; content: ""; display: table; }

            header h1 { background: rgb(11, 50, 122); border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; font-family: inherit; }
            header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
            /*header address:nth-child(2) { float: right; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; text-align: right; }*/
            header address p { margin: 0 0 0.25em; }
            header span{ display: block; float: right; }
            header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
            header img { max-height: 100%; max-width: 100%; }
            header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

            /* article */

            article, article address, table.meta, table.inventory { margin: 0 0 3em; }
            article:after { clear: both; content: ""; display: table; }
            article h1 { clip: rect(0 0 0 0); position: absolute; }

            article address { float: left; font-size: 100%; font-weight: 600; line-height: 1.25rem }

            /* table meta & balance */

            table.meta, table.balance { float: right; width: 36%; }
            table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

            /* table meta */

            table.meta th { width: 40%; }
            table.meta td { width: 60%; }

            /* table items */

            table.inventory { clear: both; width: 100%; }
            table.inventory th { font-weight: bold; text-align: center; }

            table.inventory td:nth-child(1) { width: 26%; }
            table.inventory td:nth-child(2) { width: 38%; }
            table.inventory td:nth-child(3) { text-align: right; width: 12%; }
            table.inventory td:nth-child(4) { text-align: right; width: 12%; }
            table.inventory td:nth-child(5) { text-align: right; width: 12%; }

            /* table balance */

            table.balance th, table.balance td { width: 50%; }
            table.balance td { text-align: right; }

            /* table payment */
            table.payment{ width: 50%}
            table.payment th, table.payment td { width: 50%; }
            table.payment td { text-align: right; }

            /* aside */

            aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
            aside h1 { border-color: #999; border-bottom-style: solid; }
            aside p{text-align: center; line-height: 1.1em; font-size: .75rem; width: 90%; margin: auto;}

            /* javascript */

            .add, .cut
            {
            	border-width: 1px;
            	display: block;
            	font-size: .8rem;
            	padding: 0.25em 0.5em;	
            	float: left;
            	text-align: center;
            	width: 0.6em;
            }

            .add, .cut
            {
            	background: #9AF;
            	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            	background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
            	background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
            	border-radius: 0.5em;
            	border-color: #0076A3;
            	color: #FFF;
            	cursor: pointer;
            	font-weight: bold;
            	text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
            }

            .add { margin: -2.5em 0 0; }

            .add:hover { background: #00ADEE; }

            .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
            .cut { -webkit-transition: opacity 100ms ease-in; }

            tr:hover .cut { opacity: 1; }

            @media print {
            	* { -webkit-print-color-adjust: exact; }
            	html { background: none; padding: 0; }
            	body { box-shadow: none; width: 70%!important; height:auto!important; margin:auto !important; scale: 1.3; transform-origin: 50% 0%;}
            	span:empty { display: none; }
            	.add, .cut { display: none; }
            }

            @page { margin: 0; }
        </style>
            
	</head>
	<body>
		<header>
			<h1>Invoice/فتورة</h1>
			<address >
				<p><?php echo $settings[0]->business_name; ?></p>
				<p><?php echo $settings[0]->address;?></p>
				<p><?php echo $settings[0]->phone;?></p>
				<p><?php echo $settings[0]->email;?></p>
			</address>
			<div>
          <div style="margin:auto; height: 100px; width: 100px; ">
              <img alt="" src="https://zgames.sa/assets/uploads/ZGames-logo-01-66570.png">
          </div>
      </div>

		</header>
		<article>
			<h1>Recipient</h1>

			<address>
				<p><?php echo $order_details["name"] ?></p>
				<p><?php echo $order_details["street"] ?></p>
				<p><?php echo $order_details["apartment_house"] ?></p>
				<p><?php echo $order_details["address"] ?></p>
				<p><?php echo $orderModel->get_city_name($order_details["city"])->title ?></p>
				<p><?php echo $order_details["phone"] ?></p>
				<p><?php echo $order_details["email"] ?></p>
			</address>

			<table class="meta">
				<tr>
					<th><span >رقم الفتورة / Invoice #</span></th>
					<td><span ><?php echo $order_details["order_id"];?></span></td>
				</tr>
				<tr>
					<th><span >تاريخ / Date</span></th>
					<td><span ><?php echo date("d M Y H:i:s" , strtotime($order_details["created_at"]));?></span></td>
				</tr>
				<tr>
					<th><span >المبلغ المستحق / Amount Due</span></th>
					<td><span><?php echo $order_details["total"];?></span> <span id="prefix" ><?php echo CURRENCY ?></span></td>
				</tr>
			</table>

			<table class="inventory">
				<thead>
					<tr>
						<th><span >المنتج / Item</span></th>
						<th><span >SKU</span></th>
						<th><span >سعر الوحدة / Rate</span></th>
						<th><span >الكمية / Quantity</span></th>
						<th><span >السعر / Price</span></th>
					</tr>
				</thead>
				<tbody>

          <?php foreach($order_products as $product): ?>
					<tr>
						<td><span ><?php echo $product->product_name ?></span></td>
						<td><span ><?php echo $product->sku ?></span></td>
						<td><span ><?php echo $product->product_price ?></span><span data-prefix> <?php echo CURRENCY ?></span></td>
            <?php 
              $ft = (intval($product->free_quantity) > 0) ? "(+$product->free_quantity free)" : "";
            ?>
						<td><span ><?php echo (intval($product->quantity) - intval($product->free_quantity) . $ft) ?></span></td>
						<td><span><?php echo $product->product_price * (($product->quantity) - intval($product->free_quantity)) ?></span><span data-prefix> <?php echo CURRENCY ?></span></td>
					</tr>
          <?php endforeach; ?>
                    
				</tbody>
			</table>
      <?php if(isset($order_details["prizes"]) && sizeof($order_details["prizes"]) > 0): ?>
			<table class="inventory">
				<thead>
          <tr>
            <?php 
              // $offer_title = lg_put_text($order_details["offer_title"] , $order_details["offer_arabic_title"] , false);
            ?>
            <th colspan="5"><?php echo "Prizes" ?> </th>
          </tr>
					<tr>
						<th><span >المنتج / Item</span></th>
						<th><span >SKU</span></th>
						<th><span >سعر الوحدة / Rate</span></th>
						<th><span >الكمية / Quantity</span></th>
						<th><span >السعر / Price</span></th>
					</tr>
				</thead>
				<tbody>

                    <?php foreach($order_details["prizes"] as $product): ?>
					<tr>
						<td><span ><?php echo $product->name ?></span></td>
						<td><span ><?php echo $product->sku ?></span></td>
						<td><span ><?php echo $product->value ?></span><span data-prefix> <?php echo CURRENCY ?></span></td>
						<td><span ><?php echo $product->quantity ?></span></td>
						<td><span>0</span><span data-prefix> <?php echo CURRENCY ?></span></td>
					</tr>
                    <?php endforeach; ?>
                    
				</tbody>
			</table>
      <?php endif; ?>

			<table class="balance">
        <!-- TAXABLE AMOUNT -->
				<tr>
					<th><span > المجموع الخاضع للضريبة <br> Taxable amount</span></th>
					<td><span><?php $taxable = bcdiv($order_details["sub_total"] / 1.05 , 1 , 2); echo $taxable ?></span> <span data-prefix><?php echo CURRENCY ?></span></td>
				</tr>
        <!-- TAXABLE AMOUNT -->

        <!-- CHARGES AMOUNT -->
        <?php $taxable_charges = bcdiv($order_charges["total_charges"] /1.05 , 1 , 2) ?>
        <?php foreach($order_charges["charges"] as $charge): ?>
        <tr>
            <th>
              <span>
              <?php echo $charge["arabic_title"] ?> <br> 
              <?php echo $charge["title"]; if ($charge["type"] == "Percentage") echo " ({$charge["value"]}%)"; ?>
              </span>
            </th>
            <td><span ><?php echo bcdiv($charge["price"] / 1.05 , 1 , 2) ?></span> <span data-prefix><?php echo CURRENCY ?></span></td>
        </tr>
        <?php endforeach; ?>
        <!-- CHARGES AMOUNT -->

        <!-- COUPON DISCOUNT AMOUNT -->
        <?php
          $taxable_discount = 0;
          if((int)$order_details["coupon_discount"] > 0): 
            $taxable_discount = bcdiv($order_details["coupon_discount"] / 1.05 , 1 , 2);
        ?>
				<tr>
					<th><span >خصم / Discount <?php if($order_details["coupon_type"] == "Percentage") echo " ({$order_details["coupon_value"]}%)"  ?></span></th>
					<td>
            <span> <?php echo $taxable_discount ?> </span> <span data-prefix> <?php echo CURRENCY ?></span>
          </td>
				</tr>
        <?php endif; ?>
        <!-- COUPON DISCOUNT AMOUNT -->

        <!-- ORDER OFFER DISCOUNT -->
        <?php
        foreach($order_details["offers"] as $offer):
          if((int)$offer->amount > 0): 
            $taxable_discount += bcdiv($offer->amount / 1.05 , 1 , 2);
        ?>
				<tr>
					<th><span >خصم / Discount <?php if($offer->discount_type == "Percentage") echo " ({$offer->value}%)"  ?></span></th>
					<td>
            <span> <?php echo bcdiv($offer->amount / 1.05 , 1 , 2) ?> </span> <span data-prefix> <?php echo CURRENCY ?></span>
          </td>
				</tr>
        <?php 
          endif; 
        endforeach;
        ?>
        <!-- ORDER OFFER DISCOUNT -->

        <!-- VAT AMOUNT -->
        <tr>
            <th><span >قيمة الضريبة <br> VAT amount</span></th>
            <td>
              <span><?php echo bcdiv(($taxable + $taxable_charges - $taxable_discount) * 0.05 , 1 , 2) ?> </span><span data-prefix> <?php echo CURRENCY ?> </span>
            </td>
        </tr>
        <!-- VAT AMOUNT -->

        <!-- PAID AMOUNT -->
        <?php if($order_details["wallet_use"] == "Yes" && (int)$order_details["wallet_used_amount"] > 0): ?>
        <tr>
            <th><span >المبلغ المدفوع <br> Total paid</span></th>
            <td><span><?php echo $order_details["wallet_use_amount"] ?></span> <span data-prefix><?php echo CURRENCY ?></span></td>
        </tr>
        <?php endif; ?>
        <!-- PAID AMOUNT -->

        <!-- TOTAL DUE -->
				<tr>
					<th><span >إجمالي المستحق <br> Total due</span></th>
					<td><span><?php echo $order_details["total"] ?></span> <span data-prefix><?php echo CURRENCY ?></span></td>
				</tr>
        <!-- TOTAL DUE -->

			</table>

      <table class="payment">
				<tr>
					<th><span > طريقة الدفع <br> Payment method</span></th>
					<td><span><?php echo $order_details["payment_method"] ?></span></td>
				</tr>
                
        <tr>
            <th><span >حالة الدفع <br> Payment status</span></th>
            <td><span><?php echo $order_details["payment_status"] ?></span></td>
        </tr>
			</table>
		</article>
		<aside>
			<h1><span >Thank you for shopping with us!</span></h1>
			<!-- <div>
				<p>ZGames reserves the right to change Terms of Use at any time, effective immediately upon posting on the Site. Please check <b>Terms and Conditions</b> page of the Site periodically.</p>
			</div> -->
		</aside>
	</body>
</html>