<?php

namespace MirazMac\YouScrape;

use \Requests_Session;
use \Requests_Cookie_Jar;

/**
* Wrapper for PHP Requests
*
* Provides us a quick HTTP session to perform requests more of like a web browser.
*/
class Http
{
    /**
     * Session Instance
     *
     * @var Requests_Session
     */
    protected static $session;

    /**
     * Get the HTTP Session instance
     *
     * @return Requests_Session
     */
    public static function getSession()
    {
        if (!self::$session) {
            // Build a new session
            self::$session = new Requests_Session();
            // Rich scrapper!
            self::$session->useragent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1';
            self::$session->headers['Accept'] = 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
            self::$session->headers['Accept-Language'] = 'en-US,en;q=0.5';
            // I'm an ajax request, Really!!
            self::$session->headers['X-Requested-With'] = 'XMLHttpRequest';
            // Obvious
            self::$session->headers['Referer'] = "https://m.youtube.com";
            // Not works, still will try
            if (isset($_SERVER['REMOTE_ADDR'])) {
                self::$session->headers['X-Forwarded-For'] = $_SERVER['REMOTE_ADDR'];
            }
            // Enough?
            self::$session->options['timeout'] = 80;
            self::$session->options['connect_timeout'] = 80;
            // This will make us look like more of an asshole to YouTube :|
            self::$session->options['cookies'] = new Requests_Cookie_Jar();
        }
        return self::$session;
    }
}
