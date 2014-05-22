<?php global $category_hierarchy; ?>
<?php $category_hierarchy = false; ?>
<?php $mains = (!empty($options['maincategories']) && $options['maincategories'] == "Y") ? true : false; ?>

<?php if (!empty($options['dropdown']) && $options['dropdown'] == "Y") : ?>
	<?php if ($categories = $Category -> select(0, $mains, array($options['categories_sortby'], $options['categories_sort']))) : ?>
    	<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
    	<select style="width:100%; overflow:auto;" id="<?php echo $this -> pre; ?>_widget_categories_<?php echo $number; ?>" name="" onchange="window.location = this.value;">
        	<option value=""><?php _e('- Select Category -', $this -> plugin_name); ?></option>
            <?php foreach ($categories as $category_id => $category_title) : ?>
            	<?php $wpcoDb -> model = $Category -> model; ?>
                <?php $category_postid = $wpcoDb -> field('post_id', array('id' => $category_id)); ?>
            	<option value="<?php echo get_permalink($category_postid); ?>"><?php echo $category_title; ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
<?php else : ?>
	<?php if ($hierarchy = $Category -> hierarchy(0, true, $mains, array($options['categories_sortby'], $options['categories_sort']), $options['productcount'])) : ?>
        <?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
        <?php echo $hierarchy; ?>
    <?php endif; ?>
<?php endif; ?>