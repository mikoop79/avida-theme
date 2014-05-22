<div class="wrap">
	<h2><?php _e('Manage Images', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), '?page=checkout-images&amp;method=save', array('class' => "button add-new-h2")); ?></h2>
	<?php if (!empty($images)) : ?>
		<form id="posts-filter" action="?page=checkout-images" method="post">
			<?php if (!empty($images)) : ?>
				<ul class="subsubsub">
					<li><?php echo $paginate -> allcount; ?> <?php _e('product images', $this -> plugin_name); ?></li>
				</ul>
			<?php endif; ?>
			<p class="search-box">
				<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
				<input type="submit" name="search" value="<?php _e('Search Images', $this -> plugin_name); ?>" class="button" />
			</p>
		</form>
	<?php endif; ?>
	<?php $this -> render('images' . DS . 'loop', array('images' => $images, 'paginate' => $paginate)); ?>
</div>