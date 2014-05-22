<?php

class wpcoematters extends wpCheckoutPlugin {

	function wpcoematters() {
		return;
	}
	
	function responsetext($code = null) {	
		switch ($code){
			case 8:
				$text = 'Processed Succesfuly' ;
				break;
			case 1:
				$text = 'See card issuer' ;
				break;
			case 4:
				$text = 'Call authorisation centre. (Possible causes: Card has been reported Lost, Stolen or Blocked) ';
				break;
			case 12:
				$text = 'Invalid transaction type. (Possible causes:(i) Amex was processed but Merchant does not accept	Amex, (ii) Card is not allowed to be used over the Internet (iii) Wrong CCV)' ;
				break;
			case 31:
				$text = 'See card issuer';
				break;
			case 33:
				$text = 'Card Expired or Expiry date incorrect' ;
				break;
			case 51:
				$text = 'Insufficient funds.' ;
				break;
			case 61:
				$text = 'Over card refund limit.' ;
				break;
			case 91:
				$text = 'Issuer not available (The cardholder‟s bank is currently offline. Try later.)' ;
				break;
			case 96:
				$text = 'CVV invalid or missing' ;
				break;
			case 702:
				$text = 'Transaction(with same ID)  still underway' ;
				break;
			case 707:
				$text = '3SO Activated – too many failed attempts' ;
				break;
			case 708:
				$text = 'Non-Unique UID – Already accepted' ;
				break;
			case 710:
				$text = 'IGP Activated – transaction from high risk country' ;
				break;
			case 711:
				$text = 'IGP Activated – IP Address Not Valid' ;
				break;
			case 712:
				$text = 'Fraud Screen block – IP and Bank not matching.' ;
				break;
			case 714:
				$text = 'Card from outside acceptable country range' ;
				break;
			case 810:
				$text = 'Invalid Purchase Amount' ;
				break;
			case 812:
				$text = 'Unacceptable Card Number' ;
				break;
			case 813:
				$text = 'Invalid Expiry Date Format' ;
				break;
			case 816:
				$text = 'Card Expired' ;
				break;
			case 817:
				$text = 'Invalid Merchant Details' ;
				break;
			case 871:
				$text = 'Nothing Found' ;
				break;
			case 872:
				$text = 'Too Many Found' ;
				break;
			case 873:
				$text = 'Exceeds Original Amount' ;
				break;
			case 874:
				$text = 'Already Refunded' ;
				break;
			case 875:
				$text = 'Wrong Credentials' ;
				break;
			case 878:
				$text = 'Incorrect UID Format' ;
				break;
			case 901:
				$text = 'H-Check Failed – URLs do not match' ;
				break;
			case 902:
				$text = 'Readers set to an incorrect value in POSTed Transaction' ;
				break;
			case 903:
				$text = 'Readers missing in POSTed transaction' ;
				break;
			case 904:
				$text = 'MerchantID missing in POSTed transaction' ;
				break;
			case 910:
				$text = 'Transaction Aborted' ;
				break;
			case 911:
				$text = 'XML Error' ;
				break;
			case 919:
				$text = 'Dodgy Details' ;
				break;
			case 921:
				$text = 'BlackList Invoked' ;
				break;
			case 932:
				$text = 'Bad Posting Password' ;
				break;
			case 980:
				$text = 'Host Not Found, Bank System out of action' ;
				break;
			case 990:
				$text = 'Carrier Lost, Bank line down' ;
				break;
			case 999:
				$text = 'Bad Card Length – Too Short' ;
				break;
			case 'xx':
				$text = 'The transaction is still at the bank and we are waiting for a response.' ;
				break;
			default:
				$text = 'Error code no. :' . $code ;
				break;
		}
		
		return $text;
	}
}

?>