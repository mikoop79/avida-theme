<div class="wrap">
	<h2><?php _e('Manage Digital Files'); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), '?page=checkout-files&amp;method=save', array('class' => "button add-new-h2", 'title' => __('Add a new downloadable product file', $this -> plugin_name))); ?></h2>
	<?php if (!empty($files)) : ?>
		<form id="posts-filter" action="?page=checkout-files" method="post">
			<?php if (!empty($files)) : ?>
				<ul class="subsubsub">
					<li><?php echo $paginate -> allcount; ?> <?php _e('files', $this -> plugin_name); ?></li>
				</ul>
			<?php endif; ?>
			<p class="search-box">
				<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
				<input type="submit" name="search" value="<?php _e('Search Files', $this -> plugin_name); ?>" class="button" />
			</p>
		</form>
	<?php endif; ?>
	<?php $this -> render('files' . DS . 'loop', array('files' => $files, 'paginate' => $paginate), true, 'admin'); ?>
</div>