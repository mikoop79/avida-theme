<?php

/* USPS (US Postal Service) */

/*$usps_services = array(
	'FIRST CLASS'					=>	__('First Class', $this -> plugin_name),
	'PRIORITY'						=>	__('Priority', $this -> plugin_name),
	'PRIORITY COMMERCIAL'			=>	__('Priority Commercial', $this -> plugin_name),
	'EXPRESS'						=>	__('Express', $this -> plugin_name),
	'EXPRESS COMMERCIAL'			=>	__('Express Commercial', $this -> plugin_name),
	'EXPRESS SH'					=>	__('Express SH', $this -> plugin_name),
	'EXPRESS SH COMMERCIAL'			=>	__('Express SH Commercial', $this -> plugin_name),
	'EXPRESS HFP'					=>	__('Express HFP', $this -> plugin_name),
	'EXPRESS HFP COMMERCIAL'		=>	__('Express HFP Commercial', $this -> plugin_name),
	'BPM'							
);*/

$usps_services = array(
	'FIRST CLASS'				=>	__('First Class', $this -> plugin_name),
	'FIRST CLASS COMMERCIAL'	=>	__('First Class Commercial', $this -> plugin_name),
	'FIRST CLASS HFP COMMERCIAL'	=> __('First Class HFP Commercial', $this -> plugin_name),
	'PRIORITY'					=>	__('Priority', $this -> plugin_name),
	'PRIORITY COMMERCIAL'		=>	__('Priority Commercial', $this -> plugin_name),
	'EXPRESS'					=>	__('Express', $this -> plugin_name),
	'EXPRESS COMMERCIAL'		=>	__('Express Commercial', $this -> plugin_name),
	'EXPRESS SH'				=>	__('Express SH', $this -> plugin_name),
	'EXPRESS SH COMMERCIAL'		=>	__('Express SH Commercial', $this -> plugin_name),
	'EXPRESS HFP'				=>	__('Express HFP', $this -> plugin_name),
	'EXPRESS HFP COMMERCIAL'	=>	__('Express HFP Commercial', $this -> plugin_name),
	'BPM'						=>	__('Bpm', $this -> plugin_name),
	'PARCEL'					=>	__('Parcel', $this -> plugin_name),
	'MEDIA'						=>	__('Media', $this -> plugin_name),
	'LIBRARY'					=>	__('Library', $this -> plugin_name),
);

$this -> update_option('usps_services', $usps_services);

//$this -> add_option('usps_services', $usps_services);
$this -> add_option('usps_testgatewayurl', "http://testing.shippingapis.com/ShippingAPITest.dll");
$this -> add_option('usps_prodgatewayurl', "http://production.shippingapis.com/ShippingAPI.dll");

?>