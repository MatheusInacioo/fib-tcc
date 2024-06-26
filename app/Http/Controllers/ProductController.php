<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Supplier;
use Exception;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Products/Index', [
            'products' => ProductResource::collection(Product::all())->toArray(request()),
        ]);
    }

    public function create()
    {
        $suppliers = Supplier::select('id', 'name')->get();

        return Inertia::render('Products/CreateEdit', [
            'suppliers' => $suppliers,
        ]);
    }

    public function edit(Product $product)
    {
        $suppliers = Supplier::select('id', 'name')->get();

        return Inertia::render('Products/CreateEdit', [
            'product' => ProductResource::make($product),
            'suppliers' => $suppliers,
        ]);
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->getProductData();

            Product::create($data);

            return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('products.index')->with('error', 'Ocorreu um erro ao cadastrar o produto: ' . $ex->getMessage());
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $data = $request->getProductData();

            $product->update($data);

            return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('products.index')->with('error', 'Ocorreu um erro ao autalizar os dados do produto: ' . $ex->getMessage());
        }
    }

    public function destroy($productId)
    {
        try {
            Product::find($productId)->delete();

            return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso.');
        } catch(Exception $ex) {
            return redirect()->route('products.index')->with('error', 'Ocorreu um erro ao excluir o produto: ' . $ex->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new ProductsExport, 'produtos.xlsx');
    }

    public function replace($productId)
    {
        $product = Product::find($productId);
        $replacementData = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'supplier_id' => $product->supplier_id,
            'supplier_name' => $product->getSupplierName(),
            'price' => $product->purchase_price,
        ];

        return Inertia::render('Transactions/CreateEdit', [
            'replacement' => $replacementData,
        ]);
    }
}
