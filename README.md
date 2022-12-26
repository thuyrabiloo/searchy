# Searchy

## Installation

You can install the package via composer:

```bash
composer require thuyld_rabiloo/searchy
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="searchy-config"
```

This is the contents of the published config file:

```php
return [
    'default' => 'fuzzy',
    'fieldName' => 'relevance',
    'drivers' => [
        'fuzzy' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\FuzzySearchDriver',
        ],
        'ufuzzy' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\FuzzySearchUnicodeDriver',
        ],
        'simple' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\SimpleSearchDriver',
        ],
        'levenshtein' => [
            'class' => 'Rabiloo\Searchy\SearchDrivers\LevenshteinSearchDriver',
        ],
    ],
];
```

## Usage

```php
use Rabiloo\Searchy\Traits\Searchable;
class SearchableModel extends Model 
{
    use Searchable;
    
    public function searchableColumns() 
    {
        return ['field_1', 'field_2'];
    }
}
```

### Default search
```php
$search = SearchableModel::search('keyword')->get();
```

### Fuzzy search
```php
$search = SearchableModel::fuzzySearch('keyword')->get();
$search = SearchableModel::uFuzzySearch('keyword')->get();
```

### Simple search
```php
$search = SearchableModel::simpleSearch('keyword')->get();
```

### Levenshtein search
```php
$search = SearchableModel::levenshteinSearch('keyword')->get();
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [ThuyLD](https://github.com/thuyld)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
