<?php

namespace App\Imports;

use App\Models\phonenumber;
use App\Models\user;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PhoneAutoImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   
    protected $duplicateCount = 0;
    protected $successCount = 0;

    public function collection(Collection $rows)
    {
        $data = $rows->skip(1); // Skip header
        $companyId = auth()->user()->company_id;

        // Get all active staff for this company
        $activeStaff = user::where('company_id', $companyId)
                            ->where('active_status', '1') // Or however you mark them
                            ->pluck('id')
                            ->toArray();

        //  dd($activeStaff);                   

        if (empty($activeStaff)) {
            return;
        }



        $staffCount = count($activeStaff);
        
            // dd($staffCount);
        $staffIndex = 0;
       
        foreach ($data as $row) {
            $number = trim($row[0]);
            $name = trim($row[1]);
        
            // DEBUG: Show current row data
         
        
            $exists = phonenumber::where('number', $number)
                                 ->where('company_id', $companyId)
                                 ->exists();
        
            if ($exists) {
                $this->duplicateCount++;
                \Log::info("Duplicate Found: $number");
                continue;
            }
        
            $assignedStaff = $activeStaff[$staffIndex % $staffCount];
            $staffIndex++;
        
            try {
                phonenumber::create([
                    'number'      => $number,
                    'name'        => $name,
                    'company_id'  => $companyId,
                    'staff_id'    => $assignedStaff,
                ]);
                \Log::info("Saved: $number to Staff ID $assignedStaff");
                $this->successCount++;
            } catch (\Exception $e) {
              
            }
        }
    }

    public function getResults()
    {
        return [
            'success'   => $this->successCount,
            'duplicate' => $this->duplicateCount,
        ];
    }   



}
