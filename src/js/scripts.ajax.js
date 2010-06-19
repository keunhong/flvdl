/********************************************************
*** flixey.com ajax library
*** contact: admin at flixey dot com
*** This script is the property of flixey.com, you may not copy, view, or distribute
*** this script in any form without prior consent of the administrator.
********************************************************/

var ajaxReq = false, ajaxCallback;

function ajaxRequest(filename,parameters){
	try{
		// Firefox, Opera 8.0+, Safari, IE7
		ajaxReq = new XMLHttpRequest();
	}catch(error){
		// IE5, IE6
		try{
			ajaxReq = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(error){
			try{
				ajaxReq = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(error){
				return false;
			}
		}
	}

	ajaxReq.open("POST",filename);

	// headers
	ajaxReq.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajaxReq.setRequestHeader("Content-length", parameters.length);
	ajaxReq.setRequestHeader("Connection", "close");

	ajaxReq.onreadystatechange = ajaxResponse;
	ajaxReq.send(parameters);
}

function ajaxResponse(){
	if(ajaxReq.readyState != 4){
		return;
	}
	if(ajaxReq.status == 200){ // request succeeded
		if(ajaxCallback) ajaxCallback();
	}else{
		alert("Request failed: " + ajaxReq.statusText);
	}
	return true;
}