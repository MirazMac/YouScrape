# YouScrape
YouTube Public Data Scrapper

**YouScrape** is an unofficial replacement of YouTube Data API v3 for retrieving YouTube public data. Currently it can scrape channels, videos, playlists and single video information.

### Install via Composer

```shell
composer require mirazmac/youscrape
```

### Manual Install

Download the latest release from [Releases](https://github.com/mirazmac/YouScrape/releases). Extract and require **src/autoload.php** in your code. But it's highly recommended to use [Composer](http://getcomposer.org).

```php
require 'src/autoload.php';
```


## Usage
Check **examples** folder for complete usage examples.


### Searching Videos
```php
use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape;

try {
    $videos = $youtube->videos('Honest Trailer');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

print_r($videos->getAll());

```

### Fetching Information of a Single Video
```php
use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape;

try {
    $single = $youtube->single('V7h01x1oiQs');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

print_r($single->getAll());

```

### Searching Channels
```php
use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape;

try {
    $channels = $youtube->channels('Entertainment');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

print_r($channels->getAll());

```
### Searching Playlists

```php
use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape;

try {
    $playlists = $youtube->playlists('Entertainment');
} catch (\Exception $e) {
    echo $e->getMessage();
    exit;
}

print_r($playlists->getAll());

```
