<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Integration;

use Haspadar\PHPStanEoRules\Rules\NoNullReturnRule;
use Haspadar\PHPStanEoRules\Tests\Integration\Constraints\RuleFailsWithMessage;
use Haspadar\PHPStanEoRules\Tests\Integration\Constraints\RulePasses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NoNullReturnRuleIntegrationTest extends TestCase
{
    #[Test]
    public function returnsSuccessWhenSuppressedNullGiven(): void
    {
        self::assertThat(
            __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/SuppressedNull.php',
            new RulePasses(NoNullReturnRule::class)
        );
    }

    #[Test]
    public function returnsErrorWhenUnsuppressedNullGiven(): void
    {
        self::assertThat(
            __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule/WithNullReturn.php',
            new RuleFailsWithMessage(
                NoNullReturnRule::class,
                'Returning null is forbidden by EO rules'
            )
        );
    }
}