<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\Configurator\ConfiguratorInterface;
use Ixocreate\Application\Service\ServiceRegistryInterface;
use Ixocreate\Asset\Strategy\Option\OptionInterface;
use Ixocreate\Asset\Strategy\Option\RandomOption;

final class AssetConfigurator implements ConfiguratorInterface
{
    /**
     * @var array
     */
    private $url = [];

    /**
     * @var string
     */
    private $format = '%1$s?v=%2$s';

    /**
     * @var OptionInterface
     */
    private $strategy;

    /**
     * AssetConfigurator constructor.
     */
    public function __construct()
    {
        $this->strategy = new RandomOption();
    }

    /**
     * @param string $url
     */
    public function addUrl(string $url): void
    {
        $this->url[] = $url;
    }

    /**
     * @param array $urls
     */
    public function setUrls(array $urls): void
    {
        $this->url = $urls;
    }

    /**
     * @return array
     */
    public function urls(): array
    {
        return $this->url;
    }

    /**
     * @param string $format
     */
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    public function format(): string
    {
        return $this->format;
    }

    /**
     * @param OptionInterface $option
     */
    public function setStrategy(OptionInterface $option): void
    {
        $this->strategy = $option;
    }

    /**
     * @return OptionInterface
     */
    public function strategy(): OptionInterface
    {
        return $this->strategy;
    }

    /**
     * @param ServiceRegistryInterface $serviceRegistry
     * @return void
     */
    public function registerService(ServiceRegistryInterface $serviceRegistry): void
    {
        $serviceRegistry->add(AssetConfig::class, new AssetConfig($this));
    }
}
