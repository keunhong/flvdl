<?php
header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 01 Jan 2000 00:00:00 GMT");

if(!eregi($_SERVER['HTTP_HOST'],$_SERVER['HTTP_REFERER'])) exit;

define("_included",true);

$id = $_POST['id'];
$id = str_replace(" ","",$id);
$site = $_POST['site'];

if(!$id) exit;

require_once "../classes/pear.http.php";
require_once "../classes/class.getflv.php";

$result = "";

function fetchFlv($fetch_url,$reg,$id,$match_no,$redirect,$extra_url,$title_reg,$title_match_no,$thumbnail_direct,$thumbnail_url_prefix,$thumbnail_url_suffix,$thumbnail_reg,$thumbnail_match_no,$content_reg,$content_match_no){

	global $result;

	$getflv = new getflv;

	if(!$extra_url){
		$extra_url = false;
	}
	if(!$get_redirected_url){
		$get_redirected_url = false;
	}

	$getflv->setvar("video_id",$id);
	$getflv->setvar("fetch_url",$fetch_url.$id);
	$getflv->setvar("extra_url",$extra_url);
	$getflv->setvar("match_no",$match_no);
	$getflv->setvar("get_redirected_url",$redirect);
	$getflv->setvar("reg",$reg);
	$getflv->setvar("title_reg",$title_reg);
	$getflv->setvar("title_match_no",$title_match_no);
	$getflv->setvar("thumbnail_direct",$thumbnail_direct);
	$getflv->setvar("thumbnail_url_prefix",$thumbnail_url_prefix);
	$getflv->setvar("thumbnail_url_suffix",$thumbnail_url_suffix);
	$getflv->setvar("thumbnail_reg",$thumbnail_reg);
	$getflv->setvar("thumbnail_match_no",$thumbnail_match_no);
	$getflv->setvar("content_reg",$content_reg);
	$getflv->setvar("content_match_no",$content_match_no);

	$getflv->openHTML();
	$getflv->getVideo();
	if($title_reg){
		$getflv->getTitle();
	}
	if($thumbnail_reg ||  $thumbnail_direct){
		$getflv->getThumbnail();
	}
	if($content_reg){
		$getflv->getContent();
	}
	
	

//	echo $getflv->fetch_url;
//	echo $getflv->match[0];
//	echo $getflv->html;

	$result = $getflv->getResult();
}

switch($site){
/******************************************
*** YouTube
******************************************/ 
	case("youtube"):
		fetchFlv(
			"http://youtube.com/watch?v=", // fetch_url
			"/video_id=\S+&.+&t=.+&hl/i", // reg
			$id, // video_id
			0, // match_no
			true, // redirect
			"http://www.youtube.com/get_video?", // extra_url
			"/<title>YouTube - (.*)<\/title>/i", // title_reg
			1, // title_match_no
			true, // thumbnail_direct
			"http://img.youtube.com/vi/", // thumbnail_url_prefix
			"/default.jpg", // thumbnail_url_suffix
			false, // thumbnail_reg
			false, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n</result>";
		break;
}
?>