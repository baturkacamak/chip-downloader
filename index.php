<?php

// silence
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'vendor/autoload.php';
defined('BASE_DIR') or define('BASE_DIR', __DIR__);
\Utility\Chip::getInstance()->init();
