<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::all();

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/CreateEdit');
    }
}
