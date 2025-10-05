<?php
namespace Jeedom\Core\Arrays;

// https://www.php.net/manual/en/class.arrayaccess.php
//This uses return types which are only valid in PHP 7. They can be removed if you are forced to use an older version of PHP.
//N.b. The offsetSet method contains a function that is only valid from PHP 7.3 onwards.

class ArrayAccess implements \ArrayAccess, \Iterator, \Countable {

  protected $first = null; //WARNING! Keep this always first.

  private $container = array(); //An Array of your actual values.
  private $keys = array();      //We use a separate array of keys rather than $this->position directly so that we can
  private $position;            //have an associative array.

  public function __construct( ...$args) {
    $position = 0;

    foreach( $args as $arg) { // nb variables d'arguments, c'est un tableau
      if(is_array( $arg)) {
        foreach ($arg as $key => $value) {
          if(is_array($value)) { // value est elle-même une liste
            $this->container[$key] = new ArrayAccess( $value);
          } else { // tableau à 1 seule dimension
            $this->container[$key] = $value;
          }
        }
      } else { // devrait être une erreur si le paramètre n'était pas un tableau
        $this->container[] = $arg;
      }
    }
    $this->keys = array_keys($this->container);
  }

  /**
   * call $this->supportReset() in the end of all methods that change the internal $container array, such as in offsetSet(), offsetUnset() etc.
   * This way, you can use the reset() method as normally.
   */
  private function supportReset() {
    $this->first = reset($this->items); //Support reset().
  }

  /**
   * Countable interface
   */
  public function count() : int {
    return count($this->keys);
  }

  /**
   * Iterator interface
   */
  public function rewind(): void {
    $this->position = 0;
  }

  public function current(): mixed {
    return $this->container[$this->keys[$this->position]];
  }

  public function key(): mixed {
    return $this->keys[$this->position];
  }

  public function next(): void {
    ++$this->position;
  }

  public function valid(): bool {
    return isset($this->keys[$this->position]);
  }

  /**
   * ArrayAccess interface
   */
  public function offsetSet($offset, $value): void {
    if(is_null($offset)) {
      $this->container[] = $value;
      $this->keys[] = array_key_last($this->container); //THIS IS ONLY VALID FROM php 7.3 ONWARDS. See note below for alternative.
    } else {
      $this->container[$offset] = $value;
      if(!in_array($offset, $this->keys)) $this->keys[] = $offset;
    }
    $this->supportReset();
  }

  public function offsetExists($offset): bool {
    return isset($this->container[$offset]);
  }

  public function offsetUnset($offset): void {
    unset($this->container[$offset]);
    unset($this->keys[array_search($offset,$this->keys)]);
    $this->keys = array_values($this->keys);  //This line re-indexes the array of container keys because if someone
                                              //deletes the first element, the rewind to position 0 when iterating would
                                              //cause no element to be found.
    $this->supportReset();
  }
  public function offsetGet($offset): mixed {
    return isset($this->container[$offset]) ? $this->container[$offset] : null;
  }
}


