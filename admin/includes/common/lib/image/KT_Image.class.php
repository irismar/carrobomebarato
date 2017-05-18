<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

/** 
Class definition
NAME:
	image
DESCRIPTION:
	manipulate images;	
**/
class KT_image
{
	var $arrCommands;			// array	-	keep the commands for ImageMagik	
	var $imgType;				// string	-	imgtype for GD manipulation (gif, jpg, png);
	var $errorType = array();				// array	-	error message to be displayed as User Error
	var $develErrorMessage = array();		// array	-	error message to be displayed as Developer Error
	var $orderLib = array();	// array	-	contains the name of the order of prefered libraries;
	var $gdInfo;				// string	-	magic number used for gd library
	var $gdNoSupport;			// string	-	string for which the GD has no support;

	function KT_image() {
		$this->arrCommands = array(
								"C:\\PROGRA~1\\IMAGEM~1\\",
								'/usr/bin/X11/',
								'/usr/X11R6/bin/'
							 );
		$this->orderLib = array('imagemagick','gd');
		$this->getVersionGd();
	}
	
	/**
	NAME:
		setPreferedLib()
	DESCRIPTION:
		change the order of the execution for libs;	
	ARGUMENTS:
		$lib			- string	- lib name: gd or imagemagick;
	RETURNS:
		Returns: nothing
	**/
	function setPreferedLib($lib)
	{
		$lib = strtolower($lib);
		if (in_array($lib, $this->orderLib)) {
			$i = array_search($lib, $this->orderLib);
			array_splice($this->orderLib, $i, 1);
		}
		array_unshift($this->orderLib, $lib);
	}
	
	/**
	NAME:
		addCommand()
	DESCRIPTION:
		prepend in front of the commands array a new command;	
	ARGUMENTS:
		$command			- string	- command;
	RETURNS:
		Returns: nothing
	**/
	function addCommand($command)
	{
		$command = trim($command);
		if ($command =='') {
			return;
		}
		if ( substr($command, -1, 1) != '/' && substr($command, -1, 1) != '\\' ) {
			$command .= DIRECTORY_SEPARATOR;
		}
		array_unshift($this->arrCommands, $command);
	}
	
