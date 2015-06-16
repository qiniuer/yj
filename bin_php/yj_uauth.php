<?php

require_once 'yj_common.php';
require_once 'yj_db.php';

$op = $_POST['op'];

switch($op)
{
case "login":
	$usr = $_POST['usr'];
	$passwd = $_POST['passwd'];

	$db_pass = db_read_user($usr);
	if ($passwd == ""){
		echo "error: no such user or password incorrect 1.";
		exit;
	}

	if ($passwd == $db_pass){
		$_SESSION['usr'] = $usr;
		$_SESSION['auth'] = 1;
		echo "0";
	}else{
		unset($_SESSION['usr']);
		unset($_SESSION['auth']);
		echo "error: no such user or password incorrect 2.";
	}
	break;

case "reset":
	$usr = $_POST['usr'];
	$passwd = $_POST['passwd'];
	$newpass = $_POST['passwd_n1'];

	$db_pass = db_read_user($usr);
        if ($passwd == ""){
                echo "error: account not corrected.";
                exit;
        }

	db_update_user($usr, $newpass);
	echo "0";

	break;

case "reg":
	g_check_uauth();

        if ($_SESSION['usr'] != "admin"){
		echo "error: not privileged.";
		exit;
	}

        $usr = $_POST['usr'];
        $passwd = $_POST['passwd'];

	db_write_user($usr, $passwd);
	echo "$usr, $passwd";

	break;

default:
	echo "error: no such operation.";
}

?>
