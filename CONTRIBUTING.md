# Contributing to phpstan-eo-rules

First off, thank you for considering contributing to phpstan-eo-rules! It's people like you that make the open source community such a great place.

## Code of Conduct

This project and everyone participating in it is governed by a [Code of Conduct](https://www.contributor-covenant.org/version/2/1/code_of_conduct/). By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

If you find a bug, please ensure the bug was not already reported by searching on GitHub under [Issues](https://github.com/haspadar/phpstan-eo-rules/issues). If you're unable to find an open issue addressing the problem, [open a new one](https://github.com/haspadar/phpstan-eo-rules/issues/new). Be sure to include a **title and clear description**, as much relevant information as possible, and a **code sample** or an **executable test case** demonstrating the expected behavior that is not occurring.

### Suggesting Enhancements

If you have an idea for an enhancement, please open an issue to discuss it. This allows us to coordinate our efforts and prevent duplication of work.

### Pull Requests

Pull Requests are the best way to propose changes to the codebase. We actively welcome your pull requests:

1.  Fork the repo and create your branch from `main`.
2.  Set up your development environment.
3.  Add tests for your changes.
4.  Ensure the test suite passes.
5.  Make sure your code lints.
6.  Issue that pull request!

## Development Setup

To get started with the project, you'll need to have [PHP](https://www.php.net/) (versions 8.2-8.5 are supported) and [Composer](https://getcomposer.org/) installed. You'll also need [Node.js](https://nodejs.org/) and [npm](https://www.npmjs.com/) to run some of the linting checks.

1.  **Clone the repository:**

    ```bash
    git clone https://github.com/haspadar/phpstan-eo-rules.git
    cd phpstan-eo-rules
    ```

2.  **Install PHP and Node dependencies:**

    ```bash
    composer install
    npm install
    ```

## Running aLinter and Checks

This project uses several tools to ensure code quality and consistency.

### Coding Style

We use `php-cs-fixer` to enforce coding standards.

To check for and view coding style violations, run:

```bash
composer cs-check
```

To automatically fix coding style violations, run:

```bash
composer cs-fix
```

### Static Analysis

We use PHPStan for static analysis. To run the analysis, use:

```bash
composer phpstan
```

### Tests

We use PHPUnit for testing. To run the test suite, use:

```bash
composer test
```

## Pull Request Guidelines

Before you submit a pull request, check that it meets these guidelines:

1.  **Conventional Commits:** The PR title must follow the [Conventional Commits](https://www.conventionalcommits.org/en/v1.0.0/) format (e.g., `feat(rules): Add new rule for immutability`).
2.  **Tests:** The pull request should include tests for any new features or bug fixes.
3.  **Description:** The pull request description should be meaningful and describe the changes.
4.  **No Debug Statements:** Ensure there are no `var_dump`, `print_r`, `dd`, or `dump` calls in your code.
5.  **Composer Lock File:** If you change dependencies in `composer.json`, you must run `composer update` and commit the `composer.lock` file.

Our CI pipeline will automatically check these guidelines on your PR.

Thank you for your contribution!
