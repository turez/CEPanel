<?php

namespace App\Http\Controllers;

use App\Services\CEService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdersController extends Controller
{
    /**
     * Display the list of orders in progress
     */
    public function inProgressIndex(Request $request, CEService $cEService): View
    {
        $page = $request->get('page', 1);

        $orderPaginator = $cEService->getOrdersInProgress($page);
        $orderPaginator->setPath($request->getPathInfo());

        return view('orders', [
            'orders' => $orderPaginator
        ]);
    }

    /**
     * Display the top five products of orders in progress
     */
    public function topProductsIndex(CEService $cEService): View
    {
        $topProducts = $cEService->getTopFiveProductsInProgressStatus();

        return view('top_five', [
            'topProducts' => $topProducts,
        ]);
    }

}
