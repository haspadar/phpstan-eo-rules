<?php

/*
 * SPDX-FileCopyrightText: Copyright (c) 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

namespace Haspadar\PHPStanEoRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

use function str_contains;
use function strtolower;

use const DIRECTORY_SEPARATOR;

/**
 * @implements Rule<Return_>
 */
final class NoNullReturnRule implements Rule
{
    public function getNodeType(): string
    {
        return Return_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->expr === null) {
            return [];
        }

        if ($node->expr instanceof Node\Expr\ConstFetch &&
            strtolower($node->expr->name->toString()) === 'null'
        ) {
            if (! $this->isUserCode($scope->getFile())) {
                return [];
            }

            return [
                RuleErrorBuilder::message('Returning null is forbidden by EO rules')
                    ->identifier('NoNullReturn')
                    ->build(),
            ];
        }

        return [];
    }

    private function isUserCode(string $file): bool
    {
        return ! str_contains($file, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR);
    }
}
