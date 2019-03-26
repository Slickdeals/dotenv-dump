<?php

namespace SD\DotenvDump;

use Composer\Composer;
use SD\DotenvDump\Command\DumpEnvCommand;

class CommandProvider implements \Composer\Plugin\Capability\CommandProvider
{
    private $deps;

    public function __construct(array $deps)
    {
        $this->deps = $deps;
    }

    /**
     * Retrieves an array of commands
     *
     * @return \Composer\Command\BaseCommand[]
     */
    public function getCommands()
    {
        /** @var Composer $composer */
        $composer = $this->deps['composer'];
        return [
            new DumpEnvCommand($composer->getConfig(), $composer->getPackage()->getExtra()['symfony']['root-dir'] ?? '.'),
        ];
    }
}