# PHPStan EO Rules

[![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)](https://www.php.net/releases/8.2/)

---

## 📦 About

A collection of PHPStan rules enforcing the principles of Elegant Objects:
immutability, composition, no static state, and explicit contracts.

This package is currently under development.  
Rules will be added in upcoming releases.

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

Requirements: PHP 8.2

---

## 📄 License

[MIT](LICENSE)
