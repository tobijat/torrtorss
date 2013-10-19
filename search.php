<?php

class SynoDLMSearchTorrentTo {
	private $qurl = 'http://192.168.178.22/torrtorss/torrentto.php?search=';

	public function __construct() {
	}

	public function prepare( $curl, $query ) {
		$url = $this->qurl . urlencode( $query );
		curl_setopt( $curl, CURLOPT_URL, $url );
	}

	public function parse( $plugin, $response ) {
		return $plugin->addJsonResults(
			$response,
			'list',
			array(
				'title' => 'title',
				'download' => 'download',
				'hash' => 'hash',
				'size' => 'size',
				'page' => 'link',
				'date' => 'datetime',
				'seeds' => 'seeds',
				'leechs' => 'leechs',
				'category' => 'category'
			)
		);
	}
}
