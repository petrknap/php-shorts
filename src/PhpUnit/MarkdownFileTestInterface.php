<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

interface MarkdownFileTestInterface
{
    /**
     * @todo BC remove it
     *
     * @deprecated use {@see self::IGNORED}
     */
    public const LEGACY_SKIPPED = null;
    /**
     * Do not execute this example; it will be ignored entirely
     */
    public const IGNORED = 0;
    /**
     * Do not expect output here; it is written in the following languageless code block (\`\`\`)
     */
    public const OUTPUT_IN_MARKDOWN = 1;

    public static function getPathToMarkdownFile(): string;

    public function testPhpExamplesGivenInMarkdownFileWork(string $example, string $expectedOutput): void;

    /**
     * @return iterable<string, array{0: string, 1: string}>
     *
     * @throws Exception\MarkdownFileTestException
     */
    public static function dataPhpExamplesGivenInMarkdownFileWork(): iterable;

    /**
     * @return iterable<int|string, string|self::*>
     */
    public static function getExpectedOutputsOfPhpExamples(): iterable;
}
