<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Invoice</title>
<style type="text/css">
.clearfix:after {
	content: "";
	display: table;
	clear: both;
}
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
h4{padding: 0;margin: 0;}
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

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 1em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 1em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: right; width: 36%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 40%; }
table.inventory td:nth-child(2) { width: 15%;text-align: center; }
table.inventory td:nth-child(3) { text-align: center; width: 15%; }
table.inventory td:nth-child(4) { text-align: right; width: 15%; }
table.inventory td:nth-child(5) { text-align: right; width: 15%; }

/* table balance */

table.balance th, 
table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

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
	html { background: none; }
	body { box-shadow: none;}
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 10px; }
.adres{
	width: 100%;
	margin: 0 0.5em 0.5em 0;
}
.shipping{
	width: 50%;
	float: left;
}
.shipping .meta{
	width: 100%;
}
</style>
</head>
<body>

			<header>
				<h1>Invoice</h1>
				<div style="padding:20px;display: block;">
					<img style="height: 60px" src="https://zappta.com/theme/image/pdf-logo.png" alt="Logo" >
				</div>
				<table class="meta" align="right">
					<tr>
						<th><span contenteditable>Invoice #</span></th>
						<td><span contenteditable><?php print $order['order']['order_serial'];?></span></td>
					</tr>
					<tr>
						<th><span contenteditable>Date</span></th>
						<td><span contenteditable><?php print date( 'F d, Y', strtotime($order['order']['order_date']));?></span></td>
					</tr>
					<tr>
						<th><span contenteditable>Order status</span></th>
						<td><span contenteditable><?php print orderCartOnAdminStatus($order['order']['order_status']);?></span></td>
					</tr>
					<tr>
						<th><span contenteditable>Payment Method</span></th>
						<td><span contenteditable><?php print $order['order']['payment_method'];?></span></td>
					</tr>
				</table>

			</header>

			<address contenteditable class="adres">
				<div class="shipping">
					<h4>Billing Info</h4>
					<table class="meta">
						<tr>
							<th><span contenteditable>Name</span></th>
							<td><span contenteditable><?php print $address[0]['first_name'] . ' ' . $address[0]['last_name'];?></span></td>
						</tr>
						<tr>
							<th><span contenteditable>Address</span></th>
							<td>
								<span contenteditable>
									<?php print $address[0]['stree_address'] . ', ' . $address[0]['stree_address_optional'];?> <?php print $address[0]['town_city'];?>, <?php print $address[0]['postcode'];?><br/><?php print $address[0]['country_name'];?>
								</span>
							</td>
						</tr>
						<tr>
							<th><span contenteditable>Email</span></th>
							<td><span contenteditable><?php print $address[0]['email'];?></span></td>
						</tr>
						<tr>
							<th><span contenteditable>Phone</span></th>
							<td><span contenteditable><?php print $address[0]['phone'];?></span></td>
						</tr>
					</table>
				</div>
				<div class="shipping">
					<h4>Shipping Info</h4>
					<table class="meta">
						<tr>
							<th><span contenteditable>Name</span></th>
							<td><span contenteditable><?php print $address[1]['first_name'] . ' ' . $address[1]['last_name'];?></span></td>
						</tr>
						<tr>
							<th><span contenteditable>Address</span></th>
							<td>
								<span contenteditable>
									<?php print $address[1]['stree_address'] . ', ' . $address[1]['stree_address_optional'];?> <?php print $address[1]['town_city'];?>, <?php print $address[1]['postcode'];?><br/><?php print $address[1]['country_name'];?>
								</span>
							</td>
						</tr>
						<tr>
							<th><span contenteditable>Email</span></th>
							<td><span contenteditable><?php print $address[1]['email'];?></span></td>
						</tr>
						<tr>
							<th><span contenteditable>Phone</span></th>
							<td><span contenteditable><?php print $address[1]['phone'];?></span></td>
						</tr>
					</table>
				</div>
			</address>


			<table class="inventory">
				<thead>
					<tr>
						<th><span contenteditable>Product</span></th>
						<th><span contenteditable>Price</span></th>
						<th><span contenteditable>Quantity</span></th>
						<th><span contenteditable>Shipping</span></th>
						<th><span contenteditable>Total</span></th>
					</tr>
				</thead>
				<tbody>
				<?php 
					$total_sub_total = [];
					$total_shipping = [];
					$total_grand = [];
					if ( is_array($order['items']) && count($order['items']) > 0 ) {
						foreach( $order['items'] as $it ) {
							$total_sub_total[] = $it['subtotal'];
							$total_shipping[] = $it['shipping'];
							$total_grand[] = $it['subtotal'];
							$attributes = $it['attribute'];
				?>
					<tr>
						<td>
							<span contenteditable><?php print ucfirst($it['item_name']);?></span>
							<?php 
								if ( !empty($attributes) && is_array($attributes) && count($attributes) > 0 ) {
									if ( $attributes[0]['attribute_id'] > 0 ) {
							?>	
							<p class="d-flex cart-attr">
							<?php 
									foreach ( $attributes as $option ) {
							?>	
									<span><?php print $option['value_name'];?></span>
							<?php
									}
							?>	
							</p>
							<?php 
									}
								}
							?>
						</td>
						<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['price'],2);?></span></td>
						<td><span contenteditable><?php print $it['qty'];?></span></td>
						<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['shipping'],2);?></span></td>
						<td><span data-prefix>$</span><span contenteditable><?php print number_format($it['subtotal'],2);?></span></td>
					</tr>
				<?php
						}
					}
				?>
				</tbody>
			</table>


			<table class="balance" align="right">
				<tr>
					<th><span contenteditable>Subtotal</span></th>
					<td><span data-prefix>$</span><span><?php print number_format($order['order']['final_subtotal'],2);?></span></td>
				</tr>
				<tr>
					<th><span contenteditable>Shipping</span></th>
					<td><span data-prefix>$</span><span contenteditable><?php print number_format($order['order']['shipping'],2);?></span></td>
				</tr>
				<tr>
					<th><span contenteditable>Discount</span></th>
					<td><span data-prefix>$</span><span contenteditable><?php print number_format($order['order']['discount'],2);?></span></td>
				</tr>
				<tr>
					<th><span contenteditable>Grand Total</span></th>
					<td><span data-prefix>$</span><span><?php print number_format($order['order']['total_amount'],2);?></span></td>
				</tr>
			</table>



</body>
</html>