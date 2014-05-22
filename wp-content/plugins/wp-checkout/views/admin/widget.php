<p>
	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_title">
		<?php _e('Title', $this -> plugin_name); ?>:
		<input class="widefat" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_title" type="text" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][title]" value="<?php echo $options[$number]['title']; ?>" />
	</label>
</p>

<p>
	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_display">
		<?php _e('Display', $this -> plugin_name); ?>:<br/>
		<?php $displays = array('cart' => __('Shopping Cart', $this -> plugin_name), 'search' => __('Products Search Widget', $this -> plugin_name), 'categories' => __('Shop Categories', $this -> plugin_name), 'products' => __('Latest Products', $this -> plugin_name), 'suppliers' => __('Product Suppliers', $this -> plugin_name), 'remoteproducts' => __('Remote Products', $this -> plugin_name), 'prices' => __('Price Ranges Search', $this -> plugin_name), 'keywords' => __('Keywords Drop Down', $this -> plugin_name)); ?>
		<select onchange="wpcochangedisplay('<?php echo $number; ?>',this.value);" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_display" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][display]" class="widefat" style="width:auto;">
			<?php foreach ($displays as $dkey => $dval) : ?>
				<option <?php echo ($options[$number]['display'] == $dkey) ? 'selected="selected"' : ''; ?> value="<?php echo $dkey; ?>"><?php echo $dval; ?></option>
			<?php endforeach; ?>
		</select>
	</label>
</p>

