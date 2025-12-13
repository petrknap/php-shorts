<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

final class MarkdownShortsTest extends TestCase
{
    #[Group('MarkdownShorts::evaluatePhpCodeBlock')]
    public function testEvaluatesGivenCodeBlockAsPhpAndReturnsOutput(): void
    {
        self::assertSame(
            'NULL' . PHP_EOL,
            MarkdownShorts::evaluatePhpCodeBlock('var_dump(null);')
        );
    }

    #[Group('MarkdownShorts::evaluatePhpCodeBlock')]
    public function testEvaluatesGivenCodeBlocksAsPhpInSharedContextAndReturnsOutput(): void
    {
        MarkdownShorts::evaluatePhpCodeBlock('function f(int $x): int { return $x + 1; }');
        self::assertSame(
            'int(2)' . PHP_EOL,
            MarkdownShorts::evaluatePhpCodeBlock('var_dump(f(1));')
        );
    }

    #[Group('MarkdownShorts::extractCodeBlocks')]
    public function testExtractsPhpCodeBlocksFromGivenContent(): void
    {
        self::assertSame(
            [
                3 => $this->fileGetContents('file.md.3.txt'),
                4 => $this->fileGetContents('file.md.4.txt'),
            ],
            iterator_to_array(
                MarkdownShorts::extractPhpCodeBlocks(
                    $this->fileGetContents('file.md')
                )
            )
        );
    }

    #[Group('MarkdownShorts::extractCodeBlocks')]
    public function testExtractsLanguagelessCodeBlocksFromGivenContent(): void
    {
        self::assertSame(
            [
                1 => $this->fileGetContents('file.md.1.txt'),
            ],
            iterator_to_array(
                MarkdownShorts::extractLanguagelessCodeBlocks(
                    $this->fileGetContents('file.md')
                )
            )
        );
    }

    private function fileGetContents(string $pathToFile): string
    {
        return file_get_contents(__DIR__ . '/MarkdownShortsTest/' . $pathToFile);
    }
}
