<?php declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

interface MarkdownFileTestInterface
{
    public static function getPathToMarkdownFile(): string;

    public function testPhpExamplesGivenInMarkdownFileWork(string $example, string $expectedOutput): void;

    /** @return iterable<string, array<string>> */
    public static function dataPhpExamplesGivenInMarkdownFileWork(): iterable;

    /** @return iterable<int|string, ?string> null values will be skipped */
    public static function getExpectedOutputsOfPhpExamples(): iterable;
}
