<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Departement
 * @package App\model
 *
 * @property integer id
 * @property string department_name
 */
class Departement extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'department_name',
  ];
}
