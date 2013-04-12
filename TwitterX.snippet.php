<?php
/**
 * TwitterX
 *
 * This package loads Twitter feeds using the new (and very annoying) Twitter
 * 1.1 API. You will need to create a Twitter app and get the keys and tokens
 * by creating a new app here: https://dev.twitter.com/apps/new
 *
 * This uses twitteroauth: https://github.com/abraham/twitteroauth
 *
 * TwitterX is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * TwitterX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 
 * @author Stewart Orr @ Qodo Ltd <stewart@qodo.co.uk>
 * @version 0.9
 * @copyright Copyright 2012 by Qodo Ltd
 * With thanks to Sepiariver http://www.sepiariver.ca/
 */

// Twitter API keys and secrets
$twitter_consumer_key          = isset($twitter_consumer_key) ? $twitter_consumer_key : FALSE ;
$twitter_consumer_secret       = isset($twitter_consumer_secret) ? $twitter_consumer_secret : FALSE ;
$twitter_access_token          = isset($twitter_access_token) ? $twitter_access_token : FALSE ;
$twitter_access_token_secret   = isset($twitter_access_token_secret) ? $twitter_access_token_secret : FALSE ;

// Other options
$limit = isset($limit) ? $limit : 5 ;
$chunk = isset($chunk) ? $chunk : 'TwitterXTpl' ;
$timeline = isset($timeline) ? $timeline : 'user_timeline' ;
$cache = isset($cache) ? $cache : 7200 ;
$screen_name = isset($screen_name ) ? $screen_name : '' ;
$include_rts = isset($include_rts) ? $include_rts : 1 ;
$cache_id = isset($cache_id) ? $cache_id : 'TwitterX' ;
$toPlaceholder = isset($toPlaceholder) ? $toPlaceholder : '' ;

// Here we support an old error where the parameter was incorrect.
if (isset($twitter_consumer_token_secret)) {
	$twitter_access_token_secret = isset($twitter_consumer_token_secret) ? $twitter_consumer_token_secret : FALSE ;
}

// HTML output 
$output = '';

//**************************************************************************

// If they haven't specified the required Twitter keys, we cannot continue...
if (!$twitter_consumer_key || !$twitter_consumer_secret || !$twitter_access_token || !$twitter_access_token_secret) {

	echo "<strong>TwitterX Error:</strong> Could not load TwitterX as required values were not passed.";

} else {

	// Test for required function(s)
	if (!function_exists('curl_init')) {
			echo "<strong>TwitterX Error:</strong> cURL functions do not exist, cannot continue.";	
	} else {

		// Try loading the data from MODX cache first
		$json = $modx->cacheManager->get($cache_id . '_' .  $modx->resource->id); // Added ability to set custom cache IDs
		
		if (!$json) { 

			// Load the TwitterOAuth lib required if not exists
			if (!class_exists('TwitterOAuth')) {
				require_once $modx->getOption('core_path').'components/twitterx/twitteroauth/twitteroauth/twitteroauth.php';
			}
			// Create new twitteroauth
			$twitteroauth = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $twitter_access_token, $twitter_access_token_secret);

			// We want to use JSON format
			$twitteroauth->format = 'json';
			$twitteroauth->decode_json = FALSE;

			// Request statuses with optinal parameters
			$options = array(
				'count' => $limit+1,
				'include_rts' => $include_rts
			);
			// If we have a screen_name, pass this to Twitter API
			if ($screen_name != '') {
				$options['screen_name'] = $screen_name;
			}
			// If we are viewing favourites or regular statuses
			if ($timeline != 'favorites') {
				$timeline = 'statuses/' . $timeline;
			}
			$json = $twitteroauth->get($timeline, $options);
				
			// No errors? Save to MODX Cache
			if (!isset($json->error)) {
				$modx->cacheManager->set($cache_id . '_' .  $modx->resource->id, $json, $cache);
			}
	
		}
	
		// Decode this now that we have used it above in the cache
		$json = json_decode($json);
	
		// If there any errors from Twitter, output them...
		if (isset($json->error)) {
			
			echo "<strong>TwitterX Error:</strong> Could not load TwitterX Twitter responded with the error '" . $json->error . "'.";
			
		} else {
			
			// For each result, output it
			foreach ($json as $j) {
				
				// Get placerholder values
				$placeholders = array(
					'created_at' => $j->created_at,
					'source' => $j->source,
					'id' => $j->id,
					'id_str' => $j->id_str,
					'text' => $j->text,
					'name' => $j->user->name,
					'screen_name' => $j->user->screen_name,
					'profile_image_url' => $j->user->profile_image_url,
					'location' => $j->user->location,
					'url' => $j->user->url,
					'description' => $j->user->description,
				);
				// If this is a retweet, create placeholders for this too
				if (isset($j->retweeted_status)) {
					$placeholders = array_merge($placeholders, array(
						'retweet_count' => $j->retweeted_status->retweet_count,
						'retweet_created_at' => $j->retweeted_status->created_at,
						'retweet_source' => $j->retweeted_status->source,
						'retweet_id' => $j->retweeted_status->id,
						'retweet_id_str' => $j->retweeted_status->id_str,
						'retweet_text' => $j->retweeted_status->text,
						'retweet_name' => $j->retweeted_status->user->name,
						'retweet_screen_name' => $j->retweeted_status->user->screen_name,
						'retweet_profile_image_url' => $j->retweeted_status->user->profile_image_url,
						'retweet_location' => $j->retweeted_status->user->location,
						'retweet_url' => $j->retweeted_status->user->url,
						'retweet_description' => $j->retweeted_status->user->description,
						)
					);
				}
				// Parse chunk passing values
				$output .= $modx->getChunk($chunk, $placeholders); // Concatenate to output variable
			}
		
			// Added option to output to placeholder
			if ($toPlaceholder != '') {
				$modx->setPlaceholder($toPlaceholder, $output);
			} else {
				return $output;
			}
		}
	}
}