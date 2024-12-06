<?php

function get_total_items()
{
	if ( is_array(get_cart_contents()) ) {
		return count(get_cart_contents());
	}
	return 0;
}

function get_cart_contents()
{
	return (new \App\Libraries\Cart())->contents();	
}

function insert_cart_contents($data)
{
	return (new \App\Libraries\Cart())->insert($data);	
}

function update_cart_contents($data)
{
	return (new \App\Libraries\Cart())->update($data);
}

function get_cart_totals()
{
	return (new \App\Libraries\Cart())->totalItems();
}

function get_cart_remove_item($rowid)
{
	return (new \App\Libraries\Cart())->remove($rowid);
}

function get_discount_cart($total=0)
{
	if(session()->get('cart_discount')){
        $amount = session()->get('cart_discount');
        if( $amount['type'] == 1 ) {
    		$balance = $total - $amount['amount'];
    		$bb = $total - $balance;
         	return number_format($bb,2);
        } else {
         	$balance = $total - ( $total * ( $amount['amount'] / 100 ) );
        	$bb = $total - $balance;
         	return number_format($bb,2);
        }
    } else {
        return 0;
    }
}

function discount_code_cart()
{
	if(session()->get('cart_discount')){
        $amount = session()->get('cart_discount');
        return $amount['code'];
    } else {
        return 0;
    }
}

function get_cart_destroy()
{
	return (new \App\Libraries\Cart())->destroy();
}

function checkItemCart()
{
	$result = [];
	if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
		foreach(get_cart_contents() as $cart){
			$result[] = $cart['id'];
		}
	}
	return $result;
}

function GetCartRowId($id)
{
	$result = [];
	if ( is_array(get_cart_contents()) && count(get_cart_contents()) > 0 ) {
		foreach(get_cart_contents() as $cart){
			if( $id == $cart['id'] ) {
				$result[] = [ $cart['rowid'], $cart['qty'] ];
			}
		}
	}
	return $result;
}

function calculateSubtotalTax($amount, $tax){
	$tax = (int) $tax;
	return number_format($amount * $tax / 100, 2);
}

/**
 * Create cart for api
 * @param array $product
 * @param integer $qty
 * @return array
 * @author M Nabeel Arshad
 */
function create_cart_for_api($product, $qty) {
	return  [
		'pid' => my_encrypt($product['product_id']),
		'pname' => $product['name'],
		'qtycart' => $qty,
		'itemprice' => number_format(($product['deal_enable'] > 0 ? $product['deal_final_price'] : $product['final_price']), 2),
		'item_image' => getImageThumg('products', $product['cover'], 100),
		'item_handle' => $product['handlingcharges'],
		'item_transfer' => $product['freeshipat'],
		'givewaytags' => '0',
		'attr' => $product['attr']
	];
}

/**
 * Validate requested attributes from api
 * @param array $providedAttrIds
 * @param array $attributes
 */
function validate_request_attributes($attr, $dbAttributes = [])
{
	if(empty($dbAttributes)) {
		return [
			'status' => true,
			'message' => 'No attributes found in the database.',
			'attr' => []
		];
	}
	// Extract required attribute IDs from the database
	$requiredAttrIds = array_column($dbAttributes, 'attr_id');

	$requiredAttrIds = array_map(function ($a) {
		return (int) $a;
	}, $requiredAttrIds);

	// Extract provided attribute IDs from the request
	$providedAttrIds = array_column($attr, 'id');

	// Check for missing attributes
	$missingAttributes = array_values(array_diff($requiredAttrIds, $providedAttrIds));

	if (!empty($missingAttributes)) {
		return [
			'status' => false,
			'message' => 'Missing required attributes. '.implode(', ', $missingAttributes),
			'missing_attributes' => $missingAttributes
		];
	}
	$attr_mixed = [];
	// Validate attribute values
	foreach ($dbAttributes as $dbAttribute) {
		$attrId = $dbAttribute['attr_id'];
		$dbValues = array_column($dbAttribute['values'], 'pattr_value_id');

		// Find the matching attribute in the request
		$providedAttr = array_filter($attr, function ($a) use ($attrId) {
			return $a->id == $attrId;
		});

		if (empty($providedAttr)) {
			continue;
		}

		$providedAttr = array_shift($providedAttr); // Extract the first match
		$providedValueId = $providedAttr->pattr_value_id;

		// Check if the provided value exists in the database values
		if (!in_array($providedValueId, $dbValues)) {
			return [
				'status' => false,
				'message' => "Invalid value for attribute ID $attrId.",
				'invalid_value' => $providedValueId
			];
		}
		$price = 0;
		foreach ($dbAttribute['values'] as $key => $v) {
			if ($v['pattr_value_id'] == $providedValueId) {
				$price = $v['price_value'];
			}
		}
		$id = my_encrypt($attrId);
		$value = my_encrypt($providedValueId);
		$attr_mixed[] = $id.'_'.$value.'_'.$price;

	}

	return [
		'status' => true,
		'message' => 'Request is valid.',
		'attr' => $attr_mixed
	];
}













