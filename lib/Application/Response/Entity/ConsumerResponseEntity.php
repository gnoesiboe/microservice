<?php

namespace Application\Response\Entity;

use Domain\Entity\Consumer;
use Utility\Response\ResponseEntity;

/**
 * Class ConsumerResponseEntity
 */
final class ConsumerResponseEntity extends ResponseEntity
{

    /** @var string */
    const TYPE = 'Consumer';

    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * @param Consumer $consumer
     */
    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;

        parent::__construct();
    }

    /**
     * @return string
     */
    protected function defineType()
    {
        return self::TYPE;
    }

    /**
     * @return array
     */
    protected function defineData()
    {
        return array(
            'uuid' => $this->consumer->getUUID()->getValue(),
            'username' => $this->consumer->getUsername()->getValue(),
        );
    }
}
