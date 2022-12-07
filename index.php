<?php

// silence
use Utility\Chip;

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'vendor/autoload.php';
defined('BASE_DIR') or define('BASE_DIR', __DIR__);
try {
    Chip::getInstance()->init();
} catch (Exception $e) {
}
