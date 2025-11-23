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

final class RulePasses extends Constraint
{
    private ?PhpStanOutcome $outcome = null;

    public function __construct(
        private readonly string $ruleClass
    ) {
    }

    public function toString(): string
    {
        return sprintf('passes PHPStan analysis with rule %s', $this->ruleClass);
    }

    protected function matches($other): bool
    {
        if (!is_string($other) || !file_exists($other)) {
            return false;
        }

        $process = new PhpStanProcess();
        $this->outcome = $process->run($other);

        return !$this->outcome->hasErrors();
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

        if (!$this->outcome) {
            return "\nPHPStan was not executed";
        }

        return "\nExit code: " . $this->outcome->exitCode()
            . "\nPHPStan output:\n" . $this->outcome->outputAsString();
    }
}