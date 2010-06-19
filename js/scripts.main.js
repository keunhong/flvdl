/********************************************************
*** flv.niya.cc base script
*** contact: niya@niya.cc
*** This script is the property of niya.cc, you may not copy, view, or distribute
*** this script in any form without prior consent of the administrator.
********************************************************/



var getflv_example = document.getElementById("main-body-get-form-example");
var getflv_select = document.getElementById("getflv-select");

document.getElementById("getflv-select").onchange = function(){
	if(getflv_select.value == "youtube"){
		getflv_example.innerHTML = "http://youtube.com/watch?v=EZSUKFYX0FM";
	}else if(getflv_select.value == "googlevideo"){
		getflv_example.innerHTML = "http://video.google.com/videoplay?docid=120196847870845809";
	}else if(getflv_select.value == "myspace"){
		getflv_example.innerHTML = "http://vids.myspace.com/index.cfm?fuseaction=vids.individual&VideoID=9584089";
	}else if(getflv_select.value == "veoh"){
		getflv_example.innerHTML = "http://www.veoh.com/videos/v746006ApDY2Rt3";
	}else if(getflv_select.value == "mncast"){
		getflv_example.innerHTML = "http://dory.mncast.com/mncHMovie.swf?movieID=10061704320080104152904";
	}else if(getflv_select.value == "mgoon"){
		getflv_example.innerHTML = "http://www.mgoon.com/view.htm?id=1241877<br /><strong>"  + mgoon_warn + "</strong>";
	}else if(getflv_select.value == "pandoratv"){
		getflv_example.innerHTML = "http://flvr.pandora.tv/flv2pan/flvmovie.dll?ch_userid=k-1kr&url=1D9EFC31A297444500880005778790&Partner=";
	}else if(getflv_select.value == "spike"){
		getflv_example.innerHTML = "http://www.spike.com/video/2757650";
	}else if(getflv_select.value == "break_com"){
		getflv_example.innerHTML = "http://www.break.com/index/snowball-crushes-kid.html";
	}else if(getflv_select.value == "putfile"){
		getflv_example.innerHTML = "http://media.putfile.com/LOL-dogs";
	}else if(getflv_select.value == "5min"){
		getflv_example.innerHTML = "http://www.5min.com/Video/How-to-Use-iPhone-Applications---Caissa-4088018";
	}else if(getflv_select.value == "naver"){
		getflv_example.innerHTML = "http://serviceapi.nmv.naver.com/flash/NFPlayer.swf?vid=...&outKey=...";
	}else if(getflv_select.value == "daum"){
		getflv_example.innerHTML = "http://flvs.daum.net/flvPlayer.swf?vid=OlnSZosOdPc$";
	}else if(getflv_select.value == "metacafe"){
		getflv_example.innerHTML = "http://www.metacafe.com/watch/892577/hard_to_believe_but_true/";
	}else{
		return true;
	}
}

