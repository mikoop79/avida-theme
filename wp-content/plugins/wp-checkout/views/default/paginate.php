<?php if (!empty($paginate -> pagination)) : ?>
	<div class="<?php echo $this -> pre; ?>paging">
		<?php if (empty($_GET['showall'])) : ?>
			<?php echo $paginate -> pagination; ?>
		<?php endif; ?>
		<?php if (wpco_is_category()) : ?>
			<span class="wpcoshowall">
				<?php if (empty($_GET['showall'])) : ?>
					<a href="<?php echo $wpcoHtml -> retainquery('showall=1&wpcopage=1'); ?>"><?php _e('Show All', $this -> plugin_name); ?></a>
				<?php else : ?>
					<a href="<?php echo $wpcoHtml -> retainquery('showall=0&wpcopage=1'); ?>"><?php _e('Show Paging', $this -> plugin_name); ?></a>
				<?php endif; ?>
			</span>
		<?php endif; ?>
		<br class="<?php echo $this -> pre; ?>cleaner" />
	</div>
<?php endif; ?>