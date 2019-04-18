<?php
declare(strict_types=1);
namespace Ixocreate\Asset\Package;

use Ixocreate\Asset\Package\Factory\AssetFactory;
use Ixocreate\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(Asset::class, AssetFactory::class);
