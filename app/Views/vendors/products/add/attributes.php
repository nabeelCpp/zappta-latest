	<div class="row">

		<div class="cataddblock mt-4" id="treecontainer">
			<?php  
				$cat_list = (new App\Models\CategoriesModel())->getAllCategoryTreeForVendor();
				$cat_tree = buildTreeForVendor($cat_list); 
				$select_cat_post = isset($getData['product_category']) ? $getData['product_category'][0] : '';
			?>
			<input type="hidden" name="product_category[]" id="product_category_list" data-required="Product category is required" required value="<?php print $select_cat_post;?>">
			<input type="hidden" name="product_brand_all" id="product_brand_all" value="<?php print isset($getData['product_brand_all']) ? $getData['product_brand_all'] : '';?>">
			<input type="hidden" name="attributes_brand_all" id="attributes_brand_all" value="<?php print isset($getData['attributes_brand_all']) ? $getData['attributes_brand_all'] : '';?>">
	    </div>

	    <div class="cataddblock mt-4">
	    	<div class="form-group">
	    		<?php  $old_brand_id = isset($getData['product_brand_all']) && $getData['product_brand_all'] ? unserialize(my_decrypt($getData['product_brand_all'])) : '';?>
	    		<label>Select Brand</label>
	    		<select class="form-control" id="productBrand" name="product[default][brand_id]">
	    		<?php if ( is_array($old_brand_id) && count($old_brand_id) > 0 ) { ?>
	    			<option value="0">Select Brand</option>
	    			<?php 
	    				foreach ( $old_brand_id as $bbid ) {
	    			?>
	    			<option value="<?php print $bbid['id'];?>"<?php if ( $getData['product']['default']['brand_id'] == $bbid['id'] ) { ?> selected <?php }?>><?php print $bbid['name']?></option>
	    			<?php
	    				}
	    			?>
	    		<?php } ?>
	    		</select>
	    	</div>
	    </div>

	    <div class="cataddblock mt-4">
	    	<div class="form-group">
	    		<?php  $old_attributes_id = isset($getData['attributes_brand_all']) && $getData['attributes_brand_all'] ? unserialize(my_decrypt($getData['attributes_brand_all'])) : '';?>
	    		<label>Select Attributes</label>
	    		<select class="form-control" id="productAttributes" onchange="getAttributeValue()">
	    		<?php if ( is_array($old_attributes_id) && count($old_attributes_id) > 0 ) { ?>
	    			<option value="0">Select Brand</option>
	    			<?php 
	    				foreach ( $old_attributes_id as $abbid ) {
	    			?>
	    			<option value="<?php print $abbid['id'];?>" <?=isset($getData['product_attribute']) && array_key_exists($abbid['id'], $getData['product_attribute']['selected']) ? 'disabled' :''?>><?php print $abbid['name_en']?></option>
	    			<?php
	    				}
	    			?>
	    		<?php } ?>
	    		</select>
	    	</div>
	    	<div id="valueAppendBlock">
	    	<?php 
	    		if ( isset($getData['product_attribute']['selected']) && is_array( $getData['product_attribute']['selected'] ) && count( $getData['product_attribute']['selected'] ) > 0 ) {
	    			foreach ( $getData['product_attribute']['selected'] as $selected ) {
	    				$old_attr =  my_decrypt($selected);
	    				$result = (new \App\Models\AttributeValueModel())->getValueByAttrbuteForProduct($old_attr);
	    				if ( is_array($result) && count($result) > 0 ) {
	    					$html = '<div class="valueblock" id="vvb_'.$old_attr.'">
	                        <h3>'.$result[0]['attr_name'].'</h3>
	                        <div class="value_row d-flex">
	                               <div class="check"></div>
	                               <div class="name">Name</div>
	                               <div class="price">Price Increament</div>
								   <div class="price mx-1">Quantity</div>
	                          </div>';
					            foreach ( $result as $rr ) {
					            	if ( !empty($rr) ) {
						                if ( $rr['value_opt'] == 2 ) {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"';
						                        if ( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists($rr['id'], $getData['product_attribute']['value'][$rr['attr_id']] )) {
						                        	$html .= 'checked';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name"><span class="color" style="background-color: #'.$rr['color_code'].';"></span><span>'.$rr['name_en'].'</span></div>
						                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]"';
						                        if ( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists($rr['id'], $getData['product_attribute']['value'][$old_attr] )) {
						                        	$html .= ' value="'.$getData['product_attribute']['value'][$rr['attr_id']][$rr['id']]['price'].'"';
						                        } else {
						                        	$html .= ' value="0" disabled';
						                        }
						                        $html .= '></div><div class="price mx-1"><input type="number" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][qty]" id="vq_'.$rr['id'].'" min="0" value="'.($getData['product_attribute']['value'][$rr['attr_id']][$rr['id']]['qty'] ?? 0).'" '.(( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists($rr['id'],$getData['product_attribute']['value'][$old_attr] ) ) ? '' : 'disabled').'></div>
						                              </div>';
						                } else {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"';
						                        if ( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists( $rr['id'], $getData['product_attribute']['value'][$rr['attr_id']] ) ) {
						                        	$html .= 'checked';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name">'.$rr['name_en'].'</div>
						                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]"';
						                        if ( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists($rr['id'], $getData['product_attribute']['value'][$old_attr] )) {
						                        	$html .= ' value="'.$getData['product_attribute']['value'][$rr['attr_id']][$rr['id']]['price'].'"';
						                        } else {
						                        	$html .= ' value="0" disabled';
						                        }
						                        $html .= '></div><div class="price mx-1"><input type="number" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][qty]" id="vq_'.$rr['id'].'" min="0" value="'.($getData['product_attribute']['value'][$rr['attr_id']][$rr['id']]['qty'] ?? 0).'" '.(( !empty($getData['product_attribute']['value'][$old_attr]) && array_key_exists($rr['id'],$getData['product_attribute']['value'][$old_attr] ) ) ? '' : 'disabled').'></div>
						                              </div>';
						                }
						            }
					            }
				            $html .= '</div><input type="hidden" name="product_attribute[selected]['.$old_attr.']" value="'.my_encrypt($old_attr).'"/>';
				            print $html;
	    				}
	    			}
	    		}
	    	?>
	    	</div>
	    </div>
	</div>


