<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/thickbox/thickbox.js"></script>

<?php if ($this -> get_option('shoplogo') == "Y" || $this -> get_option('shopname') == "Y") : ?>
	<?php if ($logourl = $this -> get_option('shoplogourl')) : ?>
		<div align="center">
			<h1 id="<?php echo $this -> pre; ?>logo">
				<a href="<?php echo $this -> get_option('shopurl'); ?>" title="<?php echo get_option('blogname'); ?>">
					<?php if ($this -> get_option('shoplogo') == "Y") : ?>
						<img style="border:none;" alt="<?php echo $this -> plugin_name; ?>" src="<?php echo $logourl; ?>" />
					<?php endif; ?>
					<?php if ($this -> get_option('shopname') == "Y") : ?>
						<br/><?php echo get_option('blogname'); ?>
					<?php endif; ?>
				</a>
			</h1>
		</div>
	<?php endif; ?>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo $this -> url(); ?>/css/<?php echo $this -> plugin_name; ?>-wpdie.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo site_url(); ?>/wp-includes/js/thickbox/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript">
var wpcoAjax = "<?php echo rtrim($this -> url(), '/'); ?>/<?php echo $this -> plugin_name; ?>-ajax.php";
$<?php echo $this -> pre; ?> = jQuery.noConflict();

var tb_pathToImage = "<?php echo site_url(); ?>/<?php echo WPINC; ?>/js/thickbox/loadingAnimation.gif";
var tb_closeImage = "<?php echo site_url(); ?>/<?php echo WPINC; ?>/js/thickbox/tb-close.png"
</script>

<script type="text/javascript" src="<?php echo $this -> url(); ?>/js/<?php echo $this -> plugin_name; ?>-wpdie.js"></script>