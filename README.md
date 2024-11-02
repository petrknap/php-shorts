# Set of short PHP helpers

* [`HasRequirements` trait](#hasrequirements-trait)


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
