<?php declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\TestCase;

class ArrayShortsTest extends TestCase
{
    /** @dataProvider dataKeyMapWorksWhenCalledWithOneKey */
    public function testKeyMapWorksWhenCalledWithOneKey(string $key, string $expect): void
    {
        $expected = $array = [
            'a' => 1,
        ];
        $expected[$key] = $expect;

        static::assertSame($expected, ArrayShorts::keyMap([$this, 'keyMapModifier'], $array, $key));
    }

    public static function dataKeyMapWorksWhenCalledWithOneKey(): array
    {
        return [
            'known key' => ['a', static::keyMapModifier(1, 'a')],
            'unknown key' => ['b', static::keyMapModifier(null, 'b')],
        ];
    }

    public function testKeyMapWorksWhenCalledWithMultipleKeys(): void
    {
        $array = [
            'a' => 1,
            'b' => 2,
        ];
        $expected = [
            'a' => static::keyMapModifier(1, 'a'),
            'b' => static::keyMapModifier(2, 'b'),
            'c' => static::keyMapModifier(null, 'c'),
        ];
        static::assertSame($expected, ArrayShorts::keyMap([$this, 'keyMapModifier'], $array, 'a', 'b', 'c'));
    }

    public static function keyMapModifier(?int $v, string $k): string
    {
        if ($v === null) {
            $v = 'null';
        }
        return "${k} was ${v}";
    }
}
