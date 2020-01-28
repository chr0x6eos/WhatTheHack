<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deployment extends Model
{
    //TODO:VDI - Implement start of instance
    public function start()
    {
        //NAME = VM-Name
        $name = $this->name;
        return shell_exec('whoami');
    }

    //TODO:VDI - Implement stop of instance
    public function stop()
    {
        //NAME = VM-Name
        $name = $this->name;
        return shell_exec('path');
    }
}
