<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Symfony\Component\Asset\Packages;

final class Asset
{
    /**
     * @var Packages
     */
    private $packages;

    /**
     * Asset constructor.
     *
     * @param Packages $packages
     */
    public function __construct(Packages $packages)
    {
        $this->packages = $packages;
    }

    /**
     * @param $path
     * @return string
     */
    public function getUrl($path): string
    {
        /**
         * Do not prefix absolute urls
         * This aligns with symfony asset package behaviour
         */
        return $this->packages->getUrl($path);
    }
}
