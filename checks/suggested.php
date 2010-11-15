<?php

// search for some bad things
class Suggested implements themecheck {
	protected $error = array();

	function check( $php_files, $css_files, $other_files) {

		// combine all the php files into one string to make it easier to search
	//	$php = implode(' ', $php_files);

		$ret = true;

		// things to check for
		$checks = array(

//'/get_the_time\((\s|)["|\'][A-Za-z\s]+(\s|)["|\']\)/' => 'get_the_time( get_option( \'date_format\' ) )',
'/[^get_]the_time\((\s|)["|\'][A-Za-z\s]+(\s|)["|\']\)/' => 'the_time( get_option( \'date_format\' ) )'
			);

		foreach ($php_files as $php_key => $phpfile) {
		foreach ($checks as $key => $check) {
		checkcount();
			if ( preg_match( $key, $phpfile, $matches ) ) {
			    $filename = basename($php_key);
				$error = esc_html( rtrim($matches[0],'(') );
$grep = tc_grep( rtrim($matches[0],'('), $php_key);
				$this->error[] = "RECOMMENDED<strong>{$error}</strong> was found in the file <strong>{$filename}</strong>. Use <strong>{$check}</strong> instead.{$grep}";
				$ret = false;
			}


		}

}
		return $ret;
	}

	function getError() { return $this->error; }
}

$themechecks[] = new Suggested;
