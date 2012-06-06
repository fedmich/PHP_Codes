<?php
	function _convert_utf8($content) {
		if (!mb_check_encoding($content, 'UTF-8')
				OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))) {

			$content = mb_convert_encoding($content, 'UTF-8');
		}
		return $content;
	}
?>