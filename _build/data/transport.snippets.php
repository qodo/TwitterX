<?php
/**
 * @package twitterx
 * @subpackage build
 */

function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$snippets = array();
$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'TwitterX',
    'description' => 'This package loads Twitter feeds using the Twitter 1.1 API. Created by Stewart Orr @ Qodo Ltd https://www.qodo.co.uk/twitterx/',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.TwitterX.php'),
    ),'',true,true
);

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'TwitterXFormat',
    'description' => 'This snippet simply formats and links Twitter feed statuses.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.TwitterXFormat.php'),
    ),'',true,true
);

return $snippets;