<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Tests\Fixtures\NoNullReturnRule;

final readonly class WithoutNull
{
    public function ok(): int
    {
        return 123;
    }
}