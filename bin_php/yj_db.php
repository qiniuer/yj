<?php

require_once 'yj_common.php';

try{
    $db = new PDO("sqlite:" . $g_db_file);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "DB conn failed : " . $e->getMessage();
    exit;
}


function db_reinit()
{
    global $db;

    $db->exec(
	"DROP TABLE IF EXISTS m3u8;"
    );
    
    $db->exec(
	"CREATE TABLE IF NOT EXISTS m3u8
          (
            id INT(11) PRIMARY KEY, 
            key_m3u8   VARCHAR(225), 
            seg_prefix VARCHAR(225)
          );"
    );

    $name = 'admin';
    $pass = 'admin';

    $db->exec(
        "DROP TABLE IF EXISTS user;"
    );

    $db->exec(
        "CREATE TABLE IF NOT EXISTS user
          (
            id INT(11) PRIMARY KEY,
            name     VARCHAR(225),
            password VARCHAR(225)
          );"
    );

    db_write_user($name, $pass);
}

function db_write_m3u8($new, $prev)
{
    global $db;
    $db->exec("INSERT INTO m3u8(key_m3u8, seg_prefix) VALUES ('$new', '$prev')");
}

function db_read_m3u8($new)
{
    global $db;
    $sql = "SELECT key_m3u8, seg_prefix FROM m3u8 where key_m3u8='$new';";

    $seg_prefix = "";    
    foreach ($db->query($sql) as $row) {
        $seg_prefix = $row['seg_prefix'];
    }
    return $seg_prefix;
}

function db_rm_m3u8($new)
{
    global $db;
    $db->exec("DELETE FROM m3u8 where key_m3u8='$new'");
    
}

function db_write_user($name, $password)
{
    global $db;
    $db->exec("INSERT INTO user(name, password) VALUES ('$name', '$password')");
}

function db_read_user($name)
{
    global $db;
    $sql = "SELECT name, password FROM user where name='$name';";

    $pass = "";
    foreach ($db->query($sql) as $row) {
        $pass = $row['password'];
    }
    return $pass;
}

function db_update_user($name, $password)
{
    global $db;
    $db->exec("UPDATE user SET password='$password' where name='$name'");
}
?>
