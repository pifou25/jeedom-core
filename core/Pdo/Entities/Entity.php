<?php

namespace Jeedom\Pdo\Entities;

/**
 * Class Entity
 * @package Jeedom\Pdo\Entities
 */
class Entity
{
    
	protected $_changed = false;
    /**
     * Check if the entity has changed
     * @return bool
     */
    public function hasChanged(): bool
    {
        return $this->_changed;
    }
    /**
     * Set the changed state of the entity
     * @param bool $changed
     */
    public function setChanged(bool $changed): void
    {
        $this->_changed = $changed;
    }

    /**
     * @var array
     */
    protected $data = [];

    /**
     * Entity constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Get the value of a property
     * @param string $property
     * @return mixed|null
     */
    public function get(string $property)
    {
        return $this->data[$property] ?? null;
    }

    /**
     * Set the value of a property
     * @param string $property
     * @param mixed $value
     */
    public function set(string $property, $value): void
    {
        $this->data[$property] = $value;
    }
}