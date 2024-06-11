<?php

namespace App\Exports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $columns;

    public function __construct()
    {
        $this->columns = array_diff(
            Schema::getColumnListing((new User)->getTable()),
            [
                'email_verified_at',
                'password',
                'remember_token',
                'created_at',
                'updated_at',
            ]
        );

        $userRole = Role::where('id', $this->columns[1])->pluck('name');
        $this->columns['role'] = $userRole;
    }

    public function collection()
    {
        return User::select($this->columns)->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cargo',
            'Nome',
            'Email',
        ];
    }
}
