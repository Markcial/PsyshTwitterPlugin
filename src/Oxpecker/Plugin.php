<?php

namespace Oxpecker;

use Psy\Plugin\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public static function getPresenters()
    {
        return array(
            new Presenter()
        );
    }

    public static function getCommands()
    {
        return array(
            new Command()
        );
    }
}
