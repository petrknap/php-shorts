<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

use PHPUnit\Framework\TestCase;

final class MarkdownFileTestTraitTest extends TestCase implements MarkdownFileTestInterface
{
    use MarkdownFileTestTrait;

    public static function getPathToMarkdownFile(): string
    {
        return __DIR__ . '/MarkdownFileTestTraitTest/hello-world.md';
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        return [
            'echo-hello-world' => 'Hello, World!',
            'log-hello-world' => null,
        ];
    }
}
