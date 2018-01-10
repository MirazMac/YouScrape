<?php

namespace MirazMac\YouScrape\Formatter;

use MirazMac\YouScrape\Element\ElementBag;
use MirazMac\YouScrape\Element\PlaylistElement;
use MirazMac\YouScrape\Interfaces\FormatterInterface;
use MirazMac\YouScrape\Utilities;
use \LogicException;

/**
*
*/
class PlaylistFormatter implements FormatterInterface
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

        foreach ($results as $result) {
            // Playlists only
            if (empty($result['item_type']) || $result['item_type'] !== 'compact_playlist') {
                continue;
            }
            $playlistEl = $this->getDefaultDataFormat();
            $this->processPlaylist($playlistEl, $result);

            $parsedResult[] = new PlaylistElement($playlistEl);
        }

        $continuation = new ContinuationFormatter($this->searchData);
        $tokens = $continuation->process();

        return new ElementBag($parsedResult, $tokens['next'], $tokens['prev']);
    }

    protected function processPlaylist(array &$playlistEl, array $playResult)
    {
        if (empty($playResult['playlist_id'])) {
            return;
        }

        $playlistEl['id'] = $playResult['playlist_id'];

        if (isset($playResult['title']['runs'][0]['text'])) {
            $playlistEl['authorName'] = $playResult['owner']['runs'][0]['text'];
        }

        if (isset($playResult['title']['runs'][0]['text'])) {
            $playlistEl['title'] = $playResult['title']['runs'][0]['text'];
        }

        if (isset($playResult['owner']['runs'][0]['text'])) {
            $playlistEl['authorName'] = $playResult['owner']['runs'][0]['text'];
        }

        if (isset($playResult['video_count_short']['runs'][0]['text'])) {
            $playlistEl['videos'] = $playResult['video_count_short']['runs'][0]['text'];
        }

        if (isset($playResult['thumbnail_info']['url'])) {
            $playlistEl['thumbnail'] = $playResult['thumbnail_info']['url'];
        }

        if (isset($playResult['video_count_short']['runs'][0]['text'])) {
            $playlistEl['videos'] = Utilities::numbersOnly($playResult['video_count_short']['runs'][0]['text']);
        }
    }


    public static function getDefaultDataFormat()
    {
        return [
            'id' => null,
            'title' => null,
            'thumbnail' => null,
            'videos' => 0,
            'authorName' => null
        ];
    }
}
