<?php

$paymentfields = $this -> get_option('paymentfields');

?>

<div class="sortable-form-table-headings">
	<table id="billingfields" class="form-table sortable-form-table">	
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
	<?php foreach ($paymentfields['billing'] as $paymentfield_key => $paymentfield) : ?>
		<?php if ($paymentfield_key != "email") : ?>
			<div class="sortable-form-table-element">
				<table>
					<tr>
						<td class="wpco-checkbox-show"><input <?php echo (!empty($paymentfields['billing'][$paymentfield_key]['show'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentfields[billing][<?php echo $paymentfield_key; ?>][show]" value="1" id="paymentfields_billing_<?php echo $paymentfield_key; ?>_show" /></td>
						<td class="wpco-checkbox-required"><input <?php echo (!empty($paymentfields['billing'][$paymentfield_key]['required'])) ? 'checked="checked"' : ''; ?> type="checkbox" name="paymentfields[billing][<?php echo $paymentfield_key; ?>][required]" value="1" id="paymentfields_billing_<?php echo $paymentfield_key; ?>_required" /></td>
						<td><?php echo $paymentfield['title']; ?></td>
						<td><input type="text" name="paymentfields[billing][<?php echo $paymentfield_key; ?>][title]" value="<?php echo esc_attr(stripslashes($paymentfields['billing'][$paymentfield_key]['title'])); ?>" id="paymentfields_billing_<?php echo $paymentfield_key; ?>_title" /></td>
					</tr>
				</table>
			</div>	
		<?php else : ?>
			<div class="sortable-form-table-element">
				<table>
					<tr>
						<td class="wpco-checkbox-show">
							<input checked="checked" disabled="disabled" type="checkbox" name="" value="" id="paymentfields_billing_email_show" />
							<input type="hidden" name="paymentfields[billing][email][show]" value="1" />
							<input type="hidden" name="paymentfields[billing][email][required]" value="1" />
						</td>
						<td class="wpco-checkbox-required"><input checked="checked" disabled="disabled" type="checkbox" name="" value="" id="paymentfields_billing_email_required" /></td>
						<td><?php _e('Email Address', $this -> plugin_name); ?></td>
						<td><input type="text" name="paymentfields[billing][email][title]" value="<?php echo esc_attr(stripslashes($paymentfields['billing']['email']['title'])); ?>" id="paymentfields_billing_email_title" /></td>
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
