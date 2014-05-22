<?php

global $user_ID, $wp_roles;
$permissions = $this -> get_option('permissions');
$user = $this -> userdata($user_ID);
$cu = wp_get_current_user();

?>

<?php if (!empty($cu -> roles) && in_array('administrator', $cu -> roles)) : ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="changepermissions_Y"><?php _e('Change Permissions', $this -> plugin_name); ?></label></th>
                <td>
                    <label><input <?php echo ($this -> get_option('changepermissions') == "Y") ? 'checked="checked"' : ''; ?> onclick="jQuery('#permissions_div').show();" type="radio" name="changepermissions" value="Y" id="changepermissions_Y" /> <?php _e('Yes', $this -> plugin_name); ?></label>
                    <label><input <?php echo (!$this -> get_option('changepermissions') || $this -> get_option('changepermissions') == "N") ? 'checked="checked"' : ''; ?> onclick="jQuery('#permissions_div').hide();" type="radio" name="changepermissions" value="N" id="changepermissions_N" /> <?php _e('No', $this -> plugin_name); ?></label>
                    <span class="howto"><?php _e('Give specific roles access to specific sections of the plugin.', $this -> plugin_name); ?></span>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div id="permissions_div" class="scroll-list" style="display:<?php echo (!$this -> get_option('changepermissions') || $this -> get_option('changepermissions') == "N") ? 'none' : 'block'; ?>;">    
        <table class="form-table">
        	<thead>
        		<tr>
        			<th></th>
        			<?php foreach ($wp_roles -> role_names as $role_name) : ?>
        				<th style="font-weight:bold; text-align:center;"><?php echo esc_attr(stripslashes($role_name)); ?></th>
        			<?php endforeach; ?>
        		</tr>
        	</thead>
            <tbody>
            	<?php $class = false; ?>
                <?php foreach ($this -> sections as $section_key => $section_menu) : ?>
                	<?php if ($section_key != "settings_affiliates" || ($section_key == "settings_affiliates" && $this -> is_plugin_active('affiliates'))) : ?>
	                    <tr class="<?php echo $class = (empty($class)) ? 'arow' : ''; ?>">
	                        <th style="white-space:nowrap; text-align:right;"><label for="perm_<?php echo $section_key; ?>"><?php echo $wpcoHtml -> section_name($section_key); ?></label></th>
                        	<?php foreach ($wp_roles -> role_names as $role_key => $role_name) : ?>
                        		<td style="text-align:center;"><label><input <?php echo (!empty($permissions[$section_key]) && in_array($role_key, $permissions[$section_key])) ? 'checked="checked"' : ''; ?> type="checkbox" name="permissions[<?php echo $section_key; ?>][]" value="<?php echo esc_attr(stripslashes($role_key)); ?>" id="<?php echo $section_key; ?>_<?php echo $role_key; ?>" /></label></td>
                        	<?php endforeach; ?>
	                    </tr>
	                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>