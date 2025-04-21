<?php

namespace App\Imports;

use App\Models\phonenumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
class PhoneImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


 

    protected $staffId;
    public $duplicateCount = 0;
    public $successCount = 0;

    
    public function __construct($staffId)
    {
        $this->staffId = $staffId;
    }

    public function collection(Collection $rows)
    {
        $data = $rows->skip(1); // skip header
        $companyId = auth()->user()->company_id;

        foreach ($data as $row) {
            $number = trim($row[0]); // optional clean-up

            $exists = phonenumber::where('number', $number)
                                 ->where('company_id', $companyId)
                                 ->exists();

            if ($exists) {
                $this->duplicateCount++;
                continue;
            }

            phonenumber::create([
                'number'      => $number,
                'name'        => $row[1],
                'company_id'  => $companyId,
                'staff_id'  =>  $this->staffId,
            ]);

            $this->successCount++;
        }
    }

}
