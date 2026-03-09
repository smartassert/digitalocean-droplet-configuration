<?php

namespace SmartAssert\DigitalOceanDropletConfiguration;

class Configuration
{
    /**
     * @param int[]    $sshKeys
     * @param string[] $volumes
     * @param string[] $tags
     */
    public function __construct(
        private string $name,
        private ?string $region,
        private string $size,
        private string $image,
        private ?bool $backups,
        private ?bool $ipv6,
        private ?string $vpcUuid,
        private ?array $sshKeys,
        private ?string $userData,
        private ?bool $monitoring,
        private ?array $volumes,
        private ?array $tags,
    ) {
        if (is_array($sshKeys)) {
            $this->setSshKeys($sshKeys);
        }

        if (is_array($volumes)) {
            $this->setVolumes($volumes);
        }

        if (is_array($tags)) {
            $this->setTags($tags);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRegion(): ?string
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

    public function getBackups(): ?bool
    {
        return $this->backups;
    }

    public function getIpv6(): ?bool
    {
        return $this->ipv6;
    }

    public function getVpcUuid(): ?string
    {
        return $this->vpcUuid;
    }

    /**
     * @return null|int[]
     */
    public function getSshKeys(): ?array
    {
        return $this->sshKeys;
    }

    public function getUserData(): ?string
    {
        return $this->userData;
    }

    public function getMonitoring(): ?bool
    {
        return $this->monitoring;
    }

    /**
     * @return null|string[]
     */
    public function getVolumes(): ?array
    {
        return $this->volumes;
    }

    /**
     * @return null|string[]
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function withName(string $name): self
    {
        $new = clone $this;
        $new->name = $name;

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

    public function withVpcUuid(string $vpcUuid): self
    {
        $new = clone $this;
        $new->vpcUuid = $vpcUuid;

        return $new;
    }

    /**
     * @param array<mixed> $sshKeys
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

    public function appendUserData(string $userData): self
    {
        $new = clone $this;
        $new->userData .= $userData;

        return $new;
    }

    public function withMonitoring(bool $monitoring): self
    {
        $new = clone $this;
        $new->monitoring = $monitoring;

        return $new;
    }

    /**
     * @param array<mixed> $volumes
     */
    public function withVolumes(array $volumes): self
    {
        $new = clone $this;
        $new->setVolumes($volumes);

        return $new;
    }

    /**
     * @param array<mixed> $tags
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
        $newTags = $tags;
        if (null !== $this->tags) {
            $newTags = array_merge($this->tags, $tags);
        }

        $new = clone $this;

        return $new->withTags($newTags);
    }

    public function setBackups(bool $backups): self
    {
        $new = clone $this;
        $new->backups = $backups;

        return $new;
    }

    /**
     * @param array<mixed> $sshKeys
     */
    public function setSshKeys(array $sshKeys): void
    {
        $sshKeys = array_filter($sshKeys, function ($item) {
            return is_int($item);
        });

        $sshKeys = array_unique($sshKeys);
        $sshKeys = [] === $sshKeys ? null : $sshKeys;

        $this->sshKeys = $sshKeys;
    }

    /**
     * @param array<mixed> $volumes
     */
    public function setVolumes(array $volumes): void
    {
        $volumes = array_filter($volumes, function ($item) {
            return is_string($item);
        });

        $volumes = array_unique($volumes);
        $volumes = [] === $volumes ? null : $volumes;

        $this->volumes = $volumes;
    }

    /**
     * @param array<mixed> $tags
     */
    public function setTags(array $tags): void
    {
        $tags = array_filter($tags, function ($item) {
            return is_string($item);
        });

        $tags = array_unique($tags);
        $tags = [] === $tags ? null : $tags;

        $this->tags = $tags;
    }
}
