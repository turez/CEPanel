<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OrdersController extends Controller
{
    /**
     * Display the list of orders in progress
     */
    public function inProgressIndex(): View
    {
        return view('orders', [

        ]);
    }

}
