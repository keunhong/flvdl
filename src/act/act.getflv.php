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
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Google Video
******************************************/
		case("googlevideo"):
		fetchFlv(
			"http://video.google.com/videoplay?docid=", // fetch_url
			"/googleplayer.swf\?\&videoUrl=(.*)\" id/i", // reg
			$id, // video_id
			1, // match_no
			true, // redirect
			false, // extra_url
			"/<title>(.*)<\/title>/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/<td class=\"main_video_thumb\">.*<img src=\"(.*)\" alt=\"\" class=\"searchresultimg\"/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Veoh
******************************************/
		case("veoh"):
		fetchFlv(
			"http://www.veoh.com/rest/v2/execute.xml?method=veoh.search.search&type=video&maxResults=40&contentRatingId=3&apiKey=5697781E-1C60-663B-FFD8-9B49D2B56D36&query=id:", // fetch_url
			"/fullPreviewHashPath=\"(.*)\"/i", // reg
			$id, // video_id
			1, // match_no
			true, // redirect
			false, // extra_url
			"/title=\"(.*)\"/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/fullMedResImagePath=\"(.*)\"/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Mncast
******************************************/
		case("mncast"):
		fetchFlv(
			"http://www.mncast.com/_MovieInfo_/_MovieInfoXML_Tag_.asp?movieID=", // fetch_url
			"/<url>(.*)<\/url>/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/<title>(.*)<\/title>/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/fullMedResImagePath=\"(.*)\"/i", // thumbnail_reg
			1, // thumbnail_match_no
			"/<content>(.*)<\/content>/i", // content_reg
			1 // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}
		if(!$result[content]){
			$result[content] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>http://".htmlspecialchars($result[url]).".flv</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>http://".htmlspecialchars($result[url]).".jpg</thumbnail>";
		echo "\n<content>".htmlspecialchars($result[content])."</content>";
		echo "\n</result>";
		break;

/******************************************
*** Mgoon
******************************************/
		case("mgoon"):
		fetchFlv(
			"http://222.239.226.90/oc/get?id=", // fetch_url
			"/FLV_URL=\"(.*)\"/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/TITLE=\"(.*)\"/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/THUMB_URL=\"(.*)\"/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** PandoraTV
******************************************/
		case("pandoratv"):
		$vars = explode("|",$id);
		$result = array();
		$result[url] = "http://flvcdn.pandora.tv/flv/_user/".substr($vars[0],0,1)."/".substr($vars[0],1,1)."/".$vars[0]."/".$vars[1].".flv";

		$getflv = new getflv;
		$getflv->setvar("result_url",$result[url]);
		//$result[url] = $getflv->getRedirectedUrl();

		$html = file_get_contents("http://flvr.pandora.tv/flv2pan/flv_trs.dll/flash_title?url=".$vars[1]);
		$html = mb_convert_encoding($html, "UTF-8", "EUC-KR");

		preg_match("/\"title\":\"(.*)\", \"runtime.*image\":\"(.*)\"/i",$html,$matches);
		$result[title] = $matches[1];
		$result[thumbnail] = $matches[2];
		
		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "[temporarily unavailable]";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "about:blank";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Myspace
******************************************/
		case("myspace"):
		fetchFlv(
			"http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID=", // fetch_url
			"/<media:content url=\"(.*)\" type=\"video\/x-flv\"/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/      <title>(.*)<\/title>/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/<media:thumbnail url=\"(.*)\" \/>/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Spike
******************************************/
		case("spike"):
		fetchFlv(
			"http://www.spike.com/video/", // fetch_url
			"/adVideoUrl.+url\* : \*(.*)\*.+event_MEDIA_START/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/adVideoUrl.+title\* : \*(.*)\*.+url/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			false, // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);
		$result[thumbnail] = "http://img".rand(1,4).".ifilmpro.com/resize/image/stills/films/resize/istd/".$id.".jpg?width=150";

		$result[url] = str_replace("$","&",$result[url]);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Break
******************************************/
		case("break_com"):
		fetchFlv(
			"http://www.break.com/", // fetch_url
			"/<meta name=\"embed_video_thumb_url\" content=\"(.*)\.jpg\" \/><meta name=\"embed_video_title/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/<meta name=\"embed_video_title\" content=\"(.*)\" \/><meta name=\"embed_video_description/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			false, // thumbnail_reg
			false, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url]).".flv</url>";
		echo "\n<url_wmv>".htmlspecialchars($result[url]).".wmv</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[url]).".jpg</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Putfile
******************************************/
		case("putfile"):
		fetchFlv(
			"http://media.putfile.com/", // fetch_url
			"/addVariable\(\"flv\", \"(.*)\"\);/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/title\" content=\"(.*)\" \/>/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/image_src\" href=\"(.*)\" \/>/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** 5min
******************************************/
		case("5min"):
		fetchFlv(
			"http://www.5min.com/Video/", // fetch_url
			"/vidURL', '(.*)'\);so\.addVariable\('vidTitle/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/<meta name=\"title\" content=\"(.*)\ \/><meta name=\"video_height/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/previewPic', '(.*)'\);.*videoID/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Naver
******************************************/
		case("naver"):

		$vars = explode("|",$id);
		$xml_vid = "http://serviceapi.nmv.naver.com/flash/play.nhn?vid=".$vars[0]."&outKey=".$vars[1];
		$xml_vid = file_get_contents($xml_vid );
		preg_match("/<FlvUrl><!\[CDATA\[(.*)\]\]><\/FlvUrl>/i",$xml_vid,$matches);
		$result[url] = $matches[1];
		

		$xml_info = "http://serviceapi.nmv.naver.com/flash/videoInfo.nhn?vid=".$vars[0]."&outKey=".$vars[1];
		$xml_info = file_get_contents($xml_info );
		preg_match("/<Subject><!\[CDATA\[(.*)\]\]><\/Subject>/i",$xml_info,$matches);
		$result[title] = $matches[1];
		preg_match("/<CoverImage><!\[CDATA\[(.*)\]\]><\/CoverImage>/i",$xml_info,$matches);
		$result[thumbnail] = $matches[1];

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}
		
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** Daum tvPot
******************************************/
		case("daum"):
		
		$xml_vid = file_get_contents("http://flvs.daum.net/viewer/MovieLocation.do?vid=".$id);
		preg_match("/<MovieLocation url=\"(.*)\"\/>/i",$xml_vid,$matches);
		$xml_vid = file_get_contents(htmlspecialchars_decode($matches[1]));
		preg_match("/<MovieLocation movieURL=\"(.*)\" \/>/i",$xml_vid,$matches);
		$result[url] = htmlspecialchars_decode($matches[1]);
		

		$xml_info = "http://tvpot.daum.net/clip/ClipInfoXml.do?kind=player&vid=".$id."&inout=out";
		$xml_info = file_get_contents($xml_info );
		preg_match("/<TITLE><!\[CDATA\[(.*)\]\]><\/TITLE>/i",$xml_info,$matches);
		$result[title] = $matches[1];
		preg_match("/<THUMB_URL><!\[CDATA\[(.*)\]\]><\/THUMB_URL>/i",$xml_info,$matches);
		$result[thumbnail] = $matches[1];

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;

/******************************************
*** MetaCafe
******************************************/
		case("metacafe"):
		fetchFlv(
			"http://www.metacafe.com/watch/", // fetch_url
			"/flashvars\", \"itemID=.*&mediaURL=(.*)&postRollContentURL=/i", // reg
			$id, // video_id
			1, // match_no
			false, // redirect
			false, // extra_url
			"/title\" content=\"Metacafe - (.*)\" \/>/i", // title_reg
			1, // title_match_no
			false, // thumbnail_direct
			false, // thumbnail_url_prefix
			false, // thumbnail_url_suffix
			"/image_src\" href=\"(.*)\" \/>/i", // thumbnail_reg
			1, // thumbnail_match_no
			false, // content_reg
			false // content_match_no
		);

		if(!$result[url]){
			$result[url] = "false";
		}
		if(!$result[title]){
			$result[title] = "false";
		}
		if(!$result[thumbnail]){
			$result[thumbnail] = "false";
		}

		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		echo "\n<result>";
		echo "\n<url>".htmlspecialchars($result[url])."</url>";
		echo "\n<url_wmv>false</url_wmv>";
		echo "\n<title>".htmlspecialchars($result[title])."</title>";
		echo "\n<thumbnail>".htmlspecialchars($result[thumbnail])."</thumbnail>";
		echo "\n<content>false</content>";
		echo "\n</result>";
		break;
}

?>