<?php

namespace Application\Controller;

use Application\Response\Factory\Consumer\ConsumerRegistrationResponseFactory;
use Domain\Exception\DomainException;
use Domain\Request\ConsumerRegistrationRequestInterface;
use Domain\Service\ConsumerRegistrationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Utility\Controller;
use Utility\ControllerInterface;
use Utility\Request;

/**
 * Class ConsumerRegister
 */
final class ConsumerRegisterController extends Controller implements ControllerInterface
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    protected function execute(Request $request)
    {
        /** @var ConsumerRegistrationRequestInterface $request */

        $service = $this->getServiceContainer()->get('domain.service.consumer.registration');

        if (($service instanceof ConsumerRegistrationService) === false) {
            throw new \UnexpectedValueException('Expecting consumer registration service to be an instance of Domain\Service\ConsumerRegistrationService');
        }

        /** @var ConsumerRegistrationService $service */

        try {
            $consumer = $service->handle($request);

            return (new ConsumerRegistrationResponseFactory())
                ->createSuccessResponse($consumer);
        } catch (DomainException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     */
    protected function validateRequest(Request $request)
    {
        $this->throwUnexpectedValueExceptionUnless(
            $request instanceof ConsumerRegistrationRequestInterface,
            'Expecting request to be an implementation of Domain\Request\ConsumerRegistrationRequestInterface'
        );
    }
}
