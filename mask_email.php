<?php
	
	function mask_email( $email ) {
		/*
		Author: Fed
		Simple way of masking emails
		*/
		
		$char_shown = 3;
		
		$mail_parts = explode("@", $email);
		$username = $mail_parts[0];
		$len = strlen( $username );
		
		if( $len <= $char_shown ){
			return implode("@", $mail_parts );	
		}
		
		//Logic: show asterisk in middle, but also show the last character before @
		$mail_parts[0] = substr( $username, 0 , $char_shown )
			. str_repeat("*", $len - $char_shown - 1 )
			. substr( $username, $len - $char_shown + 2 , 1  )
			;
			
		return implode("@", $mail_parts );
	}
