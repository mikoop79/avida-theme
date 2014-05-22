<?php 
				
global $wpdb;
$wpcoDb -> model = $Style -> model;
$allstyles = $wpcoDb -> find_all(false, array('id', 'title'), array('order', "ASC"));

?>
<?php if (!empty($allstyles)) : ?>
	<div class="scroll-list">
		<ul class="<?php echo $this -> pre; ?>checklist" id="styles">
			<?php if (!empty($Product -> data -> styles)) : ?>
				<?php $currentpstyles = array(); ?>
				<?php foreach ($Product -> data -> styles as $style_id) : ?>
					<?php
					$wpcoDb -> model = $Style -> model;
					$style_title = $wpcoDb -> field("title", array('id' => $style_id)); 
					?>
					
	                <?php if (!empty($style_title)) : ?>
	                    <li id="item_<?php echo $style_id; ?>">
	                        <span class="variationhandle" style="cursor:move; margin-top:4px; margin-right:5px; float:left;"><img src="<?php echo $this -> url(); ?>/images/updowndrag.png" /></span>
	                        <a title="<?php _e('Delete product variation', $this -> plugin_name); ?>" href="" onclick="if (confirm('<?php _e('Are you sure you want to remove this product variation permanently?', $this -> plugin_name); ?>')) { jQuery('#productvariations').load(ajaxurl + '?action=deleteproductvariation&rand=<?php echo rand(1, 999); ?>&product_id=<?php echo $Product -> data -> id; ?>', {style_id:<?php echo $style_id; ?>}); }; return false;"><img style="border:none;" src="<?php echo $this -> url(); ?>/images/deny.png" alt="delete" /></a>
	                        <a title="<?php _e('Edit product variation', $this -> plugin_name); ?>" href="" onclick="wpco_adminajax('<?php _e('Edit a Product Variation'); ?>', 'addproductvariationoption&width=620&height=520&product_id=<?php echo $Product -> data -> id; ?>&style_id=<?php echo $style_id; ?>'); return false;"><img src="<?php echo $this -> url(); ?>/images/edit.png" alt="edit" border="0" style="border:none;" /></a>
	                        <label><input checked="checked" onclick="jQuery('#options<?php echo $style_id; ?>').toggle();" type="checkbox" name="Product[styles][]" value="<?php echo $style_id; ?>" /> <?php echo __($style_title); ?></label>
	                        <br class="clear" />
	                        
	                        <!-- Variation Options -->
	                        <?php $wpcoDb -> model = $Option -> model; ?>
	                        <?php if ($options = $wpcoDb -> find_all(array('style_id' => $style_id), false, array('order', "ASC"))) : ?>
	                            <ul id="options<?php echo $style_id; ?>" style="padding:0 0 0 80px; display:block;">
	                            	<li>
			                        	<label><input <?php echo (empty($Product -> data -> styledefault[$style_id])) ? 'checked="checked"' : ''; ?> type="radio" name="Product[styledefault][<?php echo $style_id; ?>]" value="0" id="Product_styledefault_0" /> <?php _e('no default', $this -> plugin_name); ?></label>
		                        	</li>
	                                <?php foreach ($options as $option) : ?>
	                                    <li>
	                                    	<label title="<?php _e('Default Option', $this -> plugin_name); ?>"><input <?php echo (!empty($Product -> data -> styledefault[$style_id]) && $Product -> data -> styledefault[$style_id] == $option -> id) ? 'checked="checked"' : ''; ?> type="radio" name="Product[styledefault][<?php echo $style_id; ?>]" value="<?php echo $option -> id; ?>" /> <?php _e('default', $this -> plugin_name); ?></label>
	                                    	<label><input onclick="jQuery('#optionstock<?php echo $option -> id; ?>div').toggle();" <?php echo (!empty($Product -> data -> options[$style_id]) && in_array($option -> id, $Product -> data -> options[$style_id])) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[options][]" value="<?php echo $option -> id; ?>" /> <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : '') . ')' : ''; ?></label>
	                                    	<span id="optionstock<?php echo $option -> id; ?>div" style="display:<?php echo (!empty($Product -> data -> options[$style_id]) && in_array($option -> id, $Product -> data -> options[$style_id])) ? 'block' : 'none'; ?>;">
	                                    		<label>
	                                    			<strong><?php _e('Inventory/Stock:', $this -> plugin_name); ?></strong>
	                                    			<input type="text" name="Product[optionstock][<?php echo $option -> id; ?>]" value="<?php echo esc_attr(stripslashes($Product -> data -> optionstock[$option -> id])); ?>" id="Product_optionstock_<?php echo $option -> id; ?>" class="widefat" style="width:65px;" />
	                                    			<br/><small><?php _e('Set to <b>-1</b> for unlimited/infinite stock count.', $this -> plugin_name); ?></small>
	                                    		</label>
	                                    	</span>
	                                    </li>
	                                <?php endforeach; ?>
	                            </ul>
	                        <?php endif; ?>
	                    </li>
	                <?php endif; ?>
					<?php $currentpstyles[] = $style_id; ?>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<?php if (!empty($allstyles)) : ?>
				<?php $options = false; ?>
				<?php foreach ($allstyles as $allstyle) : ?>
					<?php if (empty($currentpstyles) || (!empty($currentpstyles) && !in_array($allstyle -> id, $currentpstyles))) : ?>
						<li id="item_<?php echo $allstyle -> id; ?>">                                    
							<span class="variationhandle" style="cursor:move; margin-top:4px; margin-right:5px; float:left;"><img src="<?php echo $this -> url(); ?>/images/updowndrag.png" /></span>
							<a title="<?php _e('Delete product variation', $this -> plugin_name); ?>" href="" onclick="if (confirm('<?php _e('Are you sure you want to remove this product variation permanently?', $this -> plugin_name); ?>')) { jQuery('#productvariations').load(ajaxurl + '?action=deleteproductvariation&rand=<?php echo rand(1, 999); ?>&product_id=<?php echo $Product -> data -> id; ?>', {style_id:<?php echo $allstyle -> id; ?>}); }; return false;"><img style="border:none;" src="<?php echo $this -> url(); ?>/images/deny.png" alt="delete" /></a>
							<a title="<?php _e('Edit product variation', $this -> plugin_name); ?>" href="" onclick="wpco_adminajax('<?php _e('Edit a Product Variation'); ?>', 'addproductvariationoption&width=620&height=520&product_id=<?php echo $Product -> data -> id; ?>&style_id=<?php echo $allstyle -> id; ?>'); return false;" title=""><img src="<?php echo $this -> url(); ?>/images/edit.png" alt="edit" border="0" style="border:none;" /></a>
							<label><input onclick="jQuery('#options<?php echo $allstyle -> id; ?>').toggle();" type="checkbox" name="Product[styles][]" value="<?php echo $allstyle -> id; ?>" /> <?php echo __($allstyle -> title); ?></label>
	                        <br class="clear" />
	                        
							<!-- Variation Options -->
							<?php $wpcoDb -> model = $Option -> model; ?>
							<?php if ($options = $wpcoDb -> find_all(array('style_id' => $allstyle -> id), false, array('order', "ASC"))) : ?>
								<ul id="options<?php echo $allstyle -> id; ?>" style="padding:0 0 0 80px; display:none;">
									<li>
			                        	<label><input type="radio" name="Product[styledefault][<?php echo $allstyle -> id; ?>]" value="0" id="Product_styledefault_0" /> <?php _e('no default', $this -> plugin_name); ?></label>
		                        	</li>
									<?php foreach ($options as $option) : ?>
										<li>
											<label title="<?php _e('Default Option', $this -> plugin_name); ?>"><input type="radio" name="Product[styledefault][<?php echo $allstyle -> id; ?>]" value="<?php echo $option -> id; ?>" /> <?php _e('default', $this -> plugin_name); ?></label>
											<label><input onclick="jQuery('#optionstock<?php echo $option -> id; ?>div').toggle();" <?php echo (!empty($Product -> data -> options[$allstyle -> id]) && in_array($option -> id, $Product -> data -> options[$allstyle -> id])) ? 'checked="checked"' : ''; ?> type="checkbox" name="Product[options][]" value="<?php echo $option -> id; ?>" /> <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $option -> symbol . ((!empty($option -> operator) && $option -> operator == "curr") ? $wpcoHtml -> currency() : '') . $option -> price . ((!empty($option -> operator) && $option -> operator == "perc") ? '&#37;' : '') . ')' : ''; ?></label>
											<span id="optionstock<?php echo $option -> id; ?>div" style="display:none;">
												<br/>
												<label>
	                                    			<strong><?php _e('Inventory/Stock:', $this -> plugin_name); ?></strong>
	                                    			<input type="text" name="Product[optionstock][<?php echo $option -> id; ?>]" value="-1" id="Product_optionstock_<?php echo $option -> id; ?>" class="widefat" style="width:65px;" />
	                                    			<br/><small><?php _e('Set to <b>-1</b> for unlimited/infinite stock count.', $this -> plugin_name); ?></small>
	                                    		</label>
											</span>	
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>
	
	<div id="message" style="color:red;"></div>
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("ul#styles").sortable({
			start: function(event, ui) {
				jQuery('#message').html('<img src="<?php echo $this -> url(); ?>/images/loading.gif" /> <?php _e('loading...', $this -> plugin_name); ?>');
			},
			update: function(event, ui) {
				jQuery("#message").load(wpcoAjax + "?cmd=styles_order&product_id=<?php echo $Product -> data -> id;?>", jQuery("ul#styles").sortable("serialize")).slideDown("slow");
			}
		});
	});
	</script>
<?php else : ?>
	<span class="<?php echo $this -> pre; ?>error"><?php _e('No variations are available.', $this -> plugin_name); ?></span>
<?php endif; ?>