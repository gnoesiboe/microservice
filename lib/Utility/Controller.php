<?php

namespace Utility;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 */
abstract class Controller implements ControllerInterface
{

    /**
     * @var ContainerInterface
     */
    private $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @return ContainerInterface
     */
    protected function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function handleRequest(Request $request)
    {
        $this->validateRequest($request);

        return $this->execute($request);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    abstract protected function execute(Request $request);

    /**
     * @param Request $request
     */
    abstract protected function validateRequest(Request $request);

    /**
     * @param bool $contition
     * @param string|null $message
     *
     * @throws \UnexpectedValueException
     */
    public function throwUnexpectedValueExceptionUnless($contition, $message = null)
    {
        if ((bool)$contition === false) {
            throw new \UnexpectedValueException($message);
        }
    }
}
