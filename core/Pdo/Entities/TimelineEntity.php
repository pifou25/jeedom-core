<?php

namespace Jeedom\Pdo\Entities;

class TimelineEntity extends Entity
{
	public const TABLE_NAME = 'timeline';
	public const ID = 'id';
	public const FOLDER = 'folder';
	public const TYPE = 'type';
	public const SUBTYPE = 'subtype';
	public const LINK_ID = 'link_id';
	public const NAME = 'name';
	public const DATETIME = 'datetime';
	public const OPTIONS = 'options';

	/** @var int */
	protected $id;

	/** @var string */
	protected $folder;

	/** @var string */
	protected $type;

	/** @var string */
	protected $subtype;

	/** @var string */
	protected $link_id;

	/** @var string */
	protected $name;

	/** @var \DateTimeInterface */
	protected $datetime;

	/** @var string */
	protected $options;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getFolder(): ?string
	{
		return $this->folder;
	}


	public function setFolder(?string $value): self
	{
		$this['folder'] = $value;
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


	public function getSubtype(): ?string
	{
		return $this->subtype;
	}


	public function setSubtype(?string $value): self
	{
		$this['subtype'] = $value;
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


	public function getName(): ?string
	{
		return $this->name;
	}


	public function setName(?string $value): self
	{
		$this['name'] = $value;
		return $this;
	}


	public function getDatetime(): \DateTimeInterface
	{
		return $this->datetime;
	}


	public function setDatetime(\DateTimeInterface $value): self
	{
		$this['datetime'] = $value;
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
}
