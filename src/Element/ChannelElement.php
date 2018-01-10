<?php

namespace MirazMac\YouScrape\Element;

/**
* Channel Element Object
*
* @package MirazMac\YouScrape
*/
class ChannelElement
{
    /**
     * The Element Type
     */
    const ELEMENT_TYPE = 'compact_channel';

    /**
     * Formatted data
     *
     * @var array
     */
    protected $formattedData;

    /**
     * Create a new ChannelElement
     *
     * @param array $formattedData The formatted channel data from ChannelFormatter
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
     * Retrieve the channel ID
     *
     * @return string|null
     */
    public function getID()
    {
        return $this->formattedData['id'];
    }

    /**
     * Retrieve the channel username
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->formattedData['username'];
    }

    /**
     * Retrieve the channel title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->formattedData['title'];
    }

    /**
     * Retrieve the channel thumbnail URL
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->formattedData['thumbnail'];
    }

    /**
     * Retrieve the channel's videos count
     *
     * @return string
     */
    public function getVideosCount()
    {
        return $this->formattedData['videos'];
    }

    /**
     * Retrieve the channel's subscribers count
     *
     * @return string
     */
    public function getSubscribersCount()
    {
        return $this->formattedData['subscribers'];
    }
}
