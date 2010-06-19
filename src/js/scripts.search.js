var _id="";
var _loader="";
var _status="idle";
function getVideo(id,site){
	if(_status == "busy"){
		alert("already working");
		return false;
	}else{
		_status = "busy";
	}
	_id = id;
	document.getElementById("dl_" + id).style.display = 'none';
	document.getElementById("loader_" + id).style.display = 'inline';
	var parameters = 'id='+ id +'&site=' + site;
	ajaxCallback = showResults;
	ajaxRequest("/act/act.search.getflv.php",parameters);

	return false;
}

function showResults(){
	var url = ajaxReq.responseXML.getElementsByTagName("url");
	if(url[0].firstChild.nodeValue !== "false"){
		url = url[0].firstChild.nodeValue;
	}
	document.getElementById("loader_" + _id).style.display = 'none';
	document.getElementById("dl_" + _id).style.display = 'inline';
	document.getElementById("dl_" + _id).innerHTML = '<a href="' + url + '">' + ln_download_link + '</a>';
	_status = "idle";
}