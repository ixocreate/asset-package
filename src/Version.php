<?php
namespace KiwiSuite\Asset;

use KiwiSuite\Application\ApplicationConfig;
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
            $this->version = sha1(uniqid());

            return;
        }

        try {
            $packageVersion = Versions::getVersion(Versions::ROOT_PACKAGE_NAME);
            if (strpos($packageVersion, '@') !== false) {
                $this->version = substr($packageVersion, strpos($packageVersion, '@'));
            }
        } catch (\Exception $e) {

        }

        if (empty($this->version) || strlen($this->version) !== 40) {
            $this->version = sha1(uniqid());
        }
    }
}
