<?php

namespace SmartAssert\DigitalOceanDropletConfiguration;

class Configuration
{
    /**
     * @param string[]          $names
     * @param string            $region
     * @param string            $size
     * @param string            $image
     * @param bool              $backups
     * @param bool              $ipv6
     * @param bool|string       $vpcUuid
     * @param array<int|string> $sshKeys
     * @param string            $userData
     * @param bool              $monitoring
     * @param string[]          $volumes
     * @param string[]          $tags
     */
    public function __construct(
        private array $names,
        private string $region,
        private string $size,
        private string $image,
        private bool $backups,
        private bool $ipv6,
        private string | bool $vpcUuid,
        private array $sshKeys,
        private string $userData,
        private bool $monitoring,
        private array $volumes,
        private array $tags,
    ) {
        $this->setNames($names);
        $this->setSshKeys($sshKeys);
        $this->setVolumes($volumes);
        $this->setTags($tags);
    }

    /**
     * @return string[]
     */
    public function getNames(): array
    {
        return $this->names;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getBackups(): bool
    {
        return $this->backups;
    }

    public function getIpv6(): bool
    {
        return $this->ipv6;
    }

    public function getVpcUuid(): string | bool
    {
        return $this->vpcUuid;
    }

    /**
     * @return array<int|string>
     */
    public function getSshKeys(): array
    {
        return $this->sshKeys;
    }

    public function getUserData(): string
    {
        return $this->userData;
    }

    public function getMonitoring(): bool
    {
        return $this->monitoring;
    }

    /**
     * @return string[]
     */
    public function getVolumes(): array
    {
        return $this->volumes;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param string[] $names
     */
    public function withNames(array $names): self
    {
        $new = clone $this;
        $new->setNames($names);

        return $new;
    }

    public function withRegion(string $region): self
    {
        $new = clone $this;
        $new->region = $region;

        return $new;
    }

    public function withSize(string $size): self
    {
        $new = clone $this;
        $new->size = $size;

        return $new;
    }

    public function withImage(string $image): self
    {
        $new = clone $this;
        $new->image = $image;

        return $new;
    }

    public function withBackups(bool $backups): self
    {
        $new = clone $this;
        $new->backups = $backups;

        return $new;
    }

    public function withIpv6(bool $ipv6): self
    {
        $new = clone $this;
        $new->ipv6 = $ipv6;

        return $new;
    }

    public function withVpcUuid(string | bool $vpcUuid): self
    {
        $new = clone $this;
        $new->vpcUuid = $vpcUuid;

        return $new;
    }

    /**
     * @param int[] $sshKeys
     */
    public function withSshKeys(array $sshKeys): self
    {
        $new = clone $this;
        $new->setSshKeys($sshKeys);

        return $new;
    }

    public function withUserData(string $userData): self
    {
        $new = clone $this;
        $new->userData = $userData;

        return $new;
    }

    public function withMonitoring(bool $monitoring): self
    {
        $new = clone $this;
        $new->monitoring = $monitoring;

        return $new;
    }

    /**
     * @param string[] $volumes
     */
    public function withVolumes(array $volumes): self
    {
        $new = clone $this;
        $new->setVolumes($volumes);

        return $new;
    }

    /**
     * @param string[] $tags
     */
    public function withTags(array $tags): self
    {
        $new = clone $this;
        $new->setTags($tags);

        return $new;
    }

    /**
     * @param string[] $tags
     */
    public function addTags(array $tags): self
    {
        $new = clone $this;
        $tags = array_merge($this->tags, $tags);

        return $new->withTags($tags);
    }

    public function setBackups(bool $backups): self
    {
        $new = clone $this;
        $new->backups = $backups;

        return $new;
    }

    /**
     * @param array<int|string> $sshKeys
     */
    public function setSshKeys(array $sshKeys): void
    {
        $sshKeys = array_filter($sshKeys, function ($item) {
            return is_int($item) || is_string($item);
        });

        $this->sshKeys = array_unique($sshKeys);
    }

    /**
     * @param string[] $volumes
     */
    public function setVolumes(array $volumes): void
    {
        $volumes = array_filter($volumes, function ($item) {
            return is_string($item);
        });

        $this->volumes = array_unique($volumes);
    }

    /**
     * @param string[] $tags
     */
    public function setTags(array $tags): void
    {
        $tags = array_filter($tags, function ($item) {
            return is_string($item);
        });

        $this->tags = array_unique($tags);
    }

    /**
     * @param string[] $names
     */
    private function setNames(array $names): void
    {
        $names = array_filter($names, function ($item) {
            return is_string($item);
        });

        $this->names = array_unique($names);
    }
}
