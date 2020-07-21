<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Penyakit
 * @package App\model
 *
 * @property integer id
 * @property integer id_user
 * @property integer type
 * @property string destination
 * @property string detail
 */

class Leave extends Model
{ 
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
     'id',
     'id_user',
     'id_department',
     'type',
     'start',
     'end',
     'destination',
     'detail',
     'approve',
   ];
}
