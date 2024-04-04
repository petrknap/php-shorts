<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\TestCase;

final class ArrayShortsTest extends TestCase
{
    /**
     * @group ArrayShorts::keyMap
     * @dataProvider dataAppliesCallbackToElementSpecifiedByKeyOfGivenArray
     */
    public function testAppliesCallbackToElementSpecifiedByKeyOfGivenArray(string $key, string $expect): void
    {
        $expected = $array = [
            'a' => 1,
        ];
        $expected[$key] = $expect;

        self::assertSame($expected, ArrayShorts::keyMap([$this, 'keyMapModifier'], $array, $key));
    }

    public static function dataAppliesCallbackToElementSpecifiedByKeyOfGivenArray(): array
    {
        return [
            'known key' => ['a', self::keyMapModifier(1, 'a')],
            'unknown key' => ['b', self::keyMapModifier(null, 'b')],
        ];
    }

    /** @group ArrayShorts::keyMap */
    public function testAppliesCallbackToElementsSpecifiedByKeysOfGivenArray(): void
    {
        $array = [
            'a' => 1,
            'b' => 2,
        ];
        $expected = [
            'a' => self::keyMapModifier(1, 'a'),
            'b' => self::keyMapModifier(2, 'b'),
            'c' => self::keyMapModifier(null, 'c'),
        ];
        self::assertSame($expected, ArrayShorts::keyMap([$this, 'keyMapModifier'], $array, 'a', 'b', 'c'));
    }

    public static function keyMapModifier(?int $v, string $k): string
    {
        if ($v === null) {
            $v = 'null';
        }
        return "${k} was ${v}";
    }
}
