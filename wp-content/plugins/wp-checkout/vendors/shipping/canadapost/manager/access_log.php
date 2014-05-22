<? 
	if( !defined( "CANSHIP_DIR" ) )  
		define( "CANSHIP_DIR", dirname(__FILE__) ) ;
	define( "ACCESS_LOG_FILE", CANSHIP_DIR . "/manager/access_log.data.php" );
	access_log();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - -	
	function	access_log(){
		$hFile = fopen( ACCESS_LOG_FILE, "a+" );
		if( $hFile ):
			$line = date( "Y-m-d" ) . "\t" . date("H:i:s") .
			                                   "\t" . getEnv("REMOTE_ADDR") . 
											   "\t" . getEnv("HTTP_USER_AGENT" ) .
			                                   "\t" . getEnv("SCRIPT_NAME") .
			                                   "\t" . getEnv("HTTP_REFERER") ; 
			$nBytes = fputs( $hFile, $line . "\r\n" );
			fclose( $hFile );
			return $nBytes;
		endif;
		return 0;
	}
?>