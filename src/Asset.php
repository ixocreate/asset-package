<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
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
        return $this->packages->getUrl('/' . \ltrim($path, '/'));
    }
}
