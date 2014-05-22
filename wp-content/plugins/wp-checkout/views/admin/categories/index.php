<div class="wrap">
	<h2><?php _e('Manage Categories', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), '?page=checkout-categories-save', array('class' => "button add-new-h2")); ?></h2>
	<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
		<?php if (!empty($categories)) : ?>
			<ul class="subsubsub">
				<li><?php echo $paginate -> allcount; ?> <?php _e('categories', $this -> plugin_name); ?></li>
			</ul>
		<?php endif; ?>
		<p class="search-box">
			<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
			<input type="submit" name="search" value="<?php _e('Search Categories', $this -> plugin_name); ?>" class="button" />
		</p>
	</form>
	<?php $this -> render('categories' . DS . 'loop', array('categories' => $categories, 'paginate' => $paginate)); ?>
</div>