<?php if (!empty($images)) : ?>
    <div style="overflow:auto; max-height:200px;">
        <ul>
            <?php foreach ($images as $image) : ?>
                <li id="image<?php echo $image -> id; ?>">
                    <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, 50, 50, 100), $wpcoHtml -> image_url($image -> filename) . '?1=1', array('title' => $image -> title, 'class' => 'colorbox')); ?>
					<?php echo $wpcoHtml -> link('Delete Image', "", array('class' => 'wpco_deleteimage', 'title' => __('Delete image', $this -> plugin_name), 'onclick' => "if (confirm('" . __('Are you sure you want to remove this image?', $this -> plugin_name) . "')) { delete_current_image('" . $image -> id . "', '" . $image -> product_id . "'); } return false;")); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <br class="<?php echo $this -> pre; ?>cleaner" />
    </div>
<?php endif; ?>