<?php

namespace App\Imports;

use App\Models\Employee as ModelsEmployee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportEmployee implements ToCollection
{
    public function collection(Collection $rows)
    {
        // dd($rows);
        $count = 0;
        foreach ($rows as $row) {
            if ($count > 0) {
                if (ModelsEmployee::where('nik', '=', $row[6])->doesntExist()) {
                    ModelsEmployee::create([
                        'id_branch' => (int) $row[1],
                        'id_title' => (int) $row[2],
                        'firstname' => strtolower($row[3]),
                        'lastname' => strtolower($row[4]),
                        'gender' => strtolower($row[5]),
                        'nik' => $row[6],
                        'address' => (!$row[7]),
                        'address_two' => (!$row[8]),
                        'email' => $row[9],
                        'mobile' => $row[10],
                        'phone' => $row[11],
                        'phone_two' => $row[12],
                        'hired_at' => $this->formatDate($row[13]),
                        'terminated_at' => $this->formatDate($row[14]),
                    ]);
                }
            }
            $count++;
        }
    }

    private function formatDate($date)
    {

        return date('Y-m-d', strtotime($date));
    }
}
