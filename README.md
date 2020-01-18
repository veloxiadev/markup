# veloxia/markup 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/veloxia/markup.svg?style=flat-square)](https://packagist.org/packages/veloxia/markup)
[![Build Status](https://img.shields.io/travis/veloxiadev/markup/master.svg?style=flat-square)](https://travis-ci.org/veloxiadev/markup)

Some Schema.org generators made to be used with Laravel.

## Installation

### Install via Composer

```bash
composer require veloxia/markup
```

### Laravel < 5.4

Add to  *config/app.php*

``` php
'providers' => [
    ...
    Veloxia\Markup\MarkupServiceProvider::class,
    ...
];

'aliases' => [
    ...
    'Markup' => Veloxia\Markup\Facades\Markup::class,
    ...
];

```

### Newer versions of Laravel

The Service Provider should be available automatically when the installation is complete. Otherwise try the procedure above.

## Usage

``` php

// https://schema.org/FAQPage

// either ...
$markup = \Veloxia\Markup\Markup::make('FAQ');

// ... or ...
$markup = Markup::make('FAQ');

// ... then add some data ...
$markup
    ->question("Sunt in culpa qui officia deserunt?")
    ->answer("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.");

$markup
    ->question("Casus mixtus cum culpa?")
    ->answer("Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");

// ... and print the results
echo $markup->json();

// with blade you'll need to allow html
// {!! $markup->json() !!}

```

This will output something like:

``` html
<script type="application/ld+json">
{
    "@context": "https:\/\/schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "Sunt in culpa qui officia deserunt?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
            }
        },
        {
            "@type": "Question",
            "name": "Casus mixtus cum culpa?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
            }
        }
    ]
}
</script>
```

It's also possible to bulk-insert:

``` php
// Just one Q/A pair at a time ...
$markup->question("Question here", "Answer here")->json();

// ... or a bigger array
$faq = (new \Veloxia\Markup\Generators\FAQ([
    "Question 1" => "Answer A",
    "Question 2" => "Answer B",
]))->json();

```

### Testing

``` bash
composer test
```

## Contributing

Feel free to make changes :)

## Credits

- [Viktor Svensson](https://github.com/viktorsvensson)
- [Veloxia](https://github.com/veloxiadev)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
