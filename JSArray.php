<?php

class JSArray {
  protected $array = [];

  function __construct(array $array) {
    $this->array = $array;
  }

  /**
   * @return array
  */
  function getResult() : array {
    return $this->array;
  }

  /**
   * @return int
  */
  function getLength() : int {
    return count($this->array);
  }

  /**
   * @param int $index
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/at
  */
  function at(int $index) {
    if($index < 0) {
      return $this->array[$this->getLength() + $index];
    }

    return $this->array[$index];
  }

  /**
   * @param callable $callback (mixed $item, int $index, array $array): mixed
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/map
  */
  function map(callable $callback) : JSArray {
    $newArray = [];

    foreach($this->array as $index => $item) {
      array_push($newArray, $callback($item, $index, $this->array));
    }

    return new JSArray($newArray);
  }
  
  /**
   * @param callable $callback (mixed $item, int $index, array $array): boolean
   * @return JSArray
  */
  function filter(callable $callback) : JSArray {
    $newArray = [];

    foreach($this->array as $index => $item) {
      if($callback($item, $index, $this->array)) {
        array_push($newArray, $item);
      }
    }

    return new JSArray($newArray);
  }

  /**
   * @param callable $callback (mixed $item, int $index, array $array): bool
   * @return bool
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/some
  */
  function some(callable $callback) : bool {
    $result = false;

    foreach($this->array as $index => $item) {
      if($callback($item, $index, $this->array)) {
        $result = true;
        break;
      }
    }

    return $result;
  }

  /**
   * @param callable $callback (mixed $item, int $index, array $array): bool
   * @return bool
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/every
  */
  function every(callable $callback) : bool {
    $result = true;

    foreach($this->array as $index => $item) {
      if(!$callback($item, $index, $this->array)) {
        $result = false;
        break;
      }
    }

    return $result;
  }

  /**
   * @return bool
   */
  function isEmpty() : bool {
    return $this->getLength() === 0;
  }

  /**
   * @param callable $callback (mixed $item, int $index, array $array): mixed|null
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/find
  */
  function find(callable $callback) {
    $result = null;

    foreach($this->array as $index => $item) {
      if($callback($item, $index, $this->array)) {
        $result = $item;
        break;
      }
    }

    return $result;
  }

    /**
   * @param callable $callback (mixed $item, int $index, array $array): mixed|null
   * @return int
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/findIndex
  */
  function findIndex(callable $callback) : int {
    $result = -1;

    foreach($this->array as $index => $item) {
      if($callback($item, $index, $this->array)) {
        $result = $index;
        break;
      }
    }

    return $result;
  }

  /**
   * @return int
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf
  */
  function indexOf($value) : int {
    $result = array_search($value, $this->array);
    return $result === false ? -1 : $result;
  }

  /**
   * @param int $depth
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/flat
  */
  function flat(int $depth = 1) {
    function iter($depth, $current, $result = []) {
      if($depth === 0) return $current;

      foreach($current as $item) {
        if(is_array($item)) {
          $result = array_merge($result, iter($depth - 1, $item));
        } else {
          array_push($result, $item);
        }
      }

      return $result;
    }

    return new JSArray(iter($depth, $this->array));
  }

  /**
   * @return bool
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/includes
  */
  function includes($value, $fromIndex = 0) : bool {
    $result = false;

    for($i = $fromIndex; $i < $this->getLength() - 1; $i++) {
      if($this->array[$i] === $value) {
        $result = true;
        break;
      }
    }

    return $result;
  }

  /**
   * @param callable $callback (mixed $item, int $index, array $array): void
   * @return void
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach
  */
  function forEach($callback) : void {
    $newArray = $this->clone()->getResult();
    
    foreach($newArray as $index => $item) {
      $callback($item, $index, $newArray);
    }
  }

  /**
   * @return JSArray
  */
  function clone() : JSArray {
    return new JSArray($this->array);
  }

  /**
   * @param string $separator
   * @return string
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/join
  */
  function join(string $separator = ',') : string {
    return implode($separator, $this->array);
  }

  /**
   * Mutate original array
   * @param mixed $values
   * @return int length of the final array
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/push
  */
  function push(...$values) : int {
    array_push($this->array, $values);
    return $this->getLength();
  }

  /**
   * Mutate original array
   * @return mixed|null last element of the array or null if the array is empty
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/pop
  */
  function pop() {
    if($this->isEmpty()) return null;
    return array_pop($this->array);
  }

  /**
   * Mutate original array
   * @return mixed|null first element of the array or null if the array is empty
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/shift
  */
  function shift() {
    if($this->isEmpty()) return null;
    return array_shift($this->array);
  }

  /**
   * Mutate original array
   * @param mixed $values
   * @return int length of the final array
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/unshift
  */
  function unshift(...$values) : int {
    array_unshift($this->array, $values);
    return $this->getLength();
  }

  /**
   * @param callable $callback (mixed $initial, mixed $item, int $index, array $array): mixed
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/Reduce
  */
  function reduce(callable $callback, mixed $initial = null) : JSArray {
    $newArray = $this->clone()->getResult();

    if(is_null($initial)) {
      $initial = array_shift($newArray);
    }

    foreach($newArray as $index => $item) {
      $initial = $callback($initial, $item, $index, $newArray);
    }

    return new JSArray($newArray);
  }

  /**
   * @param int $start
   * @param int $end
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/slice
  */
  function slice(int $begin = 0, int $end = null) {
    $length = $this->getLength();
    $cloned = [];

    if(is_null($end)) $end = $length;

    $start = $begin;
    $start = ($start >= 0) ? $start : $length + $start;

    $upTo = $end;
    if ($end < 0) {
      $upTo = $length + $end;
    }

    $size = $upTo - $start;

    if ($size > 0) {
      for ($i = 0; $i < $size; $i++) {
        $cloned[$i] = $this->array[$start + $i];
      }
    } else {
      for ($i = 0; $i < $size; $i++) {
        $cloned[$i] = $this->array[$start + $i];
      }
    }
  
    return $cloned;
  }

  /**
   * Mutate original array
   * @param callable $callback ($prev, $current): 1|-1|0
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/sort
  */
  function sort(callable $callback) : JSArray {
    usort($this->array, $callback);

    return $this;
  }

  /**
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/concat
  */
  function concat(...$values) {
    return new JSArray(array_merge($this->array, $values));
  }

  /**
   * Mutate original array
   * @return JSArray
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/reverse
  */
  function reverse() {
    array_reverse($this->array);
    return $this;
  }
}
