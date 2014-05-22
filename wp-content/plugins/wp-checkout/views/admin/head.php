<script type="text/javascript">
var wpcoAjax = "<?php echo rtrim($this -> url(), '/'); ?>/<?php echo $this -> plugin_name; ?>-ajax.php";
var wpcoajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
jQuery(document).ready(function() {
	if (jQuery.isFunction(jQuery.fn.colorbox)) {
		jQuery('.colorbox').colorbox({maxWidth:'100%', maxHeight:'90%'}); 
	}
});

<?php if (!empty($_GET['page']) && in_array($_GET['page'], (array) $this -> sections)) : ?>
	jQuery(document).ready(function() {
		jQuery(".wpcohelp a").tooltip();
	});
<?php endif; ?>
</script>