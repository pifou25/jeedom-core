<?php

namespace Jeedom\Pdo\Entities;

class NoteEntity extends Entity
{
	public const TABLE_NAME = 'note';
	public const ID = 'id';
	public const NAME = 'name';
	public const TEXT = 'text';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $text;


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


	public function getText(): ?string
	{
		return $this->text;
	}


	public function setText(?string $value): self
	{
		$this['text'] = $value;
		return $this;
	}
}
