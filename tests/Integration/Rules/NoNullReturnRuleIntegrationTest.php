<?php

declare(strict_types=1);

/*
 * SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */

namespace Haspadar\PHPStanEoRules\Tests\Integration\Rules;

use Haspadar\PHPStanEoRules\Rules\NoNullReturnRule;
use Haspadar\PHPStanEoRules\Tests\Integration\Constraints\RuleFailsWithMessage;
use Haspadar\PHPStanEoRules\Tests\Integration\Constraints\RulePasses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class NoNullReturnRuleIntegrationTest extends TestCase
{
    private const FIXTURES_DIR = __DIR__ . '/../../Fixtures/Rules/NoNullReturnRule';

    #[Test]
    public function returnsSuccessWhenSuppressedNullGiven(): void
    {
        self::assertThat(
            self::FIXTURES_DIR . '/SuppressedNull.php',
            new RulePasses(NoNullReturnRule::class),
        );
    }

    #[Test]
    public function returnsErrorWhenUnsuppressedNullGiven(): void
    {
        self::assertThat(
            self::FIXTURES_DIR . '/WithNullReturn.php',
            new RuleFailsWithMessage(
                NoNullReturnRule::class,
                'Returning null is forbidden by EO rules',
            ),
        );
    }
}
