<?php

require_once realpath(__DIR__ . '/../vendor/autoload.php');

$pd = new Ketwaroo\Parsedown();


var_dump($pd->parse('[test link](#anchorlink){#foo .bar .fubar target="_blank" data-cow-goes="moo"}'));
var_dump($pd->parse('## test {#foo .bar .fubar target="_blank" stuff=" d \'d\' " data-cow-goes="moo"}'));
var_dump($pd->parse('![Alt text](/path/to/img.jpg "Optional title"){#foo .bar .fubar target="_blank" data-cow-goes="moo"}'));
