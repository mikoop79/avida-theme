<div class="wrap">
	<h2><?php _e('Save a Variation', $this -> plugin_name); ?></h2>
	<form action="<?php echo $this -> url; ?>&amp;method=save" method="post">
		<?php echo $wpcoForm -> hidden('Style.id'); ?>
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Style.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('Style.title'); ?></td>
				</tr>
                <tr>
                	<th><label for="Style.caption"><?php _e('Caption/Description', $this -> plugin_name); ?></label></th>
                    <td>
                    	<?php echo $wpcoForm -> textarea('Style.caption', array('rows' => 2)); ?>
                        <span class="howto"><?php _e('Optional. Give this variation a descriptive caption/notation for your customers to see.', $this -> plugin_name); ?></span>
                    </td>
                </tr>
				<tr>
					<th><label for=""><?php _e('Field Type', $this -> plugin_name); ?></label></th>
					<td>
						<?php $types = array('select' => __('Select Drop Down', $this -> plugin_name), 'radio' => __('Radio Buttons', $this -> plugin_name), 'checkbox' => __('Checkbox List', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Style.type', $types, array('separator' => false, 'default' => "radio")); ?>
						<span class="howto"><?php _e('sets the way variation options are displayed to customers', $this -> plugin_name); ?></span>
					</td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Variation', $this -> plugin_name)); ?>
		</p>
	</form>
</div>