<?php

class wpcolucycardtxn extends wpCheckoutPlugin {
	
	var $xmlparse = array();

  function _construct() {

    $this -> postdata = '';

  }  /*  end function  */

  function CURLTxn($txn_type, $card_number, $expy_dt, $mag_data, $name, $amt, $invoice, $pnref, $zip, $street, $cvnum, $ext_data) {

   //$this -> base = 'https://payments.cynergydata.com/SmartPayments/transact2.asmx/ProcessCreditCard';
   //$this -> userid = 'USERID';
   //$this -> password = 'PASSWORD';
   $data = '';

   $this -> postdata = array('UserName'=>$this->userid,
              	  'Password' => $this -> password,
              	  'TransType' => $txn_type,
              	  'CardNum' => $card_number,
	      	        'ExpDate'=>$expy_dt,
		              'MagData'=>$mag_data,
		              'NameOnCard'=>$name,
		              'Amount'=>$amt,
		              'InvNum'=>$invoice,
		              'PNRef'=>$pnref,
		              'Zip'=>$zip,
		              'Street'=>$street,
		              'CVNum'=>$cvnum,
		              'ExtData'=>$ext_data);

		// concatenate this->postdata and put into variable
		while(list($key, $value) = each($this->postdata)) 
    {  $data .= $key . '=' . urlencode($value) . '&';
		  }
		// Remove the last "&" from the string
		$data = substr($data, 0, -1);

		// make appropriate copy of data for error-reporting purposes
		$copy_post_data = $this -> postdata;
		
		// mask the CVNum as of processors' best practices
		$copy_post_data['CVNum'] = '****';
		$copy_post_data['UserName'] = '*******';
		$copy_post_data['Password'] = '*******';
		$copy_post_data['CardNum'] = '*******' . substr($copy_post_data['CardNum'], -4);
		$copy_post_data['MagData'] = '*******';

    /*un-comment below to create a log file as well as fclose below and other references to fp*/
    /*the log-file is pci-compliant as it doesnot store or display actual transaction data */ 

/*      $fp = fopen('c:\temp\curl_log.txt','w') or die(php_errormsg);  */
    

    $ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $this -> base);
	curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	/* curl_setopt($ch, CURLOPT_WRITEHEADER, $fp); */
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 300);
	curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE,FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	/* curl_setopt($ch, CURLOPT_STDERR,$fp);  */

  $result = curl_exec($ch);

  $commError = curl_error($ch);
  $commInfo = @curl_getinfo($ch);
		curl_close($ch);

    /* fclose($fp) or die($php_errormsg);  */

    return $result;

  }
  
	function startElement($parser, $name, $attrs) {
		$this -> xmlparse[$name] = $attrs;
	}

	//Function to use at the end of an element
	function endElement($parser, $element_name) {
		//echo "<br />";
	}
	
	//Function to use when finding character data
	function char($parser, $data) {
		//echo $data;
	}
  
	function notify($xml_result = null) {
		$this -> xmlparse = array();
		
		$xmlparser = xml_parser_create();
		//xml_set_element_handler($xmlparser, array($this, "startElement"), array($this, "endElement"));
		//xml_set_character_data_handler($xmlparser, array($this, "char"));
		
		xml_parser_set_option($xmlparser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($xmlparser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($xmlparser, $xml_result, $vals, $index);
		xml_parser_free($xmlparser);
		
		return $this -> buildresult($vals);
	}
	
	function buildresult($vals = null) {
		$resultarray = array();
		
		if (!empty($vals)) {
			foreach ($vals as $val) {
				$resultarray[$val['tag']] = $val['value'];
			}
		}
		
		return $resultarray;
	}

}
 
?>