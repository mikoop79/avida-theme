<div class="shortproduct">
	<div class="img">
		<?php if ($this -> get_option('cropthumb') == "Y") : ?>
            <?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($product -> image_url, $this -> get_option('loop_thumbw'), $this -> get_option('loop_thumbh'), $this -> get_option('loopthumbq'), "thumb"), get_permalink($product -> post_id), array('title' => $product -> title)); ?>
		<?php else : ?>
			<?php echo $wpcoHtml -> link($wpcoHtml -> image($product -> image -> name), get_permalink($product -> post_id), array('title' => $product -> title)); ?>
		<?php endif; ?>
	</div>

	<?php if ($this -> get_option('showcase') == "N") : ?>	
		<div class="pricewrap">
			<span class="price"><?php echo $wpcoHtml -> currency_price($Product -> unit_price($product -> id, 999999, null, false, false)); ?></span>
			<span class="pricedesc"><?php _e('per unit', $this -> plugin_name); ?></span>
		</div>
	<?php endif; ?>

	<?php if (!is_feed()) : ?>
		<?php if ($this -> get_option('showcase') == "N") : ?>
			<?php if ($this -> get_option('loop_addbutton') == "Y" && (empty($noaddtob) || $noaddtob == false)) : ?>					
				<?php if (empty($product -> oos) || $product -> oos == false) : ?>
					<?php echo $wpcoHtml -> addtocart_action($product -> id, (!empty($product -> styles) || !empty($product -> cfields)) ? true : false, false); ?>
						<?php echo $wpcoForm -> hidden('Item.product_id', array('value' => $product -> id)); ?>
						<?php global $user_ID; ?>
						<?php echo $wpcoForm -> hidden('Item.user_id', array('value' => $user_ID)); ?>
						
						<b><?php _e('How many?', $this -> plugin_name); ?></b>
						<?php echo $wpcoForm -> text('Item.count', array('value' => (empty($product -> min_order)) ? '1' : $product -> min_order, 'width' => '25px')); ?>
						
						<?php if ($this -> get_option('buynow') == "Y") : ?>
							<?php echo $wpcoForm -> submit(__('Buy Now', $this -> plugin_name) . ' &raquo;'); ?>
						<?php else : ?>
							<span id="submit<?php echo $product -> id; ?>"><?php echo $wpcoForm -> submit(__('Add to Basket', $this -> plugin_name) . ' &raquo;'); ?></span>
							<span id="loading<?php echo $product -> id; ?>" style="display:none;"><img src="<?php echo $this -> url(); ?>/images/loading.gif" alt="loading" /> <?php _e('adding product', $this -> plugin_name); ?>...</span>
						<?php endif; ?>
						
						<p class="<?php echo $this -> pre; ?>error" id="message<?php echo $product -> id; ?>" style="display:none;"></p>
					</form>
				<?php else : ?>
					<p class="<?php echo $this -> pre; ?>oos"><?php echo $wpcocaptions['product']['oos']; ?></p>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>
	
	<p class="productdesc"><?php echo $wpcoHtml -> truncate(apply_filters($this -> pre . '_product_description', $product -> description), 125); ?></p>
	<br class="<?php echo $this -> pre; ?>cleaner" />
	
	<small><?php echo $product -> keywords; ?></small>
</div>