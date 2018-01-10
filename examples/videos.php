<?php

/**
 * Generic Example File, Duh
 *
 * @package MirazMac\YouScrape
 */

require '../vendor/autoload.php';

use MirazMac\YouScrape\YouScrape;

$youtube = new YouScrape();
$token = isset($_GET['token']) ? $_GET['token'] : null;
$q = 'Honest Trailers';

try {
    $videos = $youtube->videos($q, $token);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

if ($prev = $videos->getPrevPageToken()) {
    echo('<a href="?token='.$prev.'">Prev</a>');
}

if ($next = $videos->getNextPageToken()) {
    echo('<hr/><a href="?token='.$next.'">Next</a>');
}

echo("<hr>");
foreach ($videos->getAll() as $video) {
    echo "Title\t:\t" . $video->getTitle() . "<br>";
    echo "ID\t:\t" . $video->getID() . "<br>";
    echo "Image\t:\t" . $video->getThumbnail() . "<br>";
    echo "Views\t:\t" . $video->getViewsCount() . "<br>";
    echo "Channel\t:\t" . $video->getChannelName() . "<br>";
    echo "Duration\t:\t" . $video->getDuration() . "<br>";
    echo("<hr>");
}
