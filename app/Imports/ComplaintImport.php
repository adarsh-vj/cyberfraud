<?php

namespace App\Imports;

use App\Models\Complaint;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ComplaintImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

       // dd($collection[1]);
        // Define how to create a model from the Excel row data
        $collection->transform(function ($row) {
            return [
                'Acknowledgement No'       => $row[1],
            ];
        });
        foreach ($collection as $row) {

            Complaint::create([
                'acknowledgement_no' => @$row['Acknowledgement No'],
            ]);

        }
    }
}
