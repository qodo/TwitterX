<?php
/**
 * TwitterXFormat
 *
 * This snippet simply formats and links twitter feed statuses.
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
 * @version 1.3,1
 * @copyright Copyright 2012 by Qodo Ltd
 */

$search = array('|(http://[^ ]+)|', '|@([\w_]+)|', '|#([A-Za-z0-9-_]+)|');
$replace = array('<a href="$1" target="_blank" rel="nofollow">$1</a>', '<a href="http://twitter.com/$1" target="_blank" rel="nofollow">@$1</a>', '<a href="http://twitter.com/search?q=%23$1" target="_blank" rel="nofollow">#$1</a>');
$output = preg_replace($search, $replace, $input);
return $output;