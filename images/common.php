<?php


/**
 * base64_encode_image
 * based on: http://php.net/manual/en/function.base64-encode.php#105200
 *
 * @param $path	string
 * @return 	string
 */
	function base64_encode_image ($path=false, $fileType=false) {
		$output = false;

		if ($path) {
			$data = fread(fopen($path, "r"), filesize($path));

			if(!$fileType){
				$fileType = new finfo(FILEINFO_MIME_TYPE);
				$fileType = $fileType->file($path);
			}else{
				$fileType = 'image/' . $fileType;
			}

			$output = 'data:' . $fileType . ';base64,' . base64_encode($data);
		}

		return $output;
	}









/**
 * inlineSVG
 * loads external SVG and inlines it in HTML
 *
 * @param string $path Path to the SVG
 * @return mixed SVG string or false
 */

function inlineSVG($path){
	$svg = false;

	if(file_exists($path)){

		$doc = new DOMDocument();
		$doc->load($path);
		$svg = (string) $doc->saveXML();
		$svg = preg_replace('(<\?xml.*?\?>)', '', $svg);
	}

	return $svg;
}