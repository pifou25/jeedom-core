<?php

namespace Jeedom\Pdo\Entities;

class MessageEntity extends Entity
{
	public const TABLE_NAME = 'message';
	public const ID = 'id';
	public const DATE = 'date';
	public const LOGICAL_ID = 'logicalId';
	public const PLUGIN = 'plugin';
	public const MESSAGE = 'message';
	public const ACTION = 'action';
	public const OCCURRENCES = 'occurrences';

	/** @var int */
	protected $id;

	/** @var \DateTimeInterface */
	protected $date;

	/** @var string */
	protected $logicalId;

	/** @var string */
	protected $plugin;

	/** @var string */
	protected $message;

	/** @var string */
	protected $action;

	/** @var int */
	protected $occurrences;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getDate(): \DateTimeInterface
	{
		return $this->date;
	}


	public function setDate(\DateTimeInterface $value): self
	{
		$this['date'] = $value;
		return $this;
	}


	public function getLogicalId(): ?string
	{
		return $this->logicalId;
	}


	public function setLogicalId(?string $value): self
	{
		$this['logicalId'] = $value;
		return $this;
	}


	public function getPlugin(): string
	{
		return $this->plugin;
	}


	public function setPlugin(string $value): self
	{
		$this['plugin'] = $value;
		return $this;
	}


	public function getMessage(): ?string
	{
		return $this->message;
	}


	public function setMessage(?string $value): self
	{
		$this['message'] = $value;
		return $this;
	}


	public function getAction(): ?string
	{
		return $this->action;
	}


	public function setAction(?string $value): self
	{
		$this['action'] = $value;
		return $this;
	}


	public function getOccurrences(): ?int
	{
		return $this->occurrences;
	}


	public function setOccurrences(?int $value): self
	{
		$this['occurrences'] = $value;
		return $this;
	}
}
