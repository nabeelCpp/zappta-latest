var baseUrl;

$(function(){

	
	$('#addtocard').click(function(e) {
		e.preventDefault();
		if(!checkRequiredFields()){
			$('.loader').show();
			var single = $('#single').val();
			var pid = $('#pid').val();
			var pname = $('#pname').val();
			var qtycart = $('#qtycart').val();
			var itemprice = $('#itemprice').val();
			var item_image = $('#item_image').val();
			var _ajax_request = $('#_ajax_request').val();
			var item_handle = $('#_data_handle').val();
			var item_transfer = $('#_data_transfer').val();
			var givewaytags = $('#givewaytags').val();
			var attr = $('.attr_hidden').map(function () { return this.value; }).get();

			let postObject = {
				single: single,
				pid: pid,
				pname: pname,
				qtycart: qtycart,
				itemprice: itemprice,
				item_image: item_image,
				_ajax_request: _ajax_request,
				item_handle: item_handle,
				item_transfer: item_transfer,
				givewaytags: givewaytags,
				attr: attr
			}

			const url = baseUrl + "cart/add";
			$.ajaxSetup({
	            beforeSend: function(xhr) {
	                xhr.setRequestHeader('X-CSRF-TOKEN', _ajax_request);
	            }
	        });
			$.ajax({
				url: url,
				type: 'POST',
				data: postObject,
				datatype: 'json',
				success: function(resp) {
					$('#cartList').text(resp);
					console.log('resp', resp);
					$('.loader').hide();
				}
			});
		}
		

		// console.log('attr', attr);
	});

	$('.proattr').click(function(){
			var name = $(this).data('name');
			var price_enable = $(this).data('attr-setprice');
			var price_value = $(this).data('attr-price');
			var price = $(this).data('price');
			var id = $(this).data('id');
			var value = $(this).data('value');
			var old_price = $(this).data('value');

			$('.attr_hidden_'+id).remove();
			$('.attr_hidden_price_'+id).remove();
			$('.inputhidden').append('<input type="hidden" name="attr[]" class="attr_hidden attr_hidden_'+id+'" value="'+id+'_'+value+'_'+price_value+'" />\
										<input type="hidden" class="attr_hidden_price attr_hidden_price_'+id+'" value="'+price_value+'" />');
			$('.nametext_'+id).text(name);
			$('.attr-ul-'+id+' li').removeClass('active-attr');
			$(this).addClass('active-attr');
			
			var attr = $('.attr_hidden_price').map(function () { return this.value; }).get();
			console.log('attr',calculator_price(attr));
			var new_price = (parseFloat(calculator_price(attr)) + parseFloat(price)).toFixed(2);
			var splitprice = new_price.split('.');
			$('#itemprice').val(new_price);
			$('#firstdigit').text(splitprice[0]);
			$('#seconddigit').text(splitprice[1]);
	});

	$('#decreament').click(function(){
		var price = $(this).data('price');
		var proid = $(this).data('id');
		var inputvalue = $('#inputvalue').text();
		if ( inputvalue > 1 ) {
			var newprice = (parseInt(price) * ( parseInt(inputvalue)  - 1)).toFixed(2);
			var newqty = parseInt(inputvalue) - 1;
			// $('.itemprice_'+proid).val(newprice);
			$('#inputvalue').text(newqty);
			$('#qtycart').val(newqty);
		}
	});

	$('#increament').click(function(){
		var price = $(this).data('price');
		var proid = $(this).data('id');
		var inputvalue = $('#inputvalue').text();
		if ( inputvalue >= 1 ) {
			var newprice = (parseInt(price) * ( parseInt(inputvalue)  + 1)).toFixed(2);
			var newqty = parseInt(inputvalue) + 1;
			// $('.itemprice_'+proid).val(newprice);
			$('#inputvalue').text(newqty);
			$('#qtycart').val(newqty);
		}
	});

	$('.removeButton').click(function(){
		var removeButton = $(this).data('row-id');
		$('.cart_row_'+removeButton).remove();
	});

	$('.gtw').click(function(){
		var gtw = $(this).data('gateway');
		$('.gateway .circle').removeClass('active-circle');
		// $('.'+this).addClass('gtw');
		$('.'+gtw + ' .circle').addClass('active-circle');
		$('#gateway').val(gtw);
		// alert(gtw);
	});

	$('#same_shipping').click(function(){
		$('#shipping_fields').toggle();
	});

});
function checkRequiredFields(){
	let required = $('.attr-ul');
	let errors = 0;
	required.each(function(){
		if(!$(this).find('li.active-attr').length){
			$(this).prev('.title').find('span').html('<small style="color: red;">Please select attribute</small>');
			errors++;
		}
	});
	if(errors){
		return true;
	}
	return false;
}
function calculator_price(someArray) {
  return someArray.reduce((howMuchSoFar,currentElementOfTheArray) => {
    howMuchSoFar = parseFloat(howMuchSoFar) + parseFloat(currentElementOfTheArray);
    return howMuchSoFar;
  });
}

