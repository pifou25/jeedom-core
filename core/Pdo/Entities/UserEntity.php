<?php

namespace Jeedom\Pdo\Entities;

class UserEntity extends Entity
{
	public const TABLE_NAME = 'user';
	public const ID = 'id';
	public const LOGIN = 'login';
	public const PROFILS = 'profils';
	public const PASSWORD = 'password';
	public const OPTIONS = 'options';
	public const HASH = 'hash';
	public const RIGHTS = 'rights';
	public const ENABLE = 'enable';

	/** @var int */
	protected $id;

	/** @var string */
	protected $login;

	/** @var string */
	protected $profils;

	/** @var string */
	protected $password;

	/** @var string */
	protected $options;

	/** @var string */
	protected $hash;

	/** @var string */
	protected $rights;

	/** @var int */
	protected $enable;


	public function getId(): int
	{
		return $this->id;
	}


	public function setId(int $value): self
	{
		$this['id'] = $value;
		return $this;
	}


	public function getLogin(): ?string
	{
		return $this->login;
	}


	public function setLogin(?string $value): self
	{
		$this['login'] = $value;
		return $this;
	}


	public function getProfils(): string
	{
		return $this->profils;
	}


	public function setProfils(string $value): self
	{
		$this['profils'] = $value;
		return $this;
	}


	public function getPassword(): ?string
	{
		return $this->password;
	}


	public function setPassword(?string $value): self
	{
		$this['password'] = $value;
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


	public function getHash(): ?string
	{
		return $this->hash;
	}


	public function setHash(?string $value): self
	{
		$this['hash'] = $value;
		return $this;
	}


	public function getRights(): ?string
	{
		return $this->rights;
	}


	public function setRights(?string $value): self
	{
		$this['rights'] = $value;
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
}
