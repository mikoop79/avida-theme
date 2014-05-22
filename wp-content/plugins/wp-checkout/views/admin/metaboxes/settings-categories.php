<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="cattitleshowY"><?php _e('Show Category Title', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('cattitleshow') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="cattitleshow" id="cattitleshowY" value="Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('cattitleshow') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="cattitleshow" id="cattitleshowN" value="N" /> <?php _e('No', $this -> plugin_name); ?></label>
            </td>
        </tr>
		<tr>
			<th><label for="catimgshowN"><?php _e('Show Category Image', $this -> plugin_name); ?></label></th>
			<td>
				<label><input onclick="jQuery('#catimgshowdiv').show();" <?php echo ($this -> get_option('catimgshow') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="catimgshow" value="Y" id="catimgshowY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input onclick="jQuery('#catimgshowdiv').hide();" <?php echo ($this -> get_option('catimgshow') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="catimgshow" value="N" id="catimgshowN" /> <?php _e('No', $this -> plugin_name); ?></label>
				<span class="howto"><?php _e('if a category has an image, it will be displayed', $this -> plugin_name); ?></span>
			</td>
		</tr>
	</tbody>
</table>

<div id="catimgshowdiv" style="display:<?php echo ($this -> get_option('catimgshow') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><?php _e('Category Image Display', $this -> plugin_name); ?></th>
				<td>
					<label><input <?php echo ($this -> get_option('catimg') == "full") ? 'checked="checked"' : ''; ?> type="radio" name="catimg" value="full" /> <?php _e('Full Image', $this -> plugin_name); ?></label>
					<label><input <?php echo ($this -> get_option('catimg') == "thumb") ? 'checked="checked"' : ''; ?> type="radio" name="catimg" value="thumb" /> <?php _e('Thumbnail', $this -> plugin_name); ?></label>
					<span class="howto"><?php _e('Category image display on individual category pages.', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
    
    <div id="catimgthumb" style="display:<?php echo ($this -> get_option('catimg') == "thumb") ? 'block' : 'none'; ?>;">
    	<table class="form-table">
        	<tbody>
            	<tr>
                    <th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
                    <td>
                        <input class="widefat" style="width:40px;" type="text" name="catthumbw" value="<?php echo $this -> get_option('catthumbw'); ?>" />
                        <?php _e('by', $this -> plugin_name); ?>
                        <input class="widefat" style="width:40px;" type="text" name="catthumbh" value="<?php echo $this -> get_option('catthumbh'); ?>" />
                        <?php _e('px', $this -> plugin_name); ?>
                        <span class="howto"><?php _e('Dimensions of your categories images, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="catdescY"><?php _e('Show Description', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('catdesc') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="catdesc" value="Y" id="catdescY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('catdesc') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="catdesc" value="N" id="catdescN" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Should category description be shown on individual category pages?', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="catkwY"><?php _e('Show Keywords', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('catkw') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="catkw" value="Y" id="catkwY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('catkw') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="catkw" value="N" id="catkwN" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Should category keywords be shown on individual category pages?', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="showsubcatsY"><?php _e('Show sub-categories on category pages', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input onclick="jQuery('#showsubcatsdiv').show();" <?php echo ($this -> get_option('showsubcats') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="showsubcats" value="Y" id="showsubcatsY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                <label><input onclick="jQuery('#showsubcatsdiv').hide();" <?php echo ($this -> get_option('showsubcats') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="showsubcats" value="N" id="showsubcatsN" /> <?php _e('No', $this -> plugin_name); ?></label>
                <span class="howto"><?php _e('Should sub-categories be shown on individual category pages?', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>

<div id="showsubcatsdiv" style="display:<?php echo ($this -> get_option('showsubcats') == "Y") ? 'block' : 'none'; ?>;">
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="subcatheadingY"><?php _e('"Sub Categories" Heading', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input <?php echo ($this -> get_option('subcatheading') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="subcatheading" value="Y" id="subcatheadingY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input <?php echo ($this -> get_option('subcatheading') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="subcatheading" value="N" id="subcatheadingN" /> <?php _e('No', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('Simply shows a "Sub Categories" heading above the sub-categories', $this -> plugin_name); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="subcatdisplay_list"><?php _e('Sub Categories Display', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input onclick="jQuery('#subcatdisplaygrid').hide();" <?php echo ($this -> get_option('subcatdisplay') == "list") ? 'checked="checked"' : ''; ?> type="radio" name="subcatdisplay" value="list" id="subcatdisplay_list" /> <?php _e('List', $this -> plugin_name); ?></label>
                    <label><input onclick="jQuery('#subcatdisplaygrid').show();" <?php echo ($this -> get_option('subcatdisplay') == "grid") ? 'checked="checked"' : ''; ?> type="radio" name="subcatdisplay" value="grid" id="subcatdisplay_grid" /> <?php _e('Grid', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('Requires category images to display correctly when using "Grid".', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="subcatdisplaygrid" style="display:<?php echo ($this -> get_option('subcatdisplay') == "grid") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></th>
                    <td>
                        <input class="widefat" style="width:40px;" type="text" name="scatthumbw" value="<?php echo $this -> get_option('scatthumbw'); ?>" />
                        <?php _e('by', $this -> plugin_name); ?>
                        <input class="widefat" style="width:40px;" type="text" name="scatthumbh" value="<?php echo $this -> get_option('scatthumbh'); ?>" />
                        <?php _e('px', $this -> plugin_name); ?>
                        <span class="howto"><?php _e('Dimensions of your category images in the grid, you may leave either the width or height empty to crop accordingly.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>