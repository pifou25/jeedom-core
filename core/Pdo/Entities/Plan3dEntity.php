<?php

namespace Jeedom\Pdo\Entities;

class Plan3dEntity extends Entity
{
	public const TABLE_NAME = 'plan3d';
	public const ID = 'id';
	public const NAME = 'name';
	public const PLAN3D_HEADER_ID = 'plan3dHeader_id';
	public const LINK_TYPE = 'link_type';
	public const LINK_ID = 'link_id';
	public const POSITION = 'position';
	public const DISPLAY = 'display';
	public const CSS = 'css';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var int */
	protected $plan3dHeader_id;

	/** @var string */
	protected $link_type;

	/** @var string */
	protected $link_id;

	/** @var string */
	protected $position;

	/** @var string */
	protected $display;

	/** @var string */
	protected $css;

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


	public function getPlan3dHeaderId(): int
	{
		return $this->plan3dHeader_id;
	}


	public function setPlan3dHeaderId(int $value): self
	{
		$this['plan3dHeader_id'] = $value;
		return $this;
	}


	public function getLinkType(): ?string
	{
		return $this->link_type;
	}


	public function setLinkType(?string $value): self
	{
		$this['link_type'] = $value;
		return $this;
	}


	public function getLinkId(): ?string
	{
		return $this->link_id;
	}


	public function setLinkId(?string $value): self
	{
		$this['link_id'] = $value;
		return $this;
	}


	public function getPosition(): ?string
	{
		return $this->position;
	}


	public function setPosition(?string $value): self
	{
		$this['position'] = $value;
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


	public function getCss(): ?string
	{
		return $this->css;
	}


	public function setCss(?string $value): self
	{
		$this['css'] = $value;
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
