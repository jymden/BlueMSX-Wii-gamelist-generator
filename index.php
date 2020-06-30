<?php
/*
 * Script to create gamelist.xml file for using with game packs for BlueMAX Wii
 * Edit the constant and run the script. Then copy the created xml
 *
 * It's not very tested and will probably come out messed up if your games folder is not in order
 * But at least some of the lifting is done for you
 *
 */

// YOUR FOLDER OF ROMS
$GAMES_FOLDER = "D:\Emulatorer\MSX\Games\Cartridges";


$doc = new DomDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$root = $doc->createElement('GameList');
$root = $doc->appendChild($root);

//$root = $root->appendChild($root);

foreach (scandir($GAMES_FOLDER, 0) as $dir) {
    if (!is_dir($dir)) {
        $gameTitle = pathinfo($dir, PATHINFO_FILENAME);

        $game = $doc->createElement('Game');
        $game->setAttribute('Title', $gameTitle);

        $commandLine = $doc->createElement('CommandLine', '/rom1 "' . htmlspecialchars($dir) . '"');
        $game->appendChild($commandLine);

        $root->appendChild($game);

    }
}

$xmlString = $doc->saveXML();

Header('Content-type: text/xml');
print($xmlString);

$gameListFile = fopen('gamelist.xml', "w");
fwrite($gameListFile, $xmlString);

