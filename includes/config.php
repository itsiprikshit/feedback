<?php
/*
define("conn_error","Could not connect !");
define("mysql_host","localhost");
define("mysql_user","root");
define("mysql_pass","");
define("mysql_db","feedback");
*/
define("conn_error","Could not connect !");
define("mysql_host",getenv('OPENSHIFT_MYSQL_DB_HOST'));
define("mysql_user",getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define("mysql_pass",getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define("mysql_db","feedback");
/*
define('DB_HOST',getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT')); 
define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
*/
?>
