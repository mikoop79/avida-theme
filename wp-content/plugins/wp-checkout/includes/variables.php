<?php

/* Checkout sections/pages */
$checkout_sections = array(
	'contacts'				=>	__('Contacts', $this -> plugin_name),
	'shipping'				=>	__('Shipping', $this -> plugin_name),
	'billing'				=>	__('Billing', $this -> plugin_name),
);

/* Days of the week */
$daysoftheweek = array(
	1			=>	array('slug' => "mon", 'full' => __("Monday", $this -> plugin_name)),
	2			=>	array('slug' => "tue", 'full' => __("Tuesday", $this -> plugin_name)),
	3			=>	array('slug' => "wed", 'full' => __("Wednesday", $this -> plugin_name)),
	4			=>	array('slug' => "thu", 'full' => __("Thursday", $this -> plugin_name)),
	5			=>	array('slug' => "fri", 'full' => __("Friday", $this -> plugin_name)),
	6			=>	array('slug' => "sat", 'full' => __("Saturday", $this -> plugin_name)),
	0			=>	array('slug' => "sun", 'full' => __("Sunday", $this -> plugin_name)),
);

/* Custom field types */
$fieldtypes = array(
	'text'				=>	__('Text Input', $this -> plugin_name),
	'textarea'			=>	__('Text Area', $this -> plugin_name),
	'select'			=>	__('Select Drop Down', $this -> plugin_name),
	'checkbox'			=>	__('Checkboxes List', $this -> plugin_name),
	'radio'				=>	__('Radio Buttons', $this -> plugin_name),
	'file'				=>	__('File Upload', $this -> plugin_name),
	'pre_date'			=>	__('Date Picker', $this -> plugin_name)
);

$import_fields = array(
	'code'				=>	array('title' => __('Code/SKU', $this -> plugin_name), 'description' => __('Unique stock code or SKU for your product.', $this -> plugin_name)),
	'title'				=>	array('title' => __('Title', $this -> plugin_name), 'required' => true, 'description' => __('Title/name of your product.', $this -> plugin_name)),
	'description'		=>	array('title' => __('Description', $this -> plugin_name), 'required' => true, 'description' => __('Description of your product, it may contain HTML.', $this -> plugin_name)),
	'keywords'			=>	array('title' => __('Keywords', $this -> plugin_name), 'description' => __('Comma (,) separated keywords/tags.', $this -> plugin_name)),
	'image'				=>	array('title' => __('Image', $this -> plugin_name), 'description' => __('An image (jpg, png, gif) name or full URL of your product.', $this -> plugin_name)),
	'price'				=>	array('title' => __('Price', $this -> plugin_name), 'description' => __('Retail price of your product eg. 9.99', $this -> plugin_name)),
	'sprice'			=>	array('title' => __('Suggested Price', $this -> plugin_name), 'description' => __('Suggested retail price of your product eg. 12.99', $this -> plugin_name)),
	'wholesale'			=>	array('title' => __('Wholesale Price', $this -> plugin_name), 'description' => __('Wholesale price of your product for internal use only.', $this -> plugin_name)),
	'type'				=>	array('title' => __('Product Type', $this -> plugin_name), 'description' => __('Either "digital" or "tangible" product type.', $this -> plugin_name)),
	'min_order'			=>	array('title' => __('Minimum Order', $this -> plugin_name), 'description' => __('Minimum allowed quantity that can be ordered.', $this -> plugin_name)),
	'inventory'			=>	array('title' => __('Inventory/Stock', $this -> plugin_name), 'description' => __('Inventory/stock for this product. Use -1 for unlimited stock.', $this -> plugin_name)),
	'measurement'		=>	array('title' => __('Measurement', $this -> plugin_name), 'description' => __('Measurement name eg. Unit(s) or Box(es).', $this -> plugin_name)),
	'weight'			=>	array('title' => __('Weight', $this -> plugin_name), 'description' => __('Numeric/integer value for the weight of the product.', $this -> plugin_name)),
	'categories'		=>	array('title' => __('Categories', $this -> plugin_name), 'required' => true, 'description' => __('Comma separated category names/titles. If they do not exist, they will be created.', $this -> plugin_name)),
);

global $paymentfields, 
$globalpoptions, 
$us_states, 
$ups_pickuptypes,
$lengthmeasurements;

$allpaymentmethods = array('tc', 'amazonfps', 'apco', 'authorize_aim', 'bw', 'bartercard', 'bluepay', 'cc', 'cu', 'ematters', 'eupayment', 'eway_shared', 'fdapi', 'fd', 'google_checkout', 'ipay', 'lucy', 'mb', 'monsterpay', 'netcash', 'ogone_basic', 'pp', 'payxml', 'pp_pro', 'sagepay', 'securetrading', 're', 're_remote', 'stripe', 'virtualmerchant', 'worldpay', 'dps');

