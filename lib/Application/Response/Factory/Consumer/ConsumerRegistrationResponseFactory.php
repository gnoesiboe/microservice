<?php

namespace Application\Response\Factory\Consumer;

use Application\Response\Entity\ConsumerResponseEntity;
use Domain\Entity\Consumer;
use Domain\Exception\UsernameAlreadyExistsException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ConsumerRegistrationResponseFactory
 */
final class ConsumerRegistrationResponseFactory
{

    /**
     * @param Consumer $consumer
     *
     * @return JsonResponse
     */
    public function createSuccessResponse(Consumer $consumer)
    {
        return new JsonResponse(array(
            'success' => true,
            'payload' => array(
                (new ConsumerResponseEntity($consumer))->toArray()
            )
        ));
    }
}
