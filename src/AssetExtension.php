<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Package;

use Ixocreate\Template\ExtensionInterface;

final class AssetExtension implements ExtensionInterface
{
    /**
     * @var Asset
     */
    private $asset;

    /**
     * AssetExtension constructor.
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
