<?php

namespace Jeedom\Pdo\Entities;

class CacheEntity extends Entity
{
	public const TABLE_NAME = 'cache';
	public const KEY = 'key';
	public const VALUE = 'value';
	public const TIMESTAMP = 'timestamp';
	public const LIFETIME = 'lifetime';

	/** @var string */
	protected $key;

	/** @var string */
	protected $value;

	/** @var int */
	protected $timestamp;

	/** @var int */
	protected $lifetime;


	public function getKey(): string
	{
		return $this->key;
	}


	public function setKey(string $value): self
	{
		$this['key'] = $value;
		return $this;
	}


	public function getValue(): ?string
	{
		return $this->value;
	}


	public function setValue(?string $value): self
	{
		$this['value'] = $value;
		return $this;
	}


	public function getTimestamp(): ?int
	{
		return $this->timestamp;
	}


	public function setTimestamp(?int $value): self
	{
		$this['timestamp'] = $value;
		return $this;
	}


	public function getLifetime(): ?int
	{
		return $this->lifetime;
	}


	public function setLifetime(?int $value): self
	{
		$this['lifetime'] = $value;
		return $this;
	}
}
