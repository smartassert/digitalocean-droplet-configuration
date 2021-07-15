<?php

declare(strict_types=1);

namespace SmartAssert\DigitalOceanDropletConfiguration\Tests;

use PHPUnit\Framework\TestCase;
use SmartAssert\DigitalOceanDropletConfiguration\Configuration;
use SmartAssert\DigitalOceanDropletConfiguration\Factory;

class FactoryTest extends TestCase
{
    /**
     * @dataProvider createDataProvider
     */
    public function testCreate(Factory $factory, Configuration $expectedConfiguration): void
    {
        self::assertEquals($expectedConfiguration, $factory->create());
    }

    /**
     * @return array<mixed>
     */
    public function createDataProvider(): array
    {
        return [
            'default' => [
                'factory' => new Factory(),
                'expectedConfiguration' => new Configuration(
                    [],
                    '',
                    '',
                    '',
                    false,
                    false,
                    false,
                    [],
                    '',
                    true,
                    [],
                    []
                ),
            ],
            'non-default' => [
                'factory' => new Factory([
                    Factory::KEY_NAMES => ['name1', 'name2'],
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => true,
                    Factory::KEY_SSH_KEYS => ['ssh-key-1', 'ssh-key-2'],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ]),
                'expectedConfiguration' => new Configuration(
                    ['name1', 'name2'],
                    'custom-region',
                    'custom-size',
                    'custom-image',
                    true,
                    true,
                    true,
                    ['ssh-key-1', 'ssh-key-2'],
                    'custom user data',
                    false,
                    ['volume1', 'volume2'],
                    ['tag1', 'tag2'],
                ),
            ],
        ];
    }
}
