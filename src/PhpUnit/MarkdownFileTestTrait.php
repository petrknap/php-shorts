<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

use OutOfRangeException;
use PetrKnap\Shorts\MarkdownShorts;
use PHPUnit\Framework\TestCase;
use Traversable;

/**
 * @psalm-require-implements MarkdownFileTestInterface
 *
 * @mixin TestCase
 */
trait MarkdownFileTestTrait
{
    /** @dataProvider dataPhpExamplesGivenInMarkdownFileWork */
    public function testPhpExamplesGivenInMarkdownFileWork(string $example, ?string $expectedOutput): void
    {
        if ($expectedOutput === null) {
            self::markTestSkipped();
        }
        static::assertSame(
            $expectedOutput,
            MarkdownShorts::evaluatePhpExample($example)
        );
    }

    public static function dataPhpExamplesGivenInMarkdownFileWork(): iterable
    {
        $pathToMarkdownFile = static::getPathToMarkdownFile();
        $examples = MarkdownShorts::extractPhpExamples(file_get_contents($pathToMarkdownFile));
        $expectedOutputs = static::getExpectedOutputsOfPhpExamples();

        if ($expectedOutputs instanceof Traversable) {
            $expectedOutputs = iterator_to_array($expectedOutputs);
        }

        foreach ($examples as $example) {
            $expectedOutputId = array_key_first($expectedOutputs);
            $expectedOutput = array_shift($expectedOutputs);

            if ($expectedOutputId === null) {
                throw new class ('Missing expect') extends OutOfRangeException implements Exception\MarkdownFileTestException {
                };
            }

            yield "{$pathToMarkdownFile}#{$expectedOutputId}" => [$example, $expectedOutput];
        }

        if (!empty($expectedOutputs)) {
            throw throw new class ('Missing example') extends OutOfRangeException implements Exception\MarkdownFileTestException {
            };
        }
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        return [];
    }
}
