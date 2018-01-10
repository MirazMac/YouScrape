<?php

namespace MirazMac\YouScrape\Formatter;

use MirazMac\YouScrape\Element\ElementBag;
use MirazMac\YouScrape\Element\SingleElement;
use MirazMac\YouScrape\Element\VideoElement;
use MirazMac\YouScrape\Interfaces\FormatterInterface;
use MirazMac\YouScrape\Utilities;

/**
* Single Video Formatter
*
* @package MirazMac\YouScrape
*/
class SingleFormatter implements FormatterInterface
{
    protected $pageData;

    public function __construct(array $pageData)
    {
        $this->pageData = $pageData;
    }

    public function process()
    {
        if (empty($this->pageData['content']['video']['encrypted_id'])) {
            return false;
        }
        $singleData = $this->getDefaultDataFormat();
        $swfConfig = $this->pageData['content']['swfcfg'];

        // Process Meta Data
        $this->processVideoMeta($singleData);
        $this->processRelatedVideos($singleData);

        return new SingleElement($singleData);
    }

    protected function processVideoMeta(array &$singleData)
    {
        if (empty($this->pageData['content']['video_main_content']['contents'][0])) {
            return;
        }

        $videoMain = $this->pageData['content']['video_main_content']['contents'][0];
        // We already checked this one
        $basicMeta = $this->pageData['content']['video'];

        // We already checked this one
        $singleData['id'] = $basicMeta['encrypted_id'];

        if (isset($basicMeta['title'])) {
            $singleData['title'] = $basicMeta['title'];
        }

        if (isset($basicMeta['duration'])) {
            $singleData['duration'] = $basicMeta['duration'];
        }

        if (isset($basicMeta['length_seconds'])) {
            $singleData['length'] = $basicMeta['length_seconds'];
        }

        if (isset($videoMain['view_count_text']['runs'][0]['text'])) {
            $singleData['views'] = Utilities::numbersOnly($videoMain['view_count_text']['runs'][0]['text']);
        }
        if (isset($videoMain['description']['runs'])) {
            $singleData['desc'] = $this->processDescription($videoMain['description']['runs']);
        }

        if (isset($videoMain['like_button']['dislike_count'])) {
            $singleData['dislikes'] = $videoMain['like_button']['dislike_count'];
        }

        if (isset($videoMain['like_button']['like_count'])) {
            $singleData['likes'] = $videoMain['like_button']['like_count'];
        }

        if (isset($videoMain['date_text']['runs'][0]['text'])) {
            $date = $videoMain['date_text']['runs'][0]['text'];
            $date = str_replace('Published on ', '', $date);
            $singleData['published'] = strtotime($date);
        }

        if (isset($videoMain['short_byline_text']['runs'][0]['text'])) {
            $singleData['channelName'] = $videoMain['short_byline_text']['runs'][0]['text'];
        }

        if (isset($videoMain['subscribe_button']['channel_id'])) {
            $singleData['channelId'] = $videoMain['subscribe_button']['channel_id'];
        }

        if (isset($this->pageData['content']['swfcfg']['args']['keywords'])) {
            $singleData['keywords'] = $this->processKeywords($this->pageData['content']['swfcfg']['args']['keywords']);
        }
    }


    protected function processKeywords($keywords)
    {
        if (!is_string($keywords)) {
            return [];
        }

        return explode(',', $keywords);
    }

    protected function processRelatedVideos(array &$singleData)
    {
        if (empty($this->pageData['content']['related_videos'])) {
            return;
        }

        $relatedVideos = $this->pageData['content']['related_videos'];

        foreach ($relatedVideos as $video) {
            $videoData = VideoFormatter::getDefaultDataFormat();

            if (empty($video['encrypted_id'])) {
                continue;
            }

            $videoData['id'] = $video['encrypted_id'];

            if (isset($video['view_count_text'])) {
                $videoData['views'] = Utilities::numbersOnly($video['view_count_text']);
            }

            if (isset($video['title'])) {
                $videoData['title'] = $video['title'];
            }

            if (isset($video['public_name'])) {
                $videoData['channelName'] = $video['public_name'];
            }

            if (isset($video['duration'])) {
                $videoData['duration'] = $video['duration'];
            }

            $singleData['relatedVideos'][] = new VideoElement($videoData);
        }
    }

    protected function processDescription(array $descArray)
    {
        $finalDesc = '';

        foreach ($descArray as $desc) {
            // If its an URL then may be we need to assign it manually
            if (isset($desc['endpoint']['url'])) {
                $finalDesc .= $desc['endpoint']['url'];
                continue;
            }
            $finalDesc .= $desc['text'];
        }

        return $finalDesc;
    }

    public static function getDefaultDataFormat()
    {
        return [
            'id' => null,
            'title' => null,
            'desc' => null,
            'duration' => null,
            'length' => null,
            'published' => null,
            'channelName' => null,
            'channelId' => null,
            'views' => 0,
            'dislikes' => 0,
            'likes' => 0,
            'keywords' => [],
            'relatedVideos' => []
        ];
    }
}
