<?php

namespace MirazMac\YouScrape;

use MirazMac\YouScrape\Formatter\ChannelFormatter;
use MirazMac\YouScrape\Formatter\PlaylistFormatter;
use MirazMac\YouScrape\Formatter\SingleFormatter;
use MirazMac\YouScrape\Formatter\VideoFormatter;
use \Exception;
use \InvalidArgumentException;

/**
* YouScrape
*
* Scrapes YouTube Public Data without any HTML parsing
*
* @author MirazMac <mirazmac@gmail.com>
* @version 0.1 Initial
* @license LICENSE The MIT License
* @link https://mirazmac.info/ Author Homepage
*/
class YouScrape
{

   /**
    * Create a new instance
    *
    * Serves no purpose what so ever, its here to make the IDE happy
    */
    public function __construct()
    {
    }

    /**
     * Perform a search on YouTube's AJAX Endpoint
     *
     * @param  array  $params Array of Search parameters
     * @throws InvalidArgumentException When parameter "q" is not present
     * @return array
     */
    public function search(array $params)
    {
        if (!isset($params['q'])) {
            throw new InvalidArgumentException("Parameter q is required for search request!");
        }

        // Default parameters its better to not tweak
        $defaults = [
            'layout' => 'mobile',
            'search_type' => 'search_all',
            'lact' => 5,
            'ajax' => 1,
            'sm' => 1,
            'tsp' => 1,
            'cutoffset' => 360
        ];

        // Make sure to URLEncode the query parameter
        $params['q'] = rawurlencode($params['q']);
        // Now merge all together
        $params = array_merge($defaults, $params);
        $query = http_build_query($params);

        // Http Session
        $http = Http::getSession();
        $request = $http->get("https://m.youtube.com/results?{$query}");
        $body = ltrim($request->body, ")]}'");
        $json = json_decode($body, true);

        if (!is_array($json)) {
            return [];
        }

        return $json;
    }

    /**
     * Search YouTube for Videos
     *
     * @param  string $query     The search query
     * @param  string $pageToken Page token for splitting ( optional )
     * @param  string $sort      Sorting method ( optional )
     *                           d - videos that are uploaded today
     *                           w - videos that are uploaded this week
     *                           m - videos that are uploaded this month
     * @return object            Instance of ElementBag
     */
    public function videos($query, $pageToken = null, $sort = null)
    {
        $params = [
            'q' => $query
        ];
        // Adjust page token
        if (!empty($pageToken)) {
            $params['ctoken'] = $pageToken;
        }

        // Adjust sorting
        if (!empty($sort)) {
            $params['uploaded'] = $sort;
        }
        $formatter = new VideoFormatter($this->search($params));

        return $formatter->process();
    }

    /**
     * Search YouTube for Channels
     *
     * @param  string $query     The search query
     * @param  string $pageToken Page token for splitting ( optional )
     * @param  string $sort      Sorting method ( optional )
     *                           d - videos that are uploaded today
     *                           w - videos that are uploaded this week
     *                           m - videos that are uploaded this month
     * @return object            Instance of ElementBag
     */
    public function channels($query, $pageToken = null, $sort = null)
    {
        $params = [
            'q' => $query,
            'search_type' => 'search_users'
        ];
        // Adjust page token
        if (!empty($pageToken)) {
            $params['ctoken'] = $pageToken;
        }

        // Adjust sorting
        if (!empty($sort)) {
            $params['uploaded'] = $sort;
        }

        $formatter = new ChannelFormatter($this->search($params));

        return $formatter->process();
    }

    /**
     * Search YouTube for playLists
     *
     * @param  string $query     The search query
     * @param  string $pageToken Page token for splitting ( optional )
     * @param  string $sort      Sorting method ( optional )
     *                           d - videos that are uploaded today
     *                           w - videos that are uploaded this week
     *                           m - videos that are uploaded this month
     * @return object            Instance of ElementBag
     */
    public function playlists($query, $pageToken = null, $sort = null)
    {
        $params = [
            'q' => $query,
            'search_type' => 'search_playlists'
        ];
        // Adjust page token
        if (!empty($pageToken)) {
            $params['ctoken'] = $pageToken;
        }

        // Adjust sorting
        if (!empty($sort)) {
            $params['uploaded'] = $sort;
        }

        $formatter = new PlaylistFormatter($this->search($params));

        return $formatter->process();
    }

    /**
     * Retrieve information about a single video
     *
     * @param  string $videoID The YouTube Video ID
     * @return object          Instance of SingleElement
     */
    public function single($videoID)
    {
        $url = "https://m.youtube.com/watch?ajax=1&lact=1&layout=mobile&t=5s&tsp=1&utcoffset=360&v={$videoID}";
        $http = Http::getSession();
        $request = $http->get($url);
        $body = ltrim($request->body, ")]}'");
        //$body = ltrim(file_get_contents('body.json'), ")]}'");
        $jsonData = json_decode($body, true);
        $formatter = new SingleFormatter($jsonData);
        return $formatter->process();
    }
}
