<?php if (!empty($errors)) : ?><ul>
	<?php foreach ($errors as $err) : ?>
        <li class="<?php echo $this -> pre; ?>error"><?php echo $err; ?></li>
    <?php endforeach; ?>
</ul><br/><?php endif; ?>