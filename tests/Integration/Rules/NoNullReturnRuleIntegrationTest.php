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
    private string $tmpDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->phpstanBin = __DIR__ . '/../../../vendor/bin/phpstan';
        $this->tmpDir = sys_get_temp_dir() . '/phpstan-eo-rules-integration';

        if (!@mkdir($this->tmpDir, 0777, true) && !is_dir($this->tmpDir)) {
            throw new \RuntimeException("Failed to create temp dir: $this->tmpDir");
        }
    }

    #[Test]
    public function returnsSuccessWhenSuppressedNullGiven(): void
    {
        $copy = $this->tmpDir . '/SuppressedNull.php';
        copy(
            __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/SuppressedNull.php',
            $copy
        );

        exec(
            sprintf(
                '%s analyse --error-format raw %s',
                escapeshellcmd($this->phpstanBin),
                escapeshellarg($copy)
            ),
            $output,
            $code
        );

        self::assertSame(
            0,
            $code,
            'Suppressed return null should not trigger an error'
        );
    }

    #[Test]
    public function returnsErrorWhenUnsuppressedNullGiven(): void
    {
        $copy = $this->tmpDir . '/WithNullReturn.php';
        copy(
            __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithNullReturn.php',
            $copy
        );

        exec(
            sprintf(
                '%s analyse --error-format raw %s',
                escapeshellcmd($this->phpstanBin),
                escapeshellarg($copy)
            ),
            $output,
            $code
        );

        self::assertNotSame(
            0,
            $code,
            'Unsuppressed return null should trigger an error'
        );
    }
}