<!-- Shopping Cart -->
<div id="displaycart<?php echo $number; ?>" style="display:<?php echo (empty($options[$number]['display']) || (!empty($options[$number]['display']) && $options[$number]['display'] == "cart")) ? 'block' : 'none'; ?>;">
	<p>
    	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_show_normal">
			<?php _e('Show', $this -> plugin_name); ?>:<br/>
            <label><input <?php echo ($options[$number]['show'] == "minimal") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][show]" value="minimal" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_show_minimal" /> <?php _e('Total Only', $this -> plugin_name); ?></label>
            <label><input <?php echo (empty($options[$number]['show']) || $options[$number]['show'] == "normal") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][show]" value="normal" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_show_normal" /> <?php _e('All Details', $this -> plugin_name); ?></label>        
        </label>
    </p>
    
    <p>
    	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_showproducts_N">
    		<?php _e('Products Summary:', $this -> plugin_name); ?><br/>
    		<label><input <?php echo ($options[$number]['showproducts'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][showproducts]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_showproducts_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
    		<label><input <?php echo (empty($options[$number]['showproducts']) || $options[$number]['showproducts'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][showproducts]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_showproducts_N" /> <?php _e('No', $this -> plugin_name); ?></label>
    	</label>
    </p>
    
    <p>
    	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_hide_when_empty">
        	<?php _e('Hide when empty:', $this -> plugin_name); ?><br/>
            <label><input <?php echo (!empty($options[$number]['hide_when_empty']) && $options[$number]['hide_when_empty'] == 1) ? 'checked="checked"' : ''; ?> type="checkbox" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][hide_when_empty]" value="1" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_hide_when_empty" /> <?php _e('Hide the widget when the shopping cart is empty', $this -> plugin_name); ?></label>
        </label>
    </p>
	<p>
    	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_enablecoupons">
			<?php _e('Enable Coupon Form', $this -> plugin_name); ?>:<br/>
            <label><input <?php echo ($options[$number]['enablecoupons'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][enablecoupons]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_enablecoupons_yes" /> <?php _e('Yes', $this -> plugin_name); ?></label>
            <label><input <?php echo (empty($options[$number]['enablecoupons']) || $options[$number]['enablecoupons'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][enablecoupons]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_enablecoupons_no" /> <?php _e('No', $this -> plugin_name); ?></label>        
        </label>
    </p>
</div>

<!-- Latest Products -->
<div id="displayproducts<?php echo $number; ?>" style="display:<?php echo (!empty($options[$number]['display']) && ($options[$number]['display'] == "products" || $options[$number]['display'] == "remoteproducts")) ? 'block' : 'none'; ?>;">
	<div id="remoteproducts<?php echo $number; ?>" style="display:<?php echo (!empty($options[$number]['display']) && $options[$number]['display'] == "remoteproducts") ? 'block' : 'none'; ?>;">
		<p>
			<label>
				<?php _e('Domain', $this -> plugin_name); ?>:<br/>
				<input type="text" class="widefat" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_domain" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][domain]" value="<?php echo $options[$number]['domain']; ?>" /><br/>
				<small><?php _e('a domain/host name starting with "http://"', $this -> plugin_name); ?></small>
			</label>
		</p>
		
		<p>
			<label>
				<?php _e('iFrame Height', $this -> plugin_name); ?>:<br/>
				<input style="width:45px;" type="text" class="widefat" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_domain" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][iframeheight]" value="<?php echo $options[$number]['iframeheight']; ?>" /> <?php _e('px', $this -> plugin_name); ?>
			</label>
		</p>
	</div>

	<p>
		<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_count">
			<?php _e('Number of Products', $this -> plugin_name); ?>:<br/>
			<input class="widefat" style="width:45px;" type="text" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][count]" value="<?php echo $options[$number]['count']; ?>" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_count" style="width:45px;" /> <?php _e('products', $this -> plugin_name); ?><br/>
			<small><?php _e('set to "0" or leave empty for all products', $this -> plugin_name); ?></small>
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_thumbs_Y">
			<?php _e('Show Thumbnails', $this -> plugin_name); ?>:<br/>
			<label><input <?php echo (empty($options[$number]['thumbs']) || $options[$number]['thumbs'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][thumbs]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_thumbs_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
			<label><input <?php echo ($options[$number]['thumbs'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][thumbs]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_thumbs_N" /> <?php _e('No', $this -> plugin_name); ?></label>
		</label>
	</p>
</div>

<!-- Shop Categories -->
<div id="displaycategories<?php echo $number; ?>" style="display:<?php echo (!empty($options[$number]['display']) && $options[$number]['display'] == "categories") ? 'block' : 'none'; ?>">
	<p>
		<?php _e('Show only main categories', $this -> plugin_name); ?>:
		<label><input <?php echo (!empty($options[$number]['maincategories']) && $options[$number]['maincategories'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][maincategories]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_maincategories_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
		<label><input <?php echo (!empty($options[$number]['maincategories']) && $options[$number]['maincategories'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][maincategories]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_maincategories_N" /> <?php _e('No', $this -> plugin_name); ?></label>
	</p>
	
	<p>
		<?php _e('Show product count', $this -> plugin_name); ?>:
		<label><input <?php echo (!empty($options[$number]['productcount']) && $options[$number]['productcount'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][productcount]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_productcount_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
		<label><input <?php echo (!empty($options[$number]['productcount']) && $options[$number]['productcount'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][productcount]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_productcount_N" /> <?php _e('No', $this -> plugin_name); ?></label>
	</p>
    
    <p>
    	<?php _e('Sorting of Categories:', $this -> plugin_name); ?><br/>
        <?php _e('By', $this -> plugin_name); ?>
        <select id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_categories_sortby" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][categories_sortby]">
        	<option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "order") ? 'selected="selected"' : ''; ?> value="order"><?php _e('Sort Order', $this -> plugin_name); ?></option>
        	<option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "title") ? 'selected="selected"' : ''; ?> value="title"><?php _e('Title/Name', $this -> plugin_name); ?></option>
            <option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "created") ? 'selected="selected"' : ''; ?> value="created"><?php _e('Created Date', $this -> plugin_name); ?></option>
            <option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "modified") ? 'selected="selected"' : ''; ?> value="modified"><?php _e('Modified Date', $this -> plugin_name); ?></option>
            <option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "parent_id") ? 'selected="selected"' : ''; ?> value="parent_id"><?php _e('Parent Category', $this -> plugin_name); ?></option>
            <option <?php echo (!empty($options[$number]['categories_sortby']) && $options[$number]['categories_sortby'] == "id") ? 'selected="selected"' : ''; ?> value="id"><?php _e('ID number', $this -> plugin_name); ?></option>
        </select>
        <select id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_categories_sort" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][categories_sort]">
        	<option <?php echo (!empty($options[$number]['categories_sort']) && $options[$number]['categories_sortby'] == "ASC") ? 'selected="selected"' : ''; ?> value="ASC"><?php _e('Ascending', $this -> plugin_name); ?></option>
            <option <?php echo (!empty($options[$number]['categories_sort']) && $options[$number]['categories_sortby'] == "DESC") ? 'selected="selected"' : ''; ?> value="DESC"><?php _e('Descending', $this -> plugin_name); ?></option>
        </select>
    </p>
</div>

<p>
	<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinkN">
		<?php _e('Link Below Widget', $this -> plugin_name); ?>:<br/>
		<label><input <?php echo (!empty($options[$number]['shlink']) && $options[$number]['shlink'] == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#shlink<?php echo $number; ?>div').show();" type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][shlink]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinkY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
		<label><input <?php echo (empty($options[$number]['shlink']) || $options[$number]['shlink'] == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#shlink<?php echo $number; ?>div').hide();" type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][shlink]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinkN" /> <?php _e('No', $this -> plugin_name); ?></label>
	</label>
</p>

<div id="dropdown<?php echo $number; ?>" style="display:<?php echo (!empty($options[$number]['display']) && ($options[$number]['display'] == "products" || $options[$number]['display'] == "categories" || $options[$number]['display'] == "suppliers")) ? 'block' : 'none'; ?>;">
	<p>
    	<?php _e('Show as Drop Down', $this -> plugin_name); ?>:<br/>
        <label><input <?php echo (!empty($options[$number]['dropdown']) || $options[$number]['dropdown'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][dropdown]" value="Y" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_dropdown_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
        <label><input <?php echo (empty($options[$number]['dropdown']) || $options[$number]['dropdown'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][dropdown]" value="N" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_dropdown_N" /> <?php _e('No', $this -> plugin_name); ?></label>
    </p>
</div>

<div id="shlink<?php echo $number; ?>div" style="display:<?php echo (!empty($options[$number]['shlink']) && $options[$number]['shlink'] == "Y") ? 'block' : 'none'; ?>;">
	<p>
		<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinktitle">
			<?php _e('Link Title/Text', $this -> plugin_name); ?>:<br/>
			<input type="text" class="widefat" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][shlinktitle]" value="<?php echo (empty($options[$number]['shlinktitle'])) ? __('More great products...', $this -> plugin_name) : $options[$number]['shlinktitle']; ?>" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinktitle" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinkurl">
			<?php _e('Link URL/Location', $this -> plugin_name); ?>:<br/>
			<input type="text" class="widefat" name="<?php echo $this -> pre; ?>-widget[<?php echo $number; ?>][shlinkurl]" value="<?php echo (empty($options[$number]['shlinkurl'])) ? $this -> get_option('shopurl') : $options[$number]['shlinkurl']; ?>" id="<?php echo $this -> pre; ?>_widget_<?php echo $number; ?>_shlinkurl" />
		</label>
	</p>
</div>