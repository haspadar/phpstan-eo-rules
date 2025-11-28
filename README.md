# PHPStan EO Rules

[![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)](https://www.php.net/releases/8.2/)

---

## 📦 About

A collection of PHPStan rules enforcing the principles of Elegant Objects:
immutability, composition, no static state, and explicit contracts.

## 🔍 Available Rules

### NoNullReturnRule

Prohibits returning `null` from methods. Instead of returning null, methods should either return a meaningful value or throw an exception. This eliminates null checks and makes code more predictable.

**❌ Bad:**

```php
public function find(int $id): ?User
{
    return null; // Error: Returning null is forbidden
}
```

**✅ Good:**

```php
public function find(int $id): User
{
    throw new UserNotFoundException($id);
}

// Or use a Null Object pattern
public function find(int $id): User
{
    return new GuestUser();
}
```

To suppress this rule for specific cases:

```php
/** @phpstan-ignore NoNullReturn */
return null;
```

---

## ⚙️ Installation

```bash
composer require --dev haspadar/phpstan-eo-rules
```

Enable in your `phpstan.neon`:

```neon
includes:
    - vendor/haspadar/phpstan-eo-rules/extension.neon
```

Requirements: PHP 8.2+

## 🤝 Contributing

Contributions are welcome! Please read the [Contributing Guide](CONTRIBUTING.md) for details on how to get started, run tests, and submit your work.

## 📄 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

