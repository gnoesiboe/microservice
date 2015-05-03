<?php

namespace Application\Response\Factory;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Utility\Environment;
use Utility\Exception\ValidationException;
use Utility\Exception\ValidationExceptionSet;
use Utility\Response\Factory\ErrorResponseFactoryInterface;
use Utility\Service\EnvironmentDetectionServiceInterface;

/**
 * Class ErrorResponseFactory
 */
final class ErrorResponseFactory implements ErrorResponseFactoryInterface
{

    /**
     * @var EnvironmentDetectionServiceInterface
     */
    private $environmentDetectionService;

    /**
     * @param EnvironmentDetectionServiceInterface $environmentDetectionService
     */
    public function __construct(EnvironmentDetectionServiceInterface $environmentDetectionService)
    {
        $this->environmentDetectionService = $environmentDetectionService;
    }

    /**
     * @param NotFoundHttpException $exception
     *
     * @return JsonResponse
     */
    public function createNotFoundResponse(NotFoundHttpException $exception)
    {
        $body = array(
            'success' => false,
            'error' => array(
                'global' => $this->environmentDetectionService->isEnvironment(Environment::LOCAL) === true ? $exception->getMessage() : null,
            )
        );

        return new JsonResponse($body, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param BadRequestHttpException $exception
     *
     * @return Response
     *
     * @throws BadRequestHttpException
     */
    public function createBadRequestResponse(BadRequestHttpException $exception)
    {
        $body = array(
            'success' => false,
        );

        if ($exception instanceof ValidationExceptionSet) {
            $body['error']['global'] = 'You have validation errors';

            $body['error']['errors'] = array();

            foreach ($exception->getExceptions() as $key => $validationException) {
                /** @var ValidationException $validationException */

                $body['error']['errors'][$key] = array(
                    'error' => array(
                        'message' => $validationException->getMessage(),
                        'identifier' => $validationException->getIdentifier(),
                    ),
                    'definition' => $validationException->getValidator()->getDefinition(),
                );
            }
        } else {
            $body['error']['global'] = $exception->getMessage();
        }

        return new JsonResponse($body, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param MethodNotAllowedHttpException $exception
     *
     * @return Response
     */
    public function createMethodNotAllowedResponse(MethodNotAllowedHttpException $exception)
    {
        $body = array(
            'success' => false,
            'error' => array(
                'global' => $this->environmentDetectionService->isEnvironment(Environment::LOCAL) === true ? $exception->getMessage() : null,
            )
        );

        return new JsonResponse($body, Response::HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * @param \Exception $exception
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function createInternalServerErrorResponse(\Exception $exception)
    {
        if ($this->environmentDetectionService->isEnvironment(Environment::LOCAL) === true) {
            throw $exception;
        }

        $body = array(
            'success' => false,
        );

        return new JsonResponse($body, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
