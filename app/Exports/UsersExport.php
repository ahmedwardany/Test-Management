<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    protected $users;
    protected $columns;

    public function __construct($users, $columns)
    {
        $this->users = $users;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->users;
    }

    public function map($user): array
    {
        $mappedData = [];
        foreach ($this->columns as $column) {
            $mappedData[] = $user->$column;
        }
        return $mappedData;
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
