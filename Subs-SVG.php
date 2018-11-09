<?php
/**********************************************************************************
* Subs-SVG.php                                                                    *
***********************************************************************************
* This mod is licensed under the 2-clause BSD License, which can be found here:   *
*	http://opensource.org/licenses/BSD-2-Clause                                   *
***********************************************************************************
* This program is distributed in the hope that it is and will be useful, but	  *
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY	  *
* or FITNESS FOR A PARTICULAR PURPOSE.											  *
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

//================================================================================
// Substitute function for getting width/height info from SVG file(s):
//================================================================================
function svg_getimagesize($tmp_name)
{
	$size = @getimagesize($tmp_name);
	if (empty($size))
	{
		$file = @file_get_contents($tmp_name);
		$pattern = '~<\?xml version=(.+?)>*(<svg.+?>)~is';
		if (!$file || !preg_match($pattern, $file, $matches))
			return false;
		if (!preg_match('#width=(?:"?)(\d+)(?:")?#', $matches[2], $width) || !preg_match('#height=(?:"?)(\d+)(?:")?#', $matches[2], $height))
			return false;
		if (preg_match('#width-smf_thumb=(?:"?)(\d+)(?:")?#', $matches[2], $rwidth))
			$width[1] = $rwidth[1];
		if (preg_match('#height-smf_thumb=(?:"?)(\d+)(?:")?#', $matches[2], $rheight))
			$height[1] = $rheight[1];
		$size = array(
			0 => isset($rwidth[1]) ? $rwidth[1] : $width[1],
			1 => isset($rheight[1]) ? $rheight[1] : $height[1],
			2 => 999,
			3 => 'width="' . $width[1] . '" height="' . $height[1] . '"',
			'mime' => 'image/svg+xml'
		);
		if (isset($rwidth[1]))
			$size['real_width'] = $width[1];
		if (isset($rheight[1]))
			$size['real_height'] = $height[1];
	}
	return $size;
}

//================================================================================
// Function for "resizing" SVG files into attachments:
//================================================================================
function svg_resizeImage($destName, $src_width, $src_height, $max_width, $max_height)
{
	$file = file_get_contents($destName);
	$pattern = '~<\?xml version=(.+?)>*(<svg.+?>)~is';
	if (!$file || !preg_match($pattern, $file, $matches))
		return false;
	$msg = $matches[2];
	
	// Determine whether to resize to max width or to max height (depending on the limits.)
	if (!empty($max_width) || !empty($max_height))
	{
		if (!empty($max_width) && (empty($max_height) || $src_height * $max_width / $src_width <= $max_height))
		{
			$dst_width = $max_width;
			$dst_height = floor($src_height * $max_width / $src_width);
		}
		elseif (!empty($max_height))
		{
			$dst_width = floor($src_width * $max_height / $src_height);
			$dst_height = $max_height;
		}

		// Don't bother resizing if it's already smaller...
		if (!empty($dst_width) && !empty($dst_height) && ($dst_width < $src_width || $dst_height < $src_height || $force_resize))
		{
			if (preg_match('#width=(?:"?)(\d+)(?:")?#', $matches[2], $width))
				$msg = str_replace($width[0], $width[0] . ' width-smf_thumb="' . $dst_width . '"', $msg);
			if (preg_match('#height=(?:"?)(\d+)(?:")?#', $matches[2], $height))
				$msg = str_replace($height[0], $height[0] . ' height-smf_thumb="' . $dst_height . '"', $msg);
			$file = str_replace($matches[2], $msg, $file);
		}
	}

	// Save the image as ...
	$fp_destination = fopen($destName, 'wb');
	fwrite($fp_destination, $file);
	fclose($fp_destination);
	return true;
}

?>