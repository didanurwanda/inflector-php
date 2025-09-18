# Inflector PHP

A lightweight PHP utility for smart word transformations – from singular to plural, snake_case to CamelCase, and everything in between. Fully compatible with PHP 7.1 through 8.4.

> **Note:**  
> This library is a PHP port of the popular JavaScript library [inflector-js](https://www.npmjs.com/package/inflector-js), bringing similar functionality for smart word transformations such as singular/plural conversion and case formatting.

---

## Installation

Install via Composer:

```bash
composer require yourname/inflector
```

Or include manually:

```bash
require_once 'src/Inflector.php';
```

---

## How to Use

```php
use Inflector\Inflector;

echo Inflector::camelize('message_properties');
```

---

## API

### pluralize

public static function pluralize(string $str, string $plural = null): string

Returns the plural form of a string.

Example:

```php
Inflector::pluralize('person'); // people
Inflector::pluralize('Hat'); // Hats
Inflector::pluralize('person', 'persons'); // persons
Inflector::pluralize('person', 'guys'); // guys
```

---

### singularize

public static function singularize(string $str, string $singular = null): string

Example:

```php
Inflector::singularize('people'); // person
Inflector::singularize('octopi'); // octopus
Inflector::singularize('hats'); // hat
Inflector::singularize('guys', 'person'); // person
```

---

### camelize

public static function camelize(string $str, bool $lowFirstLetter = false): string

Example:

```php
Inflector::camelize('message_properties'); // MessageProperties
Inflector::camelize('message_properties', true); // messageProperties
```

---

### underscore

public static function underscore(string $str): string

Example:

```php
Inflector::underscore('MessageProperties'); // message_properties
Inflector::underscore('messageProperties'); // message_properties
```

---

### humanize

public static function humanize(string $str, bool $lowFirstLetter = false): string

Example:

```php
Inflector::humanize('message_properties'); // Message properties
Inflector::humanize('messageProperties', true); // message properties
```

---

### capitalize

public static function capitalize(string $str): string

Example:

```php
Inflector::capitalize('message properties'); // Message properties
Inflector::capitalize('message_properties'); // Message_properties
```

---

### dasherize

public static function dasherize(string $str): string

Example:

```php
Inflector::dasherize('message properties'); // message-properties
Inflector::dasherize('message_properties'); // message-properties
```

---

### camel2words

public static function camel2words(string $str, bool $allFirstUpper = false): string

Example:

```php
Inflector::camel2words('message_properties'); // Message Properties
Inflector::camel2words('message properties'); // Message Properties
Inflector::camel2words('Message_propertyId', true); // Message Property Id
```

---

### demodulize

public static function demodulize(string $str): string

Example:

```php
Inflector::demodulize('Message::Bus::Properties'); // Properties
```

---

### tableize

public static function tableize(string $str): string

Example:

```php
Inflector::tableize('MessageBusProperty'); // message_bus_properties
```

---

### classify

public static function classify(string $str): string

Example:

```php
Inflector::classify('message_bus_properties'); // MessageBusProperty
```

---

### foreignKey

public static function foreignKey(string $str, bool $dropIdUbar = false): string

Example:

```php
Inflector::foreignKey('MessageBusProperty'); // message_bus_property_id
Inflector::foreignKey('MessageBusProperty', true); // message_bus_propertyid
```

---

### ordinalize

public static function ordinalize(string $str): string

Example:

```php
Inflector::ordinalize('the 1 pitch'); // the 1st pitch
Inflector::ordinalize('1'); // 1st
Inflector::ordinalize('2'); // 2nd
Inflector::ordinalize('3'); // 3rd
Inflector::ordinalize('4'); // 4th
```

---

## Author

Created and maintained by **Dida Nurwanda**  
[didanurwanda@gmail.com](mailto:didanurwanda@gmail.com)

---

## License

This project is licensed under the **MIT**. See the [LICENSE](./LICENSE) file for more details.
