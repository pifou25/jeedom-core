<?php

namespace Jeedom\Pdo\Entities;

class ViewZoneEntity extends Entity
{
	public const TABLE_NAME = 'viewZone';
	public const ID = 'id';
	public const VIEW_ID = 'view_id';
	public const TYPE = 'type';
	public const NAME = 'name';
	public const POSITION = 'position';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var int */
	protected $view_id;

	/** @var string */
	protected $type;

	/** @var string */
	protected $name;

	/** @var int */
	protected $position;

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


	public function getViewId(): int
	{
		return $this->view_id;
	}


	public function setViewId(int $value): self
	{
		$this['view_id'] = $value;
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
}
