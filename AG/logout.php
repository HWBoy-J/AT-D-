<?php

define( 'DVWA_WEB_PAGE_TO_ROOT', '' );
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup( array( ) );

if( !dvwaIsLoggedIn() ) {
	dvwaRedirect( 'login.php' );
}

dvwaLogout();
dvwaMessagePush( "你已登出" );
dvwaRedirect( 'login.php' );

?>
