<?
	error_reporting( E_ALL ^ E_NOTICE );
	if( ! defined( "DOCUMENT_ROOT" ) ) 	{
		$script_filename = strlen(getEnv("SCRIPT_FILENAME")) ? getEnv("SCRIPT_FILENAME") : getEnv("PATH_TRANSLATED") ;
		define( "DOCUMENT_ROOT", substr( $script_filename,  0,  strlen($script_filename) -  strlen(getEnv("SCRIPT_NAME")))  );
	}

	if( !defined("FILE_DEBUG_IPS") ) define( "FILE_DEBUG_IPS", DOCUMENT_ROOT . "/manager/debugips.txt" );
	if( $HTTP_POST_VARS["submitted"] ):
		$hFile  = fopen( FILE_DEBUG_IPS, "w" );
		if( $hFile ) :
			fwrite( $hFile, join( "\r\n", $HTTP_POST_VARS["ip"] ) );
			fclose( $hFile );
		endif;
	endif;

	define( "ISDEBUG", isDebugMode() );
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title>Debug Mode Manager</title>

<style type="text/css">
	a {
		text-decoration : none;
		color : #003366;
	}
	
	a:hover {
		text-decoration : underline;
	}
	
	body, input, td, textarea, select {
		font-family : Verdana, Arial;
		font-size : 8pt;
	}
	
	body {
		margin : 0px;
		color : #000000;
		background : #FFFFFF;
	}
</style>		
</head>

<body>
<? debugWarnning(); ?>
<br><br><br>
<form action="<?= getEnv( "SCRIPT_NAME" )?>" method="post">
<input type="hidden" name="submitted" value="Y">
<table cellpadding="0" cellspacing="0" border="0" align="center" width="400">
<tr><td colspan=2 align="right">[ <a href='/'>Home</a> ]<br><br></td></tr>
<tr><td colspan=2><h3>Debug/Preview Mode Manager</h3></td></tr>
<tr><td width=200>IP</td><td width="100">Enable</td></tr>
<tr><td colspan=2><hr style='height:1px;'></td></tr>
<?
	$aIPs = file( FILE_DEBUG_IPS );
	$remoteIP = getEnv( "REMOTE_ADDR" );
	$found = false ;
	
	if( is_array($aIPs) ) :
		foreach( $aIPs as $ip  ){
			if( strlen(trim($ip)) ):
				if( trim($ip) == $remoteIP ) $found = true ;
				print "<tr><td>" . ( trim($ip) == $remoteIP ? "<b>$ip<br>Your Machine</b>" : "$ip" ) . "</td><td><input type='checkbox' name='ip[]' value='" . htmlspecialchars($ip) . "' checked></td></tr>\n" ;
				print "<tr><td colspan=2><hr style='height:1px;'></td></tr>\n" ;
			endif;
		}
	endif;

	if( !$found ) :
		print "<tr><td><b>$remoteIP<br>Your Machine</b></td><td><input type='checkbox' name='ip[]' value='" . htmlspecialchars($remoteIP) . "'></td></tr>" ;
		print "<tr><td colspan=2><hr style='height:1px;'></td></tr>\n" ;
	endif;
	
?>
<tr><td>Add Your Client's IP:</td><td><input type="Text" name="ip[]" value=""></td></tr>
<tr><td colspan=2><hr style='height:1px;'></td></tr>
<tr><td colspan=2><input type="Submit" value="Update"></td></tr>
<tr>
	<td colspan=2>
		<br><br>
		<b>Don't you think this is a great idea?</b>
		<p>
		I think it is. :)
		<p>
		 Picture this: if the web site you developed need some changes, like the shipping cost formula, more buttons to the site header... Normally those are Libs included by every page. What you gonna do? Copy the whole site to your test bed? You need a lots of copying and setting, and sync the changes to the live site after finish those modification.
		<p>
		My solution is to use this tool. The web site detect the remote IP to include Libs in a different folder. Simple & flexible!
	</td>
</tr>
</table>
</form>

</body>
</html>
<?
//if( !function_exists("isDebugMode") ) {
	function isDebugMode(){ 
		$aIPs = file( FILE_DEBUG_IPS );
		$remoteIP = getEnv( "REMOTE_ADDR" );
		if( is_array($aIPs) ) :
			foreach( $aIPs as $ip  ){
				if( strlen(trim($ip)) ):
					if( trim($ip) == $remoteIP ) return true ;
				endif;
			}
		endif;
		return false ;
	}
//}
	
//if( !function_exists("debugWarnning") ) {
	function	debugWarnning(){
		if( defined("ISDEBUG") && ISDEBUG == true ) 
		print( "<div style=\"
	background-color: #ffffee;
	border-color: #999999;
	border-style: dotted;
	border-width: 1px;
	color:#ff6600;
	font-weight:bold;
	font-family : Verdana, Arial;
	font-size : 11px;
	padding-top : 5;
	padding-bottom : 5;
\" > &nbsp;&nbsp;&nbsp;&nbsp;Warning : This Machine is Under DEBUG/PREVIEW Mode ! <a href='/manager/debugmode.php'>Turn it off</a>.</div>\n" ) ;
	}
//}	
?>