<html>
<head>
<title>RyuJin</title>
</head>
<body>
    <style>
        html,body{background: #333;color:#eee;font-family: monospace;font-weight: bold;}#token{background: transparent;border:1px solid #eee;padding:3px;width:250px;color:yellow;}#activate{background: transparent;border: 1px solid yellow;color:#eee;padding:3px}
    </style>
<div style="margin-top:15%">
<center>
<h3>RyuJin</h3>
<?php
 function getDomain()
   {
       $domain = preg_replace('/www\./i','',$_SERVER['SERVER_NAME']);
       $domain = ($domain == '127.0.0.1') ? 'localhost' : $domain;
       return $domain;
   }
if(isset($_POST['token']))
{
    $token = str_replace(" ","",$_POST['token']);
    if(!preg_match("/7INC/",$token))
    {
        echo "<font color=red>TOKEN NOT VALID</font><br>";
    }else{
        $tokendir = dirname(__DIR__).'/App/config/.token';
        $hta = dirname(__DIR__).'/htaccess.txt'; 
        $f = file_put_contents($tokendir,$token);
        $htf = file_get_contents($hta);
        $str = str_replace('{domain}', getDomain() , $htf);
        $f.= file_put_contents(dirname(__DIR__) . '/.htaccess',$str);
        
        if($f)
        {
            echo "<font color=lime>TOKEN SAVED </font><br>";@unlink(dirname(__DIR__) .'/index.php');
            echo "<meta http-equiv='refresh' content='1;url=?c=ryupanel&a=signin'>";
        }else{
            echo "<font color=yellow>TOKEN CAN'T SAVE </font><br>";
        }
    }
}
?>
<form method="post">
<label for="token">Input token :</label>
<input type="text" name="token" id="token" autocomplete="off" >

</form>
</center>
</div>
</body>
</html>
