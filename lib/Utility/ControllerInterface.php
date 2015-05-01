<?php

namespace Utility;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class ControllerInterface
 */
interface ControllerInterface
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function handleRequest(Request $request);
}
