<div class="wrap">
	<h2><?php _e('Manage Custom Fields', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), $this -> url . '&amp;method=save', array('class' => "button add-new-h2")); ?></h2>
	<?php if (!empty($fields)) : ?>
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
			<?php if (!empty($fields)) : ?>
				<ul class="subsubsub">
					<li><?php echo $paginate -> allcount; ?> <?php _e('custom fields', $this -> plugin_name); ?></li>
				</ul>
			<?php endif; ?>
			<p class="search-box">
				<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
				<input type="submit" name="search" value="<?php _e('Search Fields', $this -> plugin_name); ?>" class="button" />
			</p>
		</form>
	<?php endif; ?>
	<?php $this -> render('fields' . DS . 'loop', array('fields' => $fields, 'paginate' => $paginate), true, 'admin'); ?>
</div>