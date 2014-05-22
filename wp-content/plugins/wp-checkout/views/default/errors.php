<?php if (!empty($errors)) : ?><ul class="<?php echo $this -> pre; ?>errors">
	<?php foreach ($errors as $err) : ?>
        <li class="<?php echo $this -> pre; ?>error"><?php echo $err; ?></li>
    <?php endforeach; ?>
</ul><?php endif; ?>