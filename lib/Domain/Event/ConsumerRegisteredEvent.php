<?php

namespace Domain\Event;

use Domain\EventInterface;
use Domain\ValueObject\UUID;

/**
 * Class ConsumerRegisteredEvent
 */
final class ConsumerRegisteredEvent implements EventInterface
{

    /** @var string */
    const IDENTIFIER = 'consumer.registered';

    /**
     * @var UUID
     */
    private $guid;

    /**
     * @param UUID $GUID
     */
    public function __construct(UUID $GUID)
    {
        $this->guid = $GUID;
    }

    /**
     * @return UUID
     */
    public function getUUID()
    {
        return $this->guid;
    }

    /**
     * @return string
     */
    public static function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}
