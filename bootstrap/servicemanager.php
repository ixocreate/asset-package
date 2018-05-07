<?php
declare(strict_types=1);
namespace KiwiSuite\Asset;

use KiwiSuite\Asset\Factory\AssetFactory;
use KiwiSuite\ServiceManager\ServiceManagerConfigurator;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(Asset::class, AssetFactory::class);
