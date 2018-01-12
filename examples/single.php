<?php

/**
 * Generic Example File, Duh
 *
 * @package MirazMac\YouScrape
 */

require '../vendor/autoload.php';

use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape();

try {
    $single = $youtube->single('V7h01x1oiQs');
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

echo "Title \t : \t " . $single->getTitle() . "<hr>";
echo "ID \t : \t " . $single->getID() . "<hr>";
echo "Thumbnail \t : \t " . $single->getThumbnail() . "<hr>";
echo "Duration \t : \t " . $single->getDuration() . "<hr>";
echo "Description \t : \t " . $single->getDescription() . "<hr>";
echo "Length in seconds \t : \t " . $single->getLength() . "<hr>";
echo "Likes \t : \t " . $single->getLikesCount() . "<hr>";
echo "Dislikes \t : \t " . $single->getDislikesCount() . "<hr>";
echo "Views \t : \t " . $single->getViewsCount() . "<hr>";
echo "Channel Name \t : \t " . $single->getChannelName() . "<hr>";
echo "Channel ID \t : \t " . $single->getChannelID() . "<hr>";
echo "Keywords \t : \t " . join($single->getKeywords(), ', ') . "<hr>";
