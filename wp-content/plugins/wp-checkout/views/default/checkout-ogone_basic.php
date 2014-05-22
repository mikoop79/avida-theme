<?php 

$ogone_url = ($this -> get_option('ogone_basic_mode') == "test")
? "https://secure.ogone.com/ncol/test/orderstandard.asp"
: "https://secure.ogone.com/ncol/prod/orderstandard.asp";


// create all the values for the sign
$formArr = array();
$formArr['PSPID']			= $this->get_option('ogone_basic_pspid');
$formArr['orderID']			= $order->id;
$formArr['currency']		= $this->get_option('currency');
$formArr['language']		= get_locale();
$formArr['COM']				= $this->get_option('ogone_basic_title');
$formArr['amount']			= number_format( $Order->total($order->id, true, true, true, true, true), 2, '', '');

// The url's
$formArr['accepturl']			= $wpcoHtml -> return_url() ."&type=ogone_basic";
$formArr['declineurl']			= $wpcoHtml -> fail_url();
$formArr['cancelurl']			= $wpcoHtml -> bill_url();
$formArr['exceptionurl']		= "";

// Set the customer data
$formArr['EMAIL']			= $order -> bill_email;
$formArr['ownerZIP']		= $order -> bill_zipcode;
$formArr['owneraddress']	= $order -> bill_address;
$formArr['ownercty']		= $order -> bill_city;
$formArr['ownertown']		= $order -> bill_city;
$formArr['ownertelno']		= $order -> bill_phone;
$formArr['CN']				= $order -> bill_fname . ' ' . $order -> bill_lname;

// the design of the payment window
$formArr['BGCOLOR']			= $this -> get_option('ogone_basic_bgcolor');
$formArr['TXTCOLOR']		= $this -> get_option('ogone_basic_txtcolor');
$formArr['TBLBGCOLOR']		= $this -> get_option('ogone_basic_tblbgcolor');
$formArr['TBLTXTCOLOR']		= $this -> get_option('ogone_basic_tbltxtcolor');
$formArr['BUTTONBGCOLOR']	= $this -> get_option('ogone_basic_buttonbgcolor');
$formArr['BUTTONTXTCOLOR']	= $this -> get_option('ogone_basci_buttontxtcolor');
$formArr['FONTTYPE']		= $this -> get_option('ogone_basic_fonttype');
$formArr['LOGO']			= $this -> get_option('ogone_basic_logo');
$formArr['TITLE']			= $this -> get_option('ogone_basic_title');


// create an SHA 1 string
$sha1 = $this->get_option('ogone_basic_sha1');
$checkStr = "";
$checkArr = array();
foreach( $formArr as $k => $v ) {
	$checkArr[strToUpper($k)] = $v;
}
kSort($checkArr);

foreach( $checkArr as $k => $v ) {
	if ( $v == "" ) continue;
	$checkStr 		.= strToUpper($k) ."=". $v . $sha1;
}
$formArr['SHASign']	= sha1( $checkStr );


?>

<form method="post" action="<?php echo $ogone_url; ?>" id="ogone_basic_form">
    <!-- general parameters -->
    <input type="hidden" name="PSPID" value="<?php echo $formArr['PSPID']; ?>" />
    <input type="hidden" name="orderID" value="<?php echo $formArr['orderID']; ?>" />
    <input type="hidden" name="amount" value="<?php echo $formArr['amount']; ?>" />
    <input type="hidden" name="currency" value="<?php echo $formArr['currency']; ?>" />
    <input type="hidden" name="language" value="<?php echo $formArr['language']; ?>" />
    <input type="hidden" name="COM" value="<?php echo $formArr['COM']; ?>" />
    <input type="hidden" name="CN" value="<?php echo $formArr['CN']; ?>" />
    <input type="hidden" name="EMAIL" value="<?php echo $formArr['EMAIL']; ?>" />
    <input type="hidden" name="ownerZIP" value="<?php echo $formArr['ownerZIP']; ?>" />
    <input type="hidden" name="owneraddress" value="<?php echo $formArr['owneraddress']; ?>" />
    <input type="hidden" name="ownercty" value="<?php echo $formArr['ownercty']; ?>" />
    <input type="hidden" name="ownertown" value="<?php echo $formArr['ownertown']; ?>" />
    <input type="hidden" name="ownertelno" value="<?php echo $formArr['ownertelno']; ?>" />
    <!-- check before the payment: see chapter 5 -->
    <input type="hidden" name="SHASign" value="<?php echo $formArr['SHASign']; ?>" />
    <!-- layout information: see chapter 6 -->
    <input type="hidden" name="TITLE" value="<?php echo esc_attr(stripslashes($formArr['TITLE'])); ?>" />
    <input type="hidden" name="BGCOLOR" value="<?php echo esc_attr(stripslashes($formArr['BGCOLOR'])); ?>" />
    <input type="hidden" name="TXTCOLOR" value="<?php echo esc_attr(stripslashes($formArr['TXTCOLOR'])); ?>" />
    <input type="hidden" name="TBLBGCOLOR" value="<?php echo esc_attr(stripslashes($formArr['TBLBGCOLOR'])); ?>" />
    <input type="hidden" name="TBLTXTCOLOR" value="<?php echo esc_attr(stripslashes($formArr['TBLTXTCOLOR'])); ?>" />
    <input type="hidden" name="BUTTONBGCOLOR" value="<?php echo esc_attr(stripslashes($formArr['BUTTONBGCOLOR'])); ?>" />
    <input type="hidden" name="BUTTONTXTCOLOR" value="<?php echo esc_attr(stripslashes($formArr['BUTTONTXTCOLOR'])); ?>" />
    <input type="hidden" name="LOGO" value="<?php echo esc_attr(stripslashes($formArr['LOGO'])); ?>" />
    <input type="hidden" name="FONTTYPE" value="<?php echo esc_attr(stripslashes($formArr['FONTTYPE'])); ?>" />
    <!-- post payment redirection: see chapter 7 -->
    <input type="hidden" name="accepturl" value="<?php echo $formArr['accepturl'];?>" />
    <input type="hidden" name="declineurl" value="<?php echo $formArr['declineurl']; ?>" />
    <input type="hidden" name="exceptionurl" value="" />
    <input type="hidden" name="cancelurl" value="<?php echo $formArr['cancelurl']; ?>" />

	<p class="submit">
    	<?php /*<a href="<?php echo $wpcoHtml->bill_url(); ?>"><?php _e('&laquo; Back', $this->plugin_name); ?></a>*/ ?>
        <input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
    	<input type="submit" class="<?php echo $this -> pre; ?>button" value="<?php _e('Continue &raquo;', $this->plugin_name); ?>" />
    </p>
</form>

<script type="text/javascript">
jQuery(document).ready(function() {
	var form = document.getElementById('ogone_basic_form');
	form.submit();
});
</script>