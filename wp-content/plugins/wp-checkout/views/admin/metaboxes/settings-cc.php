<p><?php _e('When an order is processed, the last four(4) digits of the card will be in the order email while the first few digits will be shown in the "Orders" section when an order is viewed.', $this -> plugin_name); ?></p>
								
<table class="form-table">
	<tbody>
		<tr>
			<th><label for="billcvvY"><?php _e('Request CVV', $this -> plugin_name); ?></label></th>
			<td>
				<label><input <?php echo ($this -> get_option('billcvv') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="billcvv" value="Y" id="billcvvY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
				<label><input <?php echo ($this -> get_option('billcvv') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="billcvv" value="N" id="billcvvN" /> <?php _e('No', $this -> plugin_name); ?></label>
				
				<span class="howto"><?php _e('set to "Yes" to ask customers for their security code (CVV)', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="cctypes_selectall"><?php _e('Accepted Credit Cards', $this -> plugin_name); ?></label></th>
            <td>
            	<?php if ($cctypes = $this -> get_option('cctypes')) : ?>
                	<?php $cctypes_accepted = $this -> get_option('cctypes_accepted'); ?>
                    <label><input type="checkbox" name="cctypes_selectall" value="1" id="cctypes_selectall" onclick="jqCheckAll(this, '<?php echo $this -> sections -> settings; ?>', 'cctypes_accepted');" /> <strong><?php _e('Select All', $this -> plugin_name); ?></strong></label><br/>
                    <?php foreach ($cctypes as $cctype_key => $cctype_val) : ?>
                    	<label><input <?php echo (!empty($cctypes_accepted) && in_array($cctype_key, $cctypes_accepted)) ? 'checked="checked"' : ''; ?> type="checkbox" name="cctypes_accepted[]" value="<?php echo $cctype_key; ?>" id="cctypes_accepted_<?php echo $cctype_key; ?>" /> <?php echo $cctype_val; ?></label><br/>
                    <?php endforeach; ?>
                <?php endif; ?>
            	<span class="howto"><?php _e('tick/select the credit cards you accept which should be available to customers.', $this -> plugin_name); ?></span>
            </td>
        </tr>
	</tbody>
</table>