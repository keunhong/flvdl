<?php
$code = $_GET['code'];

if(preg_match("/\/error\.php|style|stuff|skin|\/attach|\/blog|\/components|\/doc|\/image|\/language|\/lib|\/plugins|\/script|\/attach/i",$_SERVER['REQUEST_URI'])){
	$code = 404;
}

switch($code){
	case(401): $error_message = "You are not authorized to access the requested page (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>)";
			   break;
	case(403): $error_message = "You do not have the rights to view the requested page (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>)";
			   break;
	case(404): $error_message = "The requested URI (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>) does not exist.<br /><br />If you think this page should exists or think it is a broken link, please contact me at <b>ad<span style=\"display:none;\">(iC5+Jx</span>min@fl<span style=\"display:none;\">oQi`]z=}l</span>ixey.com</b>";
			   break;
	case(500): $error_message = "An internal server error occurred while trying to reach <b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b><br /><br />If this problem continues, please contact me at <b>ad<span style=\"display:none;\">(iC5+Jx</span>min@fl<span style=\"display:none;\">oQi`]z=}l</span>ixey.com</b>";
			   break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://flixey.com/stuff/css/error.css" />
<title>flixey :: error <?=$code;?></title>
</head>
<body>
<div class="logo"><a href="http://flixey.com"><img src="http://flixey.com/images/logo.png" alt="FLIXEY.COM" /></a> <p>Error <?=$code;?></p></div><br />
<br />
<br />
<div align="center">
	<div id="error_message"><?=$error_message;?></div>
</div>
<br />
<br />
<br />
<div class="footer">© <?=date('Y');?> <a href="http://flixey.com/" title="flixey.com">Flixey</a></div>
<br />
<br />
</body>
</html>