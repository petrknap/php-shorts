<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit;

use PetrKnap\Shorts\MarkdownShorts;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Traversable;

/**
 * @todo BC move it to Testing
 *
 * @psalm-require-implements MarkdownFileTestInterface
 * @psalm-require-extends TestCase
 *
 * @mixin TestCase
 */
trait MarkdownFileTestTrait
{
    /**
     * @todo BC change $expectedOutput type to string (not null)
     */
    #[DataProvider('dataPhpExamplesGivenInMarkdownFileWork')]
    public function testPhpExamplesGivenInMarkdownFileWork(string $example, ?string $expectedOutput): void
    {
        if ($expectedOutput === MarkdownFileTestInterface::LEGACY_SKIPPED) { // @todo BC remove this way to ignore example
            self::markTestSkipped();
        }
        static::assertSame(
            $expectedOutput,
            MarkdownShorts::evaluatePhpCodeBlock($example),
        );
    }

    public static function dataPhpExamplesGivenInMarkdownFileWork(): iterable
    {
        $pathToMarkdownFile = static::getPathToMarkdownFile();
        $markdownFileContent = file_get_contents($pathToMarkdownFile);
        $phpCodeBlocks = MarkdownShorts::extractPhpCodeBlocks($markdownFileContent);
        $languagelessCodeBlocks = MarkdownShorts::extractLanguagelessCodeBlocks($markdownFileContent);
        $expectedOutputs = static::getExpectedOutputsOfPhpExamples();

        if ($languagelessCodeBlocks instanceof Traversable) {
            $languagelessCodeBlocks = iterator_to_array($languagelessCodeBlocks);
        }
        if ($expectedOutputs instanceof Traversable) {
            $expectedOutputs = iterator_to_array($expectedOutputs);
        }

        foreach ($phpCodeBlocks as $index => $phpCodeBlock) {
            $expectedOutputId = array_key_first($expectedOutputs);
            $expectedOutput = array_shift($expectedOutputs);

            if ($expectedOutputId === null) {
                throw new Exception\MarkdownFileTestTraitCannotDetermineExpectedOutput('PHP', $index);
            }

            if ($expectedOutput === MarkdownFileTestInterface::IGNORED) {
                continue;
            }

            if ($expectedOutput === MarkdownFileTestInterface::OUTPUT_IN_MARKDOWN) {
                $expectedOutput = $languagelessCodeBlocks[$index + 1]
                    ?? throw new Exception\MarkdownFileTestTraitCannotDetermineExpectedOutput('PHP', $index);
            }

            yield "{$pathToMarkdownFile}#{$expectedOutputId}" => [$phpCodeBlock, $expectedOutput];
        }

        if ($expectedOutputs !== []) {
            throw new Exception\MarkdownFileTestTraitDidNotUseAllExpectedOutputs($expectedOutputs);
        }
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        return [];
    }
}
