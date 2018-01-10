<?php

namespace MirazMac\YouScrape\Formatter;

use MirazMac\YouScrape\Element\ElementBag;
use MirazMac\YouScrape\Element\VideoElement;
use MirazMac\YouScrape\Interfaces\FormatterInterface;
use MirazMac\YouScrape\Utilities;
use \LogicException;

/**
*
*/
class VideoFormatter implements FormatterInterface
{
    protected $searchData;

    public function __construct(array $searchData)
    {
        $this->searchData = $searchData;
    }

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
            if (empty($result['item_type']) || $result['item_type'] !== 'compact_video') {
                continue;
            }
            $videoEl = $this->getDefaultDataFormat();
            $this->processVideo($videoEl, $result);
            $parsedResult[] = new VideoElement($videoEl);
        }

        $continuation = new ContinuationFormatter($this->searchData);
        $tokens = $continuation->process();

        return new ElementBag($parsedResult, $tokens['next'], $tokens['prev']);
    }

    protected function processVideo(array &$videoEl, array $videoResult)
    {
        if (empty($videoResult['encrypted_id'])) {
            return;
        }

        $videoEl['id'] = $videoResult['encrypted_id'];

        if (isset($videoResult['title']['runs'][0]['text'])) {
            $videoEl['title'] = $videoResult['title']['runs'][0]['text'];
        }

        if (isset($videoResult['short_byline']['runs'][0]['text'])) {
            $videoEl['channelName'] = $videoResult['short_byline']['runs'][0]['text'];
        }

        if (isset($videoResult['view_count']['runs'][0]['text'])) {
            $videoEl['views'] = Utilities::numbersOnly($videoResult['view_count']['runs'][0]['text']);
        }

        if (isset($videoResult['length']['runs'][0]['text'])) {
            $videoEl['duration'] = $videoResult['length']['runs'][0]['text'];
        }
    }

    public static function getDefaultDataFormat()
    {
        return [
            'id' => null,
            'title' => null,
            'duration' => null,
            'channelName' => null,
            'views' => 0
        ];
    }
}
