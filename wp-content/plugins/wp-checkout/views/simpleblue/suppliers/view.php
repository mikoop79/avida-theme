<h4><?php echo $supplier -> name; ?></h4>

<?php if (!empty($supplier -> image) && $supplier -> image == "Y") : ?>
	<div class="<?php echo $this -> pre; ?>supplierimg">
    	<?php if ($this -> get_option('supimg') == "thumb") : ?>
        	<?php echo $wpcoHtml -> timthumb_image($supplier -> image_url, $this -> get_option('supthumbw'), $this -> get_option('supthumbh'), 100); ?>
        <?php else : ?>
			<?php echo $wpcoHtml -> image($supplier -> imagename, array('folder' => "suppliers", 'alt' => $wpcoHtml -> sanitize($supplier -> name))); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if (!is_feed()) : ?>
	<?php $this -> render('products' . DS . 'loop', array('products' => $products, 'paginate' => $paginate, 'changeview' => $changeview), true, 'default'); ?>
<?php endif; ?>