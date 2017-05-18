<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	tNG_ImageUpload
DESCRIPTION:
	Provides functionalities for handling tNG based file uploads.	
**/
class tNG_ImageUpload extends tNG_FileUpload{
	var $resize;
	var $resizeProportional;
	var $resizeWidth;
	var $resizeHeight;
	
	function tNG_ImageUpload(&$tNG) {
		parent::tNG_FileUpload($tNG);
		$this->resize = false;
		$this->resizeProportional = true;
		$this->resizeWidth = 0;
		$this->resizeHeight = 0;
	}
	
	function setResize($proportional, $width, $height) {
		$this->resize = true;
		$this->resizeProportional = $proportional;
		$this->resizeWidth = (int)$width;
		$this->resizeHeight = (int)$height;
	}
	
	function deleteThumbnails($folder, $oldName) {
		if ($oldName != '') {
			$path_info = KT_pathinfo($oldName);
			$regexp = '/'.preg_quote($path_info['filename'],'/').'_\d+x\d+';
			if ($path_info['extension'] != "") {
				$regexp	.= '\.'.preg_quote($path_info['extension'],'/');
			}
			$regexp	.= '/';
		
			$folderObj = new KT_folder();
			$entry = $folderObj->readFolder($folder, false); 
			
			if (!$folderObj->hasError()) {
				foreach($entry['files'] as $key => $fDetail) {
					if (preg_match($regexp,$fDetail['name'])) {
						@unlink($folder.$fDetail['name']);
					}
				}  
			}
		}
	}
	
	function Execute() {
		$ret = parent::Execute();
		if ($ret === null && $this->resize && $this->uploadedFileName != '') {
			$ret = $this->Resize();
		}
		return $ret;
	}
	
	function Resize() {
		$ret = NULL;
		$image = new KT_image();
		$image->setPreferedLib($GLOBALS['tNG_prefered_image_lib']);
		$image->addCommand($GLOBALS['tNG_prefered_imagemagick_path']);
		$image->resize($this->dynamicFolder.$this->uploadedFileName, $this->dynamicFolder, $this->uploadedFileName, $this->resizeWidth, $this->resizeHeight, $this->resizeProportional);
		if ($image->hasError()) {
			$arrError = $image->getError();
			$errObj = new tNG_error('IMG_RESIZE', array(), array($arrError[1]));
			if ($this->dbFieldName != '') {
				$errObj->addFieldError($this->dbFieldName, 'IMG_RESIZE', array());
			}
			$ret = $errObj;
		}
		return $ret;
	}

	
}
?>