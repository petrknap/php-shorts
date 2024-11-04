<?php

declare(strict_types=1);

namespace PetrKnap\Shorts\Exception;

/**
 * @extends CouldNotProcessData<string>
 */
final class FilterCommandCouldNotFilterData extends CouldNotProcessData implements FilterCommandException
{
}
