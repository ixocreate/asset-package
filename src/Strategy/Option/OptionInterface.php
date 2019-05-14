<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\StrategyInterface;
use Ixocreate\ServiceManager\ServiceManagerInterface;

interface OptionInterface extends \Serializable
{
    public function create(ServiceManagerInterface $serviceManager): StrategyInterface;
}
