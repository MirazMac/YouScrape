<?php

namespace MirazMac\YouScrape\Element;

/**
* Playlist Video Element Object
*
* @package MirazMac\YouScrape
*/
class PlaylistElement
{
    /**
     * Element type
     *
     * @var string
     */
    const ELEMENT_TYPE = 'compact_playlist';

    /**
     * Formatted data
     *
     * @var array
     */
    protected $formattedData;

    /**
     * Create a new PlaylistElement
     *
     * @param array $formattedData Formatted data from PlaylistFormatter
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
     * Retrieve the playlist ID
     *
     * @return string|null
     */
    public function getID()
    {
        return $this->formattedData['id'];
    }

    /**
     * Retrieve the playlist title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->formattedData['title'];
    }

    /**
     * Retrieve the playlist's videos count
     *
     * @return string
     */
    public function getVideosCount()
    {
        return $this->formattedData['videos'];
    }

    /**
     * Retrieve the playlist thumbnail URL
     *
     * @return string
     */
    public function getThumbnail()
    {
        return $this->formattedData['thumbnail'];
    }

    /**
     * Retrieve playlist creator name
     *
     * @return string|null
     */
    public function getAuthorName()
    {
        return $this->formattedData['authorName'];
    }
}
