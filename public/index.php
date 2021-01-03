<?php 
if ($_SERVER['SCRIPT_FILENAME'] == 'C:/wamp64/www/lemonologueduvosgien/public/index.php') {
	require_once('../config/devPc.php');
}
if ($_SERVER['SCRIPT_FILENAME'] == '/Applications/MAMP/htdocs/lemonologueduvosgien/public/index.php') {
	require_once('../config/devMac.php');
}
require_once('../vendor/autoload.php');

session_start();

$router = new \BrunoGrosdidier\Blog\config\Router();
$router->run();
