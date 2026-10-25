<?php

namespace Jeedom\Pdo\Entities;

class HistoryArchEntity extends Entity
{
	public const TABLE_NAME = 'historyArch';
	public const CMD_ID = 'cmd_id';
	public const DATETIME = 'datetime';
	public const VALUE = 'value';

	/** @var int */
	protected $cmd_id;

	/** @var \DateTimeInterface */
	protected $datetime;

	/** @var string */
	protected $value;


	public function getCmdId(): int
	{
		return $this->cmd_id;
	}


	public function setCmdId(int $value): self
	{
		$this['cmd_id'] = $value;
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


	public function getValue(): ?string
	{
		return $this->value;
	}


	public function setValue(?string $value): self
	{
		$this['value'] = $value;
		return $this;
	}
}
