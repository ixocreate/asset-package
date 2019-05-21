<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset\Strategy;

use Ixocreate\Asset\Strategy\RandomStrategy;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Strategy\RandomStrategy
 */
class RandomStrategyTest extends TestCase
{
    public function testVersion()
    {
        $randomStrategy = new RandomStrategy(10);
        $this->assertSame(10, \mb_strlen($randomStrategy->version()));

        $randomStrategy = new RandomStrategy(9);
        $this->assertSame(9, \mb_strlen($randomStrategy->version()));
    }

    public function testInvalidLenght()
    {
        $this->expectException(\InvalidArgumentException::class);
        new RandomStrategy(2);
    }
}
