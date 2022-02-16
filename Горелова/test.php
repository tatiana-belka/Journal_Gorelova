<?php
	$string = 'as^^$&.*@#$%^&*()+djfkjasdf@#%j123905zxcv../,';
	$pattern = '/[^@.a-zA-Z0-9]/';
	$replacement = '';
	$string = preg_replace($pattern, $replacement, $string);
	echo $string;
