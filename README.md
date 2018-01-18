# Swiftmailer Punycode Plugin

[![Build Status](https://travis-ci.org/ossinkine/swiftmailer-punycode-plugin.svg?branch=master)](https://travis-ci.org/ossinkine/swiftmailer-punycode-plugin)

Swiftmailer plugin to convert domain in email addresses to punycode.

## Installation

```bash
composer require ossinkine/swiftmailer-punycode-plugin
```

## Usage

Create and register a plugin instance when you setup a `Swift_Mailer` instance.

```php
use Ossinkine\Swift\Plugin\PunycodePlugin;

// Create the Mailer using any Transport
$mailer = new Swift_Mailer(
  new Swift_SmtpTransport('smtp.example.org', 25)
);

// Register the plugin
$mailer->registerPlugin(new PunycodePlugin());
```

Now you can send an email to an address with Unicode-encoded domain.

```php
// Create a message with Unicode-encoded receiver address
$message = (new Swift_Message())
  ->setTo(['receiver@bücher.tld'])
;
// Send the message
$mailer->send($message);
```

## Usage with Symfony

Just register a service with a `swiftmailer.default.plugin` tag in your `services.yml`.

```yaml
Ossinkine\Swift\Plugin\PunycodePlugin:
    tags: [swiftmailer.default.plugin]
```

## License

[Swiftmailer Punycode Plugin](https://github.com/ossinkine/swiftmailer-punycode-plugin) is licensed under the [MIT license](LICENSE).
