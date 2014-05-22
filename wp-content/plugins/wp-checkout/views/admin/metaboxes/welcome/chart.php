
<?php

$type = (empty($_GET['type'])) ? 'days' : $_GET['type'];
$fromdate = (empty($_GET['from'])) ? date("Y-m-d", strtotime("-31 days")) : $_GET['from'];
$todate = (empty($_GET['to'])) ? date("Y-m-d", time()) : $_GET['to'];

?>

<div class="alignleft actions">
	<p>
		<a href="<?php echo $wpcoHtml -> retainquery('type=years'); ?>" class="button <?php echo (!empty($_GET['type']) && $_GET['type'] == "years") ? 'active' : ''; ?>"><?php _e('Years', $this -> plugin_name); ?></a>
		<a href="<?php echo $wpcoHtml -> retainquery('type=months'); ?>" class="button <?php echo (!empty($_GET['type']) && $_GET['type'] == "months") ? 'active' : ''; ?>"><?php _e('Months', $this -> plugin_name); ?></a>
		<a href="<?php echo $wpcoHtml -> retainquery('type=days'); ?>" class="button <?php echo (empty($_GET['type']) || (!empty($_GET['type']) && $_GET['type'] == "days")) ? 'active' : ''; ?>"><?php _e('Days', $this -> plugin_name); ?></a>
	</p>
</div>
<div class="alignright actions">
	<p>
		<form action="" method="get">
			<input type="hidden" name="type" value="<?php echo $type; ?>" />
			<input type="hidden" name="page" value="<?php echo $this -> sections -> welcome; ?>" />
			<input style="width:100px;" type="text" name="from" value="<?php echo $fromdate; ?>" id="fromdate" />
			<?php _e('to', $this -> plugin_name); ?>
			<input style="width:100px;" type="text" name="to" value="<?php echo $todate; ?>" id="todate" />
			<input class="button button-primary" type="submit" name="changedate" value="<?php _e('Change', $this -> plugin_name); ?>" />
		</form>
	</p>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#fromdate').datepicker({showButtonPanel:true, numberOfMonths:2, changeMonth:true, changeYear:true, defaultDate:"<?php echo $fromdate; ?>", dateFormat:"yy-mm-dd"});
	jQuery('#todate').datepicker({showButtonPanel:true, numberOfMonths:2, changeMonth:true, changeYear:true, defaultDate:"<?php echo $todate; ?>", dateFormat:"yy-mm-dd"});
});
</script>

<?php
	
include $this -> plugin_base() . DS . 'vendors' . DS . 'ofc' . DS . 'open_flash_chart_object.php';
open_flash_chart_object("100%", 300, admin_url('admin-ajax.php') . '?action=wpcochart&type=' . $type . '&from=' . $fromdate . '&to=' . $todate, true, plugins_url() . '/wp-checkout/');

?>