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
// Function to add some additional information to the AttachmentData element:
//================================================================================
function svg_styleJS($attachment, &$element)
{
	$element['thumbnail']['style_def'] = '';
	$element['thumbnail']['href2'] = $element['thumbnail']['href'];
	if ($attachment['thumb_mime'] == 'image/svg+xml')
	{
		$element['thumbnail']['href2'] .= '" class="thumb_' . $attachment['id_attach'];
		$element['thumbnail']['style_def'] = '<style>.thumb_' . $attachment['id_attach'] . ' { width: ' . $attachment['thumb_width'] . 'px; height: ' . $attachment['thumb_height'] . 'px; }</style>';
		$element['thumbnail']['javascript'] = 'return expandSVG(' . $attachment['id_attach'] . ');';
	}
}

//================================================================================
// Substitute function for getting width/height info from SVG file(s):
//================================================================================
function svg_getimagesize($filename, $svg_only = false)
{
	$size = @getimagesize($filename);
	if (!empty($size))
		return $svg_only ? false : $size;
	$file = file_get_contents($filename);
	if (preg_match('~(iframe|(?<!cellTextIs)html|eval|body|script\W|[CF]WS[\x01-\x0C])~i', $file))
		return false;
	if (!$file || !preg_match('~<\?xml version=(.+?)>*(<svg.+?>)~is', $file, $matches))
		return false;
	if (!preg_match('#width=(?:"?)(\d+)(?:")?#', $matches[2], $width) || !preg_match('#height=(?:"?)(\d+)(?:")?#', $matches[2], $height))
		return false;
	preg_match('#width-smf_thumb=(?:"?)(\d+)(?:")?#', $matches[2], $rwidth);
	preg_match('#height-smf_thumb=(?:"?)(\d+)(?:")?#', $matches[2], $rheight);
	$size = array(
		0 => isset($rwidth[1]) ? $rwidth[1] : $width[1],
		1 => isset($rheight[1]) ? $rheight[1] : $height[1],
		2 => 999,
		'mime' => 'image/svg+xml'
	);
	$size[3] = 'width="' . $size[0] . '" height="' . $size[1] . '"';
	if (isset($rwidth[1]))
		$size['real_width'] = $width[1];
	if (isset($rheight[1]))
		$size['real_height'] = $height[1];
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

//================================================================================
// Function to convert SVG image into a PNG (or JPG - non-preferred format) image:
// NOTE: Only available with ImageMagic extensions and PNG/JPG support functions!
//================================================================================
if (class_exists('Imagick') && (function_exists('imagecreatefrompng') || function_exists('imagecreatefromjpeg')))
{
	function imagecreatefromsvg($filename)
	{
		// Convert the SVG image into a PNG/JPEG file using ImageMagic:
		$svg = @file_get_contents($filename);
		if (!$svg)
			return false;
		$im = new Imagick();
		$im->readImageBlob($svg);
		$im->setImageFormat(function_exists('imagecreatefrompng') ? 'png24' : 'jpeg');
		$im->writeImage($filename);
		$im->clear();
		$im->destroy();

		// Now we need to read it into memory so that GD can process it:
		$func = 'imagecreatefrom' . (function_exists('imagecreatefrompng') ? 'png' : 'jpeg');
		return @$func($filename);
	}
}

//================================================================================
// Function for dealing with unthumbnailed existing SVG image attachments:
//================================================================================
function svg_findDimensions($pm = false)
{
	global $smcFunc;

	isAllowedTo('manage_attachments');
	$table = $pm ? 'pm_attachments' : 'attachments';

	// We're looking for attached SVG images that don't have the dimensions/mime type:
	$request = $smcFunc['db_query']('', '
		SELECT *
		FROM {db_prefix}' . $table . '
		WHERE filename LIKE {string:svg_image}
			AND width = {int:zero}
			AND height = {int:zero}',
		array(
			'svg_image' => '%.svg',
			'zero' => 0,
		)
	);
	while ($row = $smcFunc['db_fetch_assoc']($request))
	{
		// Get the image size information for the attachment:
		if ($pm)
			$filename = getPMAttachmentFilename($row['filename'], $row['id_attach'], $row['id_folder'], false, $row['file_hash']);
		else
			$filename = getAttachmentFilename($row['filename'], $row['id_attach'], $row['id_folder'], false, $row['file_hash']);
		$sizes = @svg_getimagesize($filename, true);

		// If this is a SVG image, update the attachment table so that the thumbs can be generated:
		if (isset($sizes[2]) && $sizes[2] == 999)
		{
			$smcFunc['db_query']('', '
				UPDATE {db_prefix}' . $table . '
				SET width = {int:width}, height = {int:height}, mime_type = {string:mime_type}
				WHERE id_attach = {int:id_attach}',
				array(
					'id_attach' => $row['id_attach'],
					'width' => $sizes[0],
					'height' => $sizes[1],
					'mime_type' => $sizes['mime'],
				)
			);
		}
	}
	$smcFunc['db_free_result']($request);
	redirectExit('action=admin;area=manageattachments;sa=maintenance');
}

function svg_findDimensionsPM()
{
	svg_findDimensions(true);
}

//================================================================================
// Functions to remove existing image dimensions from the posts attachments table:
//================================================================================
function svg_removeDimensions($pm = false)
{
	global $smcFunc;

	isAllowedTo('manage_attachments');
	$smcFunc['db_query']('', '
		UPDATE {db_prefix}' . ($pm ? 'pm_' : '') . 'attachments
		SET width = {int:zero}, height = {int:zero}
		WHERE filename LIKE {string:svg_image}',
		array(
			'zero' => 0,
			'svg_image' => '%.svg',
		)
	);
	redirectExit('action=admin;area=manageattachments;sa=maintenance');
}

function svg_removeDimensionsPM($pm = false)
{
	svg_removeDimensions(true);
}

?>