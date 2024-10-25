<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Shop;
use Exception;

class ShopController extends Controller
{
    public function store(ShopRequest $request)
    {
        try {
            $data = $request->getShopData();

            Shop::create($data);

            return redirect()->route('companies.index')->with('success', 'Loja cadastrada com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao cadastrar a loja: ' . $ex->getMessage());
        }
    }

    public function update(ShopRequest $request, Shop $shop)
    {
        try {
            $data = $request->getShopData();

            $shop->update($data);

            return redirect()->route('companies.index')->with('success', 'Loja atualizada com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao autalizar os dados da loja: ' . $ex->getMessage());
        }
    }

    public function destroy($shopId)
    {
        try {
            Shop::find($shopId)->update(['active' => false]);

            return redirect()->route('companies.index')->with('success', 'Loja excluída com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('companies.index')->with('error', 'Ocorreu um erro ao excluir a loja: ' . $ex->getMessage());
        }
    }
}
