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











