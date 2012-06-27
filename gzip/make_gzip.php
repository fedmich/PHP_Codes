<?php

/*
 * make_gzip 0.1
 */

function make_gzip($file) {
	$dest = "$file.gz";
	if (file_exists($dest)) {
		//already generated before
		return true;
	}
	if (!file_exists($file)) {
		return false;
	}

	if (!function_exists('gzencode')) {
		//gzip not available on this php server
		return false;
	}

	$content = file_get_contents($file);
	$contentx = gzencode($content, 6);
	file_put_contents($dest, $contentx);

	if (file_exists($dest)) {
		return true;
	}
}
