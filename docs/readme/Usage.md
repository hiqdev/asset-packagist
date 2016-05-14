List required packages like the following:

```php
"require": {
    "bower-asset/bootstrap": "^3.3",
    "npm-asset/jquery": "^2.2"
}
```

And add these lines:</p>

```php
"repositories": [
    {
        "type": "composer",
        "url": "https://asset-packagist.org"
    }
]
```
