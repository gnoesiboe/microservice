<?php

namespace Application\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationDIContainerFactory
 */
final class ApplicationServiceContainerFactory
{

    /**
     * @return ContainerBuilder
     */
    public function createDIContainer()
    {
        // @todo load from other file? => see Symfony/Config component
        // @todo make enviroment specific
        $container = new ContainerBuilder(new ParameterBag(array(
            'db.dsn' => 'mysql:host=localhost;dbname=microservice;charset=utf8',
            'db.username' => 'root',
            'db.password' => 'nopassword',
        )));

        $container
            ->register('router.request.http', 'Utility\HttpRequestRouter')
            ->addArgument(new Reference('manager.request'));

        $container
            ->register('service.environment.detection', 'Utility\Service\EnvironmentDetectionService')
            ->addArgument(array())
            ->addArgument('local');

        $container
            ->register('database.connection.pdo', '\PDO')
            ->addArgument('%db.dsn%')
            ->addArgument('%db.username%')
            ->addArgument('%db.password%')
            ->addArgument(array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ));

        $container
            ->register('database.connection', 'Utility\Database\DatabaseConnection')
            ->addArgument(new Reference('database.connection.pdo'));

        $this->registerRequests($container);
        $this->registerControllers($container);
        $this->registerResponseFactories($container);
        $this->registerValidators($container);
        $this->registerDomainServices($container);
        $this->registerDomainRepositories($container);

        return $container;
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerResponseFactories(ContainerBuilder $container)
    {
        $container
            ->register('factory.response.error', 'Application\Response\Factory\ErrorResponseFactory')
            ->addArgument(new Reference('service.environment.detection'));
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerControllers(ContainerBuilder $container)
    {
        $container
            ->register('controller.consumer.register', 'Application\Controller\ConsumerRegisterController')
            ->addArgument(new Reference('service_container'));
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerRequests(ContainerBuilder $container)
    {
        $container->set('request', Request::createFromGlobals());

        $container
            ->register('request.consumer.register', 'Application\Request\ConsumerRegistrationRequest')
            ->addArgument(new Reference('request'));
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerValidators(ContainerBuilder $container)
    {
        $container->register('validator.string', 'Utility\Validator\StringValidator');
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerDomainRepositories(ContainerBuilder $container)
    {
        $container
            ->register('domain.repository.consumer', 'Utility\Repository\DatabaseConsumerRepository')
            ->addArgument(new Reference('database.connection'));
    }

    /**
     * @param ContainerBuilder $container
     */
    private function registerDomainServices(ContainerBuilder $container)
    {
        $container
            ->register('domain.event.dispatcher', 'Domain\EventDispatcher')
            ->setFactory(array('Domain\EventDispatcher', 'getInstance'));

        $container
            ->register('domain.service.consumer.registration', 'Domain\Service\ConsumerRegistrationService')
            ->addArgument(new Reference('domain.event.dispatcher'))
            ->addArgument(new Reference('domain.repository.consumer'));
    }
}
