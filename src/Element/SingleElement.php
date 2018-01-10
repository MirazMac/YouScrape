<?php

namespace MirazMac\YouScrape\Element;

/**
* Single Video Element Object
*
* @package MirazMac\YouScrape
*/
class SingleElement
{
    /**
     * Element type
     *
     * @var string
     */
    const ELEMENT_TYPE = 'single_video';

    /**
     * Formatted data
     *
     * @var array
     */
    protected $formattedData;

    /**
     * Create a new SingleElement
     *
     * @param array $formattedData Formatted data from SingleFormatter
     */
    public function __construct(array $formattedData)
    {
        $this->formattedData = $formattedData;
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
        return $this->formattedData['id'];
    }

    /**
     * Retrieve the video title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->formattedData['title'];
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

    public function getDuration()
    {
        return $this->formattedData['duration'];
    }

    public function getLength()
    {
        return $this->formattedData['length'];
    }

    public function getDescription()
    {
        return $this->formattedData['desc'];
    }

    /**
     * Retrieve the video's views count
     *
     * @return integer|null
     */
    public function getViewsCount()
    {
        return $this->formattedData['views'];
    }

    /**
     * Retrieve the video's likes count
     *
     * @return integer|null
     */
    public function getLikesCount()
    {
        return $this->formattedData['likes'];
    }

    /**
     * Retrieve the video's dislikes count
     *
     * @return integer|null
     */
    public function getDislikesCount()
    {
        return $this->formattedData['dislikes'];
    }

    /**
     * Retrieve the video's channel name
     *
     * @return string|null
     */
    public function getChannelName()
    {
        return $this->formattedData['channelName'];
    }

    /**
     * Retrieve the video's channel ID
     *
     * @return string|null
     */
    public function getChannelId()
    {
        return $this->formattedData['channelId'];
    }

    /**
     * Retrieve the video's keywords
     *
     * @return array|null
     */
    public function getKeywords()
    {
        return $this->formattedData['keywords'];
    }
}
