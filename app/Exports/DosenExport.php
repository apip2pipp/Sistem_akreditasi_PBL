<?php

namespace App\Exports;

use App\Models\mDosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class DosenExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // You can use Eloquent to get the data or a query builder
        return mDosen::select('dosen_nip', 'dosen_nama', 'dosen_nidn', 'dosen_email', 'dosen_gender')
            ->get();
    }

    /**
     * Return the column headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'NIDN',
            'Email',
            'Gender'
        ];
    }

    /**
     * Return the title for the Excel sheet.
     *
     * @return string
     */
    public function title(): string
    {
        return 'Data Dosen';
    }
}
