<?php

require_once 'yj_common.php';
require_once 'yj_db.php';

g_check_uauth();

use Qiniu\Storage\BucketManager;

$key = $_POST['key'];

function rm_seg($prefix)
{
    global $g_bucket;
    global $g_auth;

    $bucketMgr = New BucketManager($g_auth);

    $eno = 0;
    list($items, $marker, $err) = $bucketMgr->listFiles($g_bucket, $prefix);
    for ($i = 0; $i < count($items); $i++){
        list($ret, $err) = $bucketMgr->delete($g_bucket, $items[$i]['key']);
        if ($err !== null) {
            $eno++;
        }
    }
    return $eno;
}

function rm_file($key)
{
        global $g_bucket;
        global $g_auth;

        $bucketMgr = New BucketManager($g_auth);

        list($ret, $err) = $bucketMgr->delete($g_bucket, $key);
        if ($err !== null){
                return -1;
        }else{
                return 0;
        }
}

$prefix = db_read_m3u8($key);
if ($prefix != ""){
        $ret = rm_seg($prefix);
        if ($ret == 0){
                if (rm_file($key) == 0){
                        db_rm_m3u8($key);
                }else{
			$ret = -2;
		}
        }
}else{
        $ret = -1;
}

echo $ret;

?>
