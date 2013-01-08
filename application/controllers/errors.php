<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * @author Suraj Kumar Adhikari <surajadhikari1929@gmail.com>
 *
 */
class Errors extends CI_Controller
{
	/**
	 * 404 Page Not Found Handler
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	public function show_404($page = '')
	{
		$heading = "404 Page Not Found";
		$message = array('Sorry, the page you requested was not found. ');

		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
		{
			/*
			 * Broken link somewhere, so send an email and display the right info to the user.
			 *
			 */
			$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);

			log_message('1', '404 referrer = ' . $referer);

			/*
			 * Search engines to look out for, should account for around 98-99% of searches
			 *
			 */
			$search_engines = array(
				'www.google.',
				'search.yahoo.',
				'bing.',
				'ask.',
				'alltheweb.',
				'altavista.',
				'search.aol',
				'baidu.'
			);

			if(strpos($referer, 'localhost') !== FALSE) // is it a broken internal link?
			{
				$message[0] .= 'It looks like we have a broken link on the site - we have been notified and we\'ll get it fixed as soon as possible.';
			}
			else
			{
				$source_text = 'another site';

				foreach($search_engines as $search_engine)
				{
					if(strpos($referer, $search_engine) !== FALSE) // bad search engine result?
					{
						$source_text = 'a search engine';
						break; // no point continuing to loop once we have found a match
					}
				}

				$message[0] .= 'It looks like you came from ' . $source_text . ' with a broken link - we have been notified and we\'ll get it fixed as soon as possible.';
			}

			$message[] = 'In the meantime, why not go to ' . anchor('', 'Front page');

		}
		else // no referer, so probably came direct
		{
			$message[0] .= 'It looks like you came directly to this page, either by typing the URL or from a bookmark. Please make sure the address you have typed or bookmarked is correct - if it is, then unfortunately the page is no longer available.';
			$message[] 	 =  'But all is not lost - why not go to ' . anchor('', 'Front page');
		}

		log_message('error', '404 Page Not Found --> '.$page);
		echo show_error($message, 404);
		exit;
	}

}