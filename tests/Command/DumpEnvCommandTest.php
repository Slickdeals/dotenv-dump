<?php

/*
 * Derived from Flex tests.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SD\DotenvDump\Tests\Command;

use Composer\Config;
use Composer\Console\Application;
use PHPUnit\Framework\TestCase;
use SD\DotenvDump\Command\DumpEnvCommand;
use Symfony\Component\Console\Tester\CommandTester;

class DumpEnvCommandTest extends TestCase
{
    public function testFileWritten()
    {
        @mkdir(TEST_DIR);
        $env = TEST_DIR . '/.env';
        $envLocal = TEST_DIR . '/.env.local.php';
        @\unlink($env);
        @\unlink($envLocal);

        $envContent = <<<EOF
APP_ENV=dev
APP_SECRET=abcdefgh123456789
EOF;
        \file_put_contents($env, $envContent);

        $command = $this->createCommand();
        $command->execute([
            'env' => 'prod',
        ]);

        $this->assertFileExists($envLocal);

        $vars = require $envLocal;
        $this->assertSame([
            'APP_ENV' => 'prod',
            'APP_SECRET' => 'abcdefgh123456789',
        ], $vars);

        \unlink($env);
        \unlink($envLocal);
    }

    private function createCommand()
    {
        $command = new DumpEnvCommand(new Config(false, __DIR__ . '/../..'), TEST_DIR);
        $application = new Application();
        $application->add($command);
        $command = $application->find('dump-env');

        return new CommandTester($command);
    }
}