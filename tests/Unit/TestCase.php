<?php

namespace IMusic\ZplBuilder\Tests\Unit;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function readMock(string $path)
    {
        return \file_get_contents(__DIR__ . '/../mocks/' . $path);
    }
}
