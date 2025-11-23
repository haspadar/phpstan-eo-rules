<?php
/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration;

final readonly class PhpStanOutcome
{
    public function __construct(
        private int $exitCode,
        private array $output
    ) {
    }

    public function exitCode(): int
    {
        return $this->exitCode;
    }

    public function output(): array
    {
        return $this->output;
    }

    public function outputAsString(): string
    {
        return implode("\n", $this->output);
    }

    public function hasErrors(): bool
    {
        return $this->exitCode !== 0;
    }

    public function containsMessage(string $message): bool
    {
        return str_contains($this->outputAsString(), $message);
    }
}