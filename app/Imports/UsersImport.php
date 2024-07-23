<?php

namespace App\Imports;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;


class UsersImport implements ToCollection
{
    protected $mapping;

    public function __construct(array $mapping)
    {
        $this->mapping = $mapping;
    }

    public function collection(Collection $rows)
    {
        $nameKey = array_search(User::NAME_COLUMN, $this->mapping)  ;
        $phoneKey = array_search(User::PHONE_COLUMN, $this->mapping);
        $emailKey = array_search(User::EMAIL_COLUMN, $this->mapping);
        foreach ($rows as $row) {
            $row = $row->toArray();
            $data = [
                'fullname' => isset($row[$nameKey]) ? $row[$nameKey] : null,
                'phone_number' => isset($row[$phoneKey]) ? (string)$row[$phoneKey] : null,
                'email' => isset($row[$emailKey]) ? $row[$emailKey] : null,
            ];


            $validator = Validator::make($data, [
                'fullname' => 'required|string|max:255',
                'phone_number' => 'required|integer',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                continue;
            }

            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
