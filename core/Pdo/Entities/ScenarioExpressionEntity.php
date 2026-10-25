<?php

namespace Jeedom\Pdo\Entities;

class ScenarioExpressionEntity extends Entity
{
	public const TABLE_NAME = 'scenarioExpression';
	public const ID = 'id';
	public const ORDER = 'order';
	public const SCENARIO_SUB_ELEMENT_ID = 'scenarioSubElement_id';
	public const TYPE = 'type';
	public const SUBTYPE = 'subtype';
	public const EXPRESSION = 'expression';
	public const OPTIONS = 'options';
	public const LOG = 'log';

	/** @var int */
	protected $id;

	/** @var int */
	protected $order;

	/** @var int */
	protected $scenarioSubElement_id;

	/** @var string */
	protected $type;

	/** @var string */
	protected $subtype;

	/** @var string */
	protected $expression;

	/** @var string */
	protected $options;

	/** @var string */
	protected $log;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
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


	public function getScenarioSubElementId(): int
	{
		return $this->scenarioSubElement_id;
	}


	public function setScenarioSubElementId(int $value): self
	{
		$this['scenarioSubElement_id'] = $value;
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


	public function getSubtype(): ?string
	{
		return $this->subtype;
	}


	public function setSubtype(?string $value): self
	{
		$this['subtype'] = $value;
		return $this;
	}


	public function getExpression(): ?string
	{
		return $this->expression;
	}


	public function setExpression(?string $value): self
	{
		$this['expression'] = $value;
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


	public function getLog(): ?string
	{
		return $this->log;
	}


	public function setLog(?string $value): self
	{
		$this['log'] = $value;
		return $this;
	}
}
