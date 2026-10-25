<?php

namespace Jeedom\Pdo\Entities;

class InteractDefEntity extends Entity
{
	public const TABLE_NAME = 'interactDef';
	public const ID = 'id';
	public const NAME = 'name';
	public const ENABLE = 'enable';
	public const QUERY = 'query';
	public const REPLY = 'reply';
	public const PERSON = 'person';
	public const OPTIONS = 'options';
	public const FILTRES = 'filtres';
	public const GROUP = 'group';
	public const ACTIONS = 'actions';
	public const DISPLAY = 'display';
	public const COMMENT = 'comment';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var int */
	protected $enable;

	/** @var string */
	protected $query;

	/** @var string */
	protected $reply;

	/** @var string */
	protected $person;

	/** @var string */
	protected $options;

	/** @var string */
	protected $filtres;

	/** @var string */
	protected $group;

	/** @var string */
	protected $actions;

	/** @var string */
	protected $display;

	/** @var string */
	protected $comment;


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


	public function getEnable(): ?int
	{
		return $this->enable;
	}


	public function setEnable(?int $value): self
	{
		$this['enable'] = $value;
		return $this;
	}


	public function getQuery(): ?string
	{
		return $this->query;
	}


	public function setQuery(?string $value): self
	{
		$this['query'] = $value;
		return $this;
	}


	public function getReply(): ?string
	{
		return $this->reply;
	}


	public function setReply(?string $value): self
	{
		$this['reply'] = $value;
		return $this;
	}


	public function getPerson(): ?string
	{
		return $this->person;
	}


	public function setPerson(?string $value): self
	{
		$this['person'] = $value;
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


	public function getFiltres(): ?string
	{
		return $this->filtres;
	}


	public function setFiltres(?string $value): self
	{
		$this['filtres'] = $value;
		return $this;
	}


	public function getGroup(): ?string
	{
		return $this->group;
	}


	public function setGroup(?string $value): self
	{
		$this['group'] = $value;
		return $this;
	}


	public function getActions(): ?string
	{
		return $this->actions;
	}


	public function setActions(?string $value): self
	{
		$this['actions'] = $value;
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


	public function getComment(): ?string
	{
		return $this->comment;
	}


	public function setComment(?string $value): self
	{
		$this['comment'] = $value;
		return $this;
	}
}
