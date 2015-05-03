<?php

namespace Application\Response\Factory;

use Application\Response\Entity\ConsumerResponseEntity;
use Domain\Entity\Consumer;
use Utility\Response\ResponseFactory;

/**
 * Class ConsumerResponseFactory
 */
abstract class ConsumerResponseFactory extends ResponseFactory
{

    /**
     * @param Consumer $consumer
     *
     * @return array
     */
    public function createBody(Consumer $consumer)
    {
        return array(
            (new ConsumerResponseEntity($consumer))->toArray()
        );
    }
}
