<?php
declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\Service\ServiceManagerConfigurator;
use Ixocreate\Asset\Factory\AssetFactory;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(Asset::class, AssetFactory::class);
