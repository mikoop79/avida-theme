<p><?php echo $wpcoHtml -> link(__('&laquo; Back to your account', $this -> plugin_name), $wpcoHtml -> account_url()); ?></p>
<h3><?php _e('Favorites', $this -> plugin_name); ?></h3>

<?php $this -> render('errors', array('errors' => $errors), true, 'default'); ?>

<?php if (!empty($favorites)) : ?>
	<?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
	<table class="<?php echo $this -> pre; ?> <?php echo $this -> pre; ?>cart">
		<thead>
			<tr>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th colspan="2"><?php _e('Actions', $this -> plugin_name); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th colspan="2"><?php _e('Product', $this -> plugin_name); ?></th>
				<th colspan="2"><?php _e('Actions', $this -> plugin_name); ?></th>
			</tr>
		</tfoot>
		<tbody>
        	<?php $class = ""; ?>
			<?php foreach ($favorites as $favorite) : ?>
            	<tr class="<?php echo $class = (empty($class) || $class == "erow") ? 'arow' : 'erow'; ?>">
                	<td style="width:50px;">
                    	<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($favorite -> product -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($favorite -> product -> image -> name, 'images'), array('class' => "colorbox", 'title' => $favorite -> product -> title)); ?>
                    </td>
                    <td><?php echo $wpcoHtml -> link($favorite -> product -> title, get_permalink($favorite -> product -> post_id)); ?></td>
                    <td><?php echo $wpcoHtml -> link('<img src="' . $this -> url() . '/images/view.png" border="0" style="border:none;" alt="view" />', get_permalink($favorite -> product -> post_id), array('title' => __('View this product now', $this -> plugin_name))); ?></td>
                    <td><?php echo $wpcoHtml -> link('<img src="' . $this -> url() . '/images/deny.png" border="0" style="border:none;" alt="delete" />', "javascript:wpco_deletefavorite('" . $favorite -> id . "');", array('title' => __('Remove this favorite from your account', $this -> plugin_name), 'onclick' => "if (!confirm('" . __('Are you sure you want to remove this favorite?', $this -> plugin_name) . "')) { return false; }")); ?></td>
                </tr>
            <?php endforeach; ?>
		</tbody>
	</table>
    <?php $this -> render('paginate', array('paginate' => $paginate), true, 'default'); ?>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No favorites are in your account at this time.', $this -> plugin_name); ?></p>
<?php endif;?>