<?php


if ( ! function_exists('cache_control'))
{
	/**
	 * Cache Control Helper
	 */
	function cacheControl()
	{
		$ci =& get_instance();
		
		//Controlling Brower cache
		$ci->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT')
					->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0')
					->set_header('Cache-Control: post-check=0, pre-check=0', FALSE)
					->set_header('Pragma: no-cache');
	}
}
