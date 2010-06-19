<?php
$code = $_GET['code'];
switch($code){
	case(401): $error_message = "You are not authorized to access the requested page (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>)";
			   break;
	case(403): $error_message = "You do not have the rights to view the requestion page (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>)";
			   break;
	case(404): $error_message = "The requested URI (<b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>) does not exist.";
			   break;
	case(500): $error_message = "An internal server error occurred while trying to reach <b>http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."</b>";
			   break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://niya.cc/css/error.css" />
<title>Error <?=$code;?> | niya.cc</title>
</head>
<body>
<div id="logo"><img src="http://www.flixey.com/images/logo_lightbg.jpg" alt="flixey.com" /></div>
<br />
<div id="error_heading">Error <?=$code;?></div>
<br />
<br />
<div id="error_message"><?=$error_message;?></div>
</body>
</html>