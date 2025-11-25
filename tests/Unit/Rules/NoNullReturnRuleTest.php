<?php

declare(strict_types=1);

/*
 * SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */

namespace Haspadar\PHPStanEoRules\Tests\Unit\Rules;

use Haspadar\PHPStanEoRules\Rules\NoNullReturnRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\Test;

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
            [['Returning null is forbidden by EO rules', 15]],
        );
    }

    #[Test]
    public function returnsNoErrorWhenReturnValueValid(): void
    {
        $this->analyse(
            [__DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithoutNull.php'],
            [],
        );
    }

    #[Test]
    public function returnsNoErrorWhenBareReturnUsed(): void
    {
        $this->analyse(
            [__DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/BareReturn.php'],
            [],
        );
    }
}
