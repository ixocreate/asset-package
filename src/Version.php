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
     * @var string|null
     */
    private $versionFilename;

    /**
     * Version constructor.
     *
     * @param ApplicationConfig $applicationConfig
     * @param string|null $versionFilename
     */
    public function __construct(
        ApplicationConfig $applicationConfig,
        ?string $versionFilename = null
    ) {
        $this->applicationConfig = $applicationConfig;
        $this->versionFilename = $versionFilename;
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
        if ($this->versionFilename !== null && \file_exists($this->versionFilename)) {
            $this->version = require $this->versionFilename;

            if (\mb_strlen($this->version) === 40) {
                return;
            }
        }

        try {
            $packageVersion = Versions::getVersion(Versions::ROOT_PACKAGE_NAME);
            if (\mb_strpos($packageVersion, '@') !== false) {
                $this->version = \mb_substr($packageVersion, \mb_strpos($packageVersion, '@') + 1);
            }
        } catch (\Exception $e) {
        }

        if (empty($this->version) || \mb_strlen($this->version) !== 40) {
            $this->version = \sha1(\uniqid());
        }
    }
}
