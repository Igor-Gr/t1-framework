<?php

namespace Commands;

use Console\Command;

class Application
    extends Command
{

    public function actionDefault()
    {
        $this->writeLn('Hello. Use it:');
        $this->writeLn('command/action for installed commands');
        $this->writeLn('Help: application/help');
    }

    public function actionHelp()
    {
        $this->writeLn('commands list:');
        $this->writeLn('migrate/create - create a new migration');
        $this->writeLn('create/test');
    }
}