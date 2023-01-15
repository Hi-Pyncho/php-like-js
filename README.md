# PHP like JS

In this mini library i wrote help classes with naive but helpful implementations to make php more pleasant and understandable for me.
I love JS, but don't like PHP for many reasons. And one of them is a confusing and inconsistent syntax. 
So, i decided to make my life easier and wrote these classes to use them in my job.

## Benefits of these classes for me:
### I can use chaining to process data in arrays
Like this:
```php
$array = [1, 2, 3, 4];
$newArray = (new JSArray)
  ->filter(function($item) {
    return $item % 2 === 0;
  })
  ->map(function($item) {
    return $item * 2;
  });
  ->getResult();
```

## I use the function signature as in the documentation for the javascript
For example, if i want to iterate array using [`array_map`](https://www.php.net/manual/ru/function.array-map.php), i can't get `index` of the array and the processed `array`.
Now i can.
And a callback function has the same signature in the rest of the class methods.

## Easier to work with associative arrays
I don't understand why in php there two way to declare associative array.  
First way:
```php
$assocArray = (object) array(
  'one' => 1;
)
print_r($assocArray->one) // 1
```

Second way:
```php
$assocArray = array(
  'one' => 1
)
print_r($assocArray['one']) // 1
```

I like the second way better because i can do this `$assocArray[$var . $var2]`.
And often these two methods are mixed in one response from api. For example:
```php
$result = json_decode($apiResponse);
// then result is equal to this
stdClass Object
(
  [name] => tisha
  [age] => 12
  [params] => Array
    (
      [character] => good
      [legs] => 4
      [colors] => Array
        (
          [0] => black
          [1] => white
        )
    )
)
// get access to colors
$colors = $result->params['colors'];
```
[This class](./src/JSObject.php) has a method that recursively converts this into an associative array.

## Easier to work with UTF-8 encoded strings
PHP doesn't use utf-8 charset by default. And working with multibyte string in PHP is pain. You need use functions with `mb_` prefix, set charset manually etc.
