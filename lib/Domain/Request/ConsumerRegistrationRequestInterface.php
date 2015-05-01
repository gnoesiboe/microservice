<?php

namespace Domain\Request;

use Domain\Request\Entity\ConsumerRequestEntityInterface;

/**
 * ConsumerRegistrationRequestInterface
 */
interface ConsumerRegistrationRequestInterface
{

    /**
     * @return ConsumerRequestEntityInterface
     */
    public function getConsumerEntity();
}
