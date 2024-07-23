<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    protected $mapping;

    public function __construct($mapping)
    {
        $this->mapping = $mapping;
    }

    public function model(array $row)
    {
        return new User([
            'fullname' => $row[$this->mapping['0']] ?? null,
            'phone_number' => $row[$this->mapping['1']] ?? null,
            'email' => $row[$this->mapping['2']] ?? null,

        ]);
    }
}
