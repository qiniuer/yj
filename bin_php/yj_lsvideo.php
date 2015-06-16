<?php

require_once 'yj_common.php';

g_check_uauth();

use Qiniu\Storage\BucketManager;

$bucketMgr = New BucketManager($g_auth);
$bucket = $g_bucket;
$prefix = $g_seg_prefix;

list($items, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix);

/*
 *   start gen xml
 */

$xml_header = '<?xml version="1.0" encoding="UTF-8"?>';

$xml  = '';
$xml .= $xml_header;
$xml .= '<root>';

$str = '';
$key = '';

for ($i = 0; $i < count($items); $i++){
    $key = $items[$i]['key'];
    $content = $key;

    // play addr
    $player = 'http://' . $g_host. '/player/html/osmf/?src=';
    $url = $player . $g_bucket_site . $key;

    // split strings by g_split
    $tmp = explode('/', $key);

    // date
    $tmp2 = explode('_', $tmp[4]);
    $time = substr($tmp2[0], 0, 4) . '-' . substr($tmp2[0], 4, 2) . '-' . substr($tmp2[0], 6, 2);
    
    // area
    $area = $tmp[3];

    // key
    $fname = $key;
    
    $str .= '<media>';
    $str .= '<content>' .$content. '</content>';
    $str .= '<url>' .$url. '</url>';
    $str .= '<time>' .$time. '</time>';
    $str .= '<area>' .$area. '</area>';
    $str .= '<key>' . $key . '</key>';
    $str .= '</media>';
}

$xml .= $str;
$xml .= '</root>';

echo $xml;

?>
