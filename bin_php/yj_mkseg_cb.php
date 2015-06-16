<?php

$input = $GLOBALS['HTTP_RAW_POST_DATA'];
$data = json_decode($input);

require_once 'yj_common.php';
require_once 'yj_db.php';

use Qiniu\Storage\BucketManager;

$m3u8 = $data->items[0]->key;
$orig = $data->inputKey;
$bucketMgr = New BucketManager($g_auth);
$bucket = $g_bucket;

//move
$key = $m3u8;
$key2 = str_replace($g_orig_prefix, $g_seg_prefix, $orig);
$key2 .= ".m3u8";

list($ret, $err) = $bucketMgr->move($bucket, $key, $bucket, $key2);
if ($err !== null){
    $log = "MOVE $bucket $key -> $key2 $err";
    //system("echo $log >> log_err");
}else{
    db_write_m3u8($key2, $key);
    $log = "MOVE $bucket $key -> $key2";
    //system("echo $log >> log");
}

// delete
list($ret, $err) = $bucketMgr->delete($bucket, $orig);
if ($err !== null) {
    $log = "DELE $bucket $orig $err";
    //system("echo $log >> log_err");    
} else {
    $log = "DELE $bucket $orig";
    //system("echo $log >> log");
}


?>
