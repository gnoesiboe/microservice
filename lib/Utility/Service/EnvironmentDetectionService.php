<?php

namespace Utility\Service;

/**
 * Class EnvironmentDetectionService
 */
final class EnvironmentDetectionService implements EnvironmentDetectionServiceInterface
{

    /**
     * @var array
     */
    private $registrations = array();

    /**
     * @var string
     */
    private $fallbackEnvironment;

    /**
     * @param array $registrations
     * @param string $fallbackEnvironment
     */
    public function __construct(array $registrations, $fallbackEnvironment = 'local')
    {
        $this->setRegistrations($registrations);
        $this->fallbackEnvironment = $fallbackEnvironment;
    }

    /**
     * @param array $registrations
     *
     * @return $this
     */
    private function setRegistrations(array $registrations)
    {
        foreach ($registrations as $hostname => $environment) {
            $this->register($hostname, $environment);
        }

        return $this;
    }

    /**
     * @param string $hostname
     * @param string $environment
     *
     * @return $this
     */
    private function register($hostname, $environment)
    {
        $this->registrations[(string)$hostname] = (string)$environment;

        return $this;
    }

    /**
     * @param string $hostname
     *
     * @return string
     */
    public function getEnvironmentForHostname($hostname)
    {
        return $this->hasEnvironmentForHostname($hostname) ? $this->registrations[$hostname] : $this->fallbackEnvironment;
    }

    /**
     * @param string $hostname
     *
     * @return bool
     */
    public function hasEnvironmentForHostname($hostname)
    {
        return array_key_exists($hostname, $this->registrations) === true;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        $hostname = gethostname();

        return $this->getEnvironmentForHostname($hostname);
    }

    /**
     * @param string $environment
     *
     * @return bool
     */
    public function isEnvironment($environment)
    {
        return $this->getEnvironment() === $environment;
    }
}
