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
            'tested-example' => 'Hello, World!',
            'skipped-example' => null,
        ];
    }
}
