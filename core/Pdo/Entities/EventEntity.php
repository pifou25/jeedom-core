<?php

namespace Jeedom\Pdo\Entities;

class EventEntity extends Entity
{
	public const TABLE_NAME = 'event';
	public const DATETIME = 'datetime';
	public const NAME = 'name';
	public const OPTION = 'option';

	/** @var string */
	protected $datetime;

	/** @var string */
	protected $name;

	/** @var string */
	protected $option;


	public function getDatetime(): ?string
	{
		return $this->datetime;
	}


	public function setDatetime(?string $value): self
	{
		$this['datetime'] = $value;
		return $this;
	}


	public function getName(): ?string
	{
		return $this->name;
	}


	public function setName(?string $value): self
	{
		$this['name'] = $value;
		return $this;
	}


	public function getOption(): ?string
	{
		return $this->option;
	}


	public function setOption(?string $value): self
	{
		$this['option'] = $value;
		return $this;
	}
}
