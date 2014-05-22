<h4><?php _e('Variation Options', $this -> plugin_name); ?></h4>

<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="variations_optionlabel_Y"><?php _e('Thumbnail Label/Caption', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php echo ($this -> get_option('variations_optionlabel') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="variations_optionlabel" value="Y" id="variations_optionlabel_Y" /> <?php _e('Show', $this -> plugin_name); ?></label>
                <label><input <?php echo ($this -> get_option('variations_optionlabel') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="variations_optionlabel" value="N" id="variations_optionlabel_N" /> <?php _e('Hide', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Should the label/caption be shown when a thumbnail is used on radio/checkbox variation options?', $this -> plugin_name); ?></span>
            </td>
        </tr>
    	<tr>
        	<th><label for="variations_optionthumbzoom_Y"><?php _e('Thumbnail Zoom Effect', $this -> plugin_name); ?></label></th>
            <td>
            	<label><input <?php if ($this -> is_plugin_active('jqzoom')) : ?><?php echo ($this -> get_option('variations_optionthumbzoom') == "Y") ? 'checked="checked"' : ''; ?><?php else : ?>disabled="disabled"<?php endif; ?> type="radio" name="variations_optionthumbzoom" value="Y" id="variations_optionthumbzoom_Y" /> <?php _e('Enable', $this -> plugin_name); ?></label>
                <label><input <?php if ($this -> is_plugin_active('jqzoom')) : ?><?php echo ($this -> get_option('variations_optionthumbzoom') == "N") ? 'checked="checked"' : ''; ?><?php else : ?>checked="checked"<?php endif; ?> type="radio" name="variations_optionthumbzoom" value="N" id="variations_optionthumbzoom_N" /> <?php _e('Disable', $this -> plugin_name); ?></label>
            	<span class="howto"><?php _e('Turn this on to make variation option thumbnails zoomable.', $this -> plugin_name); ?></span>
                
                <?php if (!$this -> is_plugin_active('jqzoom')) : ?>
                	<div class="<?php echo $this -> pre; ?>error"><?php _e('In order to use the Zoom Effect, you must install and activate the Shopping Cart plugin jQZoom extension plugin.', $this -> plugin_name); ?></div>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
        	<th><label for="variations_optionthumbw"><?php _e('Thumbnail Dimensions', $this -> plugin_name); ?></label></th>
            <td>
            	<input type="text" class="widefat" style="width:45px;" name="variations_optionthumbw" value="<?php echo esc_attr(stripslashes($this -> get_option('variations_optionthumbw'))); ?>" id="variations_optionthumbw" />
                <?php _e('by', $this -> plugin_name); ?>
                <input type="text" class="widefat" style="width:45px;" name="variations_optionthumbh" value="<?php echo esc_attr(stripslashes($this -> get_option('variations_optionthumbh'))); ?>" id="variations_optionthumbh" /> <?php _e('px', $this -> plugin_name); ?>
            	<span class="howto"><?php _e('Width and height of variation options thumbnail images.', $this -> plugin_name); ?></span>
            </td>
        </tr>
    </tbody>
</table>