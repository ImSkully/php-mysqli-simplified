# PHP MySQLi Simplified
[![Latest Stable Version](https://poser.pugx.org/imskully/php-mysqli-simplified/v/stable)](https://packagist.org/packages/imskully/php-mysqli-simplified)
[![License](https://poser.pugx.org/imskully/php-mysqli-simplified/license)](https://packagist.org/packages/imskully/php-mysqli-simplified)
[![composer.lock](https://poser.pugx.org/imskully/php-mysqli-simplified/composerlock)](https://packagist.org/packages/imskully/php-mysqli-simplified)

A further improved and simplified usage of the MySQLi driver achieved by using overload functions that provide simplistic usage and a shorter syntax.

---

# API Functions

## `fetch($db, $query)`
Executes the specified query and returns the first result.
```php
@param   $db     String  The database name to use for this query.
@param   $query  String  The SQL query.
@return  bool|string[]   The mysqli response if fetch was successful, false otherwise.
```

## `fetchAll($db, $query)`
Executes the provided query and returns an array of all results.
```php
@param   $db     String  The database name.
@param   $query  String  The SQL query.
@return  array|bool      An array containing the mysqli response if fetch was successful, false otherwise.
```

## `execute($db, $query)`
Executes the provided query.
```php
@param   $db     String  The database name.
@param   $query  String  The SQL query.
@return  bool            Returns true if the query executed, false otherwise.
```

## `escape($data, $db)`
Runs the `mysqli_escape_string()` to escape special characters from the string.
```php
@param   $data   String  The variable or data to escape.
@param   string  $db     The database of which charset to use, if none provided then the default server is used.
@return  String          Returns the data escaped.
```
