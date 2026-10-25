<?php

namespace Jeedom\Pdo\Entities;

class EqLogicEntity extends Entity
{
	public const TABLE_NAME = 'eqLogic';
	public const ID = 'id';
	public const NAME = 'name';
	public const LOGICAL_ID = 'logicalId';
	public const OBJECT_ID = 'object_id';
	public const EQ_TYPE_NAME = 'eqType_name';
	public const CONFIGURATION = 'configuration';
	public const IS_VISIBLE = 'isVisible';
	public const IS_ENABLE = 'isEnable';
	public const STATUS = 'status';
	public const TIMEOUT = 'timeout';
	public const CATEGORY = 'category';
	public const DISPLAY = 'display';
	public const ORDER = 'order';
	public const COMMENT = 'comment';
	public const GENERIC_TYPE = 'generic_type';
	public const TAGS = 'tags';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $logicalId;

	/** @var int */
	protected $object_id;

	/** @var string */
	protected $eqType_name;

	/** @var string */
	protected $configuration;

	/** @var bool */
	protected $isVisible;

	/** @var bool */
	protected $isEnable;

	/** @var string */
	protected $status;

	/** @var int */
	protected $timeout;

	/** @var string */
	protected $category;

	/** @var string */
	protected $display;

	/** @var int */
	protected $order;

	/** @var string */
	protected $comment;

	/** @var string */
	protected $generic_type;

	/** @var string */
	protected $tags;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function setName(string $value): self
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


	public function getObjectId(): ?int
	{
		return $this->object_id;
	}


	public function setObjectId(?int $value): self
	{
		$this['object_id'] = $value;
		return $this;
	}


	public function getEqTypeName(): string
	{
		return $this->eqType_name;
	}


	public function setEqTypeName(string $value): self
	{
		$this['eqType_name'] = $value;
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


	public function getIsVisible(): ?bool
	{
		return $this->isVisible;
	}


	public function setIsVisible(?bool $value): self
	{
		$this['isVisible'] = $value;
		return $this;
	}


	public function getIsEnable(): ?bool
	{
		return $this->isEnable;
	}


	public function setIsEnable(?bool $value): self
	{
		$this['isEnable'] = $value;
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


	public function getTimeout(): ?int
	{
		return $this->timeout;
	}


	public function setTimeout(?int $value): self
	{
		$this['timeout'] = $value;
		return $this;
	}


	public function getCategory(): ?string
	{
		return $this->category;
	}


	public function setCategory(?string $value): self
	{
		$this['category'] = $value;
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


	public function getOrder(): ?int
	{
		return $this->order;
	}


	public function setOrder(?int $value): self
	{
		$this['order'] = $value;
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


	public function getGenericType(): ?string
	{
		return $this->generic_type;
	}


	public function setGenericType(?string $value): self
	{
		$this['generic_type'] = $value;
		return $this;
	}


	public function getTags(): ?string
	{
		return $this->tags;
	}


	public function setTags(?string $value): self
	{
		$this['tags'] = $value;
		return $this;
	}
}
