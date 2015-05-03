<?php

namespace Application\Request;

use Domain\Entity\Consumer;
use Domain\Repository\ConsumerRepositoryInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Utility\Request;

/**
 * Class ConsumerDetailRequest
 */
final class ConsumerDetailRequest extends Request
{
    /**
     * @var ConsumerRepositoryInterface
     */
    private $consumerRepository;

    /**
     * @var Consumer
     */
    private $consumer;

    /**
     * @param HttpRequest $httpRequest
     * @param ConsumerRepositoryInterface $consumerRepository
     */
    public function __construct(HttpRequest $httpRequest, ConsumerRepositoryInterface $consumerRepository)
    {
        $this->consumerRepository = $consumerRepository;

        parent::__construct($httpRequest);
    }

    /**
     * @param HttpRequest $httpRequest
     */
    protected function validateHttpRequest(HttpRequest $httpRequest)
    {
        parent::validateHttpRequest($httpRequest);

        if ($httpRequest->attributes->has('uuid') === false) {
            throw new NotFoundHttpException('Missing required attribute \'uuid\'');
        }

        $uuid = $httpRequest->attributes->get('uuid');

        $consumer = $this->consumerRepository->getOneByUUID($uuid);

        if (($consumer instanceof Consumer) === false) {
            throw new NotFoundHttpException('No consumer found with id: ' . $uuid);
        }

        $this->consumer = $consumer;
    }

    /**
     * @return Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }
}
