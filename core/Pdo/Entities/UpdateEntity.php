<?php

namespace Jeedom\Pdo\Entities;

class UpdateEntity extends Entity
{
	public const TABLE_NAME = 'update';
	public const ID = 'id';
	public const TYPE = 'type';
	public const NAME = 'name';
	public const LOGICAL_ID = 'logicalId';
	public const LOCAL_VERSION = 'localVersion';
	public const REMOTE_VERSION = 'remoteVersion';
	public const UPDATE_DATE = 'updateDate';
	public const SOURCE = 'source';
	public const STATUS = 'status';
	public const CONFIGURATION = 'configuration';

	/** @var int */
	protected $id;

	/** @var string */
	protected $type;

	/** @var string */
	protected $name;

	/** @var string */
	protected $logicalId;

	/** @var string */
	protected $localVersion;

	/** @var string */
	protected $remoteVersion;

	/** @var \DateTimeInterface */
	protected $updateDate;

	/** @var string */
	protected $source;

	/** @var string */
	protected $status;

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


	public function getType(): ?string
	{
		return $this->type;
	}


	public function setType(?string $value): self
	{
		$this['type'] = $value;
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


	public function getLogicalId(): ?string
	{
		return $this->logicalId;
	}


	public function setLogicalId(?string $value): self
	{
		$this['logicalId'] = $value;
		return $this;
	}


	public function getLocalVersion(): ?string
	{
		return $this->localVersion;
	}


	public function setLocalVersion(?string $value): self
	{
		$this['localVersion'] = $value;
		return $this;
	}


	public function getRemoteVersion(): ?string
	{
		return $this->remoteVersion;
	}


	public function setRemoteVersion(?string $value): self
	{
		$this['remoteVersion'] = $value;
		return $this;
	}


	public function getUpdateDate(): ?\DateTimeInterface
	{
		return $this->updateDate;
	}


	public function setUpdateDate(?\DateTimeInterface $value): self
	{
		$this['updateDate'] = $value;
		return $this;
	}


	public function getSource(): ?string
	{
		return $this->source;
	}


	public function setSource(?string $value): self
	{
		$this['source'] = $value;
		return $this;
	}


	public function getStatus(): ?string
	{
		return $this->status;
	}


	public function setStatus(?string $value): self
	{
		$this['status'] = $value;
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
