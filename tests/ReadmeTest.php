<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\TestCase;

final class ReadmeTest extends TestCase implements PhpUnit\MarkdownFileTestInterface
{
    use PhpUnit\MarkdownFileTestTrait;

    public static function getPathToMarkdownFile(): string
    {
        return __DIR__ . '/../README.md';
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        return [
            Exception\CouldNotProcessData::class => '',
            Exception\NotImplemented::class => '',
            HasRequirements::class => '',
            Testing\IlluminateDatabase::class => '',
            PhpUnit\MarkdownFileTestInterface::class => '',
        ];
    }
}
