<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration\Constraints;

use Haspadar\PHPStanEoRules\Tests\Integration\PhpStanOutcome;
use Haspadar\PHPStanEoRules\Tests\Integration\PhpStanProcess;
use PHPUnit\Framework\Constraint\Constraint;

use function basename;
use function file_exists;
use function get_debug_type;
use function is_string;
use function sprintf;

/**
 * Asserts that a file passes PHPStan analysis with a given rule.
 * The constraint expects a file path string as input.
 */
final class RulePasses extends Constraint
{
    private ?PhpStanOutcome $lastOutcome = null;

    public function __construct(
        private readonly string $ruleClass,
    ) {
    }

    public function toString(): string
    {
        return sprintf('passes PHPStan analysis with rule %s', $this->ruleClass);
    }

    protected function matches($other): bool
    {
        $this->lastOutcome = $this->runPhpStan($other);

        if (! $this->lastOutcome) {
            return false;
        }

        return ! $this->lastOutcome->hasErrors();
    }

    protected function failureDescription($other): string
    {
        return 'file ' . basename($other) . ' ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (! is_string($other)) {
            return "\nProvided value is not a string: " . get_debug_type($other);
        }

        if (! file_exists($other)) {
            return "\nFile does not exist: " . $other;
        }

        if (! $this->lastOutcome) {
            return "\nPHPStan was not executed";
        }

        return "\nExit code: " . $this->lastOutcome->exitCode()
            . "\nPHPStan output:\n" . $this->lastOutcome->outputAsString();
    }

    private function runPhpStan(mixed $other): ?PhpStanOutcome
    {
        if (! is_string($other) || ! file_exists($other)) {
            return null;
        }

        return (new PhpStanProcess())->run($other);
    }
}
