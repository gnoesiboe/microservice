<?php

namespace Application;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteCollectionFactory
 */
final class RouteCollectionFactory
{

    /**
     * @return RouteCollection
     */
    public function createRouteCollection()
    {
        $routeCollection = new RouteCollection();

        $this->defineConsumerResources($routeCollection);

        return $routeCollection;
    }

    /**
     * @param RouteCollection $routeCollection
     */
    protected function defineConsumerResources(RouteCollection $routeCollection)
    {
        $routeCollection->add(
            'consumer.register',
            $route = new Route('/consumer/register', array('_request' => 'request.consumer.register', '_controller' => 'controller.consumer.register'), array(), array(), '', array(), 'POST')
        );
    }
}
