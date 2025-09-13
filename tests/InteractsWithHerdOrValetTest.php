<?php

namespace Modularavel\Installer\Console\Tests;

use Modularavel\Installer\Console\Concerns\InteractsWithHerdOrValet;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class InteractsWithHerdOrValetTest extends TestCase
{
    use InteractsWithHerdOrValet;

    public function test_isParkedOnHerdOrValet_returns_false_when_output_is_not_json(): void
    {
        $mockProcess = $this->getMockBuilder(Process::class)->disableOriginalConstructor()->getMock();
        $mockProcess->method('isSuccessful')->willReturn(true);
        $mockProcess->method('getOutput')->willReturn('No paths have been registered.');

        $this->assertFalse($this->isParkedOnHerdOrValet('paths'));
    }
}
