## Installation

You can install the package via composer:

```bash
composer require imusicjj/zpl-builder
```

## Usage

``` php
    $label = new Label("30m", "21mm");
    $label->addElement(
        (new Text("Lager 140219", FontSize::SIZE_8))->x("1mm")->y("12mm")
    );

    $zpl = $label->toZpl();
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Security

If you discover any security related issues, please email jj@imusic.dk instead of using the issue tracker.

## Credits

- [Jesper Jacobsen](https://github.com/iMusicJJ)
- [All Contributors](../../contributors)
