<?php

namespace MirazMac\YouScrape\Formatter;

use MirazMac\YouScrape\Element\ChannelElement;
use MirazMac\YouScrape\Element\ElementBag;
use MirazMac\YouScrape\Interfaces\FormatterInterface;
use MirazMac\YouScrape\Utilities;
use \LogicException;

/**
* Channel List Formatter
*
* @package MirazMac\YouScrape
*/
class ChannelFormatter implements FormatterInterface
{
    /**
     * The raw array from search response
     *
     * @var array
     */
    protected $searchData;

    /**
     * Create a ChannelFormatter instance
     *
     * @param array $searchData The raw array from search response
     */
    public function __construct(array $searchData)
    {
        $this->searchData = $searchData;
    }

    /**
     * Process the response
     *
     * @throws \LogicException If the contents not found in response data
     * @return ElementBag
     */
    public function process()
    {
        $parsedResult = [];

        // No point on proceeding
        if (!empty($this->searchData['content']['search_results']['contents'])) {
            $results = $this->searchData['content']['search_results']['contents'];
        } elseif (!empty($this->searchData['content']['continuation_contents']['contents'])) {
            $results = $this->searchData['content']['continuation_contents']['contents'];
        } else {
            throw new LogicException("Failed to find contents from the response.");
        }

        // Sorry videos only!
        foreach ($results as $result) {
            // Videos only
            if (empty($result['item_type']) || $result['item_type'] !== 'compact_channel') {
                continue;
            }
            $chEl = $this->getDefaultDataFormat();
            $this->processChannel($chEl, $result);

            $parsedResult[] = new ChannelElement($chEl);
        }

        $continuation = new ContinuationFormatter($this->searchData);
        $tokens = $continuation->process();

        return new ElementBag($parsedResult, $tokens['next'], $tokens['prev']);
    }

    protected function processChannel(array &$chEl, array $chResult)
    {
        if (empty($chResult['endpoint']['url'])) {
            return;
        }

        $url = $chResult['endpoint']['url'];

        // If it is a normal url so we can get the id by stripping of the url
        if (strstr($url, '/channel/') !== false) {
            $chEl['id'] = str_replace('/channel/', '', $url);
        } else {
            // Now this must be a custom URL!
            $chEl['username'] = str_replace('/user/', '', $url);
        }

        // Update channel title/name
        if (isset($chResult['title']['runs'][0]['text'])) {
            $chEl['title'] = $chResult['title']['runs'][0]['text'];
        }

        // Update thumbnail URL
        if (isset($chResult['thumbnail_info']['url'])) {
            $chEl['thumbnail'] = $chResult['thumbnail_info']['url'];
        }

        // Videos count
        if (isset($chResult['video_count']['runs'][0]['text'])) {
            $chEl['videos'] = Utilities::numbersOnly($chResult['video_count']['runs'][0]['text']);
        }

        // Subscribers count
        if (isset($chResult['subscriber_count']['runs'][0]['text'])) {
            $chEl['subscribers'] = Utilities::numbersOnly($chResult['subscriber_count']['runs'][0]['text']);
        }
    }

    public static function getDefaultDataFormat()
    {
        return [
            'id' => null,
            'username' => null,
            'title' => null,
            'thumbnail' => null,
            'videos' => 0,
            'subscribers' => 0
        ];
    }
}
