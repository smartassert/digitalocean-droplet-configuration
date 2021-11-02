<?php

namespace SmartAssert\DigitalOceanDropletConfiguration;

class Factory
{
    public const KEY_NAMES = 'names';
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

    private const DEFAULT_NAMES = [];
    private const DEFAULT_REGION = '';
    private const DEFAULT_SIZE = '';
    private const DEFAULT_IMAGE = '';
    private const DEFAULT_BACKUPS = false;
    private const DEFAULT_IPV6 = false;
    private const DEFAULT_VPC_UUID = false;
    private const DEFAULT_SSH_KEYS = [];
    private const DEFAULT_USER_DATA = '';
    private const DEFAULT_MONITORING = true;
    private const DEFAULT_VOLUMES = [];
    private const DEFAULT_TAGS = [];

    /**
     * @param array<mixed> $defaults
     */
    public function __construct(
        private array $defaults = [
            self::KEY_NAMES => self::DEFAULT_NAMES,
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
    ) {
    }

    public function create(): Configuration
    {
        return new Configuration(
            $this->getStringValues(self::KEY_NAMES),
            $this->getStringValue(self::KEY_REGION),
            $this->getStringValue(self::KEY_SIZE),
            $this->getStringValue(self::KEY_IMAGE),
            $this->getBooleanValue(self::KEY_BACKUPS),
            $this->getBooleanValue(self::KEY_IPV6),
            $this->getVpcUuidValue(),
            $this->getSshKeyValues(),
            $this->getStringValue(self::KEY_USER_DATA),
            $this->getBooleanValue(self::KEY_MONITORING, true),
            $this->getStringValues(self::KEY_VOLUMES),
            $this->getStringValues(self::KEY_TAGS),
        );
    }

    private function getVpcUuidValue(): string | bool
    {
        $value = $this->defaults[self::KEY_VPC_UUID] ?? false;

        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            return $value;
        }

        return false;
    }

    /**
     * @return string[]
     */
    private function getStringValues(string $key): array
    {
        $values = $this->getValues($key);

        return array_filter($values, function ($item) {
            return is_string($item);
        });
    }

    /**
     * @return array<int|string>
     */
    private function getSshKeyValues(): array
    {
        $values = $this->getValues(self::KEY_SSH_KEYS);

        return array_filter($values, function ($item) {
            return is_int($item) || is_string($item);
        });
    }

    /**
     * @return array<mixed>
     */
    private function getValues(string $key): array
    {
        $values = $this->defaults[$key] ?? [];

        return is_array($values) ? $values : [];
    }

    private function getStringValue(string $key): string
    {
        $value = $this->defaults[$key] ?? '';

        if (is_string($value)) {
            return $value;
        }

        if (is_scalar($value)) {
            return (string) $value;
        }

        return '';
    }

    private function getBooleanValue(string $key, bool $default = false): bool
    {
        $value = $this->defaults[$key] ?? '';

        if (is_bool($value)) {
            return $value;
        }

        if (is_scalar($value)) {
            return (bool) $value;
        }

        return $default;
    }
}
