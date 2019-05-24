<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\RandomStrategy;
use Ixocreate\Asset\Strategy\StrategyInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;

final class RandomOption implements OptionInterface
{
    private $length = 40;

    /**
     * @param int $length
     * @return RandomOption
     */
    public function setLength(int $length): RandomOption
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

    public function create(ServiceManagerInterface $serviceManager): StrategyInterface
    {
        return new RandomStrategy($this->length);
    }
}
