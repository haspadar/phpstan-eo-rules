<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NoNullReturnRuleIntegrationTest extends TestCase
{
    private string $phpstanBin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->phpstanBin = __DIR__ . '/../../../vendor/bin/phpstan';
        self::assertFileExists(
            $this->phpstanBin,
            'PHPStan binary not found; ensure dependencies are installed',
        );
    }

    #[Test]
    public function returnsSuccessWhenSuppressedNullGiven(): void
    {
        $fixture = __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/SuppressedNull.php';

        exec(
            sprintf(
                '%s analyse --configuration %s --error-format raw %s',
                escapeshellcmd($this->phpstanBin),
                escapeshellarg(__DIR__ . '/../../../phpstan.neon'),
                escapeshellarg($fixture),
            ),
            $output,
            $code,
        );

        self::assertSame(
            0,
            $code,
            'Suppressed return null should not trigger an error',
        );
        self::assertEmpty(
            $output,
            'No errors should be reported for suppressed null return',
        );
    }

    #[Test]
    public function returnsErrorWhenUnsuppressedNullGiven(): void
    {
        $fixture = __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithNullReturn.php';

        exec(
            sprintf(
                '%s analyse --configuration %s --error-format raw %s',
                escapeshellcmd($this->phpstanBin),
                escapeshellarg(__DIR__ . '/../../../phpstan.neon'),
                escapeshellarg($fixture),
            ),
            $output,
            $code,
        );

        self::assertNotSame(
            0,
            $code,
            'Unsuppressed return null should trigger an error',
        );
        self::assertStringContainsString(
            'Returning null is forbidden by EO rules',
            implode("\n", $output),
            'Expected error message should appear in output',
        );
    }
}