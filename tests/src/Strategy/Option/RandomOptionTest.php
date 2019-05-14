<?php
declare(strict_types=1);

namespace Ixocreate\Test\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\Option\RandomOption;
use Ixocreate\Asset\Strategy\RandomStrategy;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Strategy\Option\RandomOption
 */
final class RandomOptionTest extends TestCase
{
    private function reflectionTestLength(int $length, RandomOption $randomOption)
    {
        $reflection = new \ReflectionClass($randomOption);
        $property = $reflection->getProperty("length");
        $property->setAccessible(true);
        $this->assertSame($length, $property->getValue($randomOption));
    }

    public function testLength()
    {
        //Default Length
        $randomOption = new RandomOption();
        $this->reflectionTestLength(40, $randomOption);

        $randomOption = new RandomOption();
        $randomOption->setLength(42);
        $this->reflectionTestLength(42, $randomOption);
    }

    public function testSerialization()
    {
        $randomOption = new RandomOption();
        $randomOption->setLength(12);
        $randomOption = \unserialize(\serialize($randomOption));
        $this->reflectionTestLength(12, $randomOption);
    }

    public function testCreate()
    {
        $randomOption = new RandomOption();
        $randomOption->setLength(12);

        $strategy = $randomOption->create($this->createMock(ServiceManagerInterface::class));
        $this->assertInstanceOf(RandomStrategy::class, $strategy);
        $this->assertSame(12, \mb_strlen($strategy->version()));
    }
}
