<?php

namespace Jeedom\Pdo\Entities;

class ScenarioElementEntity extends Entity
{
	public const TABLE_NAME = 'scenarioElement';
	public const ID = 'id';
	public const ORDER = 'order';
	public const TYPE = 'type';
	public const NAME = 'name';
	public const OPTIONS = 'options';
	public const LOG = 'log';

	/** @var int */
	protected $id;

	/** @var int */
	protected $order;

	/** @var string */
	protected $type;

	/** @var string */
	protected $name;

	/** @var string */
	protected $options;

	/** @var string */
	protected $log;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getOrder(): int
	{
		return $this->order;
	}


	public function setOrder(int $value): self
	{
		$this['order'] = $value;
		return $this;
	}


	public function getType(): ?string
	{
		return $this->type;
	}


	public function setType(?string $value): self
	{
		$this['type'] = $value;
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


	public function getOptions(): ?string
	{
		return $this->options;
	}


	public function setOptions(?string $value): self
	{
		$this['options'] = $value;
		return $this;
	}


	public function getLog(): ?string
	{
		return $this->log;
	}


	public function setLog(?string $value): self
	{
		$this['log'] = $value;
		return $this;
	}
}
