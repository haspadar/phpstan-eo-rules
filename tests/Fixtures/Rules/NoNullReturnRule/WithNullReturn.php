<?php

declare(strict_types=1);

/*
 * SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */

namespace Haspadar\PHPStanEoRules\Tests\Fixtures\Rules\NoNullReturnRule;

final readonly class WithNullReturn
{
    public function bad(): mixed
    {
        return null;
    }
}
