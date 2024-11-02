<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

trait HasRequirements
{
    /**
     * @note always use named arguments
     *
     * @param iterable<string> $extensions
     * @param iterable<string> $classes
     * @param iterable<string> $functions
     * @param iterable<string> $constants
     *
     * @throws Exception\MissingRequirement
     */
    private static function checkRequirements(
        iterable $extensions = [],
        iterable $classes = [],
        iterable $functions = [],
        iterable $constants = [],
    ): void {
        foreach ($extensions as $extension) {
            if (!extension_loaded($extension)) {
                throw new Exception\MissingRequirement(self::class, 'extension', $extension);
            }
        }

        foreach ($classes as $class) {
            if (!class_exists($class)) {
                throw new Exception\MissingRequirement(self::class, 'class', $class);
            }
        }

        foreach ($functions as $function) {
            if (!function_exists($function)) {
                throw new Exception\MissingRequirement(self::class, 'function', $function);
            }
        }

        foreach ($constants as $constant) {
            if (!defined($constant)) {
                throw new Exception\MissingRequirement(self::class, 'constant', $constant);
            }
        }
    }
}
