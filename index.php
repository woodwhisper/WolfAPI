<?php
/**
 * Index.php for Wolfapi.
 *
 * WolfAPI V 0.0.1
 *
 * WolfAPI is a simple PHP based API designed to allow simple API only requests.
 * As such there is no native view support, everything goes through JSON only.
 */
    ini_set('display_errors', 1);
    error_reporting(~0);
    include 'core/src/Core.php';
    ob_start();
    $runner = \WolfAPI\Core::getInstance();
    $runner->run();
