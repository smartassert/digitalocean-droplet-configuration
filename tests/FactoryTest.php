<?php

declare(strict_types=1);

namespace SmartAssert\DigitalOceanDropletConfiguration\Tests;

use PHPUnit\Framework\TestCase;
use SmartAssert\DigitalOceanDropletConfiguration\Configuration;
use SmartAssert\DigitalOceanDropletConfiguration\Factory;

class FactoryTest extends TestCase
{
    /**
     * @param array<string, mixed> $values
     *
     * @dataProvider createDataProvider
     */
    public function testCreate(Factory $factory, array $values, Configuration $expectedConfiguration): void
    {
        self::assertEquals($expectedConfiguration, $factory->create($values));
    }

    /**
     * @return array<mixed>
     */
    public function createDataProvider(): array
    {
        return [
            'default, no values' => [
                'factory' => new Factory(),
                'values' => [],
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
            'non-default, no values' => [
                'factory' => new Factory([
                    Factory::KEY_NAMES => ['name1', 'name2'],
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => true,
                    Factory::KEY_SSH_KEYS => [101, 102],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ]),
                'values' => [],
                'expectedConfiguration' => new Configuration(
                    ['name1', 'name2'],
                    'custom-region',
                    'custom-size',
                    'custom-image',
                    true,
                    true,
                    true,
                    [101, 102],
                    'custom user data',
                    false,
                    ['volume1', 'volume2'],
                    ['tag1', 'tag2'],
                ),
            ],
            'default, has values' => [
                'factory' => new Factory(),
                'values' => [
                    Factory::KEY_NAMES => ['name1', 'name2'],
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => true,
                    Factory::KEY_SSH_KEYS => [101, 102],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ],
                'expectedConfiguration' => new Configuration(
                    ['name1', 'name2'],
                    'custom-region',
                    'custom-size',
                    'custom-image',
                    true,
                    true,
                    true,
                    [101, 102],
                    'custom user data',
                    false,
                    ['volume1', 'volume2'],
                    ['tag1', 'tag2'],
                ),
            ],
            'non-default, has values' => [
                'factory' => new Factory([
                    Factory::KEY_NAMES => ['name1', 'name2'],
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => true,
                    Factory::KEY_SSH_KEYS => [101, 102],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ]),
                'values' => [
                    Factory::KEY_NAMES => ['name3'],
                    Factory::KEY_REGION => 'override-region',
                    Factory::KEY_SIZE => 'override-size',
                    Factory::KEY_IMAGE => 'override-image',
                    Factory::KEY_BACKUPS => false,
                    Factory::KEY_IPV6 => false,
                    Factory::KEY_VPC_UUID => false,
                    Factory::KEY_SSH_KEYS => [103],
                    Factory::KEY_USER_DATA => 'override user data',
                    Factory::KEY_MONITORING => true,
                    Factory::KEY_VOLUMES => ['volume3'],
                    Factory::KEY_TAGS => ['tag3'],
                ],
                'expectedConfiguration' => new Configuration(
                    ['name3'],
                    'override-region',
                    'override-size',
                    'override-image',
                    false,
                    false,
                    false,
                    [103],
                    'override user data',
                    true,
                    ['volume3'],
                    ['tag3'],
                ),
            ],
            'default, no values should create monitoring=true' => [
                'factory' => new Factory(),
                'values' => [],
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
                    [],
                ),
            ],
            'empty default, no values should create monitoring=true' => [
                'factory' => new Factory([]),
                'values' => [],
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
                    [],
                ),
            ],
        ];
    }
}
