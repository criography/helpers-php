<?php


	/**
	 * getColourMultipliedImg
	 * creates an image with colour multiply blending mode. Can be cropped.
	 *
	 * @uses Imagick
	 * @param string $srcURL Full PATH from the docroot (no domain)
	 * @param string $suffix string attached to the filename. Defaults to '-blended'.
	 * @param string $colour hex value of a colour to be used for blending
	 * @param int $width destination width
	 * @param int $height destination height
	 * @param string $valign vertical align of the crop ('top' | 'middle' | 'bottom'). Defaults to top.
	 * @param int $jpg_quality Quality of JPEG compression, defaults to 75
	 * @param bool $forceOverwrite should the image be overwritten?
	 * @return string path to the blended image
	 */

	function getColourMultipliedImg($srcURL, $suffix='-blended', $colour='#ff0000', $width, $height, $valign, $jpg_quality=75, $forceOverwrite=false){

		$blendedURL   = preg_replace('/(\.jpg|\.jpeg)/i', $suffix.'$1', $srcURL);   /* absolute to the docroot, without the domain name */
		$srcPath      = $_SERVER['DOCUMENT_ROOT'].$srcURL;                          /* absolute to the server root */
		$blendedPath  = $_SERVER['DOCUMENT_ROOT'].$blendedURL;                      /* absolute to the server root */


		if(!file_exists($blendedPath) || (file_exists($blendedPath) && $forceOverwrite===true) ){

			if(file_exists($srcPath) && is_numeric($width) && is_numeric($height) && $width*$height>0){

				$img           = new Imagick($srcPath);
				$overlay       = new Imagick();

				/* generate overlay */
				$overlay->newImage($width, $height, new ImagickPixel($colour));
				$overlay->setImageFormat('png');

				/* define cropping coordinates */
				$x = round(($img->getimagewidth() - $width) * .5);
				$y = 0;
				if($valign==='middle'){
					$y = round(($img->getimageheight() - $height) * .5);

				}else if($valign==='bottom'){
					$y = $img->getImageHeight() - $height;

				}


				/* crop image*/
				$img->cropImage($width, $height, $x, $y);

				/* convert to grayscale */
				$img->modulateImage(100, 0, 100);

				/* set levels */
				$img->levelImage(3500, 2, 65535);

				/* multiply image */
				$img->compositeImage($overlay, imagick::COMPOSITE_MULTIPLY, 0, 0);


				/* compress image */
				$img->setImageCompression(Imagick::COMPRESSION_JPEG);
				$img->setImageCompressionQuality($jpg_quality);
				$img->setSamplingFactors(array(2, 1, 1));
				$img->stripImage();
				$img->normalizeImage();
				$img->unsharpMaskImage(0 , 0.75 , 1 , 0.05);
				$img->setInterlaceScheme(Imagick::INTERLACE_PLANE);

				/* save image */
				$img->writeImage($blendedPath);

			}
		}

		return $blendedURL;

	}
