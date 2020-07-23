<?php 
/** 
* Configuration for database connection
*
*/
$host 		= "sql211.ezyro.com";
$username 	= "ezyro_26288695";
$password   = "ocna7a894h";
$dbname     = "ezyro_26288695_lottery_db";
$dsn        = "mysql:host=$host; dbname=$dbname";
$options    = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
	);