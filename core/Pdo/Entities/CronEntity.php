<?php

namespace Jeedom\Pdo\Entities;

class CronEntity extends Entity
{
	public const TABLE_NAME = 'cron';
	public const ID = 'id';
	public const ENABLE = 'enable';
	public const _CLASS = 'class';
	public const FUNCTION = 'function';
	public const SCHEDULE = 'schedule';
	public const TIMEOUT = 'timeout';
	public const DEAMON = 'deamon';
	public const DEAMON_SLEEP_TIME = 'deamonSleepTime';
	public const OPTION = 'option';
	public const ONCE = 'once';

	/** @var int */
	protected $id;

	/** @var int */
	protected $enable;

	/** @var string */
	protected $class;

	/** @var string */
	protected $function;

	/** @var string */
	protected $schedule;

	/** @var int */
	protected $timeout;

	/** @var int */
	protected $deamon;

	/** @var int */
	protected $deamonSleepTime;

	/** @var string */
	protected $option;

	/** @var int */
	protected $once;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
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


	public function getSchedule(): ?string
	{
		return $this->schedule;
	}


	public function setSchedule(?string $value): self
	{
		$this['schedule'] = $value;
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


	public function getDeamon(): ?int
	{
		return $this->deamon;
	}


	public function setDeamon(?int $value): self
	{
		$this['deamon'] = $value;
		return $this;
	}


	public function getDeamonSleepTime(): ?int
	{
		return $this->deamonSleepTime;
	}


	public function setDeamonSleepTime(?int $value): self
	{
		$this['deamonSleepTime'] = $value;
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


	public function getOnce(): ?int
	{
		return $this->once;
	}


	public function setOnce(?int $value): self
	{
		$this['once'] = $value;
		return $this;
	}
}
