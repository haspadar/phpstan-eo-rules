<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Rules;

use Haspadar\PHPStanEoRules\Rules\NoNullReturnRule;
use PHPUnit\Framework\Attributes\Test;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

final class NoNullReturnRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoNullReturnRule();
    }

    #[Test]
    public function reportsErrorWhenReturnNullGiven(): void
    {
        $this->analyse(
            [__DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithNullReturn.php'],
            [['Returning null is forbidden by EO rules', 15]]
        );
    }

    #[Test]
    public function returnsNoErrorWhenReturnValueValid(): void
    {
        $this->analyse(
            [__DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithoutNull.php'],
            []
        );
    }

    #[Test]
    public function returnsNoErrorWhenBareReturnUsed(): void
    {
        $this->analyse(
            [__DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/BareReturn.php'],
            []
        );
    }
}