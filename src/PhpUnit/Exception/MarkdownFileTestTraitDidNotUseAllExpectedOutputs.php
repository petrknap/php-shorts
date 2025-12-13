<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\PhpUnit\Exception;

use OutOfRangeException;
use PetrKnap\Shorts\PhpUnit\MarkdownFileTestTrait;

/**
 * @internal used by {@see MarkdownFileTestTrait}
 */
final class MarkdownFileTestTraitDidNotUseAllExpectedOutputs extends OutOfRangeException implements MarkdownFileTestException
{
    /**
     * @param array<array-key, mixed> $unusedExpectedOutputs
     */
    public function __construct(
        array $unusedExpectedOutputs,
    ) {
        parent::__construct(sprintf(
            '%s did not use all expected outputs, these remained unused: %s',
            MarkdownFileTestTrait::class,
            implode(', ', array_keys($unusedExpectedOutputs)),
        ));
    }
}
