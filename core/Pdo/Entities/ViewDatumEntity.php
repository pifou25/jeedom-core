<?php

namespace Jeedom\Pdo\Entities;

class ViewDatumEntity extends Entity
{
	public const TABLE_NAME = 'viewData';
	public const ID = 'id';
	public const ORDER = 'order';
	public const VIEW_ZONE_ID = 'viewZone_id';
	public const TYPE = 'type';
	public const LINK_ID = 'link_id';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var int */
	protected $order;

	/** @var int */
	protected $viewZone_id;

	/** @var string */
	protected $type;

	/** @var int */
	protected $link_id;

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


	public function getOrder(): ?int
	{
		return $this->order;
	}


	public function setOrder(?int $value): self
	{
		$this['order'] = $value;
		return $this;
	}


	public function getViewZoneId(): int
	{
		return $this->viewZone_id;
	}


	public function setViewZoneId(int $value): self
	{
		$this['viewZone_id'] = $value;
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


	public function getLinkId(): ?int
	{
		return $this->link_id;
	}


	public function setLinkId(?int $value): self
	{
		$this['link_id'] = $value;
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
