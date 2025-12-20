<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

use PHPUnit\Framework\TestCase;

final class MarkdownFileTestTest extends TestCase implements MarkdownFileTestInterface
{
    use MarkdownFileTestTrait;

    public static function getPathToMarkdownFile(): string
    {
        return __DIR__ . '/MarkdownFileTestTest/hello-world.md';
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        return [
            'tested-examples (without output)' => 'this will be executed and compared to value provided by test class' . PHP_EOL,
            'tested-examples (with output)' => self::OUTPUT_IN_MARKDOWN,
            'ignored-example' => self::IGNORED,
        ];
    }
}
