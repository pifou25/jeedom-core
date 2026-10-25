<?php

namespace Jeedom\Pdo\Entities;

class PlanEntity extends Entity
{
	public const TABLE_NAME = 'plan';
	public const ID = 'id';
	public const PLAN_HEADER_ID = 'planHeader_id';
	public const LINK_TYPE = 'link_type';
	public const LINK_ID = 'link_id';
	public const POSITION = 'position';
	public const DISPLAY = 'display';
	public const CSS = 'css';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var int */
	protected $planHeader_id;

	/** @var string */
	protected $link_type;

	/** @var int */
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


	public function getPlanHeaderId(): int
	{
		return $this->planHeader_id;
	}


	public function setPlanHeaderId(int $value): self
	{
		$this['planHeader_id'] = $value;
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


	public function getLinkId(): ?int
	{
		return $this->link_id;
	}


	public function setLinkId(?int $value): self
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
