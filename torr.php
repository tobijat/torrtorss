<?php
$url = 'http://torrent.to/res/php/Ajax.php';
$data = array('Request' => 'GetList', 'Offset' => '0', 'FormName' => 'QuickSearchForm', 'IncludeFilter' => 'Yes', 'Filter_Section' => '', 'Filter_StrType' => '', 'Filter_Str' => 'mentalist');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

$resultObj = json_decode($result);
$entries = $resultObj->{'Results'}->{'2'}->{'Entrys'};
print_r($entries);
