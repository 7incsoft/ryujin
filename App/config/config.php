<?php

/*
* -------------------------------
* Load Config filename
* -------------------------------
*/

/** Load config **/

$list_conf = [
			
			'app',
			'web',
			'ryujin'
			];


foreach($list_conf as $conf)
{
	include CONFIG_PATH. $conf.".php";
}
define('CONFIG',$config);
?>
