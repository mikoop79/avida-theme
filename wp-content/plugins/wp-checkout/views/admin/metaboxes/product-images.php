<div id="currentimages">
	<?php $this -> render('images' . DS . 'product-images', array('images' => $images), true, 'admin'); ?>
</div>

<div id="newimages"></div>

<a class="button button-secondary" href="" onclick="add_new_image(); return false;"><?php _e('Add another image', $this -> plugin_name); ?></a>

<script type="text/javascript">
function delete_current_image(imageid, productid) {
	var mytime = new Date().getTime();
	
	jQuery.post(wpcoAjax + "?cmd=image_delete&image_id=" + imageid, {product_id:productid}, function(response) {
		jQuery('#currentimages').html(response).hide().fadeIn();																	 
	});
}

var count = 1;

function add_new_image() {
	var imagehtml = "";
	imagehtml += '<div class="newimage" id="newimage' + count + '" style="display:none;">';
	imagehtml += '<input type="file" name="extraimages[]" value="" />';
	imagehtml += ' <a href="" onclick="if (confirm(\'<?php _e('Are you sure you want to remove this?', $this -> plugin_name); ?>\')) { delete_new_image(' + count + '); } return false;"><?php _e('Remove'); ?></a>';
	imagehtml += '</div>';
	
	jQuery('#newimages').append(imagehtml);
	jQuery('#newimage' + count).fadeIn();
	count++;
}

function delete_new_image(countid) {
	jQuery('#newimage' + countid).remove();
}
</script>

<style type="text/css">
div.newimage {
	margin: 10px 0 0 0;	
}

#currentimages {
	
}

#currentimages ul {
	list-style: none;
	margin: 0 0 0 0;
	padding: 0 0 0 0;
}

#currentimages ul li {
	float: left;
	margin: 0 10px 0 0;
}
</style>