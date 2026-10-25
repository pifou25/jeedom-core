<?php

namespace Jeedom\Pdo\Entities;

class QueueEntity extends Entity
{
	public const TABLE_NAME = 'queue';
	public const ID = 'id';
	public const QUEUE_ID = 'queueId';
	public const _CLASS = 'class';
	public const FUNCTION = 'function';
	public const ARGUMENTS = 'arguments';
	public const CREATE_TIME = 'createTime';
	public const OPTIONS = 'options';
	public const TIMEOUT = 'timeout';

	/** @var int */
	protected $id;

	/** @var string */
	protected $queueId;

	/** @var string */
	protected $class;

	/** @var string */
	protected $function;

	/** @var string */
	protected $arguments;

	/** @var \DateTimeInterface */
	protected $createTime;

	/** @var string */
	protected $options;

	/** @var int */
	protected $timeout;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getQueueId(): ?string
	{
		return $this->queueId;
	}


	public function setQueueId(?string $value): self
	{
		$this['queueId'] = $value;
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


	public function getFunction(): string
	{
		return $this->function;
	}


	public function setFunction(string $value): self
	{
		$this['function'] = $value;
		return $this;
	}


	public function getArguments(): ?string
	{
		return $this->arguments;
	}


	public function setArguments(?string $value): self
	{
		$this['arguments'] = $value;
		return $this;
	}


	public function getCreateTime(): \DateTimeInterface
	{
		return $this->createTime;
	}


	public function setCreateTime(\DateTimeInterface $value): self
	{
		$this['createTime'] = $value;
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


	public function getTimeout(): ?int
	{
		return $this->timeout;
	}


	public function setTimeout(?int $value): self
	{
		$this['timeout'] = $value;
		return $this;
	}
}
