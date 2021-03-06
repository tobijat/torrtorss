<?php
require_once 'lib/TorrentRequest.php';

const REQUEST_URL = 'http://torrent.to/res/php/Ajax.php';
const TORRENT_URL = 'http://torrent.to/res/php/Downloader.php?ID=';
const DETAILS_URL = 'http://torrent.to/torrent.php?Mod=Details&ID=';

$searchTerm = isset( $_GET['search'] ) ? $_GET['search'] : '';

$parameters = array(
	'Request' => 'GetList',
	'Offset' => '0',
	'FormName' => 'QuickSearchForm',
	'IncludeFilter' => 'Yes',
	'Filter_Section' => '',
	'Filter_StrType' => '',
	'Filter_Str' => $searchTerm,
);

$request = new TorrentRequest( REQUEST_URL, $parameters, 'POST' );
$processedEntries = processResult( $request->execute() );
outputResult( $processedEntries );

function processResult( $result ) {
	$resultObj = json_decode($result, true);
	$entries = $resultObj['Results']['2']['Entrys'];

	$processedEntries = array();

	foreach ( $entries as $entry ) {
		$torrentPage = DETAILS_URL . $entry['ID'];
		$processedEntry = array();
		$processedEntry['title'] = $entry['Title'];
		$processedEntry['download'] = getDownloadLinkFromPage( $torrentPage );#TORRENT_URL . "{$entry['ID']}&Filename={$entry['Title']}";
		$processedEntry['size'] = $entry['HSize'];
		$processedEntry['datetime'] = date( "Y-m-d H:i:s", $entry['TimeStamp'] );
		$processedEntry['page'] = $torrentPage;
		$processedEntry['hash'] = '';
		$processedEntry['seeds'] = $entry['Seeder'];
		$processedEntry['leechs'] = $entry['Leecher'];
		$processedEntry['category'] = '';

		$processedEntries[] = $processedEntry;
	}

	return( $processedEntries );
}

function outputResult( $entries ) {
	header( 'Content-type: application/json' );
	echo json_encode( array( 'list' => $entries ) );
}

function getDownloadLinkFromPage( $page ) {
	$content = file_get_contents( $page );
	$token = './res/php/Downloader.php?ID=';
	$id = substr( $content, strpos( $content, $token ) + strlen( $token ), 7  );
	$link = TORRENT_URL . $id;

	return $link;
}
