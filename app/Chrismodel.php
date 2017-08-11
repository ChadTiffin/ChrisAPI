<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class Chrismodel extends Model
{
    //
    protected $hidden = ["created_at","created_by","updated_at","modified_by","deleted_at"];

}
