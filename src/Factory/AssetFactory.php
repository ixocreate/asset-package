<?php
namespace Ixocreate\Asset\Factory;

use Ixocreate\Application\ApplicationConfig;
use Ixocreate\Asset\Asset;
use Ixocreate\Asset\Version;
use Ixocreate\Config\Config;
use Ixocreate\Contract\ServiceManager\FactoryInterface;
use Ixocreate\Contract\ServiceManager\ServiceManagerInterface;
use Ixocreate\ProjectUri\ProjectUri;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;

final class AssetFactory implements FactoryInterface
{
    /**
     * @var ProjectUri
     */
    private $projectUri;

    /**
     * @param ServiceManagerInterface $container
     * @param $requestedName
     * @param array|null $options
     * @return mixed
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ServiceManagerInterface $container, $requestedName, array $options = null)
    {
        $version = new Version($container->get(ApplicationConfig::class));
        $this->projectUri = $container->get(ProjectUri::class);

        $packages = new Packages();
        $assetConfig = $container->get(Config::class)->get('asset', []);

        if(empty($assetConfig['url'])) {
            //TODO Exception
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
        if (!is_array($urls)) {
            $urls = (array) $urls;
        }

        $result = [];
        foreach ($urls as $url) {
            if ($this->isAbsoluteUrl($url)) {
                $result[] = $url;
                continue;
            }

            $result[] = rtrim((string) $this->projectUri->getMainUrl(), '/') . '/' . ltrim($url, '/');
        }

        return $result;
    }

    /**
     * @param $url
     * @return bool
     */
    private function isAbsoluteUrl($url)
    {
        return (strpos($url, '://') !== false) || (substr($url, 0, 2) === '//');
    }
}
