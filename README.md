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

### Limitations
* You can't limit or change the amount of results per page
* It depends on YouTube's internal ajax endpoints, as a result it can only show the information the endpoint provides.
* Its illegal and YouTube may block your IP if you send too many requests


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

var_dump($single);

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

## Todos
* Implement tests
* Run a benchmark to see if it gets blocked on too heavy requests
* Better and complete documentation
