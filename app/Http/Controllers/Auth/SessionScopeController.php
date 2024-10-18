<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class SessionScopeController extends Controller
{
    public function setSessionScope(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'company_id' => 'required|integer|exists:companies,id',
                'shop_id' => 'required|integer|exists:shops,id',
            ]);

            $request->session()->put('selected_company_id', $validatedData['company_id']);
            $request->session()->put('selected_shop_id', $validatedData['shop_id']);
    
            return response()->json([
                'selected_company_id' => session()->get('selected_company_id'),
                'selected_shop_id' => session()->get('selected_shop_id'),
            ]);
        } catch (Exception $ex) {
            throw new InternalErrorException('Error when setting session scope: ' . $ex->getMessage());
        }
    }
}
