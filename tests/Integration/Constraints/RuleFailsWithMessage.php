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

/**
 * Asserts that a file fails PHPStan analysis with a specific error message.
 *
 * @param string $other Path to the file to analyze
 */
final class RuleFailsWithMessage extends Constraint
{
    public function __construct(
        private readonly string $ruleClass,
        private readonly string $expectedMessage
    ) {
    }

    public function toString(): string
    {
        return sprintf(
            'fails PHPStan analysis with rule %s and contains message "%s"',
            $this->ruleClass,
            $this->expectedMessage
        );
    }

    protected function matches($other): bool
    {
        $outcome = $this->runAnalysis($other);

        if (!$outcome) {
            return false;
        }

        return $outcome->hasErrors()
            && $outcome->containsMessage($this->expectedMessage);
    }

    protected function failureDescription($other): string
    {
        return 'file ' . basename($other) . ' ' . $this->toString();
    }

    protected function additionalFailureDescription($other): string
    {
        if (!is_string($other)) {
            return "\nProvided value is not a string: " . get_debug_type($other);
        }

        if (!file_exists($other)) {
            return "\nFile does not exist: " . $other;
        }

        $outcome = $this->runAnalysis($other);

        if (!$outcome) {
            return "\nPHPStan was not executed";
        }

        return "\nExpected exit code: non-zero"
            . "\nActual exit code:   " . $outcome->exitCode()
            . "\nExpected message:   " . var_export($this->expectedMessage, true)
            . "\nPHPStan output:\n" . $outcome->outputAsString();
    }

    private function runAnalysis(mixed $other): ?PhpStanOutcome
    {
        if (!is_string($other) || !file_exists($other)) {
            return null;
        }

        return (new PhpStanProcess())->run($other);
    }
}