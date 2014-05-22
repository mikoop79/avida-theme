<div class="wrap">
	<h2><?php _e('Save a Category', $this -> plugin_name); ?></h2>
	<form action="?page=checkout-categories-save" id="categoryform" method="post" enctype="multipart/form-data">
		<?php wp_nonce_field('checkout-categories-save'); ?>
	
		<?php echo $wpcoForm -> hidden('Category.id'); ?>
		<?php echo $wpcoForm -> hidden('Category.post_id'); ?>
		<?php echo $wpcoForm -> hidden('Category.wpcat_id'); ?>
		<?php echo $wpcoForm -> hidden('Category.wpcat_parent'); ?>
		
		<table class="form-table">
			<tbody>
				<tr>
					<th><label for="Category.title"><?php _e('Title', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> text('Category.title'); ?></td>
				</tr>
				<tr>
					<th><label for="Category.useimageN"><?php _e('Category Image', $this -> plugin_name); ?></label></th>
					<td>
						<?php $options = array('Y' => __('Yes', $this -> plugin_name), 'N' => __('No', $this -> plugin_name)); ?>
						<?php echo $wpcoForm -> radio('Category.useimage', $options, array('separator' => false, 'default' => "N", 'onclick' => "change_useimage(this.value);")); ?>
						
						<script type="text/javascript">
						function change_useimage(useimage) {
							if (useimage == "Y") {
								jQuery('#imagediv').show();
							} else {
								jQuery('#imagediv').hide();
							}
						}
						
						<?php if ($wpcoHtml -> field_value('Category.useimage') == "Y") : ?>
							change_useimage("Y");
						<?php endif; ?>
						</script>
					</td>
				</tr>
			</tbody>
		</table>
		
		<div id="imagediv" style="display:<?php echo ($wpcoHtml -> field_value('Category.useimage') == "Y") ? 'block' : 'none'; ?>;">
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="Category.image"><?php _e('Image File', $this -> plugin_name); ?></label></th>
						<td>
							<?php echo $wpcoForm -> file('Category.image'); ?>
							<?php /*<small style="display:block;"><?php _e('larger than', $this -> plugin_name); ?> <strong><?php echo $this -> get_option('catthumbw'); ?></strong> by <strong><?php echo $this -> get_option('catthumbh'); ?>px</strong></small>*/ ?>
							<?php if (empty($Category -> errors['image']) && !empty($Category -> data -> image -> name)) : ?>
								<br/>
								<b><?php _e('Current Image', $this -> plugin_name); ?></b><br/>
								<span class="howto"><?php _e('leave field empty for no changes', $this -> plugin_name); ?></span>
								<?php echo $wpcoHtml -> link($wpcoHtml -> timthumb_image($Category -> data -> image_url, $this -> get_option('smallw'), $this -> get_option('smallh'), $this -> get_option('smallq')), get_option('siteurl') . '/wp-content/uploads/' . $this -> plugin_name . '/catimages/' . $Category -> data -> image -> name, array('class' => 'colorbox', 'title' => $Category -> data -> title)); ?>
								<?php echo $wpcoForm -> hidden('Category.oldimage', array('value' => $Category -> data -> image -> name)); ?>
								<small style="display:block;"><?php _e('click to enlarge', $this -> plugin_name); ?></small>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<table class="form-table">
				<tr>
					<th><label for="Category.description"><?php _e('Description', $this -> plugin_name); ?></label></th>
					<td><?php echo $wpcoForm -> textarea('Category.description'); ?></td>
				</tr>
				<tr>
					<th><label for="Category.keywords"><?php _e('Keywords', $this -> plugin_name); ?></label></th>
					<td>
						<?php echo $wpcoForm -> text('Category.keywords'); ?>
						<span class="howto">separate keywords with commas</span>
					</td>
				</tr>
				<tr>
					<th><label for="Category.parent_id"><?php _e('Parent Category', $this -> plugin_name); ?></label></th>
					<td>
						<?php $categories = $Category -> select(); ?>
						<?php echo $wpcoForm -> select('Category.parent_id', $categories); ?>
					</td>
				</tr>
                <?php if ($this -> get_option('createpages') == "Y") : ?>
                	<?php if ($this -> get_option('post_type') == "page") : ?>
                    	<tr>
                        	<th><label for="Category.page_template"><?php _e('Page Template', $this -> plugin_name); ?></label></th>
                            <td>
                            	<?php $default_categories_pagetemplate = $this -> get_option('categories_pagetemplate'); ?>
                                <?php $current_categories_pagetemplate = $wpcoHtml -> field_value('Category.page_template'); ?>
                                <?php $categories_pagetemplate = (empty($current_categories_pagetemplate)) ? $default_categories_pagetemplate : $current_categories_pagetemplate; ?>
                                <select name="Category[page_template]" id="Category.page_template">
                                	<option value=""><?php _e('Default Template', $this -> plugin_name); ?></option>
                                    <?php page_template_dropdown($categories_pagetemplate); ?>
                                </select>
                                
                                <span class="howto"><?php _e('template of WordPress page which is saved', $this -> plugin_name); ?></span>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endif; ?>
			</tbody>
		</table>
		<p class="submit">
			<?php echo $wpcoForm -> submit(__('Save Category', $this -> plugin_name)); ?>
		</p>
	</form>
</div>