$ups_pickuptypes = array(
	'01' => 'Daily Pickup',
	'03' => 'Customer Counter',
	'06' => 'One Time Pickup',
	'07' => 'On Call Air',
	'11' => 'Suggested Retail Rates',
	'19' => 'Letter Center',
	'20' => 'Air Service Center',
);

/* Length Measurement Units */
$lengthmeasurements = array(
	'cm'				=>	__('Centimeter', $this -> plugin_name),
	'ft'				=>	__('Feet (Foot)', $this -> plugin_name),
	'in'				=>	__('Inch', $this -> plugin_name),
	'km'				=>	__('Kilometer', $this -> plugin_name),
	'm'					=>	__('Meter', $this -> plugin_name),
	'mm'				=>	__('Millimeter', $this -> plugin_name),
	'yd'				=>	__('Yard', $this -> plugin_name),
);

$us_states = array(
	'AL' => 'Alabama',
	'AK' => 'Alaska',
	'AZ' => 'Arizona',
	'AR' => 'Arkansas',
	'CA' => 'California',
	'CO' => 'Colorado',
	'CT' => 'Connecticut',
	'DE' => 'Delaware',
	'' => 'District of Columbia',
	'FL' => 'Florida',
	'GA' => 'Georgia',
	'HI' => 'Hawaii',
	'ID' => 'Idaho',
	'IL' => 'Illinois',
	'IN' => 'Indiana',
	'IA' => 'Iowa',
	'KS' => 'Kansas',
	'KY' => 'Kentucky',
	'LA' => 'Louisiana',
	'ME' => 'Maine',
	'MD' => 'Maryland',
	'MA' => 'Massachusetts',
	'MI' => 'Michigan',
	'MN' => 'Minnesota',
	'MS' => 'Mississippi',
	'MO' => 'Missouri',
	'MT' => 'Montana',
	'NE' => 'Nebraska',
	'NV' => 'Nevada',
	'NH' => 'New Hampshire',
	'NJ' => 'New Jersey',
	'NM' => 'New Mexico',
	'NY' => 'New York',
	'NC' => 'North Carolina',
	'ND' => 'North Dakota',
	'OH' => 'Ohio',
	'OK' => 'Oklahoma',
	'OR' => 'Oregon',
	'PA' => 'Pennsylvania',
	'RI' => 'Rhode Island',
	'SC' => 'South Carolina',
	'SD' => 'South Dakota',
	'TN' => 'Tennessee',
	'TX' => 'Texas',
	'UT' => 'Utah',
	'VT' => 'Vermont',
	'VA' => 'Virginia',
	'WA' => 'Washington',
	'WV' => 'West Virginia',
	'WI' => 'Wisconsin', 
	'WY' => 'Wyoming',
	'AA' => 'US Armed Forces - Americas',
	'AE' => 'US Armed Forces - Europe',
	'AP' => 'US Armed Forces - Pacific',
);

$globalpoptions = array('cart' => __('Shopping Cart', $this -> plugin_name), 'ship' => __('Shipping', $this -> plugin_name), 'bill' => __('Billing', $this -> plugin_name));

$paymentfields = array(
	'shipping'			=>	array(
		'fname'				=>	array(
			'title'				=>	__('First Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'lname'				=>	array(
			'title'				=>	__('Last Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'email'				=>	array(
			'title'				=>	__('Email Address', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'company'			=>	array(
			'title'				=>	__('Company Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'phone'				=>	array(
			'title'				=>	__('Phone Number', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'fax'				=>	array(
			'title'				=>	__('Fax Number', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'address'			=>	array(
			'title'				=>	__('Address', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'address2'			=>	array(
			'title'				=>	__('Address (continued)', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'city'				=>	array(
			'title'				=>	__('City', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'country'			=>	array(
			'title'				=>	__('Country', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'state'				=>	array(
			'title'				=>	__('State/Province', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'zipcode'			=>	array(
			'title'				=>	__('Zip/Postal Code', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
	),
	'billing'			=>	array(
		'fname'				=>	array(
			'title'				=>	__('First Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'lname'				=>	array(
			'title'				=>	__('Last Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'email'				=>	array(
			'title'				=>	__('Email Address', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'company'			=>	array(
			'title'				=>	__('Company Name', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'phone'				=>	array(
			'title'				=>	__('Phone Number', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'fax'				=>	array(
			'title'				=>	__('Fax Number', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'address'			=>	array(
			'title'				=>	__('Address', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'address2'			=>	array(
			'title'				=>	__('Address (continued)', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	0,
		),
		'city'				=>	array(
			'title'				=>	__('City', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),		
		'country'			=>	array(
			'title'				=>	__('Country', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'state'				=>	array(
			'title'				=>	__('State/Province', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
		'zipcode'			=>	array(
			'title'				=>	__('Zip/Postal Code', $this -> plugin_name),
			'show'				=>	1,
			'required'			=>	1,
		),
	),
); 

?>