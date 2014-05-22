<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="product_defaulttype_digital"><?php _e('Default Product Type', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('product_defaulttype') == "tangible") ? 'checked="checked"' : ''; ?> type="radio" name="product_defaulttype" value="tangible" id="product_defaulttype_tangible" /> <?php _e('Tangible', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('product_defaulttype') == "digital") ? 'checked="checked"' : ''; ?> type="radio" name="product_defaulttype" value="digital" id="product_defaulttype_digital" /> <?php _e('Digital', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('The default product type to use when creating new products.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="product_infoholderwidth"><?php _e('Product Info Holder Width', $this -> plugin_name); ?></label></th>
        	<td>
        		<input type="text" class="widefat" style="width:65px;" name="product_infoholderwidth" value="<?php echo esc_attr(stripslashes($this -> get_option('product_infoholderwidth'))); ?>" id="product_infoholderwidth" /> <?php _e('px', $this -> plugin_name); ?>
        		<span class="howto"><?php _e('Width of the info holder for the description, variations, custom fields, etc.', $this -> plugin_name); ?></span>
        	</td>
        </tr>
    	<tr>
        	<th><label for="product_showcategories_Y"><?php _e('Show Categories', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('product_showcategories') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="product_showcategories" value="Y" id="product_showcategories_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('product_showcategories') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="product_showcategories" value="N" id="product_showcategories_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('show categories on individual product page.', $this -> plugin_name); ?></span>
            </td>
        </tr>
        <tr>
        	<th><label for="product_showkeywords_Y"><?php _e('Show Keywords', $this -> plugin_name); ?></label></th>
            <td>
      			<label><input <?php echo ($this -> get_option('product_showkeywords') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="product_showkeywords" value="Y" id="product_showkeywords_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('product_showkeywords') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="product_showkeywords" value="N" id="product_showkeywords_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('show keywords on individual product page.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="product_desrciptionposition_below"><?php _e('Description Position', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('product_descriptionposition') == "above") ? 'checked="checked"' : ''; ?> type="radio" name="product_descriptionposition" value="above" id="product_descriptionposition_above" /> <?php _e('ABOVE fields and "Add to Basket" button', $this -> plugin_name); ?></label><br/>
                <label><input <?php echo ($this -> get_option('product_descriptionposition') == "below") ? 'checked="checked"' : ''; ?> type="radio" name="product_descriptionposition" value="below" id="product_descriptionposition_below" /> <?php _e('BELOW fields and "Add to Basket" button', $this -> plugin_name); ?></label> 
            	
            </td>
        </tr>
        <tr>
        	<th><label for="product_showspecs_Y"><?php _e('Show Specifications', $this -> plugin_name); ?></label></th>
        	<td>
        		<label><input <?php echo ($this -> get_option('product_showspecs') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="product_showspecs" value="Y" id="product_showspecs_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
        		<label><input <?php echo ($this -> get_option('product_showspecs') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="product_showspecs" value="N" id="product_showspecs_N" /> <?php _e('No', $this -> plugin_name); ?></label>
        		<span class="howto"><?php _e('Should the product weight and dimensions be displayed on the product pages (if available)?', $this -> plugin_name); ?></span>
        	</td>
        </tr>
		<tr>
			<th><label for="howmanyY"><?php _e('Display "How Many"', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#howmanydiv').show();" <?php echo ($this -> get_option('howmany') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="howmany" value="Y" id="howmanyY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#howmanydiv').hide();" <?php echo ($this -> get_option('howmany') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="howmany" value="N" id="howmanyN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('turn on/off the quantity field on the product page', $this -> plugin_name); ?></span>
			</td>
		</tr>
    </tbody>
</table>

<div id="howmanydiv" style="display:<?php echo ($this -> get_option('howmany') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<tr>
                <th><label for="product_showstock_Y"><?php _e('Show Inventory/Stock', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input <?php echo ($this -> get_option('product_showstock') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="product_showstock" value="Y" id="product_showstock_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('product_showstock') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="product_showstock" value="N" id="product_showstock_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('Display the available inventory/stock available if a product has it.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="loop_btntxt_btn"><?php _e('Show Button/Text Link', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('loop_btntxt') == "btn") ? 'checked="checked"' : ''; ?> type="radio" name="loop_btntxt" value="btn" id="loop_btntxt_btn" /> <?php _e('Button', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('loop_btntxt') == "txt") ? 'checked="checked"' : ''; ?> type="radio" name="loop_btntxt" value="txt" id="loop_btntxt_txt" /> <?php _e('Text Link', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Affects both the products loop and product pages.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loop_btnlnktext"><?php _e('Button/Link Text', $this -> plugin_name); ?></label></th>
			<td>
				<input class="widefat" type="text" name="loop_btnlnktext" value="<?php echo $this -> get_option('loop_btnlnktext'); ?>" id="loop_btnlnktext" />
				<span class="howto"><?php _e('Affects both the products loop and product pages and can be changed individually per product.', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="product_zerotext"><?php _e('Zero Price Text', $this -> plugin_name); ?></label></th>
            <td>
            
            	<input class="widefat" type="text" name="product_zerotext" value="<?php echo esc_attr(stripslashes($this -> get_option('product_zerotext'))); ?>" id="product_zerotext" />
            	<span class="howto"><?php _e('text to display if a product has a zero price', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="relatedintabN"><?php _e('Related Products in Tab', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('relatedintab') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="relatedintab" value="Y" id="relatedintabY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('relatedintab') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="relatedintab" value="N" id="relatedintabN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('if set to "Yes" displays related products in a tab, else they will be displayed below the product pitch overview', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="related_display_list"><?php _e('Related Products Layout', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('related_display') == "list") ? 'checked="checked"' : ''; ?> type="radio" name="related_display" value="list" id="related_display_list" /> <?php _e('List View', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('related_display') == "grid") ? 'checked="checked"' : ''; ?> type="radio" name="related_display" value="grid" id="related_display_grid" /> <?php _e('Grid View', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('set the way (list or grid) that related products will be displayed on product pages.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><?php _e('Show Fields in Tab', $this -> plugin_name); ?></th>
			<td>
				<label><input onclick="jQuery('#optionslinkdiv').show();" <?php echo ($this -> get_option('fieldsintab') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="fieldsintab" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#optionslinkdiv').hide();" <?php echo (!$this -> get_option('fieldsintab') || $this -> get_option('fieldsintab') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="fieldsintab" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('displays custom fields and options in a tab if content tabs are available', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="optionslinkdiv" style="display:<?php echo ($this -> get_option('fieldsintab') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="optionslinktbB"><?php _e('Options Link', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('optionslinktb') == "T") ? 'checked="checked"' : ''; ?> type="radio" name="optionslinktb" value="T" id="optionslinktbT" /> <?php _e('Top', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('optionslinktb') == "B") ? 'checked="checked"' : ''; ?> type="radio" name="optionslinktb" value="B" id="optionslinktbB" /> <?php _e('Bottom', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('show product options link at the top or bottom', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><?php _e('Image Gallery and Overlay', $this -> plugin_name); ?></th>
            <td>
            	<label><input <?php if ($this -> is_plugin_active('jqzoom')) : ?>onclick="jQuery('#product_imagegallery_jqzoom_div').hide();" <?php echo ($this -> get_option('product_imagegallery') == "colorbox") ? 'checked="checked"' : ''; ?><?php else : ?>checked="checked"<?php endif; ?> type="radio" name="product_imagegallery" value="colorbox" id="product_imagegallery_colorbox" /> <?php _e('Lightbox Effect', $this -> plugin_name); ?></label>
                <label><input <?php if ($this -> is_plugin_active('jqzoom')) : ?>onclick="jQuery('#product_imagegallery_jqzoom_div').show();" <?php echo ($this -> get_option('product_imagegallery') == "jqzoom") ? 'checked="checked"' : ''; ?><?php else : ?>disabled="disabled"<?php endif; ?> type="radio" name="product_imagegallery" value="jqzoom" id="product_imagegallery_jqzoom" /> <?php _e('Zoom Effect', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Choose the way product images and thumbnails are displayed to customers.', $this -> plugin_name); ?></span>
                
                <?php if (!$this -> is_plugin_active('jqzoom')) : ?>
                	<div class="<?php echo $this -> pre; ?>error"><?php echo sprintf(__('In order to use the zoom effect, you need to have the %sZoom Gallery%s extension plugin installed and activated.', $this -> plugin_name), '<a href="http://tribulant.com/extensions/view/4/zoom-gallery" target="_blank">', "</a>"); ?></div>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<?php if ($this -> is_plugin_active('jqzoom')) : ?>
    <div id="product_imagegallery_jqzoom_div" style="display:<?php echo ($this -> get_option('product_imagegallery') == "jqzoom") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="jqzoom_lens"><?php _e('Zoom Lens', $this -> plugin_name); ?></label></th>
                    <td>
                        <label><input <?php echo ($this -> get_option('jqzoom_lens') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="jqzoom_lens" value="Y" id="jqzoom_lens_Y" /> <?php _e('Enabled', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('jqzoom_lens') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="jqzoom_lens" value="N" id="jqzoom_lens_N" /> <?php _e('Disabled', $this -> plugin_name); ?></label>
                        <span class="howto"><?php _e('The zoom lens is a small block following the mouse cursor inside the product image.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="jqzoom_position_right"><?php _e('Zoom Effect Position', $this -> plugin_name); ?></label></th>
                    <td>
                        <label><input <?php echo ($this -> get_option('jqzoom_position') == "left") ? 'checked="checked"' : ''; ?> type="radio" name="jqzoom_position" value="left" id="jqzoom_position_left" /> <?php _e('Left', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('jqzoom_position') == "right") ? 'checked="checked"' : ''; ?> type="radio" name="jqzoom_position" value="right" id="jqzoom_position_right" /> <?php _e('Right', $this -> plugin_name); ?></label>
                        <span class="howto"><?php _e('Position of the zoom effect, on the left- or right-hand side of the product image?', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="jqzoom_width"><?php _e('Dimensions of Zoom Window', $this -> plugin_name); ?></label></th>
                    <td>
                        <input type="text" class="widefat" style="width:45px;" name="jqzoom_width" value="<?php echo esc_attr(stripslashes($this -> get_option('jqzoom_width'))); ?>" id="jqzoom_width" /> <?php _e('by', $this -> plugin_name); ?>
                        <input type="text" class="widefat" style="width:45px;" name="jqzoom_height" value="<?php echo esc_attr(stripslashes($this -> get_option('jqzoom_height'))); ?>" id="jqzoom_height" /> <?php _e('px', $this -> plugin_name); ?>
                        <span class="howto"><?php _e('Width and height of the zoom effect window which shows the zoom of the product image.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<table class="form-table">
	<tbody>
		<tr>
			<th><?php _e('Image Display', $this -> plugin_name); ?></th>
			<td>
				<label><input onclick="jQuery('#cropthumbdiv').hide(); jQuery('#croploopthumbdiv').hide();" <?php echo ($this -> get_option('cropthumb') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cropthumb" value="N" id="cropthumbN" /> <?php _e('Full Images', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#cropthumbdiv').show(); jQuery('#croploopthumbdiv').show();" <?php echo (!$this -> get_option('cropthumb') || $this -> get_option('cropthumb') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cropthumb" value="Y" id="cropthumbY" /> <?php _e('Thumbnail Images', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('affects both the product loops and product pages', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="unitextboxN"><?php _e('Universal Text Box', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('unitextbox') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#unitextboxdiv').show();" type="radio" name="unitextbox" value="Y" id="unitextboxY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('unitextbox') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#unitextboxdiv').hide();" type="radio" name="unitextbox" value="N" id="unitextboxN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('places a text message below each of your products on the product pages', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="unitextboxdiv" style="display:<?php echo ($this -> get_option('unitextbox') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="unitextboxintabsN"><?php _e('Show in Content Tabs', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('unitextboxintabs') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="unitextboxintabs" value="Y" id="unitextboxintabsY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('unitextboxintabs') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="unitextboxintabs" value="N" id="unitextboxintabsN" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('set to "Yes" to show in content tabs as well', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="unitextfieldsetN"><?php _e('Show in Fieldset', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('unitextfieldset') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="unitextfieldset" value="Y" id="unitextfieldsetY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('unitextfieldset') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="unitextfieldset" value="N" id="unitextfieldsetN" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('displays message in a fieldset below categories with heading "Attention"', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><?php _e('Univeral Message', $this -> plugin_name); ?></th>
				<td>
					<textarea name="unitextboxmessage" class="widefat" rows="4"><?php echo $this -> get_option('unitextboxmessage'); ?></textarea>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div id="cropthumbdiv" style="display:<?php echo (!$this -> get_option('cropthumb') || $this -> get_option('cropthumb') == "Y") ? 'block' : 'none'; ?>;">					
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
				<td>
					<input class="widefat" style="width:40px;" type="text" name="thumbw" value="<?php echo $this -> get_option('thumbw'); ?>" />
					<?php _e('by', $this -> plugin_name); ?>
					<input class="widefat" style="width:40px;" type="text" name="thumbh" value="<?php echo $this -> get_option('thumbh'); ?>" />
					<?php _e('px', $this -> plugin_name); ?>
					<span class="howto"><?php _e('Dimensions of your product page images, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="smallw"><?php _e('Extra Images', $this -> plugin_name); ?></label></th>
				<td>
					<input class="widefat" style="width:40px;" type="text" name="smallw" value="<?php echo $this -> get_option('smallw'); ?>" id="smallw" />
					<?php _e('by', $this -> plugin_name); ?>
					<input class="widefat" style="width:40px;" type="text" name="smallh" value="<?php echo $this -> get_option('smallh'); ?>" id="smallh" />
					<?php _e('px', $this -> plugin_name); ?>
					<span class="howto"><?php _e('Dimensions of the extra image thumbnails below the main product image.', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="thumbq"><?php _e('Thumbnail Quality', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" class="widefat" style="width:45px;" name="thumbq" value="<?php echo attribute_escape($this -> get_option('thumbq')); ?>" id="thumbq" /> &#37;
					<span class="howto"><?php _e('reduce quality to reduce filesize &amp; increase site performance', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="noimageurl"><?php _e('No image URL', $this -> plugin_name); ?></label></th>
			<td>
				<input id="noimageurl" class="widefat" type="text" name="noimageurl" value="<?php echo $this -> get_option('noimageurl'); ?>" />
				<span class="howto"><?php _e('this image will be displayed when a product does not have an image available', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="product_sharingbuttons_Y"><?php _e('Show Sharing Buttons', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('product_sharingbuttons') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="product_sharingbuttons" value="Y" id="product_sharingbuttons_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('product_sharingbuttons') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="product_sharingbuttons" value="N" id="product_sharingbuttons_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Should sharing buttons (Facebook, Twitter, Google Plus, etc.) be shown at the bottom of the product?', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>