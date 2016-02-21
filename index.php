<?php
/**
 * Index.php for Wolfapi.
 *
 * WolfAPI V 0.0.1
 *
 * WolfAPI is a simple PHP based API designed to allow simple API only requests.
 * As such there is no native view support, everything goes through JSON only.
 */

    include 'core/src/Core';
    $runner = \WolfAPI\Core::getInstance();
    $runner->run();
    $runner->output();
