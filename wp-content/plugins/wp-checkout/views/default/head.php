<!--[if lt IE 8]>
<style type="text/css">
div.productsgrid ul li {
    display: inline;
    zoom: 1;
}

div.wpcocategoriesgrid ul li {
    display: inline;
    zoom: 1;
    width: <?php echo ($this -> get_option('catthumbw')); ?>px;
}
</style>
<![endif]-->

<script type="text/javascript">
var wpcoURL = "<?php echo rtrim($this -> url(), '/'); ?>";
var wpcoAjax = "<?php echo rtrim($this -> url(), '/'); ?>/<?php echo $this -> plugin_name; ?>-ajax.php";
var wpcoCurrency = "<?php echo $wpcoHtml -> currency(); ?>";

jQuery(document).ready(function() {
	jQuery(".wpcohelp a").tooltip();
});
</script>