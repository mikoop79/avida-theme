<div class="<?php echo $this -> pre; ?>product">
	<?php if (!is_feed() && current_user_can('checkout_products')) : ?>
		<p><small>
			<?php echo $wpcoHtml -> link(__('Edit Product', $this -> plugin_name), $wpcoHtml -> product_save_url($product -> id)); ?> |
			<?php echo $wpcoHtml -> link(__('Delete Product', $this -> plugin_name), $wpcoHtml -> product_delete_url($product -> id), array('onclick' => "if (!confirm('" . __('Are you sure you wish to remove this product?', $this -> plugin_name) . "')) { return false; }")); ?>
		</small></p>
	<?php endif; ?>

	<?php if ($this -> get_option('product_imagegallery') == "jqzoom" && $this -> is_plugin_active('jqzoom')) : ?>
    	<!-- Zoom Effect -->
        <div class="<?php echo $this -> pre; ?>jqzoom <?php echo $this -> pre; ?>images">
        	<div class="<?php echo $this -> pre; ?>productimage">
                <a href="<?php echo $wpcoHtml -> image_url($product -> image -> name); ?>" title="<?php echo esc_attr($product -> title); ?>" class="jqzoom" rel="jqzoom<?php echo $product -> id; ?>">
                    <?php echo $wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('thumbw'), $this -> get_option('thumbh'), $this -> get_option('thumbq')); ?>
                </a>
            </div>
            
             <?php if (!empty($product -> images)) : ?>
                <div class="<?php echo $this -> pre; ?>imglist" style="width:<?php echo $this -> get_option('thumbw'); ?>px;">
                    <ul id="thumblist" style="width:<?php echo ((int) $this -> get_option('thumbw') + 22); ?>px; float:left; overflow:hidden;">
                        <li><a title="<?php echo esc_attr(apply_filters($this -> pre . '_product_title', $product -> title)); ?>" class="zoomThumbActive" href="javascript:void(0);" rel="{
                        	gallery:'jqzoom<?php echo $product -> id; ?>',
                        	smallimage:'<?php echo $wpcoHtml -> timthumb_url(); ?>?src=<?php echo $product -> image_url; ?>&w=<?php echo $this -> get_option('thumbw'); ?>&h=<?php echo $this -> get_option('thumbh'); ?>&q=<?php echo $this -> get_option('thumbq'); ?>',
                        	largeimage:'<?php echo $wpcoHtml -> image_url($product -> image -> name); ?>'
                        	}"><img src="<?php echo $wpcoHtml -> timthumb_url(); ?>?src=<?php echo $product -> image_url; ?>&w=<?php echo $this -> get_option('smallw'); ?>&h=<?php echo $this -> get_option('smallh'); ?>&q=<?php echo $this -> get_option('smallq'); ?>" /></a></li>
                        <?php foreach ($product -> images as $image) : ?>
                            <li><a title="<?php echo esc_attr($image -> title); ?>" href="javascript:void(0);" rel="{
                            	gallery:'jqzoom<?php echo $product -> id; ?>',
                            	smallimage:'<?php echo addslashes($wpcoHtml -> timthumb_url() . '?src=' . $image -> image_url . '&w=' . $this -> get_option('thumbw') . '&h=' . $this -> get_option('thumbh') . '&q=' . $this -> get_option('thumbq')); ?>',
                            	largeimage:'<?php echo $wpcoHtml -> image_url($image -> filename); ?>',
                            	title:'<?php echo esc_attr($image -> title); ?>'
                            	}"><img src="<?php echo $wpcoHtml -> timthumb_url(); ?>?src=<?php echo $image -> image_url; ?>&w=<?php echo $this -> get_option('smallw'); ?>&h=<?php echo $this -> get_option('smallh'); ?>&q=<?php echo $this -> get_option('smallq'); ?>" /></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <br class="<?php echo $this -> pre; ?>cleaner" />
                </div>
            <?php endif; ?>
        </div>
    <?php else : ?>
    	<!-- Lightbox (Colorbox) effect -->
        <div class="<?php echo $this -> pre; ?>images">
            <?php if ($this -> get_option('cropthumb') == "Y") : ?>
                <?php $imagefull = WP_CONTENT_DIR . DS . 'uploads' . DS . $this -> plugin_name . DS . 'images' . DS . $product -> image -> name; ?>
                <?php if (file_exists($imagefull) && filesize($imagefull) > 0) : ?>
                    <div>
                        <?php /*<?php echo $wpcoHtml -> link($wpcoHtml -> image($wpcoHtml -> thumb_name($product -> image -> name), false, $product -> image -> name), $wpcoHtml -> image_url($product -> image -> name), array('class' => 'thickbox', 'rel' => $wpcoHtml -> sanitize($product -> title) . '-images', 'title' => $product -> title)); ?>*/ ?>
                        <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('thumbw'), $this -> get_option('thumbh'), $this -> get_option('thumbq'), false), $wpcoHtml -> image_url($product -> image -> name), array('class' => "colorbox", 'rel' => $wpcoHtml -> sanitize($product -> title) . '-images', 'title' => $product -> title)); ?>
                    </div>
                    <span class="clicktoenlarge"><?php echo $wpcoHtml -> link($wpcocaptions['product']['clicktoenlarge'], $wpcoHtml -> image_url($product -> image -> name), array('class' => "colorbox", 'title' => esc_attr($product -> title))); ?></span>
                <?php else : ?>
                    <div><?php echo $wpcoHtml -> image($wpcoHtml -> thumb_name($product -> image -> name), false, $product -> image -> name); ?></div>
                <?php endif; ?>
            <?php else : ?>
                <div><?php echo $wpcoHtml -> image($product -> image -> name, false, $product -> image -> name); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($product -> images)) : ?>
                <?php if ($this -> get_option('gallerytab') == "N" || ($this -> get_option('gallerytab') == "Y" && empty($product -> contents))) : ?>
                    <div class="<?php echo $this -> pre; ?>imglist">						
                        <ul>
                            <?php $imgcount = 1; ?>
                            <?php foreach ($product -> images as $image) : ?>
                                <?php if ($imgcount <= $this -> get_option('pimgcount')) : ?>
                                    <li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize($product -> title) . '-images', 'title' => $image -> title)); ?></li>
                                <?php else : ?>
                                    <?php break; ?>
                                <?php endif; ?>
                                <?php $imgcount++; ?>
                            <?php endforeach; ?>
                        </ul>
                        <br class="<?php echo $this -> pre; ?>cleaner" />
                        
                        <?php if (count($product -> images) > $this -> get_option('pimgcount')) : ?>
                            <div class="viewallextraimageslink"><?php echo $wpcoHtml -> link(__('View all images &raquo;', $this -> plugin_name), $wpcoHtml -> retainquery($this -> pre . 'method=images', $_SERVER['REQUEST_URI']), false); ?></div>
                        <?php endif; ?>
                    </div>
                <?php elseif ($this -> get_option('gallerytab') == "Y") : ?>
                    <div class="viewllextraimageslink"><a href="" class="view-all-images-link"><?php _e('View all images &raquo;', $this -> plugin_name); ?></a></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
	
    <!-- BEG Product Information Holder -->
    <div class="productinfoholder" style="width:<?php echo $this -> get_option('product_infoholderwidth'); ?>px;">
		<?php if ($this -> get_option('product_descriptionposition') == "above") : ?>
            <?php if (empty($product -> contents) || !is_array($product -> contents)) : ?>
                <div class="productdescriptionview"><?php echo apply_filters($this -> pre . '_product_description', wpautop(do_shortcode(stripslashes($product -> description)))); ?></div>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ($this -> get_option('showcase') == "N" && $product -> showcase == "N") : ?>
            <!-- NOT SHOWCASE -->
            
            <!-- Price -->
            <?php $productprice = $Product -> unit_price($product -> id, 999999, false, false, false, false); ?>
            <div class="pricewrap">
            	<!-- tiered product pricing -->
                <?php if ($product -> price_type == "tiers") : ?>
                    <?php $productprice = $Product -> unit_price($product -> id, 999999, false, false, false, true); ?>
                    <?php echo (!empty($product -> sprice) && $product -> sprice != "0.00") ? '<span class="sprice"><strike>' . $wpcoHtml -> currency_price($product -> sprice, true, true) . '</strike></span>' : ''; ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"><?php echo (!empty($product -> price_type) && $product -> price_type == "tiers" && $product -> price_display != "high") ? __('From', $this -> plugin_name) . ' ' : ''; ?><?php echo $wpcoHtml -> currency_price($productprice, true, true); ?></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                <!-- donate product pricing -->
                <?php elseif ($product -> price_type == "donate") : ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                    <?php if (!empty($product -> donate_caption)) : ?>
                        <p class="donatecaption"><?php echo stripslashes($product -> donate_caption); ?></p>
                    <?php endif; ?>
                <!-- per square pricing -->
                <?php elseif ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                    <span id="productprice<?php echo $product -> id; ?>" class="price"><?php _e('Fill in width and length', $this -> plugin_name); ?></span>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                    <?php if (!empty($product -> square_price_text)) : ?>
                        <p class="squareprice"><small><strong><?php echo stripslashes($product -> square_price_text); ?></strong></small></p>
                    <?php else : ?>
                        <p class="squareprice"><small><strong><?php echo $wpcoHtml -> currency_price($product -> square_price, true, true); ?></strong> <?php _e('per square', $this -> plugin_name); ?> <?php echo $product -> lengthmeasurement; ?></small></p>
                    <?php endif; ?>
                <!-- regular products with fixed pricing -->
                <?php else : ?>
                    <?php echo (!empty($product -> sprice) && $product -> sprice != "0.00") ? '<span class="sprice"><strike>' . $wpcoHtml -> currency_price($product -> sprice, true, true) . '</strike></span>' : ''; ?>
                    <?php if (!empty($product -> price) && $product -> price != "0.00") : ?>
                        <span id="productprice<?php echo $product -> id; ?>" class="price productprice"><?php echo $wpcoHtml -> currency_price($productprice, true, true); ?></span>
                    <?php else : ?>
                        <span id="productprice<?php echo $product -> id; ?>" class="price productprice"><?php echo stripslashes($this -> get_option('product_zerotext')); ?></span>
                    <?php endif; ?>
                    <?php $this -> render('products' . DS . 'tax', array('product' => $product), true, 'default'); ?>
                <?php endif; ?>
            </div>
			
            <!-- Specs -->
            <?php if ($this -> get_option('product_showspecs') == "Y") : ?>
				<?php if (!empty($product -> weight) || !empty($product -> width) || !empty($product -> height) || !empty($product -> length)) : ?>
					<div class="wpco_productspecs">
						<?php if (!empty($product -> weight)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Weight: ', $this -> plugin_name); ?></span><span class="wpco_productweight"><?php echo $product -> weight; ?><?php echo $this -> get_option('weightm'); ?></span>
								</div>
						<?php endif; ?>
						
						<?php if (!empty($product -> lengthmeasurement)) : ?>
							<?php if (!empty($product -> width)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Width: ', $this -> plugin_name); ?></span><span class="wpco_productwidth"><?php echo $product -> width; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
							
							<?php if (!empty($product -> height)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Height: ', $this -> plugin_name); ?></span><span class="wpco_productheight"><?php echo $product -> height; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
							
							<?php if (!empty($product -> length)) : ?>
								<div class="wpco_productspec">
									<span class="wpco_productspecname"><?php _e('Length: ', $this -> plugin_name); ?></span><span class="wpco_productlenght"><?php echo $product -> length; ?><?php echo $product -> lengthmeasurement; ?></span>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
            <?php endif; ?>
        
            <?php if ($product -> price_type == "tiers") : ?>					
                <fieldset class="<?php echo $this -> pre; ?>">
                    <legend><?php _e('Your Price', $this -> plugin_name); ?></legend>
                        <table class="<?php echo $this -> pre; ?>">
                            <tbody>
                                <?php $t = 1; ?>
                                <?php $class = 'erow'; ?>
                                <?php $price = maybe_unserialize($product -> price); ?>
                                <?php foreach ($price as $tier) : ?>
                                <?php
                                
                                	$newprice = $tier['price'];
                                	if ($this -> get_option('tax_includeinproductprice') == "Y") {
                                		$newprice = ($tier['price'] + $wpcoTax -> product_tax($product -> id, $tier['price']));
                                	}
                                
                                	?>
	                                <?php $tierstring = ($t == count($price)) ? $tier['min'] . ' ' . __('or more', $this -> plugin_name) : $tier['min'] . ' ' . __('to', $this -> plugin_name) . ' ' . $tier['max'] ; ?>
	                                <tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
	                                    <td><?php echo $tierstring; ?></td>
	                                    <td>=</td>
	                                    <td><b><?php echo $wpcoHtml -> currency_price($newprice, true, true); ?></b> <?php _e('per unit', $this -> plugin_name); ?></td>
	                                </tr>
	                                <?php $t++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                </fieldset>
            <?php endif; ?>
            
            <?php if (empty($product -> oos) || $product -> oos != true) : ?>	
                <?php echo $wpcoHtml -> addtocart_action($product -> id, false); ?>
                    <?php echo $wpcoForm -> hidden('Item.product_id', array('value' => $product -> id)); ?>
                    
                    <?php global $user_ID; ?>
                    <?php echo $wpcoForm -> hidden('Item.user_id', array('value' => $user_ID)); ?>	
                    
                    <?php if ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                        <!-- Price per square meter -->
                        <?php echo $wpcoForm -> text('Item.width', array('error' => false, 'width' => "45px", 'value' => $_POST['Item']['width'], 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?> <?php _e('X', $this -> plugin_name); ?>
                        <?php echo $wpcoForm -> text('Item.length', array('error' => false, 'width' => "45px", 'value' => $_POST['Item']['length'], 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?>
                        <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                    <?php endif; ?>				
            
                    <?php if ($this -> get_option('fieldsintab') == "N" || ($this -> get_option('fieldsintab') == "Y" && empty($product -> contents))) : ?>		
                        <?php if (!empty($product -> styles) && !empty($product -> options)) : ?>
                            <?php foreach ($product -> styles as $style_id) : ?>
                                <?php echo $this -> render_style($style_id, $product -> options[$style_id], true, $product -> id); ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
    
                        <?php if (!empty($product -> cfields)) : ?>
                            <?php foreach ($product -> cfields as $field_id) : ?>
                                <?php if (!empty($field_id)) : ?>
                                    <?php $this -> render_field($field_id, true, false, $product -> id); ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
        
                    <?php if ($this -> get_option('howmany') == "Y" && $product -> price_type != "donate" && $product -> price_type != "square") : ?>
                        <div class="<?php echo $this -> pre; ?>howmany">						
                            <b><?php _e('How many', $this -> plugin_name); ?> <?php echo $product -> measurement; ?><?php _e('?', $this -> plugin_name); ?></b>
                            <?php $cvaluet = (empty($product -> min_order)) ? '1' : $product -> min_order; ?>
                            <?php $cvalue = (empty($_POST['Item']['count'])) ? $cvaluet : $_POST['Item']['count']; ?>
                            <?php echo $wpcoForm -> text('Item.count', array('error' => false, 'value' => $cvalue, 'width' => '45px', 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', 'Calculating...');")); ?>
                            
                            <?php if (!empty($product -> inventory) && $product -> inventory > 0 && $this -> get_option('product_showstock') == "Y") : ?>
                                <span class="stockcount"><?php echo $product -> inventory; ?> <?php _e('units in stock.', $this -> plugin_name); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($product -> price_type == "donate") : ?>
                        <?php echo $wpcoHtml -> currency_html('<input type="text" name="Item[donate_price]" value="' . esc_attr(empty($_POST['Item']['donate_price']) ? $wpcoHtml -> field_value('Item.donate_price') : $_POST['Item']['donate_price']) . '" id="Item.donate_price" class="donateprice" onkeyup="wpco_updateproductprice(\'' . $product -> id . '\', \'' . __('Calculating...', $this -> plugin_name) . '\');" />'); ?>
                    	<?php /*<?php echo $wpcoHtml -> field_error('Item.donate_price'); ?>*/ ?>
                    
                        <!-- Donation Product -->
                        <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                    <?php else : ?>
                        <?php /*hidden field for quantity as 1*/ ?>
                        <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                    <?php endif; ?>
                    
                    <span class="wpcobuttonwrap">
                        <?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) : ?>
                            <!-- BEG Buy Now -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
                                    <span class="productsubmit productsubmittext affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><a class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" title="<?php echo $product -> title; ?>"><?php echo $product -> buttontext; ?></a></span>
                                <?php else : ?>
                                    <span class="productsubmit productsubmitbutton affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><a href="" title="<?php _e('Buy this product now', $this -> plugin_name); ?>" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit();" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
                                <?php endif; ?>
                            <?php else : ?>
                                <span class="productsubmit productsubmitbutton buynowproductsubmit" id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                            <?php endif; ?>
                        <?php elseif (!empty($product -> affiliate) && $product -> affiliate == "Y" && !empty($product -> affiliateurl)) : ?>
                            <!-- BEG Affiliate Product -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <span class="productsubmit productsubmittext affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><a href="<?php echo $product -> affiliateurl; ?>" <?php echo (!empty($product -> affiliatewindow) && $product -> affiliatewindow == "blank") ? 'target="_blank"' : 'target="_self"'; ?> title="<?php echo $product -> buttontext; ?>" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
                            <?php else : ?>
                                <span class="productsubmit productsubmitbutton affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                            <?php endif; ?>
                        <?php elseif (false && !empty($product -> price_type) && $product -> price_type == "donate") : ?>
                            <!-- BEG Donation Product -->
                            
                            <!-- END DOnation Product -->
                        <?php else : ?>
                            <!-- BEG Normal Product3 -->
                            <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                <?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
                                    <span id="submit<?php echo $product -> id; ?>"><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" title="<?php echo $product -> title; ?>"><?php echo $product -> buttontext; ?></a></span>
                                <?php else : ?>
                                    <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                                        <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>" onclick="wpco_addtocart(jQuery('#addtocart<?php echo $product -> id; ?>'), '<?php echo $product -> id; ?>', '<?php echo $this -> widget_active('cart'); ?>'); return false;" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
                                    <?php else : ?>
                                        <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit(); return false;" class="<?php echo $this -> pre; ?>buylink" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <?php if ($this -> get_option('cart_addajax') == "Y") : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><input type="submit" name="submit" value="<?php echo $product -> buttontext; ?>" /></span>
                                <?php else : ?>
                                    <span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <span class="<?php echo $this -> pre; ?>loading" id="loading<?php echo $product -> id; ?>" style="display:none; z-index:99;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /> <?php _e('Adding Item...', $this -> plugin_name); ?><br class="<?php echo $this -> pre; ?>cleaner" /></span>
                            <span class="<?php echo $this -> pre; ?>added" style="display:none;" id="added<?php echo $product -> id; ?>"><img src="<?php echo $this -> url(); ?>/images/accept.png" /> <?php _e('Product has been added', $this -> plugin_name); ?><br class="<?php echo $this -> pre; ?>cleaner" /></span>
                        <?php endif; ?>
                        
                        <!-- loading indicator -->
                        <span class="wpcoloadingwrap" id="wpcoloadingwrap<?php echo $product -> id; ?>" style="display:none;">
	                    	<img src="<?php echo $this -> url(); ?>/views/simpleblue/img/loading.gif" alt="loading" />
	                    </span>
                        
                        <!-- favorites -->
                        <?php $this -> render('favorites' . DS . 'link', array('product' => $product), true, 'default'); ?>
                        
                        <br class="wpcocleaner" />
                    </span>
                    
                    <?php if ($product -> inhonorof == "Y") : ?>
                        <?php if (!empty($product -> inhonorof) && $product -> inhonorof == "Y") : ?>
                            <?php if ($product -> inhonorofreq == "N") : ?>
                                <div class="<?php echo $this -> pre; ?>inhonorofcheckbox">
                                    <label><input onclick="if (this.checked == true) { jQuery('#<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>').show(); } else { jQuery('#<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>').hide(); }" type="checkbox" name="inhonorofreq" value="1" id="inhonorofreq<?php echo $product -> id; ?>" /> <?php _e('Specify beneficiary details?', $this -> plugin_name); ?></label>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    
                        <div style="display:<?php echo (!empty($product -> inhonorofreq) && $product -> inhonorofreq == "Y") ? 'block' : 'none'; ?>;" class="<?php echo $this -> pre; ?>inhonorof" id="<?php echo $this -> pre; ?>inhonorof<?php echo $product -> id; ?>">
                            <fieldset>
                                <legend><?php _e('In Honor Of...', $this -> plugin_name); ?></legend>
                                
                                <table>
                                    <tbody>
                                        <tr>
                                            <td><?php _e('Your Name:', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_name'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Beneficiary Name', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_benname'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php _e('Beneficiary Email', $this -> plugin_name); ?></td>
                                            <td><?php echo $wpcoForm -> text('Item.iof_benemail'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this -> get_option('fieldsintab') == "Y" && (!empty($product -> styles) || !empty($product -> cfields)) && !empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
                        <?php if ($this -> get_option('optionslinktb') == "B") : ?>
                            <p class="<?php echo $this -> pre; ?>optionslink"><?php echo $wpcoHtml -> link(__('Choose product options/variations &raquo;', $this -> plugin_name), "", array('class' => "product-options-link")); ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php else : ?>
                    <p class="<?php echo $this -> pre; ?>oos"><?php echo $wpcocaptions['product']['oos']; ?></p>
                <?php endif; ?>
                    
                <p class="<?php echo $this -> pre; ?>error" id="message<?php echo $product -> id; ?>" style="display:none;"></p>
            </div>
			
			<?php if (!empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
				<?php $tabscount = 1; ?>
                <?php $tabscount2 = 1; ?>
				<div style="clear:both; display:block; height:1px; width:100%;"></div>
			
				<div id="tabs<?php echo $product -> id; ?>">
                	<!-- BEG Tabs Menu -->
                	<ul>
                    	<li><a href="#tabs<?php echo $product -> id; ?>-1"><?php _e('Description', $this -> plugin_name); ?></a></li>
                        <?php $tabscount2++; ?>
                        <?php foreach ($product -> contents as $content) : ?>
                        	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php echo $content -> title; ?></a></li>
                        	<?php $tabscount2++; ?>
                        <?php endforeach; ?>
                        <?php if (empty($product -> oos) || $product -> oos == false) : ?>
							<?php if (!$this -> get_option('fieldsintab') || $this -> get_option('fieldsintab') == "Y") : ?>
                                <?php if (!empty($product -> styles) || !empty($product -> cfields)) : ?>
                                	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Options', $this -> plugin_name); ?></a></li>
                                    <?php $productoptionstab = $tabscount2; ?>
                                    <?php $tabscount2++; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
							<?php if (!empty($product -> images)) : ?>
                            	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Gallery', $this -> plugin_name); ?></a></li>
                                <?php $gallerytab = $tabscount2; ?>
                                <?php $tabscount2++; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
                        	<li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Related Products', $this -> plugin_name); ?></a></li>
                            <?php $tabscount2++; ?>
                        <?php endif; ?>
                    </ul>
                    <!-- END Tabs Menu -->
                
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3><?php _e('Description', $this -> plugin_name); ?></h3>
						<div>
							<?php echo apply_filters($this -> pre . '_product_description', wpautop(do_shortcode(stripslashes($product -> description)))); ?>
							
							<?php if ($this -> get_option('unitextbox') == "Y") : ?>
								<?php $message = $this -> get_option('unitextboxmessage'); ?>
								<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
									<div class="<?php echo $this -> pre; ?>unitextbox">
										<?php echo $message; ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
					<?php $tabscount++; ?>
					<?php foreach ($product -> contents as $content) : ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3><?php echo $content -> title; ?></h3>
							<div>
								<?php echo wpautop(do_shortcode(stripslashes($content -> content))); ?>
								
								<?php if ($this -> get_option('unitextbox') == "Y") : ?>
								<?php $message = $this -> get_option('unitextboxmessage'); ?>
								<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
									<div class="<?php echo $this -> pre; ?>unitextbox">
										<?php echo $message; ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							</div>
						</div>
						<?php $tabscount++; ?>
					<?php endforeach; ?>
                    <!-- BEG Custom Fields & Variations in Tab -->
					<?php if (empty($product -> oos) || $product -> oos == false) : ?>
						<?php if (!$this -> get_option('fieldsintab') || $this -> get_option('fieldsintab') == "Y") : ?>
							<?php if (!empty($product -> styles) || !empty($product -> cfields)) : ?>
								<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
									<h3><?php _e('Options', $this -> plugin_name); ?></h3>
									<div>
										<?php if (!empty($product -> styles) && !empty($product -> options)) : ?>
											<?php foreach ($product -> styles as $style_id) : ?>
												<?php $wpcoDb -> model = $Style -> model; ?>
												<?php if ($style = $wpcoDb -> find(array('id' => $style_id))) : ?>
													<?php echo $this -> render_style($style_id, $product -> options[$style_id], true, $product -> id); ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										
										<?php if (!empty($product -> cfields)) : ?>
											<?php foreach ($product -> cfields as $field_id) : ?>
												<?php if (!empty($field_id)) : ?>
													<?php $wpcoDb -> model = $wpcoField -> model; ?>
													<?php if ($field = $wpcoDb -> find(array('id' => $field_id))) : ?>
														<?php $_POST[$field -> slug] = $_POST['Item'][$field -> slug]; ?>
														<?php $this -> render_field($field_id, true, false, $product -> id); ?>
													<?php endif; ?>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
										
										<!-- <?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) : ?>
											<p><?php echo $wpcoForm -> submit($product -> buttontext); ?></p>
										<?php else : ?>
											<p><?php echo $wpcoForm -> submit($product -> buttontext); ?></p>
										<?php endif; ?> -->
										<?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) : ?>
											<?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
												<?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
													<span id="submit<?php echo $product -> id; ?>"><a class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" title="<?php echo $product -> title; ?>"><?php echo $product -> buttontext; ?></a></span>
												<?php else : ?>
													<span id="submit<?php echo $product -> id; ?>"><a href="" title="<?php _e('Buy this product now', $this -> plugin_name); ?>" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit();" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
												<?php endif; ?>
											<?php else : ?>
												<span id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
											<?php endif; ?>
										<?php else : ?>
											<?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
												<?php if (!empty($product -> affiliate) && $product -> affiliate == "Y") : ?>
													<span id="submit<?php echo $product -> id; ?>"><a href="<?php echo $wpcoHtml -> retainquery($this -> pre . 'method=affiliate&amp;id=' . $product -> id); ?>" class="<?php echo $this -> pre; ?>buylink" target="_<?php echo $product -> affiliatewindow; ?>" title="<?php echo $product -> title; ?>"><?php echo $product -> buttontext; ?></a></span>
												<?php else : ?>
													<?php if ($this -> get_option('cart_addajax') == "Y") : ?>
														<span id="submit<?php echo $product -> id; ?>"><a href="" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>" onclick="wpco_addtocart(jQuery('#addtocart<?php echo $product -> id; ?>'), '<?php echo $product -> id; ?>', '<?php echo $this -> widget_active('cart'); ?>'); return false;" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
													<?php else : ?>
														<span class="productsubmit" id="submit<?php echo $product -> id; ?>"><a href="" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit(); return false;" class="<?php echo $this -> pre; ?>buylink" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
													<?php endif; ?>
												<?php endif; ?>
											<?php else : ?>
												<?php if ($this -> get_option('cart_addajax') == "Y") : ?>
													<span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><input type="submit" name="submit" value="<?php echo $product -> buttontext; ?>" /></span>
												<?php else : ?>
													<span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
												<?php endif; ?>
											<?php endif; ?>
											<span class="<?php echo $this -> pre; ?>loading" id="loading<?php echo $product -> id; ?>" style="display:none; z-index:99;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /> <?php _e('Adding Item...', $this -> plugin_name); ?></span>
											<span class="<?php echo $this -> pre; ?>added" style="display:none;" id="added<?php echo $product -> id; ?>"><img src="<?php echo $this -> url(); ?>/images/accept.png" /> <?php _e('Product has been added', $this -> plugin_name); ?></span>
										<?php endif; ?>
										<?php if ($this -> get_option('unitextbox') == "Y") : ?>
											<?php $message = $this -> get_option('unitextboxmessage'); ?>
											<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
												<div class="<?php echo $this -> pre; ?>unitextbox">
													<?php echo $message; ?>
												</div>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
								<?php $tabscount++; ?>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
					<!-- END Custom Fields & Variations in Tab -->
                    <!-- BEG Gallery/extra Images in Tab -->
					<?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
						<?php if (!empty($product -> images)) : ?>
							<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
								<h3><?php _e('Gallery', $this -> plugin_name); ?></h3>
								<div>
									<div class="<?php echo $this -> pre; ?>imglist <?php echo $this -> pre; ?>imglistfull">
										<ul>
											<?php foreach ($product -> images as $image) : ?>
												<li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize($product -> title) . '-images', 'title' => $image -> title)); ?></li>
											<?php endforeach; ?>
										</ul>
										<br class="<?php echo $this -> pre; ?>cleaner" />
									</div>
									
									<?php if ($this -> get_option('unitextbox') == "Y") : ?>
										<?php $message = $this -> get_option('unitextboxmessage'); ?>
										<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
											<div class="<?php echo $this -> pre; ?>unitextbox">
												<?php echo $message; ?>
											</div>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
                            <?php $tabscount++; ?>
						<?php endif; ?>
					<?php endif; ?>
					<!-- END Gallery/extra Images in Tab -->
                    <!-- BEG Related Products in Tab -->
					<?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
						<?php $rproducts = array(); ?>
						<?php foreach ($product -> related as $rproduct) : ?>
							<?php $wpcoDb -> model = $Product -> model; ?>
							<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
						<?php endforeach; ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
							<div>
								<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => true, 'noaddtob' => true), true, 'default'); ?>
							</div>
						</div>
                        <?php $tabscount++; ?>
					<?php endif; ?>
                    <!-- END Related Products in Tab -->
				</div>
				<!-- END Tabber -->
			<?php endif; ?>
		<?php if (empty($product -> oos) || $product -> oos == false) : ?>
				<?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) : ?>
					<input type="hidden" name="buynow" value="Y" />
				<?php endif; ?>
                
                <input type="hidden" name="fromproductpage" value="Y" />
                
                <?php if (!empty($_POST['fromproductpage'])) : ?>
					<script type="text/javascript">
					eval("request<?php echo $product -> id; ?> = false;");
                    jQuery(document).ready(function(e) {
                        wpco_updateproductprice_new('<?php echo $product -> id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
                    });
                    </script>
                <?php endif; ?>
			</form>
		<?php endif; ?>
		
		<?php if ($this -> get_option('fieldsintab') == "Y" && (!empty($product -> styles) || !empty($product -> cfields)) && !empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
			<?php if ($this -> get_option('optionslinktb') == "T") : ?>
				<fieldset class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>optionslinkfieldset">
					<legend><?php _e('Product Options', $this -> plugin_name); ?></legend>
					<span class="<?php echo $this -> pre; ?>optionslink"><?php echo $wpcoHtml -> link(__('Choose product options/variations &raquo;', $this -> plugin_name), "", array('class' => "product-options-link")); ?></span>
				</fieldset>
			<?php endif; ?>
		<?php endif; ?>
	<?php else : ?>		
		<!-- SHOWCASE -->
        <?php $showcasemsg = $this -> get_option('showcasemsg'); ?>
        <p><?php echo (empty($product -> showcasemsg)) ? $showcasemsg : $product -> showcasemsg; ?></p>
        
		<?php if (!empty($product -> contents) && (is_array($product -> contents) || is_object($product -> contents))) : ?>
			<?php $tabscount = 1; ?>
            <?php $tabscount2 = 1; ?>
			<div style="clear:both; display:block; height:1px; width:100%;"></div>
		
			<div id="tabs<?php echo $product -> id; ?>">
            	<!-- BEG Tabs Menu -->
                <ul>
                    <li><a href="#tabs<?php echo $product -> id; ?>-1"><?php _e('Description', $this -> plugin_name); ?></a></li>
                    <?php $tabscount2++; ?>
                    <?php foreach ($product -> contents as $content) : ?>
                        <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php echo $content -> title; ?></a></li>
                        <?php $tabscount2++; ?>
                    <?php endforeach; ?>
                    <?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
                        <?php if (!empty($product -> images)) : ?>
                            <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Gallery', $this -> plugin_name); ?></a></li>
                            <?php $tabscount2++; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
                        <li><a href="#tabs<?php echo $product -> id; ?>-<?php echo $tabscount2; ?>"><?php _e('Related Products', $this -> plugin_name); ?></a></li>
                        <?php $tabscount2++; ?>
                    <?php endif; ?>
                </ul>
                <!-- END Tabs Menu -->
            
				<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
					<h3><?php _e('Description', $this -> plugin_name); ?></h3>
					<div>
						<?php echo apply_filters($this -> pre . '_product_description', wpautop(do_shortcode(stripslashes($product -> description)))); ?>
						
						<?php if ($this -> get_option('unitextbox') == "Y") : ?>
							<?php $message = $this -> get_option('unitextboxmessage'); ?>
							<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
								<div class="<?php echo $this -> pre; ?>unitextbox">
									<?php echo $message; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
				<?php $tabscount++; ?>
				<?php foreach ($product -> contents as $content) : ?>
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3><?php echo $content -> title; ?></h3>
						<div>
							<?php echo wpautop(do_shortcode(stripslashes($content -> content))); ?>
							
							<?php if ($this -> get_option('unitextbox') == "Y") : ?>
							<?php $message = $this -> get_option('unitextboxmessage'); ?>
							<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
								<div class="<?php echo $this -> pre; ?>unitextbox">
									<?php echo $message; ?>
								</div>
							<?php endif; ?>
						<?php endif; ?>
						</div>
					</div>
					<?php $tabscount++; ?>
				<?php endforeach; ?>
				
				<!-- GALLERY IN TAB --> 
				<?php if (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") : ?>
					<?php if (!empty($product -> images)) : ?>
						<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
							<h3><?php _e('Gallery', $this -> plugin_name); ?></h3>
							<div>
								<div class="<?php echo $this -> pre; ?>imglist <?php echo $this -> pre; ?>imglistfull">
									<ul>
										<?php foreach ($product -> images as $image) : ?>
											<li><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('ithumbw'), $this -> get_option('ithumbh'), 100), $wpcoHtml -> image_url($image -> filename), array('class' => 'colorbox', 'rel' => $wpcoHtml -> sanitize($product -> title) . '-images', 'title' => $image -> title)); ?></li>
										<?php endforeach; ?>
									</ul>
									<br class="<?php echo $this -> pre; ?>cleaner" />
								</div>
								
								<?php if ($this -> get_option('unitextbox') == "Y") : ?>
									<?php $message = $this -> get_option('unitextboxmessage'); ?>
									<?php if (!empty($message) && $this -> get_option('unitextboxintabs') == "Y") : ?>
										<div class="<?php echo $this -> pre; ?>unitextbox">
											<?php echo $message; ?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
                        <?php $tabscount++; ?>
					<?php endif; ?>
				<?php endif; ?>
				
				<!-- RELATED PRODUCTS -->
				<?php if (!empty($product -> related) && $this -> get_option('relatedintab') == "Y") : ?>
					<?php $rproducts = array(); ?>
					<?php foreach ($product -> related as $rproduct) : ?>
						<?php $wpcoDb -> model = $Product -> model; ?>
						<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
					<?php endforeach; ?>
					<div id="tabs<?php echo $product -> id; ?>-<?php echo $tabscount; ?>">
						<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
						<div>
							<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => true, 'noaddtob' => true), true, 'default'); ?>
						</div>
					</div>
                    <?php $tabscount++; ?>
				<?php endif; ?>
			</div>
			<!-- END TABBER -->
		<?php endif; ?>	
        
        </div>
	<?php endif; ?>

	<?php if (!empty($product -> categories) && $this -> get_option('product_showcategories') == "Y") : ?>	
		<fieldset class="<?php echo $this -> pre; ?>">
			<?php if (count($product -> categories) == 1) : ?>
				<legend><?php echo $wpcocaptions['product']['category']; ?></legend>
			<?php else : ?>
				<legend><?php echo $wpcocaptions['product']['categories']; ?></legend>
			<?php endif; ?>
			
			<?php $c = 1; ?>
			<?php foreach ($product -> categories as $category_id) : ?>
				<?php $wpcoDb -> model = $Category -> model; ?>
				<?php if ($category = $wpcoDb -> find(array('id' => $category_id))) : ?>
					<a href="<?php echo get_permalink($category -> post_id); ?>" title="<?php echo $category -> title; ?>"><?php echo $category -> title; ?></a>
					<?php echo ($c < count($product -> categories)) ? ', ' : ''; ?>
				<?php endif; ?>
				<?php $c++; ?>
			<?php endforeach; ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if ($this -> get_option('unitextbox') == "Y" && $this -> get_option('unitextfieldset') == "Y") : ?>
		<?php $message = $this -> get_option('unitextboxmessage'); ?>
		<?php if (!empty($message)) : ?>
			<fieldset class="<?php echo $this -> pre; ?>">
				<legend><?php _e('Attention', $this -> plugin_name); ?></legend>
				<div class="<?php echo $this -> pre; ?>unitextbox">
					<?php echo $message; ?>
				</div>
			</fieldset>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if (!empty($product -> supplier_id) && $this -> get_option('hidesuppliers') == "N") : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php echo $wpcocaptions['product']['supplier']; ?></legend>
			<?php if ($this -> get_option('supplierpages') == "Y" && !empty($product -> supplier -> post_id)) : ?>
				<?php if ($product -> supplier -> image == "Y" && !empty($product -> supplier -> imagename)) : ?>
					<?php /*<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> supplier -> imagename, array('folder' => "suppliers"), $product -> supplier -> imagename), get_permalink($product -> supplier -> post_id), array('title' => $product -> supplier -> name)); ?>*/ ?>
                    <?php if ($this -> get_option('supimg') == "full") : ?>
                    	<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> supplier -> imagename, array('folder' => "suppliers"), $product -> supplier -> imagename), get_permalink($product -> supplier -> post_id), array('title' => $product -> supplier -> name)); ?>
                    <?php else : ?>
                    	<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> supplier -> image_url, $this -> get_option('supthumbw'), $this -> get_option('supthumbh'), 100), get_permalink($product -> supplier -> post_id), array('title' => $product -> supplier -> name)); ?>
                    <?php endif; ?>
				<?php else : ?>
					<?php echo $wpcoHtml -> link($product -> supplier -> name, get_permalink($product -> supplier -> post_id), array('title' => $product -> supplier -> name)); ?>
				<?php endif; ?>
			<?php else : ?>
				<?php echo $product -> supplier -> name; ?>
			<?php endif; ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if (!empty($product -> kws) && is_array($product -> kws) && $this -> get_option('product_showkeywords') == "Y") : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php echo $wpcocaptions['product']['keywords']; ?></legend>
			<div class="<?php echo $this -> pre; ?>keywords">
				<?php $k = 1; ?>
				<?php foreach ($product -> kws as $kw) : ?>
					<?php echo $wpcoHtml -> link($kw, $wpcoHtml -> retainquery($this -> pre . 'searchterm=' . urlencode($kw), get_permalink($this -> get_option('allproductsppid'))), array('title' => $kw)); ?>
					<?php echo ($k < count($product -> kws)) ? ', ' : ''; ?>
					<?php $k++; ?>
				<?php endforeach; ?>
			</div>
		</fieldset>
	<?php endif; ?>	
	
	<?php if (!empty($product -> min_order)) : ?>
		<fieldset class="<?php echo $this -> pre; ?>">
			<legend><?php _e('Minimum Order', $this -> plugin_name); ?></legend>
			<?php echo $product -> min_order; ?> <?php _e('units', $this -> plugin_name); ?>
		</fieldset>
	<?php endif; ?>
	
	<?php if ($this -> get_option('unitextbox') == "Y") : ?>
		<?php $message = $this -> get_option('unitextboxmessage'); ?>
		<?php if (!empty($message)) : ?>
			<div class="<?php echo $this -> pre; ?>unitextbox">
				<?php echo $message; ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>
    
    <?php if ($this -> get_option('product_descriptionposition') == "below") : ?>
		<?php if (empty($product -> contents) || !is_array($product -> contents)) : ?>
        	<br class="<?php echo $this -> pre; ?>cleaner" />
            <?php echo apply_filters($this -> pre . '_product_description', wpautop(do_shortcode(stripslashes($product -> description)))); ?>
        <?php endif; ?>
    <?php endif; ?>
	
	<?php if (!empty($product -> related) && ($this -> get_option('relatedintab') == "N" || empty($product -> contents))) : ?>
		<br class="<?php echo $this -> pre; ?>cleaner" />
	
		<?php $rproducts = array(); ?>
		<?php foreach ($product -> related as $rproduct) : ?>
			<?php $wpcoDb -> model = $Product -> model; ?>
			<?php $rproducts[] = $wpcoDb -> find(array('id' => $rproduct -> related_id)); ?>
		<?php endforeach; ?>
		<h3 id="related"><?php _e('Related Products', $this -> plugin_name); ?></h3>
		<?php $this -> render('products' . DS . 'loop', array('products' => $rproducts, 'related' => true, 'tabber' => false), true, 'default'); ?>
	<?php endif; ?>
    
    <?php if ($this -> get_option('product_sharingbuttons') == "Y") : ?>
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
		<a class="addthis_button_pinterest_pinit" pi:pinit:url="<?php echo get_permalink($product -> post_id); ?>" pi:pinit:media="<?php echo site_url('/') . $product -> image_url; ?>" pi:pinit:layout="horizontal"></a> 
        <a class="addthis_counter addthis_pill_style"></a>
        </div>
        <script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e5ef8193f008bd1"></script>
        <!-- AddThis Button END -->
    <?php endif; ?>
</div>

<?php if (!is_feed()) : ?>
	<script type="text/javascript">
	<?php if ($tabscount > 1) : ?>
		jQuery(document).ready(function() {
			$tabs = jQuery('#tabs<?php echo $product -> id; ?>').tabs();
			
			jQuery('.product-options-link').click(function() {
				wpco_scroll(jQuery('#tabs<?php echo $product -> id; ?>'));
				$tabs.tabs('select', '<?php echo $productoptionstab; ?>');
				return false;
			});
			
			jQuery('.view-all-images-link').click(function() {
				wpco_scroll(jQuery('#tabs<?php echo $product -> id; ?>'));
				$tabs.tabs('select', '<?php echo $gallerytab; ?>');
				return false;	
			});
		});
	<?php endif; ?>
	</script>
<?php endif; ?>

<?php if (!empty($product -> styles)) : ?>
	<script type="text/javascript">
	eval("request<?php echo $product -> id; ?> = false;");
	jQuery(document).ready(function() {
		wpco_updateproductprice_new('<?php echo $product -> id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
	});
	</script>
<?php endif; ?>