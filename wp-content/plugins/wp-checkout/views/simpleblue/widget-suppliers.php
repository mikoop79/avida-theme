<?php global $wpcoDb; ?>
<?php $wpcoDb -> model = $Supplier -> model; ?>
<?php $suppliers = $wpcoDb -> find_all(null, null, array('name', "ASC")); ?>
<?php if (!empty($suppliers)) : ?>
	<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
    <?php if (!empty($options['dropdown']) && $options['dropdown'] == "Y") : ?>
    	<select style="width:100%; overflow:auto;" onchange="if (this.value != '') { window.location = this.value; }" name="suppliers<?php echo $number; ?>">
        	<option value=""><?php _e('- Select Supplier -', $this -> plugin_name); ?></option>
            <?php foreach ($suppliers as $supplier) : ?>
            	<option value="<?php echo get_permalink($supplier -> post_id); ?>"><?php echo $supplier -> name; ?></option>
            <?php endforeach; ?>
        </select>
    <?php else : ?>
        <ul>
            <?php foreach ($suppliers as $supplier) : ?>
                <li><?php echo $wpcoHtml -> link($supplier -> name, get_permalink($supplier -> post_id), array('title' => $supplier -> name)); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endif; ?>