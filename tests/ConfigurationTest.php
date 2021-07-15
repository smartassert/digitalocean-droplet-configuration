<?php

declare(strict_types=1);

namespace SmartAssert\DigitalOceanDropletConfiguration\Tests;

use PHPUnit\Framework\TestCase;
use SmartAssert\DigitalOceanDropletConfiguration\Configuration;
use SmartAssert\DigitalOceanDropletConfiguration\Factory;

class ConfigurationTest extends TestCase
{
    /**
     * @dataProvider getNamesDataProvider
     *
     * @param string[] $expectedNames
     */
    public function testGetNames(Configuration $configuration, array $expectedNames): void
    {
        self::assertSame($expectedNames, $configuration->getNames());
    }

    /**
     * @return array<mixed>
     */
    public function getNamesDataProvider(): array
    {
        $factory = new Factory();

        return [
            'none' => [
                'configuration' => $factory->create(),
                'expectedNames' => [],
            ],
            'no valid' => [
                'configuration' => $factory->create()->withNames([
                    1,
                    true,
                    new \stdClass(),
                ]),
                'expectedNames' => [],
            ],
            'valid' => [
                'configuration' => $factory->create()->withNames([
                    'one',
                    'two',
                ]),
                'expectedNames' => [
                    'one',
                    'two',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getSshKeysDataProvider
     *
     * @param int[] $expectedSshKeys
     */
    public function testGetSshKeys(Configuration $configuration, array $expectedSshKeys): void
    {
        self::assertSame($expectedSshKeys, $configuration->getSshKeys());
    }

    /**
     * @return array<mixed>
     */
    public function getSshKeysDataProvider(): array
    {
        $factory = new Factory();

        return [
            'none' => [
                'configuration' => $factory->create(),
                'expectedSshKeys' => [],
            ],
            'no valid' => [
                'configuration' => $factory->create()->withSshKeys([
                    'string',
                    true,
                    new \stdClass(),
                ]),
                'expectedSshKeys' => [],
            ],
            'valid' => [
                'configuration' => $factory->create()->withSshKeys([
                    1,
                    2,
                ]),
                'expectedSshKeys' => [
                    1,
                    2,
                ],
            ],
        ];
    }

    /**
     * @dataProvider getVolumesDataProvider
     *
     * @param string[] $expectedVolumes
     */
    public function testGetVolumes(Configuration $configuration, array $expectedVolumes): void
    {
        self::assertSame($expectedVolumes, $configuration->getVolumes());
    }

    /**
     * @return array<mixed>
     */
    public function getVolumesDataProvider(): array
    {
        $factory = new Factory();

        return [
            'none' => [
                'configuration' => $factory->create(),
                'expectedVolumes' => [],
            ],
            'no valid' => [
                'configuration' => $factory->create()->withVolumes([
                    1,
                    true,
                    new \stdClass(),
                ]),
                'expectedVolumes' => [],
            ],
            'valid' => [
                'configuration' => $factory->create()->withVolumes([
                    'one',
                    'two',
                ]),
                'expectedVolumes' => [
                    'one',
                    'two',
                ],
            ],
        ];
    }

    /**
     * @dataProvider getTagsDataProvider
     *
     * @param string[] $expectedTags
     */
    public function testGetTags(Configuration $configuration, array $expectedTags): void
    {
        self::assertSame($expectedTags, $configuration->getTags());
    }

    /**
     * @return array<mixed>
     */
    public function getTagsDataProvider(): array
    {
        $factory = new Factory();

        return [
            'none' => [
                'configuration' => $factory->create(),
                'expectedTags' => [],
            ],
            'no valid' => [
                'configuration' => $factory->create()->withTags([
                    1,
                    true,
                    new \stdClass(),
                ]),
                'expectedTags' => [],
            ],
            'valid' => [
                'configuration' => $factory->create()->withTags([
                    'one',
                    'two',
                ]),
                'expectedTags' => [
                    'one',
                    'two',
                ],
            ],
        ];
    }

    public function testAddTags(): void
    {
        $factory = new Factory();
        $configuration = $factory->create();

        self::assertSame([], $configuration->getTags());

        $configuration = $configuration->addTags(['one']);
        self::assertSame(['one'], $configuration->getTags());

        $configuration = $configuration->addTags(['two']);
        self::assertSame(['one', 'two'], $configuration->getTags());

        $configuration = $configuration->addTags(['one']);
        self::assertSame(['one', 'two'], $configuration->getTags());
    }
}
