<?php

namespace PetrKnap\Shorts;

use Exception;
use PHPUnit\Framework\TestCase;

final class ExceptionWrapperTest extends TestCase
{
    public function testWrapsException(): void
    {
        $innerException = new Exception('', 0);
        $outerException = new class ($innerException) extends Exception {
            use ExceptionWrapper;
        };

        self::assertSame(
            $innerException->getMessage(),
            $outerException->getMessage(),
        );
        self::assertSame(
            $innerException->getCode(),
            $outerException->getCode(),
        );
        self::assertSame(
            $innerException,
            $outerException->getPrevious(),
        );
    }
}
