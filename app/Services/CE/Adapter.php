<?php

namespace App\Services\CE;

use Illuminate\Pagination\LengthAwarePaginator;

class Adapter
{
    public function __construct(
        private Client $cEClient,
    ) { 
    }

    public function getOrdersByStatus(string $statuses, int $page): LengthAwarePaginator {

        $response = $this->cEClient->makeRequest(
            'get',
            'v2/orders',
            ['statuses' => $statuses, 'page' => $page],
        );

        $ordersResponse = new OrdersResponse($response, $page);

        return $ordersResponse->getOrders();
    }

    public function updateStock(string $ProductNo, int $stock)
    {

    }
}