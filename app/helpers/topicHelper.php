<?php declare(strict_types = 1);

function getLinkToTopic(stdClass $topic) : string
{
   return URL_ROOT . '/topics/topic/' . $topic->id;
}