<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\ComposerStrategy;
use Ixocreate\Asset\Strategy\StrategyInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;

final class ComposerOption implements OptionInterface
{
    /**
     * @var int
     */
    private $length = 40;

    /**
     * @param int $length
     * @return ComposerOption
     */
    public function setLength(int $length): ComposerOption
    {
        $this->length = $length;

        return $this;
    }

    /**
     * @return string|void
     */
    public function serialize()
    {
        return \serialize($this->length);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->length = \unserialize($serialized);
    }

    /**
     * @param ServiceManagerInterface $serviceManager
     * @return StrategyInterface
     */
    public function create(ServiceManagerInterface $serviceManager): StrategyInterface
    {
        return new ComposerStrategy($this->length);
    }
}
