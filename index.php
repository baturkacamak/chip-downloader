<?php

// Import the 'Chip' class from the 'Utility' namespace
use Utility\Chip;

// Enable error reporting and display of errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the Composer autoloader
include_once 'vendor/autoload.php';

// Define the BASE_DIR constant
defined('BASE_DIR') or define('BASE_DIR', __DIR__);

try {
    // Initialize the Chip class
    Chip::getInstance()->init();
} catch (Exception $e) {
    // Do nothing if an exception is thrown
}
