<?php

namespace Jeedom\Pdo\Entities;

class InteractQueryEntity extends Entity
{
	public const TABLE_NAME = 'interactQuery';
	public const ID = 'id';
	public const INTERACT_DEF_ID = 'interactDef_id';
	public const QUERY = 'query';
	public const ACTIONS = 'actions';

	/** @var int */
	protected $id;

	/** @var int */
	protected $interactDef_id;

	/** @var string */
	protected $query;

	/** @var string */
	protected $actions;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getInteractDefId(): int
	{
		return $this->interactDef_id;
	}


	public function setInteractDefId(int $value): self
	{
		$this['interactDef_id'] = $value;
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


	public function getActions(): ?string
	{
		return $this->actions;
	}


	public function setActions(?string $value): self
	{
		$this['actions'] = $value;
		return $this;
	}
}
