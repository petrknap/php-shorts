<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FilterCommandTest extends TestCase
{
    private const INPUT = 'input';

    public function testFiltersInputByCommand(): void
    {
        self::assertSame(
            self::INPUT,
            (new FilterCommand('cat'))->filter(self::INPUT),
        );
    }

    #[DataProvider('dataThrows')]
    public function testThrows(string $command, array $options, string $data): void
    {
        self::expectException(Exception\FilterCommandCouldNotFilterData::class);

        (new FilterCommand($command, $options))->filter($data);
    }

    public static function dataThrows(): array
    {
        return [
            'unknown command' => ['unknown', [], ''],
            'unknown option' => ['php', ['--unknown'], ''],
            'wrong data' => ['php', [], '<?php wrong data'],
        ];
    }
}
