// SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
//
// SPDX-License-Identifier: MIT

const pr = danger.github.pr;
const git = danger.git;

// PR title format
const conventionalCommitPattern = /^(feat|fix|docs|style|refactor|perf|test|build|ci|chore|revert)(\(.+\))?: .+/;
if (!conventionalCommitPattern.test(pr.title)) {
    fail('PR title must follow Conventional Commits format: `type(scope): description`');
}

// PR description
if (!pr.body || pr.body.length < 50) {
    warn('Please add a meaningful PR description (minimum 50 characters)');
}

// PR size
const totalChanges = pr.additions + pr.deletions;
if (totalChanges > 200) {
    warn(`Large PR (${totalChanges} lines). Consider splitting into smaller PRs.`);
}

// Tests - checks both 'tests/' and 'test/' directories
const changedFiles = [...git.modified_files, ...git.created_files];
const isTestPath = (f) => /(^|\/)tests?\//.test(f);
const sourceFiles = changedFiles.filter(f => f.endsWith('.php') && !isTestPath(f));
const testFiles = changedFiles.filter(f => f.endsWith('.php') && isTestPath(f));
if (sourceFiles.length > 0 && testFiles.length === 0) {
    warn('Source code modified without test changes');
}

// Debug statements
schedule(async () => {
    const phpFiles = changedFiles.filter(f => f.endsWith('.php'));
    const debugPatterns = [/var_dump\s*\(/, /print_r\s*\(/, /\bdd\s*\(/, /dump\s*\(/];

    for (const file of phpFiles) {
        const content = await danger.github.utils.fileContents(file);
        if (debugPatterns.some(p => p.test(content))) {
            fail(`Debug statement found in ${file}`);
        }
    }
});

// Composer sync - checks both modified and created files
// Ignores changes that don't touch require/require-dev/autoload/autoload-dev sections
schedule(async () => {
    if (changedFiles.includes('composer.json') && !changedFiles.includes('composer.lock')) {
        const composerDiff = await danger.git.diffForFile('composer.json');

        // Only check actual changes (+ or - lines), not context
        const diffLines = composerDiff?.diff?.split('\n') || [];
        const changedLines = diffLines.filter(line =>
            (line.startsWith('+') || line.startsWith('-')) &&
            !line.startsWith('+++') &&
            !line.startsWith('---')
        );
        const hasRequireChanges = changedLines.some(line =>
            line.includes('"require"') ||
            line.includes('"require-dev"') ||
            line.includes('"autoload"') ||
            line.includes('"autoload-dev"')
        );

        // Only fail if require/autoload sections changed
        if (hasRequireChanges) {
            fail('composer.json modified but composer.lock not updated');
        }
    }
});