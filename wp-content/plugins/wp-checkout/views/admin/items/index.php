<div class="wrap">
	<h2><?php _e('Manage Order Items', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New'), $this -> url . '&amp;method=save', array('title' => __('Add a new order item', $this -> plugin_name), 'class' => "button add-new-h2")); ?></h2>
	<?php if (!empty($items)) : ?>
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
			<?php if (!empty($items)) : ?>
				<ul class="subsubsub">
					<li><?php echo $paginate -> allcount; ?> <?php _e('order items', $this -> plugin_name); ?></li>
				</ul>
			<?php endif; ?>
			<p class="search-box">
				<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
				<input type="submit" name="search" value="<?php _e('Search Items', $this -> plugin_name); ?>" class="button" />
			</p>
		</form>
	<?php endif; ?>
	<?php $this -> render('items' . DS . 'loop', array('items' => $items, 'paginate' => $paginate), true, 'admin'); ?>
</div>