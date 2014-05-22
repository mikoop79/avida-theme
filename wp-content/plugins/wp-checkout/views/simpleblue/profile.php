<?php $user = $this -> userdata($userid); ?>

<div class="<?php echo $this -> pre; ?>">
	<h3><?php _e('Customer Information', $this -> plugin_name); ?></h3>
    <h4><?php _e('Shipping Details', $this -> plugin_name); ?></h4>
    
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="ship_fname"><?php _e('First Name', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td>
                    <input type="text" name="ship_fname" value="<?php echo $user -> ship_fname; ?>" id="ship_fname" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="ship_lname"><?php _e('Last Name', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td>
                    <input type="text" name="ship_lname" value="<?php echo $user -> ship_lname; ?>" id="ship_lname" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="ship_company"><?php _e('Company Name', $this -> plugin_name); ?></label></th>
                <td>
                    <input type="text" name="ship_company" value="<?php echo esc_attr(stripslashes($user -> ship_company)); ?>" id="ship_company" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="ship_phone"><?php _e('Phone Number', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td>
                    <input type="text" name="ship_phone" value="<?php echo esc_attr(stripslashes($user -> ship_phone)); ?>" id="ship_phone" class="regular-text" />
                </td>
            </tr>
            <tr>
            	<th><label for="ship_fax"><?php _e('Fax Number', $this -> plugin_name); ?></label></th>
                <td>
                	<input type="text" name="ship_fax" value="<?php echo esc_attr(stripslashes($user -> ship_fax)); ?>" id="ship_fax" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th><label for="ship_address"><?php _e('Address', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td><input type="text" name="ship_address" value="<?php echo $user -> ship_address; ?>" id="ship_address" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="ship_address2"><?php _e('Address (continued)', $this -> plugin_name); ?></label></th>
                <td><input type="text" name="ship_address2" value="<?php echo $user -> ship_address2; ?>" id="ship_address2" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="ship_city"><?php _e('City', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td><input type="text" name="ship_city" value="<?php echo $user -> ship_city; ?>" id="ship_city" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="ship_state"><?php _e('State/Province', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td><input type="text" name="ship_state" value="<?php echo $user -> ship_state; ?>" id="ship_state" class="regular-text" /></td>
            </tr>
            <tr>
                <th><label for="ship_country"><?php _e('Country', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td>
                    <?php if ($countries = $Country -> select()) : ?>
                        <select name="ship_country" id="ship_country">
                            <option value="">- <?php _e('Select Country', $this -> plugin_name); ?> -</option>
                            <?php foreach ($countries as $cid => $ctitle) : ?>
                                <option <?php echo (!empty($user -> ship_country) && $user -> ship_country == $cid) ? 'selected="selected"' : ''; ?> value="<?php echo $cid; ?>"><?php echo $ctitle; ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th><label for="ship_zipcode"><?php _e('Zip Code', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                <td><input type="text" name="ship_zipcode" value="<?php echo $user -> ship_zipcode; ?>" id="ship_zipcode" class="regular-text" /></td>
            </tr>
        </tbody>
    </table>
    
    <h4><?php _e('Billing Details', $this -> plugin_name); ?></h4>
    
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="billingsameshippingY"><?php _e('Same as Shipping', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input onclick="jQuery('#bssdiv').hide();" <?php echo ($user -> billingsameshipping == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="billingsameshipping" value="Y" id="billingsameshippingY" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input onclick="jQuery('#bssdiv').show();" <?php echo ($user -> billingsameshipping == "N") ? 'checked="checked"' : ''; ?> type="radio" name="billingsameshipping" value="N" id="billingsameshippingN" /> <?php _e('No', $this -> plugin_name); ?></label>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="bssdiv" style="display:<?php echo (!empty($user -> billingsameshipping) && $user -> billingsameshipping == "N") ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="bill_fname"><?php _e('First Name', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td>
                        <input type="text" name="bill_fname" value="<?php echo $user -> bill_fname; ?>" id="bill_fname" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="bill_lname"><?php _e('Last Name', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td>
                        <input type="text" name="bill_lname" value="<?php echo $user -> bill_lname; ?>" id="bill_lname" class="regular-text" />
                    </td>
                </tr>
                <tr>
                	<th><label for="bill_company"><?php _e('Company Name', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="text" name="bill_company" value="<?php echo esc_attr(stripslashes($user -> bill_company)); ?>" id="bill_company" class="regular-text" />
                    </td>
                </tr>
                <tr>
                	<th><label for="bill_phone"><?php _e('Phone Number', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td>
                    	<input type="text" name="bill_phone" value="<?php echo esc_attr(stripslashes($user -> bill_phone)); ?>" id="bill_phone" class="regular-text" />
                    </td>
                </tr>
                <tr>
                	<th><label for="bill_fax"><?php _e('Fax Number', $this -> plugin_name); ?></label></th>
                    <td>
                    	<input type="text" name="bill_fax" value="<?php echo esc_attr(stripslashes($user -> bill_fax)); ?>" id="bill_fax" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th><label for="bill_address"><?php _e('Address', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td><input type="text" name="bill_address" value="<?php echo $user -> bill_address; ?>" id="bill_address" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="bill_address2"><?php _e('Address (continued)', $this -> plugin_name); ?></label></th>
                    <td><input type="text" name="bill_address2" value="<?php echo $user -> bill_address2; ?>" id="bill_address2" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="bill_city"><?php _e('City', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td><input type="text" name="bill_city" value="<?php echo $user -> bill_city; ?>" id="bill_city" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="bill_state"><?php _e('State/Province', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td><input type="text" name="bill_state" value="<?php echo $user -> bill_state; ?>" id="bill_state" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label for="bill_country"><?php _e('Country', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td>
                        <?php if ($countries = $Country -> select()) : ?>
                            <select name="bill_country" id="bill_country">
                                <option value="">- <?php _e('Select Country', $this -> plugin_name); ?> -</option>
                                <?php foreach ($countries as $cid => $ctitle) : ?>
                                    <option <?php echo (!empty($user -> bill_country) && $user -> bill_country == $cid) ? 'selected="selected"' : ''; ?> value="<?php echo $cid; ?>"><?php echo $ctitle; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><label for="bill_zipcode"><?php _e('Zip Code', $this -> plugin_name); ?><sup class="error">&#42;</sup></label></th>
                    <td><input type="text" name="bill_zipcode" value="<?php echo $user -> bill_zipcode; ?>" id="bill_zipcode" class="regular-text" /></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>