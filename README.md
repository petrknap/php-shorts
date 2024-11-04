# Set of short PHP helpers

* `Exception`s
  * [`CouldNotProcessData` template](#exceptioncouldnotprocessdata-template)
  * [`NotImplemented`](#exceptionnotimplemented)
* [`FilterCommand`](#filtercommand)
* [`HasRequirements` trait](#hasrequirements-trait)

## [`Exception\CouldNotProcessData` template](./src/Exception/CouldNotProcessData.php)

Template for an exception that indicates that the data could not be processed.

```php
namespace PetrKnap\Shorts;

interface ImageResizerException extends \Throwable {}

/** @extends Exception\CouldNotProcessData<string> */
final class ImageResizerCouldNotResizeImage extends Exception\CouldNotProcessData implements ImageResizerException {}

final class ImageResizer {
    public function resize(string $image) {
        throw new ImageResizerCouldNotResizeImage(__METHOD__, $image);
    }
}
```

## [`Exception\NotImplemented`](./src/Exception/NotImplemented.php)

Simple exception for prototyping purposes.

```php
namespace PetrKnap\Shorts;

final class StringablePrototype implements \Stringable {
    public function __toString(): string {
        Exception\NotImplemented::throw(__METHOD__);
    }
}
```

## [`FilterCommand`](./src/FilterCommand.php)

Object used to filter input using an external command.

```php
namespace PetrKnap\Shorts;

echo (new FilterCommand('tr', ['a-z', 'A-Z']))->filter('input');  # echo "input" | tr a-z A-Z
```

## [`HasRequirements` trait](./src/HasRequirements.php)

Simple trait to check if requirements of your code are fulfilled.

```php
namespace PetrKnap\Shorts;

final class ServiceWithRequirements {
    use HasRequirements;
    
    public function __construct() {
        self::checkRequirements(functions: ['required_function']);
    }

    public function do(): void {
        required_function();
    }
}
```

It should not replace [Composers](https://getcomposer.org/) [`require`s](https://getcomposer.org/doc/04-schema.md#require),
but it could improve them and check [`suggest`s](https://getcomposer.org/doc/04-schema.md#suggest).

---

Run `composer require petrknap/shorts` to install it.
You can [support this project via donation](https://petrknap.github.io/donate.html).
The project is licensed under [the terms of the `LGPL-3.0-or-later`](./COPYING.LESSER).
