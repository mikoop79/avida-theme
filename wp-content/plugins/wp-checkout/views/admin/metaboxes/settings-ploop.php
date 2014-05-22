<table class="form-table">
	<tbody>
		<tr>
			<th><label for="loop_displaygrid"><?php _e('Display', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('loop_display') == "list") ? 'checked="checked"' : ''; ?> type="radio" name="loop_display" value="list" id="loop_displaylist" /> <?php _e('List View', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('loop_display') == "grid") ? 'checked="checked"' : ''; ?> type="radio" name="loop_display" value="grid" id="loop_displaygrid" /> <?php _e('Grid View', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('specify how product should be displayed in the loop', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
            <th><label for="loop_showfields_N"><?php _e('Show Fields', $this -> plugin_name); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('loop_showfields') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loop_showfields" value="Y" id="loop_showfields_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('loop_showfields') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loop_showfields" value="N" id="loop_showfields_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('should custom fields and product variations be shown in the product loop? It only works with list view, not with grid view.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="loop_changeviewmode_Y"><?php _e('Allow Changing of View Mode', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('loop_changeviewmode') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loop_changeviewmode" value="Y" id="loop_changeviewmode_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('loop_changeviewmode') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loop_changeviewmode" value="N" id="loop_changeviewmode_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Do you want to allow users/customers to change the view between list/grid?', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="loopsortingN"><?php _e('Sorting Options', $this -> plugin_name); ?></label></th>
			<td>
				<label><input type="radio" <?php echo ($this -> get_option('loopsorting') == "Y") ? 'checked="checked"' : ''; ?> id="loopsortingY" name="loopsorting" value="Y" /> <?php _e('Show', $this -> plugin_name); ?></label>
				<label><input type="radio" <?php echo ($this -> get_option('loopsorting') == "N") ? 'checked="checked"' : ''; ?> id="loopsortingN" name="loopsorting" value="N" /> <?php _e('Hide', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('allow users to sort products by title, price &amp; date', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loop_sort_field"><?php _e('Default Order Field', $this -> plugin_name); ?></label></th>
			<td>
				<select name="loop_sort_field" id="loop_sort_field">
					<option value="">- <?php _e('Select', $this -> plugin_name); ?> -</option>
					<option <?php echo ($this -> get_option('loop_sort_field') == "title") ? 'selected="selcted"' : ''; ?> value="title"><?php _e('Title', $this -> plugin_name); ?></option>
					<option <?php echo ($this -> get_option('loop_sort_field') == "price") ? 'selected="selcted"' : ''; ?> value="price"><?php _e('Price', $this -> plugin_name); ?></option>
					<option <?php echo ($this -> get_option('loop_sort_field') == "modified") ? 'selected="selcted"' : ''; ?> value="modified"><?php _e('Date', $this -> plugin_name); ?></option>
				</select>
                
                <span class="howto"><?php _e('field to order products by in the products list/grid', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loop_sort_direction_ASC"><?php _e('Default Order Direction', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('loop_sort_direction') == "ASC") ? 'checked="checked"' : ''; ?> type="radio" name="loop_sort_direction" value="ASC" id="loop_sort_direction_ASC" /> <?php _e('Ascending', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('loop_sort_direction') == "DESC") ? 'checked="checked"' : ''; ?> type="radio" name="loop_sort_direction" value="DESC" id="loop_sort_direction_DESC" /> <?php _e('Descending', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('This works in conjunction with the "Default Order Field" above. Ascending is A to Z, Low to High, etc.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loop_titleposition_above"><?php _e('Product Title Position', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (!$this -> get_option('loop_titleposition') || $this -> get_option('loop_titleposition') == "above") ? 'checked="checked"' : ''; ?> type="radio" name="loop_titleposition" value="above" id="loop_titleposition_above" /> <?php _e('Above Image', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('loop_titleposition') == "below") ? 'checked="checked"' : ''; ?> type="radio" name="loop_titleposition" value="below" id="loop_titleposition_below" /> <?php _e('Below Image', $this -> plugin_name); ?></label>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>loop_truncatetitle"><?php _e('Truncate Titles', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" class="widefat" style="width:45px;" name="loop_truncatetitle" value="<?php echo $this -> get_option('loop_truncatetitle'); ?>" id="<?php echo $this -> pre; ?>loop_truncatetitle" /> <?php _e('characters', $this -> plugin_name); ?>
				<span class="howto"><?php _e('Truncate product titles. To ignore, leave empty.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="loop_truncatedescription"><?php _e('Truncate Descriptions', $this -> plugin_name); ?></label></th>
			<td>
				<input type="text" class="widefat" style="width:45px;" name="loop_truncatedescription" value="<?php echo esc_attr(stripslashes($this -> get_option('loop_truncatedescription'))); ?>" id="loop_truncatedescription" />
				<span class="howto"><?php _e('Truncate product descriptions in the loop. Leave empty to ignore.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>loop_perpage"><?php _e('Products per Page', $this -> plugin_name); ?></label></th>
			<td><input type="text" name="loop_perpage" value="<?php echo $this -> get_option('loop_perpage'); ?>" id="<?php echo $this -> pre; ?>loop_perpage" class="widefat" style="width:45px;" /> <?php _e('products', $this -> plugin_name); ?></td>
		</tr>
        <tr>
        	<th><label for="loop_zerotext"><?php _e('Zero Price Text', $this -> plugin_name); ?></label></th>
            <td>
            	<input class="widefat" type="text" name="loop_zerotext" value="<?php echo esc_attr(stripslashes($this -> get_option('loop_zerotext'))); ?>" id="loop_zerotext" />
            	<span class="howto"><?php _e('text to display if a product has a zero price', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>loop_addbutton"><?php _e('Show Add/Buy button', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#loop_addbuttonY_div').show();" <?php echo (!$this -> get_option('loop_addbutton') || $this -> get_option('loop_addbutton') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loop_addbutton" value="Y" id="<?php echo $this -> pre; ?>loop_addbutton" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#loop_addbuttonY_div').hide();" <?php echo ($this -> get_option('loop_addbutton') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loop_addbutton" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
			</td>
		</tr>
	</tbody>
</table>

<div id="loop_addbuttonY_div" style="display:<?php echo ($this -> get_option('loop_addbutton') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="loop_howmany_Y"><?php _e('Display "How Many"', $this -> plugin_name); ?></label></th>
				<td>
					<label><input <?php echo ($this -> get_option('loop_howmany') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="loop_howmany" value="Y" id="loop_howmany_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('loop_howmany') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="loop_howmany" value="N" id="loop_howmany_N" /> <?php _e('No', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Displays a "how many" text box for item quantity of the product being added', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="loop_thumblink_product"><?php _e('Link Thumbnail To', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('loop_thumblink') == "product") ? 'checked="checked"' : ''; ?> type="radio" name="loop_thumblink" value="product" id="loop_thumblink_product" /> <?php _e('Product Page', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('loop_thumblink') == "image") ? 'checked="checked"' : ''; ?> type="radio" name="loop_thumblink" value="image" id="loop_thumblink_image" /> <?php _e('Larger/Original Image', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Where should the thumbnails in the products loop link to?', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<div id="croploopthumbdiv" style="display:<?php echo ($this -> get_option('cropthumb') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
				<td>
					<input class="widefat" style="width:45px;" type="text" name="loop_imgw" value="<?php echo $this -> get_option('loop_imgw'); ?>" />
					<?php _e('by', $this -> plugin_name); ?>
					<input class="widefat" style="width:45px;" type="text" name="loop_imgh" value="<?php echo $this -> get_option('loop_imgh'); ?>" />
					<?php _e('px', $this -> plugin_name); ?>
                    
                    <span class="howto"><?php _e('Dimensions of your product loop images, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>
					
                    <?php /*
					<div>
						<label><input <?php echo ($this -> get_option('croploopthumbs') == "Y") ? 'checked="checked"' : ''; ?> type="checkbox" name="croploopthumbs" value="Y" /> <?php _e('Crop to exact dimensions', $this -> plugin_name); ?></label>
                        <br/><small><?php _e('untick to resize rather than crop', $this -> plugin_name); ?></small>
					</div>
                    
                    <span class="howto"><?php _e('remember to click the "Update all thumbnails" link after changing these settings', $this -> plugin_name); ?></span> 
					*/ ?>
				</td>
			</tr>
			<tr>
				<th><label for=""><?php _e('Thumbnail Quality', $this -> plugin_name); ?></label></th>
				<td>
					<input type="text" class="widefat" style="width:45px;" name="loopthumbq" value="<?php echo attribute_escape($this -> get_option('loopthumbq')); ?>" /> &#37;
					<span class="howto"><?php _e('reduce quality to reduce filesize &amp; increase site performance', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for=""><?php _e('Short Search Results', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('shortsearchresults') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="shortsearchresults" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('shortsearchresults') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="shortsearchresults" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('Shows a product thumbnail and short description instead of full product page', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>