<?php

use LaravelPlus\Extension\Repository\ConfigLoader;

class ConfigLoaderTests extends TestCase
{
    public function test_withNoParameter()
    {
        $command = new ConfigLoader();

        Assert::isInstanceOf(ConfigLoader::class, $command);
    }
}