Dear <?php echo stripslashes($item -> iof_benname); ?>,

A donation in the amount of <?php echo $wpcoHtml -> currency_price(($Product -> unit_price($item -> product -> id, $item -> count, $item -> id) * $item -> count)); ?> has been made on your behalf. 
This donation was made by <?php echo stripslashes($item -> iof_name); ?>.