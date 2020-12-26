<?php

/*
* -------------------------------
* Load Config filename
* -------------------------------
*/

$list_conf = array('web');

foreach($list_conf as $conf)
{
	include CONFIG_PATH. $conf.".php";
}
define('CONFIG',$config);
?>