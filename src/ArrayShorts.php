<?php declare(strict_types=1);

namespace PetrKnap\Shorts;

final class ArrayShorts
{
    public static function keyMap(callable $callback, array $array, mixed $key, mixed ...$keys): array
    {
        foreach (array_merge([$key], $keys) as $k) {
            $array[$k] = $callback($array[$k] ?? null, $k);
        }
        return $array;
    }
}
