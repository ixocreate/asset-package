<?php
declare(strict_types=1);
namespace Ixocreate\Asset;

use Ixocreate\Asset\Factory\AssetFactory;
use Ixocreate\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(Asset::class, AssetFactory::class);
