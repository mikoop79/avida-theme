<?php $wpcoDb -> model = $wpcoKeyword -> model; ?>
<?php if ($keywords = $wpcoDb -> find_all($conditions = false, $fields = "`keyword`", $order = array('keyword', "ASC"), $limit = false, $assign = false, $distinct = true)) : ?>
	<?php echo $args['before_title']; ?><?php echo $options['title']; ?><?php echo $args['after_title']; ?>
	
	<select name="" onchange="window.location = '<?php echo get_permalink($this -> get_option('searchpage_id')); ?>?<?php echo $this -> pre; ?>searchterm=' + this.value + '';">
		<option value="">- <?php _e('Choose Keyword', $this -> plugin_name); ?> -</option>
		<?php foreach ($keywords as $keyword) : ?>
			<option value="<?php echo $keyword -> keyword; ?>"><?php echo $keyword -> keyword; ?></option>
		<?php endforeach; ?>
	</select>
<?php endif; ?>