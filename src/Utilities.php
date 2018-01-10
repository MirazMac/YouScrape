<?php

namespace MirazMac\YouScrape;

/**
*
*/
class Utilities
{
    public static function numbersOnly($string)
    {
        return (int)preg_replace('/[^0-9]/i', '', $string);
    }
}
