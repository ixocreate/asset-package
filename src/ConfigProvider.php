<?php
namespace Ixocreate\Asset;

use Ixocreate\Contract\Application\ConfigProviderInterface;

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
}
