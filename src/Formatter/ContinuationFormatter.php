<?php

namespace MirazMac\YouScrape\Formatter;

use MirazMac\YouScrape\Interfaces\FormatterInterface;

/**
* Formatter for Continuation Data
*
* @package MirazMac\YouScrape
*/
class ContinuationFormatter implements FormatterInterface
{
    protected $videoData;

    public function __construct(array $videoData)
    {
        $this->videoData = $videoData;
    }

    public function process()
    {
        $tokens = $this->getDefaultDataFormat();
        $tokens['prev'] = $this->extractPrevToken();
        $tokens['next'] = $this->extractNextToken();
        return $tokens;
    }

    protected function extractNextToken()
    {
        // If this one is set we are on the first page
        if (!empty($this->videoData['content']['search_results']['continuations'][0]['continuation'])) {
            return $this->videoData['content']['search_results']['continuations'][0]['continuation'];
        }

        // Try first token for next token
        if (isset($this->videoData['content']['continuation_contents']['continuations'][0]['continuation'])) {
            $tokenEl = $this->videoData['content']['continuation_contents']['continuations'][0];
            if ($tokenEl['item_type'] === 'next_continuation_data') {
                return $this->videoData['content']['continuation_contents']['continuations'][0]['continuation'];
            }
        }

        // Didn't work huh? Lets try in the second way
        if (isset($this->videoData['content']['continuation_contents']['continuations'][1]['continuation'])) {
            $tokenEl = $this->videoData['content']['continuation_contents']['continuations'][1];
            if ($tokenEl['item_type'] === 'next_continuation_data') {
                return $this->videoData['content']['continuation_contents']['continuations'][1]['continuation'];
            }
        }
        // Sorry, no luck
        return false;
    }

    protected function extractPrevToken()
    {
        // Since a prev page token won't be in the first page, we would actually skip the first one
        if (isset($this->videoData['content']['continuation_contents']['continuations'][0]['continuation'])) {
            $tokenEl = $this->videoData['content']['continuation_contents']['continuations'][0];
            if ($tokenEl['item_type'] === 'previous_continuation_data') {
                return $this->videoData['content']['continuation_contents']['continuations'][0]['continuation'];
            }
        }

        // Never actually found here a prev token as far as I did research
        // But it's good to have fallback
        if (isset($this->videoData['content']['continuation_contents']['continuations'][1]['continuation'])) {
            $tokenEl = $this->videoData['content']['continuation_contents']['continuations'][1];
            if ($tokenEl['item_type'] === 'previous_continuation_data') {
                return $this->videoData['content']['continuation_contents']['continuations'][1]['continuation'];
            }
        }

        return false;
    }

    public static function getDefaultDataFormat()
    {
        return [
            'next' => null,
            'prev' => null
        ];
    }
}
