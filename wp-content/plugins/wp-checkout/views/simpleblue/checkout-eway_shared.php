<?php

$ewayCustomerID = $this -> get_option('eway_shared_customerid');
$ewayTotalAmount = number_format($Order -> total($order -> id, true, true, true, true, true), 2, '.', '');
$ewayCustomerFirstName = $order -> bill_fname;
$ewayCustomerLastName = $order -> bill_lname;
$ewayCustomerEmail = $order -> bill_email;
$ewayCustomerPhone = $order -> bill_phone;
$ewayPageTitle = "";
$ewayPageDescription = "";
$ewayPageFooter = "";
$ewayLanguage = "EN";
$ewayCompanyName = "";
$ewayCompanyLogo = "";
$ewayPageBanner = "";
$ewayCustomerAddress = $order -> bill_address;
$ewayCustomerAddress .= (empty($order -> bill_address2)) ? '' : ' ' . $order -> bill_address2;
$ewayCustomerCity = $order -> bill_city;
$ewayCustomerState = $order -> bill_state;
$wpcoDb -> model = $Country -> model;
$country = $wpcoDb -> field('value', array('id' => $order -> bill_country));
$ewayCustomerCountry = $country;
$ewayCustomerPostCode = $order -> bill_zipcode;
$ewayCustomerInvoiceDescription = $this -> get_option('eway_shared_invoicedescription');
$ewayCustomerInvoiceRef = $order -> id;
$ewayCancelURL = $wpcoHtml -> bill_url();
$ewayURL = $wpcoHtml -> retainquery('type=eway_shared&order_id=' . $order -> id, $wpcoHtml -> return_url());
$ewaySiteTitle = get_bloginfo('name');
$ewayAutoRedirect = 1;
$ewayModDetails = "";

/* The CURL Call */
$ewayurl .= "?CustomerID=" . urlencode($this -> get_option('eway_shared_customerid'));
$ewayurl .= "&UserName=" . urlencode($this -> get_option('eway_shared_username'));
$ewayurl .= "&Amount=" . urlencode($ewayTotalAmount);
$ewayurl .= "&Currency=" . urlencode($this -> get_option('currency'));
$ewayurl .= "&PageTitle=" . urlencode($ewayPageTitle);
$ewayurl .= "&PageDescription=" . urlencode($ewayPageDescription);
$ewayurl .= "&PageFooter=" . urlencode($ewayPageFooter);	
$ewayurl .= "&Language=" . urlencode($ewayLanguage);
$ewayurl .= "&CompanyName=" . urlencode($ewayCompanyName);
$ewayurl .= "&CustomerFirstName=" . urlencode($ewayCustomerFirstName);
$ewayurl .= "&CustomerLastName=" . urlencode($ewayCustomerLastName);		
$ewayurl .= "&CustomerAddress=" . urlencode($ewayCustomerAddress);
$ewayurl .= "&CustomerCity=" . urlencode($ewayCustomerCity);
$ewayurl .= "&CustomerState=" . urlencode($ewayCustomerState);
$ewayurl .= "&CustomerPostCode=" . urlencode($ewayCustomerPostCode);
$ewayurl .= "&CustomerCountry=" . urlencode($ewayCustomerCountry);		
$ewayurl .= "&CustomerEmail=" . urlencode($ewayCustomerEmail);
$ewayurl .= "&CustomerPhone=" . urlencode($ewayCustomerPhone);		
$ewayurl .= "&InvoiceDescription=" . urlencode($ewayCustomerInvoiceDescription);
$ewayurl .= "&CancelURL=" . urlencode($ewayCancelURL);
$ewayurl .= "&ReturnUrl=" . urlencode($ewayURL);
$ewayurl .= "&CompanyLogo=" . urlencode($ewayCompanyLogo);
$ewayurl .= "&PageBanner=" . urlencode($ewayPageBanner);
$ewayurl .= "&MerchantReference=" . urlencode($order -> id);
$ewayurl .= "&MerchantInvoice=" . urlencode($order -> id);
$ewayurl .= "&MerchantOption1="; 
$ewayurl .= "&MerchantOption2=";
$ewayurl .= "&MerchantOption3=";
$ewayurl .= "&ModifiableCustomerDetails=" . urlencode($ewayModDetails);
	
$spacereplace = str_replace(" ", "%20", $ewayurl);	
$posturl = "https://au.ewaygateway.com/Request/" . $spacereplace;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $posturl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

if (CURL_PROXY_REQUIRED == 'True') {
	$proxy_tunnel_flag = (defined('CURL_PROXY_TUNNEL_FLAG') && strtoupper(CURL_PROXY_TUNNEL_FLAG) == 'FALSE') ? false : true;
	curl_setopt ($ch, CURLOPT_HTTPPROXYTUNNEL, $proxy_tunnel_flag);
	curl_setopt ($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
	curl_setopt ($ch, CURLOPT_PROXY, CURL_PROXY_SERVER_DETAILS);
}

$response = curl_exec($ch);

function fetch_data($string, $start_tag, $end_tag) {
	$position = stripos($string, $start_tag);  
	$str = substr($string, $position);  		
	$str_second = substr($str, strlen($start_tag));  		
	$second_positon = stripos($str_second, $end_tag);  		
	$str_third = substr($str_second, 0, $second_positon);  		
	$fetch_data = trim($str_third);		
	return $fetch_data; 
}


$responsemode = fetch_data($response, '<result>', '</result>');
$responseurl = fetch_data($response, '<uri>', '</uri>');
$responseerror = fetch_data($response, '<error>', '</error>');
   
if($responsemode == "True") { 

	?>
	
	<h3><?php _e('Processing Order', $this -> plugin_name); ?></h3>
	<?php _e('Please wait while your order is being processed.', $this -> plugin_name); ?><br/>
	<?php _e('If you do not get redirected within 3 seconds, please click the "Continue" button below.', $this -> plugin_name); ?><br/><br/>
	
	<p class="submit">
        <?php /*<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />*/ ?>
		<?php /*<input class="<?php echo $this -> pre; ?>button" type="submit" name="continue" value="<?php _e('Continue &raquo;', $this -> plugin_name); ?>" />*/ ?>
		<a href="<?php echo $responseurl; ?>" class="<?php echo $this -> pre; ?>button"><?php _e('Continue &raquo;', $this -> plugin_name); ?></a>
    </p>
	
	<?php
			  	  	
  $this -> redirect($responseurl);
} else {
  //$this -> redirect($wpcoHtml -> bill_url());
  ?>
  
  	<p><?php _e('This order has failed with the response error below, please try again.', $this -> plugin_name); ?></p>
  	<p class="<?php echo $this -> pre; ?>error"><?php echo stripslashes($responseerror); ?></p>
  
	<p class="submit">
		<input class="<?php echo $this -> pre; ?>button" type="button" name="back" value="<?php _e('&laquo; Back', $this -> plugin_name); ?>" onclick="history.go(-1);" />
	</p>
  
  <?php
}

?>