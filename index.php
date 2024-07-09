<?php

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Ensure the current directory is pointing to the front controller's directory
chdir(__DIR__);

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
// $pathsConfig = ($_SERVER["HTTP_HOST"] == "zgames.sa" ) ? FCPATH . 'app_saudi/Config/Paths.php' : FCPATH . 'app/Config/Paths.php';
// if($_SERVER["HTTP_HOST"] == "test.zgames.ae")
// $pathsConfig = FCPATH . 'app_saudi_test/Config/Paths.php';
// $pathsConfig = FCPATH . 'app_saudi/Config/Paths.php';

switch ($_SERVER["HTTP_HOST"]) {
    case "test.zgames.ae":
        # code...
        $pathsConfig = FCPATH . "app_test/Config/Paths.php";
        break;

    case "zgames.sa":
        # code...
        $pathsConfig = FCPATH . "app_saudi_test/Config/Paths.php";
        break;

    case "zgames.qa":
        # code...
        $pathsConfig = FCPATH . "app_qatar/Config/Paths.php";
        break;

    case "zgames.co.za":
        # code...
        $pathsConfig = FCPATH . "app_south_africa/Config/Paths.php";
        break;
    
    default:
        # code...
        $pathsConfig = FCPATH . "app/Config/Paths.php";
        break;
}

// ^^^ Change this if you move your application folder
require realpath($pathsConfig) ?: $pathsConfig;

$paths = new Config\Paths();

// Location of the framework bootstrap file.
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app       = require realpath($bootstrap) ?: $bootstrap;

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is setup, it's time to actually fire
 * up the engines and make this app do its thang.
 */
$app->run();
