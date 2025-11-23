<?php
/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration;

final class PhpStanProcess
{
    public function __construct(
        private readonly string $phpstanBin = __DIR__ . '/../../vendor/bin/phpstan',
        private readonly string $phpstanConfig = __DIR__ . '/../../phpstan.neon'
    ) {
    }

    public function run(string $file): PhpStanOutcome
    {
        $phpstanBin = realpath($this->phpstanBin);
        $phpstanConfig = realpath($this->phpstanConfig);

        if (!$phpstanBin || !$phpstanConfig) {
            throw new \RuntimeException('PHPStan binary or config not found');
        }

        $output = [];
        $exitCode = 0;

        exec(
            sprintf(
                '%s analyse --configuration %s --error-format raw --no-progress --no-ansi %s 2>&1',
                escapeshellcmd($phpstanBin),
                escapeshellarg($phpstanConfig),
                escapeshellarg($file)
            ),
            $output,
            $exitCode
        );

        return new PhpStanOutcome($exitCode, $output);
    }
}