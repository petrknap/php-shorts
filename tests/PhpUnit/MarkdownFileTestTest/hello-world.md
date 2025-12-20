# Hello, World!

## Tested examples

```php
echo 'this will be executed and compared to value provided by test class' . PHP_EOL;
```


```php
echo 'this will be executed and compared to the following languageless code block' . PHP_EOL;
```
```
this will be executed and compared to the following languageless code block
```

## Ignored example

```php
use Psr\Log\LoggerInterface;

/** @var LoggerInterface $logger */
$logger->debug('this will be ignored');
```
