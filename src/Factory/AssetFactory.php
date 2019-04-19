<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Factory;

use Ixocreate\Application\ApplicationConfig;
use Ixocreate\Application\Config\Config;
use Ixocreate\Application\Uri\ApplicationUri;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\Version;
use Ixocreate\ServiceManager\FactoryInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Zend\ServiceManager\Exception\InvalidArgumentException;

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
        $version = new Version($container->get(ApplicationConfig::class));
        $this->projectUri = $container->get(ApplicationUri::class);

        $packages = new Packages();
        $assetConfig = $container->get(Config::class)->get('asset', []);

        if (empty($assetConfig['url'])) {
            throw new InvalidArgumentException("no Url set in Config");
        }

        $urls = $this->getUrls($assetConfig['url']);
        $format = (!empty($assetConfig['format'])) ? $assetConfig['format'] : '%1$s?v=%2$s';

        $urlPackage = new UrlPackage(
            $urls,
            new StaticVersionStrategy($version->getVersion(), $format)
        );
        $packages->setDefaultPackage($urlPackage);
        return new Asset($packages);
    }

    /**
     * @param $urls
     * @return array
     */
    private function getUrls($urls): array
    {
        if (!\is_array($urls)) {
            $urls = (array)$urls;
        }

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
