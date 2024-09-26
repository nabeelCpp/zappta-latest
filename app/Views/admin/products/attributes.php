<style type="text/css">
	
/* UL items list */
ul.flex-tree,
ul.flex-tree ul {
	list-style: none;
	padding-left: 34px;
}

ul.flex-tree label {
	font-weight: normal;
}

ul.flex-tree li{
	position: relative;
	margin: 5px auto;
}
ul.flex-tree li label,
ul.flex-tree li span,
ul.flex-tree li span label {
	cursor: pointer;
}

ul.flex-tree li span.open:after,
ul.flex-tree li span.closed:after {
	content: "\025BE";
	display: inline-block;
	font: 400 30px/1 Arial, "Helvetica Neue", Helvetica, sans-serif;
	width: 20px;
	margin-top: 4px;
	padding-left: 3px;
	color: #ababab;
	position: absolute;
	top: 0;
	left: 0;
	margin-left: -30px;
	margin-top: -5px;
}

ul.flex-tree li span.closed:after {
	content: "\025B4";
}

ul.flex-tree label.node {
	font-weight: bold;
}

/* Checkboxes */
ul.flex-tree input[type="checkbox"],
ul.flex-tree input[type="radio"] {
	border: 1px solid #b4b9be;
	background: #fff;
	color: #555;
	clear: none;
	cursor: pointer;
	display: inline-block;
	line-height: 0;
	height: 16px;
	margin: -4px 4px 0 0;
	outline: 0;
	padding: 0;
	text-align: center;
	vertical-align: middle;
	width: 16px;
	min-width: 16px;
	-webkit-appearance: none;
	box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
	transition: 0.05s border-color ease-in-out;
}

ul.flex-tree input[type="radio"] {
	border-radius: 50%;
	margin-right: 4px;
	line-height: 10px;
}

ul.flex-tree input[type="checkbox"]:focus,
ul.flex-tree input[type="radio"]:focus {
	border-color: #5b9dd9;
	box-shadow: 0 0 2px rgba(30, 140, 190, 0.8);
}

ul.flex-tree input[type="radio"]:checked:before,
ul.flex-tree input[type="checkbox"]:checked:before,
ul.flex-tree input[type="checkbox"]:indeterminate:before {
	float: left;
	display: inline-block;
	vertical-align: middle;
	width: 16px;
	font: 400 20px/1 Arial, "Helvetica Neue", Helvetica, sans-serif;
	speak: none;
	-webkit-font-smoothing: antialiased;
}

ul.flex-tree input[type="checkbox"]:checked:before {
	content: "\02713";
	margin: -3px 0 0 -2px;
	color: #1e8cbe;
}

ul.flex-tree input[type="checkbox"].indeterminate {
	background-color: #eee;
}

ul.flex-tree input[type="checkbox"]:indeterminate:before {
	content: "\02043";
	color: #1e8cbe;
	margin: -3px 0 0 -1px;
}

ul.flex-tree input[type="radio"]:checked:before {
	content: "\2022";
	text-indent: -9999px;
	border-radius: 50px;
	font-size: 24px;
	width: 6px;
	height: 6px;
	margin: 4px;
	line-height: 16px;
	background-color: #1e8cbe;
}
/* UL items list */
ul.flex-tree,
ul.flex-tree ul {
	list-style: none;
	padding-left: 34px;
}

ul.flex-tree label {
	font-weight: normal;
}

ul.flex-tree li label,
ul.flex-tree li span,
ul.flex-tree li span label {
	cursor: pointer;
}

ul.flex-tree li span.open:after,
ul.flex-tree li span.closed:after {
	content: "\025BE";
	display: inline-block;
}

ul.flex-tree li span.closed:after {
	content: "\025B4";
}

ul.flex-tree label.node {
	font-weight: bold;
}
#valueAppendBlock{
	padding: 11px;
	display: block;
	width: 100%;
}
.valueblock{
	width: 100%;
	display: block;
	/*border: 1px solid #FFFFFF;*/
	margin: 10px auto;
	box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
}
.valueblock h3{
	width: 100%;
	display: block;
	font-size: 18px;
	background: #FFFFFF;
	padding: 10px;
}
.value_row{
	width: calc(100% - 10px);
	background-color: #FFFFFF;
	box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px;
	margin: 5px;
	padding: 10px;
	align-items: center;
}
.value_row .check{
	width: 30px;
}
.value_row .name{
	width: calc(100% - 150px);
	font-size: 13px;
}
.value_row .name span{
	display: table-cell;
	padding-left: 5px;
}
.value_row .name .color{
	width: 20px;
	height: 20px;
	margin-right: 5px;
	box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
}
.value_row .price{
	width: 120px;
	font-size: 13px;
}
.value_row .price input{
	width: 100%;
	border: 1px solid #EEEEEE;
	padding: 3px;
}
</style>	
	<div class="row">

		<div class="cataddblock mt-4" id="treecontainer">
			<?php  
				$cat_list = (new App\Models\CategoriesModel())->getAllCategoryTreeForVendor();
				$cat_tree = buildTreeForVendor($cat_list); 
				$select_cat_post = (new \App\Models\ProductsCategoriesModel())->getAdminByStoreId($default['pid']);
				// print $select_cat_post;
			?>
	    </div>

	    <div class="cataddblock mt-4">
	    	
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
					            	if ( !empty($rr) ) {
						                if ( $rr['value_opt'] == 2 ) {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" disabled class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" ';
						                        if ( !empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] )) {
						                        	$html .= 'checked disabled';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name"><span class="color" style="background-color: #'.$rr['color_code'].';"></span><span>'.$rr['name_en'].'</span></div>
						                                   <div class="price"><input type="number" disabled id="vsvs_'.$rr['id'].'"';
						                        if ( !empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] )) {
						                        	$html .= ' value="'.$selected_value[$rr['attr_id']][$rr['id']]['price'].'"';
						                        } else {
						                        	$html .= ' value="0" disabled';
						                        }
						                        $html .= '></div>
						                              </div>';
						                } else {
						                    $html .= '<div class="value_row d-flex">
						                                   <div class="check"><input type="checkbox" disabled class="valuecheck" value="'.my_encrypt($old_attr.'_'.$rr['attr_id'].'_'.$rr['id'].'_'.$rr['value_opt']).'" id="vbv_'.$rr['id'].'" ';
						                        if (!empty($selected_value[$old_attr]) && array_key_exists($rr['id'], $selected_value[$rr['attr_id']] ) ) {
						                        	$html .= 'checked disabled';
						                        }    
						                    	$html .= ' ></div>
						                                   <div class="name">'.$rr['name_en'].'</div>
						                                   <div class="price"><input type="number" disabled id="vsvs_'.$rr['id'].'"';
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
					        $html .= '</div>';    
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
	$('#treecontainer').flexTree({
	  items: <?php print json_encode(adminDisplayTree($cat_tree,$select_cat_post));?>,
	  type: 'radio',
	  // targetElement: function(e){},
	  name: 'flex_tree',
	  addControlOnParent: true,
	  collapsed: false,
	});
</script>