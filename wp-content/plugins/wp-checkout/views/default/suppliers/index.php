<?php if (!empty($suppliers)) : ?>
	<div class="suppliers">
        <ul>
            <?php foreach ($suppliers as $supplier) : ?>
                <li class="supplier"><a class="supplierlink" id="supplierlink<?php echo $supplier -> id; ?>" href="<?php echo get_permalink($supplier -> post_id); ?>" title="<?php esc_attr($supplier -> name); ?>"><?php echo $supplier -> name; ?></a>
            <?php endforeach; ?>
        </ul>
    </li>
<?php endif; ?>