Good day <?php echo $order -> bill_fname; ?> <?php echo $order -> bill_lname; ?>,

Your order #<?php echo $order -> id; ?> has been modified by the merchant/administrator.
You can view the updated order online on the link below.

<a href="<?php echo $wpcoHtml -> order_url($order -> id); ?>">View Order #<?php echo $order -> id; ?></a>

<?php if (!empty($order -> notifycomments)) : ?>
	Merchant/Admin Comments:
    --------------------------------------------------
    <?php echo wpautop(stripslashes($order -> notifycomments)); ?>
    --------------------------------------------------
<?php endif; ?>