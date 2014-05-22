<?php if (!is_feed() && current_user_can('checkout_products')) : ?>
	<p><small>
		<?php echo $wpcoHtml -> link(__('Edit Category', $this -> plugin_name), $wpcoHtml -> category_save_url($category -> id)); ?> |
		<?php echo $wpcoHtml -> link(__('Delete Category', $this -> plugin_name), $wpcoHtml -> category_delete_url($category -> id), array('onclick' => "if (!confirm('" . __('Are you sure you wish to remove this category?', $this -> plugin_name) . "')) { return false; }")); ?>
	</small></p>
<?php endif; ?>

<div class="<?php echo $this -> pre; ?>category">
	<?php if ($this -> get_option('catkw') == "Y") : ?>
		<p><small><?php echo $category -> keywords; ?></small></p>
	<?php endif; ?>
	
	<?php if ($this -> get_option('catimgshow') == "Y" && $category -> useimage == "Y") : ?>
		<?php if (!empty($category -> image -> name)) : ?>
			<p class="catimage <?php echo $this -> pre; ?>catimg">				
				<?php if ($this -> get_option('catimg') == "full") : ?>
					<?php echo $wpcoHtml -> image($category -> image -> name, array('folder' => 'catimages', 'alt' => $wpcoHtml -> sanitize($category -> title))); ?>
				<?php else : ?>
					<?php /*<?php echo $wpcoHtml -> image($wpcoHtml -> thumb_name($category -> image -> name, 'thumb'), array('folder' => 'catimages', 'alt' => $wpcoHtml -> sanitize($category -> title))); ?>*/ ?>
                    <?php echo $wpcoHtml -> timthumb_image($category -> image_url, $this -> get_option('catthumbw'), $this -> get_option('catthumbh'), 100); ?>
				<?php endif; ?>
			</p>
            <?php if ($this -> get_option('cattitleshow') == "Y") : ?>
           		<h3 class="cattitle"><?php echo $wpcoHtml -> link($category -> title, get_permalink($category -> post_id), array('title' => $category -> title, 'class' => "cattitlelink")); ?></h3>
            <?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php /* should the category description be shown? */ ?>
	<?php if ($this -> get_option('catdesc') == "Y") : ?>
		<?php echo wpautop($category -> description); ?>
	<?php endif; ?>
</div>
<br class="<?php echo $this -> pre; ?>cleaner" />

<?php global $wpcoDb; ?>
<?php $wpcoDb -> model = $Category -> model; ?>
<?php if (!is_feed() && $subs = $wpcoDb -> find_all(array('parent_id' => $category -> id), false, array($suborderby, $suborder))) : ?>
	<?php if ($this -> get_option('showsubcats') == "Y") : ?>
		<?php if ($this -> get_option('subcatheading') == "Y") : ?>
            <h3><?php _e('Sub Categories', $this -> plugin_name); ?></h3>
        <?php endif; ?>
        <?php if ($this -> get_option('subcatdisplay') == "grid") : ?>
            <div class="<?php echo $this -> pre; ?>categoriesgrid">
                <ul>
                    <?php foreach ($subs as $sub) : ?>
                        <li>
                            <div class="<?php echo $this -> pre; ?>categoryimg">
                            	<?php /*
                                <?php if ($this -> get_option('subcatimgdisplay') == "full") : ?>
                                    <?php echo $wpcoHtml -> link($wpcoHtml -> image($sub -> image -> name, array('folder' => "catimages", 'alt' => $wpcoHtml -> sanitize($sub -> title))), get_permalink($sub -> post_id), array('title' => $sub -> title)); ?>
                                <?php elseif ($this -> get_option('subcatimgdisplay') == "thumb") : ?>
                                    <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($sub -> image_url, $this -> get_option('scatthumbw'), $this -> get_option('scatthumbh'), 100), get_permalink($sub -> post_id), array('title' => $sub -> title)); ?>
                                <?php else : ?>
                                    <?php echo $wpcoHtml -> link($wpcoHtml -> image($wpcoHtml -> thumb_name($sub -> image -> name, "small"), array('folder' => "catimages", 'alt' => $wpcoHtml -> sanitize($sub -> title))), get_permalink($sub -> post_id), array('title' => $sub -> title)); ?>
                                <?php endif; ?>
								*/ ?>
                                <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($sub -> image_url, $this -> get_option('scatthumbw'), $this -> get_option('scatthumbh'), 100), get_permalink($sub -> post_id), array('title' => $sub -> title)); ?>
                            </div>
                            <h4><?php echo $wpcoHtml -> link($sub -> title, get_permalink($sub -> post_id), array('title' => $sub -> title)); ?></h4>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <br class="<?php echo $this -> pre; ?>cleaner" />
            </div>
        <?php else : ?>
            <ul>
                <?php foreach ($subs as $sub) : ?>
                    <li><?php echo $wpcoHtml -> link($sub -> title, get_permalink($sub -> post_id), array('title' => $sub -> title)); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if (!empty($products) && !is_feed()) : ?>
	<?php $this -> render('products' . DS . 'loop', array('products' => $products, 'paginate' => $paginate, 'changeview' => $changeview), true, 'default'); ?>
<?php endif; ?>