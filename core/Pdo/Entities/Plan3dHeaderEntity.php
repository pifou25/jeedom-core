<?php

namespace Jeedom\Pdo\Entities;

class Plan3dHeaderEntity extends Entity
{
	public const TABLE_NAME = 'plan3dHeader';
	public const ID = 'id';
	public const NAME = 'name';
	public const ORDER = 'order';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var int */
	protected $order;

	/** @var string */
	protected $configuration;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
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


	public function getOrder(): ?int
	{
		return $this->order;
	}


	public function setOrder(?int $value): self
	{
		$this['order'] = $value;
		return $this;
	}


	public function getConfiguration(): ?string
	{
		return $this->configuration;
	}


	public function setConfiguration(?string $value): self
	{
		$this['configuration'] = $value;
		return $this;
	}
}
