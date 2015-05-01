<?php

namespace Utility;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Utility\Exception\ValidationExceptionSet;
use Utility\Response\Factory\ErrorResponseFactoryInterface;

/**
 * Class RequestHandler
 */
final class RequestHandler
{

    /**
     * @var RequestMatcherInterface
     */
    private $urlMatcher;

    /**
     * @var ErrorResponseFactoryInterface
     */
    private $errorResponseFactory;

    /**
     * @var ContainerInterface
     */
    private $serviceContainer;

    /**
     * @param RequestMatcherInterface|UrlMatcherInterface $urlMatcher
     * @param ErrorResponseFactoryInterface $errorResponseFactory
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(RequestMatcherInterface $urlMatcher, ErrorResponseFactoryInterface $errorResponseFactory, ContainerInterface $serviceContainer)
    {
        $this->urlMatcher = $urlMatcher;
        $this->errorResponseFactory = $errorResponseFactory;
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param HttpRequest $httpRequest
     *
     * @return Response
     */
    public function handle(HttpRequest $httpRequest)
    {
        try {
            $routeParameters = $this->urlMatcher->matchRequest($httpRequest);

            $request = $this->extractRequestFromRouteParameters($routeParameters);
            $controller = $this->extractControllerFromRouteParameters($routeParameters);

            return $controller->handleRequest($request, $this->serviceContainer);
        } catch (ValidationExceptionSet $exception) {
            return $this->errorResponseFactory->createBadRequestResponse($exception);
        } catch (BadRequestHttpException $exception) {
            return $this->errorResponseFactory->createBadRequestResponse($exception);
        }  catch (NotFoundHttpException $exception) {
            return $this->errorResponseFactory->createNotFoundResponse($exception);
        } catch (MethodNotAllowedException $exception) {
            return $this->errorResponseFactory->createMethodNotAllowedResponse($exception);
        } catch (\Exception $exception) {
            return $this->errorResponseFactory->createInternalServerErrorResponse($exception);
        }
    }

    /**
     * @param array $routeParameters
     *
     * @return Request
     */
    private function extractRequestFromRouteParameters(array $routeParameters)
    {
        if (array_key_exists('_request', $routeParameters) === false) {
            throw new \UnexpectedValueException("Route '{$routeParameters['_route']}' does not have a '_request' key defined");
        }

        $request = $this->serviceContainer->get($routeParameters['_request']);

        if (($request instanceof Request) === false) {
            throw new \UnexpectedValueException('Request should be an instance of Utility\Request');
        }

        return $request;
    }

    /**
     * @param array $routeParameters
     *
     * @return ControllerInterface
     */
    private function extractControllerFromRouteParameters(array $routeParameters)
    {
        if (array_key_exists('_controller', $routeParameters) === false) {
            throw new \UnexpectedValueException("Route '{$routeParameters['_route']}' does not have a '_controller' key defined");
        }

        $controller = $this->serviceContainer->get($routeParameters['_controller']);

        if (($controller instanceof ControllerInterface) === false) {
            throw new \UnexpectedValueException('Controller should be an implementation of Utility\ControllerInterface');
        }

        return $controller;
    }
}
