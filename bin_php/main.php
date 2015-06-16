#!/usr/bin/php

<?php

require_once 'autoload.php';

use Qiniu\Auth;
use Qiniu\Processing\PersistentFop;

$accessKey = '_dJU6nq83rkE-NMYuQxg5b6my7vslNTJyNeMxYpD';
$secretKey = 'k2r_CC4blZM-sKvJxRaxtn-jK7LnokyegPKkNBDl';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'bucket';
$key = 'demo.mp4';
$pfop = New PersistentFop($auth, $bucket);

$fops='avthumb/m3u8/segtime/40/vcodec/libx264/s/320x240';
list($id, $err) = $pfop->execute($key, $fops);

echo "\n====> pfop avthumb result: \n";
if ($err != null) {
    var_dump($err);
} else {
    echo "PersistentFop Id: $id";
}

?>
