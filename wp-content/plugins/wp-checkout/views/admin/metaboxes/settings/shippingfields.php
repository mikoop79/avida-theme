<?php

$paymentfields = $this -> get_option('paymentfields');

?>

<div class="sortable-form-table-headings">
	<table id="shippingfields" class="form-table sortable-form-table">	
		<thead>
			<tr>
				<td class="wpco-checkbox-show" style="vertical-align:top; font-weight:bold;"><?php _e('Show', $this -> plugin_name); ?></td>
				<td class="wpco-checkbox-required" style="vertical-align:top; font-weight:bold;"><?php _e('Required', $this -> plugin_name); ?></td>
				<td style="font-weight:bold;"><?php _e('Field', $this -> plugin_name); ?></td>
				<td style="font-weight:bold;"><?php _e('Title/Caption', $this -> plugin_name); ?></td>
			</tr>
		</thead>
	</table>
</div>
<div class="sortable-elements">
	<?php foreach ($paymentfields['shipping'] as $paymentfield_key => $paymentfield) : ?>
		<?php if ($paymentfield_key != "email") : ?>
			<div class="sortable-form-table-element">
				<table>
					<tr>
						<td class="wpco-checkbox-show"><input <?php echo (!empty($paymentfields['shipping'][$paymentfield_key]['show'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentfields[shipping][<?php echo $paymentfield_key; ?>][show]" value="1" id="paymentfields_shipping_<?php echo $paymentfield_key; ?>_show" /></td>
						<td class="wpco-checkbox-required"><input <?php echo (!empty($paymentfields['shipping'][$paymentfield_key]['required'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentfields[shipping][<?php echo $paymentfield_key; ?>][required]" value="1" id="paymentfields_shipping_<?php echo $paymentfield_key; ?>_required" /></td>
						<td><?php echo $paymentfield['title']; ?></td>
						<td><input type="text" name="paymentfields[shipping][<?php echo $paymentfield_key; ?>][title]" value="<?php echo esc_attr(stripslashes($paymentfields['shipping'][$paymentfield_key]['title'])); ?>" id="paymentfields_shipping_<?php echo $paymentfield_key; ?>_title" /></td>
					</tr>
				</table>
			</div>	
		<?php else : ?>
			<div class="sortable-form-table-element">
				<table>
					<tr>
						<td class="wpco-checkbox-show">
							<input checked="checked" disabled="disabled" type="checkbox" name="" value="" id="paymentfields_shipping_email_show" />
							<input type="hidden" name="paymentfields[shipping][email][show]" value="1" />
							<input type="hidden" name="paymentfields[shipping][email][required]" value="1" />
						</td>
						<td class="wpco-checkbox-required"><input checked="checked" disabled="disabled" type="checkbox" name="" value="" id="paymentfields_shipping_email_required" /></td>
						<td><?php _e('Email Address', $this -> plugin_name); ?></td>
						<td><input type="text" name="paymentfields[shipping][email][title]" value="<?php echo esc_attr(stripslashes($paymentfields['shipping']['email']['title'])); ?>" id="paymentfields_shipping_email_title" /></td>
					</tr>
				</table>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
</div>


<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.sortable-elements').sortable({
		placeholder: "wpml-placeholder",
		tolerance: 'pointer',
		revert: 100,
		distance: 5
	});
});
</script>
