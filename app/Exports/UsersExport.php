<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
    }

    public function collection()
    {
        $columns = array_map(function ($column) {
            return 'users.' . $column;
        }, $this->columns);

        $columns[] = 'roles.name as role_name';

        return User::select($columns)
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'Cargo',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->role_name,
        ];
    }
}
