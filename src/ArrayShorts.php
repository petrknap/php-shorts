<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

/**
 * @template K of int|string  The type of the individual keys
 * @template E of mixed       The type of the individual elements
 */
final class ArrayShorts
{
    /**
     * @param callable(?E, K): ?E $callback
     * @param array<K, E> $array
     * @param K $key
     * @param K $keys
     *
     * @return array<K, ?E>
     */
    public static function keyMap(callable $callback, array $array, mixed $key, mixed ...$keys): array
    {
        foreach (array_merge([$key], $keys) as $k) {
            $array[$k] = $callback($array[$k] ?? null, $k);
        }
        return $array;
    }
}
