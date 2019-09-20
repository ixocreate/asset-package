<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Strategy;

final class FileStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    private $version;

    /**
     * FileVersionStrategy constructor.
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        if (!\file_exists($filename)) {
            throw new \InvalidArgumentException(\sprintf("Filename '%s' doesn't exist", $filename));
        }
        $this->version = require $filename;

        if (\mb_strlen($this->version) < 3) {
            throw new \InvalidArgumentException("Length must be 3 or greater");
        }
    }

    /**
     * @return string
     */
    public function version(): string
    {
        return $this->version;
    }
}
