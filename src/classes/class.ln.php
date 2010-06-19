<?php
if(!defined("_included")) exit;
/***********************************************************************
***	class.ln language class
***********************************************************************/


class ln{
	var $varname;
	var $varcontent;

	function setvar($varname, $varcontent){
		$this->$varname=$varcontent;
	}
}

?>