<?php

namespace Jeedom\Pdo\Entities;

class CmdEntity extends Entity
{
	public const TABLE_NAME = 'cmd';
	public const ID = 'id';
	public const EQ_LOGIC_ID = 'eqLogic_id';
	public const EQ_TYPE = 'eqType';
	public const LOGICAL_ID = 'logicalId';
	public const ORDER = 'order';
	public const NAME = 'name';
	public const CONFIGURATION = 'configuration';
	public const TEMPLATE = 'template';
	public const IS_HISTORIZED = 'isHistorized';
	public const TYPE = 'type';
	public const SUB_TYPE = 'subType';
	public const UNITE = 'unite';
	public const DISPLAY = 'display';
	public const IS_VISIBLE = 'isVisible';
	public const VALUE = 'value';
	public const ALERT = 'alert';
	public const GENERIC_TYPE = 'generic_type';

	/** @var int */
	protected $id;

	/** @var int */
	protected $eqLogic_id;

	/** @var string */
	protected $eqType;

	/** @var string */
	protected $logicalId;

	/** @var int */
	protected $order;

	/** @var string */
	protected $name;

	/** @var string */
	protected $configuration;

	/** @var string */
	protected $template;

	/** @var string */
	protected $isHistorized;

	/** @var string */
	protected $type;

	/** @var string */
	protected $subType;

	/** @var string */
	protected $unite;

	/** @var string */
	protected $display;

	/** @var int */
	protected $isVisible;

	/** @var string */
	protected $value;

	/** @var string */
	protected $alert;

	/** @var string */
	protected $generic_type;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getEqLogicId(): int
	{
		return $this->eqLogic_id;
	}


	public function setEqLogicId(int $value): self
	{
		$this['eqLogic_id'] = $value;
		return $this;
	}


	public function getEqType(): ?string
	{
		return $this->eqType;
	}


	public function setEqType(?string $value): self
	{
		$this['eqType'] = $value;
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


	public function getOrder(): ?int
	{
		return $this->order;
	}


	public function setOrder(?int $value): self
	{
		$this['order'] = $value;
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


	public function getConfiguration(): ?string
	{
		return $this->configuration;
	}


	public function setConfiguration(?string $value): self
	{
		$this['configuration'] = $value;
		return $this;
	}


	public function getTemplate(): ?string
	{
		return $this->template;
	}


	public function setTemplate(?string $value): self
	{
		$this['template'] = $value;
		return $this;
	}


	public function getIsHistorized(): string
	{
		return $this->isHistorized;
	}


	public function setIsHistorized(string $value): self
	{
		$this['isHistorized'] = $value;
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


	public function getSubType(): ?string
	{
		return $this->subType;
	}


	public function setSubType(?string $value): self
	{
		$this['subType'] = $value;
		return $this;
	}


	public function getUnite(): ?string
	{
		return $this->unite;
	}


	public function setUnite(?string $value): self
	{
		$this['unite'] = $value;
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


	public function getIsVisible(): ?int
	{
		return $this->isVisible;
	}


	public function setIsVisible(?int $value): self
	{
		$this['isVisible'] = $value;
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


	public function getAlert(): ?string
	{
		return $this->alert;
	}


	public function setAlert(?string $value): self
	{
		$this['alert'] = $value;
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
}
