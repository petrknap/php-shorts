<?php

declare(strict_types=1);

namespace PetrKnap\Shorts;

use PHPUnit\Framework\TestCase;

final class HasRequirementsTest extends TestCase
{
    public function testChecksRequirements(): void
    {
        self::createInstance(
            extensions: ['zlib'],
            classes: ['DeflateContext'],
            functions: ['zlib_encode'],
            constants: ['ZLIB_ENCODING_RAW'],
        );

        self::assertTrue(true);
    }

    public function testThrowsWhenExtensionIsNotLoaded(): void
    {
        self::expectException(Exception\MissingRequirement::class);

        self::createInstance(extensions: ['unknown']);
    }

    public function testThrowsWhenClassDoesNotExist(): void
    {
        self::expectException(Exception\MissingRequirement::class);

        self::createInstance(classes: ['Unknown']);
    }

    public function testThrowsWhenFunctionDoesNotExist(): void
    {
        self::expectException(Exception\MissingRequirement::class);

        self::createInstance(functions: ['unknown']);
    }

    public function testThrowsWhenConstantIsNotDefined(): void
    {
        self::expectException(Exception\MissingRequirement::class);

        self::createInstance(constants: ['UNKNOWN']);
    }

    private static function createInstance(
        array $extensions = [],
        array $classes = [],
        array $functions = [],
        array $constants = [],
    ): void {
        new class (
            $extensions,
            $classes,
            $functions,
            $constants,
        ) {
            use HasRequirements;

            public function __construct(
                array $extensions,
                array $classes,
                array $functions,
                array $constants,
            ) {
                self::checkRequirements(
                    extensions: $extensions,
                    classes: $classes,
                    functions: $functions,
                    constants: $constants,
                );
            }
        };
    }
}
