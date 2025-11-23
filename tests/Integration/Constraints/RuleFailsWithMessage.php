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

final class RuleFailsWithMessage extends Constraint
{
    private ?PhpStanOutcome $analysis = null;

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
        if (!is_string($other) || !file_exists($other)) {
            return false;
        }

        $runner = new PhpStanProcess();
        $this->analysis = $runner->run($other);

        return $this->analysis->exitCode() !== 0
            && $this->analysis->containsMessage($this->expectedMessage);
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

        if (!$this->analysis) {
            return "\nPHPStan was not executed";
        }

        return "\nExpected exit code: non-zero"
            . "\nActual exit code:   " . $this->analysis->exitCode()
            . "\nExpected message:   " . var_export($this->expectedMessage, true)
            . "\nPHPStan output:\n" . $this->analysis->outputAsString();
    }
}