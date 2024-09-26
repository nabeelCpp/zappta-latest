	<div class="row">

		<div class="cataddblock mt-4" id="treecontainer">
			<?php  
				$cat_list = (new App\Models\CategoriesModel())->getAllCategoryTreeForVendor();
				$cat_tree = buildTreeForVendor($cat_list); 
				$select_cat_post = (new \App\Models\ProductsCategoriesModel())->getByStoreId($default['pid']);
				// print '<pre>';
	   //  		print_r($default);
	   //  		print '</pre>';
	   //  		die();
			?>
			<input type="hidden" name="product_category[]" data-required="Product category is required" required id="product_category_list" value="<?php print $select_cat_post;?>">
			<input type="hidden" name="product_brand_all" id="product_brand_all" value="<?php print isset($getData['product_brand_all']) ? $getData['product_brand_all'] : '';?>">
			<input type="hidden" name="attributes_brand_all" id="attributes_brand_all" value="<?php print isset($getData['attributes_brand_all']) ? $getData['attributes_brand_all'] : '';?>">
	    </div>

	    <div class="cataddblock mt-4">
	    	<div class="form-group">
	    		<?php  $old_brand_id = (new App\Models\CategoriesModel())->getSelectBrand($select_cat_post);?>
	    		<label>Select Brand</label>
	    		<select class="form-control" id="productBrand" name="product[default][brand_id]">
	    		<?php if ( is_array($old_brand_id) && count($old_brand_id) > 0 ) { ?>
	    			<option value="0">Select Brand</option>
	    			<?php 
	    				foreach ( $old_brand_id as $bbid ) {
	    			?>
	    			<option value="<?php print $bbid['id'];?>"<?php if ( $default['brand_id'] == $bbid['id'] ) { ?> selected <?php }?>><?php print $bbid['name']?></option>
	    			<?php
	    				}
	    			?>
	    		<?php } ?>
	    		</select>
	    	</div>
	    </div>

	    <div class="cataddblock mt-4">
	    	<div class="form-group">
	    		<?php  
	    			$old_attributes_id = (new App\Models\CategoriesModel())->getSelectAttribute($select_cat_post);
	    			$selected_attr = isset($default['product_value']) ? unserialize($default['product_value']) : [];
	    		?>
	    		<label>Select Attributes</label>
	    		<select class="form-control" id="productAttributes" onchange="getAttributeValue()">
	    		<?php if ( is_array($old_attributes_id) && count($old_attributes_id) > 0 ) { ?>
	    			<option value="0">Select Brand</option>
	    			<?php 
	    				foreach ( $old_attributes_id as $abbid ) {
	    			?>
	    			<?php if ( is_array($selected_attr) && count($selected_attr) > 0 ) {?>
	    			<option value="<?php print $abbid['id'];?>"<?php if ( array_key_exists($abbid['id'], $selected_attr) ) { ?> disabled <?php } ?>><?php print $abbid['name_en']?></option>
		    		<?php } else { ?>
	    			<option value="<?php print $abbid['id'];?>"><?php print $abbid['name_en']?></option>
		    		<?php } ?>
	    			<?php
	    				}
	    			?>
	    		<?php } ?>
	    		</select>
	    	</div>
	    	<div id="valueAppendBlock">
	    	<?php 
	    		$attributes_l = ( new \App\Models\ProductsAttributeModel() )->getAttributesById( $default['pid'] );
	    		$selected_value = unserialize($default['product_value']);
	    		if ( is_array( $attributes_l ) && count( $attributes_l ) > 0 ) {
	    			foreach ( $attributes_l as $selected ) {
	    					$old_attr =  $selected['attr_id'];
	    					$html = '<div class="valueblock" id="vvb_'.$old_attr.'">
	                        <h3>'.$selected['name_en'].'</h3>
	                        <div class="value_row d-flex">
	                               <div class="check"></div>
	                               <div class="name">Name</div>
	                               <div class="price">Price Increament</div>
	                          </div>';
	    				$result = (new \App\Models\AttributeValueModel())->getValueByAttrbuteForProduct($old_attr);
	    				if ( is_array($result) && count($result) > 0 ) {
					            foreach ( $result as $rr ) {
					            	//$selected_value = ( new \App\Models\ProductsAttributeModel() )->getByStoreId( $default['pid'],0,$rr['attr_id'],$rr['id'] );
					            	// print_r($selected_value);
					            	if ( !empty($rr) ) {
						                if ( $rr['value_opt'] == 2 ) {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"';
						                        if ( !empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] )) {
						                        	$html .= 'checked';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name"><span class="color" style="background-color: #'.$rr['color_code'].';"></span><span>'.$rr['name_en'].'</span></div>
						                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]"';
						                        if ( !empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] )) {
						                        	$html .= ' value="'.$selected_value[$rr['attr_id']][$rr['id']]['price'].'"';
						                        } else {
						                        	$html .= ' value="0" disabled';
						                        }
						                        $html .= '></div>
						                              </div>';
						                } else {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][name]" class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" onclick="enablepriceblock('.$rr['id'].');"';
						                        if (!empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] ) ) {
						                        	$html .= 'checked';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name">'.$rr['name_en'].'</div>
						                                   <div class="price"><input type="number" id="vsvs_'.$rr['id'].'" name="product_attribute[value]['.$rr['attr_id'].']['.$rr['id'].'][price]"';
						                        if ( !empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] ) ) {
						                        	$html .= ' value="'.$selected_value[$rr['attr_id']][$rr['id']]['price'].'"';
						                        } else {
						                        	$html .= ' value="0" disabled';
						                        }
						                        $html .= '></div>
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
		} else {
			$('#vsvs_'+ids).attr('disabled',true);
		}
	}

</script>