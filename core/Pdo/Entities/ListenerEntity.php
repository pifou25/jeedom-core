<?php

namespace Jeedom\Pdo\Entities;

class ListenerEntity extends Entity
{
	public const TABLE_NAME = 'listener';
	public const ID = 'id';
	public const _CLASS = 'class';
	public const FUNCTION = 'function';
	public const EVENT = 'event';
	public const OPTION = 'option';

	/** @var int */
	protected $id;

	/** @var string */
	protected $class;

	/** @var string */
	protected $function;

	/** @var string */
	protected $event;

	/** @var string */
	protected $option;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getClass(): ?string
	{
		return $this->class;
	}


	public function setClass(?string $value): self
	{
		$this['class'] = $value;
		return $this;
	}


	public function getFunction(): ?string
	{
		return $this->function;
	}


	public function setFunction(?string $value): self
	{
		$this['function'] = $value;
		return $this;
	}


	public function getEvent(): ?string
	{
		return $this->event;
	}


	public function setEvent(?string $value): self
	{
		$this['event'] = $value;
		return $this;
	}


	public function getOption(): ?string
	{
		return $this->option;
	}


	public function setOption(?string $value): self
	{
		$this['option'] = $value;
		return $this;
	}
}
