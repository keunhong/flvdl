<?php
// Redirect old language vars
if($_GET['ln'] == "jp"){
	header("Location: ./?ln=JA-jp");
}else if($_GET['ln'] == "kr"){
	header("Location: ./?ln=KO-kr");
}

define("_included",true);
include "./classes/class.ln.php";

$_ln = $_GET['ln'];
$ln = new ln;

if(file_exists($dir = "./ln/ln.".$_ln.".php")){
	include $dir;
}else{
	$_ln = "EN-us";
	include "./ln/ln.EN-us.php";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Download videos from various flv based video sites." />
<meta name="keywords" content="youtube, metacafe, download, naver, daum, daum tvpot, flv, downloader, flash video, putfile, break, spark, pandora tv, pandora, mncast, mgoon" />
<meta name="robots" content="all,index,follow" />

<link rel="stylesheet" href="./css/styles.main.css" title="styles.main" />
<script type="text/javascript" src="./js/scripts.ajax.js"></script>
<script type="text/javascript" src="./js/scripts.mgoon.js"></script>
<script type="text/javascript">
var download_link = "<?=$ln->download_link?>";
var mgoon_warn = "<?=$ln->mgoon_warn?>";
</script>
<title>video downloader | flixey.com</title>
</head>
<body>
<div align="center">
	<div class="main-body">
		<div class="main-top-logo"><a href="http://flixey.com"><img src="http://flixey.com/images/logo.png" alt="flixey" /></a>
</div>
		<div class="main-body-get" align="center">
		<div class="main-top-ln">
			<a href="?ln=EN-us"><img src="http://niya.cc/images/flags/us.png" alt="EN-us" /></a>
			<a href="?ln=EN-uk"><img src="http://niya.cc/images/flags/gb.png" alt="EN-uk" /></a>
			<a href="?ln=KO-kr"><img src="http://niya.cc/images/flags/kr.png" alt="KO-kr" /></a>
			<a href="?ln=JA-jp"><img src="http://niya.cc/images/flags/jp.png" alt="JA-jp" /></a>
			<a href="?ln=SV-se"><img src="http://niya.cc/images/flags/se.png" alt="SV-se" /></a>
		</div>
			<p class="main-body-get-form-directions"><?=$ln->directions_direct;?></p>
				<form name="getflv" id="getflv" action="./" method="post">
				<table class="main-body-get-form">
					<tr>
						<td>
							<input type="text" id="getflv-input" />
						</td>
						<td>
							<select id="getflv-select">
								<option value="">(<?=$ln->select;?>)</option>
								<option value="">---</option>
								<option value="youtube"><?=$ln->youtube;?></option>
								<option value="googlevideo"><?=$ln->googlevideo;?></option>
								<option value="metacafe"><?=$ln->metacafe;?></option>
								<option value="myspace"><?=$ln->myspace;?></option>
								<option value="veoh"><?=$ln->veoh;?></option>
								<option value="break_com"><?=$ln->break_com;?></option>
								<option value="spike"><?=$ln->spike;?></option>
								<option value="putfile"><?=$ln->putfile;?></option>
								<option value="5min"><?=$ln->fivemin;?></option>
								<option value="">---</option>
								<option value="mgoon"><?=$ln->mgoon;?></option>
								<option value="mncast"><?=$ln->mncast;?></option>
								<option value="pandoratv"><?=$ln->pandoratv;?></option>
								<option value="naver"><?=$ln->naver;?></option>
								<option value="daum"><?=$ln->daum;?></option>
							</select>
						</td>
						<td class="main-body-get-form-submit-td">
							<span id="main-body-get-form-submit"><input type="submit" id="getflv-submit" value="<?=$ln->download;?>" /></span><span id="main-body-get-form-loader"><img src="./img/loader.gif" alt="loading..." /></span>
						</td>
					</tr>
				</table>
				</form>
			<p id="main-body-get-form-errors"></p>
			<p class="main-body-get-form-example"><?=$ln->example;?>: <span id="main-body-get-form-example">http://youtube.com/watch?v=EZSUKFYX0FM</span></p>
		</div>
		<br />
		<script type="text/javascript">
		<!--
			google_ad_client = "pub-9746216862614473";
			//728x90, created 1/18/08
			google_ad_slot = "5037443679";
			google_ad_width = 728;
			google_ad_height = 90;
		//-->
		</script>
		<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
		<br />
		<br />
		<div id="main-body-result">
			<div id="main-body-result-title"><?=$ln->result;?></div>
			<div id="main-body-result-content"></div>
			<br />
		</div>
		<div class="main-body-search" align="center">
			<p class="main-body-get-form-directions"><?=$ln->directions_search;?></p>
				<form name="search" id="search" action="./search/" method="get">
				<input type="hidden" name="ln" value="<?=$_ln;?>" />
				<table class="main-body-search-form">
					<tr>
						<td>
							<input type="text" name="q" id="search-input" />
						</td>
						<td>
							<select id="search-select">
								<option value="youtube"><?=$ln->youtube;?></option>
							</select>
						</td>
						<td class="main-body-search-form-submit-td">
							<span id="main-body-search-form-submit"><input type="submit" id="search-submit" value="<?=$ln->search;?>" /></span>
						</td>
					</tr>
				</table>
				<p class="main-body-search-form-vars">
					<?=$ln->sort_by;?>: 
					<input type="radio" name="searchSort" value="relevance" id="relevance" checked="checked" />
					<label for="relevance"><?=$ln->relevance;?></label>
					<input type="radio" name="searchSort" value="video_date_uploaded" id="video_date_uploaded" />
					<label for="video_date_uploaded"><?=$ln->date_added;?></label>
					<input type="radio" name="searchSort" value="video_view_count" id="video_view_count" />
					<label for="video_view_count"><?=$ln->view_count;?></label>
					<input type="radio" name="searchSort" value="video_avg_rating" id="video_avg_rating" />
					<label for="video_avg_rating"><?=$ln->rating;?></label>
					 / 
					<input type="radio" name="uploaded" value="" id="all_time" checked="checked" />
					<label for="all_time"><?=$ln->all_time;?></label>
					<input type="radio" name="uploaded" value="d" id="today" />
					<label for="today"><?=$ln->today;?></label>
					<input type="radio" name="uploaded" value="w" id="this_week" />
					<label for="this_week"><?=$ln->this_week;?></label>
					<input type="radio" name="uploaded" value="m" id="this_month" />
					<label for="this_month"><?=$ln->this_month;?></label>
				</p>
				</form>
		</div>
		<br />

		<div class="main-bottom">
			<!--<p class="foot_info"><?=$ln->siteadd;?><b>vide<span style="display:none;">3|"RU@gub</span>o@f<span style="display:none;">BG$4SYb</span>lixey.co<span style="display:none;">Y,Q~K</span>m<span style="display:none;">[[eSJ~</span></b></p>-->
			<p>powered by <a href="http://flixey.com/">flixey.com</a></p>
		</div>
<br />
	</div>
</div>

<script type="text/javascript" src="./js/scripts.main.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-1331144-3");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>