	/**
	NAME:
		imageSize()
	DESCRIPTION:
		take a file name as the only argument and return an array conatining the image dimensions;	
	ARGUMENTS:
		$sourceFileName			- string	- path to the source file;
	RETURNS:
		Returns: [array] (x, y) on succes, [array] (-1, -1) on error
	**/
	function imageSize($sourceFileName)
	{
		$res = array(-1,-1);
		if (!is_file($sourceFileName)) {
			$this->setError('PHP_IMAGE_NO_IMG', array(), array($sourceFileName));
			return $res;
		}
		if (!is_readable($sourceFileName)) {
			$this->setError('PHP_IMAGE_READ_ERR', array(), array($sourceFileName));
			return $res;
		}
		
		$arr = @getimagesize($sourceFileName);
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
				case 2:
				case 3:
					$res = array($arr[0], $arr[1]);	 
					break;
			}	
		}
		return $res;
		
	}
	
	/**
	NAME:
		resize()
	DESCRIPTION:
		resize an image;	
	ARGUMENTS:
		$sourceFileName			- string	- path to the source file;
		$folder					- string	- path to the destination file (without filename);
		$destinationFileName	- string	- nama of the destination file
		$newWidth				- int		- new width of the file;
		$newHeight				- int		- new hight of the file;
		$keepProportion			- boolean	- if the proportion must be kept or not;
	RETURNS:
		Returns: nothing;
	**/
	function resize($sourceFileName, $folder, $destinationFileName, $width, $height, $keepProportion)
	{	
		$this->checkFolder($folder, 'write', 'image resize');
		$this->validateFile($sourceFileName, 'image resize');
		if ($this->hasError()) {
			return;
		}	
		if ($keepProportion === "false") {
			$keepProportion = false;
		}
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'resize_' . $lib;
			if ($rez = $this->$lib($sourceFileName, $folder, $destinationFileName, $width, $height, $keepProportion)) {
				KT_setFilePermissions($folder.$destinationFileName);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_RESIZE_NO_LIB', array(), array($this->getGdNoSupport()));
		}
	}
	
	/**
	NAME:
		resize_gd()
	DESCRIPTION:
		resize an image using GD library;	
	ARGUMENTS:
		$sourceFileName			- string	- path to the source file;
		$folder					- string	- path to the destination file (without filename);
		$destinationFileName	- string	- nama of the destination file
		$newWidth				- int		- new width of the file;
		$newHeight				- int		- new hight of the file;
		$keepProportion			- boolean	- if the proportion must be kept or not;
	RETURNS:
		Returns: nothing;
	**/
	function resize_gd($sourceFileName, $folder, $destinationFileName, $newWidth, $newHeight, $keepProportion)
	{
		$newWidth = (int)$newWidth;
		$newHeight = (int)$newHeight;
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($sourceFileName)) {
			return false;
		}
		$img = &$this->getImg($sourceFileName, 'resize');
		if ($this->hasError()) {
			return;
		}
		$srcWidth = ImageSX($img);
		$srcHeight = ImageSY($img);

		if ( $keepProportion && ($newWidth != 0 && $srcWidth<$newWidth) && ($newHeight!=0 && $srcHeight<$newHeight) ) {
			if ($sourceFileName != $folder . $destinationFileName) {
				@copy($sourceFileName, $folder . $destinationFileName);
			}
			return true;
		}
		
		if ($keepProportion == true) {
			if ($newWidth != 0 && $newHeight != 0) {
				$ratioWidth = $srcWidth/$newWidth; 
				$ratioHeight = $srcHeight/$newHeight; 
				if( $ratioWidth < $ratioHeight ){ 
					$destWidth = $srcWidth/$ratioHeight;
					$destHeight = $newHeight; 
				} else { 
					$destWidth = $newWidth; 
					$destHeight = $srcHeight/$ratioWidth; 
				}
			} else {
				if ($newWidth != 0) {
					$ratioWidth = $srcWidth/$newWidth; 
					$destWidth = $newWidth; 
					$destHeight = $srcHeight/$ratioWidth; 
				} else if ($newHeight != 0) {
					$ratioHeight = $srcHeight/$newHeight; 
					$destHeight = $newHeight; 
					$destWidth = $srcWidth/$ratioHeight; 
				} else {
					$destWidht = $srcWidth;
					$destHeight = $srcHeight;
				}
			}
		} else {
			$destWidth = $newWidth; 
			$destHeight = $newHeight; 
		}
		$destWidth = round($destWidth);
		$destHeight = round($destHeight);
		
		$destImage = &$this->getImageCreate($destWidth, $destHeight); 
		
		$this->getImageCopyResampled($destImage, $img, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
		ImageDestroy($img);
		$img = &$destImage;
		$this->createNewImg($img, $folder . $destinationFileName, 100);
		return true;
	}
	
	
	function resize_imagemagick($sourceFileName, $folder, $destinationFileName, $width, $height, $keepProportion)
	{
		if (!$this->checkImageMagik()) {
			return false;
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-sample',
							($width==0?"":$width) . 'x' . ($height==0?"":$height) . ($keepProportion==true?'>':'!'),
							$sourceFileName,
							$folder . $destinationFileName
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_RESIZE_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
		
	}
	
	/**
	NAME:
		adjustQuality()
	DESCRIPTION:
		adjust the Quality of an image;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$qualityLevel	- int		- the quality; 
	RETURNS:
		Returns: nothing;
	**/
	function adjustQuality($filename, $qualityLevel)
	{	
		$this->checkFolder($filename, 'write', 'adjust quality');
		$this->validateFile($filename, 'adjust quality');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'adjustQuality_' . $lib;
			if ($rez = $this->$lib($filename, $qualityLevel)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_ADJUST_QUAL_NO_LIB', array(), array($this->getGdNoSupport()));
		}
		
	}
	
	/**
	NAME:
		adjustQuality_gd()
	DESCRIPTION:
		adjust quality image (for jpg) using GD library;	
	ARGUMENTS:
		$sourceFileName	- string	- path to the picture;
		$qualityLevel 	- int		- the quality level 
	RETURNS:
		Returns: nothing;
	**/
	function adjustQuality_gd($sourceFileName, $qualityLevel)
	{
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($sourceFileName)) {
			return false;
		}
		$img = &$this->getImg($sourceFileName, 'adjust quality');
		if ($this->hasError()) {
			return;
		}
		$this->createNewImg($img, $sourceFileName, $qualityLevel);
		return true;
	}
	
	function adjustQuality_imagemagick($filename, $qualityLevel)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-quality',
							$qualityLevel,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_ADJUST_QUAL_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;	
		}
	}

	/**
	NAME:
		crop()
	DESCRIPTION:
		crop an image;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$x, $y			- int		- top left of the picture;
		$destWidth		- int		- width of the new picture;
		$destHeight 	- int		- height of the new picture
	RETURNS:
		Returns: nothing;
	**/
	function crop($filename, $x, $y, $width, $height)
	{
		$this->checkFolder($filename, 'write', 'crop');
		$this->validateFile($filename, 'crop');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'crop_' . $lib;
			if ($rez = $this->$lib($filename, $x, $y, $width, $height)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_CROP_NO_LIB', array(), array($this->getGdNoSupport()));
		}		
	}
	
	/**
	NAME:
		grop_gd()
	DESCRIPTION:
		crop an image using GD library;	
	ARGUMENTS:
		$sourceFileName	- string	- path to the picture;
		$x, $y			- int		- top, left of the picture;
		$destWidth		- int		- width of the new picture;
		$destHeight 	- int		- height of the new picture
	RETURNS:
		Returns: nothing;
	**/
	function crop_gd($sourceFileName, $x, $y, $destWidth, $destHeight)
	{	
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($sourceFileName)) {
			return false;
		}
		$img = &$this->getImg($sourceFileName, 'crop');
		$srcWidth = ImageSX($img); 
		$srcHeight = ImageSY($img); 
		$destImage = &$this->getImageCreate($destWidth, $destHeight);
		
		$this->getImageCopyResampled($destImage, $img, 0, 0, $x, $y, $destWidth, $destHeight, $destWidth, $destHeight);
		ImageDestroy($img);
		$this->createNewImg($destImage, $sourceFileName, 100);
		return true;
	}
	
	function crop_imagemagick($filename, $x, $y, $width, $height)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-crop',
							$width .'x'. $height .'+'. $x .'+'. $y,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_CROP_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	/**
	NAME:
		rotate()
	DESCRIPTION:
		rotate an image;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$degree			- int		- degrees to rotate the image clockwise;
	RETURNS:
		Returns: nothing;
	**/
	function rotate($filename, $degree)
	{
		$this->checkFolder($filename, 'write', 'rotate');
		$this->validateFile($filename, 'rotate');
    	$this->validateDegree($degree);
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'rotate_' . $lib;
			if ($rez = $this->$lib($filename, $degree)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_ROTATE_NO_LIB', array(), array($this->getGdNoSupport()));
		}
	}
	
	/**
	NAME:
		rotate_gd()
	DESCRIPTION:
		rotate an image using GD library;	
	ARGUMENTS:
		$sourceFileName	- string	- path to the picture;
		$degree			- int		- degrees to rotata, clockwise;
	RETURNS:
		Returns: nothing;
	**/
	function rotate_gd($sourceFileName, $degree)
	{	
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($sourceFileName)) {
			return false;
		}
		$img = &$this->getImg($sourceFileName, 'rotate');
		$srcWidth = ImageSX($img); 
		$srcHeight = ImageSY($img);
		if ($srcWidth>$srcHeight) {
			$newd = $srcWidth;
			$corection = $srcWidth - $srcHeight;
			$landscape = 1;
		} else {
			$newd = $srcHeight;
			$corection = $srcHeight - $srcWidth;
			$landscape = 0;
		}			
		$degree = 360 - $degree;
				
		switch ($degree) {
			case 360:
			case 0:
				$w = $srcWidth;
				$h = $srcHeight;
				$x1 = 0;
				$y1 = 0;
				break;
			case 180:
				$w = $srcWidth;
				$h = $srcHeight;
				if ($landscape) {
					$x1 = 0;
					$y1 = $corection;
				} else {	
					$x1 = $corection;
					$y1 = 0;
				}
				break;
			case 90:
				$w = $srcHeight;
				$h = $srcWidth;
				if ($landscape) {
					$x1 = 0;
					$y1 = 0;
				} else {
					$x1 = 0;
					$y1 = $corection;
				}
				break;
			case 270:
				$w = $srcHeight;
				$h = $srcWidth;
				if ($landscape) {
					$x1 = $corection;
					$y1 = 0;
				} else {
					$x1 = 0;
					$y1 = 0;
				}
				break;
		}

		$destImage = &$this->getImageCreate($newd, $newd);
		$finalImage = &$this->getImageCreate($w,$h);
		
		$this->getImageCopyResampled($destImage, $img, 0, 0, 0, 0, $srcWidth, $srcHeight, $srcWidth, $srcHeight);
		$rotatedImage = ImageRotate($destImage, $degree, 0);
		$this->getImageCopyResampled($finalImage, $rotatedImage, 0, 0, 0 + $x1, 0 + $y1, $w, $h, $w, $h);
		
		ImageDestroy($img);
		$this->createNewImg($finalImage, $sourceFileName, 100);
		return true;
	}
	
	function rotate_imagemagick($filename, $degree)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-rotate',
							$degree,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);
	
		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_ROTATE_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	/**
	NAME:
		validateDegree()
	DESCRIPTION:
		rotate an image;	
	ARGUMENTS:
		$degree			- int		- degrees to rotate the image clockwise;
	RETURNS:
		Returns: nothing;
	**/
	function validateDegree($degree)
	{
		switch ($degree) {
			case 0:
			case 180:
			case 90:
			case 270:
			case 360:
				break;
			default:
				$this->setError('PHP_IMAGE_ROTATE_DEG_ERR', array(), array());
				break;
		}
    return;
  }


	/**
	NAME:
		flip()
	DESCRIPTION:
		flip an image horisontally or vertically;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$direction		- string	- how to flip horisontal or vertical;
	RETURNS:
		Returns: nothing;
	**/
	function flip($filename, $direction)
	{
		$this->checkFolder($filename, 'write', 'flip');
		$this->validateFile($filename, 'flip');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'flip_' . $lib;
			if ($rez = $this->$lib($filename, $direction)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_FLIP_NO_LIB', array(), array());
		}		
	}
	
	function flip_gd($filename, $direction)
	{
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($filename)) {
			return false;
		}
		$srcImage = $this->getImg($filename, 'flip');
		$srcWidth = ImageSX($srcImage);
		$srcHeight = ImageSY($srcImage);
		$destImage = $this->getImageCreate($srcWidth, $srcHeight);
		
		if (strtolower($direction)=='vertical') {
			for ($x = 0; $x < $srcWidth; $x++) {
				for ($y = 0; $y < $srcHeight; $y++) {
					imagecopy($destImage, $srcImage, $x, $srcHeight - $y - 1, $x, $y, 1, 1);
				}
			}
		} else {
			for ($x = 0; $x < $srcWidth; $x++) {
				for ($y = 0; $y < $srcHeight; $y++) {
					imagecopy($destImage, $srcImage, $srcWidth - $x - 1, $y, $x, $y, 1, 1);
				}
			}
		}
		ImageDestroy($srcImage);
		$this->createNewImg($destImage, $filename, 100);
		return true;
	}
	
	function flip_imagemagick($filename, $direction)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		if (strtolower($direction)=='vertical') {
			$arg = '-flip';
		} else {
			$arg = '-flop';
		}
		$arrArguments = array(
							$arg,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_FLIP_ERR', array($arr[0]), array($arr[1]));
		} 	else {
			return true;
		}
		
	}
	
	/**
	NAME:
		sharpen()
	DESCRIPTION:
		apply an unsharp mask on the image;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
	RETURNS:
		Returns: nothing;
	**/
	function sharpen($filename, $intensity = 5)
	{
		$intensity = 1;
		$this->checkFolder($filename, 'write', 'sharpen');
		$this->validateFile($filename, 'sharpen');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'sharpen_' . $lib;
			if ($rez = $this->$lib($filename, $intensity)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_SHARPEN_NO_LIB', array(), array());
		}		
	}
	
	function sharpen_gd($filename, $intensity = 5)
	{
		return false;
	}
	
	function sharpen_imagemagick($filename, $intensity = 5)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-sharpen',
							'3x' . $intensity,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_SHARPEN_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	
	/**
	NAME:
		blur()
	DESCRIPTION:
		apply an gaussian blur mask on the image;	
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$intensity		- int - intensity of the filter;
	RETURNS:
		Returns: nothing;
	**/
	function blur($filename, $intensity = 1)
	{
		$intensity = 1;
		$this->checkFolder($filename, 'write', 'blur');
		$this->validateFile($filename, 'blur');
		if ($this->hasError()) {
			return;
		}
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'blur_' . $lib;
			if ($rez = $this->$lib($filename, $intensity)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_BLUR_NO_LIB', array(), array());
		}		
	}
	
	function blur_gd($filename, $intensity = 1)
	{
		if (substr(PHP_VERSION, 0, 1) < 5) {
			return false;
		}
		if (!function_exists('imagefilter')) {
			return false;
		}
		
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($filename)) {
			return false;
		}
		
		$srcImage = $this->getImg($filename, 'blur');
		ImageFilter($srcImage, IMG_FILTER_GAUSSIAN_BLUR);
		$this->createNewImg($srcImage, $filename, 100);
		return true;
	}
	
	function blur_imagemagick($filename, $intensity = 1)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		$arrArguments = array(
							'-blur',
							$intensity,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);

		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_BLUR_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	
	/**
	NAME:
		contrast()
	DESCRIPTION:
		increase or decrease the contrast of an image;
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$direction	- string	- increase or decrease;
	RETURNS:
		Returns: nothing;
	**/
	function contrast($filename, $direction)
	{
		$this->checkFolder($filename, 'write', 'contrast');
		$this->validateFile($filename, 'contrast');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'contrast_' . $lib;
			if ($rez = $this->$lib($filename, $direction)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_CONTRAST_NO_LIB', array(), array());
		}		
	}
	
	function contrast_gd($filename, $direction)
	{
		if (substr(PHP_VERSION, 0, 1) < 5) {
			return false;
		}
		if (!function_exists('imagefilter')) {
			return false;
		}
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($filename)) {
			return false;
		}
		
		$srcImage = $this->getImg($filename, 'contrast');
		if (strtolower($direction)=='decrease') {
			$arg = 5;
		} else {
			$arg = -5;
		}
		ImageFilter($srcImage, IMG_FILTER_CONTRAST, $arg);
		$this->createNewImg($srcImage, $filename, 100);
		return true;
	}
	
	function contrast_imagemagick($filename, $direction)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		if (strtolower($direction)=='decrease') {
			$arg = '+contrast';
		} else {
			$arg = '-contrast';
		}
		$arrArguments = array(
							$arg,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);
		
		if ($shell->hasError()) {
			$arr = $shell->getError();
			$this->setError('PHP_IMAGE_CONTRAST_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	
	/**
	NAME:
		brightness()
	DESCRIPTION:
		increase or decrease the brightness of an image;
	ARGUMENTS:
		$filename		- string	- path to the source file;
		$direction	- string	- increase or decrease;
	RETURNS:
		Returns: nothing;
	**/
	function brightness($filename, $direction)
	{
		$this->checkFolder($filename, 'write', 'brightness');
		$this->validateFile($filename, 'brightness');
		if ($this->hasError()) {
			return;
		}
		
		foreach ($this->orderLib as $key => $lib) {
			$lib = 'brightness_' . $lib;
			if ($rez = $this->$lib($filename, $direction)) {
				KT_setFilePermissions($filename);
				break;
			}
		}
		
		if ($rez!=true) {
			$this->setError('PHP_IMAGE_BRIGHTNESS_NO_LIB', array(), array());
		}		
	}
	
	function brightness_gd($filename, $direction)
	{
		if (substr(PHP_VERSION, 0, 1) < 5) {
			return false;
		}
		if (!function_exists('imagefilter')) {
			return false;
		}
		if (!$this->gdInfo >= 1 || !$this->checkGdFileType($filename)) {
			return false;
		}
		
		$srcImage = $this->getImg($filename, 'brightness');
		if (strtolower($direction)=='decrease') {
			$arg = -6;
		} else {
			$arg = 6;
		}
		ImageFilter($srcImage, IMG_FILTER_BRIGHTNESS, $arg);
		$this->createNewImg($srcImage, $filename, 100);
		return true;
	}
	
	function brightness_imagemagick($filename, $direction)
	{
		if (!$this->checkImageMagik()) {
			return false;	
		}
		$shell = new KT_shell();
		$arrCommands = $this->arrCommands;
		if (strtolower($direction)=='decrease') {
			$arg = '95';
		} else {
			$arg = '105';
		}
		$arrArguments = array(
							'-modulate',
							$arg,
							$filename,
							$filename
							);
		$shell->execute($arrCommands, $arrArguments);
		
		if ($shell->hasError()) {
			$arr = $shell->getError();
			print_r($arr);
			$this->setError('PHP_IMAGE_BRIGHTNESS_ERR', array($arr[0]), array($arr[1]));
		} else {
			return true;
		}
	}
	
	
	/**
	NAME:
		getImg()
	DESCRIPTION:
		return an image handle or set an error if not succeded;	
	ARGUMENTS:
		$sourceFileName			- string	- path to the source file;
	RETURNS:
		Returns: int - image handle to the image if succeded or set error;
	**/
	function getImg($sourceFileName, $from)
	{
		$arr = getimagesize($sourceFileName);
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
					if (function_exists('imagecreatefromgif')) {
						$img = imagecreatefromgif($sourceFileName);
						$this->imgType = 'gif';
						return $img;
					} else {
						$this->setError('PHP_IMAGE_NO_TYPE_SUPPORT', array($from), array($from, 'GIF'));
					}
					break;
				case 2:
					if (function_exists('imagecreatefromjpeg')) {
						$img = imagecreatefromjpeg($sourceFileName);
						$this->imgType = 'jpg';
						return $img;
					} else {
						$this->setError('PHP_IMAGE_NO_TYPE_SUPPORT', array($from),  array($from, 'JPG'));
					}
					break;
				case 3:
					if (function_exists('imagecreatefrompng')) {
						$img = imagecreatefrompng($sourceFileName);
						$this->imgType = 'png';
						return $img;
					} else {
						$this->setError('PHP_IMAGE_NO_TYPE_SUPPORT', array($from), array($from, 'PNG'));
					}
					break;
				default:
					$this->setError('PHP_IMAGE_UNKNOWN_TYPE', array($from), array($from));
					break;
			}	
		} else {
			$this->setError('PHP_IMAGE_UNKNOWN_TYPE', array($from), array($from));
		}
	}
	
	/**
	NAME:
		validateFile()
	DESCRIPTION:
		check if file exists;
		validate the file; suported format jpg, gif, png;	
	ARGUMENTS:
		$filename			- string	- path to the source file;
	RETURNS:
		Returns: boolean - true if supported filetype/false otherwise;
	**/
	function validateFile($filename, $from)
	{
		if ($filename == "" || !file_exists($filename)) {
			$this->setError('PHP_IMAGE_NO_IMG_ERR', array($from), array($from, $filename));
			return false;
		}
		
		$arr = @getimagesize($filename);
		$res = false;
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
				case 2:
				case 3:
					$res = true;
					break;
			}	
		}
		if (!$res) {
			$this->setError('PHP_IMAGE_INV_IMG', array($from), array($from, $filename));
		}
		return $res;
	}
	
	/**
	NAME:
		checkGdFileType()
	DESCRIPTION:
		check if GD support the type of picture;	
	ARGUMENTS:
		$sourceFileName			- string	- path to the source file;
	RETURNS:
		Returns: boolean - true if GD support the type of picture false if not;
	**/
	function checkGdFileType($filename)
	{
		$arr = @getimagesize($filename);
		$res = false;
		if (is_array($arr)) {
			switch ($arr[2]) {
				case 1:
					if (function_exists('imagecreatefromgif') && function_exists('imagegif')) {
						$this->gdNoSupport = 'GIF';
						$res = true;
					} 
					break;
				case 2:
					if (function_exists('imagecreatefromjpeg') && function_exists('imagejpeg')) {
						$this->gdNoSupport = 'JPG';
						$res = true;
					} 
					break;
				case 3:
					if (function_exists('imagecreatefrompng') && function_exists('imagepng')) {
						$this->gdNoSupport = 'PNG';
						$res = true;
					} 
					break;
			}	
		}
		return $res;
	}

	function getGdNoSupport()
	{
		if ($this->gdNoSupport!='') {
			return KT_getResource('PHP_IMAGE_GD_SUPPORT', 'Image', array($this->gdNoSupport));
			$this->gdNoSupport = '';
		} else {
			return '';
		}
	}
		
	/**
	NAME:
		getImageCreate()
	DESCRIPTION:
		wrapper for imagecreatetruecolor/imagecreate;	
	ARGUMENTS:
		$destWidth		- int		- widh of the file;
		$destHeight		- int		- height of the  file;
	RETURNS:
		Returns: int - image handle;
	**/
	function getImageCreate($destWidth, $destHeight)
	{
		if (function_exists('imagecreatetruecolor') && $this->gdInfo>=2) {
			$image = @imagecreatetruecolor($destWidth, $destHeight); 
		} else {
			$image = @imagecreate($destWidth, $destHeight); 
		}
		return $image; 
	}
	
	/**
	NAME:
		getImageCopyResampled()
	DESCRIPTION:
		wrapper for ImageCopyResampled/ImageCopyResized;	
	ARGUMENTS:
		$destImage		- int		- image handle for destination image;
		$img 			- int		- image handle of source image;	
		$x1, $y1		- int		- x,y from top left for destination image;
		$x2, $y2		- int		- x,y from top left for source image;
		$destWidth		- int		- widh for destination file;
		$destHeight		- int		- height for destination file;
		$srcWidth		- int		- widh for source file;
		$srcHeight		- int		- height for source file;
	RETURNS:
		Returns: nothing;
	**/
	function getImageCopyResampled(&$destImage, &$img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight)
	{
		if (function_exists('imagecopyresampled') && $this->gdInfo>=2) {
			@ImageCopyResampled($destImage, $img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight);
		} else {
			@ImageCopyResized($destImage, $img, $x1, $y1, $x2, $y2, $destWidth, $destHeight, $srcWidth, $srcHeight);
		}	
	}
	
	/**
	NAME:
		createNewImg()
	DESCRIPTION:
		create the files and saved;	
	ARGUMENTS:
		$img 			- int		- image handle;	
		$file			- string	- filename (including path), to save the
		$qualityLevel	- int		- quality level (used with jpg pictures)
	RETURNS:
		Returns: nothing;
	**/
	function createNewImg(&$img, $file, $qualityLevel='')
	{
		switch ($this->imgType) {
			case 'gif':
				imagegif($img, $file);
				break;
			case 'jpg':
				if ($qualityLevel>0) {
					imagejpeg($img, $file, $qualityLevel);
				} else {			
					imagejpeg($img, $file);
				}
				break;
			case 'png':
				imagepng($img, $file);
				break;
		}	
		imagedestroy($img);
	}
	
	/**
	NAME:
		getVersionGd()
	DESCRIPTION:
		return the version of the GD;	
	ARGUMENTS:
		none
	RETURNS:
		Returns: [int] - version number of the installed GD;
	**/
	function getVersionGd()
	{
		
		ob_start();
		phpinfo(8);
		$phpinfo = ob_get_contents();
		ob_end_clean();
		$phpinfo = strip_tags($phpinfo);
		$phpinfo = stristr($phpinfo, "gd version");
		$phpinfo = stristr($phpinfo, "version");
		$end = strpos($phpinfo, ".");
		$phpinfo = substr($phpinfo, 0, $end);
		$length = strlen($phpinfo) - 1;
		$phpinfo = substr($phpinfo, $length);
		$this->gdInfo = $phpinfo;
		return $phpinfo;
	}
	
	/**
	NAME:
		checkImageMagik()
	DESCRIPTION:
		check if imagemagik is installed;	
	ARGUMENTS:
		none
	RETURNS:
		Returns: [boolean] - true if is installed or false if not;
	**/
	function checkImageMagik() {
		for ($i=0; $i<count($this->arrCommands) ;$i++) {
			$this->arrCommands[$i] .= 'convert';
		}
		if (!isset($GLOBALS["tNG"]["imagemagick"])) {
			$shell = new KT_shell();
			$arrCommands = $this->arrCommands;
			$arrArguments = array("");
			$output = $shell->execute($arrCommands, $arrArguments);
			
			if ($shell->hasError()) {
				$GLOBALS["tNG"]["imagemagick"] = false;
			} else {
				if ($output!='') {
					$GLOBALS["tNG"]["imagemagick"] = true;
				} else {
					$GLOBALS["tNG"]["imagemagick"] = false;	
				}
			}
		}
		return $GLOBALS["tNG"]["imagemagick"];
	}
	
	/**
	NAME:
		checkFolder()
	DESCRIPTION:
		Check if the folder exists and has write permissions.
		If the folder does not exists, try to create it.
		If the folder does not have write permissions or if could not create it, set error.
	ARGUMENTS:
		- $path		- string	- the path;
		- $right	- string	- the right to check;
		- $from		- string	- from what function is called;
	RETURNS:
		nothing
	**/
	function checkFolder($path, $right, $from) {
		if (strtolower(substr(PHP_OS, 0, 1))=='w') {
			$path = str_replace('/', '\\', $path);
		}
		if (preg_match("/\./ims",$path)) {
			$arr = split("[/\]", $path);
			array_pop($arr);
			$path = implode(DIRECTORY_SEPARATOR, $arr);
		}
		
		$folder = new KT_folder();
		$folder->createFolder($path);
		if ($right!='') {
			$res = $folder->checkRights($path, $right);
			if ($res !== true) {
				$this->setError('PHP_IMAGE_CHECK_FOLDER_ERROR', array($from), array($from, $path, $right));
			}
		}
		if ($folder->hasError()) {
			$arr = $folder->getError();
			$this->setError('PHP_IMAGE_FOLDER_ERROR', array($from, $arr[0]), array($from, $arr[1]));
		}
	}
	
	/**
	NAME:
		setError()
	DESCRIPTION:
		set error for developper and user.
	ARGUMENTS:
		- $errorCode		- string	- error message code;
		- $arrArgsUsr		- array		- array with optional parameters for sprintf functions.
		- $arrArgsDev		- array		- array with optional parameters for sprintf functions.
	RETURNS:
		- nothing
	**/
	function setError($errorCode, $arrArgsUsr, $arrArgsDev)
	{
		$errorCodeDev = $errorCode;
		if ( !in_array($errorCodeDev, array('', '%s')) ) {
			$errorCodeDev .= '_D';
		}
		if ($errorCode!='') {
			$this->errorType[] = KT_getResource($errorCode, 'Image', $arrArgsUsr);
		} else {
			$this->errorType = array();
		}
		if ($errorCodeDev!='') {
			$this->develErrorMessage[] = KT_getResource($errorCodeDev, 'Image', $arrArgsDev);
		} else {
			$this->develErrorMessage = array();
		}
	}
	
	/**
	NAME:
		hasError()
	DESCRIPTION:
		check if an error was setted.
	ARGUMENTS:
		none
	RETURNS:
		- boolean - true if error is set or false if not;
	**/
	function hasError()
	{	
		if (count($this->errorType)>0 || count($this->develErrorMessage)>0) {
			return 1;	
		}	
		return 0;
	}
		
	/**
	NAME:
		getError()
	DESCRIPTION:
		return the errors setted.
	ARGUMENTS:
		none
	RETURNS:
		- array - 0=>error for user, 1=>error for developer;
	**/	
	function getError()
	{
		return array(implode('<br />', $this->errorType), implode('<br />', $this->develErrorMessage));	
	}

}
?>