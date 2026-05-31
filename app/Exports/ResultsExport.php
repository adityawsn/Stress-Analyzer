<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ResultsExport implements FromArray, WithHeadings
{
    protected array $rows;
    protected array $columns;

    public function __construct(array $rows, array $columns)
    {
        $this->columns = $columns;
        // normalize rows to simple arrays in the order of columns
        $this->rows = array_map(function ($r) {
            return array_map(function ($col) use ($r) {
                return $r[$col] ?? '';
            }, $this->columns);
        }, $rows);
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
