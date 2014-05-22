<?php

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
$root = __FILE__;
for ($i = 0; $i < 6; $i++) $root = dirname($root);
require_once($root . DS . 'wp-config.php');
require_once(ABSPATH . 'wp-admin' . DS . 'includes' . DS . 'admin.php');
header("Content-Type: text/css");
echo stripslashes(get_option('wpcocustomcsscode'));

?>