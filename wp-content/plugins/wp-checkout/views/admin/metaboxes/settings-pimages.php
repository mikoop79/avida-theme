<table class="form-table">
	<tbody>
		<tr>
			<th><label for="gallerytabY"><?php _e('"Gallery" Content Tab', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo (!$this -> get_option('gallerytab') || $this -> get_option('gallerytab') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="gallerytab" value="Y" id="gallerytabY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('gallerytab') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="gallerytab" value="N" id="gallerytabN" /> <?php _e('No', $this -> plugin_name); ?></label>
				
				<span class="howto"><?php _e('will display extra product images in a tab if content tabs are available', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
			<td>
				<input class="widefat" style="width:40px;" type="text" name="ithumbw" value="<?php echo $this -> get_option('ithumbw'); ?>" />
				<?php _e('by', $this -> plugin_name); ?>
				<input class="widefat" style="width:40px;" type="text" name="ithumbh" value="<?php echo $this -> get_option('ithumbh'); ?>" />
				<?php _e('px', $this -> plugin_name); ?>
				<span class="howto"><?php _e('Dimensions of your extra images, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>
                <?php /*
				<div>
					<label><input <?php echo ($this -> get_option('cropithumbs') == "Y") ? 'checked="checked"' : ''; ?> type="checkbox" name="cropithumbs" value="Y" /> <?php _e('Crop to exact dimensions', $this -> plugin_name); ?></label>
				</div>
				*/ ?>
			</td>
		</tr>
		<tr>
			<th><label for="<?php echo $this -> pre; ?>pimgcount"><?php _e('Number of thumbs on product pages', $this -> plugin_name); ?></label></th>
			<td><input class="widefat" id="<?php echo $this -> pre; ?>pimgcount" type="text" style="width:45px;" name="pimgcount" value="<?php echo $this -> get_option('pimgcount'); ?>" /></td>
		</tr>
	</tbody>
</table>