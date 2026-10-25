<?php

namespace Jeedom\Pdo\Entities;

class WidgetEntity extends Entity
{
	public const TABLE_NAME = 'widgets';
	public const ID = 'id';
	public const NAME = 'name';
	public const TYPE = 'type';
	public const SUBTYPE = 'subtype';
	public const TEMPLATE = 'template';
	public const DISPLAY = 'display';
	public const REPLACE = 'replace';
	public const TEST = 'test';

	/** @var int */
	protected $id;

	/** @var string */
	protected $name;

	/** @var string */
	protected $type;

	/** @var string */
	protected $subtype;

	/** @var string */
	protected $template;

	/** @var string */
	protected $display;

	/** @var string */
	protected $replace;

	/** @var string */
	protected $test;


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


	public function getTemplate(): ?string
	{
		return $this->template;
	}


	public function setTemplate(?string $value): self
	{
		$this['template'] = $value;
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


	public function getReplace(): ?string
	{
		return $this->replace;
	}


	public function setReplace(?string $value): self
	{
		$this['replace'] = $value;
		return $this;
	}


	public function getTest(): ?string
	{
		return $this->test;
	}


	public function setTest(?string $value): self
	{
		$this['test'] = $value;
		return $this;
	}
}
