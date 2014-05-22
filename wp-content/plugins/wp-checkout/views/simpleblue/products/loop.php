<?php if (!empty($searchterm)) : ?>
	<p><?php _e('Search results for', $this -> plugin_name); ?> "<strong><?php echo stripslashes($searchterm); ?></strong>"</p>
<?php endif; ?>

<?php if (!empty($products)) : ?>
	<?php 
	
	global $displaygrid;
		
	$displaygrid = true;
	$displaygrid = (!$this -> get_option('loop_display') || $this -> get_option('loop_display') == "grid") ? true : false; 
	
	if (!empty($related) && $related == true) {
		$displaygrid = ($this -> get_option('related_display') == "list") ? false : true;	
	}
	
	/* What is the view mode? */
	if (!empty($changeview)) {
		if ($changeview == "list") {
			$displaygrid = false;	
		} else {
			$displaygrid = true;
		}
	} elseif (isset($_COOKIE[$this -> pre . 'productsviewmode'])) {
		$productsviewmode = $_COOKIE[$this -> pre . 'productsviewmode'];
		
		if ($productsviewmode == "list") {
			$displaygrid = false;	
		} else {
			$displaygrid = true;
		}
	}
	
	$productswrapperclass = 'products' . (($displaygrid) ? 'grid' : 'list');
	$productswrapperid = $productswrapperclass . rand(1, 999);
	
	$productsstring = false;
	foreach ($products as $product) {
		$productsstring .= '&products[]=' . $product -> id;	
	}
	
	?>
    
	<div class="<?php echo $productswrapperclass; ?>" id="<?php echo $productswrapperid; ?>">
		<?php if (($this -> get_option('loopsorting') == "Y" || $this -> get_option('loop_changeviewmode') == "Y") && empty($related)) : ?>
			<div class="productsoptions">
				<form class="productssort">
					<?php if ($this -> get_option('loopsorting') == "Y") : ?>
						<label for="productsortselect"><?php _e('Sort By', $this -> plugin_name); ?>: </label>
						<select name="productsortselect" onchange="window.location=this.value;">
							<option value=""><?php _e('Choose Sorting', $this -> plugin_name); ?></option>
							<optgroup label="<?php _e('By Price', $this->plugin_name); ?>" name="sortlistselect">
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=price&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Low to High', $this->plugin_name); ?></option>
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=price&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('High to Low', $this->plugin_name); ?></option>
							</optgroup>
							<optgroup label="<?php _e('By Title', $this->plugin_name); ?>">
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=title&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('A to Z', $this->plugin_name); ?></option>
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=title&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Z to A', $this->plugin_name); ?></option>
							</optgroup>
							<optgroup label="<?php _e('By Date', $this->plugin_name); ?>">
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=modified&sort=DESC', $_SERVER['REQUEST_URI']); ?>"><?php _e('New to Old', $this->plugin_name); ?></option>
								<option value="<?php echo $wpcoHtml -> retainquery('sortby=modified&sort=ASC', $_SERVER['REQUEST_URI']); ?>"><?php _e('Old to New', $this->plugin_name); ?></option>
							</optgroup>
						</select>
					<?php endif; ?>
					
					<?php if ($this -> get_option('loop_changeviewmode') == "Y") : ?>
						<!-- change view between list/grid -->
						<a class="changeviewmode changetogrid" href="<?php echo $wpcoHtml -> retainquery('changeview=grid', $_SERVER['REQUEST_URI']); ?>">Grid View</a>
						<a class="changeviewmode changetolist" href="<?php echo $wpcoHtml -> retainquery('changeview=list', $_SERVER['REQUEST_URI']); ?>">List View</a>
					<?php endif; ?>
				</form>
			</div>
		<?php endif; ?>
        <?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
		<ul class="products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>ul">
			<?php $liclass = ''; ?>
			<?php foreach ($products as $product) : ?>
				<li class="products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>item products<?php echo ($displaygrid) ? 'grid' : 'list'; ?>item-<?php echo $liclass = (empty($liclass) || $liclass == "r") ? 'l' : 'r'; ?>">
					<?php if ($truncate = $this -> get_option('loop_truncatetitle')) : ?>
						<?php if (!empty($truncate)) : ?>
							<?php $product -> title = $wpcoHtml -> truncate(apply_filters($this -> pre . '_product_title', $product -> title), $truncate, '...'); ?>
						<?php endif; ?>
					<?php endif; ?>
					
					<?php /* CODE ADDED BY VITOR */ if ($displaygrid == true) : ?>
						<?php if (!$this -> get_option('loop_titleposition') || $this -> get_option('loop_titleposition') == "above") : ?>				
							<?php if (!empty($tabber) && $tabber == true) : ?>
								<h4 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h4>
							<?php else : ?>
								<h3 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h3>
							<?php endif; ?>
						<?php endif; ?>
					<?php /* CODE ADDED BY VITOR */ endif; ?>
					
					<?php $imgw = ($this -> get_option('loop_imgw')) ? "width:" . $this -> get_option('loop_imgw') . "px; " : ''; ?>
					<?php $imgh = ($this -> get_option('loop_imgh')) ? "height:" . $this -> get_option('loop_imgh') . "px; " : ''; ?>
				
					<div class="productimage">
                    	<?php $thumblink = ($this -> get_option('loop_thumblink') == "product") ? get_permalink($product -> post_id) : $wpcoHtml -> image_url($product -> image -> name); ?>
                    
						<?php if ($this -> get_option('cropthumb') == "Y") : ?>
							<?php /*<?php echo $wpcoHtml -> link($wpcoHtml -> image($wpcoHtml -> thumb_name($product -> image -> name, $append = "loopthumb"), array('class' => "productimagethumb"), $product -> image -> name), $thumblink, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => (($this -> get_option('loop_thumblink') == "product") ? "productimagelink" : "productimagelink thickbox"))); ?>*/ ?>
                            <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('loop_imgw'), $this -> get_option('loop_imgh'), $this -> get_option('loopthumbq'), "productimagethumb"), $thumblink, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => (($this -> get_option('loop_thumblink') == "product") ? "productimagelink" : "productimagelink colorbox"))); ?>
						<?php else : ?>
							<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> image -> name, array('class' => "productimagethumb"), $product -> image -> name), $thumblink, array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => (($this -> get_option('loop_thumblink') == "product") ? "productimagelink" : "productimagelink colorbox"))); ?>
						<?php endif; ?>
					</div>
					
					<?php /* CODE ADDED BY VITOR */ if ($displaygrid == true) : ?>
						<?php if ($this -> get_option('loop_titleposition') == "below") : ?>				
							<?php if (!empty($tabber) && $tabber == true) : ?>
								<h4 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h4>
							<?php else : ?>
								<h3 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h3>
							<?php endif; ?>
						<?php endif; ?>
					<?php /* CODE ADDED BY VITOR */ endif; ?>
					
					<?php /* CODE ADDED BY VITOR */ if ($displaygrid == false) : ?>
						<div class="productdataholder">
					<?php /* CODE ADDED BY VITOR */ endif; ?>
					
					<?php /* CODE ADDED BY VITOR */ if ($displaygrid == false) : ?>
						<h3 class="producttitle producttitle<?php echo $product -> id; ?>"><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $product -> title), get_permalink($product -> post_id), array('title' => apply_filters($this -> pre . '_product_title', $product -> title), 'class' => "producttitlelink")); ?></h3>
					<?php /* CODE ADDED BY VITOR */ endif; ?>

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
                                                <?php _e('How many?', $this -> plugin_name); ?>
                                                <?php echo $wpcoForm -> text('Item.count', array('value' => (empty($product -> min_order)) ? '1' : $product -> min_order, 'width' => '25px')); ?>
                                            </div>
                                        <!-- Donation Product -->
                                        <?php elseif ($product -> price_type == "donate") : ?>
                                        	<?php echo $wpcoHtml -> currency_html('<input type="text" name="Item[donate_price]" value="' . $wpcoHtml -> field_value('Item.donate_price') . '" id="Item.donate_price" class="donateprice" onkeyup="wpco_updateproductprice(\'' . $product -> id . '\', \'' . __('Calculating...', $this -> plugin_name) . '\');" />'); ?>
                                        <!-- By Square Measurement -->
                                        <?php elseif ($product -> price_type == "square" && !empty($product -> square_price)) : ?>
                                        	<div class="productsizeholder">
												<?php echo $wpcoForm -> text('Item.width', array('width' => "35px", 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?> <?php _e('X', $this -> plugin_name); ?>
                                                <?php echo $wpcoForm -> text('Item.length', array('width' => "35px", 'onkeyup' => "wpco_updateproductprice('" . $product -> id . "', '" . __('Calculating...', $this -> plugin_name) . "');")); ?><?php echo $product -> lengthmeasurement; ?>
                                                <?php echo $wpcoForm -> hidden('Item.count', array('value' => 1)); ?>
                                            </div>
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
                                        
                                        
                                        
                                        <p class="<?php echo $this -> pre; ?>error producterror" id="message<?php echo $product -> id; ?>" style="display:none;"></p>
                                    </form>
                                <?php else : ?>
                                    <p class="<?php echo $this -> pre; ?>oos productoutofstock"><?php echo $wpcocaptions['product']['oos']; ?></p>
                                <?php endif; ?>
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
					
					<?php if ($this -> get_option('favoritesshow') == "productsandloop") : ?>
						<?php $this -> render('favorites' . DS . 'link', array('product' => $product), true, 'default'); ?>
					<?php endif; ?>
					
					<?php /* CODE ADDED BY VITOR */ if ($displaygrid == false) : ?>
						</div>
					<?php /* CODE ADDED BY VITOR */ endif; ?>
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