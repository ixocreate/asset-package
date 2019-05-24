<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Test\Asset\Strategy;

use Ixocreate\Asset\Strategy\FileStrategy;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ixocreate\Asset\Strategy\FileStrategy
 */
class FileStrategyTest extends TestCase
{
    public function testVersion()
    {
        $strategy = new FileStrategy('tests/misc/valid_versionfile.php');
        $this->assertSame("91d4dbd1ec7b6fed3972382bb17efef678eb432d", $strategy->version());
    }

    public function testLengthTooShort()
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileStrategy('tests/misc/invalid_versionfile_tooshort.php');
    }

    public function testInvalidFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        new FileStrategy('dontexist');
    }
}
