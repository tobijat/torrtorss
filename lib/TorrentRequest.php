<?php

class TorrentRequest {
	private $url;
	private $parameters;
	private $method;

	public function __construct( $url, $parameters, $method = "POST") {
		$this->url = $url;
		$this->parameters = $parameters;
		$this->method = $method;
	}

	public function execute() {
		$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => $this->method,
        		'content' => http_build_query($this->parameters),
    		),
		);
		$context  = stream_context_create($options);
		return file_get_contents($this->url, false, $context);
	}
}