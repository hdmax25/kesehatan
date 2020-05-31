<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Penyakit
 * @package App\model
 *
 * @property integer id
 * @property string pneyakit_name
 */
class Penyakit extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id',
    'penyakit_name',
  ];
}
