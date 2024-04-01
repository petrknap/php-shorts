<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

interface HasRequirements
{
    /**
     * @throws Exception\MissingRequirement
     */
    public static function checkRequirements(): void;
}
