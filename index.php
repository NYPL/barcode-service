<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;

Config::initialize(__DIR__ . '/config');

$service = new Service();

$service->get("/docs/barcode", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(
        [__DIR__ . "/src", __DIR__ . "/vendor/nypl/microservice-starter/src"],
        $response
    );
});

$service->get("/api/v0.1/patrons/{id}/barcode", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\PatronController($request, $response);
    return $controller->getBarcode($parameters["id"]);
});

$service->run();
