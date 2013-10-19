<?php
require_once 'TorrentRequest.php';

const REQUEST_URL = 'http://torrent.to/res/php/Ajax.php';
const TORRENT_URL = 'http://torrent.to/res/php/Downloader.php';

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
processResult( $request->execute() );

function processResult( $result ) {
	$resultObj = json_decode($result, true);
	$entries = $resultObj['Results']['2']['Entrys'];

	$processedEntries = array();

	foreach ( $entries as $entry ) {
		$entry['Torrent'] = TORRENT_URL . "?ID={$entry['ID']}&Filename={$entry['Title']}";
		$processedEntries[] = $entry;
	}

	print_r($processedEntries);
}

