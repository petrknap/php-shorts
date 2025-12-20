# Set of short PHP helpers

* [Exceptions](#exceptions)
  * [`CouldNotProcessData` template](#couldnotprocessdata-template)
  * [`NotImplemented`](#notimplemented)
* [`HasRequirements` trait](#hasrequirements-trait)
* [Testing](#testing)
  * [`IlluminateDatabase` helper](#illuminatedatabase-helper)
  * [`MarkdownFileTest` interface + trait](#markdownfiletest-interface--trait)



## Exceptions


### [`CouldNotProcessData` template](./src/Exception/CouldNotProcessData.php)

Template for an exception that indicates that the data could not be processed.

```php
interface ImageResizerException extends Throwable {}

final class ImageResizerCouldNotResizeImage extends PetrKnap\Shorts\Exception\CouldNotProcessData implements ImageResizerException {}

final class ImageResizer {
    public function resize(string $image) {
        throw new ImageResizerCouldNotResizeImage(__METHOD__, $image);
    }
}
```


### [`NotImplemented`](./src/Exception/NotImplemented.php)

Simple exception for prototyping purposes.

```php
final class StringablePrototype implements Stringable {
    public function __toString(): string {
        PetrKnap\Shorts\Exception\NotImplemented::throw(__METHOD__);
    }
}
```



## [`HasRequirements` trait](./src/HasRequirements.php)

Simple trait to check if requirements of your code are fulfilled.

```php
final class ServiceWithRequirements {
    use PetrKnap\Shorts\HasRequirements;
    
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



## Testing


### [`IlluminateDatabase` helper](./src/Testing/IlluminateDatabase.php)

Simple helper which provides logic to test `Illuminate\Database` without `Laravel` mess.

```php
$pdo = new PDO('sqlite::memory:');
$pdo->exec('CREATE TABLE tigers (id INTEGER PRIMARY KEY, name VARCHAR)');
$pdo->prepare('INSERT INTO tigers (name) VALUES (?), (?), (?)')
    ->execute(['Roque', 'Jasper', 'Gopal']);

PetrKnap\Shorts\Testing\IlluminateDatabase::createCapsuleManager($pdo)
    ->bootEloquent();

class Tiger extends Illuminate\Database\Eloquent\Model {}

assert(Tiger::count() === 3);
```


### [`MarkdownFileTest` interface](./src/PhpUnit/MarkdownFileTestInterface.php) + [trait](./src/PhpUnit/MarkdownFileTestTrait.php)

The interface and trait let you automatically test code examples in a Markdown file like `README.md`.

```php
final class ReadmeTest extends PHPUnit\Framework\TestCase implements PetrKnap\Shorts\PhpUnit\MarkdownFileTestInterface {
    use PetrKnap\Shorts\PhpUnit\MarkdownFileTestTrait;

    public static function getPathToMarkdownFile(): string {
        return __DIR__ . '/../README.md';
    }

    public static function getExpectedOutputsOfPhpExamples(): array {
        return [
            'some example' => 'has this output',
        ];
    }
}
```

By specifying the file path and expected outputs, the trait runs each code block and checks that its output matches, keeping documentation examples correct and up‑to‑date.

---

Run `composer require petrknap/shorts` to install it.
You can [support this project via donation](https://petrknap.github.io/donate.html).
The project is licensed under [the terms of the `LGPL-3.0-or-later`](./COPYING.LESSER).
