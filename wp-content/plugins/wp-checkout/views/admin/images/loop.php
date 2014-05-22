<?php if (!empty($images)) : ?>
	<form action="?page=checkout-images&amp;method=mass" method="post" onsubmit="if (!confirm('<?php _e('Are you sure you wish to execute this action on the selected images?', $this -> plugin_name); ?>')) { return false; }">
		<div class="tablenav">
			<div class="alignleft actions">
				<select name="action">
					<option value=""><?php _e('- Bulk Actions -', $this -> plugin_name); ?></option>
					<option value="delete"><?php _e('Delete', $this -> plugin_name); ?></option>
				</select>
				<input type="submit" name="execute" value="<?php _e('Apply', $this -> plugin_name); ?>" class="button" />
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
		<table class="widefat">
			<thead>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th colspan="2"><?php _e('File', $this -> plugin_name); ?></th>
					<th><?php _e('Product', $this -> plugin_name); ?></th>
					<th><?php _e('Size', $this -> plugin_name); ?></th>
					<th><?php _e('Type', $this -> plugin_name); ?></th>
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="check-column"><input type="checkbox" name="checkboxall" value="checkboxall" id="checkboxall" /></th>
					<th colspan="2"><?php _e('File', $this -> plugin_name); ?></th>
					<th><?php _e('Product', $this -> plugin_name); ?></th>
					<th><?php _e('Size', $this -> plugin_name); ?></th>
					<th><?php _e('Type', $this -> plugin_name); ?></th>
					<th><?php _e('Modified', $this -> plugin_name); ?></th>
				</tr>
			</tfoot>
			<tbody>
				<?php $class = ''; ?>
				<?php foreach ($images as $image) : ?>
				<?php $info = $wpcoHtml -> image_pathinfo($image -> filename); ?>
				<tr class="<?php echo $class = (empty($class)) ? 'alternate' : ''; ?>">
					<th class="check-column"><input type="checkbox" name="Image[checklist][]" value="<?php echo $image -> id; ?>" id="checklist<?php echo $image -> id; ?>" /></th>
					<td style="width:75px;"><?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($image -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), $wpcoHtml -> image_url($image -> filename), array('title' => $image -> title, 'class' => 'colorbox')); ?></td>
					<td>
						<?php echo $wpcoHtml -> link($image -> title, '?page=checkout-images&amp;method=save&amp;id=' . $image -> id, array('class' => 'row-title')); ?>
						<div class="row-actions">
							<span class="edit"><?php echo $wpcoHtml -> link(__('Edit', $this -> plugin_name), "?page=checkout-images&amp;method=save&amp;id=" . $image -> id); ?> |</span>
							<span class="delete"><?php echo $wpcoHtml -> link(__('Delete', $this -> plugin_name), "?page=checkout-images&amp;method=delete&amp;id=" . $image -> id, array('class' => "submitdelete", 'onclick' => "if (!confirm('" . __('Are you sure you want to delete this image?', $this -> plugin_name) . "')) { return false; }")); ?></span>
						</div>
					</td>
					<td><?php echo $wpcoHtml -> link(apply_filters($this -> pre . '_product_title', $Product -> field('title', array('id' => $image -> product_id))), '?page=checkout-products&amp;method=view&amp;id=' . $image -> product_id); ?></td>
					<td><label for="checklist<?php echo $image -> id; ?>"><?php echo number_format((($image -> filesize/1024)/1024), 2, '.', ''); ?><?php _e('Mb', $this -> plugin_name); ?></label></td>
					<td><label for="checklist<?php echo $image -> id; ?>"><?php echo $image -> filetype; ?></label></td>
					<td><label for="checklist<?php echo $image -> id; ?>"><?php echo $image -> modified; ?></label></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="tablenav">
			<div class="alignleft">
				<select name="perpage" onchange="change_perpage(this.value);">
					<option value="">- <?php _e('Per Page', $this -> plugin_name); ?> -</option>
					<?php $p = 5; ?>
					<?php while ($p < 100) : ?>
						<option <?php echo (isset($_COOKIE[$this -> pre . 'imagesperpage']) && $_COOKIE[$this -> pre . 'imagesperpage'] == $p) ? 'selected="selected"' : ''; ?> value="<?php echo $p; ?>"><?php echo $p; ?> <?php _e('images', $this -> plugin_name); ?></option>
						<?php $p += 5; ?>
					<?php endwhile; ?>
				</select>
				
				<script type="text/javascript">
				function change_perpage(perpage) {
					if (perpage != "") {
						document.cookie = "<?php echo $this -> pre; ?>imagesperpage=" + perpage + "; expires=<?php echo $wpcoHtml -> gen_date($this -> get_option('cookieformat'), strtotime("+30 days")); ?> GMT; path=/";
						window.location = "<?php echo $_SERVER['REQUEST_URI']; ?>";
					}
				}
				</script>
			</div>
			<?php $this -> render('paginate', array('paginate' => $paginate)); ?>
		</div>
	</form>
<?php else : ?>
	<p class="<?php echo $this -> pre; ?>error"><?php _e('No images are available', $this -> plugin_name); ?></p>
<?php endif; ?>