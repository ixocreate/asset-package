<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Template;

use Ixocreate\Asset\Asset;
use Ixocreate\Template\Extension\ExtensionInterface;

final class AssetExtension implements ExtensionInterface
{
    /**
     * @var Asset
     */
    private $asset;

    /**
     * AssetExtension constructor.
     *
     * @param Asset $asset
     */
    public function __construct(Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'asset';
    }

    public function __invoke($path)
    {
        return $this->asset->getUrl($path);
    }
}
