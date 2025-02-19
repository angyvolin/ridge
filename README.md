# PHPinnacle Ridge

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This library is a pure asynchronous PHP implementation of the AMQP 0-9-1 protocol.

Code is mostly based on [bunnyphp](https://github.com/jakubkulhan/bunny), but use [amphp](https://amphp.org) for async operations.

## Install

Via Composer

```bash
$ composer require phpinnacle/ridge
```

## Basic Usage

```php
<?php

use Amp\Loop;
use PHPinnacle\Ridge\Channel;
use PHPinnacle\Ridge\Client;
use PHPinnacle\Ridge\Message;

require __DIR__ . '/vendor/autoload.php';

Loop::run(function () {
    $client = Client::create('amqp://user:pass@localhost:5672');

    yield $client->connect();

    /** @var Channel $channel */
    $channel = yield $client->channel();

    yield $channel->queueDeclare('queue_name');

    for ($i = 0; $i < 10; $i++) {
        yield $channel->publish("test_$i", '', 'queue_name');
    }

    yield $channel->consume(function (Message $message, Channel $channel) {
        echo $message->content() . \PHP_EOL;

        yield $channel->ack($message);
    }, 'queue_name');
});

```

More examples can be found in [`examples`](examples) directory.

## Testing

```bash
$ composer test
```

## Benchmarks

We run benchmarks as follow:

```bash
$ RIDGE_BENCHMARK_DSN=amqp://user:pass@localhost:5672 composer bench
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email dev@phpinnacle.com instead of using the issue tracker.

## Credits

- [PHPinnacle][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/phpinnacle/ridge.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/phpinnacle/ridge.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/phpinnacle/ridge.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpinnacle/ridge.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phpinnacle/ridge
[link-scrutinizer]: https://scrutinizer-ci.com/g/phpinnacle/ridge/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/phpinnacle/ridge
[link-downloads]: https://packagist.org/packages/phpinnacle/ridge
[link-author]: https://github.com/phpinnacle
[link-contributors]: ../../contributors
