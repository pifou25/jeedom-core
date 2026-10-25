<?php

namespace Jeedom\Pdo\Entities;

class DataStoreEntity extends Entity
{
	public const TABLE_NAME = 'dataStore';
	public const ID = 'id';
	public const TYPE = 'type';
	public const LINK_ID = 'link_id';
	public const KEY = 'key';
	public const VALUE = 'value';

	/** @var int */
	protected $id;

	/** @var string */
	protected $type;

	/** @var int */
	protected $link_id;

	/** @var string */
	protected $key;

	/** @var string */
	protected $value;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getType(): string
	{
		return $this->type;
	}


	public function setType(string $value): self
	{
		$this['type'] = $value;
		return $this;
	}


	public function getLinkId(): int
	{
		return $this->link_id;
	}


	public function setLinkId(int $value): self
	{
		$this['link_id'] = $value;
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
