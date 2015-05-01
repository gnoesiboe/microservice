<?php

namespace Utility\Service;

/**
 * Interface EnvironmentDetectionServiceInterface
 */
interface EnvironmentDetectionServiceInterface
{

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @param string $hostname
     *
     * @return bool
     */
    public function hasEnvironmentForHostname($hostname);

    /**
     * @param string $hostname
     *
     * @return string
     */
    public function getEnvironmentForHostname($hostname);

    /**
     * @param string $environment
     *
     * @return bool
     */
    public function isEnvironment($environment);
}
