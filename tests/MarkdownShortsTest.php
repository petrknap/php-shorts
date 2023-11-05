<?php declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\TestCase;

final class MarkdownShortsTest extends TestCase
{
    public function testEvaluatesPhpExample(): void
    {
        self::assertSame(
            'NULL' . PHP_EOL,
            MarkdownShorts::evaluatePhpExample('var_dump(null);')
        );
    }

    public function testEvaluatesPhpExamplesInSharedContext(): void
    {
        MarkdownShorts::evaluatePhpExample('function f(int $x): int { return $x + 1; }');
        self::assertSame(
            'int(2)' . PHP_EOL,
            MarkdownShorts::evaluatePhpExample('var_dump(f(1));')
        );
    }

    public function testExtractsPhpExamples(): void
    {
        self::assertSame(
            [
                $this->fileGetContents('file.md.php_0.txt'),
                $this->fileGetContents('file.md.php_1.txt'),
            ],
            iterator_to_array(
                MarkdownShorts::extractPhpExamples(
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
