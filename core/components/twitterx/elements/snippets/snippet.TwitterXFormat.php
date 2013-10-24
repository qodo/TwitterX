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
 * @version 1.3.2
 * @copyright Copyright 2012 by Qodo Ltd
 */

$output = preg_replace('/(https?:\/\/[^\s"<>]+)/','<a href="$1">$1</a>', $input);
$output = preg_replace('/(^|[\n\s])#([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/search?q=%23$2">#$2</a>', $output);
$output = preg_replace('/(^|[\n\s])@([^\s"\t\n\r<:]*)/is', '$1<a href="http://twitter.com/$2">@$2</a>', $output);
return $output;