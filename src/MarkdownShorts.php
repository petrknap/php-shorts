<?php declare(strict_types=1);

namespace PetrKnap\Shorts;

final class MarkdownShorts
{
    public static function evaluatePhpExample(string $phpExample): string
    {
        ob_start();
        eval($phpExample);
        return (string) ob_get_clean();
    }

    /** @return iterable<string> */
    public static function extractPhpExamples(string $content): iterable
    {
        $examples = explode('```', $content);
        $countOfExamples = count($examples);
        for ($i = 1; $i < $countOfExamples; $i += 2) {
            [$language, $example] = explode(PHP_EOL, $examples[$i], 2);
            if ($language === 'php') {
                yield $example;
            }
        }
    }
}
