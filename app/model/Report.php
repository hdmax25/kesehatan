<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Report
 * @package App\model
 *
 * @property integer id
 * @property integer id_user
 * @property integer id_department
 * @property integer id_penyakit
 * @property string position
 * @property string domicile
 * @property string deatail
 */
class Report extends Model
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
    'id_penyakit',
    'position',
    'domicile',
    'deatail',
  ];
}
