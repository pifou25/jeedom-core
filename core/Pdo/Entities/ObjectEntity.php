<?php

namespace Jeedom\Pdo\Entities;

class ObjectEntity extends Entity
{
	public const TABLE_NAME = 'object';
	public const ID = 'id';
	public const NAME = 'name';
	public const FATHER_ID = 'father_id';
	public const IS_VISIBLE = 'isVisible';
	public const POSITION = 'position';
	public const CONFIGURATION = 'configuration';
	public const DISPLAY = 'display';
	public const IMAGE = 'image';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var int */
	protected $father_id;

	/** @var bool */
	protected $isVisible;

	/** @var int */
	protected $position;

	/** @var string */
	protected $configuration;

	/** @var string */
	protected $display;

	/** @var string */
	protected $image;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function setName(string $value): self
	{
		$this['name'] = $value;
		return $this;
	}


	public function getFatherId(): ?int
	{
		return $this->father_id;
	}


	public function setFatherId(?int $value): self
	{
		$this['father_id'] = $value;
		return $this;
	}


	public function getIsVisible(): ?bool
	{
		return $this->isVisible;
	}


	public function setIsVisible(?bool $value): self
	{
		$this['isVisible'] = $value;
		return $this;
	}


	public function getPosition(): ?int
	{
		return $this->position;
	}


	public function setPosition(?int $value): self
	{
		$this['position'] = $value;
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


	public function getDisplay(): ?string
	{
		return $this->display;
	}


	public function setDisplay(?string $value): self
	{
		$this['display'] = $value;
		return $this;
	}


	public function getImage(): ?string
	{
		return $this->image;
	}


	public function setImage(?string $value): self
	{
		$this['image'] = $value;
		return $this;
	}
}
