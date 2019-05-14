<?php
declare(strict_types=1);

namespace Ixocreate\Asset\Strategy;

final class RandomStrategy implements StrategyInterface
{
    /**
     * @var int
     */
    private $version;

    public function __construct(int $length)
    {
        if ($length < 3) {
            throw new \InvalidArgumentException("Length must be 3 or greater");
        }
        $this->version = \mb_substr(bin2hex(\random_bytes((int) \ceil($length / 2))), 0, $length);
    }

    public function version(): string
    {
        return $this->version;
    }
}
