TwitterX v1.4.0
===============

This uses twitteroauth v3.1.0: https://github.com/abraham/twitteroauth for 
support for PHP 7.3 and 8.0+.

As twitteroauth only supports PHP versions that are actively supported, the next 
version of TwitterX will drop support for 7.3 and add support for 8.1. For more 
information, you can review the releases list at: https://github.com/abraham/twitteroauth/releases

This package loads Twitter feeds using the 1.1 API. You will need to create a 
Twitter app here:

https://dev.twitter.com/apps/new

Once you've created your new application you will need to generate tokens and 
use those tokens when you call the TwitterX snippet which will load your 
statuses:

Snippet TwitterX
----------------

This should be called uncached if you are using :ago in the chunk otherwise it 
can be cached.

[[!TwitterX?
    &twitter_consumer_key=`aaaa`
    &twitter_consumer_secret=`bbbb`
    &twitter_access_token=`cccc`
    &twitter_access_token_secret=`dddd`
    &limit=`4`
    &timeline=`user_timeline`
    &chunk=`TwitterXTpl`
    &cache=`7200`
    &screen_name=`Qodo,Microsoft`
    &include_rts=`1`
]]

* twitter_consumer_key - your twitter consumer token (REQUIRED)
* twitter_consumer_secret - your twitter consumer secret (REQUIRED)
* twitter_access_token - your twitter access token (REQUIRED)
* twitter_access_token_secret - your twitter access token secret (REQUIRED)
* limit - limit how many statuses to display (default: 5)
* timeline - which twitter timeline to load (default: user_timeline, retweeted_by_me etc)
* chunk - which chunk to load when rendering the statuses (default: TwitterXTpl)
* cache - how many seconds to cache the twitter data feed (default: 7200)
* screen_name - which user you want to load
* include_rts - should this include retweets (default: 1)
* cache_id - unique ID for caching in case you want to view multiple feeds or different feeds (default: TwitterX_PAGEID)
* toPlaceholder - a placeholder ID if you want to use content as a placeholder instead of outputting directly (default: '')
* toPlaceholderPrefix - if you want to prefix the placeholder values. E.g. 'twitterx' would create placeholders like [[*twitterx.text]] (default: '')
* slug - for when loading a twitter list, you must specify a screen_name and a slug (default: '')

Loading timelines
-----------------

As the 1.1 API is more restrictive the tweets available have changed. The snippet defaults to user_time line but you can load any of these:

* public_timeline
* public_timeline
* friends_timeline
* user_timeline
* mentions
* retweets_of_me
* favourites

Loading lists ** New as of 1.3 **
---------------------------------

You can now load lists by using the following:

    &timeline=`lists/statuses`
    &slug=`NAME_OF_YOUR_SLUG`
    &screen_name=`SCREEN_NAME_OF_LIST_OWNER`

An example of this would be the MODX List: https://twitter.com/modx/the-modx-team

    &timeline=`lists/statuses`
    &slug=`the-modx-team`
    &screen_name=`modx`

Searching Twitter
-----------------

TwitterX now supports basic Twitter searches using the &search parameter:

&search=`MODX`

Snippet TwitterXFormat
----------------------

Use this snippet in your chunk placeholders to format the status text and automatically link any search, usernames or topics:

[[+text:TwitterXFormat]]

Chunk options
-------------

The package comes with a chunk for displaying the statuses called 'TwitterXTpl'. You can customise this by using the following placeholders:

* created_at - date status was created
* source - source of the Tweet (application like web, iOS etc)
* id - status id on timeline
* id_str - status id on Twitter (twitter.com/user/statuses/id_str)
* text - status main text
* name - Twitter name
* screen_name - Twitter username
* profile_image_url - Twitter avatar image url for this user (uses https as of version 1.3.3)
* location - This users location
* url - This users URL (if specified)
* description - This users profile information

Retweets (where applicable)
--------------------------

* retweet_created_at - date status was created
* retweet_source - source of the Tweet (application like web, iOS etc)
* retweet_id - status id on timeline
* retweet_id_str - status id on Twitter (twitter.com/user/statuses/id_str)
* retweet_text - status main text
* retweet_name - Twitter name
* retweet_screen_name - Twitter username
* retweet_profile_image_url - Twitter avatar image url for this user (uses https as of version 1.3.3)
* retweet_location - This users location
* retweet_url - This users URL (if specified)
* retweet_description - This users profile information

Further info
------------

For information and support, check out my blog:

https://www.qodo.co.uk/twitterx/

Created by Stewart Orr @ Qodo Ltd (https://www.qodo.co.uk).
Contributers: @sepiariver (http://www.sepiariver.ca), @OostDesign (http://www.oostdesign.com/), @scottborys (http://scottborys.com/), Dameon87 (https://github.com/Dameon87)