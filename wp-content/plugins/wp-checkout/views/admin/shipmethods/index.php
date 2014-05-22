<div class="wrap">
	<h2><?php _e('Shipping Methods', $this -> plugin_name); ?> <?php echo $wpcoHtml -> link(__('Add New', $this -> plugin_name), $this -> url . '&amp;method=save', array('title' => __('Add a new shipping method', $this -> plugin_name), 'class' => "button add-new-h2")); ?></h2>
	<?php if (true || !empty($shipmethods)) : ?>
		<form id="posts-filter" action="<?php echo $this -> url; ?>" method="post">
        	<?php if (!empty($shipmethods)) : ?>
                <ul class="subsubsub">
                    <li><?php echo $paginate -> allcount; ?> <?php _e('shipping methods', $this -> plugin_name); ?></li>
                </ul>
            <?php endif; ?>
			
			<p class="search-box">
				<input type="text" name="searchterm" class="search-input" id="post-search-input" value="<?php echo (empty($_POST['searchterm'])) ? $_GET[$this -> pre . 'searchterm'] : $_POST['searchterm']; ?>" />
				<input type="submit" name="search" value="<?php _e('Search Methods', $this -> plugin_name); ?>" class="button" />
			</p>
		</form>
	<?php endif; ?>
    
    <br class="clear" />
    
	<?php $this -> render('shipmethods' . DS . 'loop', array('shipmethods' => $shipmethods, 'paginate' => $paginate), true, 'admin'); ?>	
</div>