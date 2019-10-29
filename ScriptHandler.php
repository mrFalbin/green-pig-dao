<?php

namespace GreenPigDAO\Composer;

use Composer\Script\Event;

class ScriptHandler
{

    public static function myScript($event)
    {
        $event->getIO()->write('foo 111111111111 !!!!!!!! ');
    }

}