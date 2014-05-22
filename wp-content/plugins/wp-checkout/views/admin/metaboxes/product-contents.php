<div id="<?php echo $this -> pre; ?>contents"></div>

<p>
	<input onclick="wpco_addcontent('',''); jQuery('#<?php echo $this -> pre; ?>title' + (wpcocontent - 1)).focus();" type="button" name="addcontent" id="<?php echo $this -> pre; ?>addcontent" value="<?php _e('Add Another Description', $this -> plugin_name); ?>" class="button button-secondary" />
</p>

<script type="text/javascript">
var wpcocontent = 1;
var wpcotitle = '';
var wpcocontents = '';

function wpco_addcontent(wpcotitle, wpcocontents) {					
	wpcohtml = '';
	wpcohtml += '<div id="<?php echo $this -> pre; ?>content' + wpcocontent + '">';
	wpcohtml += '<label for="<?php echo $this -> pre; ?>title' + wpcocontent + '"><h4><?php _e('Additional Description', $this -> plugin_name); ?> (<a href="#void" onclick="wpco_removecontent(\'' + wpcocontent + '\');" title=""><?php _e('remove', $this -> plugin_name); ?></a>)</h4></label>';
	wpcohtml += '<table class="form-table">';
	wpcohtml += '<tbody>';
	wpcohtml += '<tr>';
	wpcohtml += '<th><label for="<?php echo $this -> pre; ?>title' + wpcocontent + '"><?php _e('Title', $this -> plugin_name); ?></label></th>';
	wpcohtml += '<td><input class="widefat" id="<?php echo $this -> pre; ?>title' + wpcocontent + '" type="text" name="Product[contents][' + wpcocontent + '][title]" value="' + wpcotitle + '" /></td>';
	wpcohtml += '</tr>';
	wpcohtml += '<tr>';
	wpcohtml += '<th><label for="<?php echo $this -> pre; ?>textarea' + wpcocontent + '"><?php _e('Description', $this -> plugin_name); ?></label></th>';
	wpcohtml += '<td><textarea rows="4" class="widefat mytextarea" id="<?php echo $this -> pre; ?>textarea' + wpcocontent + '" name="Product[contents][' + wpcocontent + '][content]">' + wpcocontents + '</textarea></td>';
	wpcohtml += '</tr>';
	wpcohtml += '</tbody>';
	wpcohtml += '</table>';
	wpcohtml += '</div>';
	
	jQuery("#<?php echo $this -> pre; ?>contents").append(wpcohtml);    
    jQuery('#<?php echo $this -> pre; ?>textarea' + wpcocontent + '').addClass("mceEditor");
	if (typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function") {
		tinyMCE.execCommand("mceAddControl", false, '<?php echo $this -> pre; ?>textarea' + wpcocontent + '');
	}
	
	wpcocontent++;
}

function wpco_removecontent(contentid) {
	if (confirm("<?php _e('Are you sure you wish to remove this description?', $this -> plugin_name); ?>")) {
		jQuery("#<?php echo $this -> pre; ?>content" + contentid).remove();
	}
	
	return false;
}

jQuery(document).ready(function() {
	var wpcocontent = 1;
	<?php if (!empty($Product -> data -> contents)) : ?>
		<?php foreach ($Product -> data -> contents as $content) : ?>
			wpco_addcontent(<?php echo json_encode(stripslashes($content -> title)); ?>, <?php echo json_encode(wpautop(stripslashes($content -> content))); ?>);
		<?php endforeach; ?>
	<?php endif; ?>
});
</script>