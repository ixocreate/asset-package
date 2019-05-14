<?php
declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\Service\SerializableServiceInterface;
use Ixocreate\Asset\Strategy\Option\OptionInterface;

final class AssetConfig implements SerializableServiceInterface
{
    /**
     * @var array
     */
    private $options = [];

    /**
     * AssetConfig constructor.
     * @param AssetConfigurator $assetConfigurator
     */
    public function __construct(AssetConfigurator $assetConfigurator)
    {
        $this->options = [
            'urls' => $assetConfigurator->urls(),
            'format' => $assetConfigurator->format(),
            'strategy' => $assetConfigurator->strategy(),
        ];
    }

    /**
     * @return array
     */
    public function urls(): array
    {
        return $this->options['urls'];
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return $this->options['format'];
    }

    /**
     * @return OptionInterface
     */
    public function strategy(): OptionInterface
    {
        return $this->options['strategy'];
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return \serialize($this->options);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->options = \unserialize($serialized);
    }
}