function add_to_cart(ids)
{
		$('.loader').show();
		var pid = $('#ids_'+ids).data('id');
		var pname = $('#ids_'+ids).data('name');
		var itemprice = $('#ids_'+ids).data('price');
		var item_image = $('#ids_'+ids).data('image');
		var item_attr = $('#ids_'+ids).data('attr');
		var item_handle = $('#ids_'+ids).data('handle');
		var item_transfer = $('#ids_'+ids).data('transfer');
		let postObject = {
			single: 1,
			pid: pid,
			pname: pname,
			qtycart: 1,
			itemprice: itemprice,
			item_image: item_image,
			item_handle: item_handle,
			item_transfer: item_transfer,
			givewaytags: 0,
			attr: [item_attr]
		}
		const url = baseUrl + "cart/add";
		$.ajax({
			url: url,
			type: 'POST',
			data: postObject,
			datatype: 'json',
			success: function(resp) {
				$('#cartList').text(resp);
				console.log('resp', resp);
				$('.loader').hide();
			}
		});
}

function cart_table_decreament(ids)
{
	var price = $('.cart_row_'+ids+ '  .cartprice').data('price');
	var inputvalue = $('.cart_row_'+ids+ '  #inputvalue_'+ids).text();
	if ( inputvalue > 1 ) {
		var newprice = (parseInt(price) * ( parseInt(inputvalue)  - 1)).toFixed(2);
		var newqty = parseInt(inputvalue) - 1;
		$('.cart_row_'+ids+ '  .inputvalue').text(newqty);
		updateItemCart(ids , newqty);
	}
}

function cart_table_increament(ids)
{
	var price = $('.cart_row_'+ids+ '  .cartprice').data('price');
	var inputvalue = $('.cart_row_'+ids+ '  #inputvalue_'+ids).text();
	if ( inputvalue >= 1 ) {
		var newprice = (parseInt(price) * ( parseInt(inputvalue)  - 1)).toFixed(2);
		var newqty = parseInt(inputvalue) + 1;
		$('.cart_row_'+ids+ '  .inputvalue').text(newqty);
		updateItemCart(ids , newqty);
		// $('#qtycart').val(newqty);
	}
}

function updateItemCart(rowid , qty)
{
    $('.loader').show();
    $.ajax({
        url: baseUrl+'/cart/update_cart',
        type: 'POST',
        datatype: 'JSON',
        data: { 'rowid' : rowid ,  'qty' : qty },
        success: function(resp){
            // $('#headerCart span').text(resp);
            $('.loader').hide();
            location.reload();
        }
    });
}

function deleteQtyFromCart(ids)
{
    var itemqty = $('#itemqty'+ids).val();
    var itemrow = $('#itemqty'+ids).attr('data-row');
    var priceAdd = $('#itemqty'+ids).attr('data-p');
    var itemid = $('#itemqty'+ids).attr('data-id');
    var itemname = $('#itemqty'+ids).attr('data-name');
    if(itemqty > 0) {
        if ( itemqty == 1 ) {

        } else {
            var qty = parseInt(itemqty) - 1;
            updateItemCart(itemrow , qty);
            var newPrice = parseFloat(priceAdd) * qty;
            console.log('newPrice',newPrice);
            $('#itemqty'+ids).val(qty);
            $('#cartPrice'+ids+' span').text(newPrice.toFixed(2));
            $('#pPrive').val(newPrice.toFixed(2));
        }
    } 
}


function deleteItem(ids)
{
    $('.loader').show();
    $.ajax({
        url: baseUrl+'/cart/delete_item_cart',
        type: 'POST',
        datatype: 'JSON',
        data: { 'rowid' : ids },
        success: function(resp){
            $('#cartList').text(resp);
            $('.loader').hide();
            $('.cart_row_'+ids).remove();
            if ( resp == 0 ) {
                $('#cartModal').modal('hide');
                location.reload();
            }
        }
    });
}


function checkPlayAndWin()
{
	var givewayplay = $(".givewayplay:checked").val();
    if (givewayplay === undefined || givewayplay === null) {
    	alert('Please select atleast one product');
    } else {
    	window.location.href = baseUrl + 'compaign/verify/'+givewayplay;
    }
}


