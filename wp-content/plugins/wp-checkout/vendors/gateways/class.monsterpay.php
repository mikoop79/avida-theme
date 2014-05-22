<?php

class wpcomonsterpay extends wpCheckoutPlugin {
	
	var $tnxid;
	var $checksum;
	var $parity;
	
	var $identifier;
	var $usrname;
	var $pwd;

	function wpcomonsterpay() {
		return;
	}
	
	function wddx_deserialize($xmlpacket) 
	{
		if ($xmlpacket instanceof SimpleXMLElement) 
		{
			if (!empty($xmlpacket->struct)) 
			{
				$struct = array();
				foreach ($xmlpacket->xpath("struct/var") as	$var) 
				{
					if (!empty($var["name"])) {
					$key = (string) $var["name"];
					$struct[$key] = wddx_deserialize($var);
					}
				}
				return $struct;
			}
			elseif (!empty($xmlpacket->array)) {
				$array = array();
				foreach ($xmlpacket->xpath("array/*") as $var) {
					array_push($array, wddx_deserialize($var));
				}
				return $array;
			}
			else if (!empty($xmlpacket->string)) {
				return (string) $xmlpacket->string;
			} 
			else if (!empty($xmlpacket->number)) {
				return (int) $xmlpacket->number;
			} 
			else {
				if (is_numeric((string) $xmlpacket)) {
				return (int) $xmlpacket;
				} else {
				return (string) $xmlpacket;
				}
			}
	  }
	  else 
	  {
		$sxe = simplexml_load_string($xmlpacket);
		$datanode = $sxe->xpath("/wddxPacket[@version='1.0']/data");
		return wddx_deserialize($datanode[0]);
	  }	
  }
	
	function request() {		
		$monsterpay_string = 'method=' . 'order_synchro' .
		'&identifier=' . $this -> identifier .
		'&usrname=' . $this -> usrname .
		'&pwd=' . $this -> pwd .
		'&tnxid=' . $this -> tnxid .
		'&checksum=' . $this -> checksum .
		'&parity=' . $this -> parity;

		$monsterpay_url = "https://www.monsterpay.com/secure/components/synchro.cfc?wsdl";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $monsterpay_url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $monsterpay_string);
		$monsterpay_result = curl_exec($ch);
		
		$monsterpay_wddx = trim($monsterpay_result);
		$monsterpay_xml = $this -> wddx_deserialize($monsterpay_wddx);
		$xmldata = html_entity_decode($monsterpay_xml);
		$xmldata = str_replace("<wddxPacket version='1.0'><header/><data><string>", "", $xmldata);
		$monsterpay_xml = str_replace("</string></data></wddxPacket>", "", $xmldata);
		$order_synchro = simplexml_load_string($monsterpay_xml);
		
		return $order_synchro;
	}
}

?>