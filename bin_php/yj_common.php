<?php

require_once 'autoload.php';

use Qiniu\Auth;

$accessKey = '_dJU6nq83rkE-NMYuQxg5b6my7vslNTJyNeMxYpD';
$secretKey = 'k2r_CC4blZM-sKvJxRaxtn-jK7LnokyegPKkNBDl';
$g_auth = new Auth($accessKey, $secretKey);
$g_host = '115.231.183.32/src';
$g_host_bin = $g_host. '/bin_php';
$g_cb = 'http://172.30.251.247/src/bin_php/';
$g_bucket_site = 'http://7x00hh.com1.z0.glb.clouddn.com/';
$g_bucket = 'bucket';
$g_orig_prefix = 'media/origin/';
$g_seg_prefix = 'media/m3u8/';
$g_db_file = 'db.data';

session_start();
function g_check_uauth()
{
	if ($_SESSION['auth'] == 1){
		return 0;
	}else{
		echo "error: UAuth failed.";
		exit;
	}
}

?>
