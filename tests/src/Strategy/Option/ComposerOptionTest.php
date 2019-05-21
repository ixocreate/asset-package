<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOCREATE GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\ComposerStrategy;
use Ixocreate\Asset\Strategy\Option\ComposerOption;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Strategy\Option\ComposerOption
 */
final class ComposerOptionTest extends TestCase
{
    private function reflectionTestLength(int $length, ComposerOption $composerOption)
    {
        $reflection = new \ReflectionClass($composerOption);
        $property = $reflection->getProperty("length");
        $property->setAccessible(true);
        $this->assertSame($length, $property->getValue($composerOption));
    }

    public function testLength()
    {
        //Default Length
        $composerOption = new ComposerOption();
        $this->reflectionTestLength(40, $composerOption);

        $composerOption = new ComposerOption();
        $composerOption->setLength(42);
        $this->reflectionTestLength(42, $composerOption);
    }

    public function testSerialization()
    {
        $composerOption = new ComposerOption();
        $composerOption->setLength(12);
        $composerOption = \unserialize(\serialize($composerOption));
        $this->reflectionTestLength(12, $composerOption);
    }

    public function testCreate()
    {
        $composerOption = new ComposerOption();
        $composerOption->setLength(12);

        $strategy = $composerOption->create($this->createMock(ServiceManagerInterface::class));
        $this->assertInstanceOf(ComposerStrategy::class, $strategy);
        $this->assertSame(12, \mb_strlen($strategy->version()));
    }
}
