<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Exception;
use Inertia\Inertia;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::where('active', true)->get();

        return Inertia::render('Shops/Index', [
            'shops' => $shops,
        ]);
    }

    public function create()
    {
        return Inertia::render('Shops/CreateEdit');
    }

    public function edit(Shop $shop)
    {
        return Inertia::render('Shops/CreateEdit', [
            'shop' => ShopResource::make($shop),
        ]);
    }

    public function store(ShopRequest $request)
    {
        try {
            $data = $request->getShopData();

            Shop::create($data);

            return redirect()->route('shops.index')->with('success', 'Loja cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('shops.index')->with('error', 'Ocorreu um erro ao cadastrar a loja: ' . $ex->getMessage());
        }
    }

    public function update(ShopRequest $request, Shop $shop)
    {
        try {
            $data = $request->getShopData();

            $shop->update($data);

            return redirect()->route('shops.index')->with('success', 'Loja atualizada com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('shops.index')->with('error', 'Ocorreu um erro ao autalizar os dados da loja: ' . $ex->getMessage());
        }
    }

    public function destroy($shopId)
    {
        try {
            Shop::find($shopId)->delete();

            return redirect()->route('shops.index')->with('success', 'Loja excluída com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('shops.index')->with('error', 'Ocorreu um erro ao excluir a loja: ' . $ex->getMessage());
        }
    }
}
