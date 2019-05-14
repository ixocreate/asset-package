<?php
declare(strict_types=1);

namespace Ixocreate\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\FileStrategy;
use Ixocreate\Asset\Strategy\StrategyInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;

final class FileOption implements OptionInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @param string $filename
     * @return FileOption
     */
    public function setFilename(string $filename): FileOption
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string|void
     */
    public function serialize()
    {
        return \serialize($this->filename);
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->filename = \unserialize($serialized);
    }

    public function create(ServiceManagerInterface $serviceManager): StrategyInterface
    {
        return new FileStrategy($this->filename);
    }
}
