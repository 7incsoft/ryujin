<?php

/*
* -------------------------------
* Load Config filename
* -------------------------------
*/

/** Load config **/

$list_conf = [
			
			
			'web',
			
			];


foreach($list_conf as $conf)
{
	include CONFIG_PATH. $conf.".php";
}
define('CONFIG',$config);
?>
