<table class="form-table">
	<tbody>
		<tr>
			<th><label for="Product.supplier_id"><?php _e('Supplier', $this -> plugin_name); ?></label></th>
			<td>
            	<?php if ($supplier = $this -> is_supplier()) : ?>
                	<strong><?php echo $supplier -> name; ?></strong>
                    <?php echo $wpcoForm -> hidden('Product.supplier_id', array('value' => $supplier -> id)); ?>
                    <?php echo $wpcoForm -> hidden('Product.user_id', array('value' => $supplier -> user_id)); ?>
                <?php else : ?>
                    <div id="suppliers-div">
                        <?php $this -> render('suppliers' . DS . 'product-suppliers', array('supplier_id' => $Product -> data -> supplier_id), true, 'admin'); ?>
                        <?php echo $wpcoForm -> hidden('Product.user_id'); ?>
                    </div>
                <?php endif; ?>
			</td>
		</tr>
		<tr>
			<th><label for="Product.affiliateN"><?php _e('Affiliate/External Product', $this -> plugin_name); ?></label></th>
			<td>
				<?php $affiliate = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
				<?php echo $wpcoForm -> radio('Product.affiliate', $affiliate, array('separator' => false, 'default' => "N", 'onclick' => "change_affiliate(this.value);")); ?>
				<span class="howto"><?php _e('use this feature to put an external product on your site which will redirect.', $this -> plugin_name); ?></span>
				
				<script type="text/javascript">
				function change_affiliate(affiliate) {
					if (affiliate == "Y") {
						jQuery('#affiliatediv').show();
					} else {
						jQuery('#affiliatediv').hide();
					}
				}
				</script>
			</td>
		</tr>
	</tbody>
</table>

<div id="affiliatediv" style="display:<?php echo ($wpcoHtml -> field_value('Product.affiliate') == "Y") ? 'block' : 'none'; ?>;">
	<table class="form-table">
		<tbody>
			<tr>
				<th><label for="Product.affiliateurl"><?php _e('Referral URL', $this -> plugin_name); ?></label></th>
				<td>
					<?php echo $wpcoForm -> text('Product.affiliateurl'); ?>
					<span class="howto"><?php _e('when the "Add to Basket" button is clicked, the page will redirect to this URL', $this -> plugin_name); ?></span>
				</td>
			</tr>
			<tr>
				<th><label for="Product.affiliatewindow"><?php _e('Target Window', $this -> plugin_name); ?></label></th>
				<td>
					<?php $target = array('self' => __('Same Window', $this -> plugin_name), 'blank' => __('New Window', $this -> plugin_name)); ?>
					<?php echo $wpcoForm -> radio('Product.affiliatewindow', $target, array('separator' => false, 'default' => 'blank')); ?>
					<span class="howto"><?php _e('specify how the affiliate product should be opened', $this -> plugin_name); ?></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="form-table">
	<tbody>
		<tr>
			<th><label for="Product.measurement"><?php _e('Measurement', $this -> plugin_name); ?></label></th>
			<td>
				<?php echo $wpcoForm -> text('Product.measurement', array('width' => "150px")); ?>
				<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('eg. Unit(s), Bottle(s), Box(es), Bag(s), Liter(s)', $this -> plugin_name); ?></span>
			</td>
		</tr>
        <tr>
        	<th><label for="Product.buttontext"><?php _e('Button Text', $this -> plugin_name); ?></label></th>
            <td>
            	<?php $btnlnktext = (!empty($Product -> data -> buttontext)) ? $Product -> data -> buttontext : $this -> get_option('loop_btnlnktext'); ?>
            	<?php echo $wpcoForm -> text('Product.buttontext', array('value' => $btnlnktext)); ?>
            	<span class="howto"><?php _e('Caption/title on the button for this product throughout the site.', $this -> plugin_name); ?></span>
            </td>
        </tr>
		<tr>
			<th><label for="Product.min_order"><?php _e('Minimum Order', $this -> plugin_name); ?></label></th>
			<td>
				<?php echo $wpcoForm -> text('Product.min_order', array('width' => '50px')); ?>
				<span class="howto"><?php _e('Leave empty for no minimum order.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="Product.inventory"><?php _e('Inventory/Stock', $this -> plugin_name); ?></label></th>
			<td>
				<?php $value = (!empty($Product -> data -> inventory) || $Product -> data -> inventory == "0") ? $Product -> data -> inventory : "-1"; ?>
				<?php echo $wpcoForm -> text('Product.inventory', array('width' => '50px', 'value' => $value)); ?> <?php _e('units', $this -> plugin_name); ?>
				<span class="howto">
					<?php _e('Set to <b>-1</b> for unlimited/infinite stock count.', $this -> plugin_name); ?><br/>
					<?php _e('Do not use this stock count if you are setting inventory/stock on variation options.', $this -> plugin_name); ?>
				</span>
			</td>
		</tr>
		<tr>
			<th><label for="Product.keywords"><?php _e('Keywords/Tags', $this -> plugin_name); ?></label></th>
			<td>
				<?php echo $wpcoForm -> text('Product.keywords'); ?>
				<span class="howto"><?php _e('Separate keywords with commas EG. my,great,product,keywords. These are saved as post/page tags as well.', $this -> plugin_name); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="Product.code"><?php _e('Code/SKU', $this -> plugin_name); ?></label></th>
			<td>
				<?php echo $wpcoForm -> text('Product.code'); ?>
				<span class="howto"><small><?php _e('(optional)', $this -> plugin_name); ?></small> <?php _e('For example the product code given by the supplier'); ?></span>
			</td>
		</tr>
	</tbody>
</table>