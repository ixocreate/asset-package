<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\ApplicationConfig;
use PackageVersions\Versions;

final class Version
{
    /**
     * @var ApplicationConfig
     */
    private $applicationConfig;

    /**
     * @var string
     */
    private $version = null;

    /**
     * Version constructor.
     *
     * @param ApplicationConfig $applicationConfig
     */
    public function __construct(ApplicationConfig $applicationConfig)
    {
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if ($this->version === null) {
            $this->generateVersion();
        }

        return $this->version;
    }

    /**
     *
     */
    private function generateVersion(): void
    {
        if ($this->applicationConfig->isDevelopment()) {
            $this->version = \sha1(\uniqid());

            return;
        }

        try {
            $packageVersion = Versions::getVersion(Versions::ROOT_PACKAGE_NAME);
            if (\mb_strpos($packageVersion, '@') !== false) {
                $this->version = \mb_substr($packageVersion, \mb_strpos($packageVersion, '@'));
            }
        } catch (\Exception $e) {
        }

        if (empty($this->version) || \mb_strlen($this->version) !== 40) {
            $this->version = \sha1(\uniqid());
        }
    }
}
