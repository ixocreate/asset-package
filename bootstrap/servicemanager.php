<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset;

use Ixocreate\Application\ServiceManager\ServiceManagerConfigurator;
use Ixocreate\Asset\Factory\AssetFactory;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(Asset::class, AssetFactory::class);
