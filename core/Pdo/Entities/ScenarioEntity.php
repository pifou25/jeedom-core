<?php

namespace Jeedom\Pdo\Entities;

class ScenarioEntity extends Entity
{
	public const TABLE_NAME = 'scenario';
	public const ID = 'id';
	public const NAME = 'name';
	public const GROUP = 'group';
	public const IS_ACTIVE = 'isActive';
	public const MODE = 'mode';
	public const SCHEDULE = 'schedule';
	public const SCENARIO_ELEMENT = 'scenarioElement';
	public const TRIGGER = 'trigger';
	public const TIMEOUT = 'timeout';
	public const IS_VISIBLE = 'isVisible';
	public const OBJECT_ID = 'object_id';
	public const DISPLAY = 'display';
	public const DESCRIPTION = 'description';
	public const CONFIGURATION = 'configuration';
	public const ORDER = 'order';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $group;

	/** @var bool */
	protected $isActive;

	/** @var string */
	protected $mode;

	/** @var string */
	protected $schedule;

	/** @var string */
	protected $scenarioElement;

	/** @var string */
	protected $trigger;

	/** @var int */
	protected $timeout;

	/** @var bool */
	protected $isVisible;

	/** @var int */
	protected $object_id;

	/** @var string */
	protected $display;

	/** @var string */
	protected $description;

	/** @var string */
	protected $configuration;

	/** @var int */
	protected $order;


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


	public function getGroup(): ?string
	{
		return $this->group;
	}


	public function setGroup(?string $value): self
	{
		$this['group'] = $value;
		return $this;
	}


	public function getIsActive(): ?bool
	{
		return $this->isActive;
	}


	public function setIsActive(?bool $value): self
	{
		$this['isActive'] = $value;
		return $this;
	}


	public function getMode(): ?string
	{
		return $this->mode;
	}


	public function setMode(?string $value): self
	{
		$this['mode'] = $value;
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


	public function getScenarioElement(): ?string
	{
		return $this->scenarioElement;
	}


	public function setScenarioElement(?string $value): self
	{
		$this['scenarioElement'] = $value;
		return $this;
	}


	public function getTrigger(): ?string
	{
		return $this->trigger;
	}


	public function setTrigger(?string $value): self
	{
		$this['trigger'] = $value;
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


	public function getIsVisible(): ?bool
	{
		return $this->isVisible;
	}


	public function setIsVisible(?bool $value): self
	{
		$this['isVisible'] = $value;
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


	public function getDisplay(): ?string
	{
		return $this->display;
	}


	public function setDisplay(?string $value): self
	{
		$this['display'] = $value;
		return $this;
	}


	public function getDescription(): ?string
	{
		return $this->description;
	}


	public function setDescription(?string $value): self
	{
		$this['description'] = $value;
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


	public function getOrder(): ?int
	{
		return $this->order;
	}


	public function setOrder(?int $value): self
	{
		$this['order'] = $value;
		return $this;
	}
}
