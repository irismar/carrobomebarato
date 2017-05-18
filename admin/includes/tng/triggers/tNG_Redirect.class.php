<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

class tNG_Redirect {
	var $tNG;
	var $URL;
	var $keepUrlParams;
	
	function tNG_Redirect($tNG = null) {
		$this->tNG = $tNG;
	}
	
	function setURL($URL) {
		$this->URL = $URL;
		if (strpos($URL,"includes/nxt/back.php") !== false) {
			$this->URL = KT_makeIncludedURL($this->URL);
		}
	}
	
	function setKeepURLParams($keepUrlParams) {
		$this->keepUrlParams = $keepUrlParams;
	}
	
	function Execute() {
		if (!isset($this->tNG)) {
			$page = KT_DynamicData($this->URL,null,'rawurlencode');
		} else {
			$useSavedData = false;
			if ($this->tNG->getTransactionType()=='_delete' || $this->tNG->getTransactionType()=='_multipleDelete') {
				$useSavedData = true;
			}
			$page = KT_DynamicData($this->URL,$this->tNG,'rawurlencode',$useSavedData);
		}
		if ($this->keepUrlParams) {
			foreach($_GET as $param => $value) {
				$page = KT_addReplaceParam($page, $param, $value);
			}
		}
		KT_redir($page);
	}
}
?>