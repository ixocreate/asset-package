<?php
namespace KiwiSuite\Asset;

use KiwiSuite\Contract\Template\ExtensionInterface;

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
