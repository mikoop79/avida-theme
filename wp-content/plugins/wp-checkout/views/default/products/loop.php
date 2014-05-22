<?php if (!empty($searchterm)) : ?>
	<p><?php _e('Search results for', $this -> plugin_name); ?> "<strong><?php echo stripslashes($searchterm); ?></strong>"</p>
<?php endif; ?>

<?php if (!empty($products)) : ?>
	<?php 
	
	global $displaygrid;	
	if (!empty($related) && $related == true) { $displaygrid = ($this -> get_option('related_display') == "list") ? false : true; }
	
	$productswrapperclass = 'products' . (($displaygrid) ? 'grid' : 'list');
	$productswrapperid = $productswrapperclass . rand(1, 999);
	
	$productsstring = false;
	foreach ($products as $product) {
		$productsstring .= '&products[]=' . $product -> id;	
	}
	
	?>
    
	<div class="<?php echo $productswrapperclass; ?>" id="<?php echo $productswrapperid; ?>">
    	<div class="productsoptions">
			<?php if (($this -> get_option('loopsorting') == "Y" || $this -> get_option('loop_changeviewmode') == "Y") && empty($related)) : ?>
                <form class="productssort">
                	<?php if ($this -> get_option('loopsorting') == "Y") : ?>
                        <label for="productsortselect"><?php _e('Sort By', $this -> plugin_name); ?>: </label>
                        <select name="productsortselect" onchange="window.location=this.value;">
                            <option value=""><?php _e('Choose Sorting', $this -> plugin_name); ?></option>
                            <optgroup label="<?php _e('By Price', $this->plugin_name); ?>" name="sortlistselect">
                                <option <?php echo ($_GET['sortby'] == "price" && $_GET['sort'] == "ASC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=price&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Low to High', $this->plugin_name); ?></option>
                                <option <?php echo ($_GET['sortby'] == "price" && $_GET['sort'] == "DESC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=price&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('High to Low', $this->plugin_name); ?></option>
                            </optgroup>
                            <optgroup label="<?php _e('By Title', $this->plugin_name); ?>">
                                <option <?php echo ($_GET['sortby'] == "title" && $_GET['sort'] == "ASC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=title&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('A to Z', $this->plugin_name); ?></option>
                                <option <?php echo ($_GET['sortby'] == "title" && $_GET['sort'] == "DESC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=title&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Z to A', $this->plugin_name); ?></option>
                            </optgroup>
                            <optgroup label="<?php _e('By Date', $this->plugin_name); ?>">
                                <option <?php echo ($_GET['sortby'] == "modified" && $_GET['sort'] == "DESC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=modified&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('New to Old', $this->plugin_name); ?></option>
                                <option <?php echo ($_GET['sortby'] == "modified" && $_GET['sort'] == "ASC") ? 'selected="selected"' : ''; ?> value="<?php echo $wpcoHtml -> retainquery('sortby=modified&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Old to New', $this->plugin_name); ?></option>
                            </optgroup>
                        </select>
                    <?php endif; ?>
                    
                    <?php if ($this -> get_option('loop_changeviewmode') == "Y") : ?>
                    	<!-- change view between list/grid -->
                        <a class="changeviewmode changetogrid" href="<?php echo $wpcoHtml -> retainquery('changeview=grid', $_SERVER['REQUEST_URI']); ?>">Grid View</a>
                        <a class="changeviewmode changetolist" href="<?php echo $wpcoHtml -> retainquery('changeview=list', $_SERVER['REQUEST_URI']); ?>">List View</a>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
            <?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
        </div>
		<ul class="products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>ul">
			<?php $liclass = ''; ?>
			<?php foreach ($products as $product) : ?>
				<li class="products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>item products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>item-<?php echo $liclass = (empty($liclass) || $liclass == "r") ? 'l' : 'r'; ?>">
					<?php if ($truncate = $this -> get_option('loop_truncatetitle')) : ?>
						<?php if (!empty($truncate)) : ?>
							<?php $product -> title = $wpcoHtml -> truncate(apply_filters($this -> pre . '_product_title', $product -> title), $truncate, '...'); ?>
						<?php endif; ?>
					<?php endif; ?>

					<?php if (!$this -> get_option('loop_titleposition') || $this -> get_option('loop_titleposition') == "above") : ?>				
						<?php if (!empty($tabber) && $tabber == true) : ?>
							<h4 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h4>
						<?php else : ?>
							<h3 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h3>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php $imgw = ($this -> get_option('loop_imgw')) ? "width:" . $this -> get_option('loop_imgw') . "px; " : ''; ?>
					<?php $imgh = ($this -> get_option('loop_imgh')) ? "height:" . $this -> get_option('loop_imgh') . "px; " : ''; ?>
				
					<div class="productimage">
                    	<?php $thumblink = ($this -> get_option('loop_thumblink') == "product") ? get_permalink($product -> post_id) : $wpcoHtml -> image_url($product -> image -> name); ?>
                    
						<?php if ($this -> get_option('cropthumb') == "Y") : ?>
                            <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('loop_imgw'), $this -> get_option('loop_imgh'), $this -> get_option('loopthumbq'), "productimagethumb"), $thumblink, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => (($this -> get_option('loop_thumblink') == "product") ? "productimagelink" : "productimagelink colorbox"))); ?>
						<?php else : ?>
							<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> image -> name, array('class' => "productimagethumb"), $product -> image -> name), $thumblink, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => (($this -> get_option('loop_thumblink') == "product") ? "productimagelink" : "productimagelink colorbox"))); ?>
						<?php endif; ?>
					</div>
					
					<?php if ($this -> get_option('loop_titleposition') == "below") : ?>				
						<?php if (!empty($tabber) && $tabber == true) : ?>
							<h4 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h4>
						<?php else : ?>
							<h3 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h3>
						<?php endif; ?>
					<?php endif; ?>

					<!-- Not Showcase -->
					<?php if ($this -> get_option('showcase') == "N" && $product -> showcase == "N") : ?>
                    	<div class="productdetails productdetails<?php echo $product -> id; ?>">
                        	<!-- Price -->				
                            <div class="productpricewrap">
                            	<?php if (empty($product -> price_type) || ($product -> price_type != "donate" && $product -> price_type != "square")) : ?>
									<?php echo (!empty($product -> price_type) && $product -> price_type == "tiers" && $product -> price_display != "high") ? __('From', $this -> plugin_name) . ' ' : ''; ?>
                                    <?php echo (!empty($product -> sprice) && is_numeric($product -> sprice) && $product -> sprice != "0.00") ? '<span class="sprice"><strike>' . $wpcoHtml -> currency_price($product -> sprice, true, true) . '</strike></span>' : ''; ?>
                                    <?php if (!empty($product -> price) && $product -> price != "0.00") : ?>
                                        <span id="productprice<?php echo $product -> id; ?>" class="productprice"><?php echo $wpcoHtml -> currency_price($Product -> unit_price($product -> id, 999999, null, false, false, true), true, true); ?></span>
                                    <?php else : ?>
                                        <span id="productprice<?php echo $product -> id; ?>" class="productprice"><?php echo stripslashes($this -> get_option('loop_zerotext')); ?></span>
                                    <?php endif; ?>
                                <?php elseif ($product -> price_type == "donate") : ?>
                                	<?php if (!empty($product -> donate_caption)) : ?>
                                		<span id="productprice<?php echo $product -> id; ?>" class="productprice"><?php echo $product -> donate_caption; ?></span>
                                    <?php endif; ?>
                                <?php elseif ($product -> price_type == "square") : ?>
                                	<?php if (!empty($product -> square_price_text)) : ?>
                                    	<span id="productprice<?php echo $product -> id; ?>" class="productprice"><?php echo stripslashes($product -> square_price_text); ?></span>
                                    <?php else : ?>
                                    	<span id="productprice<?php echo $product -> id; ?>" class="productprice"><?php echo $wpcoHtml -> currency_price($product -> square_price, true, true); ?> <?php _e('per sq', $this -> plugin_name); ?> <?php echo $product -> lengthmeasurement; ?></span>
                                    <?php endif; ?>
                                <?php else : ?>
                                	<!-- do nothing, it goes inside the form -->
                                <?php endif; ?>
                            </div>
    
                            <?php if ($this -> get_option('loop_addbutton') == "Y" && (empty($noaddtob) || $noaddtob == false)) : ?>					
                                <?php if (empty($product -> oos) || $product -> oos == false) : ?>
                                    <?php echo $wpcoHtml -> addtocart_action($product -> id, (!empty($product -> styles) || !empty($product -> cfields)) ? true : false, false); ?>
                                    
                                        <?php echo $wpcoForm -> hidden('Item.product_id', array('value' => $product -> id)); ?>
                                        <?php global $user_ID; ?>
                                        <?php echo $wpcoForm -> hidden('Item.user_id', array('value' => $user_ID)); ?>
        
                                        <?php if ($this -> get_option('loop_howmany') == "Y" && $product -> price_type != "donate" && $product -> price_type != "square") : ?>								
                                            <div class="productcount wpcohowmany">
                                                <b><?php _e('How manys?', $this -> plugin_name); ?></b>
                                                <?php echo $wpcoForm -> text('Item.count', array('value' => (empty($product -> min_order)) ? '1' : $product -> min_order, 'width' => '25px')); ?>
                                            </div>
                                        <!-- Donation Product -->
                                        <?php elseif ($product -> price_type == "donate") : ?>
                                        	<?php echo $wpcoHtml -> currency_html('<input type="text" name="Item[donate_price]" value="' . $wpcoHtml -> field_value('Item.donate_price') . '" id="Item.donate_price" class="donateprice" onkeyup="wpco_updateproductprice(\'' . $product -> id . '\', \'' . __('Calculating...', $this -> plugin_name) . '\');" />'); ?>
                                        <!-- By Square Measurement -->
                                        <?php elseif ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                                            <?php echo $wpcoForm -> text('Item.width', array('width' => "45px", 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?> <?php _e('X', $this -> plugin_name); ?>
                                            <?php echo $wpcoForm -> text('Item.length', array('width' => "45px", 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?>
                                            <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                                        <?php else : ?>
                                            <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                                        <?php endif; ?>
                                        
                                        <!-- Custom Fields & Product Varieties -->
                                        <?php if (empty($related) || $related == false) : ?>
											<?php if ($displaygrid == false && $this -> get_option('loop_showfields') == "Y") : ?>
                                                <?php if (!empty($product -> styles) && !empty($product -> options)) : ?>
                                                    <?php foreach ($product -> styles as $style_id) : ?>
                                                        <?php echo $this -> render_style($style_id, $product -> options[$style_id], true, $product -> id); ?>
                                                    <?php endforeach; ?>
                                                    
                                                    <script type="text/javascript">
                                                    eval("request<?php echo $product -> id; ?> = false;");                                                    
													jQuery(document).ready(function() {
														wpco_updateproductprice_new('<?php echo $product -> id; ?>', '<?php _e('Calculating...', $this -> plugin_name); ?>');
													});
													</script>
                                                <?php endif; ?>
                            
                                                <?php if (!empty($product -> cfields)) : ?>
                                                    <?php foreach ($product -> cfields as $field_id) : ?>
                                                        <?php if (!empty($field_id)) : ?>
                                                            <?php $this -> render_field($field_id, true, false, $product -> id); ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        
                                        <span class="wpcobuttonwrap">
                                            <?php if ($this -> get_option('buynow') == "Y" || (!empty($product -> buynow) && $product -> buynow == "Y")) : ?>
                                            <!-- BEG Buy Now -->
                                                <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                                    <span class="productsubmit buynowproductsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a class="<?php echo $this -> pre; ?>buylink" href="" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit();" title="<?php _e('Buy this product right now', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
                                                <?php else : ?>
                                                    <span class="productsubmit buynowproductsubmit productsubmitbutton" id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                                                <?php endif; ?>
                                                
                                                <?php if (empty($product -> oos) || $product -> oos == false) : ?>
                                                	<input type="hidden" name="buynow" value="Y" />
                                                <?php endif; ?>
                                            <!-- END Buy Now -->
                                            <?php elseif (!empty($product -> affiliate) && $product -> affiliate == "Y" && !empty($product -> affiliateurl)) : ?>
                                            <!-- BEG Affiliate -->
                                            	<?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                                	<span class="productsubmit productsubmittext affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><a href="<?php echo $product -> affiliateurl; ?>" <?php echo (!empty($product -> affiliatewindow) && $product -> affiliatewindow == "blank") ? 'target="_blank"' : 'target="_self"'; ?> title="<?php echo $product -> buttontext; ?>" class="<?php echo $this -> pre; ?>buylink"><?php echo $product -> buttontext; ?></a></span>
                                                <?php else : ?>
                                            		<span class="productsubmit productsubmitbutton affiliateproductsubmit" id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                                                <?php endif; ?>
                                            <!-- END Affiliate -->
                                            <?php else : ?>
                                            <!-- BEG Normal Product -->
                                                <?php if ($this -> get_option('loop_btntxt') == "txt") : ?>
                                                    <?php if ((!empty($product -> styles) || !empty($product -> cfields)) && $this -> get_option('loop_showfields') == "N") : ?>
                                                        <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="<?php echo get_permalink($product -> post_id); ?>" class="<?php echo $this -> pre; ?>buylink" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
                                                    <?php else : ?>
                                                        <?php if ($this -> get_option('cart_addajax') == "N" || ($product -> price_type == "donate" && (!empty($product -> inhonorof) && $product -> inhonorof == "Y"))) : ?>
                                                            <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" onclick="jQuery('#addtocart<?php echo $product -> id; ?>').submit();" class="<?php echo $this -> pre; ?>buylink" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
                                                        <?php else : ?>
                                                            <span class="productsubmit productsubmittext" id="submit<?php echo $product -> id; ?>"><a href="" class="<?php echo $this -> pre; ?>buylink" onclick="wpco_addtocart(jQuery('#addtocart<?php echo $product -> id; ?>'), '<?php echo $product -> id; ?>', '<?php echo $this -> widget_active('cart'); ?>'); return false;" title="<?php _e('Add this product to your shopping cart', $this -> plugin_name); ?>"><?php echo $product -> buttontext; ?></a></span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php else : ?>
                                                    <?php if (empty($product -> styles) && empty($product -> cfields)) : ?>     
                                                    	<?php if ($this -> get_option('cart_addajax') == "Y" && $product -> inhonorof != "Y") : ?>
                                                        	<span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><input type="button" name="submit" value="<?php echo $product -> buttontext; ?>" onclick="wpco_addtocart(jQuery('#addtocart<?php echo $product -> id; ?>'), '<?php echo $product -> id; ?>', '<?php echo $this -> widget_active('cart'); ?>'); return false;" /></span>
                                                        <?php else : ?>
                                                        	<span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                                                        <?php endif; ?>
                                                    <?php else : ?>
                                                        <span id="submit<?php echo $product -> id; ?>" class="productsubmit productsubmitbutton"><?php echo $wpcoForm -> submit($product -> buttontext); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <span class="<?php echo $this -> pre; ?>loading" id="loading<?php echo $product -> id; ?>" style="display:none; z-index:99;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /> <?php _e('Adding Item...', $this -> plugin_name); ?><br class="<?php echo $this -> pre; ?>cleaner" /></span>
                                                <span class="<?php echo $this -> pre; ?>added" style="display:none;" id="added<?php echo $product -> id; ?>"><img src="<?php echo $this -> url(); ?>/images/accept.png" /> <?php _e('Product has been added', $this -> plugin_name); ?><br class="<?php echo $this -> pre; ?>cleaner" /></span>
                                            <?php endif; ?>
                                        </span>
                                        
                                        <p class="<?php echo $this -> pre; ?>error producterror" id="message<?php echo $product -> id; ?>" style="display:none;"></p>
                                    </form>
                                <?php else : ?>
                                    <p class="<?php echo $this -> pre; ?>oos productoutofstock"><?php echo $wpcocaptions['product']['oos']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <?php if ($this -> get_option('favoritesshow') == "productsandloop") : ?>
                            	<?php $this -> render('favorites' . DS . 'link', array('product' => $product), true, 'default'); ?>
                            <?php endif; ?>
                        </div>
                    <!-- Not Showcase -->
                    <?php else : ?>
                    	<?php $showcasemsg = $this -> get_option('showcasemsg'); ?>
                        <?php if (!empty($showcasemsg) || !empty($product -> showcasemsg)) : ?>
                            <div class="productdetails productdetails<?php echo $product -> id; ?>">
                            	<p><?php echo (empty($product -> showcasemsg)) ? $showcasemsg : $product -> showcasemsg; ?></p>
                            </div>
                        <?php endif; ?>
					<?php endif; ?>
					
					<?php if ($displaygrid == false) : ?>
						<p class="productdescription"><?php echo $wpcoHtml -> truncate(apply_filters($this -> pre . '_product_description', $product -> description), $this -> get_option('loop_truncatedescription')); ?></p>
					<?php endif; ?>
					
					<?php if ($displaygrid == false) : ?>
						<?php if (!empty($product -> kws) && is_array($product -> kws)) : ?>
                        	<div class="productkeywords">
                                <small>
                                    <?php $k = 1; ?>
                                    <?php foreach ($product -> kws as $kw) : ?>
                                        <?php echo $wpcoHtml -> link($kw, $wpcoHtml -> retainquery($this -> pre . 'searchterm=' . urlencode($kw), get_permalink($this -> get_option('allproductsppid'))), array('title' => $kw)); ?>
                                        <?php echo ($k < count($product -> kws)) ? ', ' : ''; ?>
                                        <?php $k++; ?>
                                    <?php endforeach; ?>
                                </small>
                            </div>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php do_action('checkout_product_loop_after_each', $product); ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<br class="<?php echo $this -> pre; ?>cleaner" />
		<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
	</div>
<?php else : ?>
	<?php if (empty($searchterm)) : ?>
		<div class="<?php echo $this -> pre; ?>error productserror"><?php _e('No products are available', $this -> plugin_name); ?></div>
    <?php else : ?>
    	<div class="<?php echo $this -> pre; ?>error productserror"><?php _e('There were no product results found for your search ! - please double check the spelling or try a slightly different phrase. Try and use as few words as possible. If you are still not successful, why not try browsing the categories.', $this -> plugin_name); ?></div>
    <?php endif; ?>
<?php endif; ?>