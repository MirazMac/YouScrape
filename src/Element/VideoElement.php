<?php

namespace MirazMac\YouScrape\Element;

/**
* Video Element Object
*
* @package MirazMac\YouScrape
*/
class VideoElement
{
    /**
     * Element type
     *
     * @var string
     */
    const ELEMENT_TYPE = 'compact_video';

    /**
     * Formatted data
     *
     * @var array
     */
    protected $videoData;

    /**
     * Create a new VideoElement
     *
     * @param array $formattedData Formatted data from VideoFormatter
     */
    public function __construct(array $formattedVideoData)
    {
        $this->videoData = $formattedVideoData;
    }

    /**
     * Retrieve the element type
     *
     * @return string
     */
    public function getElementType()
    {
        return static::ELEMENT_TYPE;
    }

    /**
     * Retrieve the video ID
     *
     * @return string|null
     */
    public function getID()
    {
        return $this->videoData['id'];
    }

    /**
     * Retrieve the video title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->videoData['title'];
    }

    /**
     * Retrieve the video thumbnail URI
     *
     * @param  string $size Thumbnail size string ( mqdefault, hqdefault, maxresdefault )
     * @return string
     */
    public function getThumbnail($size = 'mqdefault')
    {
        $size = filter_var($size, FILTER_SANITIZE_STRING);
        $id = $this->getID();
        return "https://i.ytimg.com/vi/{$id}/{$size}.jpg";
    }

    /**
     * Retrieve the video's view count
     *
     * @return integer|null
     */
    public function getViewsCount()
    {
        return $this->videoData['views'];
    }

    /**
     * Retrieve the video's channel name
     *
     * @return string|null
     */
    public function getChannelName()
    {
        return $this->videoData['channelName'];
    }

    /**
     * Retrieve the video duration in seconds
     *
     * @return int|null
     */
    public function getDuration()
    {
        return $this->videoData['duration'];
    }
}
