<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit\Exception;

use OutOfRangeException;
use PetrKnap\Shorts\PhpUnit\MarkdownFileTestTrait;

/**
 * @todo BC move it to Testing
 *
 * @internal used by {@see MarkdownFileTestTrait}
 */
final class MarkdownFileTestTraitCannotDetermineExpectedOutput extends OutOfRangeException implements MarkdownFileTestException
{
    public function __construct(
        string $codeBlockLanguage,
        int $codeBlockIndex,
    ) {
        parent::__construct(sprintf(
            '%s cannot determine expected output for %s code block #%d',
            MarkdownFileTestTrait::class,
            $codeBlockLanguage,
            $codeBlockIndex,
        ));
    }
}
