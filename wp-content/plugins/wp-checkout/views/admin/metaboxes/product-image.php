<?php if (empty($Product -> errors['image']) && !empty($Product -> data -> image -> name)) : ?>
	<p>
		<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($Product -> data -> image_url, 250, 200, 100), $wpcoHtml -> retainquery('1=1', $wpcoHtml -> image_url($Product -> data -> image -> name)), array('class' => 'colorbox', 'title' => $Product -> data -> title)); ?>
		<br/><small><?php _e('click to enlarge', $this -> plugin_name); ?></small>
	</p>
	<?php echo $wpcoForm -> hidden('Product.oldimage', array('value' => $Product -> data -> image -> name)); ?>
	<?php flush(); ?>
<?php endif; ?>

<?php echo $wpcoForm -> file('Product.image'); ?>

<?php if (empty($Product -> errors['image']) && !empty($Product -> data -> image -> name)) : ?>
	<small style="display:block;"><?php _e('leave this field blank to keep the current image', $this -> plugin_name); ?></small>
<?php endif; ?>