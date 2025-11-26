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
const sourceFiles = changedFiles.filter(f => f.endsWith('.php') && !f.includes('tests/') && !f.includes('test/'));
const testFiles = changedFiles.filter(f => f.endsWith('.php') && (f.includes('tests/') || f.includes('test/')));
if (sourceFiles.length > 0 && testFiles.length === 0) {
    warn('Source code modified without test changes');
}

// Debug statements
const phpFiles = changedFiles.filter(f => f.endsWith('.php'));
const debugPatterns = [/var_dump\s*\(/, /print_r\s*\(/, /\bdd\s*\(/, /dump\s*\(/];
for (const file of phpFiles) {
    const content = await danger.github.utils.fileContents(file);
    for (const pattern of debugPatterns) {
        if (pattern.test(content)) {
            fail(`Debug statement found in ${file}`);
            break;
        }
    }
}

// Composer sync - checks both modified and created files
if (changedFiles.includes('composer.json') && !changedFiles.includes('composer.lock')) {
    fail('composer.json modified but composer.lock not updated');
}