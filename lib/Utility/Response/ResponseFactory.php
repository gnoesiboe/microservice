<?php

namespace Utility\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResponseFactory
 */
abstract class ResponseFactory
{

    /**
     * @param bool $success
     * @param array $payload
     *
     * @return JsonResponse
     */
    public function createResponse($success, array $payload)
    {
        return new JsonResponse(array(
            'success' => (bool)$success,
            'payload' => $payload,
        ));
    }

    /**
     * @param array $body
     *
     * @return JsonResponse
     */
    public function createCreatedResponseInstance(array $body)
    {
        return $this->createResponse(true, $body, Response::HTTP_CREATED);
    }

    /**
     * @param array $body
     *
     * @return JsonResponse
     */
    public function createSuccessResponseInstance(array $body)
    {
        return $this->createResponse(true, $body, Response::HTTP_OK);
    }
}
