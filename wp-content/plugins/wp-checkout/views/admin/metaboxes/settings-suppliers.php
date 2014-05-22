<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="supimg_full"><?php _e('Supplier Image Display', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input onclick="jQuery('#supimgthumbdiv').hide();" <?php echo ($this -> get_option('supimg') == "full") ? 'checked="checked"' : ''; ?> type="radio" name="supimg" value="full" id="supimg_full" /> <?php _e('Full/Original Image', $this -> plugin_name); ?></label>
                <label><input onclick="jQuery('#supimgthumbdiv').show();" <?php echo ($this -> get_option('supimg') == "thumb") ? 'checked="checked"' : ''; ?> type="radio" name="supimg" value="thumb" id="supimg_thumb" /> <?php _e('Thumbnail Image', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('How should supplier images be displayed on product- and supplier pages?', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<div id="supimgthumbdiv" style="display:<?php echo ($this -> get_option('supimg') == "thumb") ? 'block' : 'none'; ?>;">
	<table class="form-table">
    	<tbody>
        	<tr>
                <th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
                <td>
                    <input class="widefat" style="width:40px;" type="text" name="supthumbw" value="<?php echo $this -> get_option('supthumbw'); ?>" />
                    <?php _e('by', $this -> plugin_name); ?>
                    <input class="widefat" style="width:40px;" type="text" name="supthumbh" value="<?php echo $this -> get_option('supthumbh'); ?>" />
                    <?php _e('px', $this -> plugin_name); ?>
                    <span class="howto"><?php _e('Dimensions of your supplier images, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>                
                </td>
            </tr>
        </tbody>
    </table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="supplierpagesY"><?php _e('Create WP posts/pages', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('supplierpages') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="supplierpages" value="Y" id="supplierpagesY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('supplierpages') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="supplierpages" value="N" id="supplierpagesN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('create a post/page for each of your suppliers which will list the products', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="hidesuppliers_Y"><?php _e('Hide suppliers from customers', $this -> plugin_name); ?></th>
			<td>
				<label><input <?php echo ($this -> get_option('hidesuppliers') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="hidesuppliers" value="Y" id="hidesuppliers_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('hidesuppliers') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="hidesuppliers" value="N" id="hidesuppliers_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Should suppliers be hidden on the shop front?', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="supplierlogin_Y"><?php _e('Supplier Login', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input onclick="jQuery('#supplierlogin_div').show();" <?php echo ($this -> get_option('supplierlogin') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="supplierlogin" value="Y" id="supplierlogin_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input onclick="jQuery('#supplierlogin_div').hide();" <?php echo ($this -> get_option('supplierlogin') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="supplierlogin" value="N" id="supplierlogin_N" /> <?php _e('No', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Allow suppliers to login and manage their own products in the Products section.', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>

<div id="supplierlogin_div" style="<?php echo ($this -> get_option('supplierlogin') == "Y") ? 'block' : 'none'; ?>">
	<table class="form-table">
    	<tbody>
        	<tr>
            	<th><label for="suppliercategories_N"><?php _e('Category Add/Delete', $this -> plugin_name); ?></label></th>
                <td>
                	<label><input type="radio" <?php echo ($this -> get_option('suppliercategories') == "Y") ? 'checked="checked"' : ''; ?> name="suppliercategories" value="Y" id="suppliercategories_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input type="radio" <?php echo ($this -> get_option('suppliercategories') == "N") ? 'checked="checked"' : ''; ?> name="suppliercategories" value="N" id="suppliercategories_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                	<span class="howto"><?php _e('Allow suppliers to add/delete their own shop categories in the system', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>