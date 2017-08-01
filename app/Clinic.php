<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clinic extends ChrisModel
{
    //
    public $hidden = ["created_at","created_by","updated_at","modified_by"];
}
