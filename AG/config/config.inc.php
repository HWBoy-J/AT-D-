<?php
$DBMS = 'MySQL';

$_DVWA = array();
$_DVWA[ 'db_server' ]   = getenv('DB_SERVER') ?: '127.0.0.1';
$_DVWA[ 'db_database' ] = 'root';
$_DVWA[ 'db_user' ]     = 'root';
$_DVWA[ 'db_password' ] = 'root';
$_DVWA[ 'db_port']      = '3306';

$_DVWA[ 'recaptcha_public_key' ]  = '6LdJJlUUAAAAAH1Q6cTpZRQ2Ah8VpyzhnffD0mBb';
$_DVWA[ 'recaptcha_private_key' ] = '6LdJJlUUAAAAAM2a3HrgzLczqdYp4g05EqDs-W4K';


$_DVWA[ 'default_security_level' ] = 'impossible';


$_DVWA[ 'default_locale' ] = 'en';


$_DVWA[ 'disable_authentication' ] = false;

define ('MYSQL', 'mysql');
define ('SQLITE', 'sqlite');


$_DVWA['SQLI_DB'] = MYSQL;

?>
