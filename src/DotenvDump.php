<?php

namespace SD\DotenvDump;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;

class DotenvDump implements PluginInterface, Capable
{
    public function activate(Composer $composer, IOInterface $io)
    {
    }

    public function getCapabilities()
    {
        return [
            CommandProvider::class => \SD\DotenvDump\CommandProvider::class,
        ];
    }
}