<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class tblAttendanceLog extends Model
{
    public $timestamps = false;
    protected $table = 'tblattendancelog';
    protected $connection = 'mysql2';
}
