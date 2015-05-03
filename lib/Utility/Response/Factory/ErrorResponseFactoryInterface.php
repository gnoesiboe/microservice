<?php

namespace Utility\Response\Factory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Interface ErrorResponseFactoryInterface
 */
interface ErrorResponseFactoryInterface
{

    /**
     * @param NotFoundHttpException $exception
     *
     * @return Response
     */
    public function createNotFoundResponse(NotFoundHttpException $exception);

    /**
     * @param BadRequestHttpException $badRequestHttpException
     *
     * @return Response
     */
    public function createBadRequestResponse(BadRequestHttpException $badRequestHttpException);

    /**
     * @param MethodNotAllowedHttpException $exception
     *
     * @return Response
     */
    public function createMethodNotAllowedResponse(MethodNotAllowedHttpException $exception);

    /**
     * @param \Exception $exception
     *
     * @return Response
     */
    public function createInternalServerErrorResponse(\Exception $exception);
}
