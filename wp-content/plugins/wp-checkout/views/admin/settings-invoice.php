<div class="wrap wpco">
	<h2><?php _e('Purchase Invoice Settings', $this -> plugin_name); ?></h2>
    
    <?php $this -> render('settings-navigation', false, true, 'admin'); ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        <table class="form-table">
            <tbody>
            	<tr>
                	<th><label for="invoice_enabled_Y"><?php _e('Enable Invoices', $this -> plugin_name); ?></label></th>
                    <td>
                    	<label><input <?php echo ($this -> get_option('invoice_enabled') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_enabled" value="Y" id="invoice_enabled_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('invoice_enabled') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_enabled" value="N" id="invoice_enabled_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                    	<span class="howto"><?php _e('turning this on will enable invoices to customers via email and PDF in the orders history section.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_enablepdf_Y"><?php _e('Enable "Save PDF" Feature', $this -> plugin_name); ?></label></th>
                	<td>
                		<label><input <?php echo ($this -> get_option('invoice_enablepdf') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_enablepdf" value="Y" id="invoice_enablepdf_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                		<label><input <?php echo ($this -> get_option('invoice_enablepdf') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_enablepdf" value="N" id="invoice_enablepdf_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                		<span class="howto"><?php _e('Allow the saving of PDF receipts from invoices.', $this -> plugin_name); ?></span>
                	</td>
                </tr>
                <tr>
                	<th><label for="invoice_pdfshowfields_N"><?php _e('Show Custom Fields/Variations on PDF Invoice', $this -> plugin_name); ?></label></th>
                    <td>
                    	<label><input <?php echo ($this -> get_option('invoice_pdfshowfields') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_pdfshowfields" value="Y" id="invoice_pdfshowfields_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('invoice_pdfshowfields') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_pdfshowfields" value="N" id="invoice_pdfshowfields_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                    	<span class="howto"><?php _e('Turn this off if you are experiencing problems with PDF invoices.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_paidstatus_Y"><?php _e('Paid Status', $this -> plugin_name); ?></label></th>
                    <td>
                    	<label><input <?php echo ($this -> get_option('invoice_paidstatus') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_paidstatus" value="Y" id="invoice_paidstatus_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('invoice_paidstatus') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_paidstatus" value="N" id="invoice_paidstatus_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                        <span class="howto"><?php _e('Should the paid status of an order be shown on the invoice?', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_productcode_N"><?php _e('Product Code/SKU', $this -> plugin_name); ?></label></th>
                    <td>
                    	<label><input <?php echo ($this -> get_option('invoice_productcode') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_productcode" value="Y" id="invoice_productcode_Y" /> <?php _e('On', $this -> plugin_name); ?></label>
                        <label><input <?php echo ($this -> get_option('invoice_productcode') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_productcode" value="N" id="invoice_productcode_N" /> <?php _e('Off', $this -> plugin_name); ?></label>
                    	<span class="howto"><?php _e('Turn this on to show the product code/SKU on the invoice.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="invoice_companyname"><?php _e('Company Name', $this -> plugin_name); ?></label></th>
                    <td>
                        <input type="text" class="widefat" name="invoice_companyname" value="<?php echo esc_attr(stripslashes($this -> get_option('invoice_companyname'))); ?>" id="invoice_companyname" />
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_logotype_text"><?php _e('Logo or Name', $this -> plugin_name); ?></label></th>
                    <td>
                    	<label><input onclick="jQuery('#logotypeimagediv').show();" <?php echo ($this -> get_option('invoice_logotype') == "image") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_logotype" value="image" id="invoice_logotype_image" /> <?php _e('Logo', $this -> plugin_name); ?></label>
                        <label><input onclick="jQuery('#logotypeimagediv').hide();" <?php echo ($this -> get_option('invoice_logotype') == "text") ? 'checked="checked"' : ''; ?> type="radio" name="invoice_logotype" value="text" id="invoice_logotype_text" /> <?php _e('Business Name', $this -> plugin_name); ?></label>
                        <span class="howto"><?php _e('choose whether you want to upload a logo file or just show your business/company name.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div id="logotypeimagediv" style="display: <?php echo ($this -> get_option('invoice_logotype') == "image") ? 'block' : 'none'; ?>;">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="invoice_companylogo"><?php _e('Company Logo', $this -> plugin_name); ?></label></th>
                        <td>
                            <input type="file" class="widefat" style="width:auto;" name="invoice_companylogo" id="invoice_companylogo" />
                            
                            <?php if ($logo = $this -> get_option('invoice_companylogo')) : ?>
                                <p><img src="<?php echo WP_CONTENT_URL . '/uploads/' . basename($this -> get_option('invoice_companylogo')); ?>" alt="logo" /></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
                
        <table class="form-table">
        	<tbody>
                <tr>
                	<th><label for="invoice_companytel"><?php _e('Company Phone', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="text" class="widefat" name="invoice_companytel" value="<?php echo esc_attr(stripslashes($this -> get_option('invoice_companytel'))); ?>" id="invoice_companytel" />
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_companyfax"><?php _e('Company Fax', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="text" class="widefat" name="invoice_companyfax" value="<?php echo esc_attr(stripslashes($this -> get_option('invoice_companyfax'))); ?>" id="invoice_companyfax" />
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_companyweb"><?php _e('Company Web Address', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="text" class="widefat" name="invoice_companyweb" value="<?php echo esc_attr(stripslashes($this -> get_option('invoice_companyweb'))); ?>" id="invoice_companyweb" />
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_companyaddress"><?php _e('Company Address', $this -> plugin_name); ?></label></th>
                    <td>
                    	<textarea class="widefat" name="invoice_companyaddress" cols="100%" rows="5" id="invoice_companyaddress"><?php echo esc_attr(stripslashes($this -> get_option('invoice_companyaddress'))); ?></textarea>
                    </td>
                </tr>
                <tr>
                	<th><label for="invoice_comments"><?php _e('Footer Text/Comments', $this -> plugin_name); ?></label></th>
                    <td>
                    	<textarea class="widefat" name="invoice_comments" cols="100%" rows="5" id="invoice_comments"><?php echo esc_attr(stripslashes($this -> get_option('invoice_comments'))); ?></textarea>
                    	<span class="howto"><?php _e('text to display at the bottom of the invoice, useful for banking details or special instructions.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p class="submit">
        	<input type="submit" class="button-primary" name="submit" value="<?php _e('Save Invoice Settings', $this -> plugin_name); ?>" />
        </p>
    </form>
    
    <h3><?php _e('Purchase Invoice Preview', $this -> plugin_name); ?></h3>
    <iframe width="100%" frameborder="0" scrolling="no" class="autoHeight widefat" style="width:100%; margin:15px 0 0 0;" src="<?php echo $this -> url(); ?>/wp-checkout-ajax.php?cmd=invoice_iframe"></iframe>
</div>