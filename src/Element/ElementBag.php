<?php

namespace MirazMac\YouScrape\Element;

/**
* ElementBag Object
*
* @package MirazMac\YouScrape
*/
class ElementBag
{
    /**
     * Elements
     *
     * @var array
     */
    protected $bag = [];

    /**
     * Next page token
     *
     * @var string
     */
    protected $nextPageToken;

    /**
     * Previous page token
     *
     * @var string
     */
    protected $prevPageToken;

    /**
     * Create a new ElementBag
     *
     * @param array  $formattedVideoData Formatted video data from FormatterInterface
     * @param string $nextPageToken      Next page token
     * @param string $prevPageToken      Previous page token
     */
    public function __construct(array $formattedVideoData, $nextPageToken = null, $prevPageToken = null)
    {
        $this->bag = $formattedVideoData;
        $this->nextPageToken = $nextPageToken;
        $this->prevPageToken = $prevPageToken;
    }

    /**
     * Retrieve the element bag
     *
     * @return array
     */
    public function getAll()
    {
        return $this->bag;
    }

    /**
     * Retrieve previous page token
     *
     * @return string|null
     */
    public function getPrevPageToken()
    {
        return $this->prevPageToken;
    }

    /**
     * Retrieve next page token
     *
     * @return string|null
     */
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }
}
