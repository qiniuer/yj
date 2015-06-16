<?php

require_once 'yj_common.php';
require_once 'yj_db.php';

g_check_uauth();

use Qiniu\Processing\PersistentFop;
use Qiniu\Storage\BucketManager;

function make_seg($key)
{
    global $g_bucket;
    global $g_auth;
    global $g_cb;

    $notify = $g_cb . "yj_mkseg_cb.php"; 
    $bucket = $g_bucket;
    $pfop = New PersistentFop($g_auth, $bucket, null, $notify);

    $fops='avthumb/m3u8/segtime/40/vcodec/libx264/s/1280x960';
    list($id, $err) = $pfop->execute($key, $fops);

    if ($err != null) {
	return array(0, $err);
    } else {
	db_write_pfop($key, $id);
	return array($id, null);
    }
}

function convert_all()
{
    global $g_orig_prefix;
    global $g_bucket;
    global $g_auth;
    
    $bucketMgr = New BucketManager($g_auth);
    list($items, $marker, $err) = $bucketMgr->listFiles($g_bucket, $g_orig_prefix);

    $key = '';
    for ($i = 0; $i < count($items); $i++) {
	$key = $items[$i]['key'];
	make_seg($key);
    }
}

convert_all();

?>
