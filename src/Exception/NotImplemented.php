<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Exception;

use LogicException;

final class NotImplemented extends LogicException implements Exception
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

    /**
     * Prototyping helper
     *
     * @throws self
     */
    public static function throw(?string $something = null): never
    {
        throw new self($something ?? 'This');
    }
}
