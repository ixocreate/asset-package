<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\Bootstrap\BootstrapItemInterface;
use Ixocreate\Application\Configurator\ConfiguratorInterface;

final class AssetBootstrapItem implements BootstrapItemInterface
{
    /**
     * @return mixed
     */
    public function getConfigurator(): ConfiguratorInterface
    {
        return new AssetConfigurator();
    }

    /**
     * @return string
     */
    public function getVariableName(): string
    {
        return 'asset';
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return 'asset.php';
    }
}
