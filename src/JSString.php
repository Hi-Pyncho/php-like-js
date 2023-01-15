<?php

class JSString {
  protected $string;

  function __construct(string $string){
    $this->string = $string;
  }

  /**
   * @return int
  */
  function getLength() : int {
    return mb_strlen($this->string);
  }

  /**
   * @param int $position
   * @return string|null
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/at
  */
  function at(int $position) : string|null {
    $result = mb_substr($this->string, $position, 1);
    return empty($result) ? null : $result;
  }

  /**
   * @param string $searchString
   * @param int $endPosition
   * @return bool
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/String/endsWith
   */
  function endsWith(string $searchString, int $endPosition = null) : bool {
    $result = false;
    $newString = $this->string;

    if(!is_null($endPosition)) {
      $newString = $this->slice(0, $endPosition);
    }

    $start = mb_strlen($newString) - mb_strlen($searchString);

    if(mb_substr($newString, $start) === $searchString) {
      $result = true;
    }

    return $result;
  }
  
  /**
   * @param string $searchString
   * @param int $position
   * @return bool
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/String/startsWith
  */
  function startsWith(string $searchString, int $position = 0) : bool {
    $result = false;
    $newString = $this->string;

    if(!is_null($position)) {
      $newString = $this->slice($position);
    }

    if(mb_substr($newString, 0, mb_strlen($searchString)) === $searchString) {
      $result = true;
    }

    return $result;
  }

  /**
   * @param string $searchString
   * @param int $position
   * @return bool
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes
  */
  function includes(string $searchString, int $position = 0) : bool {
    $string = $this->string;

    if($position !== 0) {
      $string = $this->slice($position);  
    }

    return mb_strpos($string, $searchString) !== false;
  }

  private function splitByChars($limit) {
    $result = [];

    for($i = 0; $i < $limit; $i++) {
      array_push($result, $this->at($i));
    }

    return $result;
  }
  
  /**
   * @param string $separator
   * @param int $limit
   * @return array
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/split
  */
  function split($separator = null, $limit = null) : array {
    if($limit === 0) return [];
    if(is_null($limit)) $limit = $this->getLength();
    if(is_null($separator)) return [$this->string];
    if(!is_null($limit) && $limit < 0) {
      throw new Exception('The second argument $limit must be no negative');
    }

    if($separator === '') {
      return $this->splitByChars($limit);
    }

    $result = mb_split($separator, $this->string);

    return is_null($limit) ? $result : array_slice($result, 0, $limit);
  }
  
  /**
   * @param int $count
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/repeat
  */
  function repeat($count) : JSString {
    if($count < 0) {
      throw new Exception('Repeat count must be non-negative');
    }

    return new JSString(str_repeat($this->string, $count));
  }
  
  /**
   * @param int $indexStart
   * @param int $indexEnd
   * @return JSString
   * @link https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/String/slice
  */
  function slice(int $indexStart = 0, int $indexEnd = null) : JSString {
    $strLength = $this->getLength();
    $length = is_null($indexEnd) ? $strLength : $indexEnd;
    
    if($indexStart < 0) {
      $indexStart = $strLength + $indexStart;
    }
    if($indexEnd < 0) {
      $length = $strLength + $indexEnd;
    }

    $result = '';

    for($i = $indexStart; $i < $length; $i++) {
      $result .= $this->at($i);
    }

    return new JSString($result);
  }
  
  /**
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toLowerCase
  */
  function toLowerCase() : JSString {
    return new JSString(mb_strtolower($this->string));
  }
  
  /**
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toUpperCase
  */
  function toUpperCase() : JSString {
    return new JSString(mb_strtoupper($this->string));
  }
  
  /**
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
  */
  function trim() : JSString {
    return new JSString(trim($this->string));
  }
  
  /**
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/trimStart
  */
  function trimStart() : JSString {
    return new JSString(ltrim($this->string));
  }
  
  /**
   * @return JSString
   * @link https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/trimEnd
  */
  function trimEnd() : JSString {
    return new JSString(rtrim($this->string));
  }
  
  /**
   * @return JSString
  */
  function sanitize() : JSString {
    return new JSString(filter_var($this->string, FILTER_SANITIZE_SPECIAL_CHARS));
  }
}
