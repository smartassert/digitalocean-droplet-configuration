<?php

declare(strict_types=1);

namespace SmartAssert\DigitalOceanDropletConfiguration\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SmartAssert\DigitalOceanDropletConfiguration\Configuration;
use SmartAssert\DigitalOceanDropletConfiguration\Factory;

class FactoryTest extends TestCase
{
    /**
     * @param array<string, mixed> $values
     */
    #[DataProvider('createDataProvider')]
    public function testCreate(Factory $factory, array $values, Configuration $expectedConfiguration): void
    {
        self::assertEquals($expectedConfiguration, $factory->create($values));
    }

    /**
     * @return array<mixed>
     */
    public static function createDataProvider(): array
    {
        return [
            'default, no values' => [
                'factory' => new Factory(),
                'values' => [],
                'expectedConfiguration' => new Configuration(
                    '',
                    '',
                    '',
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ),
            ],
            'non-default, no values' => [
                'factory' => new Factory([
                    Factory::KEY_NAME => 'name1',
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => 'vpc_uuid',
                    Factory::KEY_SSH_KEYS => [101, 102],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ]),
                'values' => [],
                'expectedConfiguration' => new Configuration(
                    'name1',
                    'custom-size',
                    'custom-image',
                    'custom-region',
                    true,
                    true,
                    'vpc_uuid',
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
                    Factory::KEY_NAME => 'name1',
                    Factory::KEY_REGION => 'custom-region',
                    Factory::KEY_SIZE => 'custom-size',
                    Factory::KEY_IMAGE => 'custom-image',
                    Factory::KEY_BACKUPS => true,
                    Factory::KEY_IPV6 => true,
                    Factory::KEY_VPC_UUID => 'vpc_uuid',
                    Factory::KEY_SSH_KEYS => [101, 102],
                    Factory::KEY_USER_DATA => 'custom user data',
                    Factory::KEY_MONITORING => false,
                    Factory::KEY_VOLUMES => ['volume1', 'volume2'],
                    Factory::KEY_TAGS => ['tag1', 'tag2'],
                ],
                'expectedConfiguration' => new Configuration(
                    'name1',
                    'custom-size',
                    'custom-image',
                    'custom-region',
                    true,
                    true,
                    'vpc_uuid',
                    [101, 102],
                    'custom user data',
                    false,
                    ['volume1', 'volume2'],
                    ['tag1', 'tag2'],
                ),
            ],
            'non-default, has values' => [
                'factory' => new Factory([
                    Factory::KEY_NAME => 'name1',
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
                    Factory::KEY_NAME => 'name3',
                    Factory::KEY_REGION => 'override-region',
                    Factory::KEY_SIZE => 'override-size',
                    Factory::KEY_IMAGE => 'override-image',
                    Factory::KEY_BACKUPS => false,
                    Factory::KEY_IPV6 => false,
                    Factory::KEY_VPC_UUID => 'vpc_uuid',
                    Factory::KEY_SSH_KEYS => [103],
                    Factory::KEY_USER_DATA => 'override user data',
                    Factory::KEY_MONITORING => true,
                    Factory::KEY_VOLUMES => ['volume3'],
                    Factory::KEY_TAGS => ['tag3'],
                ],
                'expectedConfiguration' => new Configuration(
                    'name3',
                    'override-size',
                    'override-image',
                    'override-region',
                    false,
                    false,
                    'vpc_uuid',
                    [103],
                    'override user data',
                    true,
                    ['volume3'],
                    ['tag3'],
                ),
            ],
        ];
    }
}
