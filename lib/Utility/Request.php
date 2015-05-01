<?php

namespace Utility;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class Request
 */
abstract class Request
{

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @param HttpRequest $httpRequest
     */
    public function __construct(HttpRequest $httpRequest)
    {
        $this->setHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequest $httpRequest
     */
    private function setHttpRequest(HttpRequest $httpRequest)
    {
        $this->validateHttpRequest($httpRequest);

        $this->httpRequest = $httpRequest;
    }

    /**
     * @param HttpRequest $request
     */
    protected function validateHttpRequest(HttpRequest $request)
    {
        $this->validateRequestHasCorrectContentType($request);
    }

    /**
     * @param HttpRequest $request
     */
    private function validateRequestHasCorrectContentType(HttpRequest $request)
    {
        if ($request->headers->get('Content-Type', null) !== 'application/json') {
            throw new BadRequestHttpException('Missing required application/json content type header');
        }
    }

    /**
     * @return HttpRequest
     */
    protected function getHttpRequest()
    {
        return $this->httpRequest;
    }
}
