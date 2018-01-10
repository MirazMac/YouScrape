<?php

/**
 * Generic Example File, Duh
 *
 * @package MirazMac\YouScrape
 */

require '../vendor/autoload.php';

use MirazMac\YouScrape\Settings;
use MirazMac\YouScrape\YouScrape;

$token = isset($_GET['token']) ? $_GET['token'] : null;
$youtube = new YouScrape();

try {
    $channels = $youtube->channels('Entertainment', $token);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}


if ($prev = $channels->getPrevPageToken()) {
    echo('<a href="?token='.$prev.'">Prev</a>');
}

if ($next = $channels->getNextPageToken()) {
    echo('<hr/><a href="?token='.$next.'">Next</a>');
}
echo("<hr>");

foreach ($channels->getAll() as $channel) {
    echo "Title\t:\t" . $channel->getTitle() . "<br>";
    echo "Username\t:\t" . $channel->getUserName() . "<br>";
    echo "ID (Fallback for username)\t:\t" . $channel->getID() . "<br>";
    echo "Thumbnail\t:\t" . $channel->getThumbnail() . "<br>";
    echo "Videos\t:\t" . $channel->getVideosCount() . "<br>";
    echo "Subscribers\t:\t" . $channel->getSubscribersCount() . "<br>";
    echo "<hr>";
}
