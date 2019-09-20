<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\Config\ConfigProviderInterface;

final class ConfigProvider implements ConfigProviderInterface
{
    public function __invoke(): array
    {
        return [
            'asset' => [
                'url' => [],
                'format' => '%1$s?v=%2$s',
            ],
        ];
    }

    public function configName(): string
    {
        return 'asset';
    }

    public function configContent(): string
    {
        return \file_get_contents(__DIR__ . '/../resources/asset.config.example.php');
    }
}
