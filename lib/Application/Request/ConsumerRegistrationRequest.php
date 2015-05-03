<?php

namespace Application\Request;

use Application\Request\Entity\ConsumerRequestEntity;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Utility\Exception\InvalidRequestFormatException;
use Utility\Helpers\JsonParser;
use Utility\Request;
use Domain\Request\ConsumerRegistrationRequestInterface;
use Domain\Request\Entity\ConsumerRequestEntityInterface;

/**
 * Class ConsumerRegistrationRequest
 */
final class ConsumerRegistrationRequest extends Request implements ConsumerRegistrationRequestInterface
{

    /**
     * @var ConsumerRequestEntity
     */
    private $consumerRequestEntity;

    /**
     * @return ConsumerRequestEntityInterface
     */
    public function getConsumerEntity()
    {
        return $this->consumerRequestEntity;
    }

    /**
     * @param HttpRequest $httpRequest
     */
    protected function validateHttpRequest(HttpRequest $httpRequest)
    {
        parent::validateHttpRequest($httpRequest);

        try {
            $input = (new JsonParser())
                ->parse($httpRequest->getContent(), true);
        } catch (InvalidRequestFormatException $exception) {
            throw new BadRequestHttpException('Could not parse request body');
        }

        if (is_array($input) === false) {
            throw new BadRequestHttpException('Content body should be an object');
        }

        $this->consumerRequestEntity = new ConsumerRequestEntity($input);
    }
}
