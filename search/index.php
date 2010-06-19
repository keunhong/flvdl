<?php
// Redirect old language vars
if($_GET['ln'] == "jp"){
	header("Location: ./?ln=JA-jp");
}else if($_GET['ln'] == "kr"){
	header("Location: ./?ln=KO-kr");
}

define("_included",true);
include "../classes/class.ln.php";

$_ln = $_GET['ln'];
if(!$_ln){
	$_ln = "EN-us";
}
$ln = new ln;

if(file_exists($dir = "../ln/ln.".$_ln.".php")){
	include $dir;
}else{
	include "../ln/ln.EN-us.php";
}

if(!$page){
	$page = 1;
}else{
	$page = $_GET['page'];
}


$site       = "youtube";
$query      = urldecode($_GET['q']);
$searchSort = $_GET['searchSort'];
$uploaded   = $_GET['uploaded'];

if($query){
// Organize youtube URL
$url = "http://youtube.com/results?search_type=search_videos&search_query=".urlencode(stripslashes(str_replace(" ","+",$query)))."&search_sort=".$searchSort."&search_category=0&search=Search&v=&uploaded=".$uploaded."&page=".$page;

// Load youtube source into $html
$html = file_get_contents($url);

preg_match("/<strong>(.+) - (.+)<\/strong> of about <strong>(.+)<\/strong>/",$html,$matches);
$videoRange[0] = $matches[1];
$videoRange[1] = $matches[2];
$videoTotal = str_replace(",","",$matches[3]);
if($videoTotal < 1000){
	$pageMax = floor(intval($videoTotal) / 20);
}else{
	$pageMax = 50;
}

preg_match_all("/vlshortTitle\">\n.+watch\?v=(.*)\" title=\"(.*)\" onclick=/i",$html,$matches);
$videoId = $matches[1];
$videoTitle = $matches[2];

preg_match_all("/Added:<\/span> (.+)<br\/>/",$html,$matches);
$videoDate = $matches[1];

preg_match_all("/From:<\/span><span class=\"vlfrom\">  <a href=\".+\" >(.+)<\/a>/",$html,$matches);
$videoUser = $matches[1];

preg_match_all("/Views:<\/span> (.+)<br\/>/",$html,$matches);
$videoViews = $matches[1];
}else{
	$videoRange[0] = "0";
	$videoRange[1] = "0";
	$videoTotal = "0";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="Download videos from various flv based video sites." />
<meta name="keywords" content="youtube, metacafe, download, naver, daum, daum tvpot, flv, downloader, flash video, putfile, break, spark, pandora tv, pandora, mncast, mgoon" />
<meta name="robots" content="all,index,follow" />
<link rel="stylesheet" href="../css/styles.search.css" title="styles.search" />
<script type="text/javascript" src="../js/scripts.ajax.js"></script>
<script type="text/javascript" src="../js/scripts.search.js"></script>
<script type="text/javascript">
var ln_download = "<?=$ln->download;?>";
var ln_download_link = "<?=$ln->download_link?>";
</script>
<title>video downloader: search | flixey.com</title>
</head>
<body>
<div align="center">
	<div class="search-body">
		<div class="top-logo"><a href="http://flixey.com"><img src="http://flixey.com/image/logo_whitebg.jpg" alt="flixey"></a><a href="http://video.flixey.com/?ln=<?=$_ln;?>"><span>main</span>page</a></div>
		<div class="top-ln">
			<a href="?ln=EN-us&amp;q=<?=urlencode($query);?>&amp;search_sort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page;?>"><img src="http://niya.cc/images/flags/us.png" alt="EN-us" /></a>
			<a href="?ln=EN-uk&amp;q=<?=urlencode($query);?>&amp;search_sort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page;?>"><img src="http://niya.cc/images/flags/gb.png" alt="EN-uk" /></a>
			<a href="?ln=KO-kr&amp;q=<?=urlencode($query);?>&amp;search_sort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page;?>"><img src="http://niya.cc/images/flags/kr.png" alt="KO-kr" /></a>
			<a href="?ln=JA-jp&amp;q=<?=urlencode($query);?>&amp;search_sort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page;?>"><img src="http://niya.cc/images/flags/jp.png" alt="JA-jp" /></a>
			<a href="?ln=SV-se&amp;q=<?=urlencode($query);?>&amp;search_sort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page;?>"><img src="http://niya.cc/images/flags/se.png" alt="SV-se" /></a>
		</div><br />

		<div class="search-body-search" align="center">
				<form name="search" id="search" action="./" method="get">
				<input type="hidden" name="ln" value="<?=$_ln;?>" />
				<table class="search-body-search-form">
					<tr>
						<td>
							<input type="text" name="q" id="search-input" value="<?=$query;?>" />
						</td>
						<td>
							<select id="search-select">
								<option value="youtube"><?=$ln->youtube;?></option>
							</select>
						</td>
						<td class="search-body-search-form-submit-td">
							<span id="search-body-search-form-submit"><input type="submit" id="search-submit" value="<?=$ln->search;?>" /></span>
						</td>
					</tr>
				</table>
				<p class="search-body-search-form-vars">
					<?=$ln->sort_by;?>: 
					<input type="radio" name="searchSort" value="relevance" id="relevance" <? if($searchSort == "relevance"){ ?>checked="checked"<? } ?> />
					<label for="relevance"><?=$ln->relevance;?></label>
					<input type="radio" name="searchSort" value="video_date_uploaded" id="video_date_uploaded" <? if($searchSort == "video_date_uploaded"){ ?>checked="checked"<? } ?> />
					<label for="video_date_uploaded"><?=$ln->date_added;?></label>
					<input type="radio" name="searchSort" value="video_view_count" id="video_view_count" <? if($searchSort == "video_view_count"){ ?>checked="checked"<? } ?> />
					<label for="video_view_count"><?=$ln->view_count;?></label>
					<input type="radio" name="searchSort" value="video_avg_rating" id="video_avg_rating" <? if($searchSort == "video_avg_rating"){ ?>checked="checked"<? } ?> />
					<label for="video_avg_rating"><?=$ln->rating;?></label>
					 / 
					<input type="radio" name="uploaded" value="" id="all_time" <? if($uploaded == ""){ ?>checked="checked"<? } ?> />
					<label for="all_time"><?=$ln->all_time;?></label>
					<input type="radio" name="uploaded" value="d" id="today" <? if($uploaded == "d"){ ?>checked="checked"<? } ?> />
					<label for="today"><?=$ln->today;?></label>
					<input type="radio" name="uploaded" value="w" id="this_week" <? if($uploaded == "w"){ ?>checked="checked"<? } ?> />
					<label for="this_week"><?=$ln->this_week;?></label>
					<input type="radio" name="uploaded" value="m" id="this_month" <? if($uploaded == "m"){ ?>checked="checked"<? } ?> />
					<label for="this_month"><?=$ln->this_month;?></label>
				</p>
				</form>
		</div>
		<br />
		<div class="title">
			<div class="stat">
				<?=$videoRange[0];?> ~ <?=$videoRange[1];?> / <?=$videoTotal;?>
			</div>
			Searching YouTube
		</div>
		<div class="pages">
		<?php if($page > 1){ ?>
			<a href="./?ln=<?=$_ln;?>&amp;q=<?=urlencode($query);?>&amp;searchSort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page - 1;?>"><?=$ln->previous_page;?></a>
		<?php }if($page < $pageMax && $page > 1){ ?>
			&nbsp;
		<?php }if($page < $pageMax){ ?>
			<a href="./?ln=<?=$_ln;?>&amp;q=<?=urlencode($query);?>&amp;searchSort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page + 1;?>"><?=$ln->next_page;?></a>
		<?php } ?>
		</div>
		<?php
			$z = 0;
			if($query && $videoId[0]){
			while($z < count($videoId)){
		?>
			<div class="item">
				<div class="itemTitle"><b><a href="http://www.youtube.com/watch?v=<?=$videoId[$z];?>"><?=$videoTitle[$z];?></a></b></div>
				<div class="itemThumb">
					<img src="http://i.ytimg.com/vi/<?=$videoId[$z];?>/1.jpg" />
					<img src="http://i.ytimg.com/vi/<?=$videoId[$z];?>/default.jpg" />
					<img src="http://i.ytimg.com/vi/<?=$videoId[$z];?>/3.jpg" />
				</div>
				<div class="itemContent">
					<b><?=$ln->added;?>:</b> <?=$videoDate[$z];?><br />
					<b><?=$ln->from;?>:</b> <a href="http://www.youtube.com/user/<?=$videoUser[$z];?>"><?=$videoUser[$z];?></a><br />
					<b><?=$ln->views;?>:</b> <?=$videoViews[$z];?><br />
				</div>
				<br />
				<div class="downloadLink">
					<div class="loader" id="loader_<?=$videoId[$z];?>"><img src="../img/search.loader.gif" alt="loading..." /></div>
					<div id="dl_<?=$videoId[$z];?>"><a href="javascript:void(0);" onclick="getVideo('<?=$videoId[$z];?>','<?=$site;?>');"><?=$ln->download;?></a></div>
				</div>
			</div>
		<?php
				if(($z+1) % 6 == 0){
		?>
		<div class="ad_item">
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
		</div>
		<?php
				}
			$z++;
			}
			}else{
		?>
		<div class="item">no result</div>
		<?php
			}
		?>
		<div class="pages">
		<?php if($page > 1){ ?>
			<a href="./?ln=<?=$_ln;?>&amp;q=<?=urlencode($query);?>&amp;searchSort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page - 1;?>"><?=$ln->previous_page;?></a>
		<?php }if($page < $pageMax && $page > 1){ ?>
			&nbsp;
		<?php }if($page < $pageMax){ ?>
			<a href="./?ln=<?=$_ln;?>&amp;q=<?=urlencode($query);?>&amp;searchSort=<?=$searchSort;?>&amp;uploaded=<?=$uploaded;?>&amp;page=<?=$page + 1;?>"><?=$ln->next_page;?></a>
		<?php } ?>
		</div>
		<br />
		<div class="search-bottom">
			<!--<p class="foot_info"><?=$ln->siteadd;?><b>vide<span style="display:none;">3|"RU@gub</span>o@f<span style="display:none;">BG$4SYb</span>lixey.co<span style="display:none;">Y,Q~K</span>m<span style="display:none;">[[eSJ~</span></b></p>-->
			<p>powered by <a href="http://flixey.com/">flixey.com</a></p>
		</div>
	</div>
</div>

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