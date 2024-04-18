<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use Throwable;

trait ExceptionWrapper
{
    public function __construct(Throwable $reason)
    {
        parent::__construct(
            message: $reason->getMessage(),
            code: $reason->getCode(),
            previous: $reason,
        );
    }
}
