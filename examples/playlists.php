<?php

/**
 * Generic Example File, Duh
 *
 * @package MirazMac\YouScrape
 */

require '../vendor/autoload.php';

use MirazMac\YouScrape\YouScrape;

$token = isset($_GET['token']) ? $_GET['token'] : null;
$youtube = new YouScrape;
try {
    $playlists = $youtube->playlists('Entertainment', $token);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

if ($prev = $playlists->getPrevPageToken()) {
    echo('<a href="?token='.$prev.'">Prev</a>');
}

if ($next = $playlists->getNextPageToken()) {
    echo('<hr/><a href="?token='.$next.'">Next</a>');
}
echo("<hr>");

foreach ($playlists->getAll() as $playlist) {
    echo "Title\t:\t" . $playlist->getTitle() . "<br>";
    echo "ID\t:\t" . $playlist->getID() . "<br>";
    echo "Thumbnail\t:\t" . $playlist->getThumbnail() . "<br>";
    echo "Videos\t:\t" . $playlist->getVideosCount() . "<br>";
    echo "Creator\t:\t" . $playlist->getAuthorName() . "<br>";
    echo "<hr>";
}
