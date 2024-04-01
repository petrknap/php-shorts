<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Exception;

use RuntimeException;
use Throwable;

/**
 * This is a template, not a real {@see ShortsException}
 *
 * @template TData of mixed
 */
abstract class CouldNotProcessData extends RuntimeException
{
    /**
     * @param TData $data
     */
    public function __construct(
        string $method,
        private mixed $data,
        ?Throwable $reason = null,
    ) {
        parent::__construct(
            sprintf(
                '%s could not process %s',
                $method,
                is_string($data) ? sprintf('string(%d)', strlen($data)) : (is_object($data) ? get_class($data) : gettype($data)),
            ),
            previous: $reason
        );
    }

    /**
     * @return TData
     */
    public function getData(): mixed
    {
        return $this->data;
    }
}