document.getElementById("getflv").onsubmit = function(){

	var url = document.getElementById("getflv-input").value;

	if(!url || url == ""){
		document.getElementById("getflv-input").style.borderColor = "#ff0000";
		return false;
	}else{
		document.getElementById("getflv-input").style.borderColor = "#7f9db9";
	}
	
    if (url.match(/\?v=([^&]+)/)){
		var site = "youtube";
		document.getElementById("getflv-select").value = "youtube";
		var videoid = RegExp.$1;
	}else if(url.match(/videos\/(.*)\?/)){
		var site="veoh";
		document.getElementById("getflv-select").value = "veoh";
		var videoid = RegExp.$1;
	}else if(!url.match(/videos\/(.*)\?/) && url.match(/videos\/(.*)/)){
		var site="veoh";
		document.getElementById("getflv-select").value = "veoh";
		var videoid = RegExp.$1;
	}else if(url.match(/videoplay\?docid=(.*)/)){
		var site="googlevideo";
		document.getElementById("getflv-select").value = "googlevideo";
		var videoid = RegExp.$1;
	}else if(!url.match(/videoplay\?docid=(.*)/) && url.match(/videoplay\?docid=(.*)&(.*)/)){
		var site="google";
		document.getElementById("getflv-select").value = "googlevideo";
		var videoid = RegExp.$1;
	}else if(url.match(/videoplay\?docid=(.*)/)){
		var site="googlevideo";
		document.getElementById("getflv-select").value = "googlevideo";
		var videoid = RegExp.$1;
	}else if(url.match(/movieID=(.*)/)){
		var site="mncast";
		document.getElementById("getflv-select").value = "mncast";
		var videoid = RegExp.$1;
	}else if(url.match(/view.htm\?id=(.*)/)){
		var site="mgoon";
		document.getElementById("getflv-select").value = "mgoon";
		var videoid = RegExp.$1;
	}else if(url.match(/ch_userid=(.*)&url=(.*)&.+/)){
		var site="pandoratv";
		document.getElementById("getflv-select").value = "pandoratv";
		var videoid = RegExp.$1 + "|" + RegExp.$2;
	}else if(url.match(/ch_userid=(.*)&url=(.*)/) && !url.match(/ch_userid=(.*)&url=(.*)&.*/)){
		var site="pandoratv";
		document.getElementById("getflv-select").value = "pandoratv";
		var videoid = RegExp.$1 + "|" + RegExp.$2;
		
	}else if(url.match(/fuseaction=vids\.individual&videoid=(.*)/)){
		var site="myspace";
		document.getElementById("getflv-select").value = "myspace";
		var videoid = RegExp.$1;
	}else if(url.match(/fuseaction=vids\.individual&VideoID=(.*)/)){
		var site="myspace";
		document.getElementById("getflv-select").value = "myspace";
		var videoid = RegExp.$1;
	}else if(url.match(/spike\.com\/video\/(.*)/)){
		var site="spike";
		document.getElementById("getflv-select").value = "spike";
		var videoid = RegExp.$1;
	}else if(url.match(/break\.com\/(.*)/)){
		var site="break_com";
		document.getElementById("getflv-select").value = "break_com";
		var videoid = RegExp.$1;
	}else if(url.match(/media\.putfile\.com\/(.*)/)){
		var site="putfile";
		document.getElementById("getflv-select").value = "putfile";
		var videoid = RegExp.$1;
	}else if(url.match(/5min\.com\/Video\/(.*)/)){
		var site="5min";
		document.getElementById("getflv-select").value = "5min";
		var videoid = RegExp.$1;
	}else if(url.match(/NFPlayer\.swf\?vid=(.*)&outKey=(.*)/)){
		var site="naver";
		document.getElementById("getflv-select").value = "naver";
		var videoid = RegExp.$1 + "|" + RegExp.$2;
	}else if(url.match(/daum\.net\/flvPlayer\.swf\?vid=(.*)/)){
		var site="daum";
		document.getElementById("getflv-select").value = "daum";
		var videoid = RegExp.$1;
	}else if(url.match(/metacafe\.com\/watch\/(.*)/)){
		var site="metacafe";
		document.getElementById("getflv-select").value = "metacafe";
		var videoid = RegExp.$1;
	}else{
		return false;
	}

	document.getElementById("main-body-get-form-errors").innerHTML = "";

	document.getElementById("main-body-get-form-submit").style.display = 'none';
	document.getElementById("main-body-get-form-loader").style.display = 'inline';


	if(document.getElementById("main-body-result").style.display == 'inline'){
		document.getElementById("main-body-result").style.display = 'none';
	}


	var parameters = 'id='+ videoid +'&site=' + site;
	ajaxCallback = showResults;
	ajaxRequest("/act/act.getflv.php",parameters);

	return false;
}

function showResults(){
	var url = ajaxReq.responseXML.getElementsByTagName("url");
	var title = ajaxReq.responseXML.getElementsByTagName("title");
	var thumbnail = ajaxReq.responseXML.getElementsByTagName("thumbnail");
	var url_wmv = ajaxReq.responseXML.getElementsByTagName("url_wmv");
	var content = ajaxReq.responseXML.getElementsByTagName("content");

	if(url[0].firstChild.nodeValue !== "false"){
		url = url[0].firstChild.nodeValue;
	}else{
		url = false;
	}if(url_wmv[0].firstChild.nodeValue !== "false"){
		url_wmv = url_wmv[0].firstChild.nodeValue;
	}else{
		url_wmv = false;
	}if(title[0].firstChild.nodeValue !== "false"){
		title = title[0].firstChild.nodeValue;
	}else{
		title = false;
	}if(thumbnail[0].firstChild.nodeValue !== "false"){
		thumbnail = thumbnail[0].firstChild.nodeValue;
	}else{
		thumbnail = false;
	}if(content[0].firstChild.nodeValue !== "false"){
		content = content[0].firstChild.nodeValue;
	}else{
		content = false;
	}
	


	if(!url ||  !title || !thumbnail){
		document.getElementById("main-body-get-form-loader").style.display = 'none';
		document.getElementById("main-body-get-form-submit").style.display = 'inline'
		document.getElementById("main-body-get-form-errors").innerHTML = 'error';
		return false;
	}
	if(document.getElementById("getflv-select").value == "mgoon"){
		url = mgoon_decode(url);
	}
	
	document.getElementById("main-body-result").style.display = 'inline';
	
	
	
	var result_content = "<img src=\"" + thumbnail + "\" alt=\"" + title + "\" class=\"result_thumbnail\"><strong>" + title + "</strong><br /><a href=\"" + url + "\" class=\"download_link\">* " + download_link + " *</a> (.flv - flash video)";
	if(url_wmv){
		result_content += "<br /><a href=\"" + url_wmv + "\" class=\"download_link\">* " + download_link + " *</a> (.wmv - window media player)";
	}if(content){
		result_content += "<br /><br />" + content;
	}

	document.getElementById("main-body-result-content").innerHTML = result_content;
	

	document.getElementById("main-body-get-form-loader").style.display = 'none';
	document.getElementById("main-body-get-form-submit").style.display = 'inline';
}


document.getElementById("search").onsubmit = function(){
	var query = document.getElementById("search-input").value;

	if(!query || query == ""){
		document.getElementById("search-input").style.borderColor = "#ff0000";
		return false;
	}else{
		document.getElementById("search-input").style.borderColor = "#7f9db9";
	}
}