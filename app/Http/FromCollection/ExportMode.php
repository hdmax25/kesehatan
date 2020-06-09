<?php

namespace App\Http\FromCollection;

use Maatwebsite\Excel\Concerns\FromCollection;
use phpDocumentor\Reflection\Types\Collection;

class ExportMode implements FromCollection
{
  protected $dataSet;

  /**
   * ExportMode constructor.
   * @param $data
   */
  public function __construct(array $data)
  {
    $this->dataSet = $data;
  }

  /**
   * @return \Illuminate\Support\Collection|Collection
   */
  public function collection()
  {
    return collect($this->dataSet);
  }
}