# NYPL Barcode Service

This package is intended to be used as a Lambda-based Barcode Service using the [NYPL PHP Microservice Starter](https://github.com/NYPL/php-microservice-starter).

This package adheres to [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/), and [PSR-4](http://www.php-fig.org/psr/psr-4/) (using the [Composer](https://getcomposer.org/) autoloader).

## Installation

* Initialize the `Config` class.

## Requirements

* PHP >=7.0

## Features

## Usage

#### Basic Example

Create an `index.php` with a `Service` object and your [Slim](http://www.slimframework.com/) routes:

~~~~
Config::initialize(__DIR__ . '/config');

$service = new NYPL\Starter\Service();

$service->get("/v0.1/bibs", function (Request $request, Response $response) {
    $controller = new Controller\BibController($request, $response);
    return $controller->getBibs();
});
~~~~

Configure your web server to load `index.php` on all requests.
See the `samples/service-config` directory for sample configuration files for an Apache `.htaccess` or Nginx `nginx.conf` installation.

### Swagger Documentation Generator

Create a Swagger route to generate Swagger specification documentation:

~~~~
$service->get("/swagger", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(__DIR__ . "/src", $response);
});
~~~~
