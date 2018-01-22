<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))
	die('require PHP > 5.3.0 !');

define('APP_DEBUG',true);

define('APP_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR.'Application'.DIRECTORY_SEPARATOR);

define('RUNTIME_PATH', dirname(APP_PATH).DIRECTORY_SEPARATOR.'Runtime'.DIRECTORY_SEPARATOR);

require '../ThinkPHP/ThinkPHP.php';