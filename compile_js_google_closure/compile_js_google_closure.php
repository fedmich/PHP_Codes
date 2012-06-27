<?php

/*
  compile_js_google_closure 0.1
 */

function compile_js_google_closure($file) {
	$dest = str_replace('.js', '.min.js', $file);
	if (file_exists($dest)) {
		//already generated before
		return true;
	}
	if (!file_exists($file)) {
		return false;
	}

	$script = file_get_contents($file);
	if (!$script) {
		return false;
	}

	//$compilation_level = 'SIMPLE_OPTIMIZATIONS';
	$compilation_level = 'ADVANCED_OPTIMIZATIONS';

	$ch = curl_init('http://closure-compiler.appspot.com/compile');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "output_info=compiled_code&output_format=text&compilation_level=$compilation_level&js_code=" . urlencode($script));
	$output = curl_exec($ch);
	curl_close($ch);

	if ($output) {
		file_put_contents($dest, $output);
	}

	if (file_exists($dest)) {
		return true;
	}
}