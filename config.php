<?php
/**
 * PEP Capping 2017 Algozzine's Class
 *
 * Configures global constants and other system functions
 * that will not be changed once started.
 *
 * This file is useful for initializing constants that are used
 * throughout the application but need a common place to be stored.
 * While similar to the bootstrap.php file, this file does not contain
 * class configuration, just variable constants.
 *
 * @author Jack Grzechowiak
 * @copyright 2017 Marist College
 * @version 0.1.3
 * @since 0.1.3
 */

define('BASEPATH', __DIR__);
define('BASEURL', '');
define('VERSION', exec('git describe --tags --abbrev=0') ?: '[No Tag]');

error_reporting(E_ALL);
//error_reporting(0);
// TODO: turn off error reporting in production

function errorHandler($errno, $errstr) {
    global $err, $errst;
    $err = $errno;
    $errst = $errstr;
    require('../views/errors/error.php');
    die();
}

set_error_handler("errorHandler");