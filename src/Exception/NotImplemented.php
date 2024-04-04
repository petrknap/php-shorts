<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Exception;

use LogicException;

final class NotImplemented extends LogicException implements ShortsException
{
    public function __construct(
        string $something,
    ) {
        parent::__construct(
            sprintf(
                '%s is not implemented',
                $something,
            ),
        );
    }

    public static function throw(?string $something = null): void
    {
        throw new self($something ?? 'This');
    }
}
