<?php

namespace Application\Controller;

use Application\Request\ConsumerDetailRequest;
use Application\Response\Factory\Consumer\ConsumerDetailResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Utility\Controller;
use Utility\Request;

/**
 * Class ConsumerDetailController
 */
final class ConsumerDetailController extends Controller
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    protected function execute(Request $request)
    {
        /** @var ConsumerDetailRequest $request */

        return (new ConsumerDetailResponseFactory())
            ->createSuccessResponse($request->getConsumer());
    }

    /**
     * @param Request $request
     */
    protected function validateRequest(Request $request)
    {
        if (($request instanceof ConsumerDetailRequest) === false) {
            throw new \UnexpectedValueException('Request should be an instance of Application\Request\ConsumerDetailRequest');
        }
    }
}
