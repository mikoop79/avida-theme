<?php

/* FedEx (Federal Express) */

/*
EUROPE_FIRST_INTERNATIONAL_PRIORITY 
FEDEX_1_DAY_FREIGHT
FEDEX_2_DAY
FEDEX_2_DAY_AM
FEDEX_2_DAY_FREIGHT
FEDEX_3_DAY_FREIGHT
FEDEX_EXPRESS_SAVER
FEDEX_FIRST_FREIGHT
FEDEX_FREIGHT_ECONOMY 
FEDEX_FREIGHT_PRIORITY 
FEDEX_GROUND
FIRST_OVERNIGHT
GROUND_HOME_DELIVERY 
INTERNATIONAL_ECONOMY 
INTERNATIONAL_ECONOMY_FREIGHT 
INTERNATIONAL_FIRST
INTERNATIONAL_PRIORITY 
INTERNATIONAL_PRIORITY_FREIGHT 
PRIORITY_OVERNIGHT
SMART_POST
STANDARD_OVERNIGHT
*/

$fedexService['SMART_POST']				= 'FedEx Smart Post';
$fedexService['PRIORITY_OVERNIGHT']     = 'FedEx Priority Overnight';
$fedexService['STANDARD_OVERNIGHT']     = 'FedEx Standard Overnight';
$fedexService['FIRST_OVERNIGHT']        = 'FedEx First Overnight';
$fedexService['FEDEX_2_DAY']             = 'FedEx 2 Day';
$fedexService['FEDEX_2_DAY_AM']			= 'FedEx 2 Day AM';
$fedexService['FEDEX_EXPRESS_SAVER']     = 'FedEx Express Saver';
$fedexService['INTERNATIONAL_PRIORITY'] = 'FedEx International Priority';
$fedexService['INTERNATIONAL_ECONOMY']  = 'FedEx International Economy';
$fedexService['INTERNATIONAL_FIRST']    = 'FedEx International First';
$fedexService['FEDEX_FIRST_FREIGHT']	= 'FedEx First Freight';
$fedexService['FEDEX_FREIGHT_ECONOMY']	= 'FedEx Freight Economy';
$fedexService['FEDEX_FREIGHT_PRIORITY']	= 'FedEx Freight Priority';
$fedexService['FEDEX_1_DAY_FREIGHT']      = 'FedEx Overnight Freight';
$fedexService['FEDEX_2_DAY_FREIGHT']      = 'FedEx 2 day Freight';
$fedexService['FEDEX_3_DAY_FREIGHT']      = 'FedEx 3 day Freight';
$fedexService['FEDEX_GROUND']           = 'FedEx Ground';
$fedexService['GROUND_HOME_DELIVERY']    = 'FedEx Home Delivery';
$fedexService['INTERNATIONAL_PRIORITY_FREIGHT'] = 'FedEx International Priority Freight';
$fedexService['INTERNATIONAL_ECONOMY_FREIGHT'] = 'FedEx International Economy Freight';
$fedexService['EUROPE_FIRST_INTERNATIONAL_PRIORITY'] = 'FedEx Europe First International Priority';

$this -> update_option('fedex_services', $fedexService);

$fedexTransitTime['EIGHTEEN_DAYS'] = '18 Days';
$fedexTransitTime['EIGHT_DAYS'] = '8 Days';
$fedexTransitTime['ELEVEN_DAYS'] = '11 Days';
$fedexTransitTime['FIFTEEN_DAYS'] = '15 Days'; 
$fedexTransitTime['FIVE_DAYS'] = '5 Days'; 
$fedexTransitTime['FOURTEEN_DAYS'] = '14 Days'; 
$fedexTransitTime['FOUR_DAYS'] = '4 Days'; 
$fedexTransitTime['NINETEEN_DAYS'] = '19 Days'; 
$fedexTransitTime['NINE_DAYS'] = '9 Days'; 
$fedexTransitTime['ONE_DAY'] = '1 Day';
$fedexTransitTime['SEVENTEEN_DAYS'] = '17 Days'; 
$fedexTransitTime['SEVEN_DAYS'] = '7 Days'; 
$fedexTransitTime['SIXTEEN_DAYS'] = '16 Days'; 
$fedexTransitTime['SIX_DAYS'] = '6 Days'; 
$fedexTransitTime['TEN_DAYS'] = '10 Days'; 
$fedexTransitTime['THIRTEEN_DAYS'] = '13 Days'; 
$fedexTransitTime['THREE_DAYS'] = '3 Days'; 
$fedexTransitTime['TWELVE_DAYS'] = '12 Days'; 
$fedexTransitTime['TWENTY_DAYS'] = '20 Days'; 
$fedexTransitTime['TWO_DAYS'] = '2 Days'; 
$fedexTransitTime['UNKNOWN'] = 'Unknown';

?>