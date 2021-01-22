<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Factory;

use Ixocreate\Application\Exception\InvalidArgumentException;
use Ixocreate\Application\Uri\ApplicationUri;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\AssetConfig;
use Ixocreate\ServiceManager\FactoryInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

final class AssetFactory implements FactoryInterface
{
    /**
     * @var ApplicationUri
     */
    private $projectUri;

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @return mixed
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        /** @var AssetConfig $assetConfig */
        $assetConfig = $container->get(AssetConfig::class);

        $this->projectUri = $container->get(ApplicationUri::class);

        if (empty($assetConfig->urls())) {
            throw new InvalidArgumentException('No Asset Url set in Config');
        }

        $urls = $this->getUrls($assetConfig->urls());
        $strategy = $assetConfig->strategy()->create($container);

        $urlPackage = new UrlPackage(
            $urls,
            new StaticVersionStrategy($strategy->version(), $assetConfig->format())
        );

        $packages = new Packages();
        $packages->setDefaultPackage($urlPackage);

        return new Asset($packages);
    }

    /**
     * @param $urls
     * @return array
     */
    private function getUrls(array $urls): array
    {
        $result = [];
        foreach ($urls as $url) {
            if ($this->isAbsoluteUrl($url)) {
                $result[] = $url;
                continue;
            }

            $result[] = \rtrim((string)$this->projectUri->getMainUri(), '/') . '/' . \ltrim($url, '/');
        }

        return $result;
    }

    /**
     * @param $url
     * @return bool
     */
    private function isAbsoluteUrl($url)
    {
        return (\mb_strpos($url, '://') !== false) || (\mb_substr($url, 0, 2) === '//');
    }
}
