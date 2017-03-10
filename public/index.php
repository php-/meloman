<?php
use josegonzalez\Dotenv\Loader as Dotenv;
use Radar\Adr\Boot;

use Zend\Diactoros\Response as Response;
use Zend\Diactoros\ServerRequestFactory as ServerRequestFactory;

/**
 * Bootstrapping
 */
require '../vendor/autoload.php';

Dotenv::load([
    'filepath' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env',
    'toEnv' => true,
]);

$_ENV['ROOT_PATH'] = dirname(__DIR__).DIRECTORY_SEPARATOR.'src';


$boot = new Boot();
$adr = $boot->adr([
    'Musapp\Config',
]);

/**
 * Run
 */
$adr->run(ServerRequestFactory::fromGlobals(), new Response());
