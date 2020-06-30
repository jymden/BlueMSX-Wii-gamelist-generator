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
$GAMES_FOLDER = 'C:\MSX\Games\roms';


$doc = new DomDocument();
$doc->preserveWhiteSpace = false;
$doc->formatOutput = true;
$root = $doc->createElement('GameList');
$root = $doc->appendChild($root);

$folderArray = scandir($GAMES_FOLDER, 0);

foreach ($folderArray as $dir) {
    if (!is_dir($dir)) {
        // Create game title from file name (exclude file type)
        $gameTitle = pathinfo($dir, PATHINFO_FILENAME);

        // Create Game node
        $game = $doc->createElement('Game');
        $game->setAttribute('Title', $gameTitle);

        // Create command node, with command for running the rom
        $commandLine = $doc->createElement('CommandLine', '/rom1 "' . htmlspecialchars($dir) . '"');
        $game->appendChild($commandLine);

        $root->appendChild($game);

    }
}

// Make xml string
$xmlString = $doc->saveXML();

// Output xml on screen
Header('Content-type: text/xml');
print($xmlString);

// Output xml to file
$gameListFile = fopen($GAMES_FOLDER . '/gamelist.xml', "w");

fwrite($gameListFile, $xmlString);
fclose($gameListFile);

