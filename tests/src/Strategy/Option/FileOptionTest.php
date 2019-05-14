<?php
declare(strict_types=1);

namespace Ixocreate\Test\Asset\Strategy\Option;

use Ixocreate\Asset\Strategy\FileStrategy;
use Ixocreate\Asset\Strategy\Option\FileOption;
use Ixocreate\ServiceManager\ServiceManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Strategy\Option\FileOption
 */
final class FileOptionTest extends TestCase
{
    private function reflectionTestFilename(string $filename, FileOption $fileOption)
    {
        $reflection = new \ReflectionClass($fileOption);
        $property = $reflection->getProperty("filename");
        $property->setAccessible(true);
        $this->assertSame($filename, $property->getValue($fileOption));
    }

    public function testLength()
    {
        $fileOption = new FileOption();
        $fileOption->setFilename('tests/misc/valid_versionfile.php');
        $this->reflectionTestFilename('tests/misc/valid_versionfile.php', $fileOption);
    }

    public function testSerialization()
    {
        $fileOption = new FileOption();
        $fileOption->setFilename('tests/misc/valid_versionfile.php');
        $fileOption = \unserialize(\serialize($fileOption));
        $this->reflectionTestFilename('tests/misc/valid_versionfile.php', $fileOption);
    }

    public function testCreate()
    {
        $fileOption = new FileOption();
        $fileOption->setFilename('tests/misc/valid_versionfile.php');

        $strategy = $fileOption->create($this->createMock(ServiceManagerInterface::class));
        $this->assertInstanceOf(FileStrategy::class, $strategy);
        $this->assertSame(require 'tests/misc/valid_versionfile.php', $strategy->version());
    }
}
