<?php
if(!defined("_included")) exit;
/***********************************************************************
***	class.getflv flv functions class
***********************************************************************/

class getflv{
	var $varname;
	var $varcontent;

	function setvar($varname,$varcontent){
		$this->$varname=$varcontent;
	}

	function openHTML(){
		$this->html = @file_get_contents($this->fetch_url);
	}

	function getVideo(){
		if(preg_match($this->reg, $this->html, $this->match)){
			$this->match_result = $this->match[$this->match_no];
		}else{
			return false;
		}
	}

	function getThumbnail(){
		if($this->thumbnail_direct){
			$this->result_thumbnail = $this->thumbnail_url_prefix.$this->video_id.$this->thumbnail_url_suffix;
		}else{
			preg_match($this->thumbnail_reg, $this->html, $this->thumbnail_match);
			$this->result_thumbnail = $this->thumbnail_match[$this->thumbnail_match_no];
		}
	}

	function getTitle(){
		if(preg_match($this->title_reg, $this->html, $this->title_match)){
			$this->result_title = $this->title_match[$this->title_match_no];
		}else{
			return false;
		}
	}

	function getContent(){
		if(preg_match($this->content_reg, $this->html, $this->content_match)){
			$this->result_content = $this->content_match[$this->content_match_no];
		}else{
			return false;
		}
	}

	function getRedirectedUrl(){
		$this->res = HTTP::head($this->result_url);
	    if (preg_match('/^3/', $this->res['response_code'])){
	        return $this->res['Location'];
	    }
	    return false;
	}

	function getResult(){
		if($this->extra_url){
			$this->result_url = $this->extra_url.$this->match_result;
		}else{
			$this->result_url = urldecode($this->match_result);
		}

		if($this->get_redirected_url){
			$this->result_url = $this->getRedirectedUrl();
		}

		$this->result = array(
			url => $this->result_url,
			title => $this->result_title,
			thumbnail => $this->result_thumbnail,
			content => $this->result_content
		);


		return $this->result;

	}

}