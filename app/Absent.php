<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Penyakit
 * @package App\model
 *
 * @property integer id
 * @property integer id_user
 */
class Absent extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'id_user',
  ];
}
