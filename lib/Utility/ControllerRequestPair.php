<?php

namespace Utility;

/**
 * Class ControllerRequestPair
 */
final class ControllerRequestPair
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ControllerInterface
     */
    private $controller;

    /**
     * @param Request $request
     * @param ControllerInterface $controller
     */
    public function __construct(Request $request, ControllerInterface $controller)
    {
        $this->request = $request;
        $this->controller = $controller;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return ControllerInterface
     */
    public function getController()
    {
        return $this->controller;
    }
}
