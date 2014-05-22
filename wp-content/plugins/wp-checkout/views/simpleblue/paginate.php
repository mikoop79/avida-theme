<?php if (!empty($paginate -> pagination)) : ?>
	<div class="<?php echo $this -> pre; ?>paging">
		<?php echo $paginate -> pagination; ?>
		<br class="<?php echo $this -> pre; ?>cleaner" />
	</div>
<?php endif; ?>