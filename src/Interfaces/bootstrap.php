<?php

require_once __DIR__.'/../../vendor/autoload.php';

ini_set('display_errors', true);
ini_set('display_startup_errors', true);

use RayRutjes\DomainFoundation\Example\Application\Application;

//---------------------------------------//
//  UPDATE THIS TO FIT YOUR ENVIRONMENT  //
$server = '127.0.0.1';
$port = 3306;
$databaseName = 'domain_foundation_silly';
$username = 'root';
$password = '';
//---------------------------------------//

$app = Application::instance($server, $port, $databaseName, $username, $password);
