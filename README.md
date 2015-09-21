# WoW Activity Tweet Bot

[![Software License][ico-license]](LICENSE.md)

A light application witch tweet for each new player activity on world of warcraft game

## Install

Use composer to load dependencies, then set .env credential (like on .env.example)

## Usage


Call bot checkUpdate method at regular interval (use cron), this method is called on index.php script
```php
    (new \GameScan\WoWActivityTweetBot\Bot())->checkUpdate();
```


## Security

If you discover any security related issues, please email contact@game-scan.com instead of using the issue tracker.

## Credits

- [kandran][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square

[link-author]: https://github.com/kandran
