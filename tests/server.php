<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Serve static files
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . '/../web' . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']))) {
	return false;
}

include __DIR__ . '/../web/index.php';
