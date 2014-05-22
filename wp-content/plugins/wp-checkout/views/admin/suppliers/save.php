<div class="wrap <?php echo $this -> pre; ?>">
	<h2><?php _e('Save Supplier', $this -> plugin_name); ?></h2>	
	<form action="<?php echo $this -> url; ?>&amp;method=save" id="supplierform" method="post" enctype="multipart/form-data">
		<?php echo $wpcoForm -> hidden('Supplier.id'); ?>
		<?php echo $wpcoForm -> hidden('Supplier.post_id'); ?>
        <?php echo $wpcoForm -> hidden('Supplier.user_id'); ?>
	
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Supplier.name"><?php _e('Name', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('Supplier.name'); ?></td>
				</tr>
                <tr>
                	<th><label for="Supplier.createlogin_N"><?php _e('Create Login Account', $this -> plugin_name); ?></label>
                	<?php echo $wpcoHtml -> help(__('Create an account with Supplier role for this supplier to login with and manage products. Remember to give suppliers permissions to specific sections under Checkout > Configuration with the Supplier role.', $this -> plugin_name)); ?></th>
                    <td>
                    	<label><input <?php echo (!empty($Supplier -> data -> user_id) || (!empty($Supplier -> data -> createlogin) && $Supplier -> data -> createlogin == "Y")) ? 'checked="checked"' : ''; ?> onclick="jQuery('#logindiv').show();" type="radio" name="Supplier[createlogin]" value="Y" id="Supplier.createlogin_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                        <label><input <?php echo (empty($Supplier -> data -> user_id) && (empty($Supplier -> data -> createlogin) || $Supplier -> data -> createlogin == "N")) ? 'checked="checked"' : ''; ?> onclick="jQuery('#logindiv').hide();" type="radio" name="Supplier[createlogin]" value="N" id="Supplier.createlogin_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                    	<span class="howto"><?php _e('Create a WordPress account for this supplier to login and manage its own products in the Products section.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div id="logindiv" style="display:<?php echo (!empty($Supplier -> data -> user_id) || (!empty($Supplier -> data -> createlogin) && $Supplier -> data -> createlogin == "Y")) ? 'block' : 'none'; ?>;">        
        	<table class="form-table">
            	<tbody>
                	<tr>
                        <th><label for="Supplier.username"><?php _e('Username', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php $disabled = (!empty($Supplier -> data -> user_id) && $userdata = get_userdata($Supplier -> data -> user_id)) ? true : false; ?>
							<?php echo $wpcoForm -> text('Supplier.username', array('disabled' => $disabled)); ?>
                            <span class="howto"><?php _e('WordPress username to register.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for="Supplier.wpemail"><?php _e('Email Address', $this -> plugin_name); ?></label></th>
                        <td>
                        	<?php echo $wpcoForm -> text('Supplier.wpemail'); ?>
                        	<span class="howto"><?php _e('WordPress email address to register.', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                    <tr>
                    	<th><label for=""><?php _e('Auto Approve', $this -> plugin_name); ?></label>
                    	<?php echo $wpcoHtml -> help(__('Set this to "Yes" to automatically approve and published new products created by this supplier. If you prefer to review and approve all products manually, set this to "No".', $this -> plugin_name)); ?></th>
                    	<td>
                    		<?php $autoapprove = array('Y' => __('Yes', $this -> plugin_name), 'N' => __('No', $this -> plugin_name)); ?>
                    		<?php echo $wpcoForm -> radio('Supplier.autoapprove', $autoapprove, array('default' => "N", 'separator' => false)); ?>
                    		<span class="howto"><?php _e('Choose to auto approve new products created by the supplier or review products and approve them manually.', $this -> plugin_name); ?></span>
                    	</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <table class="form-table">
				<tr>
					<th><label for="Supplier.imageN"><?php _e('Supplier Logo', $this -> plugin_name); ?></label></th>
					<td>
						<?php $image = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Supplier.image', $image, array('separator' => false, 'default' => "N", 'onclick' => "change_imageopt(this.value);")); ?>
						<span class="howto"><?php _e('upload an image for this supplier', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="imagediv" style="display:<?php echo ($wpcoHtml -> field_value('Supplier.image') == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Supplier.imagefile"><?php _e('Image File', $this -> plugin_name); ?></label></th>
						<td>
							<?php if (empty($Supplier -> errors['imagefile']) && !empty($Supplier -> data -> imagefile -> name)) : ?>
								<span class="howto">
									<?php _e('Current Image', $this -> plugin_name); ?><br/>
									<?php _e('Leave field empty for no changes', $this -> plugin_name); ?>
								</span>
								
								<?php $imageinfo = $wpcoHtml -> image_pathinfo($Supplier -> data -> imagefile -> name); ?>
								<p><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($Supplier -> data -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($Supplier -> data -> imagefile -> name, 'suppliers'), array('class' => 'colorbox', 'title' => $Supplier -> data -> name)); ?></p>
								<?php echo $wpcoForm -> hidden('Supplier.oldimage', array('value' => $Supplier -> data -> imagefile -> name)); ?>
								<?php flush(); ?>
							<?php endif; ?>
						
							<?php echo $wpcoForm -> file('Supplier.imagefile', $this -> plugin_name); ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Supplier.notifyN"><?php _e('Order Notification', $this -> plugin_name); ?></label></th>
					<td>
						<?php $buttons = array("Y" => __('Yes', $this -> plugin_name), "N" => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Supplier.notify', $buttons, array('separator' => false, 'default' => "N", 'onclick' => "if (this.value == 'Y') { jQuery('#notifydiv').show(); } else { jQuery('#notifydiv').hide(); }")); ?>
						<span class="howto"><?php _e('send the supplier an email with the order details', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="notifydiv" style="display:<?php echo ($wpcoHtml -> field_value('Supplier.notify') == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Supplier.email"><?php _e('Email Address', $this -> plugin_name); ?></label></th>
						<td>
							<?php echo $wpcoForm -> text('Supplier.email'); ?>
                            <span class="howto"><?php _e('Valid email address to send order notifications to.', $this -> plugin_name); ?></span>
                        </td>
					</tr>
				</tbody>
			</table>
		</div>

		<?php if ($wpcoHtml -> field_value('Supplier.post_id') != "0" && $post = get_post($wpcoHtml -> field_value('Supplier.post_id'))) : ?>		
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for=""><?php _e('Post/Page', $this -> plugin_name); ?></label></th>
						<td>
							<span class="howto"><a target="_blank" href="<?php echo get_permalink($post -> ID); ?>" title="<?php echo $post -> post_title; ?>"><?php echo $post -> post_title; ?></a></span>
							
							<?php $deletepage = array("Y" => __('Yes, delete', $this -> plugin_name), "N" => __('No, dont delete', $this -> plugin_name)); ?>
							<?php echo $wpcoForm -> radio('Supplier.deletepage', $deletepage, array('separator' => false, 'default' => "N")); ?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php endif; ?>
        
		<?php if ($this -> get_option('post_type') == "page") : ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="Supplier.page_template"><?php _e('Page Template', $this -> plugin_name); ?></label></th>
                        <td>
                            <?php $default_suppliers_pagetemplate = $this -> get_option('suppliers_pagetemplate'); ?>
                            <?php $current_suppliers_pagetemplate = $wpcoHtml -> field_value('Supplier.page_template'); ?>
                            <?php $suppliers_pagetemplate = (empty($current_suppliers_pagetemplate)) ? $default_suppliers_pagetemplate : $current_suppliers_pagetemplate; ?>
                            <select <?php echo (($this -> get_option('supplierpages') == "Y")) ? '' : 'disabled="disabled"'; ?> name="Supplier[page_template]" id="Supplier.page_template">
                                <option value=""><?php _e('Default Template', $this -> plugin_name); ?></option>
                                <?php page_template_dropdown($suppliers_pagetemplate); ?>
                            </select>
                            <?php if ($this -> get_option('supplierpages') == "N") : ?>
                            	<p class="error"><?php _e('Supplier pages is turned off in the Configuration, turn it on to enable this feature.', $this -> plugin_name); ?></p>
                            <?php endif; ?>
                            <span class="howto"><?php _e('template of WordPress page which is saved', $this -> plugin_name); ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
		
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Supplier', $this -> plugin_name)); ?>
		</p>
	</form>
</div>

<script type="text/javascript">						
function change_imageopt(imageopt) {
	if (imageopt == "Y") {
		jQuery('#imagediv').show();
		jQuery('#supplierform').attr('enctype', 'multipart/form-data');
	} else {
		jQuery('#imagediv').hide();
		jQuery('#supplierform').removeAttr('enctype');
	}
}

<?php if ($wpcoHtml -> field_value('image') == "Y") : ?>
	change_imageopt("Y");
<?php endif; ?>
</script>