<?php

namespace Application\Response\Factory\Consumer;

use Application\Response\Factory\ConsumerResponseFactory;
use Domain\Entity\Consumer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ConsumerRegistrationResponseFactory
 */
final class ConsumerRegistrationResponseFactory extends ConsumerResponseFactory
{

    /**
     * @param Consumer $consumer
     *
     * @return JsonResponse
     */
    public function createSuccessResponse(Consumer $consumer)
    {
        return $this->createCreatedResponseInstance($this->createBody($consumer));
    }
}
