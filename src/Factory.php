<?php

namespace SmartAssert\DigitalOceanDropletConfiguration;

class Factory
{
    public const KEY_NAME = 'name';
    public const KEY_REGION = 'region';
    public const KEY_SIZE = 'size';
    public const KEY_IMAGE = 'image';
    public const KEY_BACKUPS = 'backups';
    public const KEY_IPV6 = 'ipv6';
    public const KEY_VPC_UUID = 'vpc-uuid';
    public const KEY_SSH_KEYS = 'ssk-keys';
    public const KEY_USER_DATA = 'user-data';
    public const KEY_MONITORING = 'monitoring';
    public const KEY_VOLUMES = 'volumes';
    public const KEY_TAGS = 'tags';

    private const DEFAULT_NAME = '';
    private const DEFAULT_REGION = null;
    private const DEFAULT_SIZE = '';
    private const DEFAULT_IMAGE = '';
    private const DEFAULT_BACKUPS = null;
    private const DEFAULT_IPV6 = null;
    private const DEFAULT_VPC_UUID = null;
    private const DEFAULT_SSH_KEYS = null;
    private const DEFAULT_USER_DATA = null;
    private const DEFAULT_MONITORING = null;
    private const DEFAULT_VOLUMES = null;
    private const DEFAULT_TAGS = null;

    /**
     * @param array<string, mixed> $defaults
     */
    public function __construct(
        private array $defaults = [
            self::KEY_NAME => self::DEFAULT_NAME,
            self::KEY_REGION => self::DEFAULT_REGION,
            self::KEY_SIZE => self::DEFAULT_SIZE,
            self::KEY_IMAGE => self::DEFAULT_IMAGE,
            self::KEY_BACKUPS => self::DEFAULT_BACKUPS,
            self::KEY_IPV6 => self::DEFAULT_IPV6,
            self::KEY_VPC_UUID => self::DEFAULT_VPC_UUID,
            self::KEY_SSH_KEYS => self::DEFAULT_SSH_KEYS,
            self::KEY_USER_DATA => self::DEFAULT_USER_DATA,
            self::KEY_MONITORING => self::DEFAULT_MONITORING,
            self::KEY_VOLUMES => self::DEFAULT_VOLUMES,
            self::KEY_TAGS => self::DEFAULT_TAGS,
        ]
    ) {}

    /**
     * @param array<string, mixed> $values
     */
    public function create(array $values = []): Configuration
    {
        $data = array_merge($this->defaults, $values);

        return new Configuration(
            $this->getStringValue($data, self::KEY_NAME),
            $this->getStringValueOrNull($data, self::KEY_REGION),
            $this->getStringValue($data, self::KEY_SIZE),
            $this->getStringValue($data, self::KEY_IMAGE),
            $this->getBooleanValueOrNull($data, self::KEY_BACKUPS),
            $this->getBooleanValueOrNull($data, self::KEY_IPV6),
            $this->getVpcUuidValue($data),
            $this->getSshKeyValues($data),
            $this->getStringValueOrNull($data, self::KEY_USER_DATA),
            $this->getBooleanValueOrNull($data, self::KEY_MONITORING),
            $this->getStringValuesOrNull($data, self::KEY_VOLUMES),
            $this->getStringValuesOrNull($data, self::KEY_TAGS),
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getVpcUuidValue(array $data): ?string
    {
        $value = $data[self::KEY_VPC_UUID] ?? false;

        if (is_string($value)) {
            return $value;
        }

        return null;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return null|string[]
     */
    private function getStringValuesOrNull(array $data, string $key): ?array
    {
        $values = $this->getValues($data, $key);

        $values = array_filter($values, function ($item) {
            return is_string($item);
        });

        return [] === $values ? null : $values;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return null|int[]
     */
    private function getSshKeyValues(array $data): ?array
    {
        $values = $this->getValues($data, self::KEY_SSH_KEYS);

        $values = array_filter($values, function ($item) {
            return is_int($item);
        });

        return [] === $values ? null : $values;
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return array<mixed>
     */
    private function getValues(array $data, string $key): array
    {
        $values = $data[$key] ?? [];

        return is_array($values) ? $values : [];
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getStringValue(array $data, string $key): string
    {
        $value = $data[$key] ?? '';

        if (is_string($value)) {
            return $value;
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return '';
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getStringValueOrNull(array $data, string $key): ?string
    {
        $value = $data[$key] ?? null;

        return is_string($value) ? $value : null;
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getBooleanValueOrNull(array $data, string $key): ?bool
    {
        $value = $data[$key] ?? null;

        return is_bool($value) ? $value : null;
    }
}
