<?php
$SSI_INSTALL = false;
if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
{
	$SSI_INSTALL = true;
	require_once(dirname(__FILE__) . '/SSI.php');
}
elseif (!defined('SMF')) // If we are outside SMF and can't find SSI.php, then throw an error
	die('<b>Error:</b> Cannot install - please verify you put this file in the same place as SMF\'s SSI.php.');

$smcFunc['db_query']('', '
	UPDATE {db_prefix}attachments
	SET width = {int:zero}, height = {int:zero}
	WHERE mime_type LIKE {string:svg_mime}',
	array(
		'zero' => 0,
		'svg_mime' => 'image/svg+xml',
	)
);

// Echo that we are done if necessary:
if ($SSI_INSTALL)
	echo 'DB Changes should be made now...';
?>