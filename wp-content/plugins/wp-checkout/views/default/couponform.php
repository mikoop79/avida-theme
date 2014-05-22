<div class="<?php echo $this -> pre; ?>couponform">
	<small><?php _e('Do you have a discount coupon code?', $this -> plugin_name); ?></small>
    <form class="<?php echo $this -> pre; ?>" action="" method="post">
        <input type="hidden" name="<?php echo $this -> pre; ?>method" value="applycoupon" />
        <input type="text" class="<?php echo $this -> pre; ?>couponcodeinput" name="code" value="<?php echo esc_attr(stripslashes($_POST['code'])); ?>" />
        <input class="<?php echo $this -> pre; ?>button" style="cursor:pointer;" type="submit" name="applycode" value="<?php _e('Apply Code', $this -> plugin_name); ?>" />
    </form>
</div>