<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Exception;

use LogicException;

/**
 * @todo BC remove it
 *
 * @deprecated use {@link https://github.com/petrknap/php-has-requirements}
 */
final class MissingRequirement extends LogicException implements Exception
{
    /**
     * @param class-string $className
     */
    public function __construct(
        string $className,
        string $requirementType,
        string $requirementName,
    ) {
        parent::__construct(
            sprintf(
                '%s requires %s %s',
                $className,
                $requirementType,
                $requirementName,
            )
        );
    }
}
