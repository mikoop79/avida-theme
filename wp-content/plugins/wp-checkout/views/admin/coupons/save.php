<div class="wrap">
	<h2><?php _e('Save a Coupon', $this -> plugin_name); ?></h2>
	
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('Coupon.id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Coupon.title"><?php _e('Title', $this -> plugin_name); ?></label>
					<?php echo $wpcoHtml -> help(__('Enter a title/name for this coupon for display and identification purposes. This title/name will be used in the back-end and front-end so both you and your customers will see the title when the coupon code is used.', $this -> plugin_name)); ?></th>
					<td>
						<?php echo $wpcoForm -> text('Coupon.title'); ?>
						<span class="howto"><?php _e('Title/name of the coupon code for display purposes.', $this -> plugin_name); ?></span>	
					</td>
				</tr>
			</tbody>
		</table>
		
		<?php do_action($this -> pre . '_coupon_save_after_title', $this -> plugin_name); ?>
		
		<div id="code_div" style="display:block;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Coupon.code"><?php _e('Code', $this -> plugin_name); ?></label>
						<?php echo $wpcoHtml -> help(__('Fill in or generate the coupon code to give to your customers which they will enter to apply the discount to their order.', $this -> plugin_name)); ?></th>
						<td>
							<span id="couponcodecol"><?php $this -> render('coupons' . DS . 'save-code'); ?></span>
							<span id="couponcodelink"><a class="button button-secondary" href="javascript:wpco_gencouponcode();" title="<?php _e('Generate a Coupon Code', $this -> plugin_name); ?>"><?php _e('Generate Code', $this -> plugin_name); ?></a></span>
							<span id="couponcodeloading" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" /></span>
							<span class="howto"><?php _e('Code entered by customers to apply discount.', $this -> plugin_name); ?></span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
					
		<table class="form-table">
			<tbody>
				<tr>
					<th><?php _e('Discount Type', $this -> plugin_name); ?>
					<?php echo $wpcoHtml -> help(__('Choose the type of discount to apply with this discount coupon. Fixed, percentage, etc.', $this -> plugin_name)); ?></th>
					<td>
						<?php $types = apply_filters($this -> pre . '_coupon_types', array('fixed' => __('Fixed Amount', $this -> plugin_name), 'percentage' => __('Percentage', $this -> plugin_name))); ?>
						<?php 
						
						$html = $wpcoForm -> radio('Coupon.discount_type', $types, array('separator' => false, 'default' => "fixed", 'onclick' => "cp_signs(this.value);"));
						echo apply_filters($this -> pre . '_coupon_save_discounttype', $html, $types); 
						
						?>
						
						<script type="text/javascript">
						function cp_signs(type) {						
							jQuery("[id$=sign]").hide();
							jQuery("#" + type + "_sign").show();
						}
						</script>
						<span class="howto"><?php _e('Choose the type of coupon code you want to create.', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="discount_div" style="display:block;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Coupon.discount"><?php _e('Discount Value', $this -> plugin_name); ?></label>
						<?php echo $wpcoHtml -> help(__('Fill in the discount value according to the discount type above. This will determine how the discount is calculated for this coupon.', $this -> plugin_name)); ?></th>
						<td>
							<span id="fixed_sign" style="display:<?php echo ($wpcoHtml -> field_value('Coupon.discount_type') == "fixed") ? 'inline' : 'none'; ?>;"><?php echo $wpcoHtml -> currency(); ?></span>
							<span id="percentage_sign" style="display:<?php echo ($wpcoHtml -> field_value('Coupon.discount_type') == "percentage") ? 'inline' : 'none'; ?>;">&#37;</span>
							<?php echo $wpcoForm -> text('Coupon.discount', array('width' => '45px')); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<?php do_action($this -> pre . '_coupon_save_after_discount'); ?>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="expiry"><?php _e('Expiry Date', $this -> plugin_name); ?></label>
					<?php echo $wpcoHtml -> help(__('Specify an expiry date in the format YYYY-MM-DD up until which this discount coupon will work. The discount coupon will work till the day specified and thereafter it will be inactive and unusable.', $this -> plugin_name)); ?></th>
					<td>
                        <input type="text" id="expiry" class="widefat" style="width:85px;" name="Coupon[expiry]" value="<?php echo esc_attr(stripslashes($wpcoHtml -> field_value('Coupon.expiry'))); ?>" />
                        <?php echo $wpcoHtml -> field_error('Coupon.expiry'); ?>
						<small>format : <b>YYYY-MM-DD</b></small>
						<span class="howto"><?php _e('Date of expiration, leave empty for no expiration.', $this -> plugin_name); ?></span>
                        
                        <script type="text/javascript">
						jQuery(document).ready(function(e) {
                            jQuery('#expiry').datepicker({dateFormat: 'yy-mm-dd'});
                        });
						</script>
					</td>
				</tr>
				<tr>
					<th><label for="Coupon.maxuse"><?php _e('Max Use Count', $this -> plugin_name); ?></label>
					<?php echo $wpcoHtml -> help(__('Specify how many times this coupon code may be used in total by all customers.', $this -> plugin_name)); ?></th>
					<td>
						<?php echo $wpcoForm -> text('Coupon.maxuse', array('width' => '45px')); ?>
						<span class="howto"><?php _e('Maximum times this coupon may be used. Leave empty or set to 0 for unlimited usage', $this -> plugin_name); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e('Active', $this -> plugin_name); ?>
					<?php echo $wpcoHtml -> help(__('Simply activate/deactivate this discount coupon according to your needs. If you do not want it to be used anymore, you can set this setting to No and customers will not be able to apply or use it.', $this -> plugin_name)); ?></th>
					<td>
						<?php $active = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Coupon.active', $active, array('separator' => false, 'default' => "Y")); ?>
					</td>
				</tr>
			</tbody>
		</table>
						
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Coupon', $this -> plugin_name)); ?>
		</p>
	</form>
</div>

<?php do_action($this -> pre . '_coupon_save_bottom', $Coupon -> data -> id); ?>