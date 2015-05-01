<?php

use Application\Factory\ApplicationServiceContainerFactory;
use Application\Response\Factory\ErrorResponseFactory;
use Application\RouteCollectionFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Utility\RequestHandler;
use Utility\Response\Factory\ErrorResponseFactoryInterface;

require __DIR__ . '/../vendor/autoload.php';

$serviceContainer = (new ApplicationServiceContainerFactory())
    ->createDIContainer();

$routeCollection = (new RouteCollectionFactory())
    ->createRouteCollection();

/** @var Request $httpRequest */
$httpRequest = $serviceContainer->get('request');
if (($httpRequest instanceof Request) === false) {
    throw new \UnexpectedValueException('\'request\' key should provide an instance of Symfony\Component\HttpFoundation\Request');
}

$requestContext = new RequestContext();
$requestContext->fromRequest($httpRequest);

$urlMatcher = new UrlMatcher($routeCollection, $requestContext);

/** @var ErrorResponseFactory $errorResponseFactory */
$errorResponseFactory = $serviceContainer->get('factory.response.error');
if (($errorResponseFactory instanceof ErrorResponseFactoryInterface) === false) {
    throw new \UnexpectedValueException('\'factory.response.error\' should provide an implementation of Utility\Response\Factory\ErrorResponseFactoryInterface');
}

(new RequestHandler($urlMatcher, $errorResponseFactory, $serviceContainer))
    ->handle($httpRequest)
    ->send();
