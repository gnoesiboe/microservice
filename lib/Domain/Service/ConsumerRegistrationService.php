<?php

namespace Domain\Service;

use Domain\Entity\Consumer;
use Domain\Event\ConsumerRegisteredEvent;
use Domain\EventDispatcherInterface;
use Domain\Exception\UsernameAlreadyExistsException;
use Domain\Repository\ConsumerRepositoryInterface;
use Domain\Request\ConsumerRegistrationRequestInterface;
use Domain\Service;
use Domain\Specification\UsernameIsUniqueSpecification;
use Domain\ValueObject\UUID;
use Domain\Exception\DomainException;
use Domain\ValueObject\Password;
use Domain\ValueObject\Username;


/**
 * Class AccountRegistrationService
 */
final class ConsumerRegistrationService extends Service
{

    /**
     * @var ConsumerRepositoryInterface
     */
    private $consumerRepository;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param ConsumerRepositoryInterface $consumerRepository
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, ConsumerRepositoryInterface $consumerRepository)
    {
        parent::__construct($eventDispatcher);

        $this->consumerRepository = $consumerRepository;
    }

    /**
     * @param ConsumerRegistrationRequestInterface $request
     *
     * @return Consumer
     *
     * @throws DomainException
     */
    public function handle(ConsumerRegistrationRequestInterface $request)
    {
        $consumerEntity = $request->getConsumerEntity();

        $gguid = UUID::generate();
        $username = new Username($consumerEntity->getUsername());
        $password = new Password($consumerEntity->getPassword());

        $this->validateUsernameIsUnique($username);

        $consumer = new Consumer($gguid, $username, $password);

        $this->consumerRepository->persist($consumer);

        $this->getEventDispatcher()->trigger(new ConsumerRegisteredEvent($gguid));

        return $consumer;
    }

    /**
     * @param Username $username
     *
     * @throws DomainException
     */
    private function validateUsernameIsUnique(Username $username)
    {
        $usernameIsUniqueSpecification = new UsernameIsUniqueSpecification($this->consumerRepository);

        if ($usernameIsUniqueSpecification->isStatisfiedBy($username) === false) {
            throw new UsernameAlreadyExistsException($username, "Username '{$username->getValue()}' is already in use for another user");
        }
    }
}
