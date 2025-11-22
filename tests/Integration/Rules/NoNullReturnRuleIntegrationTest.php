<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration;

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

        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir, 0777, true);
        }
    }

    public function testSuppressedNullDoesNotTriggerError(): void
    {
        $fixture = __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/SuppressedNull.php';
        $copy = $this->tmpDir . '/SuppressedNull.php';
        copy($fixture, $copy);

        $cmd = sprintf(
            '%s analyse --error-format raw %s',
            escapeshellcmd($this->phpstanBin),
            escapeshellarg($copy)
        );

        exec($cmd, $output, $code);
        $outputText = implode("\n", $output);

        $this->assertSame(
            0,
            $code,
            "Expected suppression to prevent errors, but PHPStan returned non-zero exit code.\nOutput:\n$outputText"
        );

        $this->assertStringNotContainsString(
            'Returning null is forbidden by EO rules',
            $outputText,
            "Error message should not appear when suppression is active."
        );
    }

    public function testUnsuppressedNullTriggersError(): void
    {
        $fixture = __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithNullReturn.php';
        $copy = $this->tmpDir . '/WithNullReturn.php';
        copy($fixture, $copy);

        $cmd = sprintf(
            '%s analyse --error-format raw %s',
            escapeshellcmd($this->phpstanBin),
            escapeshellarg($copy)
        );

        exec($cmd, $output, $code);
        $outputText = implode("\n", $output);

        $this->assertNotSame(
            0,
            $code,
            "Expected error due to return null, but PHPStan exit code was 0.\nOutput:\n$outputText"
        );

        $this->assertStringContainsString(
            'Returning null is forbidden by EO rules',
            $outputText,
            "Error message was expected but not found in output."
        );
    }
}