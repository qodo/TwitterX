<?php
/**
 * @package twitterx
 * @subpackage build
 */

$chunks = array();

$chunks[0]= $modx->newObject('modChunk');
$chunks[0]->fromArray(array(
    'id' => 0,
    'name' => 'TwitterXTpl',
    'description' => 'TwitterX tweet chunk - duplicate this and edit as upgrading TwitterX will overwrite your changes',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/TwitterXTpl.html'),
    'properties' => '',
),'',true,true);

return $chunks;