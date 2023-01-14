<?php

class JSObject {
  /**
   * @param array $assocArray
   * @return bool
  */
  static function isEmpty(array $assocArray) : bool {
    return count($assocArray) === 0;
  }

  /**
   * @param array $assocArray
   * @return int
  */
  static function getLength(array $assocArray) : int {
    return count($assocArray);
  }

  /**
   * @param array $assocArray
   * @return bool
  */
  static function isAssocArray(array $assocArray) : bool {
    return array_keys($assocArray) !== range(0, count($assocArray) - 1);
  }

  /**
   * Recursively checks all values. 
   * And if the value is of type object, then it will convert it to an array
   * @param object|array $object
   * @return array
  */
  static function fromObjectToAssocArray(object|array $object) : array {
    $result = [];

    foreach($object as $key => $value) {
      if((is_array($value) && self::isAssocArray($value)) || is_object($value)) {
        $result[$key] = self::fromObjectToAssocArray($value);
      } else {
        $result[$key] = $value;
      }
    }

    return $result;
  }
  
  /**
   * @param array $assocArray
   * @return array
  */
  static function clone(array $assocArray) : array {
    return (new ArrayObject($assocArray))->getArrayCopy();
  }

  /**
   * @param array $assocArray
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
  */
  static function keys(array $assocArray) : array {
    $result = [];

    foreach($assocArray as $key => $value) {
      array_push($result, $key);
    }

    return $result;
  }

  /**
   * @param array $assocArray
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/values
  */
  static function values(array $assocArray) : array {
    $result = [];

    foreach($assocArray as $key => $value) {
      array_push($result, $value);
    }

    return $result;
  }

  /**
   * @param array $assocArray
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries
  */
  static function entries(array $assocArray) : array {
    $result = [];

    foreach($assocArray as $key => $value) {
      array_push($result, [$key, $value]);
    }

    return $result;
  }

  /**
   * @param array $array
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/fromEntries
  */
  static function fromEntries(array $array) : array {
    $result = [];

    foreach($array as $item) {
      $result[$item[0]] = $item[1];
    }

    return $result;
  }

  /**
   * @param array $assocArray
   * @param array $assocArrays
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign
  */
  static function assign(array $assocArray, array ...$assocArrays) {
    $newAssocArray = self::clone($assocArray);

    foreach($assocArrays as $array) {
      foreach($array as $key => $value) {
        $newAssocArray[$key] = $value;
      }
    }

    return $newAssocArray;
  }
}
