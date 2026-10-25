<?php

namespace Jeedom\Pdo\Entities;

class ConfigEntity extends Entity
{
	public const TABLE_NAME = 'config';
	public const PLUGIN = 'plugin';
	public const KEY = 'key';
	public const VALUE = 'value';

	/** @var string */
	protected $plugin;

	/** @var string */
	protected $key;

	/** @var string */
	protected $value;


	public function getPlugin(): string
	{
		return $this->plugin;
	}


	public function setPlugin(string $value): self
	{
		$this['plugin'] = $value;
		return $this;
	}


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
}
