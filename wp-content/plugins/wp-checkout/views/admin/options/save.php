<div class="wrap">
	<h2><?php _e('Save a Variation Option', $this -> plugin_name); ?></h2>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post" enctype="multipart/form-data">
		<?php echo $wpcoForm -> hidden('Option.id'); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Option.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Option.title'); ?>
                        <span class="howto"><?php _e('Give this variation option a title as it will be displayed to customers.', $this -> plugin_name); ?></span>
                    </td>
				</tr>
                <tr>
                	<th><label for="Option.image"><?php _e('Image', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="file" name="optionimage" value="" id="Option.image" />
                        <span class="howto"><?php _e('Image will be displayed as small thumbnails when using checkboxes or radio buttons.', $this -> plugin_name); ?></span>
                        <?php if (!empty($Option -> data -> image)) : ?>
                        	<a href="<?php echo site_url() . '/' . $Option -> data -> image_url; ?>" class="colorbox"><?php echo $wpcoHtml -> timthumb_image($Option -> data -> image_url, 50, 50, 100); ?></a>
                            <?php echo $wpcoForm -> hidden('Option.image', array('value' => $Option -> data -> image)); ?>
                        <?php endif; ?>
                    </td>
                </tr>
				<tr>
					<th><label for="Option.style_id"><?php _e('Variation', $this -> plugin_name); ?></label></th>
					<td>
						<?php $styles = $Style -> select(); ?>
						<?php echo $wpcoForm -> select('Option.style_id', $styles); ?>
					</td>
				</tr>
				<tr>
					<th><label for="Option.addprice"><?php _e('Add Price', $this -> plugin_name); ?></label></th>
					<td>
						<?php $addprice = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Option.addprice', $addprice, array('separator' => false, 'default' => "N", 'onclick' => "change_addprice(this.value)")); ?>
						
						<script type="text/javascript">
						function change_addprice(addprice) {
							if (addprice == "Y") {
								jQuery('#addpricediv').show();
							} else {
								jQuery('#addpricediv').hide();
							}
						}
						</script>
					</td>
				</tr>
			</tbody>
		</table>

		<div id="addpricediv" style="display:<?php echo ($wpcoHtml -> field_value('Option.addprice') == "Y") ? 'block' : 'none'; ?>;">		
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Option.price"><?php _e('Price', $this -> plugin_name); ?></label></th>
						<td>
							<?php /*<?php echo $wpcoHtml -> currency_html($wpcoForm -> text('Option.price', array('width' => "65px"))); ?>*/ ?>
							<?php $operators = array("curr" => $wpcoHtml -> currency(), "perc" => "&#37;"); ?>
							<?php echo $wpcoForm -> select('Option.operator', $operators); ?>
							<?php echo $wpcoForm -> text('Option.price', array('width' => "65px")); ?>
							<span class="howto"><?php _e('This price specified will be added to the product.', $this -> plugin_name); ?></span>
						</td>
					</tr>
					<tr>
						<th><label for="Option.condprices"><?php _e('Conditional Prices', $this -> plugin_name); ?></label></th>
						<td>
							<?php $condprices = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
							<?php echo $wpcoForm -> radio('Option.condprices', $condprices, array('separator' => false, 'default' => "N", 'onclick' => "if (this.value == 'Y') { jQuery('#condpricesdiv').show(); } else { jQuery('#condpricesdiv').hide(); }")); ?>
						</td>
					</tr>
				</tbody>
			</table>
			
			<div id="condpricesdiv" style="display:<?php echo ($wpcoHtml -> field_value('Option.condprices') == "Y") ? 'block' : 'none'; ?>;">
				<table class="form-table">
					<tbody>
						<tr>
							<th><label for=""><?php _e('Conditions', $this -> plugin_name); ?></label></th>
							<td>
								<?php $optiondata = $Option -> data; ?>
								<?php $wpcoDb -> model = $Style -> model; ?>
								<?php if ($styles = $wpcoDb -> find_all()) : ?>
									<ul class="<?php echo $this -> pre; ?>checklist">
										<?php foreach ($styles as $style) : ?>
											<?php if (!empty($style -> type) && ($style -> type == "radio" || $style -> type == "select")) : ?>
												<li>
													<label><input <?php echo (!empty($optiondata -> styles) && in_array($style -> id, $optiondata -> styles)) ? 'checked="checked"' : ''; ?> id="styleschecklist<?php echo $style -> id; ?>" onclick="jQuery('[id^=stylesoptions]').hide(); jQuery('#stylesoptions<?php echo $style -> id; ?>div').show();" type="radio" name="Option[styles][]" value="<?php echo $style -> id; ?>" /> <?php echo $style -> title; ?></label><br/>
													
													<div id="stylesoptions<?php echo $style -> id; ?>div" style="display:<?php echo (!empty($optiondata -> styles) && in_array($style -> id, $optiondata -> styles)) ? 'block' : 'none'; ?>;">
														<?php if ($options = $Option -> find_all(array('style_id' => $style -> id))) : ?>
															<ul id="options<?php echo $style -> id; ?>" style="padding:20px 0 0 20px;">
																<?php foreach ($options as $option) : ?>
																	<li style="padding:0 0 5px 0; border-bottom:1px #CCCCCC solid;">
																		<label style="float:left;"><input <?php echo (!empty($optiondata -> condoptions[$style -> id]) && in_array($option -> id, $optiondata -> condoptions[$style -> id])) ? 'checked="checked"' : ''; ?> type="checkbox" name="Option[options][<?php echo $style -> id; ?>][]" value="<?php echo $option -> id; ?>" /> <?php echo $option -> title; ?><?php echo (!empty($option -> addprice) && $option -> addprice == "Y") ? ' (' . $wpcoHtml -> currency_price($option -> price) . ')' : ''; ?></label>
																		<div style="float:right;">
																			<?php echo $wpcoHtml -> currency_html('<input type="text" class="widefat" style="width:65px;" value="' . $optiondata -> condpricesa[$option -> id] . '" name="Option[prices][' . $option -> id . ']" />'); ?>
																		</div>
																		<br class="clear" />
																	</li>
																<?php endforeach; ?>
															</ul>
														<?php endif; ?>
													</div>													
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								<?php else : ?>
									<span class="<?php echo $this -> pre; ?>error"><?php _e('No variations are available', $this -> plugin_name); ?></span>
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
			
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Variation Option', $this -> plugin_name)); ?>
		</p>
	</form>
</div>