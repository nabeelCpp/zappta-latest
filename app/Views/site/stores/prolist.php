				<?php 
					if ( is_array($count) && count($count) > 0 ) {
						$sr=1;
						foreach($count as $p) {
		    				// print '<pre>';
		    				// print_r($p);
		    				// print '</pre>';
		    				if (  !empty($filter['size']) || !empty($filter['color']) || !empty($filter['dimension']) || !empty($filter['paper_type'])  &&  !isset($filter['page']) ) {
		    					$value_price = explode(',',$p['value_price']);
		    					$pr_rr = [];
		    				// print '<pre>';
		    				// print_r($value_price);
		    				// print '</pre>';
		    					if ( !empty($value_price) && is_array($value_price) && count($value_price) > 0 ) {
		    						foreach( $value_price as $pp ) {
		    							$valprice = explode('_', $pp);
		    							$pr_rr[] = end($valprice);
		    						}
		    					}
		    					$increments_amount = !empty($filter) ? array_sum($pr_rr) : 0;
		    					$product_id_value_price = !empty($filter) ? $p['value_price'] : 0;
			    				$attr_url = '';//!empty($filter) ? '&a='.$filter['a'].'&gta='.$product_id_value_price : '';
			    			} else {
			    				$attr_url = '';
			    				$increments_amount = 0;
			    				$product_id_value_price = 0;
			    			}
							if (  $p['deal_enable'] > 0 ) {
								$dataprice = ($p['deal_final_price'] + $increments_amount);
							} else {
								$dataprice = ($p['final_price'] + $increments_amount);
							}
		    				if( ! empty( $p['pcover'] ) ) { 
		    					$ext_name = explode('.',$p['pcover']);
		    					$dataimg  = base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/250';
		    				} else {
		    					$dataimg  = base_url().'/images/product/img-not-found/jpg/100';
		    				}
				?>		
				
				
					<div  style="max-width:310px; min-width:310px;" class=" mb-4 related-pro">
						<div class="pro-list animate" id="pblock_<?php print $sr;?>">
							<div class="hover-button">
								<ul>
									<li>
										<button type="button" class="btn" id="ids_<?php print my_encrypt($p['pid']);?>" onclick='window.location.href = "<?php print base_url().'/products/'.$p['purl'].'/p/'.$p['pc'].'/'.'?sd_row='.$p['sd_row'].'&pds='.$p['pds'].$attr_url;?>"' data-id="<?php print my_encrypt($p['pid']);?>" data-name="<?php print $p['pname'];?>" data-price="<?php print $dataprice;?>" data-image="<?php print $dataimg;?>" data-attr="<?php print $product_id_value_price;?>" data-handle="<?php print $p['handlingcharges'];?>" data-transfer="<?php print $p['freeshipat'];?>">
											<span><i class="fa-solid fa-bag-shopping"></i></span>
										</button>
									</li>
									<li>
										<button type="button" class="btn" onclick="add_item_wish('<?php print my_encrypt($p['pid']);?>','<?php print my_encrypt($p['pds']);?>',<?php print $sr;?>);">
											<span><i class="fa-regular fa-heart"></i></span>
										</button>
									</li>
								</ul>
							</div>
							<a href="<?php print base_url().'/products/'.$p['purl'].'/p/'.$p['pc'].'/'.'?sd_row='.$p['sd_row'].'&pds='.$p['pds'].$attr_url;?>">
								<div class="pro-img">
									<?php 
					    				if( ! empty( $p['pcover'] ) ) { 
					    					$ext_name = explode('.',$p['pcover']);
					    			?>
					    				<img src="<?php print base_url().'/images/product/'.$ext_name[0].'/'.$ext_name[1].'/350';?>" class="animate" alt="">
					    			<?php } else { ?>
					    				<img src="<?php print base_url().'/images/product/img-not-found/jpg/100';?>" class="animate" alt="">
					    			<?php }?>
								</div>
								<div class="pro-detail">
									<small><?php print short($p['pshort'],25);?></small>
									<h3><?php print short($p['pname'],35);?></h3>
									<div class="rating d-flex">
										<div class="stars d-flex">
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
											<i class="fa-solid fa-star"></i>
										</div>
										<div class="arrow-popup"><i class="fa-solid fa-angle-down"></i></div>
										<div class="rating-count">0</div>
										<div style="margin-left: auto" class="add_To_Spree" data-id="<?=$p['pid']?>"></div>
									</div>
									<div class="price">
									<?php 
										if (  $p['deal_enable'] > 0 ) {
											$inc_price = ($p['deal_final_price'] + $increments_amount);
											$price = explode('.',trim($inc_price));
									?>
										<?php if ( is_array($price) && count($price) > 1 ) { ?>
										<span>
											<small>$</small>
											<span><?php print $price[0];?></span>
											<small><?php print $price[1];?></small>
										</span>
									<?php } else { ?>
										<?php  $inc_price = ($p['deal_final_price'] + $increments_amount);?>		
										<span>
											<small>$</small>
											<span><?php print $inc_price;?></span>
											<small>00</small>
										</span>
									<?php } ?>
										<span class="ms-3 mt-2"><del>$<?php print number_format( ( $p['final_price']  + $increments_amount ) ,2)?></del></span>
									<?php } else { ?>
										<?php 
											$inc_price = ($p['final_price'] + $increments_amount);
											$price = explode('.',trim($inc_price));
											if ( is_array($price) && count($price) > 1 ) {
										?>
										<span>
											<small>$</small>
											<span><?php print $price[0];?></span>
											<small><?php print $price[1];?></small>
										</span>
										<?php } else { ?>
										<?php  $inc_price = ($p['final_price'] + $increments_amount);?>	
										<span>
											<small>$</small>
											<span><?php print $inc_price;?></span>
											<small>00</small>
										</span>
									<?php } ?>
									<?php } ?>
    									
									</div>
									<?php if(isset($store) && $store['earn_zappta']){ ?>
										<div class="price-zaptta d-flex">
											<span>Earn</span>
											<span>
												<svg xmlns="http://www.w3.org/2000/svg" width="9" height="20" viewBox="0 0 9 20">
												<g id="Group_667" data-name="Group 667" transform="translate(-1129 -531)">
													<text id="Z" transform="translate(1129 547)" fill="#1f961b" font-size="15" font-family="OpenSans, Open Sans"><tspan x="0" y="0">Z</tspan></text>
													<g id="Rectangle_4131" data-name="Rectangle 4131" transform="translate(1133 546.5)" fill="none" stroke="#1f961b" stroke-width="1">
													<rect width="1.2" height="2" stroke="none"/>
													<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
													</g>
													<g id="Rectangle_4132" data-name="Rectangle 4132" transform="translate(1133 535)" fill="none" stroke="#1f961b" stroke-width="1">
													<rect width="1.2" height="2" stroke="none"/>
													<rect x="0.5" y="0.5" width="0.2" height="1" fill="none"/>
													</g>
												</g>
												</svg>
											</span>
											<span><?=$store['earn_zappta']?> per $<?=$store['per_dollar']?> spent</span>
										</div>
										
									<?php } ?>
								</div>
							</a>
						</div>
					</div>
				<?php 
							$sr++;
						}
					}
				?>