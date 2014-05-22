<? 
// - - - Setup runging eveivronment	
	if( ! isset($_POST) && isset($HTTP_POST_VARS) ) $_POST =& $HTTP_POST_VARS;
	if( ! isset($_GET) && isset($HTTP_GET_VARS) ) $_GET =& $HTTP_GET_VARS;
	if( ! isset($_COOKIE) && isset($HTTP_COOKIE_VARS) ) $_COOKIE =& $HTTP_COOKIE_VARS;
	if( ! isset($_FILES) && isset($HTTP_POST_FILES) ) $_FILES =& $HTTP_POST_FILES;
	if( ! isset($_SESSION) && isset($HTTP_SESSION_VARS) ) $_SESSION =& $HTTP_SESSION_VARS;
   	set_magic_quotes_runtime(0);
	//error_reporting( E_ALL ^ E_NOTICE );

	// getEnv("DOCUMENT_ROOT") not always works in virtual hosting
	//define( "DOCUMENT_ROOT", getDocumentRoot() );

// - - - Begin: define ISDEBUG variable for include different porgrams( debug or releasing mode ) - - - - - - - - - - - - - -
	define( "ISDEBUG", false );
	define( "DEBUGER_EMAIL", "s6software@users.sourceforge.net" );

	define( "CANSHIP_DIR", dirname(__FILE__) );
// - - - - - - - - - - - - Begin : include files - - - - - - - - - 
	//$sIncludesPath =  CANSHIP_DIR . ( ISDEBUG  ?  "/includes.debug/" : "/includes/" );
	$sIncludesPath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
	require_once( $sIncludesPath . "config.php" ); 
	require_once( $sIncludesPath ."minixml/minixml.inc.php" );
	require_once( $sIncludesPath ."local.php" );
	//require_once( $sIncludesPath ."canadapost.php" );
// - - - - - - - - - - - - End : include files - - - - - - - - - 
	require_once( CANSHIP_DIR . "/manager/access_log.php" );


// ======================================================================
	function getDocumentRoot(){
		//return getEnv("DOCUMENT_ROOT"); // Not always work
		$script_filename = strlen(getEnv("SCRIPT_FILENAME")) ? getEnv("SCRIPT_FILENAME") : getEnv("PATH_TRANSLATED") ;
		return substr( $script_filename,  0,  strlen($script_filename) -  strlen(getEnv("SCRIPT_NAME"))) ;
	}

?>