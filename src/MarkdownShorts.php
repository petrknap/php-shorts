<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

final class MarkdownShorts
{
    public static function evaluatePhpCodeBlock(string $phpCodeBlock): string
    {
        ob_start();
        eval($phpCodeBlock);
        return (string) ob_get_clean();
    }

    /**
     * @todo BC remove it
     *
     * @deprecated use {@see self::evaluatePhpCodeBlock()}
     */
    public static function evaluatePhpExample(string $phpExample): string
    {
        return self::evaluatePhpCodeBlock($phpExample);
    }

    /** @return iterable<int, string> */
    public static function extractPhpCodeBlocks(string $content): iterable
    {
        return self::extractCodeBlocks($content, 'php');
    }

    /**
     * @todo BC remove it
     *
     * @deprecated use {@see self::extractPhpCodeBlocks()}
     *
     * @return iterable<string>
     */
    public static function extractPhpExamples(string $content): iterable
    {
        return self::extractPhpCodeBlocks($content);
    }

    /** @return iterable<int, string> */
    public static function extractLanguagelessCodeBlocks(string $content): iterable
    {
        return self::extractCodeBlocks($content, '');
    }

    /** @return iterable<int, string> */
    private static function extractCodeBlocks(string $content, string $inLanguage): iterable
    {
        $codeBlocks = explode('```', $content);
        $countOfCodeBlocks = count($codeBlocks);
        $codeBlockIndex = 0;
        for ($i = 1; $i < $countOfCodeBlocks; $i += 2) {
            [$language, $codeBlock] = explode(PHP_EOL, $codeBlocks[$i], 2);
            if ($language === $inLanguage) {
                yield $codeBlockIndex => $codeBlock;
            }
            $codeBlockIndex++;
        }
    }
}
