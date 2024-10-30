<?php

namespace App\Http\Controllers;

use App\Services\CEService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Update the product stock to the default value
     */
    public function updateToDefaultStock(): View
    {
        return view('update_stock');
    }

    public function storeDefaultStock(Request $request, CEService $cEService)
    {
        $validatedData = $request->validate([
            'productNo' => ['required', 'string', 'max:255'],
        ]);

        $success = $cEService->updateToDefaultStock($validatedData['productNo']);

        $message = $success ? 'Product stock successfully updated.' : 'Failed to update stock.';


        return Redirect::route('product.update_stock')->with('message', $message);
    }
}
