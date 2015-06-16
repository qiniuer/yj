<?php

require_once 'yj_common.php';

g_check_uauth();

use Qiniu\Storage\BucketManager;

$bucketMgr = New BucketManager($g_auth);
$bucket = $g_bucket;
$prefix = $g_orig_prefix;

list($items, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix);

/*
if ($err !== null) {
    var_dump($err);
} else {
    var_dump($items);
}
*/



/*
 * start gen xml
 */


$xml_header = '<?xml version="1.0" encoding="UTF-8"?>';

$xml  = '';
$xml .= $xml_header;
$xml .= '<root>';


$str = '';
$key = '';

for ($i = 0; $i < count($items); $i++) {
    $key = $items[$i]['key'];

    $str .= '<media>';
    $str .= '<content><![CDATA[' .$key. ']]></content>';

    $player = 'http://' . $g_host. '/player/html/osmf/?src=';
    $url = $player . $g_bucket_site . $key;

    $str .= '<url><![CDATA[' .$url. ']]></url>';

    $str .= '</media>';
}

$xml .= $str;
$xml .= '</root>';

echo $xml;



?>
