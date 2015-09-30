# Escpr
A simple php escaping class.

### How to use Escpr:
---

#### Installing
**Escpr** is a pretty simple class. Simply download a zip or clone the repository in the root of your project. Then load it:

```php
<?php

using \Escpr\Escpr;
```

#### Escaping stuff
...is pretty easy. Just use the one and only publicly available method - escape().

Here's how:

```php
Espr::escape($anything); // anything can be, well, anything.
```

### How Escpr works
---
It traverses arrays and objet's properties' values, until it finds a string. **Escpr** escapes that string and continues to traverse.

NOTE: __Escpr works by reference, which means it escapes directly the passed argument's value and returns nothing.__

#### The stdClass hack
There's a thing you should keep in mind, though. **Espr** does not escape __stdClass__ objects. But there's a workaround.
* First, cast the stdClass object to array
* Second, escape that array with Escpr::escape().
* Third, cast back to object to use the escaped...thing...as an object.

Here's an example:

```php
$stdClassObject = new stdClass(); // create a simple stdClass object.
$stdClassObject->escapeMe = '<script>alert("Rotten tomatoes ftw!")</script>'; // add a property to it.
$stdClassObjectAsArray = (array) $stdClassObject; // because Escpr does not escape stdClass objects, convert it to array.

Escpr::escape($stdClassObjectAsArray); // escape the casted array.

$stdClassObject = (object) $stdClassObjectAsArray; // cast the escaped array back to stdClass object.

echo $stdClassObject->escapeMe . '<br />'; // print the escaped value.
```

More examples in the Examples/ folder.

Happy escaping!