<script src="<?php print base_url();?>/theme/js/vendors/js/tree.js"></script>
<script type="text/javascript">
	// const myTree = new Tree('#treecontainer', {
	//   data: <?php print json_encode(buildTreeForVendor($cat_list));?>,
	// });
	$('#treecontainer').flexTree({
	  items: <?php print json_encode(buildArrayData($cat_tree,$select_cat_post));?>,
	  type: 'radio',
	  // targetElement: function(e){},
	  name: 'flex_tree',
	  addControlOnParent: true,
	  collapsed: true,
	});

	$('.node,.leaf').click(function(){
		var leaf = $(this).val();
		var valueAppendBlock = $('#valueAppendBlock .valueblock').length;
		if ( leaf > 0 ) {
			$('#product_category_list').val(leaf);
			if ( valueAppendBlock > 0 && confirm('Are you sure to change the category? All attributes setting reset after changing the category') == false ) {

			} else {
				$('.loader').show();
				$('#valueAppendBlock .valueblock').remove();
				$.ajax({
					url: '<?php print base_url().'/vendors/products/getbrand';?>',
					type: 'get',
					data: { catid: leaf },
					datatype: "JSON",
					success: function(resp)
					{
						var r = JSON.parse(resp);
						if ( r !== 0 ) {
							$('#productBrand option,#productAttributes option').remove();
							$('#productBrand').append('<option value="0">Select Brand</option>');
							$.each(r.brands, function(key,index){
								$('#productBrand').append('<option value="'+index.id+'">'+index.name+'</option>');
							});
							$('#productAttributes').append('<option value="0">Select Attribute</option>');
							$.each(r.attributes, function(keys,indexs){
								$('#productAttributes').append('<option value="'+indexs.id+'">'+indexs.name_en+'</option>');
							});
							$('#attributes_brand_all').val(r.attributesall);
							$('#product_brand_all').val(r.brandsall);
						} else {
							$('#productBrand option,#productAttributes option').remove();
							$('#productBrand,#productAttributes').append('<option value="0">No result found</option>');
							$('#attributes_brand_all').val('');
							$('#product_brand_all').val('');
						}
						$('.loader').hide();
					}
				});
			}
		}
	});

	function getAttributeValue()
	{
		var productAttributes = $('#productAttributes').val();
		if ( $('#vvb_'+productAttributes).length == 0 ) {
			if ( productAttributes > 0 ) {
				$.ajax({
					url: '<?php print base_url().'/vendors/products/getAttributes';?>',
					type: 'get',
					data: { productAttributes: productAttributes },
					datatype: "JSON",
					success: function(resp)
					{
						var r = JSON.parse(resp);
						if ( r !== 0 ) {
							$("#productAttributes option[value='"+ productAttributes + "']").attr('disabled', true); 
							$('#valueAppendBlock').prepend(r);
						}
						// console.log(resp);
					}
				});
			}
		} else {
			$("#productAttributes option[value='"+ productAttributes + "']").attr('disabled', true); 
		}
	}

	function enablepriceblock(ids)
	{
		if ( $('#vbv_'+ids).is(':checked') ) {
			$('#vsvs_'+ids).attr('disabled',false);
			$('#vq_'+ids).attr('disabled',false);
		} else {
			$('#vsvs_'+ids).attr('disabled',true);
			$('#vq_'+ids).attr('disabled',true);
		}
	}

</script>