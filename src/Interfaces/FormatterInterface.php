<?php

namespace MirazMac\YouScrape\Interfaces;

interface FormatterInterface
{
    public function process();
    public static function getDefaultDataFormat